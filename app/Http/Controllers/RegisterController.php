<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
   public function store(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required',
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        
        // TAMBAHKAN BARIS INI
        // Secara otomatis mengatur setiap user baru sebagai jenis 'Umum'
        $validateData['id_jenis'] = 'JD03';

        $user =  User::create($validateData);
        //kirim email
        \event(new Registered($user));
        //langsung login
        \auth()->login($user);
        return \redirect('/email/verify/verification');
   }
}