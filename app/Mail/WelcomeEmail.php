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

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        \Log::info("Building Welcome Email for user: {$this->user->email}");

        $htmlContent = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome Email</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f8f9fa;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    padding: 20px;
                }
                .content {
                    padding: 20px;
                    text-align: center;
                }
                .content h1 {
                    color: #333333;
                    font-size: 24px;
                    margin-bottom: 10px;
                }
                .content p {
                    color: #555555;
                    font-size: 16px;
                    margin-bottom: 20px;
                }
                .btn {
                    display: inline-block;
                    background-color: #28a745;
                    color: #ffffff !important;
                    padding: 12px 20px;
                    font-size: 16px;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 14px;
                    color: #888888;
                }
            </style>
        </head>
        <body>
        <div class="email-container">
            <div class="content">
                <h1>Welcome to HRMS of the Developers Studio, ' . htmlspecialchars($this->user->name) . '!</h1>
                <p>Your account has been successfully created. Use your registered email to log in:</p>
                <p><strong>' . htmlspecialchars($this->user->email) . '</strong></p>
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' HRMS – Developers Studio. All rights reserved.</p>
            </div>
        </div>
        </body>
        </html>';

        return $this->subject('Welcome to HRMS of DEVELOPERS Studio!')
            ->html($htmlContent);
    }
}
