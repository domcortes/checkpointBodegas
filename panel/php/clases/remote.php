<?php
    class remote {
        private $servidor="www.chelech.cl";
        private $usuario="rootchelech";
        private $password="kabvax-winBo3-qitjim";
        private $bd="ddbb_ur";
//
        public function conectarRemoto(){
            $conexion = mysqli_connect($this->servidor,
                                        $this->usuario,
                                        $this->password,
                                        $this->bd);
            return $conexion;
        }
    }

?>
