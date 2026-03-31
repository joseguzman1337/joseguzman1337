<?php
   include("../templates/templateObservatorio.php");
   include("funciones2.php");
   $tipo=$_REQUEST['tipo'];
   if($tipo=='R'){
       $tit='Registro Riesgo';
      
   }else if($tipo=='P'){
       $tit='Identificacion <br> Riesgo';
   }else if($tipo=='S'){
       $tit='Seguimiento Estu.<br> Docente';
   }else if($tipo=='SE'){
       $tit='Seguimiento <br> Estudiante';
   }else if($tipo=='ET'){
       $tit='Estudiante <br> Tutor';
   }

  

  $db =writeHeader($tit,true,"Causas Asistencias",1,'Registro de riesgo');

    

   
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Registro de riesgo'); 
   /* include("./menu.php");
    writeMenu(0);*/
   
   
   
    ?>
<script>

  function AutocompletarEstudiante(){

    var modalidad      = jQuery("select[name='codigomodalidadacademica']").val();

    
    if (modalidad == 0){

               alert("Seleccione modalidad, facultad y programa");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();

    }else{


          var carrera="";
          $('input[name="Carrera_1[]"]:checked').each(function() { carrera+= "'"+$(this).val() + "',";});
                   carrera= carrera.substring(0, carrera.length-1);

            if(carrera==""){

              $('#nombreEst').val('');
            $('#documento').val('');

              alert("Seleccione un programa");

            }else{

              $('#nombreEst').autocomplete({

              source: "AutocompletarRegRiesgo.php?carrera="+carrera,
              select: function(event, ui){

                $("#documento").val(ui.item.numerodocumento);
              }

          });


            }

        



      }


  }

function Format(){
    $('#nombreEst').val('');
    $('#documento').val('');

}

function excel(){
              // alert('hola')
               // alert($("<div>").append( $("#customers2").eq(0).clone()).html());
      $("#datos_a_enviar").val( $("<div>").append( $("#customers2").eq(0).clone()).html());
                $("#form_test").submit(); 
  }
  
      $(document).ready(function(){    
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();

                $('#tabs-3').slideUp();

              
               });
               jQuery("select[name='codigofacultad']").change(function(){displayFacultad();

                $('#tabs-3').slideUp();

               });
      
    });
  
     function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var ndocente=$("#codente").val();
        var nombreEst=$("#nombreEst").val();
        var nestudiante=$("#documento").val();
        var periodo=jQuery("select[name='codigoperiodo']").val();

        var semestre = ""; var nivel= ""; var causas1=""; var carrera="";
        $('input[name="semestre_1[]"]:checked').each(function() { semestre += "'"+$(this).val() + "',"; });
        semestre = semestre.substring(0, semestre.length-1);
        $('input[name="idobs_tiporiesgo[]"]:checked').each(function() { nivel += "'"+$(this).val() + "',";  });
        nivel= nivel.substring(0, nivel.length-1);  
        
         $('input[name="idobs_causas_1[]"]:checked').each(function() { causas1 += "'"+$(this).val() + "',";  });
        causas1= causas1.substring(0, causas1.length-1);  
      
        $('input[name="Carrera_1[]"]:checked').each(function() { carrera+= "'"+$(this).val() + "',";});
               carrera= carrera.substring(0, carrera.length-1);
        if (modalidad==0){
            alert("Debe escoger minimo la modalidad academica");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();
        }else if(periodo=="" && modalidad!=0 ){
            alert("Debe escoger un periodo academico");
                 $('#codigoperiodo').css('border-color','#F00');
                 $('#codigoperiodo').effect("pulsate", {times:3}, 500);
                 $("#codigoperiodo").focus();
         
         ////////////////////////////////////////////////////////////////////////////////////
    }
    else {    


           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'buscar_registro_riesgo2.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                             ndocente:ndocente, nestudiante:nestudiante, nombreEst:nombreEst, semestre:semestre,
                             nivel:nivel, causas:causas1, carrera:carrera, tipo:tipo}),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            }); //AJAX   
        }
    }
    $(document).ready(function(){

$('input[name="Carrera_1[]"]').live('click', function(){


        var carrera="";

        $('input[name="Carrera_1[]"]:checked').each(function() { carrera+= "'"+$(this).val() + "',";});
               carrera= carrera.substring(0, carrera.length-1);

               if(carrera==""){

                  $('#tabs-3').slideUp();
               }else{

                $('#tabs-3').slideDown();
               }





});

$('#checkTodos').live('click', function(){ 

  $('#tabs-3').slideDown();

});

$('#checkNinguno').live('click', function(){ 

  $('#tabs-3').slideUp();

});






      $('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
  });
        
</script>
 <form action="ficheroExcel.php" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" id="tipo" name="tipo" value="<?php echo $_REQUEST['tipo']?>" />
 </form>
<div id="container" style="margin-left: 70px; ">
<?php 
///////////////////////////////////    encabezado tipo S ////////////////////////////////////////////////
if($tipo=='S'){
   ?>
<label style="color:#2448a5; font-size:13px">Aquí usted podrá encontrar el historial de información del estudiante en relación al Programa de Apoyo al Estudiante PAE. 
También encontrara la opción de citación de un estudiante, información que será guardada en la sección "Citación PAE", Citaciones pendientes.</label>
<?php 
   }
   if($tipo=='R'){
   ?>
<label style="color:#2448a5; font-size:13px">Aquí usted podrá encontrar el historial de información del estudiante en relación al Programa de Apoyo al Estudiante PAE. También encontrara la opción de citación de un estudiante, información que será guardada en la sección "Citación PAE", Citaciones pendientes.</label>
<?php 
   }
   ?>
<br />

           <div id="tabs">
            <ul>    
            <li>
              <a href="#tabs-1">
              <table  bgcolor="#ea8511" >
                  <tr>
                    <td style="font-size:12px ; color:#FFF ; padding-top:6px ; padding-left:28px " >      Criterios                 </td>
                  </tr>
                  <tr>
                    <td style="font-size:12px ; color:#FFF  ;padding-bottom:6px ; padding-left:28px ;padding-top:0" width="180px" >      Institucionales            </td>
                  </tr>
                </table>
              </a>
            </li>

            </ul>
            <div id="tabs-1">
                <?php
                $fun->bus_ins($db);
                $fun->bus_periodo($db);
                ?>
                         </div>
            <div id="tabs-2">
                <?php
                //$fun->bus_ries($db,'');
                ?>
                                <?php
                //$fun->bus_doc($db);
                ?>
                
            </div>
            <div id="tabs-3" style="display:none;">

                <?php
                $fun->bus_est($db);
                ?>

            </div>
           </div>
    <br>
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button> 
             &nbsp;&nbsp;
             <?php  if ($tipo=='R' && $roles['editar']==1){ ?>
                    <a href="form_registro_riesgo.php" class="submit" tabindex="4">Nuevo</a>
            <?php } ?>
            &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            <div id="result" >

                
            </div>
            </div>
    
<?php    
writeFooter();
        ?>  