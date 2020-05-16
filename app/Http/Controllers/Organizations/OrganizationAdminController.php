<?php

namespace App\Http\Controllers\Organizations;

use Illuminate\Validation\Rule;
use App\Organizations\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationAdminController extends Controller
{
    public function create()
    {
        $this->authorize('create', Organization::class);
        return view('organizations.admin.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Organization::class);
        $data = $request->validate([
            'name' => 'required|min:2|max:255',
            'bio' => 'required|min:2|max:512',
            'description' => 'required|min:2',
        ]);

        $organization = Organization::create($data);
        return redirect()->route('organizations.show', $organization);
    }

    public function edit(Organization $organization)
    {
        $this->authorize('manage', $organization);
        return view('organizations.admin.edit', ['organization' => $organization]);
    }

    public function update(Request $request, Organization $organization)
    {
        $this->authorize('manage', $organization);
        $data = $request->validate([
            'name' => 'required|min:2|max:255',
            'bio' => 'required|min:2|max:512',
            'description' => 'required|min:2',
            'admin_group_id' => [
                'nullable',
                'integer',
                Rule::exists('organization_groups', 'id')->where('organization_id', $organization->id),
            ],
        ]);

        $organization->update($data);
        return redirect()->route('organizations.show', $organization);
    }
}
