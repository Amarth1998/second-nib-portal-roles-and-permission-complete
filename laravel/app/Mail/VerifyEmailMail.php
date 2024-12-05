<?php
namespace App\Mail;

use App\Models\Posp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $posp;

    public function __construct(Posp $posp)
    {
        $this->posp = $posp;
    }

    public function build()
    {
        // Generate a verification token
        $token = sha1($this->posp->email);

        // Create a verification link
        $verificationLink = route('posp.verify-email', ['id' => $this->posp->id, 'token' => $token]);

        return $this->subject('Email Verification')->view('emails.verify_email', [
            'name' => $this->posp->name,
            'verificationLink' => $verificationLink
        ]);
    }
}
