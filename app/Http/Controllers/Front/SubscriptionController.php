<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // public function index(){
    //     return view('Admin.subscription.index');
    // }


   protected $service;

    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $plans = $this->service->getAllPlans();
        return view('Admin.subscription.index', compact('plans'));
    }

    public function store(StorePlanRequest $request)
    {
        try {
            $this->service->createPlan($request->validated());
            return back()->with('success', 'Plan created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
