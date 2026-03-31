<script src="../tema/jquery.validate.js"></script>
<script src="../js/MainSeguimiento.js"></script>
<div align="right">
	<a href="#" id="btnRegresarConsultar"><img src="../css/images/arrow_leftAzul.png"  class="imgCursor" height="20" width="20" /><strong >Regresar al menu</strong></a>
</div>
		<br />
<?php 
    if( isset ( $_SESSION["datoSesion"] ) ){
            $user = $_SESSION["datoSesion"];
            $idPersona = $user[ 0 ];
            $luser = $user[ 1 ];
            $lrol = $user[3];
            $txtCodigoFacultad = $user[4];
            $persistencia = new Singleton( );
            $persistencia = $persistencia->unserializar( $user[ 5 ] );
            $persistencia->conectar( );
    }
?>

	
<form id="formConsultar">
	<fieldset>
		<?php
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Se cambio el nombre de ingreso de sistema Seguimiento Plan de Desarrollo por Definición de Metas y Responsables
		 * @since  January 02, 2017
		*/
		//<legend>Seguimiento Plan de Desarrollo</legend>
		?>
		<legend style="margin-bottom:0px">Definición de Metas y Responsables</legend>
		<?php /*Fin Modificacion*/ ?>
		<div class="consultarPlan row">
			<?php 
			if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10"){
			?>
                            <div class="form-group">
                                    <div class="col-xs-12 col-md-2 ">
                                            <label for="txtCodigoFacultad">Facultad:</label>
                                    </div>
                                    <div class="col-xs-12 col-md-10 ">
                                            <select id="txtCodigoFacultad" class="chosen-select " name="txtCodigoFacultad" >
                                                    <option value="-1">Seleccionar</option>
                                                    <!--
                                                    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
                                                    *Se añade opcion plan desarrollo institucional
                                                    *Since May 23,2018
                                                    */
                                                    -->    
                                                    <option value="10000">Plan Desarrollo Institucional</option>
                                                    <?php foreach( $facultades as $facultad ) { ?>
                                                            <option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo  ucwords(strtolower($facultad->getNombreFacultad( ))); ?></option>
                                                    <?php } ?>							
                                            </select>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
			<?php				
			}else{//nFacultas
			?>
                            <input type="hidden" name="txtCodigoFacultad" id="txtCodigoFacultadd" value="<?php echo $txtCodigoFacultad; ?>" />

                                    <div class="form-group">
                                    <div class="col-xs-12 col-md-2 ">
                                        <label for="txtCodigoFacultad">Facultad:</label>
                                    </div>
                                    <div class="col-xs-12 col-md-10 ">
                                        <select id="txtCodigoFacultad" class="chosen-select " name="txtCodigoFacultad" >
                                            <option value="<?php echo $txtCodigoFacultad?>"><?php echo  ucwords(strtolower($nFacultas)); ?></option>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
						
			<?php	
			}
			?>
			<div class="form-group">
                            <div class="col-xs-12 col-md-2">
                                    <label for="cmbCarrera">Programa Académico:</label>
                            </div>
                            <div class="col-xs-12 col-md-10">
                                    <select id="cmbCarrera" class="chosen-select " name="cmbCarrera" >
                                        <option value="-1">Seleccionar</option>
                                        <?php foreach( $carreras as $carrera ) { ?>
                                                <option value="<?php echo $carrera->getCodigoCarrera( ); ?>"><?php echo $carrera->getNombreCarrera( ); ?></option>
                                        <?php } ?>							
                                    </select>
                            </div>
                            <div class="clearfix"></div>
			</div>
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
                            <div class="col-xs-12 col-md-2">
                        <!-- 
                        *@ivan quintero <quinteroivan@unbosque.edu.co
                        * Modificacion del nombre de "Indicador" a "Meta Principal" y cmbIndicadorConsultar por cmbMetaConsultar
                        >-->
                                <label for="cmbMetaConsultar">Meta principal:</label>
                        <!-- * end -->                    

                            </div>
                            <div class="col-xs-12 col-md-10">
                                <!-- 
                                *@ivan quintero <quinteroivan@unbosque.edu.co
                                * Modificacion del nombre cmbIndicadorConsultar por cmbMetaConsultar
                                >-->					
                                <select id="cmbMetaConsultar" class="chosen-select " name="cmbMetaConsultar" >
                                    <option value="-1">Seleccionar</option> 						
                                </select>
                                <!-- * end -->
                            </div>
                            <div class="clearfix"></div>
			</div>
			<div class="form-group">
                            <div class="row">
				<div class="col-xs-12 col-md-2">
				<button type="submit" class="btn btn-warning col-md-12 col-xs-12" id="btnConsultar">Consultar</button>
				</div>
				
				<div class="col-xs-12 col-md-2">
				<button type="reset" class="btn btn-warning col-md-12 col-xs-12" id="btnRestaurar">Restaurar</button>
				</div>
				<?php
				$permisoInsertar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "insertar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "insertar");
				 if($permisoInsertar){
				 	    /* 93 rol decano
				         * 98 rol Director de Facultad
						 * 99 rol Coordinador de Facultad
						 * 102 rol apoyo decano
						 * 101 rol planeacion
						 */
				 	
                                    if( $lrol ==  93 or $lrol == 98 or $lrol ==  99 or $lrol == 102 or $lrol == 101 ){
				?>	
                                        <div class="col-xs-12 col-md-2 col-md-offset-6">
                                        <button type="submit" class="btn btn-warning  col-md-12 col-xs-12 " id="btnNuevaMeta" >Nueva Meta</button>
                                        </div>
				<?php 	
                                    }
				 }
				 ?>
                            </div> 
                        </div>
	</fieldset> 
</form>
<br />
<div id="dvTablaConsultarPlan" style="overflow: auto; width: 100%; top: 0px; height: 100%px; border: 1px solid; border-radius: 4px; display: none" >
	<table cellpadding="5" cellspacing="0" border="1" width="100%" class="tablaUsuarios">
		<tbody id="TablaConsultarPlan">
		</tbody>
	</table>
</div>
<br />
<div id="detallePlan"></div>
<div id="actualizaPlan"></div>
<div id="nuevaMetaPrincipal"></div>