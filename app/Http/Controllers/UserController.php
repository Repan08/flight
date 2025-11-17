<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns',
            'password' => 'required|string|min:8',
            'phone_number' => ['required', 'regex:/^(?:\+62|62|0)[2-9][0-9]{7,11}$/']
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'phone_number.required' => 'Nomor telepon wajib diisi',
        ]);

        $createData = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'user'
        ]);

        if ($createData) {
            return redirect()->route('login')->with('success', 'Berhasil registrasi, silahkan login');
        } else {
            return redirect()->route('signup')->with('error', 'Gagal registrasi, silahkan coba lagi');
        }
    }

    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
        // memverifikassi data yang akan digunakan
        $data = $request->only('email', 'password');

        // Auth::attempt -> mencocokan data dengan database
        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin');
            } elseif (Auth::user()->role == 'staff') {
                return redirect()->route('staff.dashboard')->with('success', 'Berhasil login sebagai staff');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil login');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login, silahkan coba lagi');
        }
    }

    public function logout()
    {
        //Auth::logout() : hapus sesi login
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda sudah Logout! silahkan login kembali untuk akses lengkap');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
