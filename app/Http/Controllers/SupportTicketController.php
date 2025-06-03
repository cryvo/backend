// SupportTicketController.php
<?php
namespace App\Http\Controllers;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller {
  public function index(){
    return SupportTicket::where('user_id',auth()->id())->paginate(10);
  }
  public function store(Request $r){
    $r->validate(['subject'=>'required','message'=>'required']);
    return SupportTicket::create([
      'user_id'=>auth()->id(),
      'subject'=>$r->subject,
      'message'=>$r->message
    ]);
  }
  public function show(SupportTicket $ticket){
    $this->authorize('view',$ticket);
    return $ticket;
  }
  public function update(Request $r, SupportTicket $ticket){
    $this->authorize('update',$ticket);
    $r->validate(['status'=>'in:open,pending,resolved']);
    $ticket->update(['status'=>$r->status]);
    return $ticket;
  }
}
