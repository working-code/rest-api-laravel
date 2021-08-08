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

    public function index(Task $task): JsonResponse
    {
        return (TaskResource::collection($task->paginate(self::COUNT_PER_PAGE)))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(TaskRequest $request, Task $task): JsonResponse
    {
        $task->fill($request->only(['name', 'description',]));
        $task->save();

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
