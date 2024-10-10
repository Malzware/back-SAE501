<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf',function(){
    $data=[
        'users'=>User::all()
    ];
    $pdf=Pdf::loadView('invoice',$data);
    return$pdf->download('invoice.pdf');
});