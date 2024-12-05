<?php

namespace App\Http\Controllers\POSP;
use App\Http\Controllers\Controller;

use App\Models\Posp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;

class PospController extends Controller
{
    /**
     * Stage 1: Basic Registration
     */
    public function basicRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|unique:posps',
            'email' => 'required|email|unique:posps',
            'pancard_number' => 'required|string|unique:posps',
            'login_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $posp = Posp::create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'pancard_number' => $request->pancard_number,
            'login_password' => Hash::make($request->login_password),
            'email_verified' => false,
            'active' => true,
        ]);

     // Fire Registered Event to send verification email
event(new Registered($posp));

// Send the email verification link
Mail::to($posp->email)->send(new VerifyEmailMail($posp));

return response()->json(['message' => 'Basic registration successful. Please verify your email.'], 201);

    }

    /**
     * Email Verification
     */
    public function verifyEmail(Request $request)
    {
        $posp = Posp::find($request->id);
    
        if (!$posp || sha1($posp->email) !== $request->token) {
            return response()->json(['message' => 'Invalid or expired verification link.'], 400);
        }
    
        $posp->email_verified = true;
        $posp->save();
    
        return response()->json(['message' => 'Email verified successfully.'], 200);
    }
    




// public function documentSubmission(Request $request)
// {
//     // Validate the incoming request
//     $validator = Validator::make($request->all(), [
//         'date_of_birth' => 'required|date',
//         'gender' => 'required|string',
//         'street' => 'required|string',
//         'city' => 'required|string',
//         'state' => 'required|string',
//         'pincode' => 'required|string',
//         'aadharcard_number' => 'required|string|size:12',  // Aadhar card number
//         'pancard_number' => 'required|string|size:10',     // Pan card number
//         'education' => 'required|string',                   // Education level

//         'aadharcard_pdf' => 'required|file|mimes:pdf|max:2048',
//         'pancard_pdf' => 'required|file|mimes:pdf|max:2048',
//         'marksheet_pdf' => 'required|file|mimes:pdf|max:2048',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     // Check if user is authenticated
//     $posp = Auth::user();

//     if (!$posp) {
//         return response()->json(['error' => 'User not authenticated.'], 401);
//     }

//     // Save uploaded files
//     $aadharPath = $request->file('aadharcard_pdf')->store("documents/{$posp->id}");
//     $panPath = $request->file('pancard_pdf')->store("documents/{$posp->id}");
//     $marksheetPath = $request->file('marksheet_pdf')->store("documents/{$posp->id}");

//     // Update POSP details with the new fields
//     $posp->update([
//         'date_of_birth' => $request->date_of_birth,
//         'gender' => $request->gender,
//         'street' => $request->street,
//         'city' => $request->city,
//         'state' => $request->state,
//         'pincode' => $request->pincode,
//         'aadharcard_number' => $request->aadharcard_number,
//         'pancard_number' => $request->pancard_number,
//         'education' => $request->education,
//         'aadharcard_pdf' => $aadharPath,
//         'pancard_pdf' => $panPath,
//         'marksheet_pdf' => $marksheetPath,
//     ]);

//     return response()->json(['message' => 'Documents submitted successfully.'], 200);
// }


public function documentSubmission(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'date_of_birth' => 'required|date',
        'gender' => 'required|string',
        'street' => 'required|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'pincode' => 'required|string',
        'aadharcard_number' => 'required|string|size:12',  // Aadhar card number
        'pancard_number' => 'required|string|size:10',     // Pan card number
        'education' => 'required|string',                   // Education level

        'aadharcard_pdf' => 'required|file|mimes:pdf|max:2048',
        'pancard_pdf' => 'required|file|mimes:pdf|max:2048',
        'marksheet_pdf' => 'required|file|mimes:pdf|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Check if user is authenticated
    $posp = Auth::user();

    if (!$posp) {
        return response()->json(['error' => 'User not authenticated.'], 401);
    }

    // Generate the folder path dynamically
    $folderPath = "public/documents/{$posp->id}_{$posp->name}";

    // Ensure the folder exists
    $storagePath = storage_path('app/' . $folderPath);
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true); // Create folder with permissions if it doesn't exist
    }

    // Save uploaded files to the custom folder
    $aadharPath = $request->file('aadharcard_pdf')->storeAs($folderPath, 'aadharcard.pdf');
    $panPath = $request->file('pancard_pdf')->storeAs($folderPath, 'pancard.pdf');
    $marksheetPath = $request->file('marksheet_pdf')->storeAs($folderPath, 'marksheet.pdf');

    // Update POSP details with the new fields
    $posp->update([
        'date_of_birth' => $request->date_of_birth,
        'gender' => $request->gender,
        'street' => $request->street,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'aadharcard_number' => $request->aadharcard_number,
        'pancard_number' => $request->pancard_number,
        'education' => $request->education,
        'aadharcard_pdf' => $aadharPath,
        'pancard_pdf' => $panPath,
        'marksheet_pdf' => $marksheetPath,
    ]);

    return response()->json(['message' => 'Documents submitted successfully.'], 200);
}



    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'login_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $posp = Posp::where('email', $request->email)->first();

        if (!$posp || !Hash::check($request->login_password, $posp->login_password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        if (!$posp->email_verified) {
            return response()->json(['message' => 'Email not verified.'], 403);
        }

        // Generate token (assuming you're using Laravel Sanctum or Passport for API authentication)
        $token = $posp->createToken('POSPToken')->plainTextToken;

        return response()->json(['message' => 'Login successful.', 'token' => $token], 200);
    }
}
