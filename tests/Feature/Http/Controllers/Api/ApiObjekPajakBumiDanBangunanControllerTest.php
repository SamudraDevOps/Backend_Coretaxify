<?php

use App\Models\User;

test('index method returns paginated objekPajakBumiDanBangunans', function () {
    createObjekPajakBumiDanBangunan();

    $response = actAsSuperAdmin()->getJson('/api/objekPajakBumiDanBangunans?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('create method returns create page', function () {

    $response = actAsSuperAdmin()->get('/api/objekPajakBumiDanBangunans/create');

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ObjekPajakBumiDanBangunan/Create'));
});

test('store method creates new objekPajakBumiDanBangunan', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsSuperAdmin()->postJson('/api/objekPajakBumiDanBangunans', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('objekPajakBumiDanBangunans', $data);
});

test('show method returns objekPajakBumiDanBangunan details', function () {
    $model = createObjekPajakBumiDanBangunan();

    $response = actAsSuperAdmin()->getJson("/api/objekPajakBumiDanBangunans/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('edit method returns edit page', function () {
    $model = createObjekPajakBumiDanBangunan();

    $response = actAsSuperAdmin()->get("/api/objekPajakBumiDanBangunans/{$model->id}/edit");

    $response->assertStatus(200)
        ->assertInertia(fn ($assert) => $assert->component('ObjekPajakBumiDanBangunan/Edit'));
});

test('update method updates objekPajakBumiDanBangunan', function () {
    $model = createObjekPajakBumiDanBangunan();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsSuperAdmin()->putJson("/api/objekPajakBumiDanBangunans/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('objekPajakBumiDanBangunans', $updatedData);
});

test('destroy method deletes objekPajakBumiDanBangunan', function () {
    $model = createObjekPajakBumiDanBangunan();

    $response = actAsSuperAdmin()->deleteJson("/api/objekPajakBumiDanBangunans/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('objekPajakBumiDanBangunans', ['id' => $model->id]);
});