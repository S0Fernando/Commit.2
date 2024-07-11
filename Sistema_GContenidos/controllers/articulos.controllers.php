<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/articulos.models.php');

$articulos = new Clase_Articulos();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET["id_articulo"])) {
            $uno = $articulos->uno($_GET["id_articulo"]);
            $articulo = mysqli_fetch_assoc($uno);
            
            // Obtener comentarios, categorías y etiquetas relacionadas
            $articulo['comentarios'] = array();
            $comentarios = $articulos->obtenerComentarios($_GET["id_articulo"]);
            while ($comentario = mysqli_fetch_assoc($comentarios)) {
                array_push($articulo['comentarios'], $comentario);
            }
            
            $articulo['categorias'] = array();
            $categorias = $articulos->obtenerCategorias($_GET["id_articulo"]);
            while ($categoria = mysqli_fetch_assoc($categorias)) {
                array_push($articulo['categorias'], $categoria);
            }
            
            $articulo['etiquetas'] = array();
            $etiquetas = $articulos->obtenerEtiquetas($_GET["id_articulo"]);
            while ($etiqueta = mysqli_fetch_assoc($etiquetas)) {
                array_push($articulo['etiquetas'], $etiqueta);
            }
            
            echo json_encode($articulo);
        } else {
            $datos = $articulos->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->titulo) && !empty($datos->contenido) && !empty($datos->fecha_publicacion) && !empty($datos->id_usuario)) {
            $insertar = $articulos->insertar($datos->titulo, $datos->contenido, $datos->fecha_publicacion, $datos->id_usuario);
            if ($insertar) {
                echo json_encode(array("message" => "Se insertó correctamente", "id_articulo" => $insertar));
            } else {
                echo json_encode(array("message" => "Error, no se insertó"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;

    case "PUT":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->id_articulo) && !empty($datos->titulo) && !empty($datos->contenido) && !empty($datos->fecha_publicacion) && !empty($datos->id_usuario)) {
            $actualizar = $articulos->actualizar($datos->id_articulo, $datos->titulo, $datos->contenido, $datos->fecha_publicacion, $datos->id_usuario);
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
        if (!empty($datos->id_articulo)) {
            try {
                $eliminar = $articulos->eliminar($datos->id_articulo);
                echo json_encode(array("message" => "Se eliminó correctamente"));
            } catch (Exception $th) {
                echo json_encode(array("message" => "Error, no se eliminó: " . $th->getMessage()));
            }
        } else {
            echo json_encode(array("message" => "Error, no se envió el id_articulo"));
        }
        break;
}