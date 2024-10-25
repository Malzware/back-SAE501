<?php

use App\Http\Controllers\SignatureController;
use App\Http\Controllers\PreviewController;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::get('/admin/generate-url', [PreviewController::class, 'showGenerateForm'])->name('show.generate.form');
Route::post('/admin/generate-url', [PreviewController::class, 'generatePreviewUrl'])->name('generate.preview.url');

// User routes
Route::get('/preview/{payload}', [PreviewController::class, 'showPreview'])->name('show.preview');
Route::get('/preview-pdf/{payload}', [PreviewController::class, 'generatePdf'])->name('preview.pdf');
Route::post('/submit-signature', [PreviewController::class, 'submitSignature'])->name('submit.signature');

Route::post('/pdf', function(Request $request) {
    // Validate form data
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    try {
        // Find user with all relationships
        // Note: Changed GivenHours to GivenHour to match your model
        $user = User::with([
            'roles',
            'givenHours.resource.semester',
            'resources'
        ])->where('email', $request->email)->firstOrFail();

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
                    'total_tp' => $hours->sum('hours_tp'),
                ];
            }),
            'generated_at' => now(),
        ];

        // For debugging - remove this in production
        // dd($data);

        // Generate PDF token
        $pdfToken = \Str::random(32);
        
        // Create PDF record
        $user->pdfs()->create([
            'pdf_name' => 'Teaching_Report_' . $user->lastname . '_' . date('Y-m-d'),
            'pdf_path' => 'pdfs/' . $pdfToken . '.pdf',
            'pdf_token' => $pdfToken,
            'signed' => false
        ]);

        // Load and generate PDF
        $pdf = PDF::loadView('test', $data);
        
        return $pdf->stream('test' . $user->lastname . '_' . date('Y-m-d') . '.pdf');
        //return $pdf->download('Teaching_Report_' . $user->lastname . '_' . date('Y-m-d') . '.pdf');
    } catch (\Exception $e) {
        \Log::error('PDF Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
    }
})->name('generate.pdf');

Route::post('send-signature', [SignatureController::class, 'sendSignature'])->name('send.signature');

Route::prefix('api')->group(function () {
    Route::post('/generate-preview-url', [PreviewController::class, 'generatePreviewUrl']);
    Route::get('/preview-pdf/{payload}', [PreviewController::class, 'generatePreviewPdf']);
    Route::post('/save-signed-pdf', [PreviewController::class, 'saveSignedPdf']);
});