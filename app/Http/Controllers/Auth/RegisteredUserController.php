<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Registrieren');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => ['required', Rules\Password::defaults()],
            'terms'                 => 'required|accepted',

            'is_customer'           => 'required|boolean',
            'customer.company'      => 'required_if:is_customer,true|nullable|string|max:255',
            'customer.customer_id'  => 'required_if:is_customer,true|nullable|string|max:255',
            'customer.newsletter'   => 'required_if:is_customer,true|boolean',

            'is_employee'           => 'required|boolean',
            'employee.first_name'   => 'required_if:is_employee,true|nullable|string|max:255',
            'employee.last_name'    => 'required_if:is_employee,true|nullable|string|max:255',
        ]);



        // Create the user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



        // Create the customer profile
        if ($request->is_customer)
        {
            $user->setSetting('profile.customer', [
                'company' => $request->customer['company'],
                'customer_id' => $request->customer['customer_id'],
            ]);

            $user->setSetting('newsletter.subscribed.customer', $request->customer['newsletter']);
        }



        // Create the employee profile
        if ($request->is_employee)
        {
            $user->setSetting('profile.employee', [
                'first_name' => $request->employee['first_name'],
                'last_name' => $request->employee['last_name'],
            ]);
        }



        // Set the name of the user based on their profiles
        $user->updateName();

        // Send the verification email
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect the user to the verification email page
        return redirect(RouteServiceProvider::HOME);
    }
}
