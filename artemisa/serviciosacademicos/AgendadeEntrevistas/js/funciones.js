/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Ajuste de formulario y creacion de horarios de Entrevistas para los programas de Postgrados y Educacion Virtual.
 * @since Abril 17, 2018.
*/ 

jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z\s ñáéíóú]+$/i.test(value);
}, "Solo letras");

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
function limpiar() {
 setTimeout('document.formulario.reset()',1000);
 setTimeout('document.formularioAulas.reset()',1000);
 setTimeout('document.formularioResponsable.reset()',1000);
 setTimeout('document.formularioCreaEntrevistas.reset()',1000);
 return false;
} //End function limpiar

function guardar() {
  var carrera = $('#programa_academico').val();        
  var aula = $('#aula').val();        
  var responsable = $('#responsable').val();        
  var cupo = $('#cupo').val();        
  
     $('#formulario').validate({
            rules:{
            modalidad_academica:{required:true},    
            programa_academico:{ required:true },
            aula:{ required:true },
            responsable:{required:true},    
            cupo:{ required:true,number: true, min: 1}  
            },
            messages:{
            modalidad_academica:{required:"Debe seleccionar una modalidad academica"},
            programa_academico:{required:"Debe seleccionar un programa academico"},
            aula:{required:"Debe seleccionar el Aula"},
            responsable:{required:"Debe seleccionar el Responsable"},
            cupo:{required:"Debe seleccionar el Cupo", number:"Solo se permiten numeros", min:"Por favor, escribe un valor mayor a 0"}
            }
            }); 
        if($('#formulario').valid()){  
         
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {carrera:carrera, aula:aula, responsable:responsable, cupo:cupo, action: "Guardar"},
            beforeSend: function () {
    
            },
            success: function (data) {
               
                if( data == 0 ){
                        bootbox.alert("El aula ya se encuentra reservada para esta carrera...");
                } else{
                        bootbox.alert("Los datos se insertaron Correctamente...");
                }
                //window.onload = limpiar();  
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }
    
}//funtion guardar


    function modalidad()
    {
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "Modalidad"},
            success: function (data) {
                $('#modalidad_academica').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion modalidad

function carrera()
{
    var moda = $('#modalidad_academica').val();    
    
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {moda:moda, action: "Carrera"},
            success: function (data) {
                $('#Program').attr("style", "display:inline");
                $('#programa_academico').html(data);
            },
            error: function (data, error)
            {
              alert("Error en la consulta de los datos.");
            }
        });
}//funtion carrera   

function aula(){
        
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "Aula"},
            success: function (data) {
                $('#aula').html(data);
            },
            error: function (data, error)
            {
              alert("Error en la consulta de los datos.");
            }
        });
}//End funtion aula

function responsable(){
       
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "Responsable"},
            success: function (data) {
                $('#responsable').html(data);
            },
            error: function (data, error)
            {
              alert("Error en la consulta de los datos.");
            }
        });
}//End funtion responsable



function consultar() {
        var modal = $('#modalidad_academica').val();
        var carrera = $('#programa_academico').val();    
        var aula = $('#aula').val();
            
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {modal:modal, carrera:carrera, aula:aula, action: "Consultar"},
            beforeSend: function () {
                $('#procesando').attr("style", "display:inline");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#dataReporte').html(data);
                $('#tabla').attr("style", "display:inline");
                $('#formCrearEntrevistas').attr("style", "display:none");
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
}//End funtion consultar    

function consultarEntrevistas(id) {
    var codCarrreraSalon = id;
    //alert (codCarrreraSalon);
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html", 
            data: {action: "ConsultaEntrevistas",idCarrreraSalonE:codCarrreraSalon},
            beforeSend: function () {
              $('#procesando').attr("style", "display:block");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#tabla').attr("style", "display:none");
                $('#formulario').attr("style", "display:none");
                $('#dataReporteE').html(data);
                $('#tablaEntrevistas').attr("style", "display:block");
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
            
        });
}//End funtion consultar

function SoloConsultarEntrevistas(valor){
    alert ("En Contrucción...");

}

