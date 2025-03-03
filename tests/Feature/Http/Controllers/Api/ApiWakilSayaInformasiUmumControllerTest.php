<?php

use App\Models\User;

test('index method returns paginated wakilSayaInformasiUmums', function () {
    createWakilSayaInformasiUmum();

    $response = actAsSuperAdmin()->getJson('/api/wakilSayaInformasiUmums?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/wakilSayaInformasiUmums/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('WakilSayaInformasiUmum/Create'));
});

test('store method creates new wakilSayaInformasiUmum', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/wakilSayaInformasiUmums', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('wakilSayaInformasiUmums', $data);
});

test('show method returns wakilSayaInformasiUmum details', function () {
    $model = createWakilSayaInformasiUmum();

    $response = actAsSuperAdmin()->getJson("/api/wakilSayaInformasiUmums/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createWakilSayaInformasiUmum();

    $response = actAsSuperAdmin()->get("/api/wakilSayaInformasiUmums/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('WakilSayaInformasiUmum/Edit'));
});

test('update method updates wakilSayaInformasiUmum', function () {
    $model = createWakilSayaInformasiUmum();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/wakilSayaInformasiUmums/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('wakilSayaInformasiUmums', $updatedData);
});

test('destroy method deletes wakilSayaInformasiUmum', function () {
    $model = createWakilSayaInformasiUmum();

    $response = actAsSuperAdmin()->deleteJson("/api/wakilSayaInformasiUmums/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('wakilSayaInformasiUmums', ['id' => $model->id]);
});