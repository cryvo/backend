<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // You can store conversation history in DB if you like, for context
        $userMessage = $request->message;

        // Call OpenAI (ensure you have OPENAI_API_KEY in .env)
        $response = OpenAI::chat()->create([
            'model'    => 'gpt-4o-mini',
            'messages' => [
                ['role'=>'system','content'=> 'You are Cryvo AI Support. Help the user.'],
                ['role'=>'user'  ,'content'=> $userMessage],
            ],
            'temperature' => 0.2,
            'max_tokens'  => 500,
        ]);

        $assistant = trim($response->choices[0]->message->content);

        return response()->json([
            'reply' => $assistant
        ]);
    }
}

{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Call OpenAI
        $response = OpenAI::chat()->create([
            'model'    => 'gpt-4o-mini',
            'messages' => [
                ['role'=>'system','content'=> 'You are Cryvo AI Support. Assist users with Cryvo features.'],
                ['role'=>'user'  ,'content'=> $request->message],
            ],
            'temperature' => 0.2,
            'max_tokens'  => 500,
        ]);

        $reply = trim($response->choices[0]->message->content);

        return response()->json(['reply' => $reply]);
    }
}
