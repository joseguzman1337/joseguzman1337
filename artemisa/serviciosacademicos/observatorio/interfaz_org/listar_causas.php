<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Variables <br> Riesgo",true,"Riesgo",1);
   $fun = new Observatorio();
   /* include("./menu.php");
    writeMenu(0);*/
   //$tipo=$_REQUEST['tipo'];
   $tipo=1;
    ?>
<script>

    $(document).ready(function(){
    	// Smart Tab
  		$('#tabs').smartTab({
                    selected: 0,
                    saveState:true,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});
        
     function Buscar(){
          $('#result').html('<blink>Cargando...</blink>');
          $.ajax({
                type: 'POST',
                url: 'buscar.php',
                async: false,
                data: $('#form_test').serialize(),                
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            });
     }
        
</script>
 <form action="" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" name="entity" id="entity" value="causas">

        <div id="container" style="margin-left: 70px; ">
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Riesgo</span></a></li>
            </ul>
            <div id="tabs-1">
               <?php
                 $tipo='todos';
                 $fun->bus_tiporiesgo($db,'');
               ?>
                <br>
            </div>
          </div>
            <br>
           <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button> 
             &nbsp;&nbsp;
           <a href="form_causas.php" class="submit" tabindex="4">Nuevo</a>
            &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
           <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    </form> 
<?php    
writeFooter();
        ?> 
