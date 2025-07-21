<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $logoCid;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $logoUrl = asset('logo.jpg');

        \Log::info("Building Welcome Email for user: {$this->user->email}");

        return $this->subject('Welcome to HRMS of DEVELOPERS Studio!')
            ->view('emails.welcome')
            ->with([
                'name'  => $this->user->name,
                'email' => $this->user->

                email,
                'logo'  => $logoUrl
            ]);
    }

}
