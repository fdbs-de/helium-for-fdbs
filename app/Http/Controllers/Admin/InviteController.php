<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function update(Request $request, User $user)
    {
        $request->validate([
            'invite' => 'required|in:sommerfest',
            'value' => 'required|in:yes,no',
        ]);

        $invite = 'invite.employee.' . $request->invite;

        $user->setSetting($invite, $request->value);

        return back();
    }



    public function search(Request $request)
    {
        $request->validate([
            'invite' => 'required|in:sommerfest',
            'status' => 'required|in:yes,no',
        ]);

        $key = 'invite.employee.' . $request->invite;
        $value = (string) $request->status;

        $users = User::select('id', 'email', 'name', 'enabled_at')->whereNot('enabled_at', null)->whereHas('settings', function ($query) use ($key, $value) {
            $query->where('key', $key)->where('value', '"'.$value.'"'); // TODO: make this less hacky
        })->get();

        return response()->json($users);
    }
}
