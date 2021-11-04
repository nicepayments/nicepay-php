<?php
header("Content-Type:text/html; charset=utf-8;");

$tid = $_POST['tid'];
$amount = $_POST['amount'];

$clientId = 'S2_af4543a0be4d49a98122e01ec2059a56';
$secretKey = '9eb85607103646da9f9c02b128f2e5ee';

$resObject = '';

try {
	$res = requestPost(
		"https://sandbox-api.nicepay.co.kr/v1/payments/" . $tid,
		json_encode(array("amount" => $amount)),
		$clientId . ':' . $secretKey
	);
	$resObject = json_decode($res);
} catch (Exception $e) {
	$e->getMessage();
}

//CURL: Basic auth, json, post
function requestPost($url, $json, $userpwd)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Nicepay php</title>
	<meta httpEquiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
	<h1><?php echo ($resObject->{'resultMsg'}) ?></h1>
	<p>상세한 응답 body는 log를 확인해주세요</p>
	<hr>
	<?php
	foreach ($resObject as $key => $value)
		echo $key . '=' . $value . '<br />';
	?>
</body>

</html>