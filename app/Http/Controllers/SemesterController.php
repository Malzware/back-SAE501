<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return response()->json($semesters);
    }

    public function show($id)
    {
        $semester = Semester::findOrFail($id);
        return response()->json($semester);
    }

    public function store(Request $request)
    {
        $semester = Semester::create($request->all());
        return response()->json($semester, 201);
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);
        $semester->update($request->all());
        return response()->json($semester, 200);
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return response()->json(null, 204);
    }
}