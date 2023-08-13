<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCustomerController extends Controller
{
    public function login(){
        return view('authsCustomer.login');
    }

    public function register(){
        return view('authsCustomer.register');
    }
    public function store(Request $request)
{
    // Validate user input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email',
        'password' => 'required|string|confirmed',
        'address' => 'required|string',
        'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048', // Validate image upload
    ]);

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $profilePictureFileName = $request->file('profile_picture')->getClientOriginalName();
        $profilePicturePath = 'img/profile_pictures/' . $profilePictureFileName;

        // Move the uploaded file to the desired directory
        $request->file('profile_picture')->move(public_path('img/profile_pictures'), $profilePictureFileName);
    } else {
        $profilePicturePath = null; // No profile picture uploaded
    }

    // Create a new customer using the validated data
    $customer = Customer::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
        'address' => $validatedData['address'],
        'profile_picture' => $profilePicturePath, // Store the profile picture path
    ]);

    // Redirect the user after successful registration
    return redirect('/customer/login')->with('status', 'Registration successful. You can now log in.');
}

public function updateProfile(Request $request)
{
    $user = auth()->guard('customer')->user();

    // Validate user input
    $validatedData = $request->validate([
        'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email,' . $user->id,
        'password' => 'nullable|string|confirmed',
    ]);

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $profilePictureFileName = $request->file('profile_picture')->getClientOriginalName();
        $profilePicturePath = 'img/profile_pictures/' . $profilePictureFileName;

        // Move the uploaded file to the desired directory
        $request->file('profile_picture')->move(public_path('img/profile_pictures'), $profilePictureFileName);
        $user->profile_picture = $profilePicturePath;
    }

    // Update user information
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($validatedData['password']) {
        $user->password = bcrypt($validatedData['password']);
    }
    $user->save();

    return redirect()->back()->with('status', 'Profile updated successfully.');
}


public function postLogin(Request $request) {
    $email = $request->email;
    $password = $request->password;

    $credentials = [
        'email' => $email,
        'password' => $password,
    ];

    $isLoginSuccessful = Auth::guard('customer')->attempt($credentials);
    if ($isLoginSuccessful) {
        $customer = Auth::guard('customer')->user();

        if ($customer && $customer->is_active == 1) {
            // Update last login and login counter
            $customer->update([
                'last_login' => now(),
                'login_counter' => $customer->login_counter + 1,
            ]);

            // You can also perform your audit log here if needed

            return redirect('/');
        } else {
            Auth::guard('customer')->logout();
            return redirect('/customer/login')->with('statusLogin', 'Give Access First to User');
        }
    } else {
        return redirect('/customer/login')->with('statusLogin', 'Wrong Email or Password');
    }
}


    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/')->with('statusLogout','Success Logout');
    }
}
