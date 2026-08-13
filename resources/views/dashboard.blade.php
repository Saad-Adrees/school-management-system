<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('School Management Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Student Attendance Widget (Visible to logged-in Students) -->
            @if(auth()->user()->role === 'student' && isset($attendanceStats) && $attendanceStats)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        My Attendance Overview
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Percentage Card -->
                        <div class="p-4 bg-indigo-50 dark:bg-indigo-950/50 rounded-lg border border-indigo-200 dark:border-indigo-800 text-center">
                            <span class="block text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
                                {{ $attendanceStats['percentage'] }}%
                            </span>
                            <span class="text-xs uppercase font-semibold tracking-wider text-indigo-500 dark:text-indigo-300">
                                Attendance Rate
                            </span>
                        </div>

                        <!-- Present Days -->
                        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg border border-emerald-200 dark:border-emerald-800 text-center">
                            <span class="block text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">
                                {{ $attendanceStats['present'] }}
                            </span>
                            <span class="text-xs uppercase font-semibold tracking-wider text-emerald-500 dark:text-emerald-300">
                                Present Days
                            </span>
                        </div>

                        <!-- Absent Days -->
                        <div class="p-4 bg-rose-50 dark:bg-rose-950/50 rounded-lg border border-rose-200 dark:border-rose-800 text-center">
                            <span class="block text-3xl font-extrabold text-rose-600 dark:text-rose-400">
                                {{ $attendanceStats['absent'] }}
                            </span>
                            <span class="text-xs uppercase font-semibold tracking-wider text-rose-500 dark:text-rose-300">
                                Absent Days
                            </span>
                        </div>

                        <!-- Leave Days -->
                        <div class="p-4 bg-amber-50 dark:bg-amber-950/50 rounded-lg border border-amber-200 dark:border-amber-800 text-center">
                            <span class="block text-3xl font-extrabold text-amber-600 dark:text-amber-400">
                                {{ $attendanceStats['leave'] }}
                            </span>
                            <span class="text-xs uppercase font-semibold tracking-wider text-amber-500 dark:text-amber-300">
                                Leave Days
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Overview Summary Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Total Students Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Students</h3>
                    <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">
                        {{ $totalStudents ?? 0 }}
                    </p>
                </div>

                <!-- Total Teachers Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Teachers</h3>
                    <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2">
                        {{ $totalTeachers ?? 0 }}
                    </p>
                </div>

                <!-- Total Classes Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Classes</h3>
                    <p class="text-3xl font-extrabold text-purple-600 dark:text-purple-400 mt-2">
                        {{ $totalClasses ?? 0 }}
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>