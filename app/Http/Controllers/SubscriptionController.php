<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{CrybotSubscription,CrybotPlan};
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
  public function activate(Request $req)
  {
    $plan = CrybotPlan::find($req->plan_id);
    $expires = Carbon::now()->addDays($plan->duration_days);
    $sub = CrybotSubscription::updateOrCreate(
      ['user_id'=>auth()->id(),'market'=>$plan->market],
      ['expires_at'=>$expires,'plan_id'=>$plan->id]
    );
    // Telegram invite link
    $bot  = config('services.telegram.bot_token');
    $chat = config("services.telegram.{$plan->market}_channel_id");
    $resp = Http::post("https://api.telegram.org/bot{$bot}/createChatInviteLink",[
        'chat_id'=>$chat,'expire_date'=>$expires->timestamp,'member_limit'=>1
    ]);
    $link = $resp->json('result.invite_link');
    $sub->update(['telegram_invite_link'=>$link]);
    return response()->json(['invite_link'=>$link,'expires_at'=>$expires]);
  }

  public function link(Request $req)
  {
    $sub = CrybotSubscription::where('user_id',auth()->id())
            ->where('market',$req->market)->firstOrFail();
    return response()->json([
      'invite_link'=>$sub->telegram_invite_link,
      'mode'=>$sub->mode
    ]);
  }

  public function updateMode(Request $req)
  {
    $req->validate(['mode'=>'required|in:regular,scalping,both']);
    $sub = CrybotSubscription::firstOrCreate(
      ['user_id'=>auth()->id(),'market'=>$req->market],
      ['expires_at'=>now()->addMonth()]
    );
    $sub->mode = $req->mode; $sub->save();
    return response()->json(['mode'=>$sub->mode]);
  }
}
