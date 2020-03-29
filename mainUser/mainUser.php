<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>BeerPoint</title>

    <link rel="icon" href="imagenes/beerpoint.ico">

    <link href="https://fonts.googleapis.com/css?family=Cinzel:700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="css/estilos.css">

   

</head>

<body>

    <?php session_start();  
        if(isset($_SESSION['User'])){
            // echo "<p>El nombre es $_SESSION[User] </p>";
            //echo '<a href="./php/logout.php?Logout"> Logout </a>';
            $idp = $_SESSION['id'];
        }else {
            header('location:../index.html');
        }        
    ?>

    <!-- Modal en bootstrap para realizar el cambio de mail del usuario -->
    <div id="miModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
            <div class="modal-body">
              <!-- Form para reingreso de datos del usaurio -->
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ingreso de direccion de Mail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nuevo Mail">
                        <small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie más.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="guardarMail">Guardar</button>
                </form>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
     </div>
    </div>
    </div>

        <!-- Modal en bootstrap para realizar el cambio de contraseña del usuario -->
    <div id="miModalCon" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Contenido del modal -->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
                <div class="modal-body">
                  <!-- Form para reingreso de datos del usaurio -->
                    <form>                
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                                    
                        <button type="submit" class="btn btn-primary" id="guardarPass">Guardar</button>
                    </form>
                </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
          </div>
         </div>
        </div>
    </div>

    <!-- -->
    <div id="miModalEmp" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Contenido del modal -->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>            
          </div>
                <div class="modal-body">
                  <!-- Form para reingreso de datos del usaurio -->
                  <div id="nombreEmpresa">
                     <h4>Detalle de la empresa <span> </span></h4>
                  </div>
                  
                    <form id="formModalEmp">
                        
                    </form>
                </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
          </div>
         </div>
        </div>
    </div>


    
    <header id="main-header">
        
        <a id="logo-header" href="#">
            <span class="site-name">Beer-Point</span>
            <span class="site-desc">Encontra lo mejor para vos.</span>
        </a> <!-- / #logo-header -->

        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Acerca de</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav><!-- / nav -->

    </header>

    <div class="container">
        <div class="row imgHeader">
             <div id="botonCont"class="col-md-12">
                    <img src="imagenes/fiesta-amigos.jpg" class="img-fluid" width="100%" height="15%" alt="Responsive image">
                    <button style="float:right" id="dropBoton" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id= "idUsuario" ><?php echo $idp;?></span> <?php echo "$_SESSION[User] ";?>                             
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                         <a class="dropdown-item" id="modalId" href="#">Cambiar mail</a>
                         <a class="dropdown-item" id="modalIdCon" href="#">Cambiar contraseña</a>
                         <a class="dropdown-item" href="./php/logout.php?Logout">Salir</a>
                    </div>
            </div>
        </div>

        <div class="row">

            <div id="puntosCont"class="col-md-4 col-xs-6 mx-auto">

                <div id="contTitulo"class="row">

                    <div id="puntos" class="col-md-6 mx-auto">

                        <h2> Tus puntos:</h2>
                        
                    </div>

                </div>

                <div  class="col-md-6 mx-auto">                    
                    <h3 id="point"></h3>
                </div>

            </div>

            <div id="sidePuntos"class="col-md-4 mx-auto">

                <h2 class="tituloGral">Locales adheridos</h2>
                <table id="tabla_empresasGrid" class="table_empresas table table-dark">
                  <thead>
                    <tr>
                      <th id="id" scope="col" class="ocultar" style="display:none">ID</th>
                      <th id="descripcion" scope="col">Local</th>
                      <th id="prestigio" scope="col">Prestigio</th>
                      <th id="activo" scope="col">Abierto</th>
                    </tr>
                  </thead>
                  <tbody id="cuerpo_empresas">
                    
                  </tbody>
                </table>
            </div>

        </div>

    </div>



     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
     <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./js/js.js"></script>
    <script src="./js/plugin.js"></script>

</body>

</html>