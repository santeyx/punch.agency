<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
    }

	/**
     * Show the main application page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	//
    }

    /**
     * [webhook description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function webhook(Request $request)
    {
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);

        if (isset($update["message"])) {
            $chat_id = $update["message"]["chat"]["id"];
            $telegram_id = $update["message"]["from"]["id"];
		    $username = $update["message"]["from"]["username"];
		    $first_name = $update["message"]["from"]["first_name"];
		    $last_name = $update["message"]["from"]["last_name"];

            $text = $update["message"]["text"];

            switch ($text) {
                case "/start":
                	if ($user = \App\User::where('telegram_id', $telegram_id)->first()) {
                		$response = "The user @{$user->name} is already registered.";
                	} else {
                		if ($chat = \App\Telegram::getChat($telegram_id)) {
			                $user = \App\User::create([
			                    'name' => $username,
			                    'telegram_id' => $telegram_id
			                ]);
			            } else {
			            	$response = "Something is wrong.";
			            }
                	}
                    break;
                case "/stop":
                	if ($user = \App\User::where('telegram_id', $telegram_id)->first()) {
                		$user->subscribed = false;
                		$user->save();

                		$response = "You have successfully unsubscribed.";
                	} else {
                		$response = "User not found.";
                	}
                    break;
                default:
                    $response = "Unknown command.";
                    break;
            }

            \App\Telegram::sendMessage($chat_id, $response);
        }
    }

    /**
     * [setwebhook description]
     * @return [type] [description]
     */
    public function setwebhook()
    {
        \App\Telegram::setWebhook();
    }

}
