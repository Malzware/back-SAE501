<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PreviewController extends Controller
{
    public function generatePreviewUrl(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        try {
            // Check if user exists
            $user = User::where('email', $request->email)->firstOrFail();

            // Create payload with expiration
            $payload = [
                'email' => $request->email,
                'expires' => now()->addHours(24)->timestamp // URL expires in 24 hours
            ];

            // Encrypt the payload
            $encryptedPayload = Crypt::encrypt($payload);

            // Generate the preview URL
            $previewUrl = route('preview.pdf', ['payload' => $encryptedPayload]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'url' => $previewUrl
                ]);
            }

            // If it's a web request, return to the view with the URL
            return back()->with('success', 'Preview URL generated successfully'.$previewUrl)
                        ->with('previewUrl', $previewUrl);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate preview URL: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to generate preview URL: ' . $e->getMessage());
        }
    }

function generatePreviewPdf($payload)
    {
        try {
            $data = Crypt::decrypt($payload);
            
            if (Carbon::createFromTimestamp($data['expires'])->isPast()) {
                return response()->json(['error' => 'Preview link has expired'], 403);
            }

            $user = User::with([
                'roles',
                'givenHours.resource.semester',
                'resources'
            ])->where('email', $data['email'])->firstOrFail();

            $viewData = [
                'user' => $user,
                'roles' => $user->roles->pluck('name')->unique(),
                'givenHours' => $user->givenHours->groupBy('resource_id')->map(function($hours) {
                    $resource = $hours->first()->resource;
                    return [
                        'resource_name' => $resource->name,
                        'resource_code' => $resource->code,
                        'semester' => $resource->semester->name ?? 'N/A',
                        'total_cm' => $hours->sum('hours_cm'),
                        'total_td' => $hours->sum('hours_td'),
                    ];
                }),
                'generated_at' => now()
            ];

            $pdf = PDF::loadView('recrutement', $viewData);
            
            // Save temporary PDF for preview
            $tempPath = 'temp/' . uniqid() . '.pdf';
            Storage::put('public/' . $tempPath, $pdf->output());

            return response()->json([
                'success' => true,
                'pdfUrl' => Storage::url($tempPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired preview link'
            ], 403);
        }
    }

    public function saveSignedPdf(Request $request)
    {
        $request->validate([
            'payload' => 'required',
            'signature' => 'required'
        ]);

        try {
            $data = Crypt::decrypt($request->payload);
            
            if (Carbon::createFromTimestamp($data['expires'])->isPast()) {
                return response()->json(['error' => 'Link has expired'], 403);
            }

            $user = User::where('email', $data['email'])->firstOrFail();

            // Process signature
            $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature);
            $imageData = base64_decode($base64Image);
            
            $filename = 'signature_' . time() . '.png';
            Storage::put('public/signatures/' . $filename, $imageData);

            // Generate final PDF with signature
            $viewData = [
                // ... same as generatePreviewPdf ...
                'signature_path' => storage_path('app/public/signatures/' . $filename)
            ];

            $pdf = PDF::loadView('recrutement', $viewData);
            
            // Store signed PDF
            $pdfName = 'signed_' . $user->lastname . '_' . date('Y-m-d') . '.pdf';
            $pdfPath = 'signed-pdf/' . $pdfName;
            Storage::put('public/' . $pdfPath, $pdf->output());

            // Clean up signature file
            Storage::delete('public/signatures/' . $filename);

            return response()->json([
                'success' => true,
                'downloadUrl' => Storage::url($pdfPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save signed PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}