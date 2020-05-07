<?php

namespace App\Http\Controllers\Organizations;

use Illuminate\Validation\Rule;
use App\Organizations\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Organizations\OrganizationGroup;

class OrganizationGroupAdminController extends Controller
{
    public function create(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('groups.admin.create', [
            'organizations' => Organization::all()
                ->filter(fn (Organization $organization) => $user->can('manage', $organization)),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|min:3',
            'description' => 'nullable|min:1',
            'is_public' => 'required|boolean',
            'is_member_list_public' => 'required|boolean',
            'is_member_list_shown_to_other_members' => 'required|boolean',
        ]);

        $organization = Organization::findOrFail($data['organization_id']);
        $this->authorize('manage', $organization);

        $group = OrganizationGroup::create($data);

        return redirect()
            ->route('groups.show', $group);
    }

    public function edit(OrganizationGroup $group)
    {
        $this->authorize('manage', $group);
        return view('groups.admin.edit', ['group' => $group]);
    }

    public function update(Request $request, OrganizationGroup $group)
    {
        $this->authorize('manage', $group);

        $data = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|min:1',
            'is_public' => 'required|boolean',
            'is_member_list_public' => 'required|boolean',
            'is_member_list_shown_to_other_members' => 'required|boolean',
        ]);

        $group->update($data);

        return redirect()
            ->route('groups.show', $group);
    }
}
