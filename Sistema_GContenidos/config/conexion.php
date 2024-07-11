<?php
class Clase_Conectar
{
    public $conexion;
    protected $db;
    private $server = "localhost";
    private $usu = "root";
    private $clave = "";  
    private $base = "bd_examen";

    public function Procedimiento_Conectar()
    {
        $this->conexion = mysqli_connect($this->server, $this->usu, $this->clave, $this->base);
        mysqli_query($this->conexion, "SET NAMES 'utf8'");
        if ($this->conexion == 0) die("error al conectarse con mysql ");
        $this->db = mysqli_select_db($this->conexion, $this->base);
        if ($this->db == 0) die("error conexión con la base de datos ");
        return $this->conexion;
    }
}