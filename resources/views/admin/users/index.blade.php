<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users & Credentials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success Message Alert -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message Alert -->
            @if ($errors->any())
                <div class="p-4 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 rounded-xl shadow-sm">
                    <div class="flex items-center mb-2 font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Whoops! Something went wrong.
                    </div>
                    <ul class="list-disc list-inside text-sm ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 sm:rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Role</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Update Role</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Override Password</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/25 transition-colors duration-200">
                                    
                                    <!-- Name -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                    </td>
                                    
                                    <!-- Email -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </td>
                                    
                                    <!-- Current Role (Now formatted as stylish badges) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold capitalize tracking-wide
                                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-400' : '' }}
                                            {{ $user->role === 'teacher' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400' : '' }}
                                            {{ $user->role === 'student' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400' : '' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    
                                    <!-- Role Update Form -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="flex items-center space-x-3">
                                            @csrf
                                            @method('PUT')
                                            
                                            <select name="role" class="block w-36 py-2 px-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                                                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                                <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-xs font-bold shadow-sm transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                Update
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Password Override Form -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.users.password.update', $user->id) }}" method="POST" class="flex items-center space-x-3">
                                            @csrf
                                            @method('PUT')
                                            
                                            <input type="password" name="new_password" placeholder="New Password" required
                                                   class="w-36 py-2 px-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 rounded-lg shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-500/20 text-sm transition-colors">
                                            
                                            <input type="password" name="new_password_confirmation" placeholder="Confirm" required
                                                   class="w-36 py-2 px-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 rounded-lg shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-500/20 text-sm transition-colors">
                                            
                                            <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 text-xs font-bold shadow-sm transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 dark:focus:ring-offset-gray-800">
                                                Reset
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>