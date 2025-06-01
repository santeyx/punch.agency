   <?php

   namespace App\Jobs;

   use Illuminate\Contracts\Queue\ShouldQueue;
   use Illuminate\Foundation\Queue\Queueable;

   class SendTelegramMessage implements ShouldQueue
   {
       use Queueable;

       protected $chat_id;
       protected $message;

       public function __construct($chat_id, $message)
       {
           $this->chat_id = $chat_id;
           $this->message = $message;
       }

       public function handle()
       {
       		\App\Telegram::sendMessage($this->chat_id, $this->message);
       }
   }

