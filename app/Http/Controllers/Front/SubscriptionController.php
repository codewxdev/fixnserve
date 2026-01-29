<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Models\App;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // public function index(){
    //     return view('Admin.subscription.index');
    // }


    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }


    public function index()
    {
         
        $apps = App::with(['plans.entitlements'])->get();

        return view('Admin.subscription.index', compact('apps'));
    }


    public function store(StorePlanRequest $request)
    {
       
        try {
            // Validated data directly service ko pass kar rahe hain
            $this->subscriptionService->createPlan($request->validated());

            return redirect()->back()->with('success', 'Plan created successfully!');
        } catch (\Exception $e) {
            // Error dekhne ke liye log bhi kar sakte ho
            \Log::error('Plan Creation Error: ' . $e->getMessage());
            return redirect()->back()->with('errors', collect(['Error creating plan: ' . $e->getMessage()]));
        }
    }


    public function update(StorePlanRequest $request, $id)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($id);
            $this->subscriptionService->updatePlan($plan, $request->validated());
            return redirect()->back()->with('success', 'Plan updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating plan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($id);
            $this->subscriptionService->deletePlan($plan);
            return redirect()->back()->with('success', 'Plan deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting plan: ' . $e->getMessage());
        }
    }
}