function creaEntrevista(valor){ 
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {codCarreraSalon:valor, action: "CrearEntrevistas"},
            success: function (data) {
             $('#procesando').attr("style", "display:none");
             $('#tabla').attr("style", "display:none");
             $('#formulario').attr("style", "display:none");
             $('#dataReporteE').html(data);
             $('#tablaEntrevistas').attr("style", "display:none");
             $('#formulario1').attr("style", "display:none");
             $('#formCrearEntrevistas').attr("style", "display:block");  
             consultarEntrevistas(valor);
            $('#codcarrreraSalon').val(valor);
            },
            error: function (data, error)
            {
              alert("Error en la consulta de los datos.");
            }
        });   
    
}//End guardarEntrevista

function guardarEntrevistas() {
    var codcarrreraSalon = $('#codcarrreraSalon').val();
    var fechaEntrevista = $('#fechaE').val();        
    var horaInicio = $('#fechainicialcorte').val();        
    var horaFin = $('#horaF').val();
    
     $('#formularioCreaEntrevistas').validate({
            rules:{
            fechaE:{ required:true },
            fechainicialcorte:{ required:true},
            horaF:{required:true}
            },
            messages:{
            fechaE:{required:"Debe seleccionar una fecha para la Entrevista"},
            fechainicialcorte:{required:"Debe seleccionar una hora de Inicio para la Entrevistas"},
            horaF:{required:"Debe seleccionar una hora Final para la Entrevistas"}
            }
       }); 
       if($('#formularioCreaEntrevistas').valid()){  
       $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html", 
            data: {action: "guardarEntrevista", codcarrreraSalon:codcarrreraSalon, fechaEntrevista:fechaEntrevista, horaInicio:horaInicio, horaFin:horaFin },
            beforeSend: function () {
      
            },
            success: function (data) {
              if( data == 0 ){
                     bootbox.alert("El Horario ya se encuentra reservada para esta carrera...");
                } else
                if(data == 2){
                    bootbox.alert("La hora Final debe ser Mayor que la hora Inicial...");
                }else{
                     bootbox.alert("Los datos se insertaron Correctamente...");
                     window.onload = limpiar();
                }
                window.onload = consultarEntrevistas(codcarrreraSalon);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
            
        });
    }
}//End funtion Crear Entrevistas



function actualizarEntrevista(valor, valor2){
    var identrevista = valor;
    var idcarrreraSalon = valor2;
      
        
    $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "ConsultarEntrevistas", identrevista: identrevista },
            beforeSend: function () {
            },
            success: function (data) {
                bootbox.dialog({
                    title : "Edición Horario Entrevistas",
                    message : data,
                    size: "large",
                    buttons : {
                        success : {
                        label : 'Modificar',
                        className: 'btn-success Guardar',
                        callback : function( ){                 
                        fecha_entrevista = $("#fecha_entrevistaM").val();
                        hora_inicio = $("#hora_inicialM").val();    
                        hora_final = $("#hora_finalM").val();    
                                        
                            $.ajax({
                                type: 'POST',
                                url: 'funciones/funcionAsignarCupoAula.php',
                                dataType: "html",    
                                data: {fecha_entrevista:fecha_entrevista, hora_inicio:hora_inicio, hora_final: hora_final, identrevista:identrevista, idcarrreraSalon:idcarrreraSalon, action: "ModificarEntrevistas"},    
                                beforeSend: function(){
                                },
                                success: function (data){
                                 if( data == 0 ){
                                    bootbox.alert("Este horario ya se encuentra reservada para esta carrera...");
                                 }else
                                 if(data == 2){
                                     bootbox.alert("La hora Final debe ser Mayor que la hora Inicial...");
                                 }else{
                                    bootbox.alert("Los datos se modificaron Correctamente...");
                                }
                                 window.onload = consultarEntrevistas(idcarrreraSalon);      
                                      
                                }
                                });
                            } 
                            
                         },
                        cancel: {
                            label: "Cancelar",
                            className: 'btn-danger',
                            callback: function( ){
                            }
                        }
                    }
                });    
            },
            error: function (data, error){
                alert("Error en la consulta de los datos.");
            }
        });
}

