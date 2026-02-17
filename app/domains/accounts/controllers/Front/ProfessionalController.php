<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Domains\Accounts\Requests\StoreProfessionalRequest;
use App\Http\Controllers\Controller;
use App\Domains\Security\Models\User;
use App\Services\ProfessionalService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfessionalController extends Controller
{
    protected $professionalService;

    public function __construct(ProfessionalService $professionalService)
    {
        $this->professionalService = $professionalService;
    }

    public function store(StoreProfessionalRequest $request): JsonResponse {
           
        try {
             $professional = $this->professionalService->registerProfessional($request->validated());

             return response()->json([
                'status' => 'success',
                'message' => 'professional created successfully with Wallet!',
                'professional' => $professional
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(){

        $professionals = User::get();
        return view('Admin.professionals.index',compact('professionals'));
    }
}
