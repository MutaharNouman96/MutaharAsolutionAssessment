<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ProjectUser::with('project')->with('user')->get();
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
        //
        $validation = Validator::make($request->all(), [
            'project_id' => 'required|integer|exists:projects,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        try {
            if (ProjectUser::where('project_id', $request->project_id)->where('user_id', $request->user_id)->first()) {
                return response()->json(['errors' => 'User already assigned to this project'], 422);
            }

            $projectUser = ProjectUser::create($request->all());

            return response()->json(['message' => 'ProjectUser created successfully', 'projectUser' => $projectUser], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectUser $projectUser)
    {
        //
        return $projectUser::with('project')->with('user')->find($projectUser->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectUser $projectUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectUser $projectUser)
    {
        //
        $projectUser->delete();

        return response()->json(['message' => 'ProjectUser deleted successfully']);
    }
}
