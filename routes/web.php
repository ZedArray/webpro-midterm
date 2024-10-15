<?php

use Carbon\Carbon;
use App\Models\Expense;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $monthlyExpense = Expense::whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])->sum('amount');    
    $monthlyIncome = 1000000;
    $recentExpenses = Expense::latest()->take(8)->get();

    return view('dashboard', [
        'title' => 'Home Page',
        'monthlyExpense' => $monthlyExpense,
        'monthlyIncome' => $monthlyIncome,
        'recentExpenses' => $recentExpenses
    ]);
});

Route::get('/expenses', function () {
    $expenses = Expense::all();
    return view('expense', ['title' => 'All Expenses', 'expenses' => $expenses]);
});

Route::post('/expenses', function () {
    request()->validate([
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'category' => 'required|string|max:100',
        'date' => 'required|date',
    ]);

    Expense::create(request()->all());

    return redirect('/expenses')->with('success', 'Expenses added successfullly');
});

Route::get('/expenses/{expense}/edit', function(Expense $expense) {
    return view('expenses.edit', ['title' => 'Edit Expense', 'expense' => $expense]);
});

Route::put('/expenses/{expense}', function(Expense $expense) {
    request()->validate([
        'amount' => 'required|numeric',
        'description' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'date' => 'required|date',
    ]);
    
    $expense->update(request()->all());

    return redirect('/expenses')->with('success', 'Expense updated successfully');
});

Route::delete('/expenses/{expense}', function(Expense $expense) {
    $expense->delete();
    
    return redirect('/expenses')->with('success', 'Expense deleted successfully');
});