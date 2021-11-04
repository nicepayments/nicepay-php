<?php
header("Content-Type:text/html; charset=utf-8;"); 

$uniqId = uniqid();
$clientId = "S1_6eaa0db1afdc41f3becb770878d67d25";

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
  <button onclick="clientAuth()">clientAuth 결제하기</button>

  <script src="https://pay.nicepay.co.kr/v1/js/"></script> <!--nicepay payment-window client-auth-->

  <script>
    function clientAuth() {
      AUTHNICE.requestPay({
        clientId: '<?php echo($clientId)?>',
        method: 'card',
        orderId: '<?php echo($uniqId)?>',
        amount: 1004,
        goodsName: '나이스페이-상품',
        returnUrl: 'http://localhost:80/client-auth/response.php',
        fnError: function (result) {
          alert('개발자확인용 : ' + result.errorMsg + '')
        }
      });
    }
  </script>
</body>

</html>