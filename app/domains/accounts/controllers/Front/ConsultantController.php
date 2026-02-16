<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Domains\Accounts\Requests\StoreConsultantRequest;
use App\Domains\Accounts\Services\ConsultantService;
use App\Http\Controllers\Controller;
use App\Models\User;
 
use Illuminate\Http\Request;

class ConsultantController extends Controller
{

    protected $consultantService;

    public function __construct(ConsultantService $consultantService)
    {
        $this->consultantService = $consultantService;
    }

    public function store(StoreConsultantRequest $request)
    {
        try {
            $this->consultantService->registerConsultant($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Consultant onboarded successfully!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

   public function index()
    { 
         
        $consultants = User::get();
        return view('Admin.consultant.index',compact('consultants'));
    }
}
