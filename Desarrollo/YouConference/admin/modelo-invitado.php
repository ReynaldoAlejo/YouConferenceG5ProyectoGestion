<?php

require_once '../includes/funciones/bd_conexion.php';
require_once 'funciones/fetch.php';

if(peticion_fetch()) {

    if(!empty($_POST['accion'])) {

        if(isset($_POST['nombre'])) {

            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $descripcion = $_POST['descripcion'];

        }

        if($_POST['accion'] == 'crear') {

            $nombre_imagen = $_FILES['inputFile']['name'][0];
            $tipo_imagen = $_FILES['inputFile']['type'][0];
            $tamagno_imagen = (int) $_FILES['inputFile']['size'][0];

            if($tamagno_imagen < 20971520) {

               /* $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/gdlwebcamp/img/invitados/';*/
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/img/invitados/';

                if($tipo_imagen == "image/jpeg" || $tipo_imagen == "image/jpg" || $tipo_imagen == "image/png" || $tipo_imagen == "image/gif") {

                    if(move_uploaded_file($_FILES['inputFile']['tmp_name'][0], $carpeta_destino . $nombre_imagen)) {

                        try {

                            $stmt = $conn->prepare("INSERT INTO invitados(nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $nombre, $apellido, $descripcion, $nombre_imagen);
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

                    } else {

                        echo json_encode(array('status' => "No se ha podido subir la imagen al servidor, consulte al administrador del sitio"));

                    }

                } else {

                    echo json_encode(array('status' => "No se admite ese tipo de imagen"));

                }

            } else {

                echo json_encode(array('status' => "El tamaño de la imagen no puede exceder los 20 MB"));

            }

        }

       // actualizar y eliminar

        $conn->close();

    } else {

        header('location: login.php');

    }

} else {

    header('location: login.php');

}