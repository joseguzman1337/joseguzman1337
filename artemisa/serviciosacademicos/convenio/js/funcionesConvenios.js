$(document).ready(function() {
$('#modalidad').change(function (){
    var convenio = $('#idconvenio').val();
        var modalidad = $(this).val();
        if(modalidad == 0){
            alert('seleccione una modalidad antes de continuar');
        }else{
            cargar_facultad(modalidad,convenio);
            if(modalidad == 200){
                $('#facultad').removeAttr('disabled');
                $('#programa').attr('disabled', 'true');
                $('#Div_Facultad').removeAttr('style');
            }
            if(modalidad == 300){
                $('#Div_Facultad').css('display', 'none');
                $('#programa').removeAttr('disabled');
            }
        }
    });
$("#facultad").change(function (){
        var facultad_id;
        var documento_docente;
        var periodo;
        facultad_id = $(this).val();
        documento_docente = $('#NumDocumento').val();
        periodo = $('#Periodo').val();
		var modalidad = $('#modalidad').val();
                var convenio = $('#idconvenio').val();
    
        if(facultad_id == 0){
            alert('seleccione una facultad antes de continuar');
            $('#contenedores').fadeOut(1000);
            $('#programa').attr('disabled', 'disabled');
        }else{
            cargar_programa_academico(facultad_id, documento_docente, periodo, modalidad,convenio);
            $('#programa').removeAttr('disabled');
        }
    });
    
 $("#tipoconvenio").change(function (){
 	var cmbTipoConvenio = $(this).val();
 	if( cmbTipoConvenio == 2 || cmbTipoConvenio == 5){
 		//alert(cmbTipoConvenio);
 		$("#dvConvenio").css("display", "none");
 	}else{
 		$("#dvConvenio").css("display", "block");
 	}
 });
 
 /*$("#nuevacarrera").click(function (){
 var cmbTipoConvenio = $("#tipoconvenio").val();
	alert(cmbTipoConvenio);
	});*/
 
 var txtTipoConvenio = $("#txtTipoConvenio").val();
 if( txtTipoConvenio == 2 || txtTipoConvenio == 5){
 	$("#dvConvenio").css("display", "none");
 	$("#dvNuevaCarrera").css("display", "none");
 	$("#hrCarrera1").css("display", "none");
 	$("#hrCarrera2").css("display", "none");
 }else{
 	$("#dvConvenio").css("display", "block");
 	$("#dvNuevaCarrera").css("display", "block");
 	$("#hrCarrera1").css("display", "block");
 	$("#hrCarrera2").css("display", "block");
 }
 
 
 $('#fechafin').change(function (){
    var fecha = $('#fechafin').val();
    $.ajax({//Ajax    
         type: 'POST',
         url: 'convenios_ajax.php',
         async: false,
         dataType:'html',
         data:({actionID:'Calcularclausula',fecha:fecha}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
            //console.log(data);
              $('#fechaClausula').val(data);
        }//data
    });// AJAX
 
    });
});

/* CARGAR FACULTAD */
function cargar_facultad(modalidad,convenio){
    
    $.ajax({
        type: 'POST',
        url: 'acuerdos_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'carga_facultad',
            modalidad:modalidad,convenio:convenio
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
                if(data.modalidad == 200){
					$('#facultad').html(data.option);
				}else{
					$('#programa').html(data.option);
				}
            }
        }
    });
}
/* CARGAR PROGRAMA ACADEMICO */
function cargar_programa_academico(facultad_id, documento_docente, periodo_id, modalidad,convenio){
    $.ajax({
	       type: 'POST',
		   url: 'acuerdos_ajax.php',
           data:({actionID:'cargar_programa_academico_carreraconvenio',facultad_id:facultad_id, documento_docente:documento_docente, periodo_id:periodo_id, modalidad: modalidad,convenio:convenio}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success:function(data){
                $('#programa').html('');
                $('#programa').html(data);
	       }
    });
}

function validarDatos(from){
    var nombreconvenio = $('#nombreconvenio').val();
    if(nombreconvenio ===''){
        alert('Debe digitar el nombre del convenio');
        return false;
    }
    var data = validateForm(from);    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevoConvenio.php',
         async: false,
         dataType: 'json',
         data:$(from).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , El convenio que esta intentando ingresar ya se encuentra registrado.');},
         success: function(data){
              if(data.val===false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/MenuConvenios.php";
                   }
        }//data
       });// AJAX
    }    
}//function validarDatos

