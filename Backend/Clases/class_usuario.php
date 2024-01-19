<?php
include("conexion.php");
$bd = new BaseDatos();
$conexion= $bd->conectar();
class Usuario{
   
    private $nombre;
    private $apellido;
    private $fechaNacimiento;
    private $genero;

    public function __construct($nombre,$apellido,$fecha, $genero){
       
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->fechaNacimiento=$fecha;
        $this->genero= $genero;
    }

    public function guardarUsuario(){
       /* $contenido= file_get_contents("../Data/usuarios.json");
        $usuarios = json_decode($contenido,true);
        $usuarios[]=array(
         "id" => $this->id,   
         "nombre" => $this->nombre,
         "apellido" => $this->apellido,
         "fechaNacimiento" => $this->fechaNacimiento,
         "genero" => $this->genero
        );
        $archivo= fopen("../Data/usuarios.json","w");
        fwrite($archivo,json_encode($usuarios));
        fclose($archivo);
*/
        global $bd;
        $sql = "INSERT INTO alumnos (Nombre,Apellido,FechaNacimiento,Genero) VALUES ('$this->nombre','$this->apellido','$this->fechaNacimiento','$this->genero')";
    
        $bd->insertar($sql);
    }

    public static function obtenerUsuario($id){
        /*$contenido= file_get_contents("../Data/usuarios.json");
        $usuarios=json_decode($contenido,true);
        echo json_encode($usuarios[$id]);*/
        global $bd;
        $data=[];
        $sql="SELECT * FROM alumnos where id='".$id."'";
        $resultado=$bd->seleccionar($sql);
        $alumnos = mysqli_fetch_assoc($resultado);   
        echo json_encode($alumnos);

    }

    public static function obtenerUsuarios(){
        //$contenido= file_get_contents("../Data/usuarios.json");
        //echo $contenido;
        global $bd;
        $data=[];
        $sql="SELECT * FROM alumnos";
        $resultado=$bd->seleccionar($sql);
        
        while ($alumnos = mysqli_fetch_assoc($resultado)) {
             $data[]=$alumnos;
        }
        $var= json_encode($data);
        echo json_encode($data);

   
    }


    public static function eliminarUsuario($id){
        //$contenido= file_get_contents("../Data/usuarios.json");
        //echo $contenido;
        global $bd;
      
        $sql="DELETE FROM alumnos where id='".$id."'";
        $resultado=$bd->eliminar($sql);
       

   
    }


    public function getId() {
        return $this->id;
    }
    public function setID($id) {
       $this->id=$id;
      
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($n) {
        $this->nombre=$n;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido=$apellido;
    }

    public function getFechaNacimiento() {
        return $this->getFechaNacimiento;
    }

    public function setFechaNacimiento($fecha) {
        $this->FechaNacimiento=$fecha;
    }
    public function getGenero() {
        return $this->genero;
    }
    public function setGenero($gen) {
        $this->genero=$gen;
    }


}