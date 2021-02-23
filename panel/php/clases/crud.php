<?php

    class metodos{
        public function mostrarDatos($sql){
            $c = new Conexion();
            $conexion = $c->conectar();
            $result = mysqli_query($conexion,$sql);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function firstStepCustomerLoader($datos){
          $c=new Conexion();
          $conexion = $c->conectar();
          $dato0 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato1 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[2]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[3]);
          $dato4 = mysqli_real_escape_string($conexion, $datos[4]);
          $sql = "INSERT into ingreso (
                                        tipoIngreso,
                                        origenIngreso,
                                        tipoDocumento,
                                        numeroDocumento,
                                        statusIngreso
                                        )
                              values ('$dato0',
                                      '$dato1',
                                      '$dato2',
                                      '$dato3',
                                      '$dato4')";
          return $result=mysqli_query($conexion,$sql);
          $conexion->close();
        }

        public function agregarTitular($datos){
          $c= new Conexion();
          $conexion = $c->conectar();
          $dato0=mysqli_real_escape_string($conexion,$datos[0]);
          $dato1=mysqli_real_escape_string($conexion,$datos[1]);
          $dato2=mysqli_real_escape_string($conexion,$datos[2]);
          $dato3=mysqli_real_escape_string($conexion,$datos[3]);
          $dato4=mysqli_real_escape_string($conexion,$datos[4]);
          $sql = "INSERT into personas (id_ingreso,nombrePersona,rutPersona,tipoIngreso,epp) values (
                                          $dato0,
                                          '$dato1',
                                          '$dato2',
                                          '$dato3',
                                          '$dato4'
                                          )";
          return $result=mysqli_query($conexion,$sql);
          $conexion=close();
        }

        public function addCompanion($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0=mysqli_real_escape_string($conexion,$datos[0]);
          $dato1=mysqli_real_escape_string($conexion,$datos[1]);
          $dato2=mysqli_real_escape_string($conexion,$datos[2]);
          $dato3=mysqli_real_escape_string($conexion,$datos[3]);
          $dato4=mysqli_real_escape_string($conexion,$datos[4]);
          $sql = "INSERT into personas (id_ingreso,nombrePersona,rutPersona,tipoIngreso,epp) values (
                                          $dato0,
                                          '$dato1',
                                          '$dato2',
                                          '$dato3',
                                          '$dato4'
                                          )";
          return $result=mysqli_query($conexion,$sql);
          $conexion=close();
        }

        public function cerrarCompra($datos){
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

        public function marcarProcesar($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato0 = mysqli_real_escape_string($conexion,$datos[0]);
          $dato1 = mysqli_real_escape_string($conexion,$datos[1]);
          $sql = "UPDATE ingreso
                  set horaSalida = current_time,
                      statusIngreso = '$dato0'
                  where idIngreso = $dato1";
          return $result=mysqli_query($conexion,$sql);
        }

        public function actualizarUsuario($datos){
          $c = new Conexion();
          $conexion= $c->conectar();
          $dato1 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[2]);
          $dato4 = mysqli_real_escape_string($conexion, $datos[3]);
          $dato5 = mysqli_real_escape_string($conexion, $datos[4]);
          $dato6 = mysqli_real_escape_string($conexion, $datos[5]);
          $dato7 = mysqli_real_escape_string($conexion, $datos[6]);
          $dato8 = mysqli_real_escape_string($conexion, $datos[7]);
          $dato9 = mysqli_real_escape_string($conexion, $datos[8]);

          $sql = "UPDATE usuarios
                  set nombreUsuario='$dato1',
                      contrasenna='$dato2',
                      correoElectronico='$dato3',
                      nivelAcceso='$dato4',
                      rutUsuario='$dato5',
                      nombreMainEmpresa='$dato6',
                      rutMainEmpresa='$dato7',
                      fechaContrato='$dato8'
                  where idusuario=$dato9";
          return $result=mysqli_query($conexion,$sql);
        }

        public function agregarUsuario($datos){
            $c = new Conexion();
            $conexion = $c->conectar();
            $dato0 = mysqli_real_escape_string($conexion, $datos[0]);
            $dato1 = mysqli_real_escape_string($conexion, $datos[1]);
            $dato2 = mysqli_real_escape_string($conexion, $datos[2]);
            $dato3 = mysqli_real_escape_string($conexion, $datos[3]);
            $dato4 = mysqli_real_escape_string($conexion, $datos[4]);
            $dato5 = mysqli_real_escape_string($conexion, $datos[5]);
            $dato6 = mysqli_real_escape_string($conexion, $datos[6]);

            $sql = "INSERT INTO usuarios (
                                          rutUsuario,
                                          nombreUsuario,
                                          usuarioAcceso,
                                          nivelAcceso,
                                          correoElectronico,
                                          contrasenna,
                                          sucursal
                                          )
                  values
                  ('$dato0',
                  '$dato1',
                  '$dato2',
                  '$dato3',
                  '$dato4',
                  '$dato5',
                  '$dato6'
                  )";
            return $result=mysqli_query($conexion,$sql);
        }


        public function destruirCategoria($datos){
            $c = new Conexion();
            $conexion = $c->conectar();

            $sql = "DELETE FROM claseProducto
                  where idClaseProducto='$datos[0]'";
            return $result=mysqli_query($conexion,$sql);
        }

        public function destruirProductos($datos){
            $c = new Conexion();
            $conexion = $c->conectar();

            $sql = "DELETE from producto
                    where idProducto ='$datos[0]'";
            return $result=mysqli_query($conexion,$sql);
        }

        public function actualizarCategoria($datos){
            $c = new Conexion();
            $conexion = $c->conectar();
            $dato1 = mysqli_real_escape_string($conexion, $datos[0]);
            $dato2 = mysqli_real_escape_string($conexion, $datos[1]);
            $dato3 = mysqli_real_escape_string($conexion, $datos[2]);
            $sql = "UPDATE claseProducto
                set nombreClaseEspanol = '$dato2',
                    nombreClaseIngles = '$dato3'
                where idClaseProducto=$dato1";
            return $result=mysqli_query($conexion,$sql);
        }

        public function actualizarProducto($datos){
            $c = new Conexion();
            $conexion = $c->conectar();
            $dato1 = mysqli_real_escape_string($conexion, $datos[0]);
            $dato2 = mysqli_real_escape_string($conexion, $datos[1]);
            $dato3 = mysqli_real_escape_string($conexion, $datos[2]);
            $dato4 = mysqli_real_escape_string($conexion, $datos[3]);
            $dato5 = mysqli_real_escape_string($conexion, $datos[4]);
            $dato6 = mysqli_real_escape_string($conexion, $datos[5]);
            $dato7 = mysqli_real_escape_string($conexion, $datos[6]);
            $dato8 = mysqli_real_escape_string($conexion, $datos[7]);
            $dato9 = mysqli_real_escape_string($conexion, $datos[8]);
            $sql = "UPDATE producto
                    set
                    nombreProductoEspanol = '$dato3',
                    nombreProductoIngles = '$dato4',
                    precioProductoCLP = '$dato5',
                    precioProductoUSD = '$dato6',
                    idClase = '$dato7',
                    descripcionProductoEspanol = '$dato8',
                    descripcionProductoIngles = '$dato9'
                    where idProducto=$dato2 and id_empresa=$dato1";
                    return $result=mysqli_query($conexion,$sql);
        }

        public function destruirEnlaceUsuarioEmpresa($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato1 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[1]);
          $dato3 = mysqli_real_escape_string($conexion, $datos[2]);
          $sql = "DELETE from usuario_empresa
                  where id='$dato1' and id_usuario='$dato2' and id_empresa='$dato3'";
          return $result= mysqli_query($conexion,$sql);
        }

        public function agregarEmpresaAUsuario($datos){
          $c = new Conexion();
          $conexion = $c->conectar();
          $dato1 = mysqli_real_escape_string($conexion, $datos[0]);
          $dato2 = mysqli_real_escape_string($conexion, $datos[1]);

          $sql = "INSERT INTO usuario_empresa (id_usuario, id_empresa)
                  values ('$dato1','$dato2')";
          return $result = mysqli_query($conexion, $sql);
        }

    }



?>