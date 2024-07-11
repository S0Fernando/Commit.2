<?php
require_once("../config/sesiones.php");
require_once("../models/comentarios.models.php");

class ComentariosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Comentarios();
    }

    public function todos() {
        try {
            $datos = $this->modelo->todos();
            $todos = [];
            while ($row = mysqli_fetch_assoc($datos)) {
                $todos[] = $row;
            }
            echo json_encode($todos);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function uno($idComentario) {
        try {
            if (!isset($idComentario)) {
                throw new Exception('ID de comentario no proporcionado');
            }
            $datos = $this->modelo->uno($idComentario);
            $res = mysqli_fetch_assoc($datos);
            echo json_encode($res);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function insertar($id_articulo, $id_usuario, $contenido, $fecha_comentario) {
        try {
            if (!isset($id_articulo, $id_usuario, $contenido, $fecha_comentario)) {
                throw new Exception('Datos insuficientes para insertar comentario');
            }
            $datos = $this->modelo->Insertar($id_articulo, $id_usuario, $contenido, $fecha_comentario);
            echo json_encode($datos);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function actualizar($idComentario, $id_articulo, $id_usuario, $contenido, $fecha_comentario) {
        try {
            if (!isset($idComentario, $id_articulo, $id_usuario, $contenido, $fecha_comentario)) {
                throw new Exception('Datos insuficientes para actualizar comentario');
            }
            $datos = $this->modelo->Actualizar($idComentario, $id_articulo, $id_usuario, $contenido, $fecha_comentario);
            echo json_encode($datos);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function eliminar($idComentario) {
        try {
            if (!isset($idComentario)) {
                throw new Exception('ID de comentario no proporcionado');
            }
            $datos = $this->modelo->Eliminar($idComentario);
            echo json_encode($datos);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

$controller = new ComentariosController();

try {
    if (!isset($_GET["op"])) {
        throw new Exception('Operación no proporcionada');
    }

    switch ($_GET["op"]) {
        case 'todos':
            $controller->todos();
            break;
        case 'uno':
            if (!isset($_POST["idComentario"])) {
                throw new Exception('ID de comentario no proporcionado');
            }
            $controller->uno($_POST["idComentario"]);
            break;
        case 'insertar':
            if (!isset($_POST["id_articulo"], $_POST["id_usuario"], $_POST["contenido"], $_POST["fecha_comentario"])) {
                throw new Exception('Datos insuficientes para insertar comentario');
            }
            $controller->insertar($_POST["id_articulo"], $_POST["id_usuario"], $_POST["contenido"], $_POST["fecha_comentario"]);
            break;
        case 'actualizar':
            if (!isset($_POST["idComentario"], $_POST["id_articulo"], $_POST["id_usuario"], $_POST["contenido"], $_POST["fecha_comentario"])) {
                throw new Exception('Datos insuficientes para actualizar comentario');
            }
            $controller->actualizar($_POST["idComentario"], $_POST["id_articulo"], $_POST["id_usuario"], $_POST["contenido"], $_POST["fecha_comentario"]);
            break;
        case 'eliminar':
            if (!isset($_POST["idComentario"])) {
                throw new Exception('ID de comentario no proporcionado');
            }
            $controller->eliminar($_POST["idComentario"]);
            break;
        default:
            throw new Exception('Operación no válida');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
