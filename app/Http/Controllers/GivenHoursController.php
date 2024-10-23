<?php

namespace App\Http\Controllers;

use App\Models\GivenHour;
use Illuminate\Http\Request;

class GivenHoursController extends Controller
{
    public function index()
    {
        $givenHours = GivenHour::all();
        return response()->json($givenHours);
    }

    public function show($id)
    {
        $givenHour = GivenHour::findOrFail($id);
        return response()->json($givenHour);
    }

    public function store(Request $request)
    {
        $givenHour = GivenHour::create($request->all());
        return response()->json($givenHour, 201);
    }

    public function update(Request $request, $id)
    {
        $givenHour = GivenHour::findOrFail($id);
        $givenHour->update($request->all());
        return response()->json($givenHour, 200);
    }

    public function destroy($id)
    {
        $givenHour = GivenHour::findOrFail($id);
        $givenHour->delete();
        return response()->json(null, 204);
    }
}
