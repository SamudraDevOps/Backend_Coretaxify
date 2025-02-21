<?php

use App\Models\User;

test('index method returns paginated kuasaWajibPajaks', function () {
    createKuasaWajibPajak();

    $response = actAsSuperAdmin()->getJson('/api/kuasaWajibPajaks?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/kuasaWajibPajaks/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('KuasaWajibPajak/Create'));
});

test('store method creates new kuasaWajibPajak', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/kuasaWajibPajaks', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('kuasaWajibPajaks', $data);
});

test('show method returns kuasaWajibPajak details', function () {
    $model = createKuasaWajibPajak();

    $response = actAsSuperAdmin()->getJson("/api/kuasaWajibPajaks/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createKuasaWajibPajak();

    $response = actAsSuperAdmin()->get("/api/kuasaWajibPajaks/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('KuasaWajibPajak/Edit'));
});

test('update method updates kuasaWajibPajak', function () {
    $model = createKuasaWajibPajak();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/kuasaWajibPajaks/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('kuasaWajibPajaks', $updatedData);
});

test('destroy method deletes kuasaWajibPajak', function () {
    $model = createKuasaWajibPajak();

    $response = actAsSuperAdmin()->deleteJson("/api/kuasaWajibPajaks/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('kuasaWajibPajaks', ['id' => $model->id]);
});