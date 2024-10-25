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
            $user = User::where('email', $request->email)->firstOrFail();

            $payload = [
                'email' => $request->email,
                'expires' => now()->addHours(24)->timestamp
            ];

            $encryptedPayload = Crypt::encrypt($payload);
            
            // Get frontend URL from environment
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:4200'); // Changed to Angular's default port
            $previewUrl = $frontendUrl . '/pdf-preview/' . urlencode($encryptedPayload);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'url' => $previewUrl,
                    'message' => 'Preview URL generated successfully'
                ]);
            }

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

    public function getPreviewPdf($payload)
    {
        try {
            $data = Crypt::decrypt($payload);
            
            if (Carbon::createFromTimestamp($data['expires'])->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preview link has expired'
                ], 403);
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
            
            // Save temporary PDF for preview with a unique identifier
            $tempPath = 'temp/preview_' . uniqid() . '.pdf';
            Storage::put('public/' . $tempPath, $pdf->output());

            return response()->json([
                'success' => true,
                'pdfUrl' => Storage::url($tempPath),
                'userData' => $viewData,
                'message' => 'PDF generated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveSignedPdf(Request $request)
    {
        $request->validate([
            'payload' => 'required',
            'signature' => 'required|string'
        ]);

        try {
            $data = Crypt::decrypt($request->payload);
            
            if (Carbon::createFromTimestamp($data['expires'])->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Link has expired'
                ], 403);
            }

            $user = User::where('email', $data['email'])->firstOrFail();

            // Process signature
            $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature);
            $imageData = base64_decode($base64Image);
            
            $filename = 'signature_' . time() . '.png';
            Storage::put('public/signatures/' . $filename, $imageData);

            // Generate final PDF with signature
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
                'generated_at' => now(),
                'signature_path' => storage_path('app/public/signatures/' . $filename)
            ];

            $pdf = PDF::loadView('recrutement', $viewData);
            
            // Store signed PDF with user's name and timestamp
            $pdfName = 'signed_' . $user->lastname . '_' . date('Y-m-d_His') . '.pdf';
            $pdfPath = 'signed-pdf/' . $pdfName;
            Storage::put('public/' . $pdfPath, $pdf->output());

            // Clean up signature file
            Storage::delete('public/signatures/' . $filename);

            // Clean up any temporary preview files
            foreach (Storage::files('public/temp') as $file) {
                if (Carbon::createFromTimestamp(Storage::lastModified($file))->addHour()->isPast()) {
                    Storage::delete($file);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'PDF signed and saved successfully',
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