   <?php

   namespace App\Jobs;

   use IlluminateBusQueueable;
   use IlluminateContractsQueueShouldQueue;
   use IlluminateFoundationBusDispatchable;
   use IlluminateQueueInteractsWithQueue;
   use IlluminateQueueSerializesModels;

   class SendTelegramMessage implements ShouldQueue
   {
       use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

