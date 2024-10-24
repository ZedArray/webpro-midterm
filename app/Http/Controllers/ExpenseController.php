<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{

    public function index() {
        $monthlyExpense = Expense::where('user_id', 'like', Auth::user()->id)->where('date', '>=', now()->subDays(30))->sum('amount');
        $recentExpenses = Expense::latest()->where('user_id', 'like', Auth::user()->id)->take(8)->get();
        $monthlyIncome = 1000000;

        return view('dashboard', [
            'title' => 'Home Page',
            'monthlyExpense' => $monthlyExpense,
            'recentExpenses' => $recentExpenses,
            'monthlyIncome' => $monthlyIncome,
            'balls' => 'big ones',
        ]);
    }

    public function showExpenses(Request $request) {
        $search = $request->query('search');
        $expenses = Expense::where('description', 'like', '%' . $search . '%')->where('user_id', 'like', Auth::user()->id)->latest()->paginate(10);

        return view('expense', ['title' => 'All Expenses', 'expenses' => $expenses]);
    }

    public function store(Request $request) {
        $expense = new Expense();
        $expense->user_id = Auth::user() -> id;
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
