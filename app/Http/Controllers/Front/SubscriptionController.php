<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Models\App;
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
        // Hum saary apps load kar rahe hain taaky tabs dynamic ban sakein
        // Aur plans bhi load kar rahe hain with entitlements taaky list show ho sake
        $apps = App::with(['plans.entitlements'])->get();
        
        return view('Admin.subscription.index', compact('apps'));
    }
     

   public function store(Request $request)
    {
        // Validation matches your DB schema
        $validated = $request->validate([
            'app_id'            => 'required|exists:apps,id',
            'name'              => 'required|string|max:255',
            'tier'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'billing_cycle'     => 'required|in:monthly,yearly',
            'features'          => 'nullable|array',
            'features.*.key'    => 'required_with:features|string',
            'features.*.value'  => 'required_with:features|string',
        ]);

        try {
            $this->subscriptionService->createPlan($validated);
            return redirect()->back()->with('success', 'Plan created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating plan: ' . $e->getMessage());
        }
    }
}
