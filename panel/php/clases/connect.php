<?php

$host="localhost";
$puerto="3306";
$user="root";
$password="martin07081988";
// $user="intranet";
// $password="qwertyQXE59oplm%";
$baseDeDatos="accesoBodega";

try{
    $con = new PDO("mysql:host=$host; dbname=$baseDeDatos",$user,$password);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    print "error ".$e->getMessage();
    die();
}

 ?>
