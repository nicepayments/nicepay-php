<?php
header("Content-Type:text/html; charset=utf-8;");

$clientId = '클라이언트 키';
$secretKey = '시크릿 키';

$key = substr($secretKey, 0, 32);
$iv = substr($secretKey, 0, 16);
$resObject = '';

$plainText = "cardNo=". $_POST['cardNo'] . 
			"&expYear=" . $_POST['expYear'] . 
			"&expMonth=" . $_POST['expMonth'] . 
			"&idNo=" . $_POST['idNo']. 
			"&cardPw=" . $_POST['cardPw'];

try {
	$res = requestPost(
		"https://api.nicepay.co.kr/v1/subscribe/regist",
		json_encode(
			array("encData" => encrypt($plainText, $key, $iv), 
				  "orderId" => uniqid(), 
				  "encMode" => 'A2')
		),
		$clientId . ':' . $secretKey
	);

	$resObject = json_decode($res);
	$bid = $resObject->{'bid'};

} catch (Exception $e) {
	$e->getMessage();
}


function billing($bid){
	global $clientId;
	global $secretKey;

	try {
		$res = requestPost(
			"https://api.nicepay.co.kr/v1/subscribe/" . $bid . "/payments",
			json_encode(
				array("orderId" => uniqid(), 
					"amount" => 1004, 
					"goodsName" => 'test',
					"cardQuota" => 0,
					"useShopInterest" => false)
			),
			$clientId . ':' . $secretKey
		);
	
		return $res;
	} catch (Exception $e) {
		return $e->getMessage();
	}	
}


function expire($bid){
	global $clientId;
	global $secretKey;

	try {
		$res = requestPost(
			"https://api.nicepay.co.kr/v1/subscribe/" . $bid . "/expire",
			json_encode(
				array("orderId" => uniqid())
			),
			$clientId . ':' . $secretKey
		);
	
		return $res;
	} catch (Exception $e) {
		return $e->getMessage();
	}	
}

function encrypt($text, $key, $iv){
	$encrypted = openssl_encrypt($text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
	return bin2hex($encrypted);
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