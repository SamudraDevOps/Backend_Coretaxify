<?php

namespace Database\Factories;

use App\Support\Enums\BupotTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BupotObjekPajak>
 */
class BupotObjekPajakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipe_bupot' => BupotTypeEnum::BPPU->value,
            'nama_objek_pajak' => $this->faker->word,
            'jenis_pajak' => $this->faker->word,
            'kode_objek_pajak' => $this->faker->word,
            'tarif_pajak' => $this->faker->numberBetween(1, 10),
            'sifat_pajak_penghasilan' => $this->faker->word,
        ];
    }
}
