<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Page Title -->
            <h2 class="text-2xl font-bold text-gray-400 tracking-tight px-1">
                Faculty & Teacher Directory
            </h2>

            <!-- Main Dark Card Container -->
            <div class="bg-[#1e293b] text-gray-100 rounded-2xl shadow-xl overflow-hidden border border-slate-700/50 p-6">
                
                <!-- Controls Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-bold text-white tracking-wide">
                        All Faculty Members
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('teachers.index') }}" class="flex items-center gap-2">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search teacher or subject..." 
                                class="bg-[#0f172a] border border-slate-700 text-gray-200 placeholder-gray-400 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            />
                            <button 
                                type="submit" 
                                class="bg-[#0f172a] hover:bg-slate-900 border border-slate-700 text-xs font-bold uppercase tracking-wider text-gray-200 px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm"
                            >
                                SEARCH
                            </button>
                        </form>

                        <!-- Add Teacher Button -->
                        @if(Auth::user()->isAdmin())
                            <a 
                                href="{{ route('teachers.create') }}" 
                                class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md inline-flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                + ADD TEACHER
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-700/60">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1a2234] border-b border-slate-700 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                <th scope="col" class="px-6 py-4">TEACHER NAME</th>
                                <th scope="col" class="px-6 py-4">EMAIL</th>
                                <th scope="col" class="px-6 py-4">SUBJECT / DEPARTMENT</th>
                                <th scope="col" class="px-6 py-4">PHONE</th>
                                <th scope="col" class="px-6 py-4 text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/60 text-sm">
                            @forelse($teachers as $teacher)
                                <tr class="hover:bg-slate-800/50 transition-colors duration-150">
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ $teacher->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-300">
                                        {{ $teacher->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-indigo-900/40 text-indigo-300 border border-indigo-700/50">
                                            {{ $teacher->subject ?? $teacher->department ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $teacher->phone ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center space-x-2">
                                            <a 
                                                href="{{ route('teachers.edit', $teacher->id) }}" 
                                                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-lg transition"
                                            >
                                                Edit
                                            </a>
                                            @if(Auth::user()->isAdmin())
                                                <form method="POST" action="{{ route('teachers.destroy', $teacher->id) }}" onsubmit="return confirm('Delete this teacher record?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white font-semibold text-xs rounded-lg transition"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">
                                        No teachers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($teachers, 'links'))
                    <div class="mt-6">
                        {{ $teachers->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>