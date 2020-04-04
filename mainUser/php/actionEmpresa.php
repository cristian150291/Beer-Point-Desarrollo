<?php
        //session_start();
        //if(isset($_SESSION['User'])){
	        header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

	    	try{

	    		require 'Db.class.php';
        		//Instancio de manera static a la clase DB para la conexion  a la base de datos
        		$db = Db::getInstance();

        		        //Accion List , lista todos los usuarios
	        	if($_GET["action"] == "list_emp_time"){	
	        		$idEmp = $_POST['ID'];
		            //Ejecutamos la query
		            $array_equipo = array('t1.descripcion','t2.dia','t2.horaapertura','t2.horacierre');
		            $stmt = $db->listForTableGeneric('empresa','usuario',$array_equipo,'usuario.horariosempresa',$idEmp);

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
		        } else if($_GET["action"]=="list_emp"){
		        	//Ejecutamos la query		            
		            $stmt = $db->ejecutar("SELECT * FROM usuario.empresa;");

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

		        	}				
		        }else if($_GET["action"] == "valoracion"){
		        	$idEmp = $_POST['ID'];
		        	$valor = $_POST['valor'];
		        	$sql = "UPDATE usuario.empresa SET prom_valoracion=prom_valoracion + $valor WHERE id = $idEmp;";
		        	$stmt = $db->ejecutar($sql);
		        	$sql = "UPDATE usuario.empresa SET cant_valoracion=cant_valoracion+1 WHERE id = $idEmp;";
		        	$stmt = $db->ejecutar($sql);
		        	$sql = "UPDATE usuario.empresa SET prestigio =prom_valoracion/cant_valoracion WHERE id = $idEmp;";
		        	$stmt = $db->ejecutar($sql);

		        	if ($stmt){
						header('Content-type: application/json; charset=utf-8');
		                echo "1";
		        	}else{
		        		echo "-1";
		        	}
		        }

	    	}catch(Exception $ex) {
		        //Return error message
		        $jTableResult = array();
		        $jTableResult['Result'] = "ERROR";
		        $jTableResult['Message'] = $ex->getMessage();
		        print json_encode($jTableResult);
	    	}
       // }else {
         //   header('location:../mainUser.php');
       // }
 ?>