function validarDatosDetalle(form){
    var dato = validateForm(form);     
    if(dato==true){
        $.ajax({//Ajax
         type: 'POST',
         url: 'DetalleConvenio.php',
         async: false,
         dataType: 'json',
         data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/MenuConvenios.php";
                   }
        }//dato
       });// AJAX
    }    
}//function validarDatosDetalle

function validarDatosContraprestacion(form){
    var data = validateForm(form);
    var id = $('#idconvenio').val();    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevaContraprestacion.php',
         async: false,
         dataType: 'json',
       data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/DetalleConvenio.php?Detalle="+id;
                   }
        }//data
       });// AJAX
    }    
}//function validarDatosContraprestacion


function validarDatosDetallesContraprestacion(from){
    var dato = validateForm(from);
    var id = $('#idconvenio').val();      
    if(dato==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/DetallesContraprestacion.php',
         async: false,
         dataType: 'json',
         data:$(from).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                        location.href="../convenio/DetalleConvenio.php?Detalle="+id;
                   }
        }//dato
       });// AJAX
    }    
}//function validarDatosDetalle

function RegresarConvenio(){
    location.href="../convenio/MenuConvenios.php";
}

function RegresarContraprestacion(){
    var id = $('#idconvenio').val();
    location.href="../convenio/DetalleConvenio.php?Detalle="+id;
}

function RegresarCarrera(){
    var id = $('#idconvenio').val();
    location.href="../convenio/DetalleConvenio.php?Detalle="+id;
}

function validarDatosCarreraConvenio(form){
 var data = validateForm(form);
    var id = $('#idconvenio').val();
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevaCarreraConvenio.php',
         async: false,
         dataType: 'json',
       data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/DetalleConvenio.php?Detalle="+id;
                   }
        }//data
       });// AJAX
    }       
}

function validarDatosDetallesCarreraConvenio(form){
 var data = validateForm(form);
    var id = $('#idconvenio').val();    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/DetallesCarrera.php',
         async: false,
         dataType: 'json',
       data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{   
                       alert(data.descrip);
                       location.href="../convenio/DetalleConvenio.php?Detalle="+id;
                   }
        }//data
       });// AJAX
    }       
}

function RegresarCarreraConvenio(){
    var id = $('#idconvenio').val();
    location.href="../convenio/DetalleConvenio.php?Detalle="+id;
}

function RegresarAnexo(){
    var id = $('#idconvenio').val();
    location.href="../convenio/DetalleConvenio.php?Detalle="+id;
}


function CarrerasModalidad()
{
    var Modalidad = $('#Modalidad').val();
    var id = $('#idconvenio').val(); 
	var idtipoconvenio = $('#idtipoconvenio').val();
    $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevoAnexoConvenio.php',
         async: false,
         dataType:'html',
         data:({Action_id:'Carreras',Modalidad:Modalidad, id:id, idtipoconvenio:idtipoconvenio}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Td_Carreras').html(data);
        }//data
    });// AJAX
    
}


function validarDetalleAnexo(form){
 var data = validateForm(form);
    var id = $('#idconvenio').val();    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/DetalleAnexoConvenio.php',
         async: false,
         dataType: 'json',
       data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/DetalleConvenio.php?Detalle="+id;
                   }
        }//data
       });// AJAX
    }       
}

function BuscarModalidadCarrera(){
	var modalidad =  $('#modalidad').val();	
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/ReportesConveniosRotaciones.php',
         async: false,
         dataType:'html',
         data:({Action_id:'modalidad',modalidad:modalidad}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Td_Carrera').html(data);
        }//data
    });// AJAX
}

