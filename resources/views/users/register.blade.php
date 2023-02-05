<x-layout>
    <div>Register</div>
    <div>
        <h1 class="text-2xl mt-10 mb-8 font-medium leading-6 text-gray-900">Create User</h1>
        <x-validation-errors />   
        <form action="/users" method="POST" >
            @csrf
            <div class="bg-white py-2 px-4 sm:px-6 lg:px-8 rounded-xl text-gray-600 border border-gray-200">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-5">
                    <x-label for="name">Name</x-label>
                    <div class="mt-2 mb-4 sm:col-span-2 sm:my-0">
                        <x-input type="text" name="name" id="name" :value="old('name')" />
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:py-5">
                    <x-label for="email">Email</x-label>
                    <div class="mt-2 mb-4 sm:col-span-2 sm:my-0">
                        <x-input type="email" name="email" id="email" :value="old('email')" />
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:py-5">
                    <x-label for="password">Password</x-label>
                    <div class="mt-2 mb-4 sm:col-span-2 sm:my-0">
                        <x-input type="password" name="password" id="password" :value="old('password')" />
                    </div>
                </div>
            </div>
            <div class="pt-5">
                <div class="flex justify-end">
                    <a href="/users" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</a>
                    <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create User</button>
                </div>
            </div>
        </form>    
    </div>
</x-layout>