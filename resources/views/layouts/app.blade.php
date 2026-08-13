<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'School Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS & Alpine.js CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0f172a] text-gray-100 min-h-screen selection:bg-indigo-500 selection:text-white">
        
        <div class="min-h-screen bg-[#0f172a]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#1e293b] border-b border-slate-700/60 shadow-md">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- ========================================== -->
        <!--     FLOATING AI CHATBOT ASSISTANT WIDGET   -->
        <!-- ========================================== -->
        {{-- 
        <div x-data="{ open: false, messages: [], input: '', loading: false }" class="fixed bottom-6 right-6 z-50">
            
            <!-- Floating Toggle Button -->
            <button @click="open = !open" 
                    class="bg-indigo-600 hover:bg-indigo-500 text-white p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <!-- Chat Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!open">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                </svg>
                <!-- Close Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="open" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Chat Modal Window -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="absolute bottom-16 right-0 w-80 sm:w-96 bg-[#1e293b] border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden flex flex-col h-[480px]"
                 style="display: none;">
                
                <!-- Chat Header -->
                <div class="bg-[#1a2234] p-4 border-b border-slate-700/80 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <div>
                            <h3 class="font-bold text-white text-sm">School Assistant</h3>
                            <p class="text-[10px] text-gray-400">Powered by AI</p>
                        </div>
                    </div>
                    <button @click="open = false" class="text-gray-400 hover:text-white text-xs font-bold">✕</button>
                </div>

                <!-- Chat Conversation Area -->
                <div class="flex-1 p-4 overflow-y-auto space-y-3" id="chat-box">
                    <!-- Initial Welcome Message -->
                    <div class="bg-[#0f172a] text-gray-200 text-xs p-3 rounded-xl max-w-[85%] border border-slate-700/60 leading-relaxed shadow-sm">
                        Hello! 👋 I am your School AI Assistant. How can I help you today?
                    </div>

                    <!-- Dynamic Messages -->
                    <template x-for="(msg, index) in messages" :key="index">
                        <div :class="msg.role === 'user' ? 'ml-auto bg-indigo-600 text-white' : 'mr-auto bg-[#0f172a] text-gray-200 border border-slate-700/60'"
                             class="text-xs p-3 rounded-xl max-w-[85%] leading-relaxed shadow-sm">
                            <p x-text="msg.text"></p>
                        </div>
                    </template>

                    <!-- Typing Indicator -->
                    <div x-show="loading" class="mr-auto bg-[#0f172a] text-gray-400 text-xs p-3 rounded-xl border border-slate-700/60 italic flex items-center space-x-1" style="display: none;">
                        <span>Assistant is thinking...</span>
                    </div>
                </div>

                <!-- Input Form -->
                <form @submit.prevent="
                    if (!input.trim() || loading) return;
                    let userText = input;
                    messages.push({ role: 'user', text: userText });
                    input = '';
                    loading = true;

                    $nextTick(() => { 
                        const box = document.getElementById('chat-box'); 
                        box.scrollTop = box.scrollHeight; 
                    });

                    fetch('{{ route('chatbot.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: userText })
                    })
                    .then(res => res.json())
                    .then(data => {
                        messages.push({ role: 'bot', text: data.reply });
                        loading = false;
                        $nextTick(() => { 
                            const box = document.getElementById('chat-box'); 
                            box.scrollTop = box.scrollHeight; 
                        });
                    })
                    .catch(() => {
                        messages.push({ role: 'bot', text: 'An error occurred. Please check your network connection or API settings.' });
                        loading = false;
                    });
                " class="p-3 border-t border-slate-700/80 bg-[#0f172a] flex gap-2">
                    <input type="text" 
                           x-model="input" 
                           placeholder="Type a message..." 
                           class="flex-1 bg-[#1e293b] border border-slate-700 text-gray-200 text-xs rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-400">
                    <button type="submit" 
                            :disabled="loading" 
                            class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2.5 rounded-xl font-bold transition-all duration-200 disabled:opacity-50">
                        Send
                    </button>
                </form>
            </div>
        </div>
        --}}

    </body>
</html>