<?php

namespace App\Http\Controllers\Organizations\Event;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessWaitlistForEvent;
use App\Organizations\Events\Event;
use App\Organizations\Events\EventRegistration;
use App\Organizations\Organization;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->loadMissing('organization', 'registrationOptions');
        return view('events.view', compact('event'));
    }

    public function showRegistrationForm(Request $request, Event $event)
    {
        if (!Gate::check('attend', $event)) {
            return view('generic.message', [
                'header' => 'Can\'t attend this event',
                'title' => 'Can\'t attend this event',
                'message' => 'You are currently to unable to attend this event. There might be multiple reasons for this, such as the event being full, the registration being closed, or some other reason.',
                'showLoginMessage' => true,
            ]);
        }

        $option = $event->getRegistrationOption($request->user());

        if (!$option) {
            return 'No options for registration. Either you\'re an admin on Ilmoin, or you\'ve found a bug (<a href="https://github.com/helsec/ilmoin">please report it!</a>) <!-- EventController#showRegistrationForm -->';
        }

        $confirmed = !$option->count_to_slots || $event->max_slots - $event->getTakenSlots() >= 1;

        return view('events.register', [
            'event' => $event,
            'confirmed' => $confirmed,
        ]);
    }

    public function processRegistration(Request $request, Event $event)
    {
        if (!Gate::check('attend', $event)) {
            return view('generic.message', [
                'header' => 'Can\'t attend this event',
                'title' => 'Can\'t attend this event',
                'message' => 'You are currently to unable to attend this event. There might be multiple reasons for this, such as the event being full, the registration being closed, or some other reason.',
                'showLoginMessage' => true,
            ]);
        }

        $option = $event->getRegistrationOption($request->user());

        if (!$option) {
            return 'No options for registration. Either you\'re an admin on Ilmoin, or you\'ve found a bug (<a href="https://github.com/helsec/ilmoin">please report it!</a>) <!-- EventController#processRegistration -->';
        }

        $confirmed = !$option->count_to_slots || $event->max_slots - $event->getTakenSlots() >= 1;

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $request->user()->id,
            'confirmed' => $confirmed,
            'waitlist_priority' => $option->waitlist_priority,
            'count_to_slots' => $option->count_to_slots,
        ]);

        ProcessWaitlistForEvent::dispatch($event);

        return redirect()->route('events.show', $event);
    }

    public function showConfirmForm(Event $event)
    {
        if (!Gate::check('confirm', $event)) {
            return view('generic.message', [
                'header' => 'Can\'t attend this event',
                'title' => 'Can\'t attend this event',
                'message' => 'You are currently to unable to attend this event. There might be multiple reasons for this, such as the event being full, the registration being closed, or some other reason.',
                'showLoginMessage' => true,
            ]);
        }

        return view('events.confirm', [
            'event' => $event,
        ]);
    }

    public function processConfirm(Request $request, Event $event)
    {
        if (!Gate::check('confirm', $event)) {
            return view('generic.message', [
                'header' => 'Can\'t attend this event',
                'title' => 'Can\'t attend this event',
                'message' => 'You are currently to unable to attend this event. There might be multiple reasons for this, such as the event being full, the registration being closed, or some other reason.',
                'showLoginMessage' => true,
            ]);
        }

        EventRegistration::where('user_id', $request->user()->id)
            ->update([
                'confirmed' => true,
                'waitlist_confirmation_required_by' => null,
            ]);

        ProcessWaitlistForEvent::dispatch($event);

        return redirect()->route('events.show', $event);
    }

    public function cancel(Request $request, Event $event)
    {
        if (!Gate::check('cancel', $event)) {
            return view('generic.message', [
                'header' => 'Can\'t cancel your registration to this event',
                'title' => 'Can\'t cancel your registration to this event',
                'message' => 'You are currently to unable to cancel your registration to this event.',
                'showLoginMessage' => true,
            ]);
        }

        $registration = $event->registrations()->where('user_id', $request->user()->id)->first();

        if (!$registration) {
            return 'No registration found. Either you\'re an admin on Ilmoin, or you\'ve found a bug (<a href="https://github.com/helsec/ilmoin">please report it!</a>) <!-- EventController#cancel -->';
        }

        if ($request->isMethod('post')) {
            $registration->delete();

            ProcessWaitlistForEvent::dispatch($event);

            return redirect()->route('events.show', $event);
        }

        return view('events.cancel', [
            'event' => $event,
            'registration' => $registration,
        ]);
    }
}
