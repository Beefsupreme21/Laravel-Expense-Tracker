<x-layout>
    <div>
        {{ $user->name }}
    </div>
    <div>
        Total Earned: {{ $positiveExpenses }}
    </div>
    <div>
        Total Spent: -{{ $negativeExpenses }}
    </div>
    <table class="table-auto w-full text-black bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $month => $monthExpenses)
                <tr class="bg-gray-200">
                    <td class="border px-4 py-2 text-lg font-medium" colspan="3">{{ $month }}</td>
                </tr>
                @foreach ($monthExpenses as $expense)
                    <tr class="text-left">
                        <td class="border px-4 py-2">{{ $expense->date }}</td>               
                        <td class="border px-4 py-2">{{ $expense->description }}</td>
                        @if ( $expense->type )
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