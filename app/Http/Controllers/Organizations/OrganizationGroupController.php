<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Organizations\OrganizationGroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizationGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param OrganizationGroup $group
     * @return Response
     * @throws AuthorizationException
     */
    public function show(OrganizationGroup $group)
    {
        $this->authorize('view', $group);
        $group->load('organization', 'members');
        return view('groups.view', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OrganizationGroup $group
     * @return Response
     */
    public function edit(OrganizationGroup $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param OrganizationGroup $group
     * @return Response
     */
    public function update(Request $request, OrganizationGroup $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OrganizationGroup $group
     * @return Response
     */
    public function destroy(OrganizationGroup $group)
    {
        //
    }
}
