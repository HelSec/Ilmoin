<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Organizations\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organizations\Organization  $organization
     * @return Response
     */
    public function show(Organization $organization)
    {
        $organization->loadMissing('upcomingEvents', 'pastEvents', 'groups', 'groups.members', 'groups.organization', 'adminGroup');
        return view('organizations.view', compact('organization'));
    }
}
