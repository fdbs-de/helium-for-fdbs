<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\ImportedUserCreated;
use App\Mail\UserEnabled;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    public function indexUsers()
    {
        return Inertia::render('Dashboard/Admin/Users', [
            'users' => User::with(['roles', 'employeeProfile', 'customerProfile'])->orderBy('created_at', 'desc')->get(),
        ]);
    }



    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'newPassword' => 'required|min:8',
        ]);

        $user->password = bcrypt($request->newPassword);
        $user->save();

        return back();
    }



    public function importUsers(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*.email' => 'required|email',
            'users.*.name' => 'required|string|max:255',
            'users.*.cb_kundennummer' => 'present|nullable|string|max:255',
            'users.*.approved' => 'required|in:1',
        ]);

        
        foreach ($request->input('users') as $user)
        {
            $newPassword = Str::random(10);

            if (User::firstWhere('email', $user['email'])) continue;
            
            $model = User::create([
                'email' => $user['email'],
                'name' => $user['name'],
                'password' => bcrypt($newPassword),
            ]);

            $model->enabled_at = now();
            $model->email_verified_at = now();
            $model->save();

            $customerProfile = $model->fresh()->customerProfile()->create([
                'company' => $user['name'],
                'customer_id' => $user['cb_kundennummer'],
            ]);

            $customerProfile->enabled_at = now();
            $customerProfile->save();

            Mail::to($user['email'])->send(new ImportedUserCreated($user['email'], $newPassword));
        }

        return back()->with('success', 'Users imported successfully');
    }



    public function assignRole(User $user, Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user->assignRole($request->role);

        return back();
    }

    public function revokeRole(User $user, Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user->removeRole($request->role);

        return back();
    }



    public function enableUser(Request $request, User $user)
    {
        $user->enabled_at = now();
        $user->save();

        Mail::to($user->email)->send(new UserEnabled());

        return back();
    }

    public function enableCustomer(Request $request, User $user)
    {
        $user->customerProfile->enabled_at = now();
        $user->customerProfile->save();

        return back();
    }
    
    public function enableEmployee(Request $request, User $user)
    {
        $user->employeeProfile->enabled_at = now();
        $user->employeeProfile->save();

        return back();
    }



    public function disableUser(Request $request, User $user)
    {
        $user->enabled_at = null;
        $user->save();

        return back();
    }
    
    public function disableCustomer(Request $request, User $user)
    {
        $user->customerProfile->enabled_at = null;
        $user->customerProfile->save();

        return back();
    }
    
    public function disableEmployee(Request $request, User $user)
    {
        $user->employeeProfile->enabled_at = null;
        $user->employeeProfile->save();

        return back();
    }



    public function destroyUser(User $user)
    {
        $user->delete();

        return back();
    }

    public function destroyCustomer(User $user)
    {
        $user->customerProfile()->delete();

        return back();
    }

    public function destroyEmployee(User $user)
    {
        $user->employeeProfile()->delete();

        return back();
    }
}
