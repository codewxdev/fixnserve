<?php

namespace App\Services;

use App\Models\ConsultancyProfile;
use App\Models\ConsultantBooking;
use App\Models\ConsultantDayAvailability;
use Carbon\Carbon;

class ConsultantBookingService
{
    /**
     * Get available slots with fee
     */
    // public static function getAvailableSlots(
    //     int $consultantDayAvailabilityId,
    //     string $date,
    //     int $duration
    // ): array {

    //     $availability = ConsultantDayAvailability::with('consultantWeekDay')
    //         ->findOrFail($consultantDayAvailabilityId);
    //     // dd($availability);
    //     $consultantId = $availability->consultantWeekDay->user_id;

    //     $profile = ConsultancyProfile::where('user_id', $consultantId)->firstOrFail();

    //     if (! $profile) {
    //         abort(422, 'Consultant profile not found. Please contact support.');
    //     }

    //     // Select fee based on duration
    //     $fee = match ($duration) {
    //         15 => $profile->fee_15,
    //         30 => $profile->fee_30,
    //         45 => $profile->fee_45,
    //         60 => $profile->fee_60,
    //         default => throw new \Exception('Invalid duration'),
    //     };

    //     if (! $fee) {
    //         return [];
    //     }

    //     $start = Carbon::createFromTimeString($availability->start_time);
    //     $end = Carbon::createFromTimeString($availability->end_time);

    //     // Already booked slots
    //     $booked = ConsultantBooking::where(
    //         'consultant_day_availability_id',
    //         $consultantDayAvailabilityId
    //     )
    //         ->where('booking_date', $date)
    //         // ->whereIn('status', ['pending', 'confirmed'])
    //         ->get(['start_time', 'end_time']);
    //     // dd($booked);
    //     $slots = [];

    //     while ($start->copy()->addMinutes($duration)->lte($end)) {

    //         $slotStart = $start->format('H:i');
    //         $slotEnd = $start->copy()->addMinutes($duration)->format('H:i');

    //         $overlap = $booked->contains(function ($b) use ($slotStart, $slotEnd) {
    //             return ! (
    //                 $slotEnd <= $b->start_time ||
    //                 $slotStart >= $b->end_time
    //             );
    //         });

    //         if (! $overlap) {
    //             $slots[] = [
    //                 'start_time' => $slotStart,
    //                 'end_time' => $slotEnd,
    //                 'duration' => $duration,
    //                 'fee' => $fee,
    //                 'time_period' => Carbon::createFromFormat('H:i', $slotStart)->format('A'),
    //             ];
    //         }

    //         $start->addMinutes($duration);
    //     }

    //     return $slots;
    // }
    public static function getAvailableSlots(
        int $consultantId,
        string $date,
        int $duration
    ): array {

        $profile = ConsultancyProfile::where('user_id', $consultantId)->firstOrFail();

        $fee = match ($duration) {
            15 => $profile->fee_15,
            30 => $profile->fee_30,
            45 => $profile->fee_45,
            60 => $profile->fee_60,
            default => throw new \Exception('Invalid duration'),
        };

        if (! $fee) {
            return [];
        }

        $weekDay = Carbon::parse($date)->dayOfWeekIso;

        $availabilities = ConsultantDayAvailability::whereHas(
            'consultantWeekDay',
            fn ($q) => $q
                ->where('user_id', $consultantId)
                ->where('day', $weekDay)
        )->get();

        if ($availabilities->isEmpty()) {
            return [];
        }

        $booked = ConsultantBooking::where('user_id', $consultantId)
            ->where('booking_date', $date)
            ->get(['start_time', 'end_time']);

        $slots = [];

        foreach ($availabilities as $availability) {

            $windowStart = Carbon::createFromTimeString($availability->start_time);
            $windowEnd = Carbon::createFromTimeString($availability->end_time);

            $cursor = $windowStart->copy();

            while ($cursor->copy()->addMinutes($duration)->lte($windowEnd)) {

                $slotStart = $cursor->format('H:i');
                $slotEnd = $cursor->copy()->addMinutes($duration)->format('H:i');

                $overlap = $booked->contains(function ($b) use ($slotStart, $slotEnd) {
                    return ! (
                        $slotEnd <= $b->start_time ||
                        $slotStart >= $b->end_time
                    );
                });

                if (! $overlap) {
                    $slots[] = [
                        'start_time' => $slotStart,
                        'end_time' => $slotEnd,
                        'duration' => $duration,
                        'fee' => $fee,
                        'period' => Carbon::createFromFormat('H:i', $slotStart)->format('A'),
                    ];
                }

                $cursor->addMinutes($duration);
            }
        }

        return $slots;
    }
}
