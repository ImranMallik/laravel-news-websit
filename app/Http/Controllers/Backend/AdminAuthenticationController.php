<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Http\Requests\HandleLoginRequest;
use App\Http\Requests\SendPasswordResetLink;
use App\Mail\AdminResetPassworLinkMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AdminAuthenticationController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(HandleLoginRequest $request)
    {
        // dd($request->all());
        $request->authenticate();


        Auth::guard('admin')->user();

        return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
    }


    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(SendPasswordResetLink $request)
    {
        // dd($request->all());
        $token = \Str::random(64);
        $admin = Admin::where('email', $request->email)->first();
        $admin->remember_token = $token;
        $admin->save();

        Mail::to($request->email)->send(new AdminResetPassworLinkMail($token, $request->email));
        return redirect()->back()->with('success', 'A mail has been sent to your email address');
    }

    public function resetPassword($token)
    {
        return view('admin.auth.password-reset', compact('token'));
    }

    public function handelRequestPassword(AdminResetPasswordRequest $request)
    {
        $token = $request->input('token');
        $admin = Admin::where('email', $request->email)
            ->where('remember_token', $token)
            ->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Invalid token or email.');
        }
        $admin->password = Hash::make($request->password);
        $admin->remember_token = null;
        $admin->save();
        return redirect()->route('admin.login')->with('success', 'Password reset successfully.');
    }
}
