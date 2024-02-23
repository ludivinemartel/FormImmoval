<?php

namespace App\Service;

use DateTime;

class CalendarGenerator
{
    public function generateCalendar(): array
    {
    $currentDate = new DateTime();
    $daysInMonth = $currentDate->format('t');
    $firstDayOfMonth = new DateTime('first day of ' . $currentDate->format('F Y'));
    $firstDayOfWeek = (int)$firstDayOfMonth->format('N');

    $calendar = [];
    $currentDay = 1;
    for ($i = 1; $i <= 6; $i++) {
        $week = [];
        for ($j = 1; $j <= 7; $j++) {
            if ($i === 1 && $j < $firstDayOfWeek) {
                $week[] = null;
            } elseif ($currentDay <= $daysInMonth) {
                $week[] = $currentDay;
                $currentDay++;
            } else {
                $week[] = null;
            }
        }
        $calendar[] = $week;
    }

    return $calendar;
}
}
