<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('students.update', $student->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Roll Number -->
                    <div>
                        <label for="roll_number" class="block font-medium text-sm text-gray-700">Roll Number</label>
                        <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number', $student->roll_number) }}" class="border-gray-300 rounded-md shadow-sm w-full mt-1" required>
                        @error('roll_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="border-gray-300 rounded-md shadow-sm w-full mt-1" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="border-gray-300 rounded-md shadow-sm w-full mt-1" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Class Select -->
                    <div>
                        <label for="class_id" class="block font-medium text-sm text-gray-700">Class</label>
                        <select name="class_id" id="class_id" class="border-gray-300 rounded-md shadow-sm w-full mt-1" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold">
                            Update Student
                        </button>
                        <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-semibold">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>