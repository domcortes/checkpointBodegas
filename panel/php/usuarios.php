<?php

  session_start();
  if(!$_SESSION['verificar'] || $_SESSION['nivelAcceso']!='administrador'){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    require_once("clases/Conexion.php");
    require_once("clases/crud.php");
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Usuarios del Sistema</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="card">
            <div class="card-header">
                  <h1>ADMINISTRACION DE USUARIOS</h1>
            </div>
            <div class="card-body">
                  <div class="card">
                        <div class="card-body">
                        En esta sección, usted vera a los diferentes usuarios y administrara sus niveles de acceso a la plataforma
                        </div>
                  </div>


                 <div class="card-body">
                 <form action="clases/procesos/insertUser.php" method="POST">
                        <!--nombre-->
                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <label for="nombreUsuario">Nombre Usuario</label>
                                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="..." required>
                              </div>
                              <div class="form-group col-md-6">
                                    <label for="contrasenna">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasenna" name="contrasenna" placeholder="*******" required>
                              </div>
                        </div>
                        <!--finNombre-->
                        <div class="form-row">
                              <div class="form-group col-md-3">
                                    <label for="rutUsuario">Rut Usuario</label>
                                    <input type="text" class="form-control" id="rutUsuario" name="rutUsuario" placeholder="..." required>
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="rutUsuario">Sucursal</label>
                                    <select class="form-control" id="sucursal" name="sucursal" required="true">
                                      <option value="adm"></option>
                                      <option value="CF">Centro Ferretero</option>
                                      <option value="MH">Multi Hogar</option>
                                      <option value="GMN">Gastromax PNT</option>
                                      <option value="PAV">Gastromax PUQ</option>
                                      <option value="PCV">Patio Constructor</option>
                                      <option value="TIV">Tienda</option>
                                      <option value="SAV">Salomon</option>
                                    </select>
                              </div>
                              <div class="form-group col-md-6">
                                    <label for="usuarioAcceso">Nombre Acceso</label>
                                    <input type="text" class="form-control" id="usuarioAcceso" name="usuarioAcceso" placeholder="nombre.apellido" required>
                              </div>
                        </div>
                        <!--nivelAcceso-->
                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <label for="correoElectronico">Correo Electrónico</label>
                                    <input type="email" class="form-control" name="correoElectronico" id="correoElectronico" placeholder="ejemplo@dominio.com" required>
                              </div>

                              <div class="form-group col-md-6">
                                    <label for="nivelAcceso">Nivel de acceso</label>
                                    <select name="nivelAcceso" id="nivelAcceso" class="form-control">
                                          <option value="administrador">Administrador</option>
                                          <option value="televenta">Tele-vendedor</option>
                                          <option value="frontDesk">Trabajador</option>
                                          <option value="cafetería">Portero</option>
                                    </select>
                              </div>
                        </div>
                        <!--fin nivelAcceso-->

                        <div class="btn-group" role="group" aria-label="commandForm">
                              <input type="submit" id="agregar" name="agregar" value="Agregar usuario" class="btn btn-success">
                              <input type="submit" id="limpiarFormulario" name="limpiarFormulario" value="Limpiar Formulario" class="btn btn-danger">
                        </div>

                        <?php
                              if(isset($_POST['agregar'])){
                                    include('clases/procesos/insertUser.php');
                              }
                        ?>

                  </form>
                 </div>

                 <div class="card-body">
                 <table class="table">
                        <thead class="thead-dark">
                        <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Nombre Usuario</th>
                              <th scope="col">Contraseña</th>
                              <th class="text-center" scope="col">Correo Electronico</th>
                              <th class="text-center" scope="col">Nivel Acceso</th>
                              <th class="text-center">Sucursal</th>
                              <th class="text-center" scope="col">Acciones</th>
                        </tr>
                        </thead>


                        <tbody>
                        <?php
                          $i=0;
                          $obj = new metodos();
                          $sql = 'SELECT * from usuarios';
                          $datos = $obj->mostrarDatos($sql);

                          foreach ($datos as $key){
                            $i++;
                        ?>

                        <tr>
                              <td><?php echo $key['idusuario']; ?></td>
                              <td><?php echo ucwords($key['nombreUsuario']);?></th>
                              <td><?php echo '*******';?></td>
                              <td class="text-center"><?php echo $key['correoElectronico'];?></td>
                              <td class="text-center"><?php echo strtoupper($key['nivelAcceso']);?></td>
                              <td class="text-center"><?php echo strtoupper($key['sucursal']); ?></td>
                              <td class="text-center"><a href="detalleUsuarios.php?idUsuario=<?php echo $key['idusuario'];?>" class="btn btn-info">Ver Usuario</a></td>
                        </tr>

                        <?php
                        }
                        ?>
                        </tbody>
                        </table>
                 </div>

            </div>
      </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
          function evaluarClase(cadena){
                var claseEspañol = document.getElementById('claseProductoEspañol').value;

                  if(claseEspañol=='Cafeteria'){
                       document.getElementById('claseProductoIngles').value='Coffee & Hot Beverages';

                  } else if (claseEspañol=='Cafe a Goteo'){
                      document.getElementById('claseProductoIngles').value='Drip Coffee';

                  } else if (claseEspañol=='Pasteleria'){
                      document.getElementById('claseProductoIngles').value='Homemade Pastry';

                  } else if (claseEspañol=='Bebidas Frias'){
                      document.getElementById('claseProductoIngles').value='Cold Beverages';

                  } else if (claseEspañol=='Cervezas y alcoholes'){
                      document.getElementById('claseProductoIngles').value='Beers & Alcoholic Beverages';

                  } else if (claseEspañol=='Baguette Frios'){
                      document.getElementById('claseProductoIngles').value='Baguette';

                  } else if (claseEspañol=='Quiche del dia'){
                      document.getElementById('claseProductoIngles').value='Quice';

                  } else if (claseEspañol=='Crema del dia'){
                      document.getElementById('claseProductoIngles').value='Vegetable Soup';

                  } else if (claseEspañol=='Sandwich'){
                      document.getElementById('claseProductoIngles').value='Sandwich';

                  } else if (claseEspañol=='Ensaladas'){
                      document.getElementById('claseProductoIngles').value='Salads';

                  } else if (claseEspañol=='En todo momento'){
                      document.getElementById('claseProductoIngles').value='Anytime Toasts & Brunch';

                  } else {
                        alert("Necesita seleccionar una clase");
                  }

                  document.getElementById('descripcionProductoEspañol').focus();
          }

          function valorDolar(valor){
                var valorCLP = document.getElementById('precioProductoCLP').value;
                var valorDolar = 800;
                var conversion = Math.round(valorCLP/valorDolar);
                document.getElementById('precioProductoUSD').value =  conversion;
                document.getElementById('claseProductoEspañol').focus();
          }

          function duplicarNombre(nombreTexto){
                var nombreProducto = document.getElementById('nombreProductoEspañol').value;
                document.getElementById('nombreProductoIngles').value = nombreProducto;
          }
    </script>
  </body>
</html>