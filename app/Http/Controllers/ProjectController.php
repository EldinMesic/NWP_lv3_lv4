<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
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
    public function show(Project $project)
    {
        $users = User::query()->orderBy('name', 'asc')->get()->except(Auth::id());
        $isCreator = $project->creator->id === Auth::id();
        return view('project.show', ['project' => $project, 'users' => $users, 'isCreator' => $isCreator]);
    }
    public function update(Request $request, Project $project)
    {
        $post = $request->post();
        try {
            if($request->filled(['name', 'cost', 'startDate'])){
                $project->update([
                    'name' => $post['name'],
                    'description' => $post['description'],
                    'cost' => $post['cost'],
                    'completed_jobs' => $post['completedJobs'],
                    'start_time' => $post['startDate'],
                    'end_time' => $post['endDate']
                ]);
                $postUserIds = array_filter($post['users']);
                $postUserIds[] = Auth::id();
                $postUserIds = array_unique($postUserIds);
                $project->users()->sync($postUserIds);
            }else{
                $project->update(['completed_jobs' => $post['completedJobs']]);
            }
            
            return redirect()->route('project.show', $project)->with('message', 'Project updated successfully');
        } catch (MassAssignmentException $e) {
            return back()->with('message', 'Failed to update Project');
        }
        
    }
}
