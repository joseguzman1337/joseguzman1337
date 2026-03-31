<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

	include("../templates/templateObservatorio.php");
	include("funciones.php");
	$fun = new Observatorio();
   
	$db =writeHeader("Entrevista<br>Admisiones",true,"Admisiones",1);
   
	$tipo=$_REQUEST['tipo'];
	////////////INFORMACION DEL ESTUDIANTE///////////////
	$codigoestudiante=$_REQUEST['codigoestudiante'];
	$query_carrera = " SELECT codigoperiodo FROM estudianteestadistica ee WHERE ee.codigoestudiante=". $codigoestudiante;
	$dataPeriodo= $db->GetRow($query_carrera);
	$codigoperiodo = $_SESSION['codigoperiodosesion'];
	if(!empty($dataPeriodo)){
		$codigoperiodo = $dataPeriodo["codigoperiodo"];
	}
   
	$query_segunda_ent = "SELECT idobs_estadoadmision FROM obs_admitidos_cab_entrevista 
							WHERE codigoestudiante = ".$codigoestudiante." AND codigoperiodo = ".$codigoperiodo." 
							AND codigoestado = 100";
	$dataSegundaEnt= $db->GetRow($query_segunda_ent);
?>
<script src="../js/jtip.js" type="text/javascript"></script>
    <script type="text/javascript">
   
	$(document).ready(function(){
    	
//                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
//                var estudiante=$("#codigoestudiante").val();
//                var entity=$("#entity1").val();
//                var codcarrera=$("#cod_carrera").val();
//                jQuery("#tabs-1")
//                    .html(ajaxLoader)
//                    .load('generaentrevista_paso1.php', {codigoestudiante: estudiante, entity:entity, cod_carrera:codcarrera }, function(response){					
//                    if(response) {
//                        jQuery("#tabs-1").css('display', ''); 
//                    } 
//                });
                
  		$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'});
   
                
        });
            
       function cargar(id){
        var Utipo=$("#Utipo").val();
        if(id==1){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity1").val();
                var codcarrera=$("#cod_carrera").val();
                var tipo=$("#tipo").val();
                jQuery("#tabs-1")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso1.php', {codigoestudiante: estudiante, Utipo:Utipo, tipo:tipo, entity:entity, cod_carrera:codcarrera }, function(response){					
                    if(response) {
                        jQuery("#tabs-1").css('display', ''); 
                    } 
                });
         }else if(id==2){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity2").val();
                var tipo=$("#tipo").val();
                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                jQuery("#tabs-2")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso2.php', {codigoestudiante: estudiante, Utipo:Utipo, tipo:tipo,  entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                    if(response) {
                        jQuery("#tabs-2").css('display', ''); 
                    } 
                });
         }else if(id==3){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity3").val();
                var tipo=$("#tipo").val();
                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                jQuery("#tabs-3")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso3.php', {codigoestudiante: estudiante, Utipo:Utipo, tipo:tipo, entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                    if(response) {
                        jQuery("#tabs-3").css('display', ''); 
                    } 
                });
         }else if(id==4){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var tipo=$("#tipo").val();
                var entity=$("#entity1").val();
                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                jQuery("#tabs-4")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso4.php', {codigoestudiante: estudiante, Utipo:Utipo, tipo:tipo, entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                    if(response) {
                        jQuery("#tabs-4").css('display', ''); 
                    } 
                });
         }else if(id==5){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var tipo=$("#tipo").val();
                var entity=$("#entity1").val();
                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                jQuery("#tabs-5")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso5.php', {codigoestudiante: estudiante, Utipo:Utipo, tipo:tipo, entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                    if(response) {
                        jQuery("#tabs-5").css('display', ''); 
                    } 
                });
         }else if(id==6){
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity1").val();
                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                jQuery("#tabs-6")
                    .html(ajaxLoader)
                    .load('generaentrevista_paso6.php', {codigoestudiante: estudiante, Utipo:Utipo,  entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                    if(response) {
                        jQuery("#tabs-6").css('display', ''); 
                    } 
                });
         }
       }
 
    </script>
<form action="" method="post" id="form_test">
      <input type="hidden" name="entity1" id="entity1" value="admitidos_cab_entrevista">
      <input type="hidden" name="entity2" id="entity2" value="admitidos_entrevista_conte">
      <input type="hidden" name="entity3" id="entity3" value="admitidos_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $codigoperiodo ?>" />
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>" />
      <input type="hidden" name="Utipo" id="Utipo" value="<?php echo $_REQUEST['Utipo'] ?>" />
        <div id="container" style="margin-left: 10px;">
            <!--DATOS DEL ESTUDIANTE-->
                <?php $cod_carrera=$fun->estu_admision($db,$codigoestudiante);
                        //echo '-->'.$cod_carrera ?>
            <input type="hidden" id="cod_carrera" name="cod_carrera" value="<?php echo $cod_carrera ?>" >
	<span style="font-size:10px;">* Recuerde que tiene 24 horas para hacer las modificaciones requeridas a la entrevista una vez se haya iniciado el proceso.</span>
            <br/><br/>
        <div id="tabs" style=" width: 1350px;  ">
            <ul>
                <li style="width: 190px" ><div class="stepNumber">1</div><a href="#tabs-1" onclick="cargar('1')"><span class="stepDesc">Datos del<br />Estudiante</span></a></li>
                <li style="width: 150px"><div class="stepNumber">2</div><a href="#tabs-2" onclick="cargar('2')"><span class="stepDesc">Preguntas<br />Familia y Contexto Gen  </span></a></li>
                <li style="width: 190px"><div class="stepNumber">3</div><a href="#tabs-3" onclick="cargar('3')"><span class="stepDesc">Campos<br />A Evaluar</span></a></li>
                <li style="width: 190px"><div class="stepNumber">4</div><a href="#tabs-4" onclick="cargar('4')"><span class="stepDesc">Entrevistadores<br /></span></a></li>
				<?php if($dataSegundaEnt['idobs_estadoadmision'] == '3'){ ?>
                <li style="width: 190px"><div class="stepNumber">5</div><a href="#tabs-5" onclick="cargar('5')"><span class="stepDesc">Segunda entrevista<br /></span></a></li>
				<?php } ?>
                <?php if ($tipo=='Adm') {?>
                <li style="width: 190px"><div class="stepNumber">6</div><a href="#tabs-6" onclick="cargar('6')"><span class="stepDesc">Admision<br /></span></a></li>
                <?php } ?>
                <!--<li style="width: 190px"><div class="stepNumber">6</div><a href="#tabs-6"><span class="stepDesc">Nota Aclaratoria</span></a></li>-->
            </ul>
            <div id="tabs-1" style=" height: 250px">
                
                <br>
                <br>
            </div>
            <div id="tabs-2" style=" height: 550px">
                   
            </div>
            <div id="tabs-3" style=" height: 1050px">
            
            </div>
            <div id="tabs-4" style=" height: 250px">
            
            </div>
			<?php if($dataSegundaEnt['idobs_estadoadmision'] == '3'){ ?>
			<div id="tabs-5" style=" height: 250px">
            
            </div>			
            <?php } if ($tipo=='Adm') {?>
            <div id="tabs-6" style=" height: 150px">
            
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</form>

<?php    writeFooter();
        ?>  

