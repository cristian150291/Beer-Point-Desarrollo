<?php
try{
	$con = mysql_connect("localhost","root","");
	mysql_select_db("crudproductos", $con);
	if($_GET["accion"] == "listar")	{
		$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM producto;");
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		if(isset($_REQUEST['filtro'])){
			$f=$_REQUEST['filtro'];
			$b=" WHERE (nombre LIKE '%$f%') OR (precio LIKE '%$f%') OR (cantidad LIKE '%$f%') OR (proveedor LIKE '%$f%') ";
		}else{
			$b="";
		}
		$result = mysql_query("SELECT * FROM producto $b ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		$rows = array();
		while($row = mysql_fetch_array($result)){
		    $rows[] = $row;
		}
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}else if($_GET["accion"] == "crear"){
		$result = mysql_query("INSERT INTO producto VALUES(NULL,'".$_POST["nombre"]."',".$_POST["precio"].",".$_POST["cantidad"].",'". $_POST["proveedor"]."')");
		$result = mysql_query("SELECT * FROM producto WHERE id = LAST_INSERT_ID();");
		$row = mysql_fetch_array($result);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}else if($_GET["accion"] == "actualizar"){
		$result = mysql_query("UPDATE producto SET nombre='".$_POST["nombre"]."', precio=".$_POST["precio"].", cantidad=".$_POST["cantidad"].",proveedor='".$_POST["proveedor"]."' WHERE id=" . $_POST["id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}else if($_GET["accion"] == "eliminar"){
		$result = mysql_query("DELETE FROM producto WHERE id= " . $_POST["id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	mysql_close($con);
}catch(Exception $ex){
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}	
?>

//EJEMPLO CON EL JS 
<script type="text/javascript">
		$(document).ready(function () {
			$('#Productos').jtable({
				title: 'Tabla Productos',
				paging: true,
				pageSize:5,
				sorting: true,
				defaultSorting: 'nombre ASC',
				toolbar: {
					    items: [
					    {
					        icon: 'img/pdf.png',
					        text: 'Exportar a PDF',
					        click: function () {
					         	window.open('html2pdf/pdf/pdf2.php',"_blank");
					        }
					    }]
					},
				actions: {
					listAction: 'productos.php?accion=listar',
					createAction: 'productos.php?accion=crear',
					updateAction: 'productos.php?accion=actualizar',
					deleteAction: 'productos.php?accion=eliminar'
				},
				fields: {
					id: {
						title: 'Id Producto',
						key: true,
						create: false,
						edit: false,
						list: false
					},
					nombre: {
						title: 'Nombre Producto',
						width: '25%'
					},
					precio: {
						title: 'Precio',
						width: '25%'
					},
					cantidad: {
						title: 'Cantidad',
						width: '25%'
					},
					proveedor: {
						title: 'Proveedor',
						width: '25%',
						options:<?php
									$con = mysql_connect("localhost","root","");
									mysql_select_db("crudproductos", $con);
									$result = mysql_query("SELECT * FROM proveedor");
									$n=mysql_num_rows($result);
									echo "{";
									$i=0;
									while($row = mysql_fetch_array($result)){
										$i++;
									    echo "'".$row['proveedor']."':'".$row['proveedor']."'";
									    if($i<$n){
									    	echo ",";
									    }	    
									}
									echo "}";
								?>
						}						
				}
			});
			$('#filtrar').keyup(function (e) {
				$('#Productos').jtable('load',{
					filtro:$('#filtrar').val()
				});
			});
			$('#Productos').jtable('load');
		});
	</script>