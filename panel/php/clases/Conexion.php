<?php
    class Conexion {
        private $servidor="localhost";
        private $usuario="intranet";
        private $password="qwertyQXE59oplm%";
        // private $usuario="root";
        // private $password="martin07081988";
        private $bd="accesoBodega";
//
        public function conectar(){
            $conexion = mysqli_connect($this->servidor,
                                        $this->usuario,
                                        $this->password,
                                        $this->bd);
            return $conexion;
        }
    }


?>
