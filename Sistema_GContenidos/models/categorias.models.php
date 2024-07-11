<?php
require_once('../config/conexion.php');

class Clase_Categorias {
    public function todos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Categorias`";
        $todos = mysqli_query($con, $cadena);
        $con->close();
        return $todos;
    }

    public function uno($id_categoria)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Categorias` WHERE id_categoria = $id_categoria";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function insertar($nombre_categoria)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO `Categorias` (nombre_categoria) VALUES ('$nombre_categoria')";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function actualizar($id_categoria, $nombre_categoria)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE `Categorias` SET nombre_categoria = '$nombre_categoria' WHERE id_categoria = $id_categoria";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function eliminar($id_categoria)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM `Categorias` WHERE id_categoria = $id_categoria";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function contarArticulos($id_categoria)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT COUNT(*) as total FROM `Articulos_Categorias` WHERE id_categoria = $id_categoria";
        $resultado = mysqli_query($con, $cadena);
        $fila = mysqli_fetch_assoc($resultado);
        $con->close();
        return $fila['total'];
    }
}