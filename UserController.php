<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all(); ←コードレビューより修正
        $users = User::paginate(20)->get();
        return view('users.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = new User;
        $user->name = $validated['name'],
        $user->email = $validated['email'],
        $user->password = Hash::make($validated['password']),
        $user->save();

        return redirect('/users');
    }
}
