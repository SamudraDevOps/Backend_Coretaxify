<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\CsvReader;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $csvReader = new CsvReader('university10');
        $csvData = $csvReader->getCsvData();
        if ($csvData) {
            foreach ($csvData as $data) {
                University::create($data);
            }
        } else {
            University::factory(4)->create();
        }
    }
}