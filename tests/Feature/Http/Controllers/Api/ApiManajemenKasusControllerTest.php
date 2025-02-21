<?php

use App\Models\User;

test('index method returns paginated manajemenKasuses', function () {
    createManajemenKasus();

    $response = actAsSuperAdmin()->getJson('/api/manajemenKasuses?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/manajemenKasuses/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ManajemenKasus/Create'));
});

test('store method creates new manajemenKasus', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/manajemenKasuses', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('manajemenKasuses', $data);
});

test('show method returns manajemenKasus details', function () {
    $model = createManajemenKasus();

    $response = actAsSuperAdmin()->getJson("/api/manajemenKasuses/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createManajemenKasus();

    $response = actAsSuperAdmin()->get("/api/manajemenKasuses/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ManajemenKasus/Edit'));
});

test('update method updates manajemenKasus', function () {
    $model = createManajemenKasus();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/manajemenKasuses/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('manajemenKasuses', $updatedData);
});

test('destroy method deletes manajemenKasus', function () {
    $model = createManajemenKasus();

    $response = actAsSuperAdmin()->deleteJson("/api/manajemenKasuses/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('manajemenKasuses', ['id' => $model->id]);
});