<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\University;
use App\Support\Enums\ContractStatusEnum;
use App\Support\Enums\ContractTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignmentUser>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'university_id' => University::inRandomOrder()->first()->id ?? University::factory()->create()->id,
            'contract_type' => ContractTypeEnum::LICENSE->value,
            'qty_student' => $this->faker->numberBetween(10, 50),
            'start_period' => $this->faker->date,
            'end_period' => $this->faker->date,
            'spt' => $this->faker->numberBetween(5,10),
            'bupot' => $this->faker->numberBetween(5,10),
            'faktur' => $this->faker->numberBetween(5,10),
            'contract_code' => $this->faker->text(5),
            'status' => ContractStatusEnum::ACTIVE->value,
            'is_buy_task' => false,
        ];
    }
}
