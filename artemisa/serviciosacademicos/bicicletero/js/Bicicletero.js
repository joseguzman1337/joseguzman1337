function BuscarData(){
    if(ValidaBoxText('NumDocenteAdmin') && ValidaBoxText('Nom_DocenteAdmin') && ValidaBoxText('Apll_DocenteAdmin') && ValidaBoxText('captcha')){ 
           $('#action_ID').val('ValidarAcceso');
                 $.ajax({//Ajax
                      type: 'POST',
                      url: '../Controller/Bicicletero_html.php',
                      async: false,
                      dataType: 'json',
                      data:$('#AccesoDocenteAdmin').serialize(),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                      success: function(data){
                            if(data.val==false){
                                alert(data.msj+'\n'+data.msj2);
                                location.href='../Controller/Bicicletero_html.php?action_ID=Acceso';
                                return false;
                            }else{
                                alert(data.msj+'\n'+data.msj2);
                                $.ajax({//Ajax
                                      type: 'POST',
                                      url: '../Controller/Bicicletero_html.php',
                                      async: false,
                                      dataType: 'html',
                                      data:{ dato : data.datoadmindocente ,op:1},
                                      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                                      success: function(data){
                                            $('#VerFormulario').html(data);
                                      }//DATA
                                 });//AJAX
                            }
                      }//DATA
                 });//AJAX
          
     }
}//function BuscarData
function ValidaBoxText(name){
    if(!$.trim($('#'+name).val())){
        /************************************/
        $('#'+name).effect("pulsate", {times:3}, 500);
        $('#'+name).css('border-color','#F00');
        return false;
        /************************************/
    }
    var texto = $('#'+name).val();
    var num = texto.length;
    if(num<3){
        /************************************/
        alert('Debe escribir Su primer Nombre y Apellido.');
        $('#'+name).effect("pulsate", {times:3}, 500);
        $('#'+name).css('border-color','#F00');
        return false;
        /************************************/
    }
    return true;
}//function ValidaMultiBox
function ActivarDesactivar(value){
    if(value==12){
        $('#TD_OtherLabel').css('visibility','visible');//visibility: visible
        $('#TD_OtherBox').css('visibility','visible');
    }else{
        $('#TD_OtherLabel').css('visibility','collapse');//visibility: collapse
        $('#TD_OtherBox').css('visibility','collapse');
    }
}//function ActivarDesactivar
function SaveDocenteAdmin(){
    $('#action_ID').val('SaveData');
    $('#opc').val(1);
    var formData = new FormData($(".BicicleteroFromulario")[0]);
    
     $.ajax({
            url: '../Controller/Bicicletero_html.php',  
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
                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                showMessage(message);        
            },
            //una vez finalizado correctamente
            success: function(data){
                if(data.val==false){
                   if(data.Op==1){
                        alert('Error en el Tama\u00f1o de la imagen...');
                        message = $("<span class='error'>Error en el Tama\u00f1o de la imagen...</span>");
                        showMessage(message);
                        return false;
                   }else{
                        alert(data.msj);
                        message = $("<span class='error'>Error la Imgen no es tipo jpeg-png-jpg</span>");
                        showMessage(message);
                        return false;
                   } 
                }else{
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                
                showMessage(message);
                if(isImage(data.type))
                    {
                        $(".showImage").html("<img src="+data.img+" width='300' />");
                    }
                }
                
                setTimeout(function(){
                    if(confirm('Desea adicionar otra bicicleta...?')){
                        cargarFormulario();
                    }else{
                        $('#SaveBici').css('display','none');
                    }
                },2000);
                
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    //
    
}//function SaveDocenteAdmin
function SaveEstudiante(){
    $('#action_ID').val('SaveData');
    $('#opc').val(0);
    var formData = new FormData($(".BicicleteroFromulario")[0]);
    
     $.ajax({
            url: '../Controller/Bicicletero_html.php',  
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
                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                //showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                if(data.val==false){
                   if(data.Op==1){
                        alert('Error en el Tama\u00f1o de la imagen...');
                        message = $("<span class='error'>Error en el Tama\u00f1o de la imagen...</span>");
                        showMessage(message);
                        return false;
                   }else{
                        alert(data.msj);
                        message = $("<span class='error'>"+data.msj+"</span>");
                        showMessage(message);
                        return false;
                   } 
                }else{
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(data.type))
                    {
                        $(".showImage").html("<img src="+data.img+" width='300' />");
                    }
                }
                
                setTimeout(function(){
                    if(confirm('Desea adicionar otra bicicleta...?')){
                        cargarFormulario();
                    }else{
                        $('#SaveBici').css('display','none');
                    }
                },2000);
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    //
    
}//function SaveEstudiante
function cargarFormulario(){
    $('.Clear').val('');
    $('.ClearRadio').attr('checked',false);
    $(".showImage").html("<img src='../imagen/bicycle.png' />");
    $('.success').hide(1000,function(){});
}//function cargarFormulario 
//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg':  case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}
function ViewBiciletaAdmin(){
     var idUser = $('#idUser').val();
    $.ajax({//Ajax
          type: 'POST',
          url: '../Controller/Bicicletero_html.php',
          async: false,
          dataType: 'html',
          data:{ action_ID:'ViewBicicletas' ,idUser :idUser ,op:0},
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data){
                $('#ViewData').html(data);
          }//DATA
     });//AJAX
}//function ViewBicileta
function ViewBicileta(){
    var idUser = $('#idUser').val();
    $.ajax({//Ajax
          type: 'POST',
          url: '../Controller/Bicicletero_html.php',
          async: false,
          dataType: 'html',
          data:{ action_ID:'ViewBicicletas' ,idUser :idUser ,op:1},
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data){
                $('#ViewData').html(data);
          }//DATA
     });//AJAX
}//function ViewBicileta
function EditUpdateBicicleta(idd){
    $('#FormView'+idd+' #action_ID').val('Edit');
    $.ajax({//Ajax
          type: 'POST',
          url: '../Controller/Bicicletero_html.php',
          async: false,
          dataType: 'json',
          data:$('#FormView'+idd).serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data){ 
            if(data.val==false){
                alert(data.msj);
                return false;
            }else{
                message = $("<span class='success' style='text-align: center; width: 100%; font-size: 9px;'>Se a Modificado Correctamente.</span>");
                showMessage(message);
                $('#FormView'+idd +' .success').hide(5000,function(){});
            }
          }//DATA
       });//AJAX   
}//function EditUpdateBicicleta3
function DelectBicicleta(idd){
    if(confirm('Desea Eliminar el Registro...?')){
        $('#FormView'+idd+' #action_ID').val('DeleteBici');
        $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/Bicicletero_html.php',
              async: false,
              dataType: 'json',
              data:$('#FormView'+idd).serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){ 
                if(data.val==false){
                    alert(data.msj);
                    return false;
                }else{
                    message = $("<span class='error' style='text-align: center; width: 100%; font-size: 9px;'>Se a Eliminado Correctamente.</span>");
                    showMessage(message);
                    $('#FormView'+idd +' .error').hide(40000,function(){});
                    $('#FormView'+idd).css('visibility','collapse');
                }
              }//DATA
           });//AJAX   
       }
}//function DelectBicicleta
function VolverRetorno(id,op){
    if(op==1){
        var X = 0;
    }else{
        var X = 1;
    }
    
    $.ajax({//Ajax
          type: 'POST',
          url: '../Controller/Bicicletero_html.php',
          async: false,
          dataType: 'html',
          data:{ dato:id ,op:X},
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data){
                $('#ViewData').html(data);
          }//DATA
     });//AJAX
}//function VolverRetorno