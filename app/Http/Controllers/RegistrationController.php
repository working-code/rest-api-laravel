<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request, User $user): JsonResponse
    {
        $user->fill($request->only(['email', 'password', 'name']));
        $user->password = bcrypt($user->password);
        $user->save();

        return (new RegistrationResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
