<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Subject Marks Directory</h2>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Top Bar: Title, Search, and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">All Entered Marks</h3>
                    
                    <div class="flex space-x-4">
                        <form action="{{ route('marks.index') }}" method="GET" class="flex space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student or subject..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">SEARCH</button>
                        </form>
                        <a href="{{ route('marks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center">
                            + ADD MARKS
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-sm uppercase border-b">
                            <th class="pb-3 font-medium">Student Name</th>
                            <th class="pb-3 font-medium">Subject</th>
                            <th class="pb-3 font-medium">Marks Obtained</th>
                            <th class="pb-3 font-medium">Total Marks</th>
                            <th class="pb-3 font-medium">Grade</th>
                            <th class="pb-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($marks as $mark)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4">{{ $mark->student->name ?? 'Unknown Student' }}</td>
                                <td class="py-4">{{ $mark->subject }}</td>
                                <td class="py-4">{{ $mark->marks_obtained }}</td>
                                <td class="py-4">{{ $mark->total_marks }}</td>
                                <td class="py-4">{{ $mark->grade ?? 'N/A' }}</td>
                                <td class="py-4 text-right flex justify-end space-x-3">
                                    <a href="{{ route('marks.edit', $mark->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('marks.destroy', $mark->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No marks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $marks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>