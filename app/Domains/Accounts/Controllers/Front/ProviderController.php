<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Domains\Accounts\Requests\StoreProviderRequest;
use App\Domains\Accounts\Services\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Domains\Security\Models\User;
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

        $providers = User::get();
        
        return view('Admin.providers.index',compact('providers'));

    }
}
