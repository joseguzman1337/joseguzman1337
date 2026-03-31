/*
 * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>.
 * Se realizan los ajustes de validación de cada una de las ordenes (Origen y Destino) y los estados de las mismas.
 * Se modifica el entorno visual usando las librerias de Boptstrap.
 * @since Febrebro 5 de 2018.
*/ 
jQuery.validator.setDefaults({
highlight:function(element){
$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
},
unhighlight:function(element){
$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
},
errorElement:'span',
errorClass:'help-block',
errorPlacement:function(error,element){
if(element.parent('.input-group').length){
error.insertAfter(element.parent());
}else{
error.insertAfter(element);
}
}
});

function CambiarOrdenes(){
       $('#action_ID').val('Save');
         $.ajax({//Ajax
                  type: 'POST',
                  url: '../Controller/CambioCargaAcademica_html.php',
                  async: false,
                  dataType: 'json',
                  data:$('#OrdenCambio').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Ninguna de las Ordenes puede estar anulada...');},
                  success: function(data){
                      if(data.val==false){
                         alert(data.descrip);
                         return false;
                      }else
                      {
                        alert(data.descrip1);    
                        BuscarInfoOrdenes();              
                      }
                  }//DATA   
           });//AJAX
}//End function CambiarOrdenes

function BuscarInfoOrdenes(){
    $('#OrdenCambio').validate({
        rules:{
        Orden_1:{ required:true,number: true, minlength: 7, maxlength: 7 },
        Orden_2:{ required:true,number: true, minlength: 7, maxlength: 7 }
        },
        messages:{
        Orden_1:{required:"Debe Digitar la Orden con Carga", number:"Solo se permiten números", minlength:"Debe digitar 7 Caracteres", maxlength:"Debe digitar 7 Caracteres" },
        Orden_2:{required:"Debe Digitar la Orden sin Carga", number:"Solo se permiten números", minlength:"Debe digitar 7 Caracteres", maxlength:"Debe digitar 7 Caracteres" }
        }
    });  
   
    if($('#OrdenCambio').valid()){   
            $('#action_ID').val('Buscar');
            $('#Buscar').css('display','none'); 
            $.ajax({//Ajax
                      type: 'POST',
                      url: '../Controller/CambioCargaAcademica_html.php',
                      async: false,
                      dataType: 'html',
                      data:$('#OrdenCambio').serialize(),
                      //data:({action_ID:'Convenios',id:id}),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexion , Favor Vuelva a Intentar');},
                      success: function(data){
                        $('#Buscar').css('display','inline');
                        $('#CargarInfo').html(data);
                      }//DATA
               });//AJAX
    }
}//End function BuscarInfoOrdenes.

function Regresar(){
    location.href='../Controller/CambioCargaAcademica_html.php';
}//End function Regresar.