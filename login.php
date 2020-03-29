<?php

/*Incluimos el fichero de la clase*/
require './php/Db.class.php';

session_start();

/*Obtenemos datos ingresados por el usuario*/
$usu = $_POST['usu'];
$pw =  $_POST['pw']; 

/*Creamos la instancia del objeto. Ya estamos conectados*/
$bd=Db::getInstance();

/*Creamos una query sencilla*/
$sql="SELECT us, pw FROM usuario.pws where us = '$usu' and pw = '$pw' ;";

/*Ejecutamos la query*/
$stmt=$bd->ejecutar($sql);

//Guardo id_usuario de la contrasena ingresada para solicitar puntos del mismo
$sqlid = "SELECT id_usuario FROM usuario.pws WHERE us='$usu' AND pw='$pw';";
$result = $bd->ejecutar($sqlid) or die("Error en la Conexión: ".pg_last_error());
$row = pg_fetch_array($result);
$idp = $row['id_usuario'];


/** Obtengo cantidad de registros de la consulta a la base de datos*/
$numReg = pg_num_rows($stmt);

    if($numReg>0){    
        $_SESSION['User'] = $usu;        
       $_SESSION['id'] = $idp;
        echo '1';
    } else{        
        echo "-1";
    }

    /** Cierro conexion de la instacia a la base de datos */
$bd->cerrar_pg();    
?>