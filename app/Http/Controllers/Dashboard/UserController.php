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

    public function enableCustomer(Request $request, User $user) {
        $user->customerProfile->enabled_at = now();
        $user->customerProfile->save();

        return back();
    }
    
    public function enableEmployee(Request $request, User $user) {
        $user->employeeProfile->enabled_at = now();
        $user->employeeProfile->save();

        return back();
    }

    public function disableUser(Request $request, User $user) {
        $user->enabled_at = null;
        $user->save();

        return back();
    }
    
    public function disableCustomer(Request $request, User $user) {
        $user->customerProfile->enabled_at = null;
        $user->customerProfile->save();

        return back();
    }
    
    public function disableEmployee(Request $request, User $user) {
        $user->employeeProfile->enabled_at = null;
        $user->employeeProfile->save();

        return back();
    }



    public function destroyUser(User $user) {
        $user->delete();

        return back();
    }

    public function destroyCustomer(User $user) {
        $user->customerProfile()->delete();

        return back();
    }

    public function destroyEmployee(User $user) {
        $user->employeeProfile()->delete();

        return back();
    }
}
