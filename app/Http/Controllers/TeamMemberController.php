<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function show(TeamMember $teamMember): View
    {
        if (! $teamMember->is_active) {
            abort(404);
        }

        $otherMembers = TeamMember::query()
            ->activeOrdered()
            ->where('id', '!=', $teamMember->id)
            ->limit(6)
            ->get();

        return view('pages.team.show', compact('teamMember', 'otherMembers'));
    }
}
