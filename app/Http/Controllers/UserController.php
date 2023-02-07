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
        $currentMonth = Carbon::now()->format('F Y');
        $currentYear = Carbon::now()->format('Y');
        $previousMonth = Carbon::now()->subMonth()->format('F Y');
        $previousMonthYear = Carbon::now()->subMonth()->format('Y');

        $expenses = Expense::where('user_id', $user->id)
            ->when(request()->has('searchQuery'), function ($query) {
                return $query->where('description', 'like', '%' . request('searchQuery') . '%');
            })
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->date)->format('F Y');
            });

        $totalIncome = $user->expenses->where('type', 'income')->sum('amount');
        $totalExpenses = $user->expenses->where('type', 'expense')->sum('amount');

        $foodExpenses = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('category', 'food')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');
            
        $rentExpenses = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('category', 'rent')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');

        $entertainmentExpenses = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('category', 'entertainment')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');
            
        $utilitiesExpenses = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('category', 'utilities')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');

        $currentMonthExpenseTotal = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');

        $currentMonthIncomeTotal = Expense::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', Carbon::now()->format('m'))
            ->sum('amount');

        $previousMonthExpenseTotal = Expense::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereYear('date', $previousMonthYear)
            ->whereMonth('date', Carbon::now()->subMonth()->format('m'))
            ->sum('amount');

        $previousMonthIncomeTotal = Expense::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereYear('date', $previousMonthYear)
            ->whereMonth('date', Carbon::now()->subMonth()->format('m'))
            ->sum('amount');

        return view('users.show', [
            'expenses' => $expenses,
            'user' => $user,
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'currentMonthExpenseTotal' => $currentMonthExpenseTotal,
            'currentMonthIncomeTotal' => $currentMonthIncomeTotal,
            'previousMonthExpenseTotal' => $previousMonthExpenseTotal,
            'previousMonthIncomeTotal' => $previousMonthIncomeTotal,
            'currentMonth' => $currentMonth,
            'previousMonth' => $previousMonth,
            'foodExpenses' => $foodExpenses,
            'rentExpenses' => $rentExpenses,
            'entertainmentExpenses' => $entertainmentExpenses,
            'utilitiesExpenses' => $utilitiesExpenses,
        ]);
    }



    public function searchExpenses(User $user)
    {
        $days = request('days');
        $expenses = Expense::where('user_id', $user->id)
            ->where('date', '>=', Carbon::now()->subDays($days))
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

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);

        return redirect()->route('users.show', ['user' => $user->id]);
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

    public function register()
    {
        return view('users.register');
    }

    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($validated)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('home');
    }

    public function demo()
    {
        $demoUser = User::where('email', 'demo@example.com')->first();

        auth()->login($demoUser);

        return redirect()->route('users.show', ['user' => $demoUser->id]);
    }
}
