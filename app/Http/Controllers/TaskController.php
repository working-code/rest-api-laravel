<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected const COUNT_PER_PAGE = 15;

    /**
     * @OA\Get (
     *     path="/api/v1/tasks",
     *     tags={"Tasks"},
     *     security={{"passport":{}}},
     *     description="Returns list tasks",
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                       @OA\Property(property="id", type="string", example=70),
     *                       @OA\Property(property="name", type="string", example="Super task"),
     *                       @OA\Property(property="description", type="string", example="Description super task"),
     *                       @OA\Property(property="created_at", type="string", example="2021-08-08T12:06:54.000000Z"),
     *                       @OA\Property(property="updated_at", type="string", example="2021-08-08T12:06:54.000000Z"),
     *                      ),
     *                       @OA\Property(property="links", type="object",
     *                          @OA\Property(property="first", type="string", example="http://rest-api-laravel.test/api/v1/tasks?page=1"),
     *                          @OA\Property(property="last", type="string", example="http://rest-api-laravel.test/api/v1/tasks?page=7"),
     *                          @OA\Property(property="prev", type="string", example="null"),
     *                           @OA\Property(property="next", type="string", example="http://rest-api-laravel.test/api/v1/tasks?page=2"),
     *                      ),
     *                      @OA\Property(property="meta", type="object"),
     *                      @OA\Property(property="path", type="object"),
     *             ),
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthenticated"),
     *          )
     *     )
     * )
     */
    public function index(Task $task): JsonResponse
    {
        return (TaskResource::collection($task->paginate(self::COUNT_PER_PAGE)))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Post  (
     *     path="/api/v1/tasks",
     *     tags={"Tasks"},
     *     security={{"passport":{}}},
     *     description="Create task",
     *
     *     @OA\RequestBody(
     *       required=true,
     *          @OA\JsonContent(
     *              required={"name","description"},
     *          @OA\Property(property="name", type="string", example="Super task"),
     *          @OA\Property(property="description", type="string", example="Description super task"),
     *          ),
     *      ),
     *
     *     @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *               @OA\Property(property="data", type="object",
     *                       @OA\Property(property="id", type="string", example=70),
     *                       @OA\Property(property="name", type="string", example="Super task"),
     *                       @OA\Property(property="description", type="string", example="Description super task"),
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
     *                  @OA\Property(property="name", type="string", example="The name field is required."),
     *                  @OA\Property(property="description", type="string", example="The description field is required.")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthenticated"),
     *            )
     *     )
     * )
     */
    public function store(TaskRequest $request, Task $task): JsonResponse
    {
        $task->fill($request->only(['name', 'description',]));
        $task->save();

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
