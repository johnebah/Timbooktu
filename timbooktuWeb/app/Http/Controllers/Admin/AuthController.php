<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $adminPassword = (string) env('ADMIN_PASSWORD', 'admin');

        if (! hash_equals($adminPassword, (string) $request->input('password'))) {
            return back()->withErrors([
                'password' => 'Invalid password.',
            ])->onlyInput('password');
        }

        $request->session()->put('is_admin', true);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }
}
