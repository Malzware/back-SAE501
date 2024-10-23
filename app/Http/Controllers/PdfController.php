<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function index()
    {
        $pdfs = Pdf::all();
        return response()->json($pdfs);
    }

    public function show($id)
    {
        $pdf = Pdf::findOrFail($id);
        return response()->json($pdf);
    }

    public function store(Request $request)
    {
        $pdf = Pdf::create($request->all());
        return response()->json($pdf, 201);
    }

    public function update(Request $request, $id)
    {
        $pdf = Pdf::findOrFail($id);
        $pdf->update($request->all());
        return response()->json($pdf, 200);
    }

    public function destroy($id)
    {
        $pdf = Pdf::findOrFail($id);
        $pdf->delete();
        return response()->json(null, 204);
    }
}
