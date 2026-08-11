<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Search and Add Button -->
                <div class="flex justify-between mb-4">
                    <form method="GET" action="{{ route('attendances.index') }}" class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Student..." class="border rounded px-3 py-2">
                        <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                        <a href="{{ route('attendances.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Clear</a>
                    </form>
                    
                    <a href="{{ route('attendances.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">+ Mark Attendance</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                <!-- Table -->
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-3">Student Name</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr class="border-b">
                            <td class="p-3">{{ $attendance->student->name ?? 'N/A' }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M, Y') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-white text-sm 
                                    {{ $attendance->status == 'Present' ? 'bg-green-500' : ($attendance->status == 'Absent' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('attendances.edit', $attendance->id) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>