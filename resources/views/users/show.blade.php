<x-layout>
    <div class="text-2xl font-medium mb-4">
        {{ $user->name }}
    </div>
    <form action="/users/{{ $user->id }}/search-expenses" method="POST" class="flex items-center">
        @csrf
        <input type="text" name="searchQuery" value="{{ request('searchQuery') ?? null }}" class="border border-gray-400 p-2 mr-4">
        <button type="submit" name="days" value="30" class="bg-gray-300 p-2 mr-2">Last 30 days</button>
        <button type="submit" name="days" value="90" class="bg-gray-300 p-2 mr-2">Last 90 days</button>
        <button type="submit" class="bg-blue-400 p-2 text-white">Search</button>
    </form>
    <a href="/users/{{ $user->id }}" class="text-blue-400 font-medium mt-4">Reset filters</a>
    
    
    <div class="text-lg mt-2">
        <p>Total Earned: <span class="text-green-500 font-medium">${{ number_format($totalIncome, 2) }}</span></p>
        <p>Total Spent: <span class="text-red-500 font-medium">-${{ number_format($totalExpenses, 2) }}</span></p>
        @if ($totalIncome - $totalExpenses > 0)
            <p>Current Balance: <span class="font-medium">${{ number_format($totalIncome - $totalExpenses, 2) }}</span></p>
        @else
            <p>Current Balance: <span class="text-red-500 font-medium">${{ number_format($totalIncome - $totalExpenses, 2) }}</span></p>
        @endif
    </div>

    <div>
        <span>{{ $currentMonth }}</span>
        <span>{{ $currentMonthExpenseTotal }}</span>
        <span>{{ $currentMonthIncomeTotal }}</span>
        <canvas id="pie-chart-current-month"></canvas>
    </div>

    <div>
        <span>{{ $currentMonth }}</span>
        <span>${{ number_format($currentMonthExpenseTotal, 2) }}</span>
        <span>${{ number_format($currentMonthIncomeTotal, 2) }}</span>
        <canvas id="pie-chart-previous-month"></canvas>
    </div>

    <div x-data="{ open: false }">
        <button x-on:click="open = !open">Add new expense</button>
        <div x-show="open">
            <form action="/expenses" method="POST" >
                @csrf
                <div>
                    <x-label for="user_id">User ID</x-label>
                    <x-input type="text" name="user_id" id="user_id" :value="old('user_id')" />
                </div>
                <div>
                    <x-label for="date">Date</x-label>
                    <x-input type="date" name="date" id="date" :value="old('date')" />
                </div>
                <div>
                    <x-label for="description">Description</x-label>
                    <x-input type="text" name="description" id="description" :value="old('description')" />
                </div>
                <div>
                    <x-label for="category">Category</x-label>
                    <x-input type="text" name="category" id="category" :value="old('category')" />
                </div>
                <div>
                    <x-label for="amount">Amount</x-label>
                    <x-input type="text" name="amount" id="amount" :value="old('amount')" />
                </div>
                <div>
                    <x-label for="type">Type</x-label>
                    <x-input type="text" name="type" id="type" :value="old('type')" />
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <a href="/expenses" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create Expense</button>
                    </div>
                </div>
            </form>    
        </div>
    </div>

    <table class="table-auto w-full text-black bg-white mt-4">
        <tbody>
            @foreach ($expenses as $month => $monthExpenses)
                <tr class="bg-gray-200">
                    <td class="border px-4 py-2 text-lg font-medium" colspan="4">{{ $month }}</td>
                </tr>
                @foreach ($monthExpenses as $expense)
                    <tr class="text-left">
                        <td class="border px-4 py-2">{{ $expense->date }}</td>               
                        <td class="border px-4 py-2">{{ $expense->description }}</td>
                        <td class="border px-4 py-2">{{ $expense->category }}</td>
                        @if ( $expense->type == 'income' )
                            <td class="border px-4 py-2 text-green-500 text-right">${{ $expense->amount }}</td>
                        @else
                            <td class="border px-4 py-2 text-red-500 text-right">-${{ $expense->amount }}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <script>
        let currentMonth = document.getElementById('pie-chart-current-month').getContext('2d');

        let pieChart = new Chart(currentMonth, {
            type: 'pie',
            data: {
                labels: ['Income', 'Expense'], 
                datasets: [{
                    data: [{{ $currentMonthExpenseTotal }}, {{ $currentMonthIncomeTotal }}],
                    backgroundColor: ['#00FF00', '#FF0000']
                }]
            },
            options: {}
        });

    </script>
</x-layout>