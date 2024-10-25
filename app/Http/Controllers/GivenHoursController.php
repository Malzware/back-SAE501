<?php

namespace App\Http\Controllers;

use App\Models\GivenHour;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GivenHoursController extends Controller
{
    // Display a listing of the given hours
    
    public function index()
    {
        $givenHours = GivenHour::with(['resource', 'user'])->get();
        return response()->json($givenHours, Response::HTTP_OK);
    }

    // Show the form for creating a new given hour
    public function create()
    {
        $resources = Resource::all();
        $users = User::all();
        return response()->json(['resources' => $resources, 'users' => $users], Response::HTTP_OK);
    }

    // Store a newly created given hour in storage
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'user_id' => 'required|exists:users,id',
            'hours_cm' => 'nullable|integer',
            'hours_td' => 'nullable|integer',
            'hours_tp' => 'nullable|integer',
            'comment' => 'nullable|string',
        ]);

        $givenHour = GivenHour::create($request->all());
        return response()->json($givenHour, Response::HTTP_CREATED);
    }

    // Display the specified given hour
    public function show($id)
    {
        $givenHour = GivenHour::with(['resource', 'user'])->find($id);

        if (!$givenHour) {
            return response()->json(['error' => 'GivenHour not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($givenHour, Response::HTTP_OK);
    }

    // Show the form for editing the specified given hour
    public function edit($id)
    {
        $givenHour = GivenHour::find($id);
        if (!$givenHour) {
            return response()->json(['error' => 'GivenHour not found'], Response::HTTP_NOT_FOUND);
        }

        $resources = Resource::all();
        $users = User::all();
        return response()->json([
            'givenHour' => $givenHour,
            'resources' => $resources,
            'users' => $users,
        ], Response::HTTP_OK);
    }

    // Update the specified given hour in storage
    public function update(Request $request, $id)
    {
        $givenHour = GivenHour::find($id);

        if (!$givenHour) {
            return response()->json(['error' => 'GivenHour not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'user_id' => 'required|exists:users,id',
            'hours_cm' => 'nullable|integer',
            'hours_td' => 'nullable|integer',
            'hours_tp' => 'nullable|integer',
            'comment' => 'nullable|string',
        ]);

        $givenHour->update($request->all());
        return response()->json($givenHour, Response::HTTP_OK);
    }

    // Remove the specified given hour from storage
    public function destroy($id)
    {
        $givenHour = GivenHour::find($id);

        if (!$givenHour) {
            return response()->json(['error' => 'GivenHour not found'], Response::HTTP_NOT_FOUND);
        }

        $givenHour->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}