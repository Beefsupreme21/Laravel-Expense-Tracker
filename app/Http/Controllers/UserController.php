<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Expense;
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

    public function show(User $user)
    {
        $expenses = Expense::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->date)->format('F Y');
        });

        $positiveExpenses = $user->expenses->where('type', 1)->sum('amount');
        $negativeExpenses = $user->expenses->where('type', 0)->sum('amount');

        return view('users.show', [
            'expenses' => $expenses,
            'user' => $user,
            'positiveExpenses' => $positiveExpenses,
            'negativeExpenses' => $negativeExpenses,
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
