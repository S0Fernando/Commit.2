<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/etiquetas.models.php');
$etiquetas = new Clase_Etiquetas();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET["id_etiqueta"])) {
            $uno = $etiquetas->uno($_GET["id_etiqueta"]);
            echo json_encode(mysqli_fetch_assoc($uno));
        } else {
            $datos = $etiquetas->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->nombre_etiqueta)) {
            $insertar = $etiquetas->insertar($datos->nombre_etiqueta);
            if ($insertar) {
                echo json_encode(array("message" => "Se insertó correctamente"));
            } else {
                echo json_encode(array("message" => "Error, no se insertó"));
            }
        } else {
            echo json_encode(array("message" => "Error, falta el nombre de la etiqueta"));
        }
        break;

    case "PUT":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_etiqueta) && !empty($datos->nombre_etiqueta)) {
            $actualizar = $etiquetas->actualizar($datos->id_etiqueta, $datos->nombre_etiqueta);
            if ($actualizar) {
                echo json_encode(array("message" => "Se actualizó correctamente"));
            } else {
                echo json_encode(array("message" => "Error, no se actualizó"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;

    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_etiqueta)) {
            try {
                $eliminar = $etiquetas->eliminar($datos->id_etiqueta);
                echo json_encode(array("message" => "Se eliminó correctamente"));
            } catch (Exception $th) {
                echo json_encode(array("message" => "Error, no se eliminó"));
            }
        } else {
            echo json_encode(array("message" => "Error, no se envió el id_etiqueta"));
        }
        break;
}