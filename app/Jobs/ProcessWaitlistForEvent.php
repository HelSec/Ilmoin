<?php

namespace App\Jobs;

use App\Mail\ConfirmAttendanceEmail;
use App\Organizations\Events\Event;
use App\Organizations\Events\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessWaitlistForEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Event */
    protected $event;

    /**
     * Create a new job instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event->unsetRelation('registrationOptions')->unsetRelation('organization')->unsetRelation('registrations');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slotsAvailable = $this->event->max_slots - $this->event->getTakenSlots();
        $waitlist = $this->event->registrations()
            ->where('confirmed', false)
            ->where('waitlist_confirmation_required_by', null)
            ->orderByDesc('waitlist_priority')
            ->orderBy('created_at')
            ->limit($slotsAvailable)
            ->with('user')
            ->get();

        $waitlist->each(function (EventRegistration $registration) {
            $registration->waitlist_confirmation_required_by = now()->addDays(3);
            $registration->save();

            Mail::to($registration->user)
                ->send(new ConfirmAttendanceEmail($registration));
        });
    }
}
