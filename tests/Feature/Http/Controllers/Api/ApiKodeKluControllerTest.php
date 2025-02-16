<?php

use App\Models\User;

test('index method returns paginated kodeKlus', function () {
    createKodeKlu();

    $response = actAsSuperAdmin()->getJson('/api/kodeKlus?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/kodeKlus/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('KodeKlu/Create'));
});

test('store method creates new kodeKlu', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/kodeKlus', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('kodeKlus', $data);
});

test('show method returns kodeKlu details', function () {
    $model = createKodeKlu();

    $response = actAsSuperAdmin()->getJson("/api/kodeKlus/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createKodeKlu();

    $response = actAsSuperAdmin()->get("/api/kodeKlus/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('KodeKlu/Edit'));
});

test('update method updates kodeKlu', function () {
    $model = createKodeKlu();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/kodeKlus/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('kodeKlus', $updatedData);
});

test('destroy method deletes kodeKlu', function () {
    $model = createKodeKlu();

    $response = actAsSuperAdmin()->deleteJson("/api/kodeKlus/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('kodeKlus', ['id' => $model->id]);
});