function BuscarCarreraMateria(){
    var carrera =  $('#carrera').val();
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/ReportesConveniosRotaciones.php',
         async: false,
         dataType:'html',
         data:({Action_id:'carrera',carrera:carrera}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Td_Materia').html(data);
        }//data
    });// AJAX
}



function validaarchivo(form){ 
    $.ajax({
        url: 'convenios_ajax.php',  
        type: 'POST',
        data:$(form).serialize(),
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            alert('Subiendo la archivo, por favor espere...');        
        },
        //una vez finalizado correctamente
        success: function(data){
            alert('Los datos fueron agregados correctamente.');
             location.href="../convenio/MenuConvenios.php";
        },
        //si ha ocurrido un error
        error: function(){               
             alert('Se encontraron errores en los datos, por favor verificar la información.');
        }
    });
}
function Clausula(){
    var fecha = $('#fechafin').val();
    
    $.ajax({//Ajax
         type: 'POST',
         url: 'convenios_ajax.php',
         async: false,
         dataType:'html',
         data:({actionID:'Calcularclausula',fecha:fecha}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
           // console.log(data);
              $('#fechaClausula').val(data);
        }//data
    });// AJAX
}//function Clausula 

function GuardarObservaciones(op='')
{
     var rol = $("#rol").val();
        var Solicitudid = $("#id").val();
        var usuario = $("#usuario").val();
        
        if(op==1){
            var textarea = $("#observaciones_2").val();
            var procesoConvenio = 1;
            if(textarea=='')
            {
              alert("Debe incluir una observacion para Enviar Validacion Juridica.");  
              return false;
            } 
        }else{
   
    var textarea = $("#observaciones").val();
    var procesoConvenio = 0;
    
    if(textarea=='')
    {
      alert("Debe incluir una observacion para Enviar Oficina de Desarrollo.");  
              return false;
            } 
        }
        
        console.log(procesoConvenio);
 
        $.ajax({//Ajax
        type: 'POST',
        url: '../convenio/observaciones_ajax.php',
        async: false,
        dataType: 'json',
        data:({Action_id:'Observaciones',textarea:textarea, id:Solicitudid, usuario:usuario, rol:rol,procesoConvenio:procesoConvenio}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
              if(data==false){
                       alert("La observacion no se pudo guardar.");                      
                   }else{
                       alert("La observacion se guardo correctamente.");
                       location.href="../convenio/ConveniosEnTramite.php";
                   }
            }//data
         });// AJAX
    
}
 
function ValidarInstitucion()
{
    var tipoinstitucion = $("#tipoinstitucion").val();
    var ciudad = $("#ciudadid").val(); 
    var nombreinstitucion = $("#nombreinstitucion").val();
    
    $.ajax({//Ajax
        type: 'POST',
        url: 'observaciones_ajax.php',
        async: false,
        dataType: 'html',
        data:({Action_id:'Instituciones',tipoinstitucion:tipoinstitucion, ciudad:ciudad, nombreinstitucion:nombreinstitucion}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Tr_Instituciones').html(data);
        }//data
    });// AJAX      
}

function RegresarDetalles()
{
    var id = $("#id").val();
    location.href="VistaPropuesta.php?id="+id;
}
 
function ValidarNuevaInstitucion(from)
{   
    $.ajax({//Ajax
     type: 'POST',
     url: 'observaciones_ajax.php',
     async: false,
     dataType: 'json',
     data:$(from).serialize(),
     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , El convenio que esta intentando ingresar ya se encuentra registrado.');},
     success: function(data){        
          if(data.val===false){
             alert("Error al ingresar la institucion");
           }else{
               alert("La institución se reguistro correctamente. ");
               location.href="../convenio/ConveniosEnTramite.php";
           }
           if(data.val===null)
           {
            alert("La institución se reguistro correctamente. ");
            location.href="../convenio/ConveniosEnTramite.php";
           }
    }//data
   });// AJAX     
}

