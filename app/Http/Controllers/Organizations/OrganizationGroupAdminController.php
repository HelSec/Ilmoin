<?php

namespace App\Http\Controllers\Organizations;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Organizations\OrganizationGroup;

class OrganizationGroupAdminController extends Controller
{
    public function edit(OrganizationGroup $group)
    {
        $this->authorize('manage', $group);
        return view('groups.admin.edit', ['group' => $group]);
    }

    public function update(Request $request, OrganizationGroup $group)
    {
        $this->authorize('manage', $group);

        $data = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('organization_groups', 'id')->whereNot('id', $group->organization_id)],
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
