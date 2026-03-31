

<script src="../js/MainGraficarIndicador.js"></script>
<div align="right">
	<img src="../css/images/arrow_leftAzul.png" id="btnRegresarConsultar" class="imgCursor" height="20" width="20" />
</div>
<form id="formGraficarIndicador">
	<fieldset>
		<legend>Indicadores Gráficos</legend>
		<div class="row">
			
			<?php 
			if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10"){
				?>
				<div class="form-group">
					<div class="col-xs-12 col-md-2">
						<label for="txtCodigoFacultad">Facultades:</label>
					</div>
					<div class="col-xs-12 col-md-10">
						<select id="txtCodigoFacultad" class="chosen-select " name="txtCodigoFacultad" >
							<option value="-1">Seleccionar</option>
							<?php foreach( $facultades as $facultad ) { ?>
								<option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
		                	<?php } ?>							
						</select>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php				
			}else{
				?>
				<input type="hidden" name="txtCodigoFacultad" id="txtCodigoFacultad" value="<?php echo $txtCodigoFacultad; ?>" />
				<?php	
			}
			?>
			<div class="form-group">
				<div class="col-xs-12 col-md-2">
					<label for="cmbLineaConsulta">Línea Estratégica:</label>
				</div>
				<div class="col-xs-12 col-md-10">
					<select id="cmbLineaConsulta" class="chosen-select " name="cmbLineaConsulta" >
						<option value="-1">Seleccionar</option>
						<?php foreach( $lineaEstrategicas as $lineaEstrategica ) { ?>
							<option value="<?php echo $lineaEstrategica->getIdLineaEstrategica( ); ?>"><?php echo $lineaEstrategica->getNombreLineaEstrategica( ); ?></option>
	                	<?php } ?>							
					</select>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-md-2">
					<label for="cmbProgramaConsultar">Programa:</label>
				</div>
				<div class="col-xs-12 col-md-10">
					<select id="cmbProgramaConsultar" class="chosen-select " name="cmbProgramaConsultar" >
						<option value="-1">Seleccionar</option> 							
					</select>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-md-2">
					<label for="cmbProyectoConsultar">Proyecto:</label>
				</div>
				<div class="col-xs-12 col-md-10">
					<select id="cmbProyectoConsultar" class="chosen-select " name="cmbProyectoConsultar" >
						<option value="-1">Seleccionar</option> 						
					</select>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-warning" id="btnConsultar">Consultar</button>
				<button type="reset" class="btn btn-warning" id="btnRestaurar">Restaurar</button>
			</div> 
		</div> 
	</fieldset>
	<div class="container-fluid" id="graficos">
	</div>
</form>

<div id="mensageDialogo" align="left" class="ui-widget">
	<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<div id="dialogo"></div>
	</div>
</div>

<div id="mensageAlert" align="left" class="ui-widget">
	<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<div id="alerta"></div>
	</div>
</div>