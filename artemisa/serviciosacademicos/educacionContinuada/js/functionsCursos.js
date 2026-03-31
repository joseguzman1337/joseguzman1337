 $(document).ready(function() {     
    //Para agregar empresas al registrar/editar cursos cerrados
    $('#btnEmpresas').click(function(event) {
                        if(!$("#btnEmpresas").hasClass("disable")){
                            var i = parseInt($( "#numEmpresas" ).val()) + 1;

                                var html = '<div class="empresa">';
                                html = html + '<label for="nombre" class="fixed">Empresa: </label>';
                                html = html + '<input type="text"  class="grid-5-12 empresaName" minlength="2" name="empresa[]" id="empresa_'+i+'" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="" />';
                                html = html + '<input type="hidden"  class="grid-5-12" minlength="2" name="idempresa[]" id="idempresa_'+i+'" maxlength="12" tabindex="1" autocomplete="off" value="" />';
                                html = html + '<input type="hidden"  class="grid-5-12" minlength="2" name="tmp_empresa[]" id="tmp_empresa_'+i+'" value="" />';
                                html = html + '</div>';

                                $("#btnEmpresas").before(html);
                                $( "#numEmpresas" ).val(i);
                            // 12 es el máximo de empresa que pueden patrocinar un curso   
                            if(i>12){
                                $("#btnEmpresas").addClass("disable");
                            }
                        }
                    });

    //Para agregar profesores al registrar/editar cursos cerrados				
            $('#btnProfesores').click(function(event) {
                    if(!$("#btnProfesores").hasClass("disable")){
                            var i = parseInt($( "#numProfesores" ).val()) + 1;
                            var j = i - 1;
                            if($( "#profesor_" + j ).val()==="" || $( "#idprofesor_" + j ).val()===""){
                                $( "#profesor_" + j ).addClass('error');
                                $( "#profesor_" + j ).effect("pulsate", { times:3 }, 500);
                            } else {
                                    var html = '<div class="profesor">';
                                        html = html + '<label for="nombre" class="fixed">Profesor: </label>';
                                        html = html + '<input type="text"  class="grid-5-12 profesorName" minlength="2" name="profesor[]" id="profesor_'+i+'" title="Profesor" maxlength="200" tabindex="1" autocomplete="off" value="" />';
                                        html = html + '<input type="hidden" class="grid-5-12 idprofesor" minlength="2" name="idprofesor[]" id="idprofesor_'+i+'" maxlength="12" tabindex="1" autocomplete="off" value="" />';
                                        html = html + '</div>';

                                        $("#btnProfesores").before(html);
                                        $( "#numProfesores" ).val(i);
                                    // 30 es el máximo de profesores que pueden patrocinar un curso   
                                    if(i>30){
                                        $("#btnProfesores").addClass("disable");
                                    }
                            }
                        }
                    });
    
    //autocomplete de profesores
    $(document).on("keyup",".profesorName",function(event){
                    var idNumber = $(this).attr("id");
                    idNumber = idNumber.split("_");
                    idNumber = idNumber[idNumber.length-1];
                    
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForProfesores.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-400;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idprofesor_'+idNumber).val(ui.item.id);
                        },
                        change: function(event, ui) {
                            if (ui.item) {
                                //todo bien... el usuario eligio uno del autocomplete
                                $( this ).removeClass('error');
                            } else {
                                //no se ha elegido nada en el autocomplete
                                $( this ).addClass('error');
                            }
                        }
                    });
    
                });

    //Para evitar que si hay cambios en el datos de profesores no quede registrado el que no es
  $("#profesores").on("keydown",".profesorName", function(event){
        //vacio el id al cambiar el nombre
        $(this).next('input.idprofesor').val('');
    });
    
    $('#actividad').change(function() {
        getActividadesHijas();
    });
   
    
 });
 
$(function() {
                    $( "#fechainiciogrupo" ).datepicker({
                        defaultDate: "-30d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-2y"
                        }
                    );
                    
                    $( "#fechafinalgrupo" ).datepicker({
                        defaultDate: "+0d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-2y"
                        }
                    );
                        
                    $( "#fechaInicioInscripcion" ).datepicker({
                        defaultDate: "-30d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-2y"
                        }
                    );
                    
                    $( "#fechaFinalInscripcion" ).datepicker({
                        defaultDate: "+0d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-2y"
                        }
                    );
                    
                    $( "#fechaFinalMatriculas" ).datepicker({
                        defaultDate: "+0d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-2y"
                        }
                    );
                        
                    $( "#ui-datepicker-div" ).show();
                });
                
 $(document).ready(function() {
            $('#ui-datepicker-div').hide();
});
 
 /****
  * Para los que son de tipo eventos de actualización
  */
 function getActividadesHijas(selected){
            $('#actividadHija').remove();
            selected = (typeof selected === "undefined") ? "null" : selected;
            if($('#actividad').val() != ""){
                var act = $('#actividad').val();
                    $.ajax({
                      dataType: 'json',
                      type: 'POST',
                      url: '../searches/getCategoriasHijas.php',
                      data: { actividad: act, selected: selected },                
                      success:function(data){
                             $('#actividad').after(data.html);
                    },
                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                }); 
            }     
 }
 

function validarFecha(idFechaMin,idFechaMax){
    valido = true;
    if (new Date ($( "#"+idFechaMin ).val()) > new Date ($( "#"+idFechaMax ).val())) {
          $( "#"+idFechaMin ).addClass('error');
           $( "#"+idFechaMin ).effect("pulsate", { times:3 }, 500);
          $( "#"+idFechaMax ).addClass('error');
           $( "#"+idFechaMax ).effect("pulsate", { times:3 }, 500);
         valido = false;
   }
   return valido;
}

function isInt(n) {
   return typeof n === 'number' && n % 1 == 0;
}

function validarCursosGrupo(){
    var valido = true;
    var val = validarFecha("fechaInicioInscripcion","fechaFinalInscripcion");
                        if(!val){
                            valido = false;
                        }
                        
                        //validar que la fecha de inicio no sea mayor que la fecha final
                        val = validarFecha("fechainiciogrupo","fechafinalgrupo");
                        if(!val){
                            valido = false;
                        }
                        
                        //validar que la fecha de pago matricula sea mayor que las de inscripcion
                        val = validarFecha("fechaFinalInscripcion","fechaFinalMatriculas");
                        if(!val){
                            valido = false;
                        }
                        
                        if(!isInt(parseFloat($("#valorMatricula").val()))){
                            $( "#valorMatricula" ).addClass('error');
                            $( "#valorMatricula" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                        }
                        
                        if(!isInt(parseFloat($("#cupoEstudiantes").val()))){
                            $( "#cupoEstudiantes" ).addClass('error');
                            $( "#cupoEstudiantes" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                        }  
                      
                        if(($('#tipo').val()==2 && $('#empresa_1').val()=="")){
                            $( "#empresa_1" ).addClass('error');
                            $( "#empresa_1" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                        }
                        
                        if($('#idprofesor_1').val()==""){
                            $( "#profesor_1" ).addClass('error');
                            $( "#profesor_1" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                        }
    return valido;
}