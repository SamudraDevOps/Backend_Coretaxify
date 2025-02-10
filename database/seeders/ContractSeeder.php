<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Support\Enums\ContractTypeEnum;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract = Contract::create([
            'university_id' => 1,
            'contract_type' => ContractTypeEnum::LICENSE->value,
            'qty_student' => 1,
            'start_period' => now(),
            'end_period' => now()->addYears(1),
            'spt' => 5,
            'bupot' => 5,
            'faktur' => 5,
            'contract_code' => 'L-0001',
        ]);
    }
}
