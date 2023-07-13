<?php
// توکن ربات
$bot_token = 'BOT_TOKEN';

$api_url = 'https://api.telegram.org/bot'.$bot_token.'/';
$request_url = $api_url . 'getUpdates';
$request_params = array(
    'offset' => '-1'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$request_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query($request_params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$get_updates = curl_exec($ch);
curl_close ($ch);

$response = json_decode($get_updates);
if ($response->ok && count($response->result) > 0) {
    foreach ($response->result as $result) {
        $update_id = $result->update_id;
        $request_url = $api_url . 'getUpdates';
        $request_params = array(
            'offset' => $update_id + 1
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$request_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query($request_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $delete_update = curl_exec($ch);
        curl_close ($ch);
    }
}

echo 'پاک کردن اپدیت های در انتظار با موفقیت انجام شد.';
?>
