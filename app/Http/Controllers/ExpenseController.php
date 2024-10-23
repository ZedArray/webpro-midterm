<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index() {
        $monthlyExpense = Expense::where('date', '>=', now()->subDays(30))->sum('amount');
        $recentExpenses = Expense::latest()->take(8)->get();
        $monthlyIncome = 1000000;

        return view('dashboard', [
            'title' => 'Home Page',
            'monthlyExpense' => $monthlyExpense,
            'recentExpenses' => $recentExpenses,
            'monthlyIncome' => $monthlyIncome,
        ]);
    }

    public function showExpenses(Request $request) {
        $expenses = Expense::all();

        $new = [];
        $search = $request->query('search');
        print($search);

        foreach ($expenses as $expense) {
            if (str_contains($expense->description, $search)){
                array_push($new, $expense);
            }
        }

        return view('expense', ['title' => 'All Expenses', 'expenses' => $new]);
    }

    public function store(Request $request) {
        $expense = new Expense();
        $expense->amount = $request->input('amount');
        $expense->description = $request->input('description');
        $expense->category = $request->input('category');
        $expense->date = $request->input('date');

        $expense->save();

        return redirect('/expenses')->with('success', 'Expense added successfully');
    }

    public function update(Request $request, Expense $expense) {
        $expense->amount = $request->input('amount');
        $expense->description = $request->input('description');
        $expense->category = $request->input('category');
        $expense->date = $request->input('date');

        $expense->save();

        return redirect('/expenses')->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense) {
        $expense->delete();
        return redirect('/expenses')->with('success', 'Expense deleted successfully');
    }
}
