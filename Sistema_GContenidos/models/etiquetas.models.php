<?php
require_once('../config/conexion.php');

class Clase_Etiquetas {
    public function todos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Etiquetas`";
        $todos = mysqli_query($con, $cadena);
        $con->close();
        return $todos;
    }

    public function uno($id_etiqueta)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Etiquetas` WHERE id_etiqueta = $id_etiqueta";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function insertar($nombre_etiqueta)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO `Etiquetas` (nombre_etiqueta)
                    VALUES ('$nombre_etiqueta')";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function actualizar($id_etiqueta, $nombre_etiqueta)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE `Etiquetas`
                    SET nombre_etiqueta = '$nombre_etiqueta'
                    WHERE id_etiqueta = $id_etiqueta";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function eliminar($id_etiqueta)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM `Etiquetas` WHERE id_etiqueta = $id_etiqueta";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }
}