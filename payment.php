<?php
// require_once('html/crudTeleventaRemoto.php');
// require_once('./vendor/autoload.php');
// use Transbank\Webpay\Webpay;
// use Transbank\Webpay\Configuration;
// use Transbank\Webpay\WebpayPlus\Transaction;

// $a = $_GET['a'];
// $o = $_GET['o'];
// $m = $_GET['m'];
// $p = $_GET['p'];

// $url = 'www.chelech.cl/panel/pages/forms/botonDone.php?a='.$a.'&o='.$o.'&m='.$m.'&p='.$p;

// $obj = new metodosTeleventaRemoto();
// $sql = "SELECT * FROM url where urlText='".$url."'";
// $buscarUrl = $obj->buscarURLremoto($sql);
// if(sizeof($buscarUrl)===0){
//     echo
//         '<script>
//             alert("URL No válida, será redirigido a Empresas Chelech");
//             window.location="/";
//         </script>';
// }else{
//     $sqlBoleta = "SELECT * from url where urlText='".$url."' and boleta='0'";
//     $validar = $obj->buscarURLremoto($sqlBoleta);

//     if(sizeof($validar)===0){
//         echo
//             '<script>
//                 alert("Este link ya se encuentra pagado y con documento tributario emitido.\nPor favor contactar a su ejecutivo de ventas para solicitar su comprobante");
//                 window.location="/";
//             </script>';
//     }else{
//         $fc = date('Y-m-d',strtotime($validar[0]['fechaCreacion']));
//         $fh = date('Y-m-d');

//         $date1= new DateTime($fc);
//         $date2= new DateTime($fh);
//         $diff = $date1->diff($date2);

//         $dif = $diff->days;

//         if($dif<=1){

//             $amount=base64_decode(base64_decode(base64_decode($a)));
//             $buy_order = base64_decode(base64_decode(base64_decode($o)));
//             $session_id = $buyOrder;
//             $mail=base64_decode(base64_decode(base64_decode($m)));
//             $phone=base64_decode(base64_decode(base64_decode($p)));
//             $return_url = 'http://www.chelech.cl/return.php';
//             $response = Transaction::create($buy_order, $session_id, $amount, $return_url);

//             $formAction = $response->getUrl();
//             $token = $response->getToken();
//         }else{
//             echo
//                 '<script>
//                     alert("URL expiró, será redirigido a Empresas Chelech");
//                     window.location="/";
//                 </script>';
//         }
//     }
// }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Pago Click</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/pricing/">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.6/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/4.6/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/4.6/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon.ico">
    <meta name="msapplication-config" content="/docs/4.6/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-warning border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-normal"><img src="https://chelech.cl/img/sections/slider/s5.png" alt="" width= "40%"; height="40%"></h5>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Boton de Pago</h1>
      <p class="lead">A continuacion entregamos detalles para pago por su compra en Empresas Chelech:</p>
    </div>

    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Detalle de transaccion</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><?php echo '$ '.number_format($amount,0,',','.'); ?><small class="text-muted">clp</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Su correo de confirmacion: <?php echo $mail; ?></li>
              <li>Vale transitorio # <?php echo $buy_order; ?></li>
            </ul>
            <form action="<?php echo $formAction; ?>" method="POST" class="form-inline" role="form">
                <input type="hidden" name="token_ws" value="<?php echo $token; ?>">
                <button type="submit" class="btn btn-lg btn-block btn-success">Pagar con WEBPAY <img src="img/tbkUser/07_Logo_webpay_plus-300px.png" alt="" width="120" heigth="60"></button>
            </form>
          </div>
        </div>
      </div>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <h5 class="my-0 mr-md-auto font-weight-normal">
                <img src="https://chelech.cl/img/sections/slider/s5.png" alt="" width= "40"; height="40">
                <span id="siteseal">
                    <script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=IBzf8XtGf1VUOcYwuNrS6AyfcD75w9JCMsiIoFRvEKT5xi65qYbs4Poja20j"></script>
                </span>
            </h5>
            <small class="d-block mb-3 text-muted">Empresas Chelech &copy; 2021</small>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>