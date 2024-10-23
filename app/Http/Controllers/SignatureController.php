<?php

namespace App\Http\Controllers;

use App\Mail\SignatureMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    public function sendSignature(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'signature' => 'required'
        ]);

        try {
            // Find user with all relationships
            // Note: Changed GivenHours to GivenHour to match your model
            $user = User::with([
                'roles',
                'givenHours.resource.semester',
                'resources'
            ])->where('email', $request->email)->firstOrFail();

            // Clean up the base64 image string
            $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature);
            $imageData = base64_decode($base64Image);
            
            // Generate unique filename
            $filename = 'signature_' . time() . '.png';
            $fileWithPath = 'public/images/' . $filename;

            // Store the image
            Storage::put($fileWithPath, $imageData);

                    // Calculate totals and prepare data
        $data = [
            'user' => $user,
            'roles' => $user->roles->pluck('name')->unique(),
            'givenHours' => $user->givenHours->groupBy('resource_id')->map(function($hours) {
                $resource = $hours->first()->resource;
                return [
                    'resource_name' => $resource->name,
                    'resource_code' => $resource->resource_code,
                    'semester' => $resource->semester->name ?? 'N/A',
                    'total_cm' => $hours->sum('hours_cm'),
                    'total_td' => $hours->sum('hours_td'),
                ];
            }),
            'generated_at' => now(),
            'signaturePath' => Storage::path($fileWithPath)
        ];

            $pdfToken = \Str::random(32);

            // Create PDF record
        $user->pdfs()->create([
            'pdf_name' => 'Teaching_Report_' . $user->lastname . '_' . date('Y-m-d'),
            'pdf_path' => 'pdfs/' . $pdfToken . '.pdf',
            'pdf_token' => $pdfToken,
            'signed' => true
        ]);

            // Generate PDF
            $pdf = PDF::loadView('test', $data);
            
            // Delete the temporary signature file
            Storage::delete($fileWithPath);

        return $pdf->stream('test' . $user->lastname . '_' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Failed to save signature: ' . $e->getMessage());
        }
    }
}