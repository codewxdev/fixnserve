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
            'consultant_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        return DB::transaction(function () use ($request) {

            $availability = ConsultantDayAvailability::with('consultantWeekDay')
                ->lockForUpdate()
                ->findOrFail($request->consultant_day_availability_id);

            $consultantId = $availability->consultantWeekDay->user_id;

            $profile = ConsultancyProfile::where('user_id', $consultantId)->first();

            if (! $profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Consultant profile not found',
                ], 404);
            }

            // 🔹 Fee calculation
            $fee = match ($request->duration) {
                15 => $profile->fee_15,
                30 => $profile->fee_30,
                45 => $profile->fee_45,
                60 => $profile->fee_60,
            };

            if (! $fee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected duration not available',
                ], 422);
            }

            $start = Carbon::createFromFormat('H:i', $request->start_time);
            $end = $start->copy()->addMinutes($request->duration);

            // 🔒 Overlap check (correct logic)
            $overlap = ConsultantBooking::where(
                'consultant_day_availability_id',
                $availability->id
            )
                ->where('booking_date', $request->booking_date)
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end)
                        ->where('end_time', '>', $start);
                })
                ->exists();

            if ($overlap) {
                return response()->json([
                    'success' => false,
                    'message' => 'This slot is already booked',
                ], 409);
            }

            // ✅ Create booking
            $booking = ConsultantBooking::create([
                'user_id' => auth()->id(),
                'consultant_day_availability_id' => $availability->id,
                'consultant_id' => $request->consultant_id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
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
            ], 201);
        });
    }

    public function getBookSlot() {}
}
