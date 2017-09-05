<?php
namespace App\Http\Controllers;

date_default_timezone_set('Europe/London');

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Auth;

class ChatController extends Controller
{
    var $pusher;
    var $user;
    var $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'chat';

    public function postMessage(Request $request, $chat)
    {
        $this->pusher = App::make('pusher');
        $this->user = Auth::user();
        $this->chatChannel = $chat;

        $text = e($request->input('chat_text'));

        $message = [
            'text' => $text,
            'username' => $this->user->name,
            'email' => $this->user->email,
            'avatar' => $this->user->avatar,
            'timestamp' => (time()*1000),
            'chat' => $chat
        ];
        $this->pusher->trigger($this->chatChannel, 'new-message', $message);

        $messageDB = new \App\Message();        
        $messageDB->user = Auth::user()->id;
        $messageDB->chatID = (int)substr($chat, 4);
        $messageDB->text = $text;
        $messageDB->created_at = time();
        $messageDB->save();
    }

    public function getMessages($chat) {
        $id = (int)substr($chat, 4);
        $messages = \App\Message::where('chatID', $id)->get();
        foreach($messages as $message) {
            $message->userObject = \App\User::find($message->user); 
        }
        echo $messages;
    }

    public function createChannel($user) {
        $chat = new \App\Chat();
        $chat->userID_1 = Auth::User()->id;
        $chat->userID_2 = (int)substr($user, 4);
        $chat->save();
    }

    public function createChat($user) {
        $chat = new \App\Chat();
        $chat->userID_1 = Auth::User()->id;
        $chat->userID_2 = (int) $user;
        $chat->save();

        echo $chat->id;
    }
}
