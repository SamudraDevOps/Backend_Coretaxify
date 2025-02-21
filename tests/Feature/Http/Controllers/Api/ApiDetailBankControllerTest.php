<?php

use App\Models\User;

test('index method returns paginated detailBanks', function () {
    createDetailBank();

    $response = actAsSuperAdmin()->getJson('/api/detailBanks?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/detailBanks/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DetailBank/Create'));
});

test('store method creates new detailBank', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/detailBanks', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('detailBanks', $data);
});

test('show method returns detailBank details', function () {
    $model = createDetailBank();

    $response = actAsSuperAdmin()->getJson("/api/detailBanks/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createDetailBank();

    $response = actAsSuperAdmin()->get("/api/detailBanks/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DetailBank/Edit'));
});

test('update method updates detailBank', function () {
    $model = createDetailBank();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/detailBanks/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('detailBanks', $updatedData);
});

test('destroy method deletes detailBank', function () {
    $model = createDetailBank();

    $response = actAsSuperAdmin()->deleteJson("/api/detailBanks/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('detailBanks', ['id' => $model->id]);
});