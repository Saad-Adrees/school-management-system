<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chatbot user queries.
     */
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $apiKey = env('OPENAI_API_KEY');

        // Check if API key is missing or still set to placeholder
        if (!$apiKey || $apiKey === 'your_actual_openai_api_key_here') {
            return response()->json([
                'reply' => 'OpenAI API key is missing. Please set your actual OPENAI_API_KEY in the .env file and run "php artisan config:clear".'
            ], 400);
        }

        try {
            // Http::withoutVerifying() bypasses local cURL SSL certificate verification issues on XAMPP/localhost
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($apiKey),
                    'Content-Type'  => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful School AI Assistant integrated into a School Management System. Assist users (admins, teachers, students) with questions about attendance, marking systems, student records, teacher dashboards, and general platform guidance concise and clearly.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->input('message')
                        ]
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $reply = $response->json('choices.0.message.content');
                return response()->json(['reply' => $reply]);
            }

            // Log detailed API response error to storage/logs/laravel.log
            Log::error('OpenAI API Error Response: ' . $response->body());
            
            return response()->json([
                'reply' => 'Sorry, I am having trouble connecting to the AI server right now. (Status Code: ' . $response->status() . ')'
            ], 500);

        } catch (\Exception $e) {
            // Log exceptions to storage/logs/laravel.log
            Log::error('Chatbot Controller Exception: ' . $e->getMessage());

            return response()->json([
                'reply' => 'Sorry, I am having trouble connecting to the AI server right now.'
            ], 500);
        }
    }
}