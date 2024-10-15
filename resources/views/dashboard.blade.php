<x-layout>
    <x-slot:title> {{ $title }} </x-slot:title>

    <div class="dashboard-overview grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">
        
        {{-- Card for total expenses this month --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-bold mb-3">Monthly Expenses</h4>
            <p class="text-lg">You have spent this month:</p>
            <p class="text-2xl font-bold text-red-500 mt-2">Rp{{ $monthlyExpense }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-bold mb-3">Monthly Income</h4>
            <p class="text-lg">Your monthly income:</p>
            <p class="text-2xl font-bold text-green-500 mt-2">Rp{{ $monthlyIncome }}</p>
        </div>

        {{-- Card for Monthly Expense vs Daily Income comparison graph --}}
        <div class="bg-white shadow-md rounded-lg p-6 col-span-1 md:col-span-2 lg:col-span-1">
            <h4 class="text-xl font-bold mb-3">Monthly Expense vs Daily Income</h4>
            <canvas id="expenseIncomeChart" width="400" height="200"></canvas>
        </div>

        {{-- Recent 8 expenses card --}}
        <div class="bg-white shadow-md rounded-lg p-6 col-span-1 md:col-span-2">
            <h4 class="text-xl font-bold mb-3">Recent Expenses</h4>
            <ul class="space-y-2">
                @forelse ($recentExpenses as $expense)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $expense->description }}</span>
                        <span class="text-gray-500">Rp{{ $expense->amount }} ({{ $expense->date }})</span>
                    </li>
                @empty
                    <li>No recent expenses found.</li>
                @endforelse

            </ul>
        </div>
    </div>

    {{-- Script for rendering the graph using Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('expenseIncomeChart').getContext('2d');
        var expenseIncomeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    label: 'Amount',
                    data: [{{ $monthlyIncome }}, {{ $monthlyExpense }}],
                    backgroundColor: ['#4CAF50', '#FF5733']
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-layout>
