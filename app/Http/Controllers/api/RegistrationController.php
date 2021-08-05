<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);
        if (!empty($inputData)) {
            $validator = Validator::make($inputData, [
                'email'           => 'required|email',
                'name'            => 'required|String',
                'password'        => 'required',
                'password_repeat' => 'required|same:password',
            ]);
            if (!$validator->fails()) {
                $inputData['password'] = bcrypt($inputData['password']);
                /** @var User $user */
                User::create($inputData);

                return response('User registration successful ', 200);
            }
        }

        return response("Validation error", 400);
    }
}
