<?php
namespace App\Http\Controllers\API;
namespace App\Services;
use OpenAI;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChatbotService;

class ChatbotController extends Controller
{
    public function chat(Request $req, ChatbotService $bot)
    {
        $req->validate(['message'=>'required|string']);
        $reply = $bot->ask($req->input('message'));
        return response()->json(['reply'=>$reply]);
    }
}
<?php
// File: backend/app/Services/ChatbotService.php

class ChatbotService
{
    protected $client;
    protected $faqText;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.key'));
        // Load FAQ array and format as plain text
        $faq = Setting::get('crybot-faq', []);
        $this->faqText = '';
        foreach ($faq as $item) {
            $this->faqText .= "Q: {$item['q']}\nA: {$item['a']}\n\n";
        }
    }

    public function ask(string $msg): string
    {
        $system = <<<EOD
You are C.V.A., the Cryvo Virtual Assistant. Use the following CryBot FAQ to answer user questions:

{$this->faqText}

Now answer the user’s question based on the FAQ and your full knowledge of Cryvo and CryBot.
EOD;

        $resp = $this->client->chat()->create([
            'model'    => 'gpt-4',
            'messages' => [
                ['role'=>'system','content'=>$system],
                ['role'=>'user','content'=>$msg],
            ],
        ]);

        return trim($resp['choices'][0]['message']['content'] ?? '');
    }
}
