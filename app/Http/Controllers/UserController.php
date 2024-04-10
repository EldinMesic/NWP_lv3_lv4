<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('name', 'asc')->get();
        return view('user.index', ['users' => $users]);
    }
    public function getUsers(){
        $users = User::query()->orderBy('name', 'asc')->get();
        return response()->json($users);
    }
}