function GuradarProcesoDesarrollo()
{
    var id = $("#id").val();
    var usuario = $("#usuario").val();    
        $.ajax({//Ajax
        type: 'POST',
        url: '../convenio/observaciones_ajax.php',
        async: false,
        dataType: 'json',
        data:({Action_id:'PasoSecretaria', id:id, usuario:usuario}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){            
              if(data==true){
                   alert("El proceso se realizo correctamente.");
                   location.href="../convenio/ConveniosEnTramite.php";                     
                   }else{
                    alert("El paso Juridico no se pudo guardar.");
                   }
        }//data
        });// AJAX    
}
 
function CargarArchivo(fomr)
{
    var formData = new FormData($(fomr)[0]);
    var message = ""; 
        //hacemos la petición ajax  
        $.ajax({
            url: 'observaciones_ajax.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            dataType: 'json',
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //una vez finalizado correctamente
            success: function(data){
                if(data.val==false){
                    alert(data.mesj);     
                }else{
                    alert("El archivo ha subido correctamente.");
                }                
            },
            //si ha ocurrido un error
            error: function(){
               alert("Ha ocurrido un error.");                
            }
        });
}

function PasoSecretariaGeneral()
{
    var id = $("#id").val();
    var usuario = $("#usuario").val();
        $.ajax({//Ajax
        type: 'POST',
        url: '../convenio/observaciones_ajax.php',
        async: false,
        dataType: 'json',
        data:({Action_id:'PasoJuridico', id:id, usuario:usuario}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){            
              if(data==true){
                   alert("El proceso se realizo correctamente.");
                   location.href="../convenio/ConveniosEnTramite.php";                     
                   }else{
                    alert("El paso Juridico no se pudo guardar.");
                   }
        }//data
        });// AJAX
} 

function PasoFirmasFinales()
{
    var id = $("#id").val();
    var usuario = $("#usuario").val();
        $.ajax({//Ajax
        type: 'POST',
        url: '../convenio/observaciones_ajax.php',
        async: false,
        dataType: 'json',
        data:({Action_id:'PasoFirmasProceso', id:id, usuario:usuario}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){            
              if(data.val==true){
                   alert("El proceso se realizo correctamente.");
                   location.href="../convenio/ConveniosEnTramite.php";                     
                   }else{
                    alert("El paso Firmas Finales no se pudo guardar.");
                    return false;
                   }
            }//data
        });// AJAX
}//PasoFirmasFinales 
 
function contraparte()
{
    var texto = 'Desea Actualizar el Proceso de Solicitud.';
    if(confirm(texto)){
        var id = $("#id").val();
        var usuario = $("#usuario").val();
            $.ajax({//Ajax
            type: 'POST',
            url: '../convenio/observaciones_ajax.php',
            async: false,
            dataType: 'json',
            data:({Action_id:'contraparte', id:id, usuario:usuario}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){            
                  if(data==true){
                       alert("El proceso se realizo correctamente.");
                       location.href="../convenio/ConveniosEnTramite.php";                     
                       }else{
                        alert("No se pudo guardar el paso de la contraparte.");
                       }
            }//data
        });// AJAX
    } 
}    
function CambioProceso(id){
    if($('#EnvioContraparte').is(':checked')){
        var texto = 'Desea Cambiar el Estado del Proceso de la Solicitud a \n Revision por la Contraparte.';
        var valor = 11;
    }else{
        var texto = 'Desea Cambiar el Estado del Proceso de la Solicitud a \n En Oficina de Desarrollo.';
        var valor = 2;
    }
    
    if(confirm(texto)){
        var usuario = $("#usuario").val();
         $.ajax({//Ajax
            type: 'POST',
            url: '../convenio/observaciones_ajax.php',
            async: false,
            dataType: 'json',
            data:({Action_id:'CambioProcesoContraParte', id:id, usuario:usuario,valor:valor}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){            
                  if(data.val==true){
                       alert("El proceso se realizo correctamente.");
                       location.href="../convenio/ConveniosEnTramite.php"; 
                  }else{
                       alert("No se pudo Realizar el Cambio.");
                       return false;
                  }
            }//data            
       });//AJAX
    }
}//function CambioProceso