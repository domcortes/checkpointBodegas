<?php
require_once './vendor/autoload.php';
use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use Transbank\Webpay\WebpayPlus\Transaction;

$token = filter_input(INPUT_POST, 'TBK_TOKEN');
$response = Transaction

$output = $result->detailOutput;
if ($response->responseCode ===0) {
  echo '<script>window.localStorage.clear();</script>';
  echo '<script>window.localStorage.setItem("authorizationCode",'.$response->getAuthorizationCode.');</script>';
  echo '<script>window.localStorage.setItem("amount",'.$response->getAmount.');</script>';
  echo '<script>window.localStorage.setItem("buyOrder",'.$response->getBuyOrder.');</script>';
}


?>
<?php if ($output->responseCode==0) : ?>
  <form action="<?php echo $result->urlRedirection; ?>" method="post" id="return-form">
  <input type="hidden" name="token_ws" value="<?php echo $tokenWS; ?>">
</form>

<script>
  document.getElementById('return-form').submit();
</script>
<?php endif; ?>