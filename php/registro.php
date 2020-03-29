<?php       
    try{

        require 'Db.class.php';
        //Instancio de manera static a la clase DB para la conexion  a la base de datos
        $db = Db::getInstance();

        //Capturo datos por POST
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $mail = $_POST['mail'];
        $fecha = $_POST['fecha'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        //$newDate = date("yyy/mm/dd", strtotime($fecha ));
        $fecha_format_2 = date('d-m-Y', strtotime($fecha));

        /*if (isset($fecha)){
        $fbaja = "to_date('$fecha', 'dd/mm/yyyy')";
        }
        else{
        $fbaja = "NULL";
        }*/

        

        
          //Realizo la consulta a la base de datos        
          $queryd = " INSERT INTO usuario.usuario (dni, nombre, apellido, mail, fechan) VALUES ('$dni','$nombre','$apellido','$mail','$fecha_format_2');";

          //Ejecuto la consulta a la base de datos
           $db->ejecutar($queryd) or die("Error en la Conexión: ".pg_last_error());

          
              
          $sqlid = "SELECT id FROM usuario.usuario WHERE dni ='$dni';";

          $id = $db->ejecutar($sqlid) or die("Error en la Conexión: ".pg_last_error());

          $row = pg_fetch_array($id);
          $idp = $row['id'];

          $sqlpw = "INSERT INTO usuario.pws(id_usuario, us, pw) VALUES ('$idp','$usuario','$password');";

          $re = $db->ejecutar($sqlpw) or die("Error en la Conexión: ".pg_last_error());


          if($re){
            echo "1";
          }else {
              echo "-1";
          }

        $db->cerrar_pg(); 

    }catch(Exception $ex) {
        //Return error message
        echo "Error no descrito";
    }	
?>