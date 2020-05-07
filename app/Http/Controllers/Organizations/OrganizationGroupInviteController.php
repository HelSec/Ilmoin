<?php

namespace App\Http\Controllers\Organizations;

use DB;
use App\Users\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Organizations\OrganizationGroup;
use App\Organizations\OrganizationGroupInvite;

class OrganizationGroupInviteController extends Controller
{
    public function createInvites(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('groups.invites.create', [
            'groups' => OrganizationGroup::with('organization')->get()
                ->filter(fn (OrganizationGroup $group) => $user->can('manage', $group)),
        ]);
    }

    public function storeInvites(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $group = OrganizationGroup::findOrFail($request->input('group_id'));
        $this->authorize('manage', $group);

        $emails = collect(explode("\n", $request->input('users')))
            ->map(fn (string $it) => str_replace("\n", "", str_replace("\r", "", $it)))
            ->toArray();

        $count = User::whereIn('email', $emails)
            ->whereNotExists(function (Builder $query) use ($group) {
                return $query->select(DB::raw('1'))
                    ->from('organization_group_members')
                    ->where('organization_group_members.user_id', DB::raw('users.id'))
                    ->where('organization_group_members.organization_group_id', $group->id);
            })
            ->whereNotExists(function (Builder $query) use ($group) {
                return $query->select(DB::raw('1'))
                    ->from('organization_group_invites')
                    ->where('organization_group_invites.user_id', DB::raw('users.id'))
                    ->where('organization_group_invites.organization_group_id', $group->id)
                    ->where('organization_group_invites.approved_by_user', false);
            })
            ->get()
            ->map(fn (User $user) => OrganizationGroupInvite::firstOrCreate([
                'organization_group_id' => $group->id,
                'user_id' => $user->id,
            ], [
                'approved_by_group' => true,
            ]))
            ->each(fn (OrganizationGroupInvite $invite) => $invite->update([
                'approved_by_group' => true,
            ]))
            ->each(fn (OrganizationGroupInvite $invite) => $invite->checkIfApproved())
            ->count();

        return redirect()
            ->route('groups.show', $group)
            ->with('notice', "Invited $count users");
    }

    public function join(Request $request, OrganizationGroup $group)
    {
        $user = $request->user();
        /** @var OrganizationGroupInvite $invite */
        $invite = $group->invites()
            ->where('approved_by_group', true)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $invite->update([
            'approved_by_user' => true,
        ]);
        $invite->checkIfApproved();

        return redirect()
            ->route('groups.show', $group)
            ->with('notice', "Successfully joined that group");
    }
}
