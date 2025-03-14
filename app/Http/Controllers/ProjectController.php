<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectAttributeValue;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        // return Project::with('attributes')->get();
        $query = Project::query();

        // Check if there are filters in the request
        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                // Check if the filter is for a standard column in projects table
                if (in_array($key, ['name', 'status'])) {
                    $this->applyFilter($query, $key, $value);
                } else {
                    // Otherwise, filter using the EAV structure , calling as subquery from project_attribute_values
                    $query->whereHas('attributeValues', function ($attrQuery) use ($key, $value) {
                        $attrQuery->whereHas('attribute', function ($attributeQuery) use ($key) {
                            $attributeQuery->where('name', $key);
                        });

                        // Apply the filter condition, attrQuery is the subquery from project_attribute_values
                        $this->applyFilter($attrQuery, 'value', $value);
                    });
                }
            }
        }

        return response()->json($query->with('attributes')->get());
    }

    //filter to query function 
    private function applyFilter($query, $column, $value)
    {
        if (is_array($value)) {
            // Handle operators like >, <, LIKE
            foreach ($value as $operator => $val) {
                if (in_array($operator, ['=', '>', '<', 'LIKE'])) {
                    $query->where($column, $operator, $val); // appending in the given query
                }
            }
        } else {
            // Default to '=' if no operator is specified
            $query->where($column, '=', $value);
        }
    }







    public function show($id)
    {
        return Project::with('attributes')->find($id);
    }
    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|in:0,1,2,3',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $project = Project::create($request->only(['name', 'status']));

        if ($request->has('attributes')) {
            foreach ($request->get("attributes") as $attribute) {
                ProjectAttributeValue::create([
                    'project_id' => $project->id,
                    'attribute_id' => $attribute['id'],
                    'value' => $attribute['value'],
                ]);
            }
        }

        return response()->json(['message' => 'Project created successfully', 'project' => $project->load('attributes')], 201);
    }

    public function update(Request $request, Project $project)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|in:0,1,2,3',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $project->update($request->only(['name', 'status']));

        if ($request->has('attributes')) {
            foreach ($request->attributes as $attribute) {
                ProjectAttributeValue::updateOrCreate(
                    ['project_id' => $project->id, 'attribute_id' => $attribute['id']],
                    ['value' => $attribute['value']]
                );
            }
        }

        return response()->json(['message' => 'Project updated successfully', 'project' => $project->load('attributes')]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
