<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandleLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
}
