<?php

use App\Models\User;

test('index method returns paginated alamatWajibPajaks', function () {
    createAlamatWajibPajak();

    $response = actAsAdmin()->getJson('/api/alamatWajibPajaks?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('store method creates new alamatWajibPajak', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/alamatWajibPajaks', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('alamatWajibPajaks', $data);
});

test('show method returns alamatWajibPajak details', function () {
    $model = createAlamatWajibPajak();

    $response = actAsSuperAdmin()->getJson("/api/alamatWajibPajaks/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('update method updates alamatWajibPajak', function () {
    $model = createAlamatWajibPajak();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/alamatWajibPajaks/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('alamatWajibPajaks', $updatedData);
});

test('destroy method deletes alamatWajibPajak', function () {
    $model = createAlamatWajibPajak();

    $response = actAsSuperAdmin()->deleteJson("/api/alamatWajibPajaks/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('alamatWajibPajaks', ['id' => $model->id]);
});
