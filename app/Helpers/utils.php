<?php

if (!function_exists('convertMinutesToDuration')) {
    function convertMinutesToDuration($totalMinutes) {
        $days = floor($totalMinutes / (24 * 60));
        $hours = floor(($totalMinutes % (24 * 60)) / 60);
        $minutes = $totalMinutes % 60;

        $duration = [];
        if ($days > 0) {
            $duration[] = "$days hari";
        }
        if ($hours > 0) {
            $duration[] = "$hours jam";
        }
        if ($minutes > 0) {
            $duration[] = "$minutes menit";
        }

        return implode(' ', $duration);
    }
}