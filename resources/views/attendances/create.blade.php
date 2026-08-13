<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mark Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Error Message Alert (e.g. Attendance already exists) -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-900 dark:text-red-200 dark:border-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('attendances.store') }}" method="POST">
                    @csrf

                    <!-- Student Selection -->
                    <div class="mb-4">
                        <label for="student_id" class="block font-medium text-gray-700 dark:text-gray-300">Student</label>
                        <select name="student_id" id="student_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date Selection -->
                    <div class="mb-4">
                        <label for="attendance_date" class="block font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="attendance_date" id="attendance_date" value="{{ old('attendance_date', date('Y-m-d')) }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1" required>
                        @error('attendance_date')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-4">
                        <label for="status" class="block font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1" required>
                            <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>Present</option>
                            <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>Absent</option>
                            <option value="Leave" {{ old('status') == 'Leave' ? 'selected' : '' }}>Leave</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center mt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                            Save Attendance
                        </button>
                        <a href="{{ route('attendances.index') }}" class="ml-3 text-gray-600 dark:text-gray-400 hover:underline">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>