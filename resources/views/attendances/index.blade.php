<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Page Title -->
            <h2 class="text-2xl font-bold text-gray-400 tracking-tight px-1">
                Attendance Management
            </h2>

            <!-- Main Dark Card Container -->
            <div class="bg-[#1e293b] text-gray-100 rounded-2xl shadow-xl overflow-hidden border border-slate-700/50 p-6">
                
                <!-- Controls Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-bold text-white tracking-wide">
                        Attendance Records
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Date / Search Filter -->
                        <form method="GET" action="{{ route('attendances.index') }}" class="flex items-center gap-2">
                            <input 
                                type="date" 
                                name="date" 
                                value="{{ request('date', date('Y-m-d')) }}" 
                                class="bg-[#0f172a] border border-slate-700 text-gray-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            />
                            <button 
                                type="submit" 
                                class="bg-[#0f172a] hover:bg-slate-900 border border-slate-700 text-xs font-bold uppercase tracking-wider text-gray-200 px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm"
                            >
                                FILTER
                            </button>
                        </form>

                        <!-- Mark Attendance Button -->
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                            <a 
                                href="{{ route('attendances.create') }}" 
                                class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md inline-flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                + MARK ATTENDANCE
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-700/60">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1a2234] border-b border-slate-700 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                <th scope="col" class="px-6 py-4">STUDENT NAME</th>
                                <th scope="col" class="px-6 py-4">DATE</th>
                                <th scope="col" class="px-6 py-4">STATUS</th>
                                <th scope="col" class="px-6 py-4">REMARKS</th>
                                <th scope="col" class="px-6 py-4 text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/60 text-sm">
                            @forelse($attendances as $attendance)
                                <tr class="hover:bg-slate-800/50 transition-colors duration-150">
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ $attendance->student->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-300">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(strtolower($attendance->status) === 'present')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-emerald-900/40 text-emerald-400 border border-emerald-700/50">
                                                Present
                                            </span>
                                        @elseif(strtolower($attendance->status) === 'absent')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-rose-900/40 text-rose-400 border border-rose-700/50">
                                                Absent
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-amber-900/40 text-amber-400 border border-amber-700/50">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $attendance->remarks ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center space-x-2">
                                            <a 
                                                href="{{ route('attendances.edit', $attendance->id) }}" 
                                                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-lg transition"
                                            >
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('attendances.destroy', $attendance->id) }}" onsubmit="return confirm('Delete this record?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white font-semibold text-xs rounded-lg transition"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">
                                        No attendance records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($attendances, 'links'))
                    <div class="mt-6">
                        {{ $attendances->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>