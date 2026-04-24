<?php

namespace App\Domains\Command\Controllers\Cp\V1;

use App\Domains\Command\Models\Maintenance;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceController extends BaseApiController
{
    public function index()
    {
        $data = Maintenance::paginate(10);

        return $this->success(
            $data,
            'maintenance_data_fetched'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['global', 'module', 'region'])],
            'module' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'reason' => 'required|string',
            'user_message' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $status = now()->gte($validated['starts_at'])
            ? 'active'
            : 'scheduled';

        $maintenance = Maintenance::create([
            ...$validated,
            'status' => $status,
            'created_by' => auth()->id(),
        ]);

        cache()->forget('maintenance:active');

        return $this->success(
            $maintenance,
            'maintenance_created',
            201
        );
    }

    public function updateStatus(Maintenance $maintenance)
    {
        $maintenance->update(['status' => 'cancelled']);

        cache()->forget('maintenance:active');

        return $this->success(
            null,
            'maintenance_cancelled'
        );
    }
}
