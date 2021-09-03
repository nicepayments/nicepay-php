<?php
header("Content-Type:text/html; charset=utf-8;"); 
?>

<!DOCTYPE html>
<html>

<head>
  <title>Nicepay php</title>
  <meta httpEquiv="x-ua-compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
  <h1><?php echo($_POST['resultMsg']) ?></h1>
  <p>상세한 응답 body는 log를 확인해주세요</p>
  <hr>
  <?php
    foreach ($_POST as $key => $value)
	echo $key.'='.$value.'<br />';
  ?>
</body>

</html>