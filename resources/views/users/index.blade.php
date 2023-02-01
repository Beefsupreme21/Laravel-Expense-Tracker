<x-layout>     
    <table class="table-auto w-full text-black bg-white">
        <thead>
            <tr class="text-left font-medium">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="text-left">
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2">
                        <a href="/users/{{ $user->id }}">{{ $user->name }}</a>
                    </td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>        
                    <td class="border px-4 py-2">
                        <a href="/users/{{ $user->id }}/edit">
                            <x-svg.edit class="w-6 h-6 hover:stroke-blue-500"/>
                        </a>
                    </td>        
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
