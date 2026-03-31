
$(document).ready(function () { 
    $('#exportarDocumento').click(function(e){
        $("#datos_a_enviar").val( $("<div>").append( $("#tablaReporteHoras").eq(0).clone()).html());
        $("#formInforme").submit();
    });
});


function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 910) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=960, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
}
