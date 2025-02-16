<?php

use App\Models\User;

test('index method returns paginated informasiUmums', function () {
    createInformasiUmum();

    $response = actAsSuperAdmin()->getJson('/api/informasiUmums?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/informasiUmums/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('InformasiUmum/Create'));
});

test('store method creates new informasiUmum', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/informasiUmums', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('informasiUmums', $data);
});

test('show method returns informasiUmum details', function () {
    $model = createInformasiUmum();

    $response = actAsSuperAdmin()->getJson("/api/informasiUmums/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createInformasiUmum();

    $response = actAsSuperAdmin()->get("/api/informasiUmums/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('InformasiUmum/Edit'));
});

test('update method updates informasiUmum', function () {
    $model = createInformasiUmum();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/informasiUmums/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('informasiUmums', $updatedData);
});

test('destroy method deletes informasiUmum', function () {
    $model = createInformasiUmum();

    $response = actAsSuperAdmin()->deleteJson("/api/informasiUmums/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('informasiUmums', ['id' => $model->id]);
});