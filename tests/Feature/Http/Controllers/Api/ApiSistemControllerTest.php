<?php

use App\Models\User;

test('index method returns paginated sistems', function () {
    createSistem();

    $response = actAsSuperAdmin()->getJson('/api/sistems?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/sistems/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('Sistem/Create'));
});

test('store method creates new sistem', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/sistems', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('sistems', $data);
});

test('show method returns sistem details', function () {
    $model = createSistem();

    $response = actAsSuperAdmin()->getJson("/api/sistems/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createSistem();

    $response = actAsSuperAdmin()->get("/api/sistems/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('Sistem/Edit'));
});

test('update method updates sistem', function () {
    $model = createSistem();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/sistems/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('sistems', $updatedData);
});

test('destroy method deletes sistem', function () {
    $model = createSistem();

    $response = actAsSuperAdmin()->deleteJson("/api/sistems/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('sistems', ['id' => $model->id]);
});