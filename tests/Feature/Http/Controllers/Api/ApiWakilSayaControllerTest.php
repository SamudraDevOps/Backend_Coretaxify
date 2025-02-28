<?php

use App\Models\User;

test('index method returns paginated wakilSayas', function () {
    createWakilSaya();

    $response = actAsSuperAdmin()->getJson('/api/wakilSayas?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/wakilSayas/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('WakilSaya/Create'));
});

test('store method creates new wakilSaya', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/wakilSayas', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('wakilSayas', $data);
});

test('show method returns wakilSaya details', function () {
    $model = createWakilSaya();

    $response = actAsSuperAdmin()->getJson("/api/wakilSayas/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createWakilSaya();

    $response = actAsSuperAdmin()->get("/api/wakilSayas/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('WakilSaya/Edit'));
});

test('update method updates wakilSaya', function () {
    $model = createWakilSaya();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/wakilSayas/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('wakilSayas', $updatedData);
});

test('destroy method deletes wakilSaya', function () {
    $model = createWakilSaya();

    $response = actAsSuperAdmin()->deleteJson("/api/wakilSayas/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('wakilSayas', ['id' => $model->id]);
});