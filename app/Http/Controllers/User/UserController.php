<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;

class UserController extends Controller
{
    protected $users;
    
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function index() {
        // $users = User::all();
        $users = $this->users->all();
        return UserResource::collection($users);
    }
}