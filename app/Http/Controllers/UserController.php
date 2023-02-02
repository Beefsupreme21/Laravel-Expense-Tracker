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
        $users = User::when(request('searchQuery'), function ($query) {
            return $query->where('name', 'like', '%' . request('searchQuery') . '%');
        })->with('expenses')->get();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        $expenses = Expense::where('user_id', $user->id);
    
        if (request()->has('searchQuery')) {
            $expenses->where('description', 'like', '%'. request('searchQuery') . '%');
        }
    
        $expenses = $expenses->orderBy('date', 'desc')->get();
    
        $expenses = $expenses->groupBy(function ($expense) {
            return Carbon::parse($expense->date)->format('F Y');
        });
        
        $positiveExpenses = $user->expenses->where('type', 'income')->sum('amount');
        $negativeExpenses = $user->expenses->where('type', 'expense')->sum('amount');
    
        return view('users.show', [
            'expenses' => $expenses,
            'user' => $user,
            'positiveExpenses' => $positiveExpenses,
            'negativeExpenses' => $negativeExpenses,
        ]);
    }

    public function searchLast30Days(User $user)
    {
        $expenses = Expense::where('user_id', $user->id)
            ->where('date', '>=', Carbon::now()->subDays(30))
            ->where('description', 'like', '%' . request('searchQuery') . '%')
            ->orderBy('date', 'desc')->get();

        $expenses = $expenses->groupBy(function ($expense) {
            return Carbon::parse($expense->date)->format('F Y');
        });

        $positiveExpenses = $user->expenses->where('type', 'income')->sum('amount');
        $negativeExpenses = $user->expenses->where('type', 'expense')->sum('amount');

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
