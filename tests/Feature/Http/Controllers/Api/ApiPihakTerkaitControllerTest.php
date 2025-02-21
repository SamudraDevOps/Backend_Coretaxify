<?php

use App\Models\User;

test('index method returns paginated pihakTerkaits', function () {
    createPihakTerkait();

    $response = actAsSuperAdmin()->getJson('/api/pihakTerkaits?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/pihakTerkaits/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PihakTerkait/Create'));
});

test('store method creates new pihakTerkait', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/pihakTerkaits', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('pihakTerkaits', $data);
});

test('show method returns pihakTerkait details', function () {
    $model = createPihakTerkait();

    $response = actAsSuperAdmin()->getJson("/api/pihakTerkaits/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createPihakTerkait();

    $response = actAsSuperAdmin()->get("/api/pihakTerkaits/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PihakTerkait/Edit'));
});

test('update method updates pihakTerkait', function () {
    $model = createPihakTerkait();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/pihakTerkaits/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('pihakTerkaits', $updatedData);
});

test('destroy method deletes pihakTerkait', function () {
    $model = createPihakTerkait();

    $response = actAsSuperAdmin()->deleteJson("/api/pihakTerkaits/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('pihakTerkaits', ['id' => $model->id]);
});