<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Responses;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller {

    protected $user;
    protected $jwt;

    public function __construct(User $user, JWTAuth $jwt)
    {
        $this->user = $user;
        $this->jwt = $jwt;
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

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return Responses::notFound(['user_not_found']);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return Responses::internalError(['token_expired']);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return Responses::internalError(['token_invalid']);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return Responses::internalError(['token_absent' => $e->getMessage()]);

        }

        return Responses::json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = $this->jwt->parseToken()->authenticate()) {
                return Responses::notFound(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return Responses::json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return Responses::json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return Responses::json(['token_absent'], $e->getStatusCode());

        }

        return Responses::json(compact('user'));
    }
}