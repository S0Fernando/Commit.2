<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/usuarios.models.php');
$usuarios = new Clase_Usuarios();
$metodo = $_SERVER['REQUEST_METHOD'];
switch ($metodo) {
    case 'GET':
        if (isset($_GET["id_usuario"])) {
            $uno = $usuarios->uno($_GET["id_usuario"]);
            echo json_encode(mysqli_fetch_assoc($uno));
        } else {
            $datos = $usuarios->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->nombre) && !empty($datos->apellido) && !empty($datos->correo_electronico)) {
            $insertar = $usuarios->insertar($datos->nombre, $datos->apellido, $datos->correo_electronico);
            if ($insertar) {
                echo json_encode(array("message" => "Se insertó correctamente"));
            } else {
                echo json_encode(array("message" => "Error, no se insertó"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos obligatorios"));
        }
        break;
    case "PUT":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_usuario) && !empty($datos->nombre) && !empty($datos->apellido) && !empty($datos->correo_electronico)) {
            $actualizar = $usuarios->actualizar($datos->id_usuario, $datos->nombre, $datos->apellido, $datos->correo_electronico);
            if ($actualizar) {
                echo json_encode(array("message" => "Se actualizó correctamente"));
            } else {
                echo json_encode(array("message" => "Error, no se actualizó"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos obligatorios"));
        }
        break;
    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_usuario)) {
            try {
                $eliminar = $usuarios->eliminar($datos->id_usuario);
                echo json_encode(array("message" => "Se eliminó correctamente"));
            } catch (Exception $th) {
                echo json_encode(array("message" => "Error, no se eliminó"));
            }
        } else {
            echo json_encode(array("message" => "Error, no se envió el id_usuario"));
        }
        break;
}