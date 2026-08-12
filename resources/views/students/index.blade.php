<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Flash Message -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('students.index') }}" class="mb-6 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, roll no, or email..." class="border-gray-300 rounded-md shadow-sm w-full md:w-1/3">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md">Search</button>
                </form>

                <!-- Students Table -->
                <table class="min-w-full divide-y divide-gray-200 w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Roll No</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Class</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->roll_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->schoolClass->name ?? $student->class_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-3">
                                    
                                    <!-- Edit Link -->
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $students->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>