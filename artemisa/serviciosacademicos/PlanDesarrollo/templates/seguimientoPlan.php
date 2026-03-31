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
	
	$permisoEliminar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "eliminar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "eliminar");
?>

<table cellpadding="0" cellspacing="0" border="1" width="100%">
	<thead>
		<tr></tr>
		<tr>
			<th colspan="7">
				<h2>Indicador</h2>
			</th>
		</tr>
		<tr>
			<td colspan="5">
				<strong>Indicador</strong>
			</td>
			<td colspan="2">
				<strong>Tipo Indicador</strong>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<?php echo $indicador->getNombreIndicador( );
							$indicador->getIndicadorPlanDesarrolloId( );
					
					?><br />
			</td>
			<td colspan="2">
				<?php echo $indicador->getTipoIndicador()->getNombreTipoIndicador();
					  $tipoIndicador = $indicador->getTipoIndicador()->getIdTipoIndicador();

						?><br />
			</td>
		</tr>
	</thead>
</table>

<table cellpadding="0" cellspacing="0" border="1" width="100%">
	<thead>
		<tr></tr>
		<tr>
			<th colspan="7">
				<h2>Meta Plan De Desarrollo</h2>
			</th>
		</tr>
	</thead>
</table>

<table cellpadding="0" cellspacing="0" border="1" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nombre</th>
			<?php
			/*modified Diego RIvera <riveradiego@unbosque.edu.co>
			 *se ocultan campos de avanve y valor
			 * Since  March 22,2017 
			 */ 
			
			?>
			<!--<th>Valor</th>
			<th>Avance</th>-->
			<?php 
			//fin modificacion
			?>
			<th>Vigencia</th>
			<th>Responsable Proyecto</th>
			<?php 
			  if ( $permisoEliminar ) {
			?>
			<th></th>
			<th></th>
			<?php 
			 } else {
			 	?>
			<th colspan="2"></th>	
			<?php
			 }
			 ?>
		</tr>
	</thead>
	<tbody class="listaEstudiantes">
		<?php
		foreach( $metas as $k => $meta ) {
			$porcentaje = "";
			
			if( $indicador->getTipoIndicador()->getIdTipoIndicador( ) == "2" ){
				$porcentaje = "%";
			}
		?>
		<tr>
			<td><?php echo $k+1; ?></td>
			<td><?php echo $meta->getNombreMetaPlanDesarrollo(); ?>
				<?php 
				 $metasSecundariasPlan=$meta->getMetasSecundarias();
				 $numeroAvances = sizeof( $metasSecundariasPlan );
				 
				 $acumuladoMeta = 0;
				 foreach ( $metasSecundariasPlan as $ms ) {
					$acumuladoMeta = $acumuladoMeta + $ms->getValorMetaSecundaria();
				 }
				
				?>
				</td> 
			<?php
			/*modified Diego RIvera <riveradiego@unbosque.edu.co>
			 *se ocultan campos de avanve y valor
			 * Since  March 22,2017 
			 */ 
			?>
			<!--<td><?php echo $meta->getAlcanceMeta().$porcentaje; ?></td> 
			<td><?php echo $meta->getAvanceMetaPlanDesarrollo(); ?></td> -->
			<?php 
			// fin modificacion
			?>
			<td><?php echo $meta->getVigenciaMeta(); ?></td> 
			<td ><?php echo $proyecto->getResponsableProyecto(); ?></td> 
                 <?php
                 /*
                 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                 * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
                 * con los modulos y donde se van a registar
                 * @since  marzo 21, 2017
                 */

                        if ( $permisoEliminar and $numeroAvances == 0 ) {
                        ?>
                        <td>
                         <?php  	
                         } else {
                         ?>

                        <td colspan="2">
                        <?php 
                          }
                          ?>	
                                <button class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="actualizarPlan('<?php echo $meta->getMetaIndicadorPlanDesarrolloId() ; ?>')">Editar</button>
                        </td>

                        <?php 
                        if ( $numeroAvances  == 0 ) {
                                  if ( $permisoEliminar and $lrol ==101 ) {

                	 ?>
			<td>
				<button class="btn btn-warning btn-labeled fa fa-trash-o" onClick=" eliminarMetaPrincipal ('<?php echo $meta->getMetaIndicadorPlanDesarrolloId() ; ?>' , '<?php echo $indicador->getIndicadorPlanDesarrolloId( );?>') ">Eliminar</button>
			</td>
                        <?php        
					  		}
                        }
                            /* FIN MODIFICACION */
                        ?>
			<!--<td>
				<button class="btn btn-warning btn-labeled fa fa-trash" onClick="verPlan('<?php echo $meta->getMetaIndicadorPlanDesarrolloId() ; ?>')">Eliminar</button>
			</td>-->
		</tr>
		<?php
			$metasSecundarias=null;
			$metasSecundarias=$meta->getMetasSecundarias();
			
			if( !empty( $metasSecundarias ) ){
				$tipoOperacion = "verDetalle";
			?>
			<tr>
                            <td colspan="7">
                                    <?php
                                    /*
                                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                                     * Se Modifica el titulo Metas Anuales por Avances Anuales
                                     * @since  January 02, 2017
                                    */
                                    //<h3>Metas Anuales</h3>
                                    ?>
                                    <h3>Avances Anuales</h3>

                                    <?php 
                                     $calculoAvances = $meta->getAlcanceMeta() - $acumuladoMeta;
                                     if($calculoAvances > 0 ){

                                            echo '<p><strong>Valor pendiente para alcanzar su meta:'.$calculoAvances.'<strong></p>';
                                     }

                                     /*Fin Modificacion*/ ?>
                                    <table cellpadding="0" cellspacing="0" border="1" width="100%">
                                            <thead>
                                                    <tr>
                                                            <th>No.</th>
                                                            <th>Nombre Meta Anual</th>
                                                            <!--<th>Valor Año</th>-->
                                                            <th>Avance Esperado</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Fecha Fin</th>
                                                            <th>Responsable</th>
                                                            <th colspan="4"></th>
                                                    </tr>
                                            </thead>
                                            <tbody class="listaEstudiantes">
                                                    <?php

                                                    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                                     * se cambio de 90  dias a 180 dias segun solictud de planeacion 
                                                     * se crea funcion  actualizarCampos para permitir realizar modificaciones durante 180 dias
                                                     * Since March 30 , 2017
                                                     * */

                                                    function actualizarCampos( $fechaCreacion ){
                                                            $fechaActual=date('Y-m-d');		
                                                            $datetime1 = new DateTime( $fechaCreacion );
                                                            $datetime2 = new DateTime( $fechaActual );
                                                            $interval = $datetime1->diff($datetime2);
                                                            return $interval->format('%a');
                                                            }
                                                    // fin modificacion

                                        foreach( $metasSecundarias as $k2 => $metaSec ) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $k2+1; ?></td>
                                                    <td><?php echo $metaSec->getNombreMetaSecundaria( ); ?></td>
                                                    <?php
                                                    /*
                                                     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                                                     * Se Modifica el valor mostrado $metaSec->getAvanceResponsableMetaSecundaria() por $metaSec->getValorMetaSecundaria()
                                                     * @since  January 02, 2017
                                                    */
                                                    ?>
                                                    <!--<td><?php echo $metaSec->getAvanceResponsableMetaSecundaria(); ?>%</td>-->
                                                    <td><?php echo $metaSec->getValorMetaSecundaria( );
                                                            if( $tipoIndicador == 1 ){

                                                            } else {
                                                                    echo '%';
                                                            }?>
                                                    </td>
                                                    <td><?php echo date('Y-m-d', strtotime( $metaSec->getFechaInicioMetaSecundaria() ) ); ?></td>
                                                    <td><?php echo date('Y-m-d', strtotime( $metaSec->getFechaFinMetaSecundaria() ) ); ?></td>
                                                    <?php 
                                                     $fechaCreacion = substr( $metaSec->getFechaCreacion( ),0,10 );
                                                     $diferenciaFecha = actualizarCampos( $fechaCreacion );
                                                     $fechaFin = substr( $metaSec->getFechaFinMetaSecundaria( ),0,10 );

                                                     $colspan = 0;

                                                     if( $diferenciaFecha > 360 and $numeroAvances == 1 ) {
                                                         $colspan = 3;
							} 
						    ?>

                                                    <td colspan="<?php echo $colspan; ?>"><?php echo $metaSec->getResponsableMetaSecundaria(); ?></td>
                                                    <!--<td>
                                                            <button class="btn btn-warning btn-labeled fa fa-search" onClick="verPlan('<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>', '<?php echo $tipoOperacion; ?>')" >Detalle</button>
                                                    </td>-->
                                     <?php
                                     /*
                                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                                     * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
                                     * con los modulos y donde se van a registar
                                     * @since  marzo 21, 2017
                                     */
                                     
                                     /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                                      *Se añade opcion a rol 101(planeacion) editar y eliminar avances sin tener encuenta restriccion de tiempo
                                      * Since October 12 ,2018
                                      */
                                       if( $diferenciaFecha > 360 and $lrol <>101 ) {

                                        } else { 

                                         if( $permisoEditar ){
                                            /* 93 decano
                                            * 98 Director de Facultad
                                            * 99 Coordinador de Facultad
                                            * 102 apoyo decano
                                            * 101 planeacion
                                            */

                                              if( $lrol ==  93 or $lrol == 99 or $lrol == 98 or $lrol == 102 or $lrol == 101 ){
                                     ?>
                                        <td>
                                                        <?php 	

                                                        if( $diferenciaFecha > 360 and $lrol <>101  ) {

                                                                } else {
                                                        ?>
                                                                <button class="btn btn-warning btn-labeled fa fa-pencil-square-o" 
                                                                        onClick="actualizarMetaSecundaria('<?php echo $meta->getMetaIndicadorPlanDesarrolloId() ; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>')">
                                                                        Editar
                                                                </button>
                                                <?php 
                                                                }
                                                } ?>
                                        </td>
                                      <?php        
                                      	}
                                        /* FIN MODIFICACION */
                                       if ( $permisoEliminar ) {

                                         ?>
                                            
                                           <td>
                                            <?php 
                                                /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                                                *Se añade opcion a rol 101(planeacion) editar y eliminar avances sin tener encuenta restriccion de tiempo
                                                * Since October 12 ,2018
                                                */
                                               if( $diferenciaFecha > 360 and $lrol <>101  ) {

                                                    } else {
                                            ?>
                                             <button class="btn btn-warning btn-labeled fa fa-trash" onClick="eliminarMetaSecundaria('<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId() ; ?>')">Eliminar</button>
                                            <?php 
                                                    }
                                            ?>
                                            </td>
                                           <?php }
                                           }
                                           ?>
                                           </tr>
                                   <?php
                                   }
                                   ?>
						</tbody>
					</table>
					<br />
					<br />
				</td>
			</tr> 
			<?php
			}//End if !empty metas secundarias  
		}
		?>
	</tbody>
</table>
