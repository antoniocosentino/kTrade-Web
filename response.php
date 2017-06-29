<?
include("config.inc.php");
$code = $_GET['code'];

$full_url = $token_url . "?grant_type=authorization_code&code=" . $code . "&redirect_uri=" . $redirect . "&client_id=" . $consumer_key . "&client_secret=" . $consumer_secret;



$curl = curl_init();
curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $full_url));
$resp = curl_exec($curl);
curl_close($curl);

$resp_obj = json_decode($resp);

session_start();
//$_SESSION['access_token'] = $resp_obj->access_token;
//$_SESSION['refresh_token'] = $resp_obj->refresh_token;

$at = $resp_obj->accessToken;

$_SESSION['access_token'] = $at;
$_SESSION['refresh_token'] = $resp_obj->refreshToken;


//kprint($resp_obj);

header("Location: app.php");

?>



 