function emergenteActualizar( id ){
        var idCarreraSalon = id;
                  
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "ConsultarEditar", idCarreraSalon: idCarreraSalon },
            beforeSend: function () {
            },
            success: function (data) {
                bootbox.dialog({
                    title : "Edición Aula y Cupo",
                    message : data,
                    size: "large",
                    buttons : {
                        success : {
                        label : 'Modificar',
                        className: 'btn-success Guardar',
                        callback : function( ){                 
                        programa_academico = $("#programa_academicoM").val();
                        aula = $("#aulaM").val();    
                        responsable = $("#responsableM").val();    
                        cupo = $("#cupoM").val();    
            
            $('#formActualizar').validate({
            rules:{
            cupoM:{ required:true,number: true, min: 1}  
            },
            messages:{
            cupoM:{required:"Debe seleccionar el Cupo", number:"Solo se permiten números", min:"Por favor, escribe un valor mayor a 0"}
            }
            }); 
            
                            
        if($('#formActualizar').valid()){  
            
                            $.ajax({
                                type: 'POST',
                                url: 'funciones/funcionAsignarCupoAula.php',
                                dataType: "html",    
                                data: {carreraM:programa_academico, aulaM:aula, idCarreraSalon: idCarreraSalon, responsable:responsable, cupoM:cupo, action: "Modificar"},    
                                beforeSend: function(){
                                },
                                success: function (data){
                                 if( data == 0 ){
                                    bootbox.alert("El aula ya se encuentra reservada para esta carrera...");
                                 } else{
                                    bootbox.alert("Los datos se modificaron Correctamente...");
                                    window.onload = consultar();  
                                    }    
                                      
                                }
                                });
        } else {return false}
                            } 
                            
                         },
                        cancel: {
                            label: "Cancelar",
                            className: 'btn-danger',
                            callback: function( ){
                            }
                        }
                    }
                });    
            },
            error: function (data, error){
                alert("Error en la consulta de los datos.");
            }
        });
}//End function emergenteActualizar

function eliminar(id){
   var idCarreraSalon = id; 
    
   bootbox.confirm("Esta seguro de Eliminar el Registro?", function (result) {
            
            if (result){
                $.ajax({
                type: 'POST',
                url: 'funciones/funcionAsignarCupoAula.php',
                dataType: "html",
                data: {idCarreraSalon: idCarreraSalon, action: "Eliminar"},
                success: function (data) {
                bootbox.alert ("El registro se Eliminó Correctamente...");  
                window.onload = consultar();    
                },
                error: function (data, error)
                {
                  alert("Error en la consulta de los datos.");
                }
                });
            } else {
              console.log("El usuario canceló la Eliminación");
              }
        });
}//End function eliminar

function noEliminar(id){
   var idCarreraSalon = id; 
  
  bootbox.alert ("No se Puede eliminar porque tiene horarios definidos.")    ;

}//End function eliminar

function eliminarEntrevista(id, valor){
   var idEntrevista = id; 
   var carreraSalonId = valor;
    
  bootbox.confirm("Esta seguro de Eliminar el Registro?", function (result) {
            
            if (result){
                $.ajax({
                type: 'POST',
                url: 'funciones/funcionAsignarCupoAula.php',
                dataType: "html",
                data: {idEntrevista: idEntrevista, action: "EliminarEntrevista"},
                success: function (data) {
                if( data == 1 ){
                  bootbox.alert ("El registro se Eliminó Correctamente...");      
                }    
                window.onload = consultarEntrevistas(carreraSalonId);  //esta enviando es entrevistaId  
                },
                error: function (data, error)
                {
                  alert("Error en la consulta de los datos.");
                }
                });
            } else {
              console.log("El usuario canceló la Eliminación");
              }
        });
}//End function eliminarEntrevista

function consultarSalon() {
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "ConsultarSalon"},
            beforeSend: function () {
                $('#procesando').attr("style", "display:inline");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#dataReporteS').html(data);
                $('#tablaSalon').attr("style", "display:inline");
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
}//End funtion consultar Salones.

