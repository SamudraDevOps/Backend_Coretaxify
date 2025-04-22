<!-- TEMPLATE YA -->

<?php

use App\Models\User;
use App\Models\University;
use App\Support\Enums\ContractTypeEnum;
use App\Support\Enums\ContractStatusEnum;

test('index method returns paginated dataEkonomis', function () {
    $this->dummy->createContract();

    $response = actAsAdmin()->getJson('/api/admin/contract?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta']);
});

test('store method creates new dataEkonomi', function () {
    $data = [
        'university_id' => University::inRandomOrder()->first()->id ?? University::factory()->create()->id,
        'contract_type' => ContractTypeEnum::LICENSE->value,
        'qty_student' => 5,
        'start_period' => '2023-01-01',
        'end_period' => '2023-01-02',
        'spt' => 5,
        'bupot' => 5,
        'faktur' => 5,
        'contract_code' => 'L-ABCDE',
        'status' => ContractStatusEnum::ACTIVE->value,
        'is_buy_task' => 0,
    ];

    $response = actAsAdmin()->postJson('/api/admin/contract', $data);

    $response->assertStatus(201);
        // ->assertJsonStructure(['id', 'name']);
    // $this->assertDatabaseHas('contracts', $data);
});

// test('show method returns dataEkonomi details', function () {
//     $model = createDataEkonomi();

//     $response = actAsSuperAdmin()->getJson("/api/dataEkonomis/{$model->id}");

//     $response->assertStatus(200)
//         ->assertJson(['id' => $model->id, 'name' => $model->name]);
// });

// test('update method updates dataEkonomi', function () {
//     $model = createDataEkonomi();
//     $updatedData = [
//         'name' => 'Updated name',
//     ];

//     $response = actAsSuperAdmin()->putJson("/api/dataEkonomis/{$model->id}", $updatedData);

//     $response->assertStatus(200)
//         ->assertJson($updatedData);
//     $this->assertDatabaseHas('dataEkonomis', $updatedData);
// });

// test('destroy method deletes dataEkonomi', function () {
//     $model = createDataEkonomi();

//     $response = actAsSuperAdmin()->deleteJson("/api/dataEkonomis/{$model->id}");

//     $response->assertStatus(204);
//     $this->assertDatabaseMissing('dataEkonomis', ['id' => $model->id]);
// });
