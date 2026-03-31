function BuscarPrograma(value){
 
  $.ajax({//Ajax
      type: 'POST',
      url: '../Controller/CambioPlanEstudio_html.php',
      async: false,
      dataType: 'html',
      data:{ dato : value ,action_ID:'Programa'},
      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
      success: function(data){
            $('#Td_Programa').html(data);
      }//DATA
  });//AJAX
  
}//function BuscarPrograma
function VerPlanEstudio(value){
    
  $.ajax({//Ajax
      type: 'POST',
      url: '../Controller/CambioPlanEstudio_html.php',
      async: false,
      dataType: 'html',
      data:{ dato : value ,action_ID:'PlanEstudio',text:'PlanOld'},
      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
      success: function(data){
            $('#Td_PlanOld').html(data);
      }//DATA
  });//AJAX
  
  $.ajax({//Ajax
      type: 'POST',
      url: '../Controller/CambioPlanEstudio_html.php',
      async: false,
      dataType: 'html',
      data:{ dato : value ,action_ID:'PlanEstudio',text:'PlanNew'},
      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
      success: function(data){
            $('#Td_PlanNew').html(data);
      }//DATA
  });//AJAX  
}//function VerPlanEstudio
function CargarArchivo(){
    $('#opc').val('1');
    $('#Tr_OldPlan').css('visibility','collapse');
    $('#Tr_Archivo').css('visibility','visible');
    $('#Tr_Excel').css('visibility','collapse');
    $('#Tr_Return').css('visibility','visible');
}//function CargarArchivo
function VolverFormulario(){
    $('#opc').val('');
    $('#Tr_OldPlan').css('visibility','visible');
    $('#Tr_Archivo').css('visibility','collapse');
    $('#Tr_Excel').css('visibility','visible');
    $('#Tr_Return').css('visibility','collapse');
}//function VolverFormulario
function Validar(){
    if($('#modalidad').val()==-1 || $('#modalidad').val()=='-1'){
        /************************************/
        $('#modalidad').effect("pulsate", {times:3}, 500);
        $('#modalidad').css('border-color','#F00');
        return false;
        /************************************/
    }
    
    if($('#programa').val()==-1 || $('#modalidad').val()=='-1'){
        /************************************/
        $('#programa').effect("pulsate", {times:3}, 500);
        $('#programa').css('border-color','#F00');
        return false;
        /************************************/
    }
    if($('#opc').val()!=1){
    
        if($('#PlanOld').val()==-1 || $('#modalidad').val()=='-1'){
            /************************************/
            $('#PlanOld').effect("pulsate", {times:3}, 500);
            $('#PlanOld').css('border-color','#F00');
            return false;
            /************************************/
        }
    }
    
    if($('#PlanNew').val()==-1 || $('#modalidad').val()=='-1'){
        /************************************/
        $('#PlanNew').effect("pulsate", {times:3}, 500);
        $('#PlanNew').css('border-color','#F00');
        return false;
        /************************************/
    }
    
    /***************************/
    return true;
    /***************************/
}//function Validar
function SaveFormulario(){
    if(Validar()){
        $('#action_ID').val('SaveData');
        /***********************************/
        var formData = new FormData($(".CambioPlanEstudioFormulario")[0]);
    
         $.ajax({
                url: '../Controller/CambioPlanEstudio_html.php',  
                type: 'POST',
                dataType: 'json',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //mientras enviamos el archivo
                beforeSend: function(){
                    message = $("<span class='before'>Subiendo Datos del Archivo, por favor espere...</span>");
                    showMessage(message);        
                },
                //una vez finalizado correctamente
                success: function(data){
                    if(data.val==false){                      
                        message = $("<span class='error'>Error en el Archivo...</span>");
                        showMessage(message);
                        return false;                       
                    }else{
                    message = $("<span class='success'>Se ha realizado los cambios de forma correcta.</span>");
                    
                    showMessage(message);
                   } 
                },
                //si ha ocurrido un error
                error: function(){
                    message = $("<span class='error'>Ha ocurrido un error.</span>");
                    showMessage(message);
                }
            });
        /***********************************/
    }
}//function SaveFormulario
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 