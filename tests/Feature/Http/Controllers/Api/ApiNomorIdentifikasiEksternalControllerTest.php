<?php

use App\Models\User;

test('index method returns paginated nomorIdentifikasiEksternals', function () {
    createNomorIdentifikasiEksternal();

    $response = actAsSuperAdmin()->getJson('/api/nomorIdentifikasiEksternals?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/nomorIdentifikasiEksternals/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('NomorIdentifikasiEksternal/Create'));
});

test('store method creates new nomorIdentifikasiEksternal', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/nomorIdentifikasiEksternals', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('nomorIdentifikasiEksternals', $data);
});

test('show method returns nomorIdentifikasiEksternal details', function () {
    $model = createNomorIdentifikasiEksternal();

    $response = actAsSuperAdmin()->getJson("/api/nomorIdentifikasiEksternals/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createNomorIdentifikasiEksternal();

    $response = actAsSuperAdmin()->get("/api/nomorIdentifikasiEksternals/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('NomorIdentifikasiEksternal/Edit'));
});

test('update method updates nomorIdentifikasiEksternal', function () {
    $model = createNomorIdentifikasiEksternal();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/nomorIdentifikasiEksternals/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('nomorIdentifikasiEksternals', $updatedData);
});

test('destroy method deletes nomorIdentifikasiEksternal', function () {
    $model = createNomorIdentifikasiEksternal();

    $response = actAsSuperAdmin()->deleteJson("/api/nomorIdentifikasiEksternals/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('nomorIdentifikasiEksternals', ['id' => $model->id]);
});