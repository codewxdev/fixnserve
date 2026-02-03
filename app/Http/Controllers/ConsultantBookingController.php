<?php

namespace App\Http\Controllers;

use App\Models\ConsultancyProfile;
use App\Models\ConsultantBooking;
use App\Models\ConsultantDayAvailability;
use App\Services\ConsultantBookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultantBookingController extends Controller
{
    public function getSlots(Request $request)
    {
        $slots = ConsultantBookingService::getAvailableSlots(
            $request->consultant_day_availability_id,
            $request->date,
            $request->duration
        );

        return response()->json([
            'success' => true,
            'slots' => $slots,
        ]);
    }

    public function bookSlot(Request $request)
    {
        $request->validate([
            'consultant_day_availability_id' => 'required|exists:consultant_day_availabilities,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|in:15,30,45,60',
        ]);

        return DB::transaction(function () use ($request) {

            $availability = ConsultantDayAvailability::with('consultantWeekDay')
                ->lockForUpdate()
                ->findOrFail($request->consultant_day_availability_id);

            $consultantId = $availability->consultantWeekDay->user_id;

            $profile = ConsultancyProfile::where('user_id', $consultantId)->firstOrFail();

            // Fee calculation
            $fee = match ($request->duration) {
                15 => $profile->fee_15,
                30 => $profile->fee_30,
                45 => $profile->fee_45,
                60 => $profile->fee_60,
            };

            if (! $fee) {
                abort(422, 'Selected duration not available');
            }

            $start = Carbon::createFromFormat('H:i', $request->start_time);
            $end = $start->copy()->addMinutes($request->duration);

            // ❌ Check overlapping bookings
            $overlap = ConsultantBooking::where(
                'consultant_day_availability_id',
                $availability->id
            )
                ->where('booking_date', $request->booking_date)
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_time', [$start, $end])
                        ->orWhereBetween('end_time', [$start, $end])
                        ->orWhere(function ($q2) use ($start, $end) {
                            $q2->where('start_time', '<=', $start)
                                ->where('end_time', '>=', $end);
                        });
                })
                ->exists();

            if ($overlap) {
                abort(409, 'This slot is already booked');
            }

            // ✅ Create booking
            $booking = ConsultantBooking::create([
                'user_id' => auth()->id(),
                'consultant_day_availability_id' => $availability->id,
                'booking_date' => $request->booking_date,
                'start_time' => $start->format('H:i'),
                'end_time' => $end->format('H:i'),
                'duration' => $request->duration,
                'fee' => $fee,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slot booked successfully',
                'booking' => $booking,
            ]);
        });
    }
}
