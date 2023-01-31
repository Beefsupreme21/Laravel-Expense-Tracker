<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required', 
            'email' => 'required', 
            'password' => 'required', 
        ]);

        User::create($validated);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => 'required', 
            'email' => 'required', 
            'password' => 'required', 
        ]);

        $user->update($validated);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
