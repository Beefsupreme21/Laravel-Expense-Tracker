<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\StoreexpenseRequest;
use App\Http\Requests\UpdateexpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        
        return view('expenses.index', [
            'expenses' => $expenses,    
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'type' => 'required',
        ]);

        Expense::create($validated);

        return redirect('/expenses');
    }

    public function show(expense $expense)
    {
        //
    }

    public function edit(expense $expense)
    {
        //
    }

    public function update(UpdateexpenseRequest $request, expense $expense)
    {
        //
    }

    public function destroy(expense $expense)
    {
        //
    }
}
