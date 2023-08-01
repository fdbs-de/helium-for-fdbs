<?php

namespace App\Http\Controllers\Apps\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'newsletter' => 'required|in:generic,customer',
            'value' => 'required|boolean',
        ]);

        

        // Check if user has customer access and wants to subscribe to customer newsletter
        if ($request->newsletter == 'customer' && $request->value)
        {
            if (!$request->user()->access['customer']) return redirect()->back()->with('error', 'Sie sind kein Kunde bei uns.');
        }



        $newsletter = 'newsletter.subscribed.' . $request->newsletter;
        $request->user()->setSetting($newsletter, $request->value);

        return redirect()->back()->with('success', 'Newsletter Einstellungen wurden aktualisiert.');
    }
}
