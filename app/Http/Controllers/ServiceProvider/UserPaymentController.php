<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserPaymentController extends Controller
{
    /**
     * Get user's payment methods
     */
    public function index()
    {
        $payments = Auth::user()->payments()
            ->active()
            ->latest()
            ->get();

        return ApiResponse::success($payments, 'Payment methods retrieved successfully');
    }

    /**
     * Add a new payment method
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:card,jazzcash,easypaisa,bank_transfer',
            'payment_title' => 'nullable|string|max:100',
            'is_default' => 'boolean',

            // Card validation
            'card_holder_name' => 'required_if:payment_method,card|string|max:255',
            'card_number' => 'required_if:payment_method,card|string|min:13|max:19',
            'expiry_month' => 'required_if:payment_method,card|string|size:2',
            'expiry_year' => 'required_if:payment_method,card|string|size:4',
            'cvv' => 'required_if:payment_method,card|string|min:3|max:4',
            'card_brand' => 'nullable|string|max:50',
            'address_line' => 'required_if:payment_method,card|string|max:255',
            'postal_code' => 'required_if:payment_method,card|string|max:20',
            'city' => 'required_if:payment_method,card|string|max:100',
            'currency' => 'required_if:payment_method,card|string|size:3|in:USD,PKR,EUR,GBP,SAR,AED',

            // JazzCash validation
            'jazzcash_account_number' => 'required_if:payment_method,jazzcash|string|max:15',
            'jazzcash_account_title' => 'required_if:payment_method,jazzcash|string|max:255',
            'jazzcash_cnic' => 'nullable|string|max:15',
            'jazzcash_email' => 'nullable|email|max:255',

            // EasyPaisa validation
            'easypaisa_account_number' => 'required_if:payment_method,easypaisa|string|max:15',
            'easypaisa_account_title' => 'required_if:payment_method,easypaisa|string|max:255',
            'easypaisa_cnic' => 'nullable|string|max:15',
            'easypaisa_email' => 'nullable|email|max:255',

            // Bank Transfer validation
            'bank_name' => 'required_if:payment_method,bank_transfer|string|max:255',
            'account_title' => 'required_if:payment_method,bank_transfer|string|max:255',
            'account_number' => 'required_if:payment_method,bank_transfer|string|max:50',
            'iban' => 'nullable|string|max:34',
            'branch_code' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422, 'Validation failed.');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->payment_method === 'card' && $request->has('cvv')) {
            $data['cvv_hash'] = $request->cvv;
        }

        $payment = UserPayment::create($data);

        if ($request->is_default) {
            $payment->markAsDefault();
        }

        return ApiResponse::success($payment, 'Payment method added successfully', 201);
    }

    /**
     * Set a payment method as default
     */
    public function setDefault($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);
        $payment->markAsDefault();

        return ApiResponse::success(null, 'Payment method set as default');
    }

    /**
     * Delete a payment method
     */
    public function destroy($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);

        $totalPayments = Auth::user()->payments()->active()->count();
        if ($totalPayments <= 1) {
            return ApiResponse::error('Cannot delete the only payment method.', 400);
        }

        $payment->delete();

        return ApiResponse::success(null, 'Payment method deleted successfully');
    }

    /**
     * Get payment methods by type
     */
    public function byType($type)
    {
        $validTypes = ['card', 'jazzcash', 'easypaisa', 'bank_transfer'];

        if (! in_array($type, $validTypes)) {
            return ApiResponse::error('Invalid payment type.', 400);
        }

        $payments = Auth::user()->payments()
            ->active()
            ->byMethod($type)
            ->get();

        return ApiResponse::success($payments, ucfirst($type).' payment methods retrieved');
    }
}
