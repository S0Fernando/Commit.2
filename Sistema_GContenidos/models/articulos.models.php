<?php
require_once('../config/conexion.php');

class Clase_Articulos {
    public function todos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM Articulos";
        $todos = mysqli_query($con, $cadena);
        $con->close();
        return $todos;
    }

    public function uno($id_articulo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM Articulos WHERE id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function insertar($titulo, $contenido, $fecha_publicacion, $id_usuario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO Articulos (titulo, contenido, fecha_publicacion, id_usuario)
                    VALUES ('$titulo', '$contenido', '$fecha_publicacion', $id_usuario)";
        $resultado = mysqli_query($con, $cadena);
        $id_articulo = mysqli_insert_id($con);
        $con->close();
        return $id_articulo;
    }

    public function actualizar($id_articulo, $titulo, $contenido, $fecha_publicacion, $id_usuario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE Articulos
                    SET titulo = '$titulo',
                        contenido = '$contenido',
                        fecha_publicacion = '$fecha_publicacion',
                        id_usuario = $id_usuario
                    WHERE id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function eliminar($id_articulo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        
        // Primero, eliminamos los registros relacionados en la tabla Comentarios
        $cadena_comentarios = "DELETE FROM Comentarios WHERE id_articulo = $id_articulo";
        mysqli_query($con, $cadena_comentarios);
        
        // Luego, eliminamos los registros relacionados en la tabla Articulos_Categorias
        $cadena_categorias = "DELETE FROM Articulos_Categorias WHERE id_articulo = $id_articulo";
        mysqli_query($con, $cadena_categorias);
        
        // Después, eliminamos los registros relacionados en la tabla Articulos_Etiquetas
        $cadena_etiquetas = "DELETE FROM Articulos_Etiquetas WHERE id_articulo = $id_articulo";
        mysqli_query($con, $cadena_etiquetas);
        
        // Finalmente, eliminamos el artículo
        $cadena = "DELETE FROM Articulos WHERE id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        
        $con->close();
        return $resultado;
    }

    public function obtenerComentarios($id_articulo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM Comentarios WHERE id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function obtenerCategorias($id_articulo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT c.* FROM Categorias c
                    JOIN Articulos_Categorias ac ON c.id_categoria = ac.id_categoria
                    WHERE ac.id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function obtenerEtiquetas($id_articulo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT e.* FROM Etiquetas e
                    JOIN Articulos_Etiquetas ae ON e.id_etiqueta = ae.id_etiqueta
                    WHERE ae.id_articulo = $id_articulo";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }
}