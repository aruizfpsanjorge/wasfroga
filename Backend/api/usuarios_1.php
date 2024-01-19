<?php

//localhost/5ud/REST/api/usuarios.php
header("Content-Type: application/json"); //formato salida.
include_once("../Clases/class_usuario.php");


$_POST=json_decode(file_get_contents('php://input'),true); //decodificar el json 

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
      
        /*
        if (isset($_POST)){
            $usuario= new Usuario($_POST["nombre"],$_POST["apellido"],$_POST["fechaNacimiento"],$_POST["genero"]);
            $usuario-> guardarUsuario();
            $resultado["mensaje"]="Guardar usuario, informacion:" . json_encode($_POST);
            echo json_encode($resultado);
        }
        break;
        */
        if (isset($_POST['nombre'])&&isset($_POST['apellido'])&&isset($_POST['fecha'])&&isset($_POST['genero'])){
            $user= new Usuario($_POST['nombre'],$_POST['apellido'],$_POST['fecha'],$_POST['genero']);
            $user->guardarUsuario();
        }
        break;
     

    case 'GET':

      
        if (isset($_GET['id'])){

            Usuario::obtenerUsuario($_GET['id']);
           
        }
        else{
            //todos
            Usuario::obtenerUsuarios();//ESTATICO
        }
        break;

    case 'PUT':

        $put=json_decode(file_get_contents('php://input'),true); //decodificar el json 
        echo "<h1>Actualizar</h1>";
        if ((isset($put))&&(isset($_GET['id']))){
            echo "Actualizar idusuario:". $_GET['id'];
            echo" , Información a actualizar:". json_encode($put);

        }


        break;

    case 'DELETE':
       /* echo "<h1>Eliminar</h1>";
        if (isset($_GET['id'])) echo "Elimnar user con id:". $_GET['id'];
        break;*/

        if (isset($_GET['id'])){

            Usuario::eliminarUsuario($_GET['id']);
           
        }
}
?>