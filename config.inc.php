<?

function kprint($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function kcurl($url){
	$curl = curl_init();
	curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $url));
	$resp = curl_exec($curl);
	curl_close($curl);
	$resp_obj = json_decode($resp);
	return $resp_obj;
}


$consumer_key = "xxx";
$consumer_secret = "xxx";
$redirect = "https://www.kultmedia.com/varie/KTRADE/response.php";
$access_url = "https://connect.spotware.com/oauth/v2/auth";
$token_url = "https://connect.spotware.com/oauth/v2/token";

$api_url = "https://api.spotware.com";

?>