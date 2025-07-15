<?php

use App\Models\User;

test('index method returns paginated selfAssignments', function () {
    createSelfAssignment();

    $response = actAsAdmin()->getJson('/api/selfAssignments?page=1&perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(1, 'data');
});

test('store method creates new selfAssignment', function () {
    $data = [
        'name' => 'Test name',
    ];

    $response = actAsAdmin()->postJson('/api/selfAssignments', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name']);
    $this->assertDatabaseHas('selfAssignments', $data);
});

test('show method returns selfAssignment details', function () {
    $model = createSelfAssignment();

    $response = actAsAdmin()->getJson("/api/selfAssignments/{$model->id}");

    $response->assertStatus(200)
        ->assertJson(['id' => $model->id, 'name' => $model->name]);
});

test('update method updates selfAssignment', function () {
    $model = createSelfAssignment();
    $updatedData = [
        'name' => 'Updated name',
    ];

    $response = actAsAdmin()->putJson("/api/selfAssignments/{$model->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson($updatedData);
    $this->assertDatabaseHas('selfAssignments', $updatedData);
});

test('destroy method deletes selfAssignment', function () {
    $model = createSelfAssignment();

    $response = actAsAdmin()->deleteJson("/api/selfAssignments/{$model->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('selfAssignments', ['id' => $model->id]);
});