<?php

namespace App\Http\Controllers;

use App\Models\GivenHour; // Assurez-vous que ce modèle existe et est bien configuré
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
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'user_id' => 'required|exists:users,id',
            'hours_cm' => 'required|integer',
            'hours_td' => 'required|integer',
            'hours_tp' => 'required|integer',
        ]);

        $givenHour = GivenHour::create($request->all());
        return response()->json($givenHour, 201);
    }

    public function update(Request $request, $id)
    {
        $givenHour = GivenHour::findOrFail($id);

        $request->validate([
            'hours_cm' => 'integer',
            'hours_td' => 'integer',
            'hours_tp' => 'integer',
        ]);

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
