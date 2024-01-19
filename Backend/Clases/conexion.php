<?php

class BaseDatos {
    private $conexion;
    private $user;
    private $host;
    private $pass;
    private $db;

    public function __construct() {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
        $this->db = "rest";
    }

    public function conectar() {
        $this->conexion = new mysqli($this->host,$this->user,$this->pass,$this->db);
        if ($this->conexion->connect_errno) {
            printf("Error de conexión: %s\n", $mysqli->connect_error);
            exit();
        }
        else {
            return $this->conexion;
        }
    }

    public function seleccionar($query) {
        $resultado = $this->conexion->query($query);
        if (!$resultado) {
            echo "Los datos no pueden ser mostrados";
        }
        return $resultado;
    }

    public function insertar($query){
        $resultado = $this->conexion->query($query);
        if (!$resultado) {
            echo "Los datos no pueden ser insertados";
        }
    }

    public function eliminar($query) {
        $resultado = $this->conexion->query($query);
        if (!$resultado) {
            echo "Los datos no pueden ser eliminados";
        }
    }
    public function update($query) {
        $resultado=$this->conexion->query($query);
        if (!$resultado) {
            echo "Los datos no pudieron ser modificados";
        }
    }
}

?>