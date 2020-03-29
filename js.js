/**
 * Con documet ready leo el archivo html, luego detecto el evento del click
 * sobre el button de enviar datos para el acceso login a la pagina principal
 */
$(document).ready(function(){         
    
    
    

    /**
     * Obtengo el evento de submit para consulta a la base de datos,
     * realizo una peticion ajax post a un php y detectar usuario,
     * en caso de ser un usuario valido damos acceso y direccionamos la 
     * oagina la principal de user
     */

    //$('#btnlogin').attr("disabled", true);
    $( "#btnlogin" ).click(function( event ) {              
        if(validar()){                       
                $.ajax({            
                    type:'POST',
                    url:'login.php',            
                    data:{usu:$("#us").val(),pw:$("#pw").val()},
                    beforeSend: function () {
                        $("#respuesta").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        if (response == 1){                       
                            location.href ="./mainUser/mainUser.php";
                        }else if (response == -1){                    
                            $('#myModal').modal('show'); 
                            $("#respuesta").html("Usuario o Password invalidos");
                        }                        
                    }
            });
          
        }else {
                      
        }     
        return false;
      }); // Fin de vento submit

      /***
        <form action="./php/registro.php" method="POST">
        nombre <input type="text" value="nombre" id="Nregistro"> <br>
        apellido : <input type="text" value="apellido" id="Aregistro"><br>
        mail : <input type="mail" value="mail" id="Mregistro"><br>
        fecha nacimineto : <input id="date" type="date" value="ingreso de fecha" id="Fregistro"><br>
        usuario : <input type="text" value="usuario" id="Sregistro"><br>
        password : <input type="password" value="pass" id="Pregistro"><br>
        <input type="submit" value="Registrarse" id="registro">
    </form>
        
        */
      
      $( "#registro" ).click(function( event ) {       
            
        $.ajax({            
            type:'POST',
            url:'./php/registro.php',            
            data:{nombre:$("#Nregistro").val(),apellido:$("#Aregistro").val(),dni:$("#Dregistro").val(),mail:$("#Mregistro").val(),fecha:$("#Fregistro").val(),usuario:$("#Sregistro").val(),password:$("#Pregistro").val()},
            /*beforeSend: function () {
                $("#registrores").html("Procesando, espere por favor...");
            },*/
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                if (response == 1){                       
                    location.href ="./index.html";
                }else if (response == -1){                                               
                    $("#registrores").html("Error al intentar dar de alta al nuevo usuario");
                } else {
                    alert(response);
                }                       
            }
        });          
        return false;
      }); // Fin de vento submit

      function isChecked (objThis,obj){
        if(objThis['checked'] == true){
            obj.attr('type', 'text');
        }else{
            obj.attr('type','password');
        }
      }

      //Funcion para ocultar o mostrar password al usuario
      $("#ver").change(function (){       
        var obj =  $("#pw");
         isChecked(this,obj);       
      });

      //ver en registro
      $("#verRegistro").change(function (){        
        if($('#verRegistro').is(':checked')){
            $("#Pregistro").attr('type', 'text');
        }else{
            $("#Pregistro").attr('type','password');
        }
      });

      //Funcion validacion de campos

      function validar () {
          if ($("#us").val().length <= 0){
            $("#usua").html("Debe ingresar un Usuario");            
            return false;
          }
          if($("#pw").val().length <= 0 ){
            $("#pwd").html("Debe ingresar Password");
            return false;
          }
          return true;  
      }    

});