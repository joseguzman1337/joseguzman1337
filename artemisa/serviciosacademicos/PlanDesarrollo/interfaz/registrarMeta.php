<script src="../tema/jquery.validate.js"></script>
<script src="../js/MainSeguimiento.js"></script>
<script src="../js/textarea-helper.js"></script>

  <script>
        $(document).ready(function (){
          $('.campoNumeros').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });
    </script>
<?php
 /**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
 ini_set('display_errors','On');
 include '../tools/includes.php';
 include '../control/ControlIndicador.php';
 
 session_start( );
 
 if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			if( is_array($_POST[$key_post]) ){
				$$key_post = $_POST[$key_post];
			}else{
				$$key_post = strip_tags(trim($_POST[$key_post]));
			}
		}
	}
	
if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){
    	if( is_array($_GET[$key_get]) ){ 
        	$$key_get = $_GET[$key_get];
		}else{
			$$key_post = strip_tags(trim($_GET[$key_get]));
		}
     } 
}
 
 
 
 if( isset ( $_SESSION["datoSesion"] ) ){
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$txtCodigoFacultad = $user[4];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 5 ] );
	$persistencia->conectar( );
}else{
	header("Location:error.php");
}

?>
		
  <script>
  
  
  </script>

<style>
	#listaIndicadores{
		background-color:#B3B3B3;	
		cursor: pointer;
	}
	
	li{
		padding: 12px;
	}
</style>

<form class="" class="form-horizontal" id="metasNuevas" >
	<input type="hidden" value="<?php echo $idProyecto?>" name="idProyecto" id="idProyecto">
	<input type="hidden" value="" name="idIndicador" id="idIndicador">
	

	   <div class="form-group">
			<label class="col-md-3 form-label">Facultad:</label>
			
			<div class="col-md-9">
				<input type="text" readonly="" value="<?php echo $facultad; ?>" class="form-control" id="FacultadNuevaMeta" name="FacultadNuevaMeta">
			</div>
			
		</div >
		
		<div class="form-group">
			
			<label class="col-md-3 form-label">Programa Acadmico:</label>
			
			<div class="col-md-9">
				<input type="text" readonly="" value="<?php echo $programaAcademico; ?>" class="form-control" id="programaANuevaMeta" name="programaANuevaMeta">
			</div>
			
		</div >
		
		<div class="form-group">
			
			<label class="col-md-3 form-label">Línea Estratégica:</label>
			
			<div class="col-md-9">
				<textarea readonly=""  class="form-control" name="lineaNuevaMeta" id="lineaNuevaMeta"><?php echo $linea; ?></textarea>
			</div>
			
		</div >
		
		<div class="form-group">
			
			<label class="col-md-3 form-label">Programa:</label>
			
			<div class="col-md-9">
				<textarea  readonly="" id="pNuevaMeta" name="pNuevaMeta" class="form-control col-md-10"><?php echo $programa; ?></textarea>
			</div>
			
		</div >
		
		<div class="form-group">
			
			<label class="col-md-3 form-label">Proyecto:</label>
			
			<div class="col-md-9">				
				<textarea readonly="" id="proyectoNuevaMeta" name="proyectoNuevaMeta"  class="form-control"><?php echo $proyecto?></textarea><br>
			</div>
			
		</div >
		
		<div class="form-group">
			<label class="col-md-3 form-label">Meta:</label>
			<div class="col-md-9">
				<textarea class="form-control" name="metaPlan" id="metaPlan"></textarea>
			</div>
		</div >
		
		<div class="form-group">
			<label class="col-md-3 form-label">Alcance Meta:</label>
			<div class="col-md-9">
				<input type="text" name="valorMeta"  value="" class="form-control campoNumeros" id='valorMeta'>
			</div>
		</div >
		
		<div class="form-group">
			<label class="col-md-3 form-label ">Tipo Indicador:</label>
				<div class="form-check form-check-inline col-md-9 ">
				 <p class='contenedorRadio'>
					    <label class="form-check form-check-inline">
				       	  <input type="radio" name="tIndicador"   id="rdbCuantitativo" value="1"> Cuantitativo
				        </label>
			    
					    <label class="form-check form-check-inline">
					      <input  type="radio" name="tIndicador"  id="rdbCualitativo" value="2"> Cualitativo
					    </label>
				<p>
				</div >
		<div>

		
		
		<div class="form-group">
			
			<label class="col-md-3 form-label">Indicador:</label>
			
			<div class="col-md-9">
				  <textarea class="form-control" id="indicadorPlan" name="indicadorPlan" size="30"></textarea>
				  <div id="nIndicador"></div>
			</div>
		</div >
		
	<br>
	<div class="form-group col-md-3">
			<button id="btnRegistrarNuevaMeta" class="btn btn-warning form-control ">Guardar</button>
	</div>
  	
  	<div class="form-group col-md-3">
		    <button id="btnCancelarNuevaMeta" class="btn btn-warning form-control ">Cancelar</button>
	</div>	
		
</form>



