<?php

use App\Models\User;

test('index method returns paginated penunjukkanWajibPajakSayas', function () {
    createPenunjukkanWajibPajakSaya();

    $response = actAsSuperAdmin()->getJson('/api/penunjukkanWajibPajakSayas?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/penunjukkanWajibPajakSayas/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PenunjukkanWajibPajakSaya/Create'));
});

test('store method creates new penunjukkanWajibPajakSaya', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/penunjukkanWajibPajakSayas', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('penunjukkanWajibPajakSayas', $data);
});

test('show method returns penunjukkanWajibPajakSaya details', function () {
    $model = createPenunjukkanWajibPajakSaya();

    $response = actAsSuperAdmin()->getJson("/api/penunjukkanWajibPajakSayas/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createPenunjukkanWajibPajakSaya();

    $response = actAsSuperAdmin()->get("/api/penunjukkanWajibPajakSayas/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PenunjukkanWajibPajakSaya/Edit'));
});

test('update method updates penunjukkanWajibPajakSaya', function () {
    $model = createPenunjukkanWajibPajakSaya();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/penunjukkanWajibPajakSayas/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('penunjukkanWajibPajakSayas', $updatedData);
});

test('destroy method deletes penunjukkanWajibPajakSaya', function () {
    $model = createPenunjukkanWajibPajakSaya();

    $response = actAsSuperAdmin()->deleteJson("/api/penunjukkanWajibPajakSayas/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('penunjukkanWajibPajakSayas', ['id' => $model->id]);
});