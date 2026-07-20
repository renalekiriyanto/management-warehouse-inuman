<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Socialite;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function pageLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
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

    public function completeProfile(Request $request)
    {
        // Retrieve the user data from the request
        $user = $request->user;
        $stations = Station::all(); // Assuming you have a Station model to fetch stations
        $roles = Role::all(); // Assuming you have a Role model to fetch roles
        // Render the complete profile view and pass the user data
        return view('auth.complete-profile', ['user' => $user, 'stations' => $stations, 'roles' => $roles]);
    }

    public function completeProfileSubmit(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'station_id' => 'required|exists:stations,id',
            'role' => 'required|exists:roles,id',
        ]);
        $user = Auth::user(); // Get the currently authenticated user
        // Update the user data
        $user->station_id = $validatedData['station_id'];

        $role = Role::findById($validatedData['role'], 'web');
        $user->assignRole($role->name);

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->profile()->updateOrCreate([], ['avatar' => $avatarPath]);
        }

        // Save the updated user data
        $user->save();

        // Redirect to a success page or dashboard
        return redirect()->route('dashboard')->with('success', 'Profile completed successfully.');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Checking email user
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            if ($existingUser) {
                // User already exists, log them in
                // Check user role

            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()), // Generate a random password
                ]);

                $avatarPath = null;

                if ($googleUser->getAvatar()) {

                    $contents = Http::get($googleUser->getAvatar())->body();

                    $filename = Str::uuid() . '.jpg';

                    Storage::disk('public')->put(
                        "avatars/{$filename}",
                        $contents
                    );

                    $avatarPath = "avatars/{$filename}";
                }

                $profile = $newUser->profile()->create([
                    'avatar' => $avatarPath,
                ]);
            }

            Auth::login($newUser, true); // Log in the new user
            // redirecto to complete profile page, and pass data new user created
            return redirect()->route('auth.complete-profile', ['user' => $newUser]); // Redirect to the intended page after login
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Unable to login using Google. Please try again.']);
        }
    }
}
