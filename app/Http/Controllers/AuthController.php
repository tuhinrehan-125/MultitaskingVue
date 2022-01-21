<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request){
        // dd("You hit register");
        // $this->validate($request, [
        //     'email' => 'email|required|unique:users,email',
        //     'name' => 'required',
        //     'password' => 'required|min:6'
        // ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return abort(401);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ],
        ]);
    }

    public function login(UserLoginRequest $request){
        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return response()->json([
                'errors' => [
                    'email' => ['Sorry we cant find you with those details.'],
                ],
            ], 422);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ],
        ]);
    }

    public function user(Request $request){
        return new UserResource($request->user());
    }

    public function logout(){
        auth()->logout();
    }
}