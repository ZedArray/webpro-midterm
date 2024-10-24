<x-layout>
    <x-slot:title> {{ $title }} </x-slot:title>

    <section class="dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Expenses Management -->
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <!-- Search Bar -->
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" action="/expenses" method="GET">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2" placeholder="Search expenses" value="{{ request()->search }}">
                            </div>
                        </form>
                    </div>
                    
                    <!-- Add Expense Button -->
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button id="addExpenseBtn" class="flex items-center justify-center text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add Expense
                        </button>
                    </div>

                    <!-- Add Expense Modal -->
                    <div id="addExpenseModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <!-- Modal content -->
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white p-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add Expense</h3>
                                    <form action="/expenses" method="POST" class="mt-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" name="description" id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                            <input type="number" name="amount" id="amount" step="0.01" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                            <input type="text" name="category" id="category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                            <input type="date" name="date" id="date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                        </div>

                                        <div class="mt-5 sm:mt-6">
                                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                                Save Expense
                                            </button>
                                            <button type="button" id="cancelModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Add Expense Modal -->
                </div>

                <!-- Expenses Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Date</th>
                                <th scope="col" class="px-4 py-3">Amount</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr class="border-b">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $expense->description }}</th>
                                    <td class="px-4 py-3">{{ $expense->category }}</td>
                                    <td class="px-4 py-3">{{ $expense->date }}</td>
                                    <td class="px-4 py-3">Rp{{ $expense->amount }}</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="expense-{{ $expense->id }}-dropdown-button" data-dropdown-toggle="expense-{{ $expense->id }}-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Actions for Edit/Delete -->
                                        <div id="expense-{{ $expense->id }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                                            <ul class="py-1 text-sm text-gray-700" aria-labelledby="expense-{{ $expense->id }}-dropdown-button">
                                                <li><button class="block w-full text-left py-2 px-4 hover:bg-gray-100" onclick="showEditModal('{{ $expense->id }}', '{{ $expense->description }}', '{{ $expense->amount }}', '{{ $expense->category }}', '{{ $expense->date }}')">Edit</button></li>
                                                <li>
                                                    <form action="/expenses/{{ $expense->id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="block w-full text-left py-2 px-4 hover:bg-gray-100" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-4 py-3">No expenses found.</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>

                <div class="m-5">
                    {{ $expenses->links() }}
                </div>

            </div>
        </div>
    </section>

    <!-- Edit Expense Modal -->
    <div id="editExpenseModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Expense</h3>
                    <form action="" method="POST" class="mt-4" id="editExpenseForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" id="edit-description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit-amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" name="amount" id="edit-amount" step="0.01" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit-category" class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" id="edit-category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit-date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="edit-date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mt-5 sm:mt-6">
                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                Update Expense
                            </button>
                            <button type="button" id="cancelEditModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 sm:mt-0 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Edit Expense Modal -->

    {{-- Script to handle Add Expense modal --}}
    <script>
        const addExpenseBtn = document.getElementById('addExpenseBtn');
        const addExpenseModal = document.getElementById('addExpenseModal');
        const cancelModalBtn = document.getElementById('cancelModalBtn');

        // Show the modal when Add Expense button is clicked
        addExpenseBtn.addEventListener('click', () => {
            addExpenseModal.classList.remove('hidden');
        });

        // Hide the modal when Cancel button is clicked
        cancelModalBtn.addEventListener('click', () => {
            addExpenseModal.classList.add('hidden');
        });

        // Show edit modal
        function showEditModal(id, description, amount, category, date) {
            const editExpenseModal = document.getElementById('editExpenseModal');
            const editForm = document.getElementById('editExpenseForm');

            // Set form action URL dynamically
            editForm.action = `/expenses/${id}`;

            // Fill input values with existing data
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-amount').value = amount;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-date').value = date;

            // Show modal
            editExpenseModal.classList.remove('hidden');
        }

        // Hide edit modal
        document.getElementById('cancelEditModalBtn').addEventListener('click', () => {
            document.getElementById('editExpenseModal').classList.add('hidden');
        });
    </script>
</x-layout>
