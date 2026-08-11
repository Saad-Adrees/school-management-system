<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700">Student</label>
                        <select name="student_id" class="w-full border rounded px-3 py-2 mt-1" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Date</label>
                        <input type="date" name="attendance_date" value="{{ $attendance->attendance_date }}" class="w-full border rounded px-3 py-2 mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2 mt-1" required>
                            <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                            <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                            <option value="Leave" {{ $attendance->status == 'Leave' ? 'selected' : '' }}>Leave</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('attendances.index') }}" class="ml-2 text-gray-600">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>