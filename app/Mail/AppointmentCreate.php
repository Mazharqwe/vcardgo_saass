<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentCreate extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;
    public $settings;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $settings)
    {

        $this->appointment = $appointment;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->settings['from_email'], $this->settings['company_email_from_name'])->view('email.appointment_create')->subject('Appointment details - '.env('APP_NAME'))->with('appointment', $this->appointment)->subject('Ragarding new appointment.');
    }
}
