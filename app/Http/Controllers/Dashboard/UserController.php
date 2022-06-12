<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function indexUsers() {
        return Inertia::render('Dashboard/Users', [
            'users' => User::with(['roles', 'employeeProfile', 'customerProfile'])->get(),
        ]);
    }

    public function enableUser(Request $request, User $user) {
        $user->enabled_at = now();
        $user->save();

        return back();
    }
}
