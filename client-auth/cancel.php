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
  <h1>NICEPAY TEST</h1>
  <form method="POST" action="./cancelResponse.php">
    <label>tid</label><br>
    <input type="text" name="tid" ><br>

    <label>amount</label><br>
    <input type="text" name="amount" ><br><br>

    <input type="submit" value="취소요청">
  </form> 
</body>

</html>