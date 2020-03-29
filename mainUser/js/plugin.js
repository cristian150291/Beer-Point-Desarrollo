
/**
* Plugin jquery personalizados
*/


/**
*loadGrid funcion jquery para cargar grillas de manera dinamica
*/
(function($) {
  // Declaración del plugin.
  $.fn.loadGrid = function(conf) {   	   
   console.log($(this).find("th").length);
   var columnas = $("."+conf.tabla+" tr:last th");
   var len = columnas.length;   
	for(var i=0; i<conf.datos.Records.length; i++){
        var myrow =document.createElement("tr");         
        myrow.setAttribute("class","clickable-row");   
        myrow.setAttribute("id",i+"reg");                        
        for(var j = 0 ;j < len ;j++ ){
            var mycell =document.createElement("td"); 
            var nombreId = columnas[j].id;
            if(columnas[j].getAttribute("class") == "ocultar"){
                mycell.setAttribute("style","display:none");
            }
            var currentText;
            for(var item in conf.datos.Records[i]) {
                if(item == nombreId){
                    currentText = document.createTextNode(conf.datos.Records[i][item]);                         
                    mycell.setAttribute("id",nombreId);                                                
                }                                                   
            }                
            mycell.appendChild(currentText);
            myrow.appendChild(mycell);
        }
       document.getElementById(conf.cuerpo).appendChild(myrow);                                
     }     
  }
})(jQuery);

/**
* getPoint retorna puntos acumulados por usuario
* recibe por parametro el id del usuario y repuesta, id donde se guardara los puntos devueltos
*/
(function($){
	$.fn.getPoint = function (conf){	//point idp	
		$.ajax({                  
	        type:'POST',
	        url:'./php/actionUser.php?action=point', 
	        data:{point:conf.id},
	        beforeSend: function () {
	            $("#"+conf.respuesta).html("Espere por favor...");
	        },
	        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve                                                    
	            $("#"+conf.respuesta).html(response);
	            return false;                        
	        }
    	});
	}
})(jQuery);
