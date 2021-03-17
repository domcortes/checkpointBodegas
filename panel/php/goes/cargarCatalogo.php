<?php
	if (isset($_POST['idCatalogo'])) {
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
        $tabla.="
	                <tr>
	                    <td><p class='text-center'>nombre catalogo</p></td>
	                    <td><img class='img-thumbnail' src='' alt='' width='50%' height='40%'></td>
	                    <td>sato</td>
	                    <td>nombre</td>
	                    <td>descripcion del producto</td>
                    <td>precio venta</td>
	                </tr>";
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