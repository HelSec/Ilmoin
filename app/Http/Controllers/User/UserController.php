<?php

namespace App\Http\Controllers\User;

use App\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('users.view', ['user' => $user]);
    }
}
