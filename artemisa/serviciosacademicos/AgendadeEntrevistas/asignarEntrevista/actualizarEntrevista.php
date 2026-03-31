<?php
 require('../../Connections/sala2.php');
 require('../../funciones/funcionpassword.php');
 $rutaado = '../../funciones/adodb/';
 require('../../Connections/salaado.php');
 require("../funciones/funcionAsignacionEntrevista.php");


 $codigoCarreraAspirante = $_REQUEST['codigoCarreraAspirante'];
 $nombreAspirante =  $_REQUEST['nombreAspirante'];
 $nombreCarreraAspirante = $_REQUEST['nombreCarreraAspirante'];
 $idEstudianteCarreraInscripcion = $_REQUEST['idEstudianteCarreraInscripcion'];

 $datosEntrevista = consutarId( $db, $idEstudianteCarreraInscripcion);
 $horaInico = strtotime($datosEntrevista['HoraInicio']);
 $fechaEntrevista = $datosEntrevista['FechaEntrevista'];
 $entrevistaId= $datosEntrevista['EntrevistaId'];
 $entrevistaAsignacionId=$datosEntrevista['AsignacionEntrevistaId'];
 
 $jornada = "";
 $horario = "";
 $jm = strtotime('12:00:00');
 $jt = strtotime('18:00:00');


	 if( $horaInico <= $jm ){
	 	$jornada = 'jm';
	 	$horario = 'Am';
	 }
	 else if ( $horaInico >= $jm and $horaInico <= $jt ){
	 	$jornada = 'jt';
	 	$horario = 'Pm';
	 } 

	 else if ( $horaInico >= $jt ){
	 	$jornada = 'jn';
	 	$horario = 'Pm';
	 }

	function saber_dia( $nombredia ) {
	//clasifica los dias  0 a 6 iniciando en Domingo
		$dias = array(0,1,2,3,4,5,6);
		$fecha = $dias[date('N', strtotime( $nombredia ))];
		return $fecha;
	}

function nombre_dia( $nombredia ) {
//muestra los dias de la  semana 
	$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
	$fecha = $dias[date('N', strtotime( $nombredia ))];
	return $fecha;
}

$dia = saber_dia( $fechaEntrevista );

function bontonEncender( $dia , $valor){
	if ($dia == $valor ){
			echo  'btn-success active';

		}
	}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<script type="text/javascript" src="../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../assets/js/jquery.validate.min.js"></script>


<script type="text/javascript">
	$('[data-toggle="tooltip"]').tooltip( ); 
	jQuery.validator.setDefaults({
				highlight:function(element){
				 $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
					},
				 	unhighlight:function(element){
						$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
						},
						errorElement:'span',
						errorClass:'help-block',
						errorPlacement:function(error,element){
							if(element.parent('.input-group').length){
								error.insertAfter(element.parent());
							}else{
								error.insertAfter(element);
								}
							}
				});
	jQuery.validator.addMethod("onlyText",function(value,element){
					var input=/^\s*[a-zA-Z,\s]+\s*$/;
					return this.optional(element) || input.test(value);
					}, "Este Campo solamente acepta texto.");

</script>
<style>

  .modal-body {
   	max-height: 80vh;
    overflow-y: scroll;
}


</style>
<form id="formActualizarEntrevista" class="form-horizontal">
	<input type="hidden" id="codigoCarrera" value="<?php echo $codigoCarreraAspirante ?>">
	<input type="hidden" id="idEstudianteCarreraInscripcionA" value="<?php echo $idEstudianteCarreraInscripcion ?>">
	<input type="hidden" id="entrevistaId" value="<?php echo $entrevistaId ?>">
	<input type="hidden" id="entrevistaAsignacionId" value="<?php echo $entrevistaAsignacionId;?>">

	<div align="center">
		  <div class="jumbotron">
		      <div class="container">
		        <fieldset>
				
				  <div class="form-group">
					<div><p style="color:red">Fecha Actual Entrevista : <?php echo  $fechaEntrevista .' Día '. nombre_dia( $fechaEntrevista ).' '.$datosEntrevista['HoraInicio'].' '. $horario; ?> </p> </div>
		           </div>	

		           <div class="form-group">
		                <label class="control-label col-md-4" for="aspirante">Aspirante: </label>
		                <div class="col-md-8">
		                	  	<input class="form-control" type="text"  name="aspirante" id="AspiranteA" placeholder="" value="<?php echo $nombreAspirante;?>" readonly="">
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="control-label col-md-4" for="programa">Programa académico: </label>
		                <div class="col-md-8">
		                	  	<input class="form-control" type="text"  name="programa" id="Aspirante" value="<?php echo $nombreCarreraAspirante;?>" readonly="">
		                </div>
		            </div>
					
					
					<div class="form-group">
		                <label class="control-label col-md-4" for="tipoJornadaA">Jornada  preferencia: </label>
		                <div class="col-md-8">
							<!--
							jm = jornanda manañana
							jt = jornada tarde
							jn = jornada noche
							-->
		            		<select class="form-control" id="tipoJornadaA">
		            			<option value="jm" <?php if($jornada == 'jm'){echo 'selected';}?>>Mañana</option>
		            			<option value="jt" <?php if($jornada == 'jt'){echo 'selected';}?>>Tarde</option>
		            			<option value="jn" <?php if($jornada == 'jn'){echo 'selected';}?>>Noche</option>
		            		</select>    	  	
		                </div>
		            </div>
						


					 <div class="form-group">
		                <label class="control-label col-md-4" for="">Día de Preferencia : </label>
		                 <div class="col-md-8">
			                 <div class="btn-group">
								  <button type="button" data-toggle="tooltip" title="Lunes" class="btn btn-default col-xs-12  col-sm-2 col-md-2 equivalenteA <?php bontonEncender($dia , 1) ?>" id="lu" value="1" >Lu</button>

								  <button type="button" data-toggle="tooltip" title="Martes" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalenteA <?php bontonEncender($dia , 2) ?>"  id="ma" value="2" >Ma</button>

								  <button type="button" data-toggle="tooltip" title="Miercoles" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalenteA <?php bontonEncender($dia , 3) ?>"  id="mi" value="3" >Mi</button>

								  <button type="button" data-toggle="tooltip" title="Jueves" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalenteA <?php bontonEncender($dia , 4) ?>"  id="ju" value="4" >Ju</button>

								  <button type="button" data-toggle="tooltip" title="Viernes" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalenteA <?php bontonEncender($dia , 5) ?>"  id="vi" value="5" >Vi</button>

								  <button type="button" data-toggle="tooltip" title="Sábado" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalenteA <?php bontonEncender($dia , 6) ?>"  id="sa" value="6" >Sa</button>
							 </div>
		                	  	
		                </div>
		               </div>
													

		             <div class="form-group">
						<div id="fechasA"> 
							<?php 
							echo dias ( $db , $dia.',' , $codigoCarreraAspirante , $jornada );
							?>
						</div>
		             </div>

					 <div class="form-group">
		                <label class="control-label col-md-4" for="aspirante">Observación: </label>
		                <div class="col-md-8">
		                	  	<textarea id="observacion" name ="observacion" class="form-control" placeholder="Digite el motivo por el cual reprograma o cancela la entrevista" ></textarea>
		                </div>
		            </div>

		         </fieldset>
		      	</div>
		  </div>
	</div>
</form>