<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProviderRequest;
use App\Models\User;
use App\Services\ServiceProvider;
use Illuminate\Http\Request;
use Spatie\Permission\Commands\AssignRole;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProviderController extends Controller
{

    protected $providerService;

    public function __construct(ServiceProvider $providerService)
    {
        $this->providerService = $providerService;
    }

    public function store(StoreProviderRequest $request): JsonResponse
    {

        try {
            $provider = $this->providerService->registerProvider($request->validated());

            return response()->json([
                'message' => 'Provider created successfully!',
                'provider' => $provider
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(){

        $providers = User::role('Provider')->get();
        return view('Admin.providers.index',compact('providers'));

    }
}
