<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\ExcelReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $excelReader = new ExcelReader('satuan');
        $excelData = $excelReader->getExcelData();

        if ($excelData) {
            foreach ($excelData as $data) {
                Satuan::create($data);
            }
        } else {
            // InformasiTambahan::factory(5)->create();
        }
    }
}
