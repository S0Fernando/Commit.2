<?php
require_once('../config/conexion.php');

class Clase_Usuarios {
    public function todos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Usuarios`";
        $todos = mysqli_query($con, $cadena);
        $con->close();
        return $todos;
    }

    public function uno($id_usuario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM `Usuarios` WHERE id_usuario = $id_usuario";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function insertar($nombre, $apellido, $correo_electronico)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO `Usuarios` (nombre, apellido, correo_electronico)
                    VALUES ('$nombre', '$apellido', '$correo_electronico')";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function actualizar($id_usuario, $nombre, $apellido, $correo_electronico)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE `Usuarios`
                    SET nombre = '$nombre',
                        apellido = '$apellido',
                        correo_electronico = '$correo_electronico'
                    WHERE id_usuario = $id_usuario";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }

    public function eliminar($id_usuario)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM `Usuarios` WHERE id_usuario = $id_usuario";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }
}