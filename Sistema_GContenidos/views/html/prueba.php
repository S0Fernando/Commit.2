<?php
// Incluir la clase de conexión
require_once('../config/conexion.php');

try {
    // Crear una instancia de la clase de conexión
    $conexion = new Clase_Conectar();
    // Intentar establecer la conexión
    $conexion->Procedimiento_Conectar();
    echo "Conexión exitosa a la base de datos.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>