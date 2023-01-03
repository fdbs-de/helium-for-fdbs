<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function update(Request $request, User $user)
    {
        $request->validate([
            'newsletter' => 'required|in:generic,customer',
            'value' => 'required|boolean',
        ]);

        $newsletter = 'newsletter.subscribed.' . $request->newsletter;

        $user->setSetting($newsletter, $request->value);

        return back();
    }



    public function search(Request $request)
    {
        $request->validate([
            'newsletter' => 'required|in:generic,customer',
        ]);

        $newsletter = 'newsletter.subscribed.' . $request->newsletter;

        $users = User::select('id', 'email', 'enabled_at')->whereNot('enabled_at', null)->whereHas('settings', function ($query) use ($newsletter) {
            $query->where('key', $newsletter)->where('value', 'true');
        })->get();

        return response()->json($users);
    }
}
