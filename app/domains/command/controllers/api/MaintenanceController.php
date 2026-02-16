<?php

namespace App\Domains\Command\Controllers\Api;

use App\Domains\Command\Models\Maintenance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    public function index()
    {
        $data = Maintenance::get();

        return response()->json(['data' => $data, 'message' => 'data fetch successfuly']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['global', 'module', 'region'])],
            'module' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'reason' => 'required|string',
            'user_message' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $status = now()->gte($data['starts_at'])
            ? 'active'
            : 'scheduled';

        $maintenance = Maintenance::create([
            ...$data,
            'status' => $status,
            'created_by' => auth()->id(),
        ]);

        cache()->forget('maintenance:active');

        return response()->json($maintenance, 201);
    }

    public function updateStatus(Maintenance $maintenance)
    {
        $maintenance->update(['status' => 'cancelled']);
        cache()->forget('maintenance:active');

        return response()->json([
            'message' => 'Maintenance cancelled',
        ]);
    }
}
