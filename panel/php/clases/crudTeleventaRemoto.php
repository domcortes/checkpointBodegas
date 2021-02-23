<?php
  require_once("remote.php");

    class metodosTeleventaRemoto{
      public function buscarURLremoto($sql){
            $c = new remote();
            $conexion = $c->conectarRemoto();
            $result = mysqli_query($conexion,$sql);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insertarURLremoto($datos){
          $c = new remote();
          $conexion = $c->conectarRemoto();
          $dato0 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato1 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[2]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[3]);
          $dato4 = mysqli_real_escape_string($conexion, $datos[4]);
          $sql = "INSERT into url (urlText,fechaCreacion,boleta,valeTransitorio,tipoDocumento) values ('$dato0','$dato1','$dato2','$dato3','$dato4');";
          return $result=mysqli_query($conexion,$sql);
          $conexion->close();
        }

        public function actualizarBoletaRemoto($datos){
          $c = new remote();
          $conexion = $c->conectarRemoto();
          $dato0=mysqli_real_escape_string($conexion,$datos[0]);
          $dato1=mysqli_real_escape_string($conexion,$datos[1]);
          $sql = "UPDATE ingreso
                      set horaSalida = current_time,
                          statusIngreso = '$dato0'
                      where idIngreso = $dato1";

          return $result=mysqli_query($conexion,$sql);
        }


        /*public function destruirURL($datos){
            $c = new remote();
            $conexion = $c->conectar();

            $sql = "DELETE from producto
                    where idProducto ='$datos[0]'";
            return $result=mysqli_query($conexion,$sql);
        }*/

    }



?>