<?php

namespace Database\Seeders;


use App\Models\BupotObjekPajak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\CsvReader;

class BupotObjekPajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvReader = new CsvReader('objek_pajak');
        $csvData = $csvReader->getCsvData();
        if ($csvData) {
            foreach ($csvData as $data) {
                BupotObjekPajak::create($data);
            }
        } else {
            BupotObjekPajak::factory(4)->create();
        }
    }
}
