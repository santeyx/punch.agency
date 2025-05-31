<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Telegram
{
	/**
	 * [$token description]
	 * @var string
	 */
	private static $token = '';

	/**
	 * [$main_url description]
	 * @var string
	 */
    private static $main_url = 'https://api.telegram.org/bot';

	public static function getUpdates() {
		self::$token = config('app.telegram_token');

		$response = file_get_contents(self::$main_url . self::$token . '/getUpdates');
		$updates = json_decode($response, true);

		if (!empty($updates['result'])) {
		    $chat_id = $updates['result'][0]['message']['chat']['id'];
		    $user_id = $updates['result'][0]['message']['from']['id'];
		}
    }

    /**
     * [setWebhook description]
     */
    public static function setWebhook() {
    	$domain = config('app.domain');
    	self::$token = config('app.telegram_token');

		$url = self::$main_url . self::$token . '/setWebhook?url=' . $domain . '/webhook';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if ($response === false) {
		    echo 'Error Curl: ' . curl_error($ch);
		}

		curl_close($ch);
    }

    /**
     * [sendMessage description]
     * @param  [type] $chat_id            [description]
     * @param  [type] $text               [description]
     * @param  array  $additional_params [description]
     * @return [type]                     [description]
     */
    public static function sendMessage($chat_id, $text, $additional_params=[]) {
    	self::$token = config('app.telegram_token');
	    $url = self::$main_url . self::$token . '/sendMessage';

	    $params = [
	        'chat_id' => $chat_id,
	        'text' => $text,
	        'parse_mode' => 'HTML',
	        'disable_web_page_preview' => false
	    ];

	    $params = array_merge($params, $additional_params);

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $response = curl_exec($ch);

	    if ($response === false) {
	        echo 'Error Curl: ' . curl_error($ch);
	    }

	    curl_close($ch);
    }

    /**
     * [sendPhoto description]
     * @param  [type] $chat_id   [description]
     * @param  [type] $photo_url [description]
     * @param  [type] $text      [description]
     * @param  array  $additional_params [description]
     * @return [type]            [description]
     */
    public static function sendPhoto($chat_id, $photo_url, $text, $additional_params=[]) {
        self::$token = config('app.telegram_token');
	    $url = self::$main_url . self::$token . '/sendPhoto';

	    $params = [
	        'chat_id' => $chat_id,
	        'photo' => $photo_url,
	        'caption' => $text,
	        'parse_mode' => 'HTML',
	        'disable_web_page_preview' => false
	    ];

	    $params = array_merge($params, $additional_params);

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $response = curl_exec($ch);

	    if ($response === false) {
	        echo 'Error Curl: ' . curl_error($ch);
	    }

	    curl_close($ch);
    }

    /**
     * [getChat description]
     * @param  [type] $chat_id [description]
     * @return [type]          [description]
     */
    public static function getChat($chat_id) {
    	self::$token = config('app.telegram_token');
    	$url = self::$main_url . self::$token . '/getChat';

	    $params = [
	        'chat_id' => $chat_id
	    ];

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $response = curl_exec($ch);

	    if ($response === false) {
	        echo 'Error Curl: ' . curl_error($ch);
	    }

	    curl_close($ch);

	    $chat = json_decode($response, true);

	    if (isset($chat['ok']) && $chat['ok']) {
	    	return $chat;
	    } else {
	    	return false;
	    }
    }

}