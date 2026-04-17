<?php

namespace App\Domains\Audit\Middlewares;

use App\Domains\Audit\Services\SecurityAuditService;
use App\Domains\Security\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityAuditLogger
{
    public function __construct(
        protected SecurityAuditService $auditService
    ) {}

    protected array $privilegeRoutes = [
        'api/financial-audit/export' => ['bulk_export',       'financial_data'],
        'api/manual-overrides' => ['financial_override', 'override'],
        'api/session-risk/sessions' => ['data_access',        'session'],
        'api/legal/cases' => ['data_access',        'legal_case'],
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ Log auth events
        $this->logAuthEvents($request, $response);

        // ✅ Log privilege usage (admin only)
        $this->logPrivilegeIfNeeded($request, $response);

        return $response;
    }

    private function logAuthEvents(
        Request $request,
        Response $response
    ): void {

        $path = $request->path();

        // ✅ Login
        if (str_contains($path, 'auth/login') && $request->isMethod('POST')) {
            $success = $response->getStatusCode() === 200;
            $resData = json_decode($response->getContent(), true);
            $userId = $resData['data']['user']['id'] ?? null;

            $this->auditService->log(
                eventType: $success ? 'login_success' : 'login_failed',
                data: ['path' => $path],
                user: $userId ? User::find($userId) : null,
                success: $success,
                failReason: ! $success ? 'Invalid credentials' : null
            );
        }

        // ✅ Logout
        if (str_contains($path, 'auth/logout') && auth()->check()) {
            $this->auditService->log(
                eventType: 'logout',
                data: [],
                user: auth()->user(),
                success: true
            );
        }

        // ✅ 2FA
        if (str_contains($path, '2fa/verify') && $request->isMethod('POST')) {
            $success = $response->getStatusCode() === 200;
            $this->auditService->log(
                eventType: $success ? 'mfa_passed' : 'mfa_failed',
                data: [],
                user: auth()->user(),
                success: $success,
                failReason: ! $success ? 'Invalid OTP' : null
            );
        }

        // ✅ Password change
        if (str_contains($path, 'password') && $request->isMethod('POST')
            && $response->getStatusCode() === 200) {
            $this->auditService->log(
                eventType: 'password_changed',
                data: [],
                user: auth()->user(),
                success: true
            );
        }
    }

    private function logPrivilegeIfNeeded(
        Request $request,
        Response $response
    ): void {

        if ($response->getStatusCode() < 200 ||
            $response->getStatusCode() >= 300) {
            return;
        }

        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        if (! $user->hasAnyRole([
            'Super Admin', 'support_agent', 'finance',
        ])) {
            return;
        }

        foreach ($this->privilegeRoutes as $pattern => $info) {
            if ($request->is($pattern)) {
                $this->auditService->logPrivilege(
                    userId: auth()->id(),
                    userRole: $user->getRoleNames()->first() ?? 'unknown',
                    actionType: $info[0],
                    resourceType: $info[1],
                    description: "{$info[0]} via {$request->method()} {$request->path()}",
                );
                break;
            }
        }
    }
}
