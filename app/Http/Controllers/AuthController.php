<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validate the login request data
        $credentials = $request->validate([
            'email' => 'required|string', // Or 'email' if you want to allow login by email
            'password' => 'required|string',
        ]);


        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation

            $cookie = cookie(
                "api-key",
                Crypt::encrypt(Auth::id()),
            );

            if (Auth::user()->user_type == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()
                    ->route('home')
                    ->cookie($cookie);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.', // Or 'email'
        ])->withInput(["email"]); // Keep the username input for convenience
    }

    public function register(Request $request)
    {
        $rules = [
            'user_type' => ['required', 'string', 'min:0'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ];

        // 2. Validate the request data using $request->validate()
        $validatedData = $request->validate($rules);


        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'billing_address' => $request->billing_address,
            'user_type' => intval($request->user_type),
            'phone_number' => $request->phone_number,
        ]);

        // Optionally, log the user in after registration
        Auth::login($user);
        $request->session()->regenerate(); // Prevent session fixation
        $cookie = cookie(
            "api-key",
            Crypt::encrypt($user->id),
        );

        return redirect()->route('home')->cookie($cookie); // Redirect to dashboard or a welcome page
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect to homepage or login page after logout
    }
}
