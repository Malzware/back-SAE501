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

Route::post('/pdf', function(Request $request) {
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

    // Load the Blade view and pass the form data
    // $pdf = Pdf::loadView('recrutement', $data);

    // Return the PDF as a downloadable file
    // return $pdf->download('recrutement.pdf');
    // return $pdf->stream('recrutement.pdf');

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
})->name('generate.pdf');
