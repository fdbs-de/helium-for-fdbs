<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\DestroyUserRequest;
use App\Http\Requests\Users\DuplicateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Role\RoleResource;
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
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'roles' => RoleResource::collection(Role::get()),
        ]);
    }



    public function searchPublic(Request $request)
    {
        $query = User::select('*');
        
        // START: Search
        if (array_key_exists('search', $request->filter) && $request->filter['search'])
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('name', $request->filter['search'])
                ->orWhereFuzzy('username', $request->filter['search']);
            });
        }
        // END: Search



        // START: Filter
        if (array_key_exists('exclude', $request->filter) && $request->filter['exclude'])
        {
            $query->whereNotIn('id', $request->filter['exclude']);
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';
        
        $query->orderBy($field, $order);
        // END: Sort



        // START: Pagination
        $total = $query->count();

        $limit = $request->pagination['size'] ?? 20;
        $offset = $request->pagination['size'] * ($request->pagination['page'] ?? 0) - $request->pagination['size'];

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $query->limit($limit)->offset($offset);
        // END: Pagination

        return response()->json([
            'data' => PublicUserResource::collection($query->get()),
            'total' => $total,
        ]);
    }

    

    public function search(Request $request)
    {
        $query = User::query();
        
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



        // START: Filter
        if ($request->profiles)
        {
            $profiles = array_map( function ($profile) { return 'profile.' . $profile; }, $request->profiles);

            $query->whereHas('settings', function ($query) use ($profiles) {
                $query->whereIn('key', $profiles);
            });
        }

        if ($request->roles)
        {
            $query->whereHas('roles', function ($query) use ($request) {
                $query->whereIn('name', $request->roles);
            });
        }

        if ($request->newsletter)
        {
            $newsletter = array_map( function ($newsletter) { return 'newsletter.subscribed.' . $newsletter; }, $request->newsletter);

            $query->whereHas('settings', function ($query) use ($newsletter) {
                $query->whereIn('key', $newsletter)->where('value', 'true');
            });
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';
        
        $query->orderBy($field, $order);
        // END: Sort



        // START: Identifiers
        $ids = $query->pluck('users.id')->toArray();
        // END: Identifiers



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
            'item_ids' => $ids,
            'total' => $total,
        ]);
    }



    public function create(User $user)
    {
        return Inertia::render('Admin/Users/Create', [
            'user' => UserResource::make($user),
            'roles' => Role::get(),
        ]);
    }



    public function store(CreateUserRequest $request)
    {
        // Create the user
        $user = User::create($request->only([
            'name',
            'username',
            'custom_account_id',
            'email',
            'email_verified_at',
            'enabled_at',
            'terminated_at',
        ]));

        // Set the user's password
        if ($request->password)
        {
            $user->password = Hash::make($request->password);
            $user->save();
        }



        // Set the user details
        $user->details()->create($request->details);



        // Set the user's addresses
        foreach ($request->addresses as $address)
        {
            $user->addresses()->create([
                'type' => $address['type'],
                'address_line_1' => $address['address_line_1'],
                'address_line_2' => $address['address_line_2'],
                'city' => $address['city'],
                'state' => $address['state'],
                'postal_code' => $address['postal_code'],
                'country' => $address['country'],
                'notes' => $address['notes'],
            ]);
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

        // Update the user's name
        $user->updateName();



        $user->setSetting('newsletter.subscribed.generic', $request->newsletter['generic']);
        $user->setSetting('newsletter.subscribed.customer', $request->newsletter['customer']);

        return redirect()->route('admin.users.editor', $user->id);
    }



    public function duplicate(DuplicateUserRequest $request, User $user)
    {
        $user->duplicate();

        return back();
    }



    public function update(UpdateUserRequest $request, User $user)
    {
        // Update the user
        $user->update($request->only([
            'name',
            'username',
            'custom_account_id',
            'email',
            'email_verified_at',
            'enabled_at',
            'terminated_at',
        ]));

        // Update the user's password
        if ($request->password)
        {
            $user->password = Hash::make($request->password);
            $user->save();
        }



        // Update or create the user details
        $user->details()->updateOrCreate([
            'user_id' => $user->id,
        ], $request->details);



        // Remove the user's addresses
        $user->addresses()->whereIn('id', $request->removed_addresses)->delete();

        // Set the user's addresses
        foreach ($request->addresses as $address)
        {
            $user->addresses()->updateOrCreate([
                'id' => $address['id'] ?? null,
            ], [
                'type' => $address['type'],
                'address_line_1' => $address['address_line_1'],
                'address_line_2' => $address['address_line_2'],
                'city' => $address['city'],
                'state' => $address['state'],
                'postal_code' => $address['postal_code'],
                'country' => $address['country'],
                'notes' => $address['notes'],
            ]);
        }



        // Remove the user's emails
        $user->emails()->whereIn('id', $request->removed_emails)->delete();

        // Set the user's emails
        foreach ($request->emails as $email)
        {
            $user->emails()->updateOrCreate([
                'id' => $email['id'] ?? null,
            ], [
                'type' => $email['type'],
                'email' => $email['email'],
            ]);
        }



        // Remove the user's phone numbers
        $user->phone_numbers()->whereIn('id', $request->removed_phone_numbers)->delete();

        // Set the user's phone numbers
        foreach ($request->phone_numbers as $phone_number)
        {
            $user->phone_numbers()->updateOrCreate([
                'id' => $phone_number['id'] ?? null,
            ], [
                'type' => $phone_number['type'],
                'number' => $phone_number['number'],
            ]);
        }



        // Remove the user's significant dates
        $user->significant_dates()->whereIn('id', $request->removed_significant_dates)->delete();

        // Set the user's significant dates
        foreach ($request->significant_dates as $significant_date)
        {
            $user->significant_dates()->updateOrCreate([
                'id' => $significant_date['id'] ?? null,
            ], [
                'type' => $significant_date['type'],
                'date' => $significant_date['date'],
                'ignore_year' => $significant_date['ignore_year'],
                'repeats_annually' => $significant_date['repeats_annually'],
            ]);
        }



        // Remove the user's website links
        $user->website_links()->whereIn('id', $request->removed_website_links)->delete();

        // Set the user's website links
        foreach ($request->website_links as $website_link)
        {
            $user->website_links()->updateOrCreate([
                'id' => $website_link['id'] ?? null,
            ], [
                'name' => $website_link['name'],
                'url' => $website_link['url'],
            ]);
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



    public function export(Request $request)
    {
        $users = User::whereIn('id', $request->users);

        $csv = "\xEF\xBB\xBF";

        // Add header
        $csv .= 'ID;Name;Username;Email;Email verified;Enabled;Roles;Profiles;Newsletter;Invites;Created at;Updated at' . PHP_EOL;

        foreach ($users->get() as $user)
        {
            $profiles = [];
            if ($user->getSetting('profile.customer')) $profiles[] = 'Customer';
            if ($user->getSetting('profile.employee')) $profiles[] = 'Employee';

            $newsletter = [];
            if ($user->getSetting('newsletter.subscribed.generic')) $newsletter[] = 'Generic';
            if ($user->getSetting('newsletter.subscribed.customer')) $newsletter[] = 'Customer';

            $invites = [];
            if ($user->getSetting('invite.employee.sommerfest')) $invites[] = 'Sommerfest: '. $user->getSetting('invite.employee.sommerfest');

            $csv .= $user->id . ';';
            $csv .= $user->name . ';';
            $csv .= $user->username . ';';
            $csv .= $user->email . ';';
            $csv .= $user->email_verified_at ? 'Yes;' : 'No;';
            $csv .= $user->enabled_at ? 'Yes;' : 'No;';
            $csv .= $user->roles->pluck('name')->join(', ') . ';';
            $csv .= implode(', ', $profiles) . ';';
            $csv .= implode(', ', $newsletter) . ';';
            $csv .= implode(', ', $invites) . ';';
            $csv .= $user->created_at->format('m.d.Y H:i') . ';';
            $csv .= $user->updated_at->format('m.d.Y H:i');
            $csv .= PHP_EOL;
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="users.csv"');
    }
}
