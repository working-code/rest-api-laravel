<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @OA\Post  (
     *     path="/api/registration",
     *     tags={"User"},
     *     description="Registration user",
     *
     *     @OA\RequestBody(
     *       required=true,
     *          @OA\JsonContent(
     *              required={"name","email", "password", "c_password"},
     *          @OA\Property(property="name", type="string", example="bestUser"),
     *          @OA\Property(property="email", type="string", example="bestuser@mail.ru"),
     *          @OA\Property(property="password", type="string", example="64Qd*7"),
     *          @OA\Property(property="password_repeat", type="string", example="64Qd*7"),
     *          ),
     *      ),
     *
     *     @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *               @OA\Property(property="data", type="object",
     *                       @OA\Property(property="id", type="string", example=777),
     *                       @OA\Property(property="name", type="string", example="bestUser"),
     *                       @OA\Property(property="email", type="string", example="bestuser@mail.ru"),
     *                       @OA\Property(property="created_at", type="string", example="2021-08-08T12:06:54.000000Z"),
     *                       @OA\Property(property="updated_at", type="string", example="2021-08-08T12:06:54.000000Z"),
     *                      ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error"),
     *              @OA\Property(property="errors", type="object",
     *              )
     *          )
     *     ),
     * )
     */
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
