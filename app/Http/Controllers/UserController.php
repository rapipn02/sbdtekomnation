<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan Anda memiliki model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Support\Facades\Validator; // Untuk validasi

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
   public function index()
{
    $users = User::latest()->paginate(10); // Atau sesuai logika Anda

    // Baris ini untuk menampilkan view, pastikan path view-nya benar
    return view('dashboard.users.index', compact('users'));

    // Hapus atau komentari baris di bawah ini
    // return response()->json($users);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Kembalikan view untuk form tambah pengguna
        // return view('dashboard.users.create');
        return response()->json(['message' => 'Show form to create user']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Tambahkan validasi lain jika perlu, misal untuk role
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // Atau untuk API:
            // return response()->json($validator->errors(), 422);
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => $request->role, // Jika ada kolom role
        ]);

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        // return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) // Menggunakan Route Model Binding
    {
        // Kembalikan view untuk detail pengguna
        // return view('dashboard.users.show', compact('user'));
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Kembalikan view untuk form edit pengguna
        // return view('dashboard.users.edit', compact('user'));
        return response()->json(['message' => 'Show form to edit user', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
            // Tambahkan validasi lain jika perlu
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // Atau untuk API:
            // return response()->json($validator->errors(), 422);
        }

        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        // $user->role = $request->role; // Jika ada kolom role
        $user->save();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        // return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Hapus pengguna
        $user->delete();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        // return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        return response()->json(['message' => 'User deleted successfully']);
    }
}