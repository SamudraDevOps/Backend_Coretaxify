<?php

namespace Database\Seeders;

use App\Models\KodeTransaksi;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\ExcelReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KodeTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $excelReader = new ExcelReader('kodeTransaksi');
        $excelData = $excelReader->getExcelData();

        if ($excelData) {
            foreach ($excelData as $data) {
                KodeTransaksi::create($data);
            }
        } else {
            // KodeTransaksi::factory(5)->create();
        }
    }
}
