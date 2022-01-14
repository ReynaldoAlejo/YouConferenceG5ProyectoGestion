<?php 

require_once '../includes/funciones/bd_conexion.php';
require_once 'funciones/fetch.php';

if(peticion_fetch()) {

    if(!empty($_POST['accion'])) {

        if($_POST['accion'] == 'validar') {

            $nombre = $_POST['categoria'];

            try {

                $query = $conn->query("SELECT * FROM categoria_evento WHERE cat_evento = '{$nombre}'");

                if($query->num_rows > 0) {

                    echo json_encode(array('status' => 'Duplicado'));

                } else {

                    echo json_encode(array('status' => 'No duplicado'));

                }

                $query->close();

            } catch(Exception $e) {

                die("Error: " . $e->getMessage());

            }

        }

        else if($_POST['accion'] == 'crear') {

            $nombre = $_POST['categoria'];
            $icono = $_POST['icono'];

            try {

                $stmt = $conn->prepare("INSERT INTO categoria_evento(cat_evento, icono) VALUES (?, ?)");
                $stmt->bind_param("ss", $nombre, $icono);
                $stmt->execute();

                if($stmt->affected_rows > 0) {

                    $respuesta = array(
                        'status' => 'Correcto',
                        'accion' => $_POST['accion']
                    );

                } else {

                    $respuesta = array(
                        'status' => 'Error'
                    );

                }

                $stmt->close();
                echo json_encode($respuesta);

            } catch(Exception $e) {

                die("Error: " . $e->getMessage());

            }

        }
        
        //actualizar y eliminar

        $conn->close();

    } else {

        header('location: login.php');

    }

} else {

    header('location: login.php');

}