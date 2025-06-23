<?php

namespace App\Support\Helpers;

class MonthHelper
{
    const MONTHS_INDONESIA = [
        'Januari' => 1,
        'Februari' => 2,
        'Maret' => 3,
        'April' => 4,
        'Mei' => 5,
        'Juni' => 6,
        'Juli' => 7,
        'Agustus' => 8,
        'September' => 9,
        'Oktober' => 10,
        'November' => 11,
        'Desember' => 12,
    ];

    public static function getMonthNumber(string $monthName): int
    {
        $monthNumber = self::MONTHS_INDONESIA[$monthName] ?? null;

        if (!$monthNumber) {
            throw new \InvalidArgumentException("Invalid month name: {$monthName}");
        }

        return $monthNumber;
    }

    public static function getMonthName(int $monthNumber): string
    {
        $monthNames = array_flip(self::MONTHS_INDONESIA);

        if (!isset($monthNames[$monthNumber])) {
            throw new \InvalidArgumentException("Invalid month number: {$monthNumber}");
        }

        return $monthNames[$monthNumber];
    }

    public static function getAllMonths(): array
    {
        return self::MONTHS_INDONESIA;
    }
}
