$(function(){
   //eleccion para realizar si presiona el boton crear carrera snies o si elige losbotones de modificar
   $('.btnAccionSnies').on('click',function (event) {
       var btn = $(this).attr('id');
       btn = btn.split('_');
       var accion = btn[0];
       btn = btn[1];

      if (accion=='crear'){
          $("#selecCarrera").val('');
          $("#selecCarrera").select2({ disabled: false });
          var codigoCarrera ='';
          $('#groupGeneral').hide();
          $("#frmGestion")[0].reset();
          $('#tituloModal').text('Crear carrera Snies');
          var url = 'ajax/cargaCarreraAjax.php';

      }else if(accion == 'modificar'){
          var codigoCarrera = $('#codigoCarrera_'+btn).val();
          $("#selecCarrera").select2({
              disabled: true
          });
          var idcarreraRegistro = $('#idCarreraRegistro_'+btn).val();
          var codigoSnies = $('#codigoSnies_'+btn).text();
          $('#identificador').val(idcarreraRegistro);
          $('#codigoSnies').val(codigoSnies);
          $('#contadorFila').val(btn);
          $('#fechaFinCarrera').val($('#fechaFin_'+btn).text());
          $('#fechainicioCarrera').val($('#fechaInicio_'+btn).text());
          $('#groupGeneral').show();
          $('#tituloModal').text('Actualizar carrera Snies');
          var url = 'ajax/cargaCarreraAjax.php';
      }
       $.ajax({
           type: 'POST',
           url: url,
           data: {
               accion: accion,
               codCarrera:codigoCarrera
           },
           success: function(response){
               $('#selecCarrera').append(response)
           }
       });

      $('#ejecucionAjax').val(accion);
      $('#accion').val(accion);
      $('#accion').text(accion);
   });
   $('#accion').on('click',function(){
       $("#selecCarrera").select2({ disabled: false });

        var nombreCarrera = $ ( "#selecCarrera option:selected" ) .html ();
        var fechaFinCarrera = $('#fechaFinCarrera').val();
        var codigoSnies = $('#codigoSnies').val();
        if(validaForm()){
            $.ajax({
                type: 'POST',
                url: 'ajax/procesarCarreraSniesAjax.php',
                data: new FormData(document.getElementById('frmGestion')),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ //console.log(response);
                   var contadorFila = $('#contadorFila').val();
                    $('#statusMsg').html('');
                    if(response == 1){// la carrera ya existe
                        swal('alerta!','Carrera Snies '+nombreCarrera+' ya Existe','warning');
                    }else if(response == 2){
                        swal('alerta!','No se Detecto Ningun Cambio Realizado','error');// si no surgio ningun cambio el update
                        $("#selecCarrera").select2({ disabled: true });
                    }else if(response == 3){//si se realizo correctamente el proceso
                        $("#selecCarrera").select2({ disabled: true });
                        swal('ok!','Actualizado Correctamente','success');
                        $('#modalFormuulariosnies').modal('hide');
                    }else if(response == 4){
                        $('#codigoSnies_'+contadorFila).text(codigoSnies);
                        swal('info!','Actualizado Correctamente','success');
                        $('#modalFormuulariosnies').fadeOut(3000, function(){  $("#modalFormuulariosnies").modal('hide'); });
                    }else if(response==5){// 5 carrera snies registrada correctamente
                        swal('ok!','Carrera Snies Registrada Correctamente','success');
                        $('#modalFormuulariosnies').modal('hide');
                    }else{
                        swal('inf!','Ocurrio un problema','error');
                    }

                }
            });
        }
    });

        function validaForm(){
        // Campos de texto
        var seleccion =  $("#selecCarrera").val();
        var fechaFin =  $("#fechaFinCarrera").val();
        var codigoSnies = $("#codigoSnies").val();
        if ($('#ejecucionAjax').val()=='crear') {
            if (seleccion == '') {
                swal('Alerta!', 'No selecciono ninguna carrera', 'warning');
                $("#selecCarrera").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
                return false;
            }
        }
        if(fechaFin == ''){
            swal('Alerta!','Fecha Fin Obligatoria','warning');
            $("#fechaFinCarrera").focus();
            return false;
        }

        if (codigoSnies==''){
            swal('Alerta!','Codigo Snies Obligatorio','warning');
            $("#codigoSnies").focus();
            return false;
        }
        return true;
    }
});
$(function(){
    $('#tbCarreras').DataTable();
    $('#selecCarrera').select2({
       dropdownParent: $("#modalFormuulariosnies"),
        language: {
            noResults: function() {

                return "No hay resultado";
            },
            searching: function() {

                return "Buscando..";
            }
        }
    });
});