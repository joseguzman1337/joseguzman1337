<?php
   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Citaciones",true,"PAE",1);
   /* include("./menu.php");
    writeMenu(0);*/
   $tipo=$_REQUEST['tipo'];
   
   $fun = new Observatorio();
    ?>
<script>

function excel(){
              // alert('hola')
               // alert($("<div>").append( $("#customers2").eq(0).clone()).html());
  		$("#datos_a_enviar").val( $("<div>").append( $("#customers2").eq(0).clone()).html());
                $("#form_test").submit(); 
  }
  
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
                      url: 'buscar_registro_riesgo.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                             ndocente:ndocente, nestudiante:nestudiante, semestre:semestre,
                             nivel:nivel, causas:causas1, carrera:carrera, tipo:"C"}),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            }); //AJAX   
        }
    }
    $(document).ready(function(){
    	$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});
        
</script>
 <form id="formCitaciones" method="post" enctype="multipart/form-data">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" id="tipo" name="tipo" value="<?php echo $_REQUEST['tipo']?>" />
 
        <div id="container" style="margin-left: 70px; ">
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Criterios<br />Causas</span></a></li>
            <li><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Criterio<br />Docente/Estudiante</span></a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $fun->bus_ins($db);
                ?>
                         </div>
            <div id="tabs-2">
                <?php
                $fun->bus_ries($db,'');
                ?>
                
            </div>
            <div id="tabs-3">
                <?php
                $fun->bus_doc($db);
                ?>
                <?php
                $fun->bus_est($db);
                ?>
                <?php
                $fun->bus_periodo($db);
                ?>
            </div>
           </div>
            <br>
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button> 
             
             <?php  if ($tipo=='R'){ ?>
                    &nbsp;&nbsp;
                    <a href="form_registro_riesgo.php" class="submit" tabindex="4">Nuevo</a>
            <?php } ?>
              &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
 </form>   
<?php    
writeFooter();
        ?>  