<?php

use App\Models\User;

test('index method returns paginated dummies', function () {
    createDummy();

    $response = actAsSuperAdmin()->getJson('/api/dummies?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/dummies/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('Dummy/Create'));
});

test('store method creates new dummy', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/dummies', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('dummies', $data);
});

test('show method returns dummy details', function () {
    $model = createDummy();

    $response = actAsSuperAdmin()->getJson("/api/dummies/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createDummy();

    $response = actAsSuperAdmin()->get("/api/dummies/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('Dummy/Edit'));
});

test('update method updates dummy', function () {
    $model = createDummy();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/dummies/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('dummies', $updatedData);
});

test('destroy method deletes dummy', function () {
    $model = createDummy();

    $response = actAsSuperAdmin()->deleteJson("/api/dummies/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('dummies', ['id' => $model->id]);
});