function consultarResponsables() {
        var nombres = $('#nombreresponsable').val();    
        var apellidos = $('#apellidoresponsable').val();
        var correo = $('#correoresponsable').val();
        
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {nombres:nombres, apellidos:apellidos, correo:correo, action: "ConsultarResponsables"},
            beforeSend: function () {
                $('#procesando').attr("style", "display:inline");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#dataConsultaR').html(data);
                $('#tablaResponsable').attr("style", "display:inline");
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
}//End funtion consultarResponsables

function guardarSalon(){
    var NombreSalon = $('#salon').val(); 
        $('#formularioAulas').validate({
        rules:{
        salon:{ required:true, minlength: 6}
        },
        messages:{
        salon:{required:"Debe digitar el nombre del Salon", minlength:"Debe digitar minimo 6 Caracteres"}
        }
        });
    if($('#formularioAulas').valid()){   
            $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {salon:NombreSalon, action: "GuardarSalon"},
            beforeSend: function () {
    
            },
            success: function (data) {
               
                if( data == 0 ){
                        bootbox.alert("Error al insertar...");
                } else{
                        bootbox.alert("Los datos se insertaron Correctamente...");
                }
                window.onload = limpiar();  
                window.onload = consultarSalon();
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }
}//End guardarSalon

function guardarResponsable(){
  var Nombres = $('#nombreresponsable').val(); 
  var Apellidos = $('#apellidoresponsable').val(); 
  var Correo = $('#correoresponsable').val(); 
  var Correo1 = $('#correoalterno1').val(); 
  var Correo2 = $('#correoalterno2').val(); 
  
    $('#formularioResponsable').validate({
        rules:{
        nombreresponsable:{ required:true, lettersonly: true, minlength: 3},
        apellidoresponsable:{ required:true, lettersonly: true, minlength: 3},
        correoresponsable:{ required:true, email: true},
        correoalterno1:{email: true},
        correoalterno2:{email: true}
        },
        messages:{
        nombreresponsable:{required:"Debe digitar un Nombre", lettersonly:"Debe contener solo letras", minlength:"El Nombre debe contener mas de 3 Letras"},
        apellidoresponsable:{required:"Debe digitar un Apellido", lettersonly:"Debe contener solo letras", minlength:"El Apellido debe contener mas de 3 Letras"},
        correoresponsable:{required:"Debe digitar el correo", email:"Digite un correo valido"},
        correoalterno1:{email:"Digite un correo valido"},
        correoalterno2:{email:"Digite un correo valido"}    
        }
        });
    if($('#formularioResponsable').valid()){    
            $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {Nombres:Nombres, Apellidos:Apellidos, Correo:Correo, Correo1:Correo1, Correo2:Correo2, action: "GuardarResponsable"},
            beforeSend: function () {
    
            },
            success: function (data) {
               
                if( data == 0 ){
                        bootbox.alert("Error al insertar...");
                } else{
                        bootbox.alert("Los datos se insertaron Correctamente...");
                }
                window.onload = limpiar();  
               },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }
}//End guardarSalon

function eliminarSalon(id){
   var IdSalon = id; 
        
   bootbox.confirm("Esta seguro de Eliminar el Salon?", function (result) {
            
            if (result){
                $.ajax({
                type: 'POST',
                url: 'funciones/funcionAsignarCupoAula.php',
                dataType: "html",
                data: {idSalon: IdSalon, action: "EliminarSalon"},
                success: function (data) {
                if( data == 0 ){
                        bootbox.alert("Este salon ya esta asociado a una carrera y a un cupo...");
                } else{
                        bootbox.alert("Los datos se Eliminaron Correctamente...");
                }
               window.onload = consultarSalon();
               },
                error: function (data, error)
                {
                  alert("Error en la consulta de los datos.");
                }
                });
            } else {
              console.log("El usuario canceló la Eliminación");
              }
        });
}//End function eliminarSalon

function eliminarResponsable(id){
   var IdResponsable = id; 
       
   bootbox.confirm("Esta seguro de Eliminar el Responsable?", function (result) {
            
            if (result){
                $.ajax({
                type: 'POST',
                url: 'funciones/funcionAsignarCupoAula.php',
                dataType: "html",
                data: {IdResponsable: IdResponsable, action: "EliminaResponsable"},
                success: function (data) {
                if( data == 0 ){
                    bootbox.alert("El responsable esta asignado a una carrera y a un Cupo...");
                }else{
                    bootbox.alert("Los datos se Eliminaron Correctamente...");
                }
                window.onload = limpiar();  
                window.onload = consultarResponsables();
                },
                error: function (data, error)
                {
                  alert("Error en la consulta de los datos.");
                }
                });
            }else{
              console.log("El usuario canceló la Eliminación");
            }
        });
}//End function eliminarResponsable

function actualizarSalon( id ){
    var SalonMod = id;
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "EditarSalon", SalonMod: SalonMod},
            beforeSend: function () {
            },
            success: function (data) {
                bootbox.dialog({
                    title : "Edición de Salon Entrevista",
                    message : data,
                    size: "large",
                    buttons : {
                        success : {
                        label : 'Modificar',
                        className: 'btn-success Guardar',
                        callback : function( ){                 
                        salonModificar = $("#SalonMod").val();    

                            $('#formActualizarSalon').validate({
                                rules:{
                                SalonMod:{ required:true, minlength: 6}
                                },
                                messages:{
                                SalonMod:{required:"Debe digitar el nombre del Salon", minlength:"Debe digitar minimo 6 Caracteres"}
                                }
                            });
                            if($('#formActualizarSalon').valid()){   
                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/funcionAsignarCupoAula.php',
                                    dataType: "html",    
                                    data: {salonModi:salonModificar, salonId:SalonMod ,action: "ModificarSalon"},    
                                    beforeSend: function(){
                                    },
                                    success: function (data){
                                     if( data == 0 ){
                                        bootbox.alert("El Nombre del Salon Ya Existe...");
                                     } else{
                                        bootbox.alert("Los datos se Modificaron Correctamente...");
                                        window.onload = consultarSalon();  
                                        }    

                                    }
                                    });
                            }else {return false}
                        } 
                            
                         },
                        cancel: {
                            label: "Cancelar",
                            className: 'btn-danger',
                            callback: function( ){
                            }
                        }
                    }
                });    
            },
            error: function (data, error){
                alert("Error en la consulta de los datos.");
            }
        });
    
}

