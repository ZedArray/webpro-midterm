<x-layout>
    <x-slot:title> {{ $title }} </x-slot:title>

    <div class="dashboard-overview grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">

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

        <div class="bg-white shadow-md rounded-lg p-6 col-span-1 md:col-span-2 lg:col-span-1">
            <h4 class="text-xl font-bold mb-3 text-center">Expense vs Income</h4>
            <canvas id="expenseIncomeChart" width="400" height="200"></canvas>
        </div>



        {{-- <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between">
                <div>
                    <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">$12,423</h5>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Sales this week</p>
                </div>
                <div
                    class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
                    23%
                    <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13V1m0 0L1 5m4-4 4 4" />
                    </svg>
                </div>
            </div>
            <div id="data-series-chart"></div>
            <div
                class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-5">
                <div class="flex justify-between items-center pt-5">
                    <!-- Button -->
                    <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                        data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Last 7 days
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="lastDaysdropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                    7 days</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                    30 days</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                    90 days</a>
                            </li>
                        </ul>
                    </div>
                    <a href="#"
                        class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                        Sales Report
                        <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                </div>
            </div>
        </div> --}}




        <div class="bg-white shadow-md rounded-lg p-6 col-span-1 md:col-span-2">
            <h4 class="text-xl font-bold mb-3">Recent Expenses</h4>
            <ul class="space-y-2">
                @forelse ($recentExpenses as $expense)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $expense->description }}</span>
                        <span class="text-gray-500">Rp{{ $expense->amount }} | {{ $expense->date }}</span>
                    </li>
                @empty
                    <li>No recent expenses found.</li>
                @endforelse
            </ul>
        </div>
    </div>

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
    {{-- <script>
        const options = {
            // add data series via arrays, learn more here: https://apexcharts.com/docs/series/
            series: [{
                    name: "Developer Edition",
                    data: [1500, 1418, 1456, 1526, 1356, 1256],
                    color: "#1A56DB",
                },
                {
                    name: "Designer Edition",
                    data: [643, 413, 765, 412, 1423, 1731],
                    color: "#7E3BF2",
                },
            ],
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: "area",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            legend: {
                show: false
            },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.55,
                    opacityTo: 0,
                    shade: "#1C64F2",
                    gradientToColors: ["#1C64F2"],
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: 0
                },
            },
            xaxis: {
                categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February',
                    '07 February'
                ],
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                    formatter: function(value) {
                        return '$' + value;
                    }
                }
            },
        }

        if (document.getElementById("data-series-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("data-series-chart"), options);
            chart.render();
        }
    </script> --}}

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</x-layout>
