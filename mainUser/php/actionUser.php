<?php
        /*session_start();
        if(isset($_SESSION['User'])){

        }else {
            header('location:../mainUser.php');
        } */
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    try{

        require 'Db.class.php';
        //Instancio de manera static a la clase DB para la conexion  a la base de datos
        $db = Db::getInstance();

        //Accion List , lista todos los usuarios
        if($_GET["action"] == "list")
        {

            //Ejecutamos la query
            $stmt = $db->listForTable ();

            $numregistro = pg_num_rows($stmt);
            if($numregistro > 0){
                $line = array();

                while ($row = pg_fetch_array($stmt)){
                    $line[] = $row;
                }
                //Armo result para la jtable
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                //$jTableResult['TotalRecordCount'] = $recordCount;
                $jTableResult['Records'] = $line;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jTableResult,true);
            }else {
                echo "-1";
            }
        }
        //Accion create, añade un nuevo usuario
        else if($_GET["action"] == "create")
        {
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $mail = $_POST['mail'];

                 //Realizo la consulta a la base de datos
                $queryd = " INSERT INTO usuario.usuario (dni, nombre, apellido, mail) VALUES ('$dni','$nombre','$apellido','$mail');";

                //Ejecuto la consulta a la base de datos
                $result = $db->ejecutar($queryd) or die("Error en la Conexión: ".pg_last_error());

                //Ejecutamos la query
                $stmt = $db->listForTable ();

                //Obtenemos la cantidad de registros, si son mas de uno enviamos
                //en su defectos enviamos un error
                $numregistro = pg_num_rows($stmt);

                if($numregistro > 0){
                    $line = array();
                    while ($row = pg_fetch_array($stmt)){
                        $line[] = $row;
                    }

                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    //$jTableResult['TotalRecordCount'] = $recordCount;
                    $jTableResult['Records'] = $line;
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jTableResult);
                }else {
                     echo "-1";
                }
        }
        //Accion Update, actualiza registro seleccionad0
        else if($_GET["action"] == "update")
        {
						$id = $_POST['id'];
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $mail = $_POST['mail'];
            //Update record in database
            //Realizo la consulta a la base de datos
            $query = "UPDATE usuario.usuario SET dni='$dni', nombre='$nombre', apellido='$apellido', mail='$mail' WHERE id = '$id';";

            //Ejecuto la consulta a la base de datos
            $result = $db->ejecutar($query) or die("Error en la Conexión,Update: ".pg_last_error());

            if($result){
							if (pg_query("COMMIT")) {
								/**
                 * Lo que necesitamos es que despues de realizar el update, enviar de nuevo un json
                 * con la lista cargada actualizada , de esta forma se actializa la grilla
                 */
                //Ejecutamos la query
                $stmt = $db->listForTable ();

                //Obtenemos la cantidad de registros, si son mas de uno enviamos
                //en su defectos enviamos un error
                $numregistro = pg_num_rows($stmt);
                /**
                 * Si obtenemos numeros de registros, queda por entendido que la consulta fue realizada con exito
                 * y hay datos cargados en la base de datos
                 */
                if($numregistro > 0){
                    $line = array();
                    while ($row = pg_fetch_array($stmt)){
                        $line[] = $row;
                    }

                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    //$jTableResult['TotalRecordCount'] = $recordCount;
                    $jTableResult['Records'] = $line;
                    //enviamos datos json
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jTableResult);
                }else {
                    $jTableResult = array();
                    $jTableResult['Result'] = "ERROR";
                    $jTableResult['Records'] = null;
                    echo json_encode($jTableResult);
                }
							}else {
	            	// code...
								$jTableResult = array();
								$jTableResult['Error'] = "false";
								$jTableResult['Records'] = result;
								echo json_encode($jTableResult);
	            }


            }
        }
        //Accion delete, elimina tupla seleccionada
        else if($_GET["action"] == "delete "){
            $id = $_POST['id'];
            $dni = $_POST['dni'];
            //Realizo la consulta a la base de datos
            $queryd = "DELETE FROM usuario.usuario WHERE id ='$id';";

            //Ejecuto la consulta a la base de datos
            $result = $db->ejecutar($queryd) or die("Error en la Conexión,Update: ".pg_last_error());

                if($result){
                    $stmt = $db->listForTable ();
                    //Obtenemos la cantidad de registros, si son mas de uno enviamos
                    //en su defectos enviamos un error
                    $numregistro = pg_num_rows($stmt);

                    if($numregistro > 0){
                        $line = array();

                        while ($row = pg_fetch_array($stmt)){
                            $line[] = $row;
                        }

                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['Records'] = $line;
                        //enviamos datos json
                        header('Content-type: application/json; charset=utf-8');
                        echo json_encode($jTableResult);
                    }else {
                        echo "Error tratando de obtener el update de la lista a la base de datos";
                    }
                }else {
                    echo "Error al intentar hacer delete en la base de datos";
                }
        }
        //Service que reponde a la carga de puntos de los usuarios loggeados
        else if($_GET["action"] =="point")
        {

            //captura identificador de usuario
            $id1 = $_POST['point'];

            //Realiza consulto a la base de datos capturando la cantidad de puntos obtenidos
            $sql = "SELECT puntos FROM usuario.point where id_usuario = $id1";

            //Ejecutamos la query
            $stmt = $db->ejecutar($sql);

            //Verifico que por lo menos recibi una tupla/registro de la base de datos
            $numregistro = pg_num_rows($stmt);

            if($numregistro > 0){
                while ($row = pg_fetch_array($stmt)){
                    $line = $row;
                }
                //envio puntos
                echo $line['puntos'];
            }else {
                echo "????";
            }
        }
        // Action que responde a la actualizacion del mail de los usuarios
        else if ($_GET["action"] == "updateMail"){
            $mail = $_POST["mail"];
            $id  = $_POST["id"];
            $sql = "UPDATE usuario.usuario SET  mail= '$mail' WHERE id ='$id' ;";

            $stm = $db->ejecutar($sql) or die("Error en la Conexión,Update: ".pg_last_error());

            if($stm){
                echo "ok";
            }else{
                echo "-1";
            }

        }
        // Action que responde a la actualizacion del password de los usuarios
        else if ($_GET["action"] == "updatePass"){
            $pass = $_POST["pass"];
            $id  = $_POST["id"];
            $sql = "UPDATE usuario.pws SET pw='$pass'  WHERE id_usuario = '$id' ;";

            $stm = $db->ejecutar($sql) or die("Error en la Conexión,Update: ".pg_last_error());

            if($stm){
                echo "ok";
            }else{
                echo "-1";
            }

        }

        $db->cerrar_pg();

    }catch(Exception $ex) {
        //Return error message
        $jTableResult = array();
        $jTableResult['Result'] = "ERROR";
        $jTableResult['Message'] = $ex->getMessage();
        print json_encode($jTableResult);
    }
?>
