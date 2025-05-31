<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendTelegramMessage;

class NotifyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all tasks for notify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'https://jsonplaceholder.typicode.com/todos';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error Curl: ' . curl_error($ch);
        } else {
            $todos = json_decode($response, true);

            foreach($todos as $todo) {
            	if ($todo['completed'] == false && $todo['userId'] <= 5) {
            		$users = \App\User::where('subscribed', true)->get();

            		foreach($users as $user) {
            			SendTelegramMessage::dispatch($user->telegram_id, $todo['title']);
            		}
            	}
            }
        }

        curl_close($ch);
    }
}
