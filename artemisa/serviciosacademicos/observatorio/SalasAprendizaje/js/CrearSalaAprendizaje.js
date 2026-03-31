function AddTr(){
    /*********************************************************/
    	var TblMain    =  document.getElementById("TableSessiones");
    	var NumFiles   =  parseFloat($('#numIndices').val()) + 1;
        if(NumFiles<=9){
            var NewTr      =  document.createElement("tr");
        	NewTr.id       =  'trNewSession'+NumFiles;
        	
        	TblMain.appendChild(NewTr);
            
            $('#numIndices').val(NumFiles);  
            
            $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/CrearSalaAprendizaje_html.php',
              async: false,
              dataType: 'html',
              data:({action_ID: 'AddTr',NumFiles:NumFiles}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#trNewSession'+NumFiles).css('background','#E5E4FF')//style="background: #E5E4FF;"
                    $('#trNewSession'+NumFiles).html(data);
            	}//data 
            }); //AJAX
        }
    /*********************************************************/
}//function AddTr
function DeleteTr(){
    /***********************************************************/
    var NumFiles   =  parseFloat($('#numIndices').val());
    
    if(NumFiles>0){
    
        $('#trNewSession'+NumFiles).remove();
        
        $('#numIndices').val(NumFiles-1);
        
    }
    /***********************************************************/
}//function DeleteTr
function SaveInfo(){
            
       nicEditors.findEditor('area1').saveContent();//Justificacion
       nicEditors.findEditor('area2').saveContent();//Objetivos 
       nicEditors.findEditor('area3').saveContent();//Evaluación
       nicEditors.findEditor('area4').saveContent();//Bibliografia
       
       
       var area1 = nicEditors.findEditor('area1').getContent();
       var area2 = nicEditors.findEditor('area2').getContent();
       var area3 = nicEditors.findEditor('area3').getContent();
       var area4 = nicEditors.findEditor('area4').getContent();
       
       if(!$.trim($('#NombreSala').val())){
         alert('Por favor el Nombre de la Sala de Aprendizaje');
         $('#NombreSala').effect("pulsate", {times:3}, 500);
         $('#NombreSala').css('border-color','#F00');
         return false;
       }
       
       if($('#Periodo').val()=='-1' || $('#Periodo').val()==-1){
         alert('Por favor selecionar el Periodo');
         $('#Periodo').effect("pulsate", {times:3}, 500);
         $('#Periodo').css('border-color','#F00');
         return false;
       }
       
       if(!$.trim($('#Encargado_id').val())){
         alert('Por favor Diligenciar el Departamento Encargado');
         $('#Encargado').effect("pulsate", {times:3}, 500);
         $('#Encargado').css('border-color','#F00');
         return false;  
       }
       
       if($('#CompetenciasInicial').val()=='-1' || $('#CompetenciasInicial').val()==-1){
         alert('Por favor selecionar la Competencia');
         $('#CompetenciasInicial').effect("pulsate", {times:3}, 500);
         $('#CompetenciasInicial').css('border-color','#F00');
         return false;
       } 
       
       if(!$.trim($(area1).text())){
         alert('Por favor ingresar la Jutificacion');
         return false;
       }
       
       if(!$.trim($(area2).text())){
         alert('Por favor ingresar los Objetivos de Aprendizaje');
         return false;
       }
       
       /********************************************************/
       var numIndices = $('#numIndices').val();
       
       for(i=0;i<=numIndices;i++){
          var a = $('#Competencia_'+i).val();
          var b = $('#Contenido_'+i).val();
          var c = $('#Actividad_'+i).val();
          
          if(!$.trim(a) || !$.trim(b) || !$.trim(c)){
            if(!$.trim(a)){
                $('#Competencia_'+i).effect("pulsate", {times:3}, 500);
                $('#Competencia_'+i).css('border-color','#F00');
            }
            if(!$.trim(b)){
                $('#Contenido_'+i).effect("pulsate", {times:3}, 500);
                $('#Contenido_'+i).css('border-color','#F00');
            }
            if(!$.trim(c)){
                $('#Actividad_'+i).effect("pulsate", {times:3}, 500);
                $('#Actividad_'+i).css('border-color','#F00');
            }
             alert('Por favor Diligenciar Todos los Campos de la Sesion');              
             return false;
          }
       }//for
       /********************************************************/
       
       if(!$.trim($(area3).text())){
         alert('Por favor ingresar la Evaluacion');
         return false;
       }
       
       if(!$.trim($(area4).text())){
         alert('Por favor ingresar la Bibliografia');
         return false;
       }
      
      /**************************************************************/ 
      $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/CrearSalaAprendizaje_html.php',
              async: false,
              dataType: 'json',
              data:$('#Example').serialize(),
              //data:({Texto:text,Texto_2:Texto_2}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  if(data.val==false){
                     alert(data.descrip);
                     return false;
                  }else{
                     alert(data.descrip);
                     Listado();
                  }
              }//AJAX
       });
}//function SaveInfo
function VerData(){
      // nicEditors.findEditor('area1').saveContent();
            
       $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/CrearSalaAprendizaje_html.php',
              async: false,
              dataType: 'json',
              //data:$('#Example').serialize(),
              data:({action_ID:'Buscar'}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                //$('#Div_Ver').html(data.texto);
                nicEditors.findEditor('area2').setContent(data.texto);
              }//AJAX
       });
}//function VerData
function AutoCompletarResponsable(){
    $('#Encargado').autocomplete({					
        source: "../Controller/CrearSalaAprendizaje_html.php?action_ID=AutoPrograma",
        minLength: 2,
        select: function( event, ui ) {
                $('#Encargado_id').val(ui.item.id);
                
        }                
    });
}//function AutoCompletarResponsable
function FormatBoxAuto(){
   $('#Encargado').val('');
   $('#Encargado_id').val(''); 
}//function FormatBoxAuto
function LimpiarFormulario(){
    $('#NombreSala').val('');
    $('#Periodo').val('-1');
    $('#Encargado').val('');
    $('#Encargado_id').val('');
    nicEditors.findEditor('area1').setContent('');
    nicEditors.findEditor('area2').setContent('');
    nicEditors.findEditor('area3').setContent('');
    nicEditors.findEditor('area4').setContent('');
    var numIndices = $('#numIndices').val();
    for(i=0;i<=numIndices;i++){
          $('#Competencia_'+i).val('');
          $('#Contenido_'+i).val('');
          $('#Actividad_'+i).val('');
    }//for
}//function LimpiarFormulario
function Listado(Op=''){
    $('#container').html('');
     $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/ListadoSalaAprendizaje_html.php',
              async: false,
              dataType: 'html',
              //data:$('#Example').serialize(),
              data:({action_ID:'',Op:Op}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#container').html(data);
              }//AJAX
       });
}//function Listado
function VerSalaAprendizaje(id){
     $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/ListadoSalaAprendizaje_html.php',
              async: false,
              dataType: 'html',
              //data:$('#Example').serialize(),
              data:({action_ID:'Ver',id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#container').html(data);
                  VerSalaAprendiasajJson(id);
              }//AJAX
     });
}//function VerSalaAprendizaje
function VerSalaAprendiasajJson(id){
    $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/ListadoSalaAprendizaje_html.php',
              async: false,
              dataType: 'json',
              //data:$('#Example').serialize(),
              data:({action_ID:'VerJson',id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#Justificacion').html(data.Justificacion);
                  $('#Objetivos').html(data.Objetivos);
                  $('#Evaluacion').html(data.Evaluacion);
                  $('#Bibliografia').html(data.Bibliografia);
              }//AJAX
     });
}//function VerSalaAprendiasajJson
function EliminarSalaAprendizaje(id){
    if(confirm('\u00bf Est\u00e1 seguro de eliminar esta sala de aprendizaje?')){
        $.ajax({//Ajax
                  type: 'POST',
                  url: '../Controller/ListadoSalaAprendizaje_html.php',
                  async: false,
                  dataType: 'json',
                  //data:$('#Example').serialize(),
                  data:({action_ID:'EliminarSalaAprendizaje',id:id}),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                  success: function(data){
                      if(data.val==false){
                         alert(data.descrip);
                         return false;
                      }else{
                         alert(data.descrip);
                         Listado();
                      }
                  }//DAta
         });//AJAX
    }
}//function EliminarSalaAprendizaje
function EditarSalaAprendizaje(id){
    location.href='../Controller/ListadoSalaAprendizaje_html.php?action_ID=Editar&id='+id;
}//function EditarSalaAprendizaje
function VerEditarJson(id){
    $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/ListadoSalaAprendizaje_html.php',
              async: false,
              dataType: 'json',
              //data:$('#Example').serialize(),
              data:({action_ID:'VerJson',id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  nicEditors.findEditor('area1').setContent(data.Justificacion);//$('#Justificacion').html(data.Justificacion);
                  nicEditors.findEditor('area2').setContent(data.Objetivos);//$('#Objetivos').html(data.Objetivos);
                  nicEditors.findEditor('area3').setContent(data.Evaluacion);//$('#Evaluacion').html(data.Evaluacion);
                  nicEditors.findEditor('area4').setContent(data.Bibliografia);//$('#Bibliografia').html(data.Bibliografia);
              }//AJAX
     });
}//function VerSalaAprendiasajJson
function Modificar(){
       nicEditors.findEditor('area1').saveContent();//Justificacion
       nicEditors.findEditor('area2').saveContent();//Objetivos 
       nicEditors.findEditor('area3').saveContent();//Evaluación
       nicEditors.findEditor('area4').saveContent();//Bibliografia
       
       
       var area1 = nicEditors.findEditor('area1').getContent();
       var area2 = nicEditors.findEditor('area2').getContent();
       var area3 = nicEditors.findEditor('area3').getContent();
       var area4 = nicEditors.findEditor('area4').getContent();
       
       if(!$.trim($('#Update #NombreSala').val())){
         alert('Por favor el Nombre de la Sala de Aprendizaje');
         $('#NombreSala').effect("pulsate", {times:3}, 500);
         $('#NombreSala').css('border-color','#F00');
         return false;
       }
       
       if(!$.trim($('#Update #Encargado_id').val())){
         alert('Por favor Diligenciar el Departamento Encargado');
         $('#Encargado').effect("pulsate", {times:3}, 500);
         $('#Encargado').css('border-color','#F00');
         return false;  
       }
       
       if(!$.trim($(area1).text())){
         alert('Por favor ingresar la Jutificacion');
         return false;
       }
       
       if(!$.trim($(area2).text())){
         alert('Por favor ingresar los Objetivos de Aprendizaje');
         return false;
       }
       
       /********************************************************/
       var numIndices = $('#Update #numIndices').val();
      
       for(i=0;i<=numIndices;i++){
          var a = $('#Update #Competencia_'+i).val();
          var b = $('#Update #Contenido_'+i).val();
          var c = $('#Update #Actividad_'+i).val();
         
          if(!$.trim(a) || !$.trim(b) || !$.trim(c)){
            if(!$.trim(a)){
                $('#Update  #Competencia_'+i).effect("pulsate", {times:3}, 500);
                $('#Update #Competencia_'+i).css('border-color','#F00');
            }
            if(!$.trim(b)){
                $('#Update #Contenido_'+i).effect("pulsate", {times:3}, 500);
                $('#Update #Contenido_'+i).css('border-color','#F00');
            }
            if(!$.trim(c)){
                $('#Update #Actividad_'+i).effect("pulsate", {times:3}, 500);
                $('#Update #Actividad_'+i).css('border-color','#F00');
            }
             alert('Por favor Diligenciar Todos los Campos de la Sesion');              
             return false;
          }
       }//for
       /********************************************************/
       
       if(!$.trim($(area3).text())){
         alert('Por favor ingresar la Evaluacion');
         return false;
       }
       
       if(!$.trim($(area4).text())){
         alert('Por favor ingresar la Bibliografia');
         return false;
       }
      
      /**************************************************************/ 
      $.ajax({//Ajax
              type: 'POST',
              url: '../Controller/ListadoSalaAprendizaje_html.php',
              async: false,
              dataType: 'json',
              data:$('#Update').serialize(),
              //data:({Texto:text,Texto_2:Texto_2}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  if(data.val==false){
                     alert(data.descrip);
                     return false;
                  }else{
                     alert(data.descrip);
                     Listado();
                  }
              }//AJAX
       });
}//function Modificar
function Regresar(Op=''){
     Listado(Op);
}//function Regresar
function CrearSala(){
    /*$.ajax({//Ajax
              type: 'POST',
              url: '../Controller/CrearSalaAprendizaje_html.php',
              async: false,
              dataType: 'html',
              //data:$('#Update').serialize(),
              //data:({Texto:text,Texto_2:Texto_2}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#container').html(data);
              }//AJAX
       });*/
    location.href='../Controller/CrearSalaAprendizaje_html.php?Op=1';   
}//function CrearSala;