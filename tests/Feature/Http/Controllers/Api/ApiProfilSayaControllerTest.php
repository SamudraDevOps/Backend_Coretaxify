<?php

use App\Models\User;

test('index method returns paginated profilSayas', function () {
    createProfilSaya();

    $response = actAsSuperAdmin()->getJson('/api/profilSayas?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/profilSayas/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ProfilSaya/Create'));
});

test('store method creates new profilSaya', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/profilSayas', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('profilSayas', $data);
});

test('show method returns profilSaya details', function () {
    $model = createProfilSaya();

    $response = actAsSuperAdmin()->getJson("/api/profilSayas/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createProfilSaya();

    $response = actAsSuperAdmin()->get("/api/profilSayas/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ProfilSaya/Edit'));
});

test('update method updates profilSaya', function () {
    $model = createProfilSaya();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/profilSayas/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('profilSayas', $updatedData);
});

test('destroy method deletes profilSaya', function () {
    $model = createProfilSaya();

    $response = actAsSuperAdmin()->deleteJson("/api/profilSayas/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('profilSayas', ['id' => $model->id]);
});