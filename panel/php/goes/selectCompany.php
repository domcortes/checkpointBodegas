<?php

	session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $_SESSION['idEmpresa'] = $_POST['idEmpresa'];
    header("Location: ../../home.php");
            ob_end_flush();
            exit;
  }
?>