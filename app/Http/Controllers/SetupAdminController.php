<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class SetupAdminController extends Controller
{
    /**
     * Show the form for creating the first admin user.
     */
    public function create()
    {
        // Middleware CheckFirstUserSetup sudah menangani redirect jika sudah ada user
        return view('auth.setup-admin');
    }

    /**
     * Store the first admin user.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'setup_key' => ['required', 'string', 'size:32', 'in:'.config('app.admin_setup_key')],
        ]);

        if ($validator->fails()) {
            return redirect()->route('setup-admin.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user pertama
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('status', 'Admin user created successfully! Please login.');
    }
}
