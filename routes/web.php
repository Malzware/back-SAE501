<?php

use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/pdf',function(){
//     $data=[
//         'users'=>User::all(),
//         // 'resources' =>Resource::all()
//     ];
//     $pdf=Pdf::loadView('recrutement',$data);
//     return$pdf->download('recrutement.pdf');
// });

/*Route::post('/pdf', function(Request $request) {
    // Validate form data
    $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    // Collect form data    
    $data = [
        'firstname' => $request->input('firstname'),
        'lastname' => $request->input('lastname'),
        'email' => $request->input('email'),
        'users' => User::all(),  // Any other data you want to include in the PDF
    ];

    try {
        // Load the Blade view and pass the form data
        $pdf = PDF::loadView('test', $data);
        
        // Return the PDF as a downloadable file
        // return $pdf->download('recrutement.pdf');
        return $pdf->stream('test.pdf');
    } catch (\Exception $e) {
        // Log the error and return a response
        \Log::error('PDF Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Failed to generate PDF. Please try again.');
    }
})->name('generate.pdf');*/

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