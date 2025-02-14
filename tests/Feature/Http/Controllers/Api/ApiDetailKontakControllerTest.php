<?php

use App\Models\User;

test('index method returns paginated detailKontaks', function () {
    createDetailKontak();

    $response = actAsSuperAdmin()->getJson('/api/detailKontaks?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/detailKontaks/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DetailKontak/Create'));
});

test('store method creates new detailKontak', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/detailKontaks', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('detailKontaks', $data);
});

test('show method returns detailKontak details', function () {
    $model = createDetailKontak();

    $response = actAsSuperAdmin()->getJson("/api/detailKontaks/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createDetailKontak();

    $response = actAsSuperAdmin()->get("/api/detailKontaks/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('DetailKontak/Edit'));
});

test('update method updates detailKontak', function () {
    $model = createDetailKontak();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/detailKontaks/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('detailKontaks', $updatedData);
});

test('destroy method deletes detailKontak', function () {
    $model = createDetailKontak();

    $response = actAsSuperAdmin()->deleteJson("/api/detailKontaks/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('detailKontaks', ['id' => $model->id]);
});