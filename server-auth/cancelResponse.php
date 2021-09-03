<?php
header("Content-Type:text/html; charset=utf-8;");

$tid = $_POST['tid'];
$amount = 1004;
$reason = 'test';
$orderId = uniqid();

$clientId = '클라이언트 키';
$secretKey = '시크릿 키';

$resObject = '';

$json =  json_encode(array("amount" => $amount, "reason" => $reason, "orderId" => $orderId));

try {
	$res = requestPost(
		"https://api.nicepay.co.kr/v1/payments/". $tid ."/cancel",
		json_encode(
			array("amount" => $amount, 
				  "reason" => $reason, 
				  "orderId" => $orderId)
		),
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