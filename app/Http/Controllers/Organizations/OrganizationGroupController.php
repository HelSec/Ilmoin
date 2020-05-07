<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Organizations\OrganizationGroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizationGroupController extends Controller
{
    public function index()
    {
        //
    }

    public function show(OrganizationGroup $group)
    {
        $this->authorize('view', $group);
        $group->load('organization', 'members');
        return view('groups.view', ['group' => $group]);
    }
}
