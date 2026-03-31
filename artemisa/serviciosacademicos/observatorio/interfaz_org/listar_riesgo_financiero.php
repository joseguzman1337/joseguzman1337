<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Observatorio",true,"Causas Financieras");
    $fun = new Observatorio();
   /* include("./menu.php");
    writeMenu(0);*/
   
    ?>
<script>

  
      $(document).ready(function(){    
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
               jQuery("select[name='codigofacultad']").change(function(){displayFacultad();});
      
    });
  
    function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var ndocente=$("#codente").val();
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
        }else{    
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'buscar_remision_financiera.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                             ndocente:ndocente, nestudiante:nestudiante, semestre:semestre,
                             nivel:nivel, causas:causas1, carrera:carrera, tipo:tipo}),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            }); //AJAX   
        }
    }
    $(document).ready(function(){
    	// Smart Tab
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
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Criterios<br />Causas</span></a></li>
            <li><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Criterio<br />Estudiante</span></a></li>
            </ul>
            <div id="tabs-1">
                 <?php
                $fun->bus_ins($db);
                ?>
                   
            </div>
            <div id="tabs-2">
               <?php
                $fun->bus_ries($db,'2');
                ?>
            </div>
            <div id="tabs-3">
                 <?php
                $fun->bus_est($db);
                ?>
                <?php
                $fun->bus_periodo($db);
                ?>
            </div>   </div>
           
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button> 
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php    
writeFooter();
        ?>  