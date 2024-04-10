<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = $request->post();
        $user = User::find(Auth::id());
        
        try {
            $project = $user->createdProjects()->create([    
                'name' => $post['name'],
                'description' => $post['description'],
                'cost' => $post['cost'],
                'completed_jobs' => $post['completedJobs'],
                'start_time' => $post['startDate'],
                'end_time' => $post['endDate']
            ]); 

            $postUserIds = array_filter($post['users']);
            $postUserIds = array_unique($postUserIds);
            $postUsers = User::whereIn('id', $postUserIds)->get();

            $userArray = collect([$user]);
            $userArray = $userArray->merge($postUsers);

            foreach($userArray as $singleUser){
                $singleUser->projects()->attach($project);
            }

            return back()->with('message', 'Project created successfully');
        } catch (MassAssignmentException $e) {
            return back()->with('message', 'Failed to create Project');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
