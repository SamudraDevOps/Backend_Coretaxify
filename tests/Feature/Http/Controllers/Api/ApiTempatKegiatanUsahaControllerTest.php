<?php

use App\Models\User;

test('index method returns paginated tempatKegiatanUsahas', function () {
    createTempatKegiatanUsaha();

    $response = actAsSuperAdmin()->getJson('/api/tempatKegiatanUsahas?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/tempatKegiatanUsahas/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('TempatKegiatanUsaha/Create'));
});

test('store method creates new tempatKegiatanUsaha', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/tempatKegiatanUsahas', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('tempatKegiatanUsahas', $data);
});

test('show method returns tempatKegiatanUsaha details', function () {
    $model = createTempatKegiatanUsaha();

    $response = actAsSuperAdmin()->getJson("/api/tempatKegiatanUsahas/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createTempatKegiatanUsaha();

    $response = actAsSuperAdmin()->get("/api/tempatKegiatanUsahas/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('TempatKegiatanUsaha/Edit'));
});

test('update method updates tempatKegiatanUsaha', function () {
    $model = createTempatKegiatanUsaha();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/tempatKegiatanUsahas/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('tempatKegiatanUsahas', $updatedData);
});

test('destroy method deletes tempatKegiatanUsaha', function () {
    $model = createTempatKegiatanUsaha();

    $response = actAsSuperAdmin()->deleteJson("/api/tempatKegiatanUsahas/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('tempatKegiatanUsahas', ['id' => $model->id]);
});