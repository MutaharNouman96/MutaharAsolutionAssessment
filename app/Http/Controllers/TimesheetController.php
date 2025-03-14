<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function index()
    {
        return Timesheet::with('user')->with('project')->get();
    }
    public function show($id)
    {
        return Timesheet::with('user')->with('project')->find($id);
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'project_id' => 'required|integer|exists:projects,id',
            'task_name'  => 'required|string|max:255',
            'date'       => 'required|date',
            'hours'      => 'required|numeric|min:0',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        if (!ProjectUser::where('project_id', $request->project_id)->where('user_id', auth()->user()->id)->first()) {
            return response()->json(['errors' => 'You are not a member of this Project. Unautorized to add the timesheet'], 403);
        }

        $timesheet = Timesheet::create(
            [
                'user_id' => auth()->id(),
                'project_id' => $request->project_id,
                'task_name' =>  $request->task_name,
                'date' =>  $request->date,
                'hours' =>  $request->hours,
            ]
        );
        return response()->json(['message' => 'Timesheet created successfully', 'timesheet' => $timesheet], 201);
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:pending,ongoing,completed',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'required',
        ]);

        $timesheet->update($request->only(['name', 'status']));


        return response()->json(['message' => 'Timesheet updated successfully', 'timesheet' => $timesheet->load('attributes')]);
    }

    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();

        return response()->json(['message' => 'Timesheet deleted successfully']);
    }
}
