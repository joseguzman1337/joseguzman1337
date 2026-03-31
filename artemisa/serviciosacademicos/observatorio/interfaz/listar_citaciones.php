<?php
include("../templates/templateObservatorio.php");
include("funciones2.php");

$db =writeHeader("Citaciones",true,"PAE",1,'Citaciones');
   /* include("./menu.php");
   writeMenu(0);*/
   
   $tipo=$_REQUEST['tipo']='C';
   
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Citaciones');


   session_start();

   ?>
   <!--script src="js/jquery.js"></script-->
<style type="text/css">
.wifeo_pagemenu > a {
	color:#36F;
	list-style:none;
	text-decoration:none
}
.wifeo_rubrique > a {
	color:#FFF;
	list-style:none;
	text-decoration:none
}
.wifeo_rubrique:hover > a {
	color:#FFF;
	font-weight:inherit;
	list-style:none;
	text-decoration:none
}
.wifeo_pagesousmenu > a {
	color:#FFFFFF;
	list-style:none;
	text-decoration:none
}
.wifeo_conteneur_menu {
	border-spacing:0px
}
.wifeo_conteneur_menu {
	height:50px;
	border-radius:0px;
	border:0px solid #ea980a;
	background-color:#8cc63f;
	padding:0;
	display:table;
	width:400px
}
.wifeo_conteneur_menu a {
	display:table-cell;
	height:50px;
	padding:0 10px;
	vertical-align:middle;
	text-decoration:none;
	text-align:center;
	-webkit-transition:all 0 s ease;
	-moz-transition:all 0 s ease;
	-ms-transition:all 0 s ease;
	-o-transition:all 0 s ease;
	transition:all 0 s ease
}
.wifeo_pagemenu, .wifeo_rubrique, .wifeo_pagesousmenu {
	float:left;
	position:relative;
	min-width:50%;
	text-align:center;
	display:table
}
.wifeo_sousmenu {
	display:table;
	width:100%;
	background:#CD2026;
	border-top:0px solid #77D62F;
	left:0;
	padding:0px;
	opacity:0;
	position:absolute;
	top:35px;
	visibility:hidden;
	z-index:5
}
@media screen and (min-device-width:1024px) {
.wifeo_sousmenu {
-webkit-transition:all 0 s ease;
-moz-transition:all 0 s ease;
-ms-transition:all 0 s ease;
-o-transition:all 0 s ease;
transition:all 0s ease
}
}
.wifeo_conteneur_menu a:hover {
	display:table-cell;
	height:50px;
	padding:0 10px;
	vertical-align:middle;
	text-align:center;
	text-decoration:none
}
.wifeo_sousmenu a {
	display:table-cell;
	background:#CD2026;
	background-repeat:no-repeat
}
.wifeo_sousmenu a:hover {
	background:#9814BE;
	background-image:url(http://www.wifeo.com/image_design_v3/images_menus/5/50px_h1392824465.png);
	background-position:left;
	background-repeat:no-repeat
}
.wifeo_rubrique:hover .wifeo_sousmenu {
	opacity:1;
	top:50px;
	visibility:visible;
	z-index:500
}
.wifeo_rubrique:after, .wifeo_pagemenu:after {
	content:'';
	display:table-cell;
	position:absolute;
	width:100%;
	height:0;
	top:0;
	left:0;
	z-index:3;
	background:#E67105;
	-webkit-transition:height 0s;
	-moz-transition:height 0.5s;
	-ms-transition:height 0s;
	-o-transition:height 0s;
	transition:height 0s
}
.wifeo_pagemenu:hover:after, .wifeo_rubrique:hover:after {
	height:100%
}
.wifeo_rubrique > a, .wifeo_pagemenu > a {
	z-index:5;
	position:relative
}
</style>
<script>

$(document).ready(function(){
  $("#Seguimiento3").parents('.wifeo_rubrique').css('background-color', '#ea8511');
						   
$("#Seguimiento3").click(function (){// si tiene manejo de estados, imagenes rotatorias, etc
        // llama a ajax2
  $('#tabs').slideDown();
  $('#result').slideDown();
  $('#result2').slideUp();
  $(this).parents('.wifeo_rubrique').css('background-color', '#ea8511');
  $('#Seguimiento').parents('.wifeo_rubrique').removeAttr('style');
 
  });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
						   
						           $("#Seguimiento").click(function (){// si tiene manejo de estados, imagenes rotatorias, etc
																	  $('#tabs').slideUp();
																	  $('#result').slideUp();
																	  $('#result2').slideDown();
                                    $(this).parents('.wifeo_rubrique').css('background-color', '#ea8511');
                                    $('#Seguimiento3').parents('.wifeo_rubrique').removeAttr('style');
        // llama a ajax2
        $.ajax({
           url:"CitacionesPendientes.php" ,//llama pagina " opcion  2"
           beforeSend: function (){//antes de ....
               $("#result2").html("espere un momento... ")//manda el mensaje espere un momento
               
           },
                   success:function (datos){
               $("#result2").html(datos);//cuando llega monta los datos 
                   }
        }); 
    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////	



	});
 	   
  </script>
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
        <nav>
<div class='wifeo_conteneur_menu' style="margin-left: 70px;margin-top:30px;margin-bottom:-20px;">
  <div class='wifeo_rubrique'><a href="#" onclick="" id="Seguimiento" style="color:#FFF">Citaciones Pendientes</a>
    <div class='wifeo_sousmenu'></div>
  </div>
  <div class='wifeo_rubrique'><a href="#"  onclick="criterios()" id="Seguimiento3" style="color:#FFF">Criterios Institucionales</a>
    <div class='wifeo_sousmenu'></div>
  </div>
</div>
</nav>
<div id="result2" style="margin-left:-23px; margin-right:73px">
          
        </div>
        <form id="formCitaciones" method="post" enctype="multipart/form-data">
         <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
         <input type="hidden" id="tipo" name="tipo" value="<?php echo $_REQUEST['tipo']?>" />
         
 
        
         <div id="container" style="margin-left: 70px; ">
           <div id="tabs">

         <!--    <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Criterios<br />Causas</span></a></li>
            <li><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Criterio<br />Docente/Estudiante</span></a></li>
          </ul> -->
          <div id="tabs-1">
            <?php
            $fun->bus_ins($db);
			$fun->bus_periodo($db);
            ?>
          </div>
          <div id="tabs-2" style="display:none;">
            <?php
            $fun->bus_ries($db,'');
            ?>
            
          </div>
          <div id="tabs-3" style="display:none;">
            <?php
                //$fun->bus_doc($db);
            ?>
            <?php
            $fun->bus_est($db);
            ?>
            <?php
            //$fun->bus_periodo($db);
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
        <!--a href="menu.php" class="submit" tabindex="4">Tablero de Mando</a-->
       
          <div id="result" >
          
        </div>
      </div>
      
    </form>
   
    <?php
    if(isset($_REQUEST['habilitar'])){

      $_SESSION['habilitar']=$_REQUEST['habilitar'];

      if($_REQUEST['habilitar']==1){

        

        $habilitar = 1;

        ?>
        <script>
        
        var modalidad=<?php echo $_REQUEST['modalidad']?>;
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var ndocente=$("#codente").val();
        var nestudiante=<?php echo $_REQUEST['nestudiante']?>;
        var periodo=jQuery("select[name='codigoperiodo']").val();
        var semestre = ""; var nivel= ""; var causas1=""; 
        var carrera=<?php echo $_REQUEST['carrera']?>;

        $('input[name="semestre_1[]"]:checked').each(function() { semestre += "'"+$(this).val() + "',"; });
        semestre = semestre.substring(0, semestre.length-1);
        $('input[name="idobs_tiporiesgo[]"]:checked').each(function() { nivel += "'"+$(this).val() + "',";  });
        nivel= nivel.substring(0, nivel.length-1);  
        
        $('input[name="idobs_causas_1[]"]:checked').each(function() { causas1 += "'"+$(this).val() + "',";  });
        causas1= causas1.substring(0, causas1.length-1);  
        
        if (modalidad==0){
          alert("Debe escoger minimo la modalidad academica");
          $('#codigomodalidadacademica').css('border-color','#F00');
          $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
          $("#codigomodalidadacademica").focus();
        }else{    
         $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
              type: 'POST',
              url: 'buscar_registro_riesgo2.php',
              async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                       ndocente:ndocente, nestudiante:nestudiante, semestre:semestre,
                       nivel:nivel, causas:causas1, carrera:carrera, tipo:"C",habilitado:"1"}),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                      success:function(data){
                        $('#result').html(data);
                      }
            }); //AJAX   
          }
          </script>
          
              <script>

 	   
  </script>
          <?php

        }else{

          $habilitar = 0;
        }

      }

      
      writeFooter();
      ?>  
  
   