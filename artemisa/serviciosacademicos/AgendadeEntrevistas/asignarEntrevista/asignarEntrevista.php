
<?php
 require('../../Connections/sala2.php');
 require('../../funciones/funcionpassword.php');
 $rutaado = '../../funciones/adodb/';
 require('../../Connections/salaado.php');
 require("../funciones/funcionAsignacionEntrevista.php");

 $codigoCarreraAspirante = $_REQUEST['codigoCarreraAspirante'];
 $nombreAspirante =  $_REQUEST['nombreAspirante'];
 $nombreCarreraAspirante = $_REQUEST['nombreCarreraAspirante'];

?>
<!--<script type="text/javascript" src="../serviciosacademicos/AgendadeEntrevistas/js/main.js"></script>-->
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<script type="text/javascript" src="../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>

<script type="text/javascript">
		$('[data-toggle="tooltip"]').tooltip( );		
		$( ".Guardar" ).attr( "disabled" , "disabled" ); 
</script>

<form id="formAsignarEntrevista" class="form-horizontal">
	<input type="hidden" id="codigoCarrera" value="<?php echo $codigoCarreraAspirante ?>">
	<div align="center">
		  <div class="jumbotron">
		      <div class="container">
		        <fieldset>
		           <div class="form-group">
		                <label class="control-label col-md-4" for="aspirante">Aspirante: </label>
		                <div class="col-md-8">
		                	  	<input class="form-control" type="text"  name="aspirante" id="Aspirante" placeholder="" value="<?php echo $nombreAspirante;?>" readonly="">
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="control-label col-md-4" for="programa">Programa académico: </label>
		                <div class="col-md-8">
		                	  	<input class="form-control" type="text"  name="programa" id="Aspirante" value="<?php echo $nombreCarreraAspirante;?>" readonly="">
		                </div>
		            </div>
					
					
					<div class="form-group">
		                <label class="control-label col-md-4" for="tipoJornada">Jornada  preferencia: </label>
		                <div class="col-md-8">
							<!--
							jm = jornanda manañana
							jt = jornada tarde
							jn = jornada noche
							-->
		            		<select class="form-control" id="tipoJornada">
		            			<option value="">Seleccionar</option>
		            			<option value="jm">Mañana</option>
		            			<option value="jt">Tarde</option>
		            			<option value="jn">Noche</option>
		            		</select>    	  	
		                </div>
		            </div>

					 <div class="form-group">
		                <label class="control-label col-md-4" for="">Día de Preferencia : </label>
		                 <div class="col-md-8">
			                 <div class="btn-group">
								  <button type="button" data-toggle="tooltip" title="Lunes" class="btn btn-default col-xs-12  col-sm-2 col-md-2 equivalente" id="lu" value="1" disabled="disabled">Lu</button>
								  <button type="button" data-toggle="tooltip" title="Martes" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalente"  id="ma" value="2" disabled="disabled">Ma</button>
								  <button type="button" data-toggle="tooltip" title="Miercoles" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalente"  id="mi" value="3" disabled="disabled">Mi</button>
								  <button type="button" data-toggle="tooltip" title="Jueves" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalente"  id="ju" value="4" disabled="disabled">Ju</button>
								  <button type="button" data-toggle="tooltip" title="Viernes" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalente"  id="vi" value="5" disabled="disabled">Vi</button>
								  <button type="button" data-toggle="tooltip" title="Sábado" class="btn btn-default col-xs-12  col-sm-2 col-md-2  equivalente"  id="sa" value="6" disabled="disabled">Sa</button>
							 </div>
		                	  	
		                </div>
		             </div>
				
		             <div class="form-group">
						<div id="fechas"> <p style="color: red">Seleccione Jornada de preferencia Para realizar la asignación de la entrevista</p></div>
		             </div>
		             
		         </fieldset>
		      	</div>
		  </div>
	</div>

</form>