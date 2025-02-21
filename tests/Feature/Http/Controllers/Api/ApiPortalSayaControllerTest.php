<?php

use App\Models\User;

test('index method returns paginated portalSayas', function () {
    createPortalSaya();

    $response = actAsSuperAdmin()->getJson('/api/portalSayas?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/portalSayas/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PortalSaya/Create'));
});

test('store method creates new portalSaya', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/portalSayas', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('portalSayas', $data);
});

test('show method returns portalSaya details', function () {
    $model = createPortalSaya();

    $response = actAsSuperAdmin()->getJson("/api/portalSayas/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createPortalSaya();

    $response = actAsSuperAdmin()->get("/api/portalSayas/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('PortalSaya/Edit'));
});

test('update method updates portalSaya', function () {
    $model = createPortalSaya();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/portalSayas/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('portalSayas', $updatedData);
});

test('destroy method deletes portalSaya', function () {
    $model = createPortalSaya();

    $response = actAsSuperAdmin()->deleteJson("/api/portalSayas/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('portalSayas', ['id' => $model->id]);
});