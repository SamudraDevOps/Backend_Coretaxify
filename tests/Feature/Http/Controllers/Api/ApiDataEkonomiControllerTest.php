<?php

use App\Models\User;

test('index method returns paginated dataEkonomis', function () {
    createDataEkonomi();

    $response = actAsSuperAdmin()->getJson('/api/dataEkonomis?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/dataEkonomis/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DataEkonomi/Create'));
});

test('store method creates new dataEkonomi', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/dataEkonomis', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('dataEkonomis', $data);
});

test('show method returns dataEkonomi details', function () {
    $model = createDataEkonomi();

    $response = actAsSuperAdmin()->getJson("/api/dataEkonomis/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createDataEkonomi();

    $response = actAsSuperAdmin()->get("/api/dataEkonomis/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DataEkonomi/Edit'));
});

test('update method updates dataEkonomi', function () {
    $model = createDataEkonomi();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/dataEkonomis/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('dataEkonomis', $updatedData);
});

test('destroy method deletes dataEkonomi', function () {
    $model = createDataEkonomi();

    $response = actAsSuperAdmin()->deleteJson("/api/dataEkonomis/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('dataEkonomis', ['id' => $model->id]);
});