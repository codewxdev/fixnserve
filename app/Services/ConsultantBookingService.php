<?php

namespace App\Services;

use App\Models\ConsultancyProfile;
use App\Models\ConsultantBooking;
use App\Models\ConsultantDayAvailability;
use Carbon\Carbon;

class ConsultantBookingService
{
    public static function getAvailableSlots(int $consultantId, string $date, int $duration): array
    {

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

        $availabilities = ConsultantDayAvailability::whereHas('consultantWeekDay', function ($q) use ($consultantId, $weekDay) {
            $q->where('user_id', $consultantId)
                ->where('day', $weekDay);
        })->get();

        if ($availabilities->isEmpty()) {
            return [];
        }

        $booked = ConsultantBooking::where('booking_date', $date)
            ->whereIn('consultant_day_availability_id', $availabilities->pluck('id'))
            ->get(['start_time', 'end_time']);

        $slots = [];

        foreach ($availabilities as $availability) {
            $blockStart = Carbon::createFromTimeString($availability->start_time);
            $blockEnd = Carbon::createFromTimeString($availability->end_time);

            $current = $blockStart->copy();

            while ($current->copy()->addMinutes($duration)->lte($blockEnd)) {
                $slotStart = $current->copy();
                $slotEnd = $current->copy()->addMinutes($duration);

                // ✅ Fixed arrow function
                $overlaps = $booked->contains(fn ($b) => $slotStart->lt(Carbon::createFromTimeString($b->end_time)) &&
                    $slotEnd->gt(Carbon::createFromTimeString($b->start_time))
                );

                if (! $overlaps) {
                    $slots[] = [
                        'start_time' => $slotStart->format('H:i'),
                        'end_time' => $slotEnd->format('H:i'),
                        'duration' => $duration,
                        'fee' => $fee,
                        'period' => $slotStart->format('A'),
                    ];
                }

                $current->addMinutes($duration);
            }
        }

        return $slots;
    }
}
