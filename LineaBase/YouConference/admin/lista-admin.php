<?php

  include_once 'templates/header.php';

  include_once 'templates/barra.php';

  include_once 'templates/navegacion.php';

  if($_SESSION['nivel'] != 1) {

    include_once 'forbidden.php';

  } else {

?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administradores
        <small>Aquí se encuentran todos los administradores registrados</small>
      </h1>
    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de administradores</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="registros" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <!--<th>Foto</th>
                              <th>Antigüedad</th>
                            <th>Última Edición (YYYY/MM/DD hh:mm:ss)</th>
                            <th>Nivel</th>-->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require '../includes/funciones/bd_conexion.php';

                        $query = $conn->query("SELECT id_admin, usuario, nombre, foto_perfil, fecha_registro, ult_edicion, nivel FROM admins");

                        while($registro = $query->fetch_assoc()) {

                          echo "<tr>";
                          echo "<td>" . $registro['id_admin'] . "</td>";
                          echo "<td>" . $registro['usuario'] . "</td>";
                          echo "<td>" . $registro['nombre'] . "</td>";
                          
                         

                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- .col-xs-12 -->
      </div>
      <!-- .row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

    $query->close();
    $conn->close();

    }

    include_once 'templates/footer.php';

?>
