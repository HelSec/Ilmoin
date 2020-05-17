<?php

namespace App\Http\Controllers\Organizations\Event;

use App\Http\Controllers\Controller;
use App\Organizations\Events\Event;
use Composer\DependencyResolver\Transaction;
use App\Organizations\Events\EventRegistration;
use App\Organizations\Events\EventRegistrationOption;
use App\Organizations\Organization;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Organizations\Events\EventRegistrationOptionRequiredGroup;

class EventAdminController extends Controller
{
    public function create(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('events.admin.create', [
            'organizations' => Organization::all()
                ->filter(fn (Organization $organization) => $user->can('manage', $organization)),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|min:3',
            'description' => 'required',
            'date' => 'required|date|after:now',
            'location' => 'required|min:3',
            'max_slots' => 'nullable|integer',
            'last_cancel_date' => 'nullable|date|after:now|before_or_equal:date',
        ]);

        $organization = Organization::findOrFail($data['organization_id']);

        $this->authorize('manage', $organization);

        $event = Event::create($data);

        return redirect()
            ->route('events.show', $event);
    }

    public function edit(Request $request, Event $event)
    {
        /** @var User $user */
        $user = $request->user();

        $this->authorize('manage', $event);

        return view('events.admin.edit', [
            'event' => $event,
            'organizations' => Organization::all()
                ->filter(fn (Organization $organization) => $user->can('manage', $organization)),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('manage', $event);

        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|min:3',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required|min:3',
            'max_slots' => 'nullable|integer',
            'last_cancel_date' => 'nullable|date|after:now|before_or_equal:date',
        ]);

        if (!$data['max_slots']) {
            $data['max_slots'] = null; // allow clearing it
        }

        if (!$data['last_cancel_date']) {
            $data['last_cancel_date'] = null;
        }

        $organization = Organization::findOrFail($data['organization_id']);
        $this->authorize('manage', $organization);

        $event->update($data);

        return redirect()
            ->route('events.show', $event);
    }

    public function destroy(Event $event)
    {
        //
    }

    public function createRegistrationOption(Request $request, Event $event)
    {
        /** @var User $user */
        $user = $request->user();

        $this->authorize('manage', $event);
        $event->loadMissing('organization.groups');

        return view('events.admin.regopts.create', [
            'event' => $event,
        ]);
    }

    public function storeRegistrationOption(Request $request, Event $event)
    {
        /** @var User $user */
        $user = $request->user();

        $this->authorize('manage', $event);

        $data = $request->validate([
            'priority' => [
                'required',
                'integer',
                Rule::unique('event_registration_options', 'priority')->where('event_id', $event->id)
            ],
            'opens_at' => 'required|date',
            'closes_at' => 'required|date|after:now',
            'waitlist_priority' => 'required|integer',
            'count_to_slots' => 'required|boolean',
            'enabled' => 'required|boolean',
        ]);

        $data['event_id'] = $event->id;

        $option = EventRegistrationOption::create($data);

        collect($request->input('groups'))
            ->map(fn($string) => [
                'event_registration_option_id' => $option->id,
                'organization_group_id' => intval($string)
            ])
            ->each(fn($array) => EventRegistrationOptionRequiredGroup::create($array));

        return redirect()
            ->route('admin.events.edit', $event);
    }

    public function editRegistrationOption(Request $request, EventRegistrationOption $option)
    {
        $this->authorize('manage', $option->event);

        return view('events.admin.regopts.edit', [
            'event' => $option->event,
            'option' => $option,
            'groups' => $option->groupRequirements()->pluck('organization_group_id')->toArray(),
        ]);
    }

    public function updateRegistrationOption(Request $request, EventRegistrationOption $option)
    {
        $event = $option->event;
        $this->authorize('manage', $event);

        $data = $request->validate([
            'priority' => [
                'required',
                'integer',
                Rule::unique('event_registration_options', 'priority')
                    ->where('event_id', $event->id)->whereNot('id', $option->id)
            ],
            'opens_at' => 'required|date',
            'closes_at' => 'required|date',
            'waitlist_priority' => 'required|integer',
            'count_to_slots' => 'required|boolean',
            'enabled' => 'required|boolean',
        ]);

        $oldGroupIds = $option->groupRequirements()
            ->pluck('organization_group_id')
            ->toArray();

        $groups = collect($request->input('groups'))->map(fn($string) => intval($string));
        EventRegistrationOptionRequiredGroup::where('event_registration_option_id', $option->id)
            ->whereNotIn('organization_group_id', $groups->toArray())
            ->delete();

        $groupIds = $groups->map(fn($id) => [
            'event_registration_option_id' => $option->id,
            'organization_group_id' => $id
        ])
            ->each(fn($entry) => EventRegistrationOptionRequiredGroup::firstOrCreate($entry, $entry))
            ->map(fn($array) => $array['organization_group_id'])
            ->toArray();

        $option->addPendingChange('groups', $oldGroupIds, $groupIds);
        $option->savePendingChanges();

        $option->update($data);
        return redirect()
            ->route('admin.events.edit', $event);
    }
}
