<?php

namespace App\Http\Controllers\Consultancy;

use App\Http\Controllers\Controller;
use App\Models\ConsultantWeekDay;
use Illuminate\Http\Request;

class ConsultantWeekDayController extends Controller
{
    public function index()
    {
        $weekDays = ConsultantWeekDay::with('availabilities')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'week_days' => $weekDays,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'days' => 'required|array',
            'days.*.day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'days.*.availabilities' => 'required|array|min:1',
            'days.*.availabilities.*.start_time' => 'required|date_format:H:i',
            'days.*.availabilities.*.end_time' => 'required|date_format:H:i|after:days.*.availabilities.*.start_time',
        ]);

        $created = [];

        foreach ($request->days as $dayData) {
            $day = ConsultantWeekDay::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'day' => $dayData['day'],
                ],
                [
                    'is_enabled' => true,
                ]
            );

            if (! $day->is_enabled) {
                continue;
            }

            foreach ($dayData['availabilities'] as $slot) {
                $overlap = $day->availabilities()
                    ->where(function ($q) use ($slot) {
                        $q->whereBetween('start_time', [$slot['start_time'], $slot['end_time']])
                            ->orWhereBetween('end_time', [$slot['start_time'], $slot['end_time']]);
                    })
                    ->exists();

                if ($overlap) {
                    continue;
                }

                $day->availabilities()->create([
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                ]);
            }

            $created[] = $dayData['day'];
        }

        return response()->json([
            'message' => 'Availabilities stored successfully',
            'days' => $created,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'days' => 'nullable|array',
            'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',

            'day' => 'nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',

            'availabilities' => 'required|array|min:1',
            'availabilities.*.id' => 'nullable|exists:consultant_day_availabilities,id',
            'availabilities.*.start_time' => 'required|date_format:H:i',
            'availabilities.*.end_time' => 'required|date_format:H:i|after:availabilities.*.start_time',
        ]);

        $days = $request->days ?? [$request->day];

        if (! $days) {
            return response()->json([
                'message' => 'Day or days are required',
            ], 422);
        }

        $updated = [];

        foreach ($days as $dayName) {
            // Fetch or create the day
            $day = ConsultantWeekDay::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'day' => $dayName,
                ],
                [
                    'is_enabled' => true,
                ]
            );

            if (! $day->is_enabled) {
                continue;
            }

            foreach ($request->availabilities as $slot) {
                if (isset($slot['id'])) {
                    // Update existing availability
                    $availability = $day->availabilities()->find($slot['id']);
                    if ($availability) {
                        $availability->update([
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                        ]);
                    }
                } else {
                    // Check for overlapping new slots
                    $overlap = $day->availabilities()
                        ->where(function ($q) use ($slot) {
                            $q->whereBetween('start_time', [$slot['start_time'], $slot['end_time']])
                                ->orWhereBetween('end_time', [$slot['start_time'], $slot['end_time']]);
                        })
                        ->exists();

                    if ($overlap) {
                        continue;
                    }

                    // Create new availability
                    $day->availabilities()->create([
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                    ]);
                }
            }

            $updated[] = $dayName;
        }

        return response()->json([
            'message' => 'Availability updated successfully',
            'days' => $updated,
        ]);
    }

    public function destroy($id)
    {
        ConsultantWeekDay::where('id', $id)->delete();

        return response()->json(['message' => 'Day availability removed']);
    }
}
