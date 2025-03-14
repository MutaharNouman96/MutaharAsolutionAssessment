<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{

    public function index()
    {
        return Attribute::all();
    }

    public function show($id)
    {
        return Attribute::find($id);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:attributes,name',
            'type' => 'required|in:text,date,number,select',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $attribute = Attribute::create($request->all());

        return response()->json(['message' => 'Attribute created successfully', 'attribute' => $attribute], 201);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:attributes,name',
            'type' => 'required|in:text,date,number,select',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $attribute->update($request->all());

        return response()->json(['message' => 'Attribute updated successfully', 'attribute' => $attribute]);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json(['message' => 'Attribute deleted successfully']);
    }
}
