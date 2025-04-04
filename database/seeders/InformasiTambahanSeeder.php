<?php

namespace Database\Seeders;

use App\Models\InformasiTambahan;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\ExcelReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class InformasiTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $excelReader = new ExcelReader('informasiTambahan');
        $excelData = $excelReader->getExcelData();

        if ($excelData) {
            foreach ($excelData as $data) {
                InformasiTambahan::create($data);
            }
        } else {
            // InformasiTambahan::factory(5)->create();
        }
    }
}
