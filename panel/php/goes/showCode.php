<?php
    include "../dbConnection.php";
    $link = Conectarse();

    $ciudad=$_POST['selectedCity'];

   if($ciudad==null){
       mysqli_close($link);
       die();
    } else {
        $sql="SELECT id_club, nombre_club from club where id_ciudad=$ciudad;";

        $result=mysqli_query($link,$sql);

        $row_cnt = $result->num_rows;

        if($row_cnt===0){
            "<div class='input-group-prepend'>
            <span class='input-group-text'><i class='fas fa-user'></i></span>
            </div>
            <select id=selectClub name='selectClub' class='form-control'disable>";

        } else {
            $cadena="<div class='input-group-prepend'>
            <span class='input-group-text'><i class='fas fa-barcode'></i></span>
            </div>
            <input type='text' id='clubCode' name='clubCode' class='form-control' placeholder='Codigo de equipo'></input>";



            echo $cadena;
            
        }
   }



    

?>