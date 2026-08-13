<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Report Cards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @php
                $hasGradedStudents = $students->contains(fn($student) => $student->marks->count() > 0);
            @endphp

            @if($hasGradedStudents)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($students as $student)
                        @if($student->marks->count() > 0)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border-t-4 border-indigo-600 dark:border-indigo-500 flex flex-col justify-between">
                                <div>
                                    <!-- Student Name & Info -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $student->name }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Roll No: {{ $student->roll_no ?? $student->id }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400">
                                            Graded
                                        </span>
                                    </div>
                                    
                                    <!-- Marks Table -->
                                    <div class="overflow-x-auto mb-4">
                                        <table class="w-full text-sm text-left">
                                            <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 border-b dark:border-gray-700">
                                                <tr>
                                                    <th class="px-3 py-2 font-semibold">Subject</th>
                                                    <th class="px-3 py-2 font-semibold">Score</th>
                                                    <th class="px-3 py-2 font-semibold">Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                                @php 
                                                    $totalObtained = 0; 
                                                    $totalMax = 0; 
                                                @endphp
                                                
                                                @foreach($student->marks as $mark)
                                                    @php 
                                                        $totalObtained += $mark->marks_obtained;
                                                        $totalMax += $mark->total_marks;
                                                    @endphp
                                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                                        <td class="px-3 py-2.5 font-medium text-gray-800 dark:text-gray-200">{{ $mark->subject }}</td>
                                                        <td class="px-3 py-2.5 text-gray-600 dark:text-gray-300">{{ $mark->marks_obtained }} / {{ $mark->total_marks }}</td>
                                                        <td class="px-3 py-2.5 font-bold text-indigo-600 dark:text-indigo-400">{{ $mark->grade ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Overall Performance Summary -->
                                <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900/50 p-3.5 rounded-lg border border-gray-100 dark:border-gray-700 mt-2">
                                    <span class="font-medium text-sm text-gray-700 dark:text-gray-300">Overall Performance:</span>
                                    <span class="font-bold text-base text-indigo-600 dark:text-indigo-400">
                                        {{ $totalObtained }} / {{ $totalMax }} 
                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 ml-1">
                                            ({{ $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0 }}%)
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-12 text-center border border-gray-100 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-base font-semibold text-gray-900 dark:text-gray-100">No Report Cards Found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are currently no marks entered for any students to generate report cards.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>