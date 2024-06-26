<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $createdProjects = $user->createdProjects;
        $projects = $user->projects;
        $projects = $projects->diff($createdProjects);
        //$projects = $user->projects;
        $users = User::all()->except($user->id);
        return view('home', [
            'users' => $users, 
            'createdProjects' => $createdProjects,
            'projects' => $projects
        ]);
    }
}
