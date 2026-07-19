<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function pageLogin()
    {
        return view('auth.login');
    }

    public function pageRegister()
    {
        $roles = Role::pluck('name', 'id'); // Assuming you have a Role model to fetch roles
        $stations = Station::all(); // Assuming you have a Station model to fetch stations
        return view('auth.register', [
            'roles' => $roles,
            'stations' => $stations
        ]);
    }

    public function registerAccount(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            ]);

        try {
            // Create the user
            $user = \App\Models\User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'station_id' => $validatedData['station_id'] ?? null, // Assuming you have a station_id field in your users table
            ]);
            // Assign the role to the user
            $role = Role::findById($validatedData['role_id']);
            $user->assignRole($role);

            // Redirect to a success page or login page
            return redirect()->route('login')->with('success', 'Account created successfully. Please contact super-admin to confirmed.');
        } catch (Exception $e) {
            // Handle any errors that may occur during user creation
            return back()->withErrors(['msg' => 'An error occurred while creating the account. Please try again.']);
        }
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            // You can access user information like $user->getId(), $user->getName(), $user->getEmail(), etc.
            // For example, you can create or find a user in your database and log them in.
            // Example:
            // $authUser = User::firstOrCreate([
            //     'email' => $user->getEmail(),
            // ], [
            //     'name' => $user->getName(),
            //     'google_id' => $user->getId(),
            // ]);

            // Auth::login($authUser, true);

            return redirect()->intended('/'); // Redirect to the intended page after login
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Unable to login using Google. Please try again.']);
        }
    }
}
