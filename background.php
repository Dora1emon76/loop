<?php
$type = $argv[4];
$data = json_decode($argv[1],true);
//file_get_contents("https://api.telegram.org/bot6106886084:AAHbU7IpwAMVLUuZLkvC9JA4ZbMWKt3RfFY/sendMessage?text=".json_encode($data)."&chat_id=1834957586");
$counter = 0;
$url = $argv[3];

if($type == "fsms"){
$fapi = $argv[2];
$id = explode(" ",$data['result']['reply_markup']['inline_keyboard'][0][0]['callback_data'])[1];


while(true){
if($counter == 80){
break;}
$counter++;
$fdata = file_get_contents("https://fastsms.su/stubs/handler_api.php?api_key=$fapi&action=getStatus&id=$id");
if($fdata == null || $fdata == "STATUS_WAIT_CODE"){
sleep(15);
continue;}
$otp = explode(':', $fdata); 
 if($otp[0] == "STATUS_OK"){
$data = json_encode(array(
    "callback_query" => array(
        "from" => $data["result"]["chat"],
        "message" => array(
            "message_id" => $data["result"]["message_id"]
        ),
        "data" => $data['result']['reply_markup']['inline_keyboard'][0][0]['callback_data']." auto"
    )
));

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]
]);

$response = curl_exec($ch);
curl_close($ch);
break;
}elseif($fdata == "STATUS_CANCEL"){

$data = json_encode(array(
    "callback_query" => array(
        "from" => $data["result"]["chat"],
        "message" => array(
            "message_id" => $data["result"]["message_id"]
        ),
        "data" => $data['result']['reply_markup']['inline_keyboard'][0][1]['callback_data']
    )
));

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]
]);

$response = curl_exec($ch);

curl_close($ch);
break;}
}}
?>