function editarResponsable(id){
    var idResponsable = id;
        $.ajax({
            type: 'POST',
            url: 'funciones/funcionAsignarCupoAula.php',
            dataType: "html",
            data: {action: "EditarResponsable", idResponsable: idResponsable},
            beforeSend: function () {
            },
            success: function (data) {
                bootbox.dialog({
                    title : "Edición de Responsables",
                    message : data,
                    size: "large",
                    buttons : {
                        success : {
                        label : 'Modificar',
                        className: 'btn-success Guardar',
                        callback : function( ){ 
                            nombreResMod = $("#nombreResponsableE").val();    
                            apellidoMod = $("#apellidoResponsableE").val();    
                            correoMod = $("#correoResponsableE").val();    
                            alterno1Mod = $("#correoAlterno1").val();    
                            alterno2Mod = $("#correoAlterno2").val();    
                          
                            $('#formEditarResponsable').validate({
                                rules:{
                                nombreResponsableE:{ required:true, lettersonly: true, minlength: 3},
                                apellidoResponsableE:{ required:true, lettersonly: true, minlength: 3},
                                correoResponsableE:{ required:true, email: true},
                                correoAlterno1:{email: true},
                                correoAlterno2:{email: true}
                                },
                                messages:{
                                nombreResponsableE:{required:"Debe digitar un Nombre", lettersonly:"Debe contener solo letras", minlength:"El Nombre debe contener mas de 3 Letras"},
                                apellidoResponsableE:{required:"Debe digitar un Apellido", lettersonly:"Debe contener solo letras", minlength:"El Apellido debe contener mas de 3 Letras"},
                                correoResponsableE:{required:"Debe digitar el correo", email:"Digite un correo valido"},
                                correoAlterno1:{email:"Digite un correo valido"},    
                                correoAlterno2:{email:"Digite un correo valido"}    
                                }
                            });
                            if($('#formEditarResponsable').valid()){    
                            $.ajax({
                                type: 'POST',
                                url: 'funciones/funcionAsignarCupoAula.php',
                                dataType: "html",    
                                data: {idResponsable:idResponsable, nombreResMod:nombreResMod, apellidoMod:apellidoMod, correoMod:correoMod, alterno1Mod:alterno1Mod, alterno2Mod:alterno2Mod ,action: "ModificarResponsable"},    
                                beforeSend: function(){
                                },
                                success: function (data){
                                 if( data == 0 ){
                                    bootbox.alert("El correo Principal ya se encuentra Registrado...");
                                 } else{
                                    bootbox.alert("Los datos se Modificaron Correctamente...");
                                    window.onload = consultarResponsables();  
                                    }    
                                      
                                }
                                });
                            }else {return false}
                        },
                        },
                        cancel: {
                            label: "Cancelar",
                            className: 'btn-danger',
                            callback: function( ){
                 
                            }
                        }
                    
                }
                });    
            },
            error: function (data, error){
             alert("Error en la consulta de los datos.");
            }
        });
}
    
window.onload = modalidad();    
//window.onload = carrera();    
window.onload = aula();
window.onload = responsable();