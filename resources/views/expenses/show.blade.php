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
        <p>Total Earned: <span class="text-green-500 font-medium">${{ number_format($positiveExpenses, 2) }}</span></p>
        <p>Total Spent: <span class="text-red-500 font-medium">-${{ number_format($negativeExpenses, 2) }}</span></p>
        @if ($positiveExpenses - $negativeExpenses > 0)
            <p>Current Balance: <span class="font-medium">${{ number_format($positiveExpenses - $negativeExpenses, 2) }}</span></p>
        @else
            <p>Current Balance: <span class="text-red-500 font-medium">${{ number_format($positiveExpenses - $negativeExpenses, 2) }}</span></p>
        @endif
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

</x-layout>