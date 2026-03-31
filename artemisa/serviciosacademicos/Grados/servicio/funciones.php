<?php
    
    function listar_archivos( $carpeta , $ruta ){
	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	 *se realiza modificacion debido a que se debe consultar en diferentes directorios dentro de una carpeta principal   se añade parametro ruta 
	 * esto para identificar desde donde se estan cargando archivos 
	 * ruta = 0  cargan archivos desde requisitos ver anexos
	 * ruta = 1  cargan archivos desde indexacion 
	 *Since July 12 .2017 
	 */ 
	 

	  $fileTypes = array('pdf');
	  	 if( $ruta == 0 ) {
				 if(is_dir($carpeta)){
				        if($dir = opendir($carpeta)){ ?>
							<div style="width: 80%; margin-left: 50px;">
							<h3 style="margin-top:30px;margin-bottom:0; font-weight: normal; font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif;">Los siguientes son los anexos asociados:</h3>
							<br />
							<ol id="listaDocumentos">
				            <?php while(($archivo = readdir($dir)) !== false){
				            	$filePart = pathinfo($archivo);
				                if (in_array(strtolower($filePart['extension']), $fileTypes)) {
				                	if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
				                	
				                	$ubicacion = base64_encode("ubicacion");
									$nombre = base64_encode("nombre");
				                	$file = base64_encode( urlencode( serialize( "".$carpeta."/".$archivo."" ) ) );
								?>
								<li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;"><?php echo $archivo; ?></a></li>
				              <?php  } 
								}
				            } ?>
				            </ol>
				            </div>
				           <?php closedir($dir);
				        }
				     }

			  } else if ( $ruta == 1 ) { 
	  
					   	/*verificacion de archivos:
						 *  Diplomas:        	DP
						 	Acta de Grado:   	AG
							Incentivo:          IA
							Mención de Honor:   MH
							Mención Meritoria:  MM
							Grado de Honor:	    GH
							Cum Laude:	        CL
							Mangna Cum Laude:	MC
							Suma Cum Laude:	    SC
							Laureada:          	LA
							Certificados Cal:   CN
							Énfasis:    	    EN
						 */
							$ag = '../documentos/Acta de Grado/AG_'.$carpeta.'.pdf'; 
							$dp = '../documentos/Diplomas/DP_'.$carpeta.'.pdf'; 		
							$ia = '../documentos/Incentivo/IA_'.$carpeta.'.pdf';
							$mh = '../documentos/Mencion de Honor/MH_'.$carpeta.'.pdf';
							$mm = '../documentos/Mencion Meritoria/MM_'.$carpeta.'.pdf';
							$gh = '../documentos/Grado de Honor/GH_'.$carpeta.'.pdf';
							$cl = '../documentos/Cum Laude/CL_'.$carpeta.'.pdf';
							$mc = '../documentos/Mangna Cum Laude/MC_'.$carpeta.'.pdf';
							$sc = '../documentos/Suma Cum Laude/SC_'.$carpeta.'.pdf';
							$la = '../documentos/Laureada/LA_'.$carpeta.'.pdf';
							$cn = '../documentos/Certificados Cal/CN_'.$carpeta.'.pdf';
							$en = '../documentos/Enfasis/EN_'.$carpeta.'.pdf';
					   		
					   		?>
							
							<div style="width: 80%; margin-left: 50px;">
								<h3 style="margin-top:30px;margin-bottom:0; font-weight: normal; font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif;">Los siguientes son los anexos asociados:</h3>
								<br />
								<ol id="listaDocumentos">
							
							<?php
							
							$ubicacion = base64_encode("ubicacion");
							$nombre = base64_encode("nombre");
					
					   		if( file_exists ( $ag ) ){
					   		
								 $file = base64_encode( urlencode( serialize( $ag ) ) );	
								 $archivo = 'AG_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Acta de Grado</a></li>
							

					        <?php
							} 
					   
					    	if( file_exists ( $dp ) ){
								
								 $file = base64_encode( urlencode( serialize( $dp ) ) );	
								 $archivo = 'DP_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Diploma</a></li>
					        <?php
							}
							
							if( file_exists ( $ia ) ){
								
								 $file = base64_encode( urlencode( serialize( $ia ) ) );	
								 $archivo = 'IA_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;"><?php echo $archivo; ?></a></li>
					        <?php			
							}
							
							if( file_exists ( $mh ) ){
								
								 $file = base64_encode( urlencode( serialize( $mh ) ) );	
								 $archivo = 'MH_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Mención de Honor</a></li>
					        <?php		
							}
							
							if( file_exists ( $mm ) ){
										
								 $file = base64_encode( urlencode( serialize( $mm ) ) );	
								 $archivo = 'MM_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Mención Meritoria</a></li>
					        <?php		
							}
							
							if( file_exists ( $gh ) ){
							
							 $file = base64_encode( urlencode( serialize( $gh ) ) );	
								 $archivo = 'GH_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Grado de Honor</a></li>
					        <?php			
							}
							
							if( file_exists ( $cl ) ){
										
								 $file = base64_encode( urlencode( serialize( $cl ) ) );	
								 $archivo = 'CL_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Cum Laude</a></li>
					        <?php		
							}
							
							if( file_exists ( $mc ) ){
										
								 $file = base64_encode( urlencode( serialize( $mc ) ) );	
								 $archivo = 'MC_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Mangna Cum Laude</a></li>
					        <?php		
							}
							
							if( file_exists ( $sc ) ){
								
								 $file = base64_encode( urlencode( serialize( $sc ) ) );	
								 $archivo = 'SC_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Suma Cum Laude</a></li>
					        <?php		
							}
							
							if( file_exists ( $la ) ){
								
								 $file = base64_encode( urlencode( serialize( $la ) ) );	
								 $archivo = 'LA_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Laureada</a></li>
					        <?php		
							}
							
							if( file_exists ( $cn ) ){
								
								 $file = base64_encode( urlencode( serialize( $cn ) ) );	
								 $archivo = 'CN_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Certificado de Calificaciones</a></li>
					        <?php		
							}
							
							if( file_exists ( $en ) ){
										
								 $file = base64_encode( urlencode( serialize( $en ) ) );	
								 $archivo = 'EN_'.$carpeta.'.pdf';
							?>
								  <li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;">Énfasis</a></li>
					        <?php		
							}
							
							}
				
		}

	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	 *Funcion para verificar si existen archivos relacionados al codigo del estudiante aplica solo para indexacion de documentos
	 *Since July 12,2017 
	 */
	 
	 function verificarArchivos ( $codigoEstudiante ) {
		
		/*verificacion de archivos:
		 *  Diplomas:        	DP
		 	Acta de Grado:   	AG
			Incentivo:          IA
			Mención de Honor:   MH
			Mención Meritoria:  MM
			Grado de Honor:	    GH
			Cum Laude:	        CL
			Mangna Cum Laude:	MC
			Suma Cum Laude:	    SC
			Laureada:          	LA
			Certificados Cal:   CT
			Énfasis:    	    EN
		 */
			$archivos = 0;
						
			$ag = '../documentos/Acta de Grado/AG_'.$codigoEstudiante.'.pdf'; 
			$dp = '../documentos/Diplomas/DP_'.$codigoEstudiante.'.pdf'; 		
			$ia = '../documentos/Incentivo/IA_'.$codigoEstudiante.'.pdf';
			$mh = '../documentos/Mencion de Honor/MH_'.$codigoEstudiante.'.pdf';
			$mm = '../documentos/Mencion Meritoria/MM_'.$codigoEstudiante.'.pdf';
			$gh = '../documentos/Grado de Honor/GH_'.$codigoEstudiante.'.pdf';
			$cl = '../documentos/Cum Laude/CL_'.$codigoEstudiante.'.pdf';
			$mc = '../documentos/Mangna Cum Laude/MC_'.$codigoEstudiante.'.pdf';
			$sc = '../documentos/Suma Cum Laude/SC_'.$codigoEstudiante.'.pdf';
			$la = '../documentos/Laureada/LA_'.$codigoEstudiante.'.pdf';
			$cn = '../documentos/Certificados Cal/CN_'.$codigoEstudiante.'.pdf';
			$en = '../documentos/Enfasis/EN_'.$codigoEstudiante.'.pdf';
		
		
			if( file_exists ( $ag ) or file_exists ( $dp ) or file_exists ( $ia ) or file_exists ( $mh ) or file_exists ( $mm ) or file_exists ( $gh ) or file_exists ( $cl ) or file_exists ( $mc ) or file_exists ( $sc ) or file_exists ( $la ) or file_exists ( $cn ) or file_exists ( $en ) ){
					
					$archivos = 1;
						
			} else {
							
					$archivos = 0;
			}
		
			return $archivos;
	 }

	/*
	 * funcion  encabezadoTabla y  detalleTabla   aplican para generar reporte pdf de archivo indexados , duplicados y archivos con error
	 */
	function encabezadoTabla ( $tipoEncabezado ){
			$encabezado = "<table border='1' width='100%'  cellspacing='0'>
							<tr>
								 <td colspan='4' align='center'><strong>".$tipoEncabezado."</strong></td>
							</tr>
							<tr align='center'>
								 <td><strong>Codigo</strong></td>
								 <td><strong>Nombre</strong></td>
								 <td><strong>Carrera</strong></td>
								 <td><strong>Archivo</strong></td>
						   	</tr>";	
			return $encabezado;	
	}
	
		function detalleTabla ( $codigo , $nombre , $carrera , $archivo ){
			$detalle = "<tr>
							<td>".$codigo."</td>
							<td>".$nombre."</td>
							<td>".$carrera."</td>
							<td>".$archivo."</td>
						  </tr>";
			return $detalle;		
	}
	

?>