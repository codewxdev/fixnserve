<?php

namespace App\Domains\Disputes\Middlewares;

use App\Domains\Disputes\Models\LegalCase;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLegalHold
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Check if resource under legal hold
        if (
            in_array($request->method(), ['PUT', 'PATCH', 'DELETE']) &&
            auth()->check()
        ) {
            $relatedId = $request->route('complaint')
                        ?? $request->route('appeal')
                        ?? $request->route('refund');

            if ($relatedId) {
                $id = is_object($relatedId) ? $relatedId->id : $relatedId;

                $underHold = LegalCase::where('related_id', $id)
                    ->where('legal_hold', true)
                    ->exists();

                if ($underHold) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This record is under legal hold - modifications not allowed',
                        'reason' => 'legal_hold_active',
                    ], 403);
                }

                $isSealed = LegalCase::where('related_id', $id)
                    ->where('is_sealed', true)
                    ->exists();

                if ($isSealed) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This record is sealed - no modifications allowed',
                        'reason' => 'case_sealed',
                    ], 403);
                }
            }
        }

        return $next($request);
    }
}
