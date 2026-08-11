<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Alert Message --}}
            @if (session('success'))
                <div style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header with Search Bar and Add Student Button --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-800">All Registered Students</h3>

                    {{-- Search Form --}}
                    <form action="{{ route('students.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search student..." 
                            style="padding: 0.4rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;"
                        >
                        <button 
                            type="submit" 
                            style="padding: 0.4rem 0.85rem; background-color: #1f2937; color: white; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                            Search
                        </button>
                        
                        @if(request('search'))
                            <a 
                                href="{{ route('students.index') }}" 
                                style="padding: 0.4rem 0.85rem; background-color: #e5e7eb; color: #374151; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; text-decoration: none;">
                                Clear
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('students.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-blue-700">
                        + Add Student
                    </a>
                </div>

                {{-- Table Content --}}
                @if($students->isEmpty())
                    <p class="text-gray-500 text-center py-4">No students found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->roll_number }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->email }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->schoolClass->name ?? 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <a href="{{ route('students.edit', $student) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
        
        <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this student?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
        </form>
    </td>
</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>