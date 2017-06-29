<?
session_start();
include("config.inc.php");


foreach ($_SESSION as $key => $value) {
	$_SESSION[$key] = null;
}

/*
if (require_once('oauth/lib/oauth.php')){ echo "ok"; } else{ echo "ko"; } */
//$oauth = new OAuth\Core\Consumer($consumer_key, $consumer_secret);
//$response = $oauth->request($access_url);
//$response = $oauth->sign($access_url);

$full_url = $access_url . "?access_type=online&approval_prompt=auto&client_id=" . $consumer_key . "&redirect_uri=" . $redirect . "&response_type=code&scope=trading";

header("Location: $full_url");
exit;
?>

