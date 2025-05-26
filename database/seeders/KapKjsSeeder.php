<?php

namespace Database\Seeders;

use App\Models\KapKjs;
use Illuminate\Database\Seeder;
use App\Models\InformasiTambahan;
use Database\Seeders\Helpers\ExcelReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KapKjsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $excelReader = new ExcelReader('kapKjs');
        $excelData = $excelReader->getExcelData();

        if ($excelData) {
            foreach ($excelData as $data) {
                KapKjs::create($data);
            }
        } else {
            // InformasiTambahan::factory(5)->create();
        }
    }
}