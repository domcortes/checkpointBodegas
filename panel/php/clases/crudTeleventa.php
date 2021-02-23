<?php

    class metodosTeleventaLocal{
      public function buscarURLlocal($sql){
            $c = new Conexion();
            $conexion = $c->conectar();
            $result = mysqli_query($conexion,$sql);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insertarURLlocal($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato1 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[2]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[3]);
          $dato4 = mysqli_real_escape_string($conexion, $datos[4]);
          $dato5 = mysqli_real_escape_string($conexion, $datos[5]);
          $dato6 = mysqli_real_escape_string($conexion, $datos[6]);
          $sql = "INSERT into url (urlText,fechaCreacion,boleta,valeTransitorio,tipoDocumento,monto,idUser) values ('$dato0','$dato1','$dato2','$dato3','$dato4','$dato5','$dato6');";
          return $result=mysqli_query($conexion,$sql);
          $conexion->close();
        }

        public function actualizarBoleta($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0=mysqli_real_escape_string($conexion,$datos[0]);
          $dato1=mysqli_real_escape_string($conexion,$datos[1]);
          $sql = "UPDATE ingreso
                      set horaSalida = current_time,
                          statusIngreso = '$dato0'
                      where idIngreso = $dato1";

          return $result=mysqli_query($conexion,$sql);
        }

        public function ingresarDocumentoUrl($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0=mysqli_real_escape_string($conexion,$datos[0]);
          $dato1=mysqli_real_escape_string($conexion,$datos[1]);
          $dato2=mysqli_real_escape_string($conexion,$datos[2]);
          $sql = "UPDATE url
                  set boleta='$dato0',
                      tipoDocumento='$dato1'
                  where idUrl='$dato2'";
          return $result=mysqli_query($conexion,$sql);
        }


        public function agregarCatalogo($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato1 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[2]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[3]);
          $dato4 = mysqli_real_escape_string($conexion, $datos[4]);
          $dato5 = mysqli_real_escape_string($conexion, $datos[5]);
          $dato6 = mysqli_real_escape_string($conexion, $datos[6]);
          $sql = "INSERT INTO productosCatalogo (id_catalogo, imagen, sato, nombre, descripcion, precioVenta, id_usuario) values ($dato0, '$dato1', '$dato2 ', '$dato3 ', '$dato4', '$dato5', '$dato6');";
          return $result = mysqli_query($conexion, $sql);
          $conexion->close();
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