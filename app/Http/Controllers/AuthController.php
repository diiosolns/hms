<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to the appropriate dashboard based on user role
            $role = Auth::user()->role;
            return redirect()->intended(route($role . '.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,owner,doctor,receptionist,pharmacist,lab_technician,nurse'],
            'phone' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
            'branch_id' => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password, // Mutator will handle hashing
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'hospital_id' => $request->hospital_id,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the password reset request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        // This view is for showing the "forgot password" form.
        return view('auth.reset');
    }

    /**
     * Show the password reset form.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        // This view is for showing the "reset password" form.
        return view('auth.reset');
    }

    public function showProfile($id)
    {
        // Find the user by ID. If not found, it will automatically throw a 404 exception.
        $user = User::findOrFail($id);

        // Pass the user data to the profile view.
        return view('auth.profile', compact('user'));
    }

    public function showAccountSettings($id)
    {
        // Find the user by ID. If not found, it will automatically throw a 404 exception.
        $user = User::findOrFail($id);

        // Pass the user data to the profile view.
        return view('auth.settings', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        // 1. Validate the form data.
        // The 'confirmed' rule automatically checks if 'new_password' and 'new_password_confirmation' match.
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // 2. Check if the current password is correct.
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'The provided current password does not match your password.');
        }

        // 3. Update the password.
        // We use Hash::make() to securely hash the new password before saving it.
        //$user->password = Hash::make($request->new_password);
        $user->password = $request->new_password; // Mutator will handle hashing
        $user->save();

        // 4. Redirect back with a success message.
        return back()->with('status', 'Password changed successfully!');
    }

    
    
}
