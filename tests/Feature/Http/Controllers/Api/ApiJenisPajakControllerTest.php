<?php

use App\Models\User;

test('index method returns paginated jenisPajaks', function () {
    createJenisPajak();

    $response = actAsSuperAdmin()->getJson('/api/jenisPajaks?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/jenisPajaks/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('JenisPajak/Create'));
});

test('store method creates new jenisPajak', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/jenisPajaks', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('jenisPajaks', $data);
});

test('show method returns jenisPajak details', function () {
    $model = createJenisPajak();

    $response = actAsSuperAdmin()->getJson("/api/jenisPajaks/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createJenisPajak();

    $response = actAsSuperAdmin()->get("/api/jenisPajaks/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('JenisPajak/Edit'));
});

test('update method updates jenisPajak', function () {
    $model = createJenisPajak();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/jenisPajaks/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('jenisPajaks', $updatedData);
});

test('destroy method deletes jenisPajak', function () {
    $model = createJenisPajak();

    $response = actAsSuperAdmin()->deleteJson("/api/jenisPajaks/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('jenisPajaks', ['id' => $model->id]);
});