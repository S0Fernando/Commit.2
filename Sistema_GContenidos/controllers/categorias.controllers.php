<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/categorias.models.php');
$categorias = new Clase_Categorias();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET["id_categoria"])) {
            $uno = $categorias->uno($_GET["id_categoria"]);
            echo json_encode(mysqli_fetch_assoc($uno));
        } else {
            $datos = $categorias->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                // Obtener la cantidad de artículos asociados a esta categoría
                $fila['cantidad_articulos'] = $categorias->contarArticulos($fila['id_categoria']);
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->nombre_categoria)) {
            $insertar = $categorias->insertar($datos->nombre_categoria);
            if ($insertar) {
                echo json_encode(array("message" => "Se insertó correctamente"));
            } else {
                echo json_encode(array("message" => "Error, no se insertó"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
    case "PUT":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_categoria) && !empty($datos->nombre_categoria)) {
            $actualizar = $categorias->actualizar($datos->id_categoria, $datos->nombre_categoria);
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
        if (!empty($datos->id_categoria)) {
            try {
                // Verificar si hay artículos asociados
                $cantidad_articulos = $categorias->contarArticulos($datos->id_categoria);
                if ($cantidad_articulos > 0) {
                    echo json_encode(array("message" => "Error, no se puede eliminar. La categoría tiene artículos asociados."));
                } else {
                    $eliminar = $categorias->eliminar($datos->id_categoria);
                    echo json_encode(array("message" => "Se eliminó correctamente"));
                }
            } catch (Exception $th) {
                echo json_encode(array("message" => "Error, no se eliminó"));
            }
        } else {
            echo json_encode(array("message" => "Error, no se envió el id_categoria"));
        }
        break;
}