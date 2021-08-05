<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::all();

        return response()->json($task->toArray(), 200);
    }

    public function store(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);
        if (!empty($inputData)) {
            $validator = Validator::make($inputData, [
                'name'        => 'String',
                'description' => 'String',
            ]);
            if (!$validator->fails()) {
                /** @var Task $task */
                Task::create($inputData);

                return response('Ресурс Task', 201);
            }
        }

        return response('Ошибка валидации', 400);
    }
}
