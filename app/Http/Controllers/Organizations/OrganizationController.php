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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizations\Organization  $organization
     * @return Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizations\Organization  $organization
     * @return Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizations\Organization  $organization
     * @return Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
