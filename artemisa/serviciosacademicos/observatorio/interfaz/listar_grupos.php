<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Salas <br> Aprendizaje",true,"PAE",1,'Administracion de salas de aprendizaje');
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Administracion de salas de aprendizaje'); 
   /* include("./menu.php");
    writeMenu(0);*/
   //$tipo=$_REQUEST['tipo'];
   $tipo=1;
    ?>
<script>

    $(document).ready(function(){
    	      
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
               jQuery("select[name='codigofacultad']").change(function(){displayFacultad();});
          
  		$('#tabs').smartTab({
                    selected: 0,
                    saveState:false,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});
        
     function Buscar(){
          $('#result').html('<blink>Cargando...</blink>');
          $.ajax({
                type: 'POST',
                url: 'BuscarNuevoData.php',
                async: false,
                data: $('#form_test').serialize(),                
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            });
     }
     function ListadoSalas(){
        location.href='../SalasAprendizaje/Controller/ListadoSalaAprendizaje_html.php?Op=1';
     }
        
</script>
 <form action="" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" name="entity" id="entity" value="grupos">
        <div id="container" style="margin-left: 70px; ">
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a onclick="ListadoSalas()" id="tab1"><span class="stepDesc">Creación<br />Salas de Aprendizaje</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-1" id="tab2"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            <!--<li><div class="stepNumber">3</div><a href="#tabs-2"><span class="stepDesc">Criterios<br />Docente</span></a></li>-->
            </ul>
            <div id="tabs-1">
				   <?php
					$fun->bus_ins($db,$moda=false, $facul=true,$prog=false,true,true);
					$fun->bus_periodo($db);
					?>
					<br>
					<br>
					<br/>
					<br/>
            </div>
            <!--<div id="tabs-2">
               <?php
                //$fun->bus_doc($db);
                ?>
                <?php
                //$fun->bus_periodo($db);
                ?>
            </div>-->
            
          </div>
		  <div id="botones" style="display:none;">
					   <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button> 
						 &nbsp;&nbsp;
						 <?php if ($roles['editar']==1 ){?>
					   <a href="form_grupos.php" class="submit" tabindex="4">Nuevo</a>
						 &nbsp;&nbsp;
						 <?php } ?> 
					   <a href="form_grupo_estudiante.php" class="submit" tabindex="4">Asignar Estudiantes a Salas</a>
            </div>
           <div id="result" style="width: 1030px;">
            </div>
            </div>
    </form> 
	<script type="text/javascript">
		$( "#tabs ul li a" ).on( "click", function() {
			var id = $( this ).attr( "id" );
		  var res = id.replace("tab", ""); 
		  if(res == "2" || res == 2){
			$( "#botones" ).css('display', 'block');
		  } else {
			$( "#botones" ).css('display', 'none');		  
		  }
		});
		
	</script>
<?php    
writeFooter();
        ?> 
