<?php

namespace Database\Seeders;

use App\Models\University;
use Database\Seeders\Helpers\CsvReaderForUniv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Helpers\CsvReader;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $csvReader = new CsvReaderForUniv('university');
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
