<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    public function testCanCreate()
    {
        $user = User::factory()->make();

        $data = [
            "name"            => $user->name,
            "email"           => $user->email,
            "password"        => $user->password,
            "password_repeat" => $user->password,
        ];

        $this->post(route('registration.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => [
                'name'  => $user->name,
                'email' => $user->email,
            ]]);
    }

    /**
     * @dataProvider providerValidationCreate
     */
    public function testValidationCreate(array $data): void
    {
        $this->post(route('registration.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function providerValidationCreate(): array
    {
        $this->createApplication();
        $user = User::factory()->make();

        return [
            [
                [],
            ],

            [
                [
                    "name" => $user->name,
                ],
            ],
            [
                [
                    "email" => $user->email,
                ],
            ],
            [
                [
                    "password" => $user->password,
                ],
            ],
            [
                [
                    "password_repeat" => $user->password,
                ],
            ],

            [
                [
                    "name"  => $user->name,
                    "email" => $user->email,
                ],
            ],
            [
                [
                    "name"     => $user->name,
                    "password" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "email"    => $user->email,
                    "password" => $user->password,
                ],
            ],
            [
                [
                    "email"           => $user->email,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],

            [
                [
                    "name"     => $user->name,
                    "email"    => $user->email,
                    "password" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "email"           => $user->email,
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"     => $user->name,
                    "email"    => $user->email,
                    "password" => $user->password,
                ],
            ],

            [
                [
                    "name"            => 123,
                    "email"           => $user->email,
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => 123,
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->name,
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => '123',
                    "password"        => $user->password,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password"        => $user->name,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password"        => $user->password,
                    "password_repeat" => $user->name,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password"        => 123,
                    "password_repeat" => $user->password,
                ],
            ],
            [
                [
                    "name"            => $user->name,
                    "email"           => $user->email,
                    "password"        => 12345,
                    "password_repeat" => 12345,
                ],
            ],
        ];
    }

    public function testNotCanUpdate()
    {
        $this->put(route("registration.store"), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testNotCatDelete()
    {
        $this->delete(route("registration.store"), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testNotCanShow()
    {
        $this->get(route("registration.store"), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
