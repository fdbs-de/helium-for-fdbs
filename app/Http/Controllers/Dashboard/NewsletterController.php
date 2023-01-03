<?php

namespace App\Http\Controllers\Dashboard;

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

        // Check if user is customer and wants to subscribe to customer newsletter
        if ($request->newsletter == 'customer')
        {
            if (!$request->user()->customerProfile) return redirect()->back()->with('error', 'Sie sind kein Kunde bei uns.');
        }

        $newsletter = 'newsletter.subscribed.' . $request->newsletter;

        $request->user()->setSetting($newsletter, $request->value);

        return redirect()->back()->with('success', 'Newsletter Einstellungen wurden aktualisiert.');
    }
}
