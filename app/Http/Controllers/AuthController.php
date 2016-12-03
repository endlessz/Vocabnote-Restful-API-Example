<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\User;

use App\Helpers\Responses;

class AuthController extends Controller {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|unique:users|email|max:255',
            'username'  => 'required|unique:users|alpha_dash|max:20',
            'password'  => 'required|min:6',
        ]);

        if ($validator->errors()->count()) {
            return Responses::badRequest($validator->errors());
        }

        $user = $this->user->createUser($request);

        return Responses::json($user);
    }
}