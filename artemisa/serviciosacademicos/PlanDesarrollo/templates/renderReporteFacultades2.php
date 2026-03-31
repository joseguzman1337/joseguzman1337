<script>
	$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
	
</script>
<style>
a{
	color:#000000 !important;
}
</style>


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

//include ('../control/ControlPlanProgramaLinea.php');
require_once '../control/ControlMeta.php';
$controlPlanProgramaLinea = new ControlPlanProgramaLinea( $persistencia );
$controlMeta = new ControlMeta( $persistencia );

	switch($tiporeporte)
	{
		case '1':
		{
		?>
                        <div class="table">  
                            <table class="table" width="1130px" > <!--width="1130px" -->
					<thead>
						<tr>
							<th style="width: 120px !important;">Línea Estratégica</th>
							<th style="width: 120px !important;">Programa</th>
							<th style="width: 120px !important;">Proyecto</th>
							<th style="width: 120px !important;">Indicador</th>
							<th style="width: 120px !important;">Meta</th>
							<th style="width: 120px !important;">Alcance de la Meta</th>
							<th style="width: 170px !important;">Evidencias</th>
							<th style="width: 120px !important;">Vigencia</th>
							<th style="width: 120px !important;">Valoración</th>
						</tr>
					</thead>
					<tbody id="datosFacultades">
						<?php 
				
							foreach( $linea as $ln ){
							
								$idLinea = $ln->getLineaEstrategica( )->getIdLineaEstrategica( );
								$nombreLinea = $ln->getLineaEstrategica( )->getNombreLineaEstrategica( );
								$porcentajeLinea = $ln->getPorcentaje();
							
									
								if($porcentajeLinea == '') {
									$porcentajeLinea = 0;
								}
								
								$programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea );
			
						
							//	
						?>
							<tr>
								<td style="vertical-align:middle;width: 120px !important;border-bottom: 1px dotted green;border-right: 1px dotted green;">
									<?php 
                                                                                //separa el texto de la linea por espacion en un array
										$Palabras_linea = explode(" ", $nombreLinea);
										                                        //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
										 
										 $contadorPalabras = 0;
										 $tool='';
										 while ($contadorPalabras <5 ){
										 	
											if( isset($Palabras_linea[$contadorPalabras])){
												$tool.=$Palabras_linea[$contadorPalabras]." ";
												$contadorPalabras++;
											}else {
												$contadorPalabras++;
											}
										 }                                       
									                                     
                                        echo '<div data-toggle="tooltip" title="'.$nombreLinea.'" >'.$tool.'</div>';
										echo '<p align="center"><strong>'.number_format($porcentajeLinea).'%</strong></p>';
									?>
								</td>
								<td colspan="9" >
									<table class="table" >
										<?php
										foreach( $programas as $prg ){
											
											 $idPrograma = $prg->getPrograma( )->getIdProgramaPlanDesarrollo( );
											 $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma );
											 $porcentajePrograma = $prg->getPorcentaje();
									
												if($porcentajePrograma == '') {
													$porcentajePrograma = 0;
												}
												
										?>
										<tr>
											<td style="width: 120px !important;" >
												<?php
												$tool='';
                                                      //separa el texto del programa por espacion en un array
                                                       $Palabras_Programa = explode(" ", $prg->getPrograma()->getNombrePrograma());
                                                      //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                                                       $tool='';
													   $contadorPalabras = 0;
															 while ($contadorPalabras < 5 ){
															 	
																if( isset($Palabras_Programa[$contadorPalabras])){
																	$tool.=$Palabras_Programa[$contadorPalabras]." ";
																	$contadorPalabras++;
																}else {
																	$contadorPalabras++;
																}
															 }                      
					                                                      
                                                       echo '<div data-toggle="tooltip" title="'.$prg->getPrograma()->getNombrePrograma().'" >'.$tool.'</div>';
												echo '<p align="center"><strong>'.number_format($porcentajePrograma).'%</strong></p>';
												?>
											</td>
											
											<td >
												<table class="table" >
													<?php
													foreach( $proyectos as $pry )	
                                                                                                        {		
														$idProyecto = $pry->getProyecto()->getProyectoPlanDesarrolloId() ;
														$nombreProyecto= $pry ->getProyecto()->getNombreProyectoPlanDesarrollo();
														$porcentajeProyecto = $pry ->getPorcentaje();
									
															if($porcentajeProyecto == '') {
																$porcentajeProyecto = 0;
															}
														
													?>
													<tr>	
														<td style="vertical-align:middle;width: 120px !important;"> 
														<?php
                                                            //separa el texto del proyecto por espacion en un array
                                                            $Palabras_Proyecto = explode(" ", $nombreProyecto);
                                                             $tool='';
													  		 $contadorPalabras = 0;
															 while ($contadorPalabras < 5 ){
															 	
																if( isset($Palabras_Proyecto[$contadorPalabras])){
																	$tool.=$Palabras_Proyecto[$contadorPalabras]." ";
																	$contadorPalabras++;
																}else {
																	$contadorPalabras++;
																}
															 }   
                                                            
                                                            
                                                            //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                                                             echo '<div data-toggle="tooltip" title="'.$nombreProyecto.'" >'.$tool.'</div>';
														echo '<p align="center"><strong>'.number_format($porcentajeProyecto).'%</strong></p>';	    		
														?>
														</td>		
														
														<td style="vertical-align:middle; padding: 0 !important;">
															<table class="table" >
																<?php
																	$meta = $controlMeta->metaProyecto( $idProyecto );
																	
																	foreach ($meta as $mt ) {
																		$idMeta = $mt->getMetaIndicadorPlanDesarrolloId( );
																		$nombreMeta = $mt->getNombreMetaPlanDesarrollo( );
																		$alcanceMeta = $mt->getAlcanceMeta( );
																		$vigenciaMeta = $mt->getVigenciaMeta( );
																		$porcentajeMeta = $mt->getPorcentaje( );
																		$indicador = $mt->getMetaIndicadorPlanDesarrolloId( );
																		if( $porcentajeMeta == '') {
																			$porcentajeMeta = 0;
																		}
																?>
																<tr>
																	<td style="width: 120px !important;" ><?php  ?></td>
																	<td style="width: 120px !important;" >
                                                                               <?php 
                                                                              /*        if(!empty($nombreMeta))
                                                                                          {
                                                                                             //separa el texto de la meta por espacion en un array
                                                                                   //    $Palabras_meta = explode(" ", $nombreMeta);
                                                                                     //   $cantidad_palabras = count($Palabras_meta);
                                                                                      //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                                                                                      echo '<div data-toggle="tooltip" title="'.$nombreMeta.'" >';
		                                                                                      for($i=0; $cantidad_palabras < 5; $i++)
		                                                                                      	{
		                                                                                           if(!empty($cantidad_palabras[$i]))
		                                                                                         	  {
		                                                                                            	echo $cantidad_palabras[$i]." ";
		                                                                                               }
		                                                                                           }
		                                                                                           echo '</div>';   
		                                                                                           }
		                                                                                           else
			                                                                                           {
			                                                                                             echo 'Sin informacion'; 
			                                                                                             }
			                                                                                                                                            */?>
                                                                                                                                        </td>
																	<td style="width: 120px !important;"><?php echo $alcanceMeta.'%'; ?></td>
																	<td style="width: 170px !important;"><button class="btn btn-warning btn-labeled fa fa-eye" onclick="verEvidenciaPlan('<?php echo $idProyecto?>' , '<?php echo $indicador?>' , 'VerEvidencia' , '<?php echo $idMeta?>')">
																	  Evidencias
																	</button></td>
																	<td style="width: 120px !important;text-align: center;"><?php echo $vigenciaMeta;?></td>
																	<td style="width: 120px !important;">
																		<?php 
																		
																		if ($porcentajeMeta   > 100) {
															 
																				echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center">'.round($porcentajeMeta , 2, PHP_ROUND_HALF_ODD).'%</div>';
																		
																			} else if ($porcentajeMeta   > 75 && $porcentajeMeta  < 101) {
																				
																				echo '<div data-toggle="tooltip" title="Muy alto" style="background:blue;color:white;text-align:center">'.round($porcentajeMeta , 2, PHP_ROUND_HALF_ODD).'%</div>';
																			
																			} else if ($porcentajeMeta   > 50 && $porcentajeMeta  <= 75) {
																				
																				echo '<div data-toggle="tooltip" title="Alto" style="background:green;color:white;text-align:center">'.round($porcentajeMeta , 2, PHP_ROUND_HALF_ODD).'%</div>';
																			
																			} else if ($porcentajeMeta   > 25 && $porcentajeMeta  <= 50) {
																				
																				echo '<div data-toggle="tooltip" title="Medio" style="background:yellow;color:black;text-align:center">'.round($porcentajeMeta , 2, PHP_ROUND_HALF_ODD).'%</div>';
																			
																			} else if ($porcentajeMeta   < 26) {
																				
																				echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center;">'.round($porcentajeMeta , 2, PHP_ROUND_HALF_ODD).'%</div>';
																			}
																		
																		?>
																		
																	</td>
																
																</tr>
																<?php
																	} // fin foreach meta
																?>
															</table>	
														</td>			
													</tr>
													<?php 	
														}// fin foreach proyectos
													?>
												</table>
												
											</td>
										</tr>
										<?php
										} // foreach programas
										?>
									</table>
								</td>							
							</tr>
						<?php 	
								//
							}// fin foreach linea
						?>
					</tbody>
				</table>
                            </div>
		<?php
		}break;
		case '2': 
		{
		?>
			<div class="col-md-8">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Plan Desarrollo</th>
							<th>Cumplimiento Linea Estrategica</th>
							<th>ValoracionLinea estrategica</th>
							<th>Cumplimiento Programa</th>
							<th>Valoracion Programa</th>
							<th>Cumplimiento proyecto</th>
							<th>Valoracion proyecto</th>
						</tr>
					</thead>
					<tbody>				
						<tr></tr>
					</tbody>
				</table>
			</div>
		<?php
		}break;
		case '3':
		{
			if($cmbRectoria== '1')
			{
			?>
			
        	 <div class="table-responsive">
				<table class="table table-bordered" >
					<thead>
						<!-- 
						* @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 				* se agregan columnas con los nombres de los indicadores y tooltip en los titulos
		 				* @since March  15, 2017 	
						-->
						<tr>
							<th><a href="#">Plan Desarrollo</a></th>
							<th><a href="#" data-toggle="tooltip" title="Misión, Proyecto Educativo Institucional, Orientación Estratégica Institucional, Visión">Misión</a></th>
							<th><a href="#" data-toggle="tooltip" title="Planeación, Innovación, Calidad">Planeación</a></th>							
							<th><a href="#" data-toggle="tooltip" title="Talento Humano">Talento Humano</a></th>
							<th><a href="#" data-toggle="tooltip" title="Educación">Educación</a></th>
							<th><a href="#" data-toggle="tooltip" title="Investigación">Investigación</a></th>
							<th><a href="#" data-toggle="tooltip" title="Responsabilidad Social Universitaria">Responsabilidad</a></th>
							<th><a href="#" data-toggle="tooltip" title="Éxito Estudiantil">Éxito Estudiantil</a></th>
							<th><a href="#" data-toggle="tooltip" title="Bienestar Universitario">Bienestar Universitario</a></th>
							<th><a href="#" data-toggle="tooltip" title="Internacionalización">Internacionalización</a></th>
							<th><a href="#">Cumplimiento del plan</a></th>
							<th><a href="#">Valoracion del plan</a></th>
						</tr>
						<!--fin modificacion -->
					</thead>
					<tbody id="datosplanes">
					<?php					
					//echo '<pre>'; print_r($PlanDesarrollo);
					foreach($PlanDesarrollo as $planes)
					{
						
												
					?>
						<tr>							
							<td><!-- Nombre del plan-->
						
							<?php echo $planes->NombrePlanDesarrollo; ?>
							</td>
							<td>
								<!-- 
						* @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 				* se agregan programas de las diferentes lineas estrategicas  con tooltip 
		 				* @since March  15, 2017 	
						-->
							<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $mision ) {
									if( $mision->getMision()!='' ){
										?>
										<div data-toggle="tooltip" title="Misión, Proyecto Educativo Institucional, Orientación Estratégica Institucional, Visión" >
										<?php echo $numerador.'.'. $mision->getMision(); ?>
										</div>
										
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>		
							
							</td>
							
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $planeacion ) {
									if( $planeacion->getPlaneacion()!='' ){
										?>
										<div data-toggle="tooltip" title="Planeación, Innovación, Calidad" >
										<?php echo $numerador.'.'. $planeacion->getPlaneacion(); ?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $tHumano ) {
									if( $tHumano->getThumano()!='' ){
										?>
										<div data-toggle="tooltip" title="Talento Humano" >
										<?php echo $numerador.'.'. $tHumano->getThumano(); ?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $educacion ) {
									if($educacion->getEducacion()!=''){
										?>
										<div data-toggle="tooltip" title="Educación" >
										<?php echo $numerador.'.'. $educacion->getEducacion(); ?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $investigacion ) {
									if( $investigacion->getInvestigacion()!=''){
										?>
										<div data-toggle="tooltip" title="Investigación" >
										<?php echo $numerador.'.'. $investigacion->getInvestigacion(); ?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $responsabilidad ) {
									if( $responsabilidad->getResponsabilidad()!='' ){
										?>
										<div data-toggle="tooltip" title="Responsabilidad Social Universitaria" >
										<?php echo $numerador.'.'. $responsabilidad->getResponsabilidad(); ?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $eEstudiantil ) {
									if($eEstudiantil->getEestudiantil()!='' ){
									   ?>
									   	<div data-toggle="tooltip" title="Éxito Estudiantil">
										<?php echo $numerador.'.'. $eEstudiantil->getEestudiantil();?>
										</div>
										<?php 
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $bUniversitario) {
									if( $bUniversitario->getBuniversitario()!='' ){
										?>
										<div data-toggle="tooltip" title="Bienestar Universitario" >
										<?php echo $numerador.'.'. $bUniversitario->getBuniversitario();?>
										</div>
										<?php 
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
							?>	
							</td>
							<td>
								<?php 
							$programas=$controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId );
							 $numerador=1;
								foreach ( $programas as $internacionalizacion ) {
									if($internacionalizacion->getInternacionalizacion()!='' ){
										?>
										<div data-toggle="tooltip" title="Internacionalización" >
										<?php echo $numerador.'.'. $internacionalizacion->getInternacionalizacion();?>
										</div>
										<?php
										echo '<br>';
										echo '<br>';
										$numerador++;
								}
							}
								//fin 
							?>	
							</td>
							<td></td>
							<td></td>
						</tr>
					<?php
					}//foreach
					?>
					</tbody>
				</table>
				</div>	
	
			<?php
			}
			if($cmbRectoria== '2')
			{
				?>
				<div class="col-md-8">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Linea</th>
								<th>PDI</th>
								<th>Facultad</th>
								<th>...</th>
								<th>Departamentos</th>
								<th>Cumplimiento de la linea</th>
								<th>Valoracion de la linea</th>
							</tr>
						</thead>
						<tbody id="datoslineas">
							<tr></tr>
						</tbody>
					</table>
				</div>
				<?php
			}//if
		}break;
	}
?>
  
<div id="verAvance"></div>
		