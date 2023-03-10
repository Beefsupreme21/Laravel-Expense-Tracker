<x-layout>     

    <div>
        <h1 class="text-2xl mt-10 mb-8 font-medium leading-6 text-gray-900">Create Expense</h1>
        <x-validation-errors />   
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

    <table class="table-auto w-full text-black bg-white">
        <thead>
            <tr class="text-left font-medium">
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr class="text-left">
                    <td class="border px-4 py-2">{{ $expense->amount }}</td>
                    <td class="border px-4 py-2">{{ $expense->description }}</td>           
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
