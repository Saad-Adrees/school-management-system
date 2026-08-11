<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Student Report Cards</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($students as $student)
                    @if($student->marks->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $student->name }}</h3>
                            
                            <table class="w-full text-sm text-left mb-4">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 py-1">Subject</th>
                                        <th class="px-2 py-1">Score</th>
                                        <th class="px-2 py-1">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $totalObtained = 0; 
                                        $totalMax = 0; 
                                    @endphp
                                    
                                    @foreach($student->marks as $mark)
                                        @php 
                                            $totalObtained += $mark->marks_obtained;
                                            $totalMax += $mark->total_marks;
                                        @endphp
                                        <tr class="border-b">
                                            <td class="px-2 py-2">{{ $mark->subject }}</td>
                                            <td class="px-2 py-2">{{ $mark->marks_obtained }} / {{ $mark->total_marks }}</td>
                                            <td class="px-2 py-2 font-semibold">{{ $mark->grade ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-md">
                                <span class="font-medium text-gray-700">Overall Performance:</span>
                                <span class="font-bold text-blue-600">
                                    {{ $totalObtained }} / {{ $totalMax }} 
                                    ({{ $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0 }}%)
                                </span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>