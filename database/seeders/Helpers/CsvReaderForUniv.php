<?php

namespace Database\Seeders\Helpers;

class CsvReaderForUniv {
    protected $filePath;
    protected $delimiter;

    public function __construct(string $fileName, string $delimiter = ',') {
        $this->filePath = base_path('database/data/' . $fileName . '.csv');
        $this->delimiter = $delimiter;
    }

    public function getCsvData() {
        if (file_exists($this->filePath)) {
            $csvData = array_map(function ($line) {
                return str_getcsv($line, $this->delimiter);
            }, file($this->filePath));
            array_walk($csvData, function (&$a) use ($csvData) {
            // Only process rows with the same number of columns as the header
            if (count($a) === count($csvData[0])) {
                $a = array_map(function ($value) {
                    return $value !== '' ? $value : null;
                }, array_combine($csvData[0], $a));
                $a = array_filter($a, function ($value) {
                    return $value !== null;
                });
            } else {
                $a = null; // Mark as invalid
            }
        });
        $csvData = array_filter($csvData, fn($row) => $row !== null);
        } else {
            $csvData = null;
        }

        return $csvData;
    }
}
