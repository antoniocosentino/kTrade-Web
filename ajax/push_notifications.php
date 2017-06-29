<?
$user_key = "xxx";
$app_key ="xxx";
$url = "https://api.pushover.net/1/messages.json";


$devices_arr[0] = "iPhone";

foreach ($devices_arr as $single_device) {
	
	$device = $single_device;
	$message = $_POST['message'];

	$array['token'] = $app_key;
	$array['user'] = $user_key;
	$array['message'] = $message;
	$array['device'] = $device;


	$options = array(
	        'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($array),
	    )
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	//var_dump($result);

}

?>