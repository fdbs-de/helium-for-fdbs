<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DestroyUserRequest;
use App\Http\Resources\User\PublicUserResource;
use App\Http\Resources\User\UserResource;
use App\Mail\ImportedUserCreated;
use App\Mail\UserEnabled;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index');
    }



    public function searchPublic()
    {
        $query = User::select(['id', 'name', 'username', 'image']);

        if (request()->exclude)
        {
            $query->whereNotIn('id', request()->exclude);
        }

        if (request()->search)
        {
            $query->whereFuzzy(function ($query) {
                $query
                ->orWhereFuzzy('name', request()->search)
                ->orWhereFuzzy('username', request()->search);
            });
        }

        $total = $query->count();

        if (request()->limit)
        {
            $query->limit(request()->limit);
        }

        return response()->json([
            'data' => PublicUserResource::collection($query->get()),
            'total' => $total,
        ]);
    }

    public function search(Request $request)
    {
        $query = User::with(['roles', 'settings']);
        
        // START: Search
        if ($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('name', $request->search)
                ->orWhereFuzzy('username', $request->search)
                ->orWhereFuzzy('email', $request->search);
            });
        }
        // END: Search



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';
        
        $query->orderBy($field, $order);
        // END: Sort



        // START: Pagination
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $query->limit($limit)->offset($offset);
        // END: Pagination

        return response()->json([
            'data' => UserResource::collection($query->get()),
            'total' => $total,
        ]);
    }



    public function create(User $user)
    {
        $domain = Setting::firstWhere('key', 'site.domain');
        return Inertia::render('Admin/Users/Create', [
            'user' => $user->load(['roles', 'settings']),
            'roles' => Role::get(),
            'settings' => [
                'site.domain' => $domain ? $domain->value : null,
            ],
        ]);
    }



    public function store(Request $request)
    {
        return back();
    }



    public function update(Request $request, User $user)
    {
        $user->email = $request->email;
        $user->username = $request->username;
        $user->email_verified_at = $request->email_verified_at;
        $user->enabled_at = $request->enabled_at;

        // Set the user's password
        if ($request->password)
        {
            $user->password = bcrypt($request->password);
        }



        // Set the user's roles
        $user->roles()->sync($request->roles);

        if ($request->profiles['customer']['has_customer_profile'])
        {
            $user->setSetting('profile.customer', [
                'company' => $request->profiles['customer']['company'],
                'customer_id' => $request->profiles['customer']['customer_id'],
            ]);
        }
        else
        {
            $user->unsetSetting('profile.customer');
        }



        // Set the user's employee profile
        if ($request->profiles['employee']['has_employee_profile'])
        {
            $user->setSetting('profile.employee', [
                'first_name' => $request->profiles['employee']['first_name'],
                'last_name' => $request->profiles['employee']['last_name'],
            ]);
        }
        else
        {
            $user->unsetSetting('profile.employee');
        }



        // Save the user to the database
        $user->save();

        // Update the user's name
        $user->updateName();



        $user->setSetting('newsletter.subscribed.generic', $request->newsletter['generic']);
        $user->setSetting('newsletter.subscribed.customer', $request->newsletter['customer']);

        return back();
    }



    public function delete(DestroyUserRequest $request)
    {
        User::whereIn('id', $request->ids)->delete();

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



    public function updateSettings(Request $request)
    {
        $users = User::all();

        foreach ($users as $user)
        {
            /**
             * Fix user profiles
             * This fix migrates the old user profiles to the new user settings
             */
            if ($request->fixProfiles === true)
            {
                if ($user->customerProfile)
                {
                    $user->setSetting('profile.customer', [
                        'company' => $user->customerProfile->company,
                        'customer_id' => $user->customerProfile->customer_id,
                    ]);
                }
                
                if ($user->employeeProfile)
                {
                    $user->setSetting('profile.employee', [
                        'first_name' => $user->employeeProfile->first_name,
                        'last_name' => $user->employeeProfile->last_name,
                    ]);
                }
            }

            /**
             * Update pre-calculated user name
             * This fix sets the 'name' column to the most appropriate value
             */
            if ($request->updateNames === true)
            {
                $user->updateName();
            }
        }

        return back();
    }
}
