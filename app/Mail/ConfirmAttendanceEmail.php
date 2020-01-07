<?php

namespace App\Mail;

use App\Organizations\Events\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmAttendanceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var EventRegistration $registration */
    private $registration;

    /**
     * Create a new message instance.
     *
     * @param EventRegistration $registration
     */
    public function __construct(EventRegistration $registration)
    {
        $this->registration = $registration;
    }

    protected function buildSubject($message)
    {
        return 'Confirm your attendance to ' . $this->registration->event->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->registration->load('event', 'event.organization');

        return $this->text('emails.text.confirm_attendance')
            ->with('event', $this->registration->event)
            ->with('confirm_by', $this->registration->waitlist_confirmation_required_by);
    }
}
