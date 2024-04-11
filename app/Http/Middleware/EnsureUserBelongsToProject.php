<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserBelongsToProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $projectIds = Auth::user()->projects->pluck('id')->toArray();
        $projectId = $request->route('project')->id;
        
        if($projectId == null || !in_array($projectId, $projectIds)){
            return redirect('/home');
        }
        return $next($request);
    }
}
