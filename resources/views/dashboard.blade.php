<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            School Management Overview
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Responsive Grid: 1 column on mobile, 3 columns on desktop -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold">Total Students</h3>
    <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $totalStudents ?? 0 }}</p>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold">Total Teachers</h3>
    <p class="text-3xl font-extrabold text-green-600 mt-2">{{ $totalTeachers ?? 0 }}</p>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold">Classes</h3>
    <p class="text-3xl font-extrabold text-purple-600 mt-2">{{ $totalClasses ?? 0 }}</p>
</div>

            </div>
        </div>
    </div>
</x-app-layout>