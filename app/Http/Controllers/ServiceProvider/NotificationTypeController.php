<?php

// app/Http/Controllers/NotificationTypeController.php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationTypeController extends Controller
{
    // Get all notification types
    public function index()
    {
        $types = NotificationType::all();

        return response()->json($types);
    }

    // Create a new notification type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:notification_types,name',
        ]);

        $type = NotificationType::create([
            'name' => $request->name,
        ]);

        return response()->json($type, 201);
    }

    // Update notification type
    public function update(Request $request, $id)
    {
        $type = NotificationType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:notification_types,name,'.$id,
        ]);

        $type->update(['name' => $request->name]);

        return response()->json($type);
    }

    // Delete notification type
    public function destroy($id)
    {
        $type = NotificationType::findOrFail($id);
        $type->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function show($id)
    {
        $type = NotificationType::findOrFail($id);

        return response()->json($type);
    }
}
