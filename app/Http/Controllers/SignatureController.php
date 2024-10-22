<?php

namespace App\Http\Controllers;

use App\Mail\SignatureMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    public function sendSignature(Request $request)
    {
        $request->validate([
            'signature' => ['required']
        ]);

        try {
            // Clean up the base64 image string
            $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature);
            $imageData = base64_decode($base64Image);
            
            // Generate unique filename
            $filename = 'signature_' . time() . '.png';
            $fileWithPath = 'public/storage/images/' . $filename;

            // Store the image
            Storage::put($fileWithPath, $imageData);

            return redirect('/')->with('success', 'Signature saved successfully!');
            
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Failed to save signature: ' . $e->getMessage());
        }
    }
}