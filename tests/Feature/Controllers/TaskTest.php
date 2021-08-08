<?php

namespace Tests\Feature\Controllers;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskSeeder;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function testCanShowWithAuth()
    {
        $this->setAuthCurrentUserForRouteTasks();

        $this->seed(TaskSeeder::class);
        $this->get(route('tasks.index'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => [
                [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ],
            ]]);
    }

    public function testNotCanShowWithoutAuth()
    {
        $this->seed(TaskSeeder::class);
        $this->get(route('tasks.index'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanCreateWithAuth()
    {
        $this->setAuthCurrentUserForRouteTasks();

        $task = Task::factory()->make();
        $data = [
            'name'        => $task->name,
            'description' => $task->description,
        ];

        $this->post(route('tasks.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $data]);
    }

    public function testNotCanCreateWithoutAuth()
    {
        $task = Task::factory()->make();
        $data = $task->getAttributes();

        $this->post(route('tasks.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider providerValidationCreate
     */
    public function testValidationCreate(array $data)
    {
        $this->setAuthCurrentUserForRouteTasks();

        $this->post(route('tasks.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function providerValidationCreate(): array
    {
        $task = Task::factory()->make();

        return [
            [
                [],
            ],
            [
                [
                    'description' => $task->description,
                ],
            ],
            [
                [
                    'name' => $task->name,
                ],
            ],
            [
                [
                    'name'        => 23,
                    'description' => 8948,
                ],
            ],
            [
                [

                    'name'        => 2454,
                    'description' => $task->description,

                ],
            ],
            [
                [
                    'name'        => $task->name,
                    'description' => 654,
                ],
            ],
        ];
    }

    public function testNotCanUpdate()
    {
        $this->put(route("tasks.store"), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testNotCatDelete()
    {
        $this->delete(route("tasks.store"), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    private function setAuthCurrentUserForRouteTasks()
    {
        Passport::actingAs(
            User::factory()->make(),
            [
                route('tasks.index'),
                route('tasks.store'),
            ]
        );
    }
}
