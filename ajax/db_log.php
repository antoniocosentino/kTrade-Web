<?

$mysql_host = "xxx";
$mysql_password = 'xxx';
$mysql_database = "xxx";
$mysql_username = "xxx";

$mysqli = mysqli_connect("$mysql_host", "$mysql_username", "$mysql_password", "$mysql_database") or die("Error " . mysqli_error($mysqli_conn_1));

$value = $_POST['value'];
$symbol = $_POST['symbol'];


$query = "INSERT INTO logs (day, moment, value, product_name) VALUES (now(), now(), $value, '$symbol')";


if ($mysqli->query($query)){
	//echo "OK";
	//echo $query;
}
else{
	echo "KO";
}




?>
