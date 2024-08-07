<?php
$data = json_decode(file_get_contents("php://input"),true);
if(isset($data["type"])){
/*file_get_contents("https://api.telegram.org/bot6106886084:AAHbU7IpwAMVLUuZLkvC9JA4ZbMWKt3RfFY/sendMessage?text=".$type."&chat_id=1834957586");*/
//file_put_contents("data.txt",$data["data"]);
if($data["type"] == "fsms"){
$command = "php background.php ".("'".$data["data"]."'")." ".$data['fapi']." ".$data['url']." ".$data['type']." > /dev/null 2>&1 &";

}
exec($command);
}
echo "done";
?>
