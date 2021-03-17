<?php
	if (isset($_POST['idCatalogo'])) {
		require_once("../../php/clases/cc2.php");
		$lista = new metodos();
		$sqlProductos =
			"SELECT
			productosCatalogo.id_catalogo,
			catalogo.nombreCatalogo AS nombreCatalogo,
			productosCatalogo.imagen,
			productosCatalogo.sato,
			productosCatalogo.nombre,
			productosCatalogo.descripcion,
			productosCatalogo.precioVenta
			FROM
			productosCatalogo
			INNER JOIN
			catalogo
			ON
			productosCatalogo.id_catalogo = catalogo.idCatalogo
			ORDER BY
			id";
		$productos = $lista->mostrarDatos($sqlProductos);

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
                    <th>Precio Venta</th>
                  </tr>
                </thead>
                <tbody>";
        // foreach ($productos as $producto) {
	       //  $tabla.="
	       //      <tr>
	       //          <td><p class='text-center'>".$producto['nombreCatalogo']."</p></td>
	       //          <td><img class='img-thumbnail' src='".$producto['imagen']."' alt='' width='50%' height='40%'></td>
	       //          <td>".$producto['sato']."</td>
	       //          <td>".$producto['nombre']."</td>
	       //          <td>".$producto['descripcion']."</td>
	       //      	<td>".$producto['precioVenta']."</td>
	       //      </tr>";
        // }

        $tabla.="</tbody>
                <tfoot>
                  <tr>
                    <th>Nombre catalogo</th>
                    <th>Foto</th>
                    <th>Sato</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio Venta</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
      </div>";
	}

	echo $tabla;

?>