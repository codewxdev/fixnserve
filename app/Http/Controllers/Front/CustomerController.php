<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\User;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {

            $user = $this->customerService->registerCustomer($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Customer created successfully with Wallet!',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    // CustomerController.php

    public function update(Request $request, $id)
    {
        // Use slightly different validation (ignore current email unique rule)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Ignore current user ID
            // ... other rules
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['message' => 'Customer updated successfully']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Or $user->status = 'banned' if you don't want hard delete

        return response()->json(['message' => 'Customer deleted successfully']);
    }

    public function index()
    {
        $users = User::doesntHave('roles')->with('wallet')->get();
         
        return view('Admin.customers.index', compact('users'));
    }

    public function order_history()
    {
        return view('Admin.customers.order_history');
    }
}
