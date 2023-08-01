<?php

namespace App\Http\Controllers\Apps\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'invite' => 'required|in:sommerfest',
            'value' => 'in:yes,no|nullable',
        ]);


        // if the request is sent after the 1. of september, the invite is no longer valid
        if (now()->greaterThan('2023-09-01'))
        {
            return redirect()->back()->with('error', 'Die Einladung ist nicht mehr gültig.');
        }
        
        if (!$request->user()->access['employee'])
        {
            return redirect()->back()->with('error', 'Sie sind kein Mitarbeiter bei uns.');
        }



        $invite = 'invite.employee.' . $request->invite;
        $request->user()->setSetting($invite, $request->value);

        return redirect()->back()->with('success', 'Einladungsstatus wurde erfolgreich gespeichert.');
    }
}
