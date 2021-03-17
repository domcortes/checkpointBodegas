<?php
	if (isset($_POST['idCatalogo'])) {
		$catalogo = $_POST['idCatalogo'];
		require_once("../clases/Conexion.php");
		require_once("../clases/crud.php");
		// require_once("../../php/clases/Conexion.php");
		// require_once("../../php/clases/crud.php");
      	$lista = new metodos();
      	$sqlCatalogo =
        "SELECT productosCatalogo.id_catalogo,catalogo.nombreCatalogo AS nombreCatalogo,productosCatalogo.imagen,productosCatalogo.sato,productosCatalogo.nombre,productosCatalogo.descripcion,productosCatalogo.precioVenta FROM productosCatalogo INNER JOIN catalogo ON productosCatalogo.id_catalogo = catalogo.idCatalogo WHERE productosCatalogo.id_catalogo = '$catalogo' ORDER BY id";
      	$catalogos = $lista->mostrarDatos($sqlCatalogo);

		$tabla = "<div class='card card-primary'>
          <div class='card-header'>
            <h3 class='card-title'>LISTADO DE PRODUCTO DE CATALOGO</h3>
          </div>
            <div class='card-body'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>Nombre catalogo</th>
                    <th>Foto</th>
                    <th>Sato</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                  </tr>
                </thead>
                <tbody>";
        if (sizeof($catalogos)>0) {
        	foreach ($catalogos as $catalogo) {
	        	$tabla.="
	                <tr>
	                    <td><p class='text-center'>".$catalogo['nombreCatalogo']."</p></td>
	                    <td><img class='img-thumbnail' src='".$catalogo['imagen']."' alt='' width='50%' height='40%'></td>
	                    <td>".$catalogo['sato']."</td>
	                    <td>".$catalogo['nombre']."</td>
	                    <td>".$catalogo['descripcion']."</td>
	                </tr>";
	        }
        } else {
        	$tabla .= "<tr><td class='text-center' colspan='6'>No existen registros asociados</td><tr>";
        }

        $tabla.="</tbody>
                <tfoot>
                  <tr>
                    <th>Nombre catalogo</th>
                    <th>Foto</th>
                    <th>Sato</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
      </div>";
	}

	echo $tabla;

?>