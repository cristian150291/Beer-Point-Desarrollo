$(document).ready(function(){

   var ServiceURL = 'http://192.168.0.40/Pagina/login/mainUser/php/';   
   var idp = $("#idUsuario").html(); //obtengo numero de id_usuario registrado   
   var dataEmpresa;

   /**
   * Realizamos una llamda al servicio y cargamos la grila empresas utilizando metodos del plugin
   */
   fetch(ServiceURL+'actionEmpresa.php?action=list_emp').then(function(response){ return response.json();}).then(function(responseData) {     
     dataEmpresa = responseData;
     $("#tabla_empresasGrid").loadGrid({
        datos:responseData,
        cuerpo:'cuerpo_empresas',
        tabla:'table_empresas' 
     });
     //cargar(responseData);        
    }).catch(function(err) {
        console.log(err);
    });
    
    /**
    *Obtenemos puntos acumulados por perfil de usuario
    */    
    $("#point").getPoint({
      id:idp,
      respuesta:'point'
    });

    /**
    * Evento dbl clieck de la grilla
    */
    var table = $('#miTableId');
    var valores = [];
    $('#tabla_empresasGrid').on('dblclick', 'tbody tr', function(event) {                        
      //alert("Tamño es : "+ $(this).find("th").length);}        
      var idEmpresaGrid =  $(this).find("td")[0].innerText;
      var respuestaFechasEmp;
      $.ajax({                  
          type:'POST',
          url:'./php/actionEmpresa.php?action=list_emp_time', 
          data:{ID:idEmpresaGrid},          
          success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve                                                    
              console.log("Res" + response);
              respuestaFechasEmp = response;
              return false;                        
          }
    });

    for(var i=0; i<dataEmpresa.Records.length; i++){     
      if (dataEmpresa.Records[i].id == idEmpresaGrid){
        $("#nombreEmpresa").find('span').html(dataEmpresa.Records[i].descripcion);
      }
    }

    $('#miModalEmp').modal('show');
        //$('.modal_Emp').modal('show');
        /*rowIndex = this.rowIndex;
        valores = [$(this).find("th").length];
        $(this).find("th").each(function(index,valor){
            valores[index]=$(this).html();
        });            
        $("#saveReg").hide();
        $("#updateRed").show();
        $("#delete").show();
        modalShow();                            
        $("#form-in").find("input").each(function(index,valor){                 
            $(this).val(valores[index]);
        });*/
    });



    $("#modalId").click(function(){
        $("#miModal").modal("show");
    });

    $("#modalIdCon").click(function(){
        $("#miModalCon").modal("show");
    });

    //evento cambiar mail del usuario
    $("#guardarMail").click(function(){
        var mail = $("#exampleInputEmail1").val();
        var id  = $("#po").html();      
        
        $.ajax({                  
            type:'POST',
            url:'./php/actionUser.php?action=updateMail', 
            data:{mail:mail,id:id},                                           
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve    
                if(response == 'ok'){
                    $("#miModal").modal("toggle");
                    alert("Mail Actualizado con exito");
                }else if (response == '-1'){
                    $("#miModal").modal("toggle");
                    alert("Error al realizar la operacion");
                }else{
                    alert("Error desconocido");
                }                                                
                
                return false;                        
            }
        });           
    });

    //evento cambiar password del usario
    $("#guardarPass").click(function(){
        var pass = $("#exampleInputPassword1").val();
        var id  = $("#po").html();      
        
        $.ajax({                  
            type:'POST',
            url:'./php/actionUser.php?action=updatePass', 
            data:{pass:pass,id:id},                                           
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve    
                if(response == 'ok'){
                    $("#miModalCon").modal("toggle");
                    alert("Password Actualizado con exito");
                }else if (response == '-1'){
                    $("#miModalCon").modal("toggle");
                    alert("Error al realizar la operacion");
                }else{
                    alert("Error desconocido");
                }                                                
                
                return false;                        
            }
        });           
    });

   $( "#btn2" ).click(function( event ) {      
      $.ajax({            
          type:'POST',
          url:'./php/actionUser.php?action=list', 
          data:null,                               
          beforeSend: function () {
              $("#respuesta").html("Procesando, espere por favor...");
          },
          success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve                                                    
              $("#respuesta").html(response);
              return false;                        
          }                    
      });
      return false;
    }); // Fin de vento submit

    
    $('a[href="#user"]').click(function() {

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname) {
   
                var $target = $(this.hash);
   
                $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
   
                if ($target.length) {
   
                    var targetOffset = $target.offset().top;
   
                    $('html,body').animate({scrollTop: targetOffset}, 1500);
   
                    return false;
   
               }
   
          }
   
      });

      $('a[href="#user2"]').click(function() {

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname) {
   
                var $target = $(this.hash);
   
                $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
   
                if ($target.length) {
   
                    var targetOffset = $target.offset().top;
   
                    $('html,body').animate({scrollTop: targetOffset}, 1500);
   
                    return false;
   
               }
   
          }
   
      });

      $('a[href="#inicio"]').click(function() {

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname) {
   
                var $target = $(this.hash);
   
                $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
   
                if ($target.length) {
   
                    var targetOffset = $target.offset().top;
   
                    $('html,body').animate({scrollTop: targetOffset}, 1500);
   
                    return false;
   
               }
   
          }
   
      });


    //  carousel
        $('#myCarouselCustom').carousel();

        // Go to the previous item
        $("#prevBtn").click(function(){
            $("#myCarouselCustom").carousel("prev");
        });
        // Go to the previous item
        $("#nextBtn").click(function(){
            $("#myCarouselCustom").carousel("next");
        });
        
        $('.carousel').carousel({
            interval: 8000,
            pause:true,
            wrap:false
        });  

});