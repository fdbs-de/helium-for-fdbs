<?php

namespace App\Http\Controllers\Apps\Static;

use App\Http\Controllers\Controller;
use App\Mail\AdminContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Static/Kontakt');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
            'terms' => 'required|accepted',
        ]);

        Mail::to(config('mail.addresses.user_inquiry'))->send(new AdminContactMail($request->name, $request->email, $request->message));

        return back()->with('success', true);
    }
}
