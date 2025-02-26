<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Contract;
use App\Support\Enums\ContractStatusEnum;
use Illuminate\Database\Seeder;
use App\Support\Enums\ContractTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract = Contract::create([
            'university_id' => 1,
            // 'task_id' => Task::inRandomOrder()->first()->id,
            'contract_type' => ContractTypeEnum::LICENSE->value,
            'qty_student' => 1,
            'start_period' => now(),
            'end_period' => now()->addYears(1),
            'spt' => 5,
            'bupot' => 5,
            'faktur' => 5,
            'contract_code' => 'L-0001',
            'is_buy_task' => 1,
            'status' => ContractStatusEnum::ACTIVE->value,
        ]);

        $contract2 = Contract::create([
            'university_id' => 1,
            // 'task_id' => Task::inRandomOrder()->first()->id,
            'contract_type' => ContractTypeEnum::LICENSE->value,
            'qty_student' => 1,
            'start_period' => now(),
            'end_period' => now()->addYears(1),
            'spt' => 5,
            'bupot' => 5,
            'faktur' => 5,
            'contract_code' => 'L-0002',
            'is_buy_task' => 1,
            'status' => ContractStatusEnum::ACTIVE->value,
        ]);
        $contract2->tasks()->attach([3]);
    }
}