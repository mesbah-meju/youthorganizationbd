<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Auth;
use App\Models\TicketReply;
use App\Mail\SupportMailManager;
use Mail;

use Laravel\Sanctum\PersonalAccessToken;


class TicketController extends Controller
{
    public function store(Request $request)
    {
        $ticket = new Ticket;
        $ticket->code = strtotime(date('Y-m-d H:i:s')) . Auth::user()->id;
        $ticket->user_id = Auth::user()->id;
        $ticket->subject = $request->subject;
        $ticket->details = $request->details;
        $ticket->files = $request->attachments;

        if ($ticket->save()) {
            $this->send_support_mail_to_admin($ticket);
            return response()->json([
                'result' => true,
                'message' => translate('Ticket has been sent successfully.')
            ], 200);
        }
        return response()->json([
            'result' => false,
            'message' => translate('Something went wrong.'),
        ], 404);   
    }

    public function send_support_mail_to_admin($ticket)
    {
        $array['view'] = 'emails.support';
        $array['subject'] = translate('Support ticket Code is') . ':- ' . $ticket->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = translate('Hi. A ticket has been created. Please check the ticket.');
        $array['link'] = route('support_ticket.admin_show', encrypt($ticket->id));
        $array['sender'] = $ticket->user->name;
        $array['details'] = $ticket->details;
        try {
            Mail::to(get_admin()->email)->queue(new SupportMailManager($array));
        } catch (\Exception $e) {}
    }


}
