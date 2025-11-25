<?php
    class Conexion{
        public $ip;
        public $nombre;
        public $password;
        public $bd;

        public function __construct($ip,$nombre,$password,$bd){
            $this->ip = $ip;
            $this->nombre = $nombre;
            $this->password = $password;
            $this->bd = $bd;
        }

        public function __toString(){
            return 'Ip: '
            . $this->ip .'<br>Nombre: '
            . $this->nombre .'<br>Contraseña: '
            . $this->password .'<br>Base de datos: '
            . $this->bd .'<br>';

        }
        
        public function getIp(){
            return $this->ip;
        }
        public function setIp($ip){
            $this->ip = $ip;
        }

        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getPassword(){
            return $this->password;
        }
        public function setPassword($password){
            $this->password = $password;
        }

        public function getBd(){
            return $this->bd;
        }
        public function setBd($bd){
            $this->bd = $bd;
        }

        public function conection(){
            $conexion = new mysqli($this->ip,$this->nombre,$this->password,$this->bd);
            if($conexion->connect_errno != null){
                echo 'Error conectando a la base de datos: ';
                echo '$conexion->connect_error';
                exit();
            }else{
			return $conexion;
		    }
        }

        public function conectionPDO(){
            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            try {
                $conexion = new PDO('mysql:host='.$this->ip.';dbname='.$this->bd, $this->nombre,$this->password,$opc);
                return $conexion;
            } catch (PDOException $e) {
                echo 'Falló la conexión: ' . $e->getMessage();
            }
        }
    }

    class Tarea{
        public $id;
        public $nombre;
        public $descripcion;
        public $fecha_creacion;
        public $fecha_modificacion;
        public $fecha_finalizacion;
        public $completada;
        public $id_usr_crea;
        public $id_usr_mod;
        public $id_usr_comp;

        public function __construct($nombre,$descripcion,$fecha_creacion,$id_usr_crea){
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha_creacion = $fecha_creacion;
            $this->id_usr_crea = $id_usr_crea;
        }

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id = $id;
        }

        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getDescripcion(){
            return $this->descripcion;
        }
        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        public function getFechaC(){
            return $this->fecha_creacion;
        }
        public function setFechaC($fecha_creacion){
            $this->fecha_creacion = $fecha_creacion;
        }

        public function getFechaM(){
            return $this->fecha_modificacion;
        }
        public function setFechaM($fecha_modificacion){
            $this->fecha_modificacion = $fecha_modificacion;
        }

        public function getFechaF(){
            return $this->fecha_finalizacion;
        }
        public function setFechaF($fecha_finalizacion){
            $this->fecha_finalizacion = $fecha_finalizacion;
        }

        public function getCompletada(){
            return $this->completada;
        }
        public function setCompletada($completada){
            $this->completada = $completada;
        }

        public function getId_usr_C(){
            return $this->id_usr_crea;
        }
        public function setId_usr_C($id_usr_crea){
            $this->id_usr_crea = $id_usr_crea;
        }

        public function getId_usr_M(){
            return $this->id_user_mod;
        }
        public function setId_usr_M($id_usr_mod){
            $this->id_usr_mod = $id_usr_mod;
        }

        public function getId_usr_Cp(){
            return $this->id_user_comp;
        }
        public function setId_usr_Cp($id_usr_comp){
            $this->id_usr_comp = $id_usr_comp;
        }

        public function registrarTarea($conexion){
            try{
            $consulta = $conexion->exec('INSERT INTO tareas.tareas (nombre,descripcion,fecha_creacion,id_usr_crea) VALUES ("'. $this->getNombre() .'","'. $this->getDescripcion() .'","'.$this->getFechaC().'","'. "" .'");');
            echo'<h1 id="bien">TAREA '.$t<his->nombre.' REGISTRADA!</h1>';
            }catch(Exception $e){
                die('<h1 id="mal">ERROR AL INSERTAR EL TAREA!</h1>');
                echo $e;
            }
        }
    }
    

    class Usuario{
        public $id;
        public $nombre;
        public $correo;
        public $contrasena;
        public $ruta_img;

        public function __construct($id,$nombre,$correo, $contrasena, $ruta_img){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->correo = $correo;
            $this->contrasena = $contrasena;
            $this->ruta_img = $ruta_img;
        }

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id = $id;
        }

        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getCorreo(){
            return $this->correo;
        }
        public function setCorreo($correo){
            $this->correo = $correo;
        }

        public function getContrasena(){
            return $this->contrasena;
        }
        public function setContrasena($contrasena){
            $this->contrasena = $contrasena;
        }

        public function getRuta_img(){
            return $this->ruta_img;
        }
        public function setRuta_img($ruta_img){
            $this->ruta_img = $ruta_img;
        }
    }
?>