<?php
require_once('../config/conexion.php');

class Comentarios
{
    public function todos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM Comentarios";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function uno($idComentario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM Comentarios WHERE id_comentario = $idComentario";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function Insertar($id_articulo, $id_usuario, $contenido, $fecha_comentario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO Comentarios(id_articulo, id_usuario, contenido, fecha_comentario) VALUES ($id_articulo, $id_usuario, '$contenido', '$fecha_comentario')";
        if (mysqli_query($con, $cadena)) {
            return mysqli_insert_id($con);
        } else {
            return 'Error al insertar en la base de datos';
        }
        $con->close();
    }

    public function Actualizar($idComentario, $id_articulo, $id_usuario, $contenido, $fecha_comentario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE Comentarios SET id_articulo=$id_articulo, id_usuario=$id_usuario, contenido='$contenido', fecha_comentario='$fecha_comentario' WHERE id_comentario = $idComentario";
        if (mysqli_query($con, $cadena)) {
            return $idComentario;
        } else {
            return 'Error al actualizar el registro';
        }
        $con->close();
    }

    public function Eliminar($idComentario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM Comentarios WHERE id_comentario = $idComentario";
        if (mysqli_query($con, $cadena)) {
            return true;
        } else {
            return false;
        }
        $con->close();
    }
}