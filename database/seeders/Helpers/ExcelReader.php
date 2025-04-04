<?php

namespace Database\Seeders\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelReader
{
    protected $filePath;
    protected $data = [];

    public function __construct(string $fileName)
    {
        $this->filePath = base_path('database/data/' . $fileName . '.xlsx');
    }

    public function getExcelData(): array
{
    if (!file_exists($this->filePath)) {
        return [];
    }

    try {
        $spreadsheet = IOFactory::load($this->filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Get headers from the first row
        $headers = array_shift($rows);

        foreach ($rows as $row) {
            $item = [];
            foreach ($headers as $index => $header) {
                if (isset($row[$index])) {
                    if (is_string($row[$index])) {
                        // Clean the string data
                        $cleanValue = $this->cleanString($row[$index]);

                        // Truncate if needed
                        if ($header === 'nama_transaksi') {
                            $cleanValue = substr($cleanValue, 0, 255); // Adjust length as needed
                        }

                        $item[$header] = $cleanValue;
                    } else {
                        $item[$header] = $row[$index];
                    }
                }
            }
            $this->data[] = $item;
        }

        return $this->data;
    } catch (\Exception $e) {
        // Log error or handle exception
        return [];
    }
    }

    /**
     * Clean string from problematic characters
     */
    private function cleanString($string)
    {
        // Remove or replace problematic characters
        $string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $string);

        // Alternative: convert to ASCII
        // $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

        // Remove any special Unicode characters
        $string = preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}]/u', '', $string);

        return $string;
    }


}
