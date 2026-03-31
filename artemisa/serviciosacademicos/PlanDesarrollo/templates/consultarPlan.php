<script src="../tema/jquery.validate.js"></script>
<?php 

$porcentaje = "";
$tipoOperacion = "registrarAvance"; 
$avanceIndicador = "VerEvidencia";
$facultadPlan = $txtCodigoFacultad;

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
require_once('../control/controlAvancesIndicadorPlanDesarrollo.php');
$controlAvancesIndicadorPlanDesarrollo = new controlAvancesIndicadorPlanDesarrollo( $persistencia );
?>

<?php 
/*modified Diego Rivera <riveradiego@unbosque.edu.co>
 *se añade validacion campo numerico en avance
 * since march 21,2017 
 */
?>
<script>
	$(document).ready(function(){
    	$('[data-toggle="tooltip"]').tooltip();   
	});
	
</script>
<?php
//fin modificacion
?>
<div class="panel panel-default" style="background-color: #eff2dc !importan;">
    <div class="panel-heading"> 
        <?php
            $facultad = ucwords(strtolower( $facultades ));
            $carrera = ucwords(strtolower( $carreras ));
            $linea = ucwords(strtolower( $lineas ));
            $programa = ucwords(strtolower( $programas ));
            $proyectos = ucwords(strtolower( $proyectos ));
            $ruta = $facultad.' / '.$carrera.' /<strong>Línea estratégica</strong> / '.$linea.' / <strong>Programa</strong> / '.$programa .' / <strong>Proyecto</strong> /'.$proyectos.'<br>';
        ?>
        <strong>Ruta :</strong> <?php echo $ruta; ?></br>
        <strong>Responsable :</strong> <?php echo ucwords(strtolower( $proyecto->getResponsableProyecto()));?> </br>
    </div>
    <?php
    /*
     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se Modifica presentacion se elimana presentacion metas tipo de indicador , de añade boton ver evidencias 
     * @since February  20, 2017
    */
    ?>
    <div class="panel-body ">
    <?php 
    /*
     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
     * se elimina titulo avances anuales solicito Ivan
     * @since  January 02, 2017
    */
    ?>

    <?php
    $numerador = 0;
    foreach ( $metas as $k => $meta ) {
            unset( $indicador );
            /* modified diego rivera <riveradiego@unbosque.edu.co>
             * se hace llamado   el id y el nombre de la meta $metaIndicadorPlanDesarrollo = $meta->getMetaIndicadorPlanDesarrolloId(); 
               $nombreMetaPlanDesarrollo = $meta->getNombreMetaPlanDesarrollo();
             *  Since  March 17,2017
             */
            $metaIndicadorPlanDesarrollo = $meta->getMetaIndicadorPlanDesarrolloId( ); 
            $nombreMetaPlanDesarrollo = $meta->getNombreMetaPlanDesarrollo( );
            $indicador = $meta->getIndicador( );
            $alcance =  $meta->getAlcanceMeta( );
            //fin
    ?>
        <!--<tr><td class="col-md-12">-->
    <?php

    /*
     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se Modifica metas secundarias solo se deben consultar los indicadores del plan de desarrollo  este cambio se realiza segun reunion con Leyla  e Ivan
     * @since  January 02, 2017
    */

    //$metasSecundarias=null;
    /*
     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
     * se activan nuevamente metas secundarias
     * @since  March 17, 2017
    */
    $metasSecundarias = $meta->getMetasSecundarias( );
    // fin 

     /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se inactivan condicion debido al cambio de estructura
     * Since march 17,2017
     */		
    ?>

        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                        <th colspan="9" class="col-md-12"><?php echo $numeradorMetaPrincipal = $k+1;?>. Meta Principal</th>
                </tr>

                <tr>
                        <td colspan="9" class="col-md-12"><?php echo $nombreMetaPlanDesarrollo;?></td>
                </tr>

                <tr>
                    <td colspan="9" class="col-md-12">
                    <div class="col-md-4"><strong>Vigencia : </strong><?php echo $meta->getVigenciaMeta( ); ?></div>
                    <div class="col-md-2" align="right"><strong>Alcance : </strong></div>
                    <div class="col-md-2" id="meta_<?php echo $metaIndicadorPlanDesarrollo; ?>" align="left">
                    <?php 
                    /*Modified Diego Rivera<riveradiego@<unbosque.edu.co>
                     *se agrega condicion con el fin de identificar si la meta principal tiene definido un alcance
                     *Since April 07,2017
                     * */	
                    $alcanceMetaPrincipal = $meta->getAlcanceMeta( ); 
                    $tipoIndicador = $indicador->getTipoIndicador( )->getIdTipoIndicador( ); 	
                            if ( $alcanceMetaPrincipal == 0 ) {
                                    echo 'Alcance sin definir';
                            } else {
                                    echo $alcanceMetaPrincipal;
                                    if( $tipoIndicador == 2){
                                            echo '%';
                                    }
                            } 
                    // fin modificacion	

                    ?>
                    </div>
                    <div class="col-md-2" align="right"><strong>Estado : </strong></div>
                    <div class="col-md-2">	
                    <?php  
                    $valorAvanceMetaPrincipal = $meta->getAvanceMetaPlanDesarrollo(); 

                    if ( $alcanceMetaPrincipal == 0 and $valorAvanceMetaPrincipal == 0 ) {

                            echo '<div data-toggle="tooltip" title="Bajo" style="background:red;" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">&nbsp</div>';

                    } else if ( $valorAvanceMetaPrincipal > $alcanceMetaPrincipal ) {

                            echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">&nbsp</div>';

                    } else if ( $alcanceMetaPrincipal == 0 ) {

                                    echo '<div data-toggle="tooltip" title="Bajo" style="background:red;" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">&nbsp</div>';

                    } else {
                        /*
                         * modified Diego Rivera<riveradiego@unbosque.edu.co>
                         * Se agrea valor numerico en los estados y se valida que el avance este aprobado
                         * Since March 27,2017
                         * */	
                        $ValorIndicadorMetaPrincipal = ( $valorAvanceMetaPrincipal * 100 ) / $alcanceMetaPrincipal;

                        if ($ValorIndicadorMetaPrincipal  > 100) {

                                echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">'.round($ValorIndicadorMetaPrincipal, 2, PHP_ROUND_HALF_ODD).'%</div>';

                        } else if ($ValorIndicadorMetaPrincipal  > 75 && $ValorIndicadorMetaPrincipal < 101) {

                                echo '<div data-toggle="tooltip" title="Muy alto" style="background:blue;color:white;text-align:center" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">'.round($ValorIndicadorMetaPrincipal, 2, PHP_ROUND_HALF_ODD).'%</div>';

                        } else if ($ValorIndicadorMetaPrincipal  > 50 && $ValorIndicadorMetaPrincipal <= 75) {

                                echo '<div data-toggle="tooltip" title="Alto" style="background:green;color:white;text-align:center" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">'.round($ValorIndicadorMetaPrincipal, 2, PHP_ROUND_HALF_ODD).'%</div>';

                        } else if ($ValorIndicadorMetaPrincipal  > 25 && $ValorIndicadorMetaPrincipal <= 50) {

                                echo '<div data-toggle="tooltip" title="Medio" style="background:yellow;color:black;text-align:center" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">'.round($ValorIndicadorMetaPrincipal, 2, PHP_ROUND_HALF_ODD).'%</div>';

                        } else if ($ValorIndicadorMetaPrincipal  < 26) {

                                echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center" id="valorIndicadorMeta_'.$metaIndicadorPlanDesarrollo.'">'.round($ValorIndicadorMetaPrincipal, 2, PHP_ROUND_HALF_ODD).'%</div>';
                        }
                    }

                    ?>
                    </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="9" class="col-md-12">
                    <div class="col-md-4"><strong>Tipo Indicador :</strong> 
                    <?php 
                          echo $indicador->getTipoIndicador( )->getNombreTipoIndicador( );
                    ?>
                    </div>

                    <div class="col-md-8">
                         <strong>Indicador : </strong> <?php echo ucfirst(strtolower($indicador->getNombreIndicador( ))); ?> 
                    </div>
                    </td>
                </tr>

                <?php 
                $rowPan = sizeof ( $metasSecundarias );

                if ( $rowPan > 0 ) {	
                ?>
                <tr>
                    <th class="col-md-1">No.</th>
                    <th class="col-md-1">Inicio</th>
                    <th class="col-md-1">Fin</th>
                    <th class="col-md-3">Meta Anual</th>
                    <th class="col-md-2">Acciones</th>
                    <th class="col-md-1">Alcance</th>
                    <th class="col-md-1">Avance</th>
                    <th class="col-md-1">Estado</th>	
                    <!-- 
                    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                     * se elimina titulo acciones de la tabla
                     * Since March 27,2017
                     */	
                     -->								
                    <th class="col-md-1">  <!-- Acciones--></th>
                    <!-- fin-->
                </tr>
            </thead>

            <tbody>
            <?php 

            /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
             *se crean variables $anioAcutal para identificar el año actual se extrae el año de incio y fin  de la metasecundaria con el fin 
              de solo visualizar metas secundarias que se encuentron con vigencia y finalizacion en el año en curso
             * Since March 29,2017
             */
            $anioActual = date('Y');
            $contadorMetaSecundaria = 1;

            /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
             *se crean variables $contadorMetaSecundariaAnioAcutual con el fin de identificar cuando la meta tiene metas secundarias pero no pertenecen al año y
             cuando la meto no tiene metas secundarias								 
             * Since March 29,2017
             */	
            $contadorMetaSecundariaAnioAcutual = 0;
            foreach ( $metasSecundarias as $k2 => $metaSec ) {

               $numerador++;
               $fechaInicio = substr($metaSec->getFechaInicioMetaSecundaria(),0,4);
               $fechaFIn = substr($metaSec->getFechaFinMetaSecundaria(),0,4);
               /*MOdified Diego Rivera<riveradiego@unbosque.edu.co>
               *is activate  year before  the currend year ,  
               *Since February 8 ,2018 
               */
               if ( ( $fechaInicio <= $anioActual ) or ( $fechaFIn == $anioActual ) ) {
                   $contadorMetaSecundariaAnioAcutual = $contadorMetaSecundariaAnioAcutual + 1 ;
            ?>
                    <tr>
                        <td style="vertical-align:middle;"><?php echo $contadorMetaSecundaria;?></td>
                        <td style="vertical-align:middle;"><?php echo substr($metaSec->getFechaInicioMetaSecundaria( ),0,10)?></td>
                        <td style="vertical-align:middle;"><?php echo  substr($metaSec->getFechaFinMetaSecundaria( ),0,10)?></td>
                        <td style="vertical-align:middle;"><?php echo $metaSec->getNombreMetaSecundaria( )?></td>
                        <td style="vertical-align:middle;"><?php echo $metaSec->getActividadMetaSecundaria( )?></td>
                        <td  style="vertical-align:middle;text-align: center" id="indicadoActual_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>">
                        <?php
                            /*Modified Diego Rivera<riveradiego@<unbosque.edu.co>
                             *se agrega condicion con el fin de identificar si la meta secundaria  tiene definido un alcance
                             *Since April 07,2017
                             * */	
                             $alcance = $metaSec->getValorMetaSecundaria( ); 

                             if ( $alcance == 0) {
                                   echo "Alcance sin definir";

                             } else {
                                echo $alcance;
                                if( $tipoIndicador == 2 ){
                                   echo '%';
                                 }

                             } 
                        ?>
                        </td>
                        <td  style="vertical-align:middle;text-align: center" id="avance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>">
                        <?php 

                            $avanceSinAprovacion = $controlAvancesIndicadorPlanDesarrollo->verEstadoAvanceId( $metaSec->getMetaSecundariaPlanDesarrolloId( ) );
                            $estadoSinAprovacion = $avanceSinAprovacion->getIndicadorPlanDesarrolloId();
                            $valorAvance = $metaSec->getAvanceResponsableMetaSecundaria();

                            if ( $valorAvance == "" ) {
                                echo "-";

                            } else {
                                echo $valorAvance.'%';
                            }

                            if ( $estadoSinAprovacion >0 ) {
                                echo '<br/>Existen Avances Pendiente por aprobar';
                            }
                        ?>
                        </td>
                        <td style="vertical-align:middle;">
                        <?php
                        if ( $alcance == 0 and $valorAvance == 0 ) {

                                echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">0%</div>';

                        } else if ( $valorAvance > 0 and $alcance == 0 ) {

                                echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">&nbsp</div>';

                        } else if ( $alcance == 0){

                                echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">0%</div>';

                        } else {

                               $ValorIndicador = ( $valorAvance * 100 ) / $alcance;

                                if ( $ValorIndicador  > 100 ){

                                        echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">'.round($ValorIndicador, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                } else if ( $ValorIndicador  > 75 && $ValorIndicador < 101 ){

                                        echo '<div data-toggle="tooltip" title="Muy alto" style="background:blue;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">'.round($ValorIndicador, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                } else if ( $ValorIndicador  > 50 && $ValorIndicador <= 75 ){

                                        echo '<div data-toggle="tooltip" title="Alto" style="background:green;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">'.round($ValorIndicador, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                } else if ( $ValorIndicador  > 25 && $ValorIndicador <= 50 ){

                                        echo '<div data-toggle="tooltip" title="Medio" style="background:yellow;color:black;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">'.round($ValorIndicador, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                } else if( $ValorIndicador  < 26 ){

                                        echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center" id="valorIndicador_'.$metaSec->getMetaSecundariaPlanDesarrolloId().'">'.round($ValorIndicador, 2, PHP_ROUND_HALF_ODD).'%</div>';
                                }
                        }
                        ?>

                        </td>
                        <td style="vertical-align:middle;">
                        <?php 
                        $avancesRealizados = $controlAvancesIndicadorPlanDesarrollo->verAvancesIndicador( $metaSec->getMetaSecundariaPlanDesarrolloId() );
                        $registro = sizeof($avancesRealizados);
                        $contadorAprobacion = 0;

                        foreach ($avancesRealizados as $avance) {
                                $aprobacion = $avance->getAprobacion( );	
                        }

                        if ( $registro == 0 ) {
                         /* 93 rol decano
                         * 96 Coordinador de linea
                         * 98 Director de Facultad
                         * 99 Coordinador de Facultad
                         * 102 rol apoyo decano
                         * 3 Admon Facultades - Secretari@s Academic@s
                         */
                         /*Se añade validacion de rol planeacion para que puedan registrar avances de las metas*/
                            if( ($lrol == 101 or $lrol == 96) and $facultadPlan == "10000" ){
                                ?>
                                <button  id="btnRegistrarEvidenciaAvance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>" class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="registrarEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $tipoOperacion; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>','<?php echo $tipoIndicador?>','<?php echo $metaIndicadorPlanDesarrollo; ?>','<?php echo $alcance?>')" >
                                    Registrar Evidencias
                                </button><br><br>
                                <?php
                            }
                            if( $lrol == 99 or $lrol == 98 or $lrol == 93 or $lrol == 3 or $lrol == 102  ){
                                ?>
                                <button  id="btnRegistrarEvidenciaAvance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>" class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="registrarEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $tipoOperacion; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>','<?php echo $tipoIndicador?>','<?php echo $metaIndicadorPlanDesarrollo; ?>','<?php echo $alcance?>')" >
                                        Registrar Evidencias
                                </button><br><br>
                                <?php
                            }
                        } else if ( $aprobacion == 'No aprobado' ){
                            if( $lrol == 99 or $lrol == 98  or $lrol == 93 or $lrol == 3 or $lrol == 102  ){
                                ?>
                                <button  id="btnRegistrarEvidenciaAvance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>" class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="registrarEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $tipoOperacion; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>','<?php echo $tipoIndicador?>','<?php echo $metaIndicadorPlanDesarrollo; ?>')" >
                                        Registrar Evidencias
                                </button><br><br>
                                <?php
                            }

                            if(($lrol == 101 or $lrol == 96) and $facultadPlan == "10000"){
                                ?>
                                <button  id="btnRegistrarEvidenciaAvance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>" class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="registrarEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $tipoOperacion; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>','<?php echo $tipoIndicador?>','<?php echo $metaIndicadorPlanDesarrollo; ?>','<?php echo $alcance?>')" >
                                    Registrar Evidencias
                                </button><br><br>
                                <?php
                            }
                        } else {
                            if( $lrol == 99 or $lrol == 98 or $lrol == 93 ){
                                ?>
                                <div id="salto_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>"></div>
                                <button style="display: none" id="btnRegistrarEvidenciaAvance_<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>" class="btn btn-warning btn-labeled fa fa-pencil-square-o" onClick="registrarEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $tipoOperacion; ?>','<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>','<?php echo $tipoIndicador?>','<?php echo $metaIndicadorPlanDesarrollo; ?>')" >
                                    Registrar Evidencias
                                </button>
                                <?php
                            }
                        }
                        ?>
                            <!--
                            /*Se parametro <?php echo $metaIndicadorPlanDesarrollo?> el id de la meta princiapl
                             *Se parametro <?php echo $facultadPlan?> a el codigo de facultad referente al plan
                             *Se parametro <?php echo $lrol?> el codigo de rol referente al plan
                             *Se parametro <?php echo $registro?> el codigo de registro referente al plan
                             */
                             -->
                            <button class="btn btn-warning btn-labeled fa fa-eye" onClick="verEvidenciaPlan('<?php echo $proyecto->getProyectoPlanDesarrolloId() ?>' , '<?php echo $metaSec->getMetaSecundariaPlanDesarrolloId(); ?>' , '<?php echo $avanceIndicador; ?>' , '<?php echo $metaIndicadorPlanDesarrollo;?>' , '<?php echo $facultadPlan;?>')"  >
                              Visualizar Evidencia
                            </button>
                        </td>									
                    </tr>
            <?php 
                 $contadorMetaSecundaria++;
               } 
            }//fin foreach

            if ( $contadorMetaSecundariaAnioAcutual == 0 ) {
            ?>
                    <tr>
                        <td colspan="8"><h2 align="center">No tiene metas programadas para este año</h2></td>
                    </tr>
            <?php	
             } 
            ?>
            </tbody>
            <?php 
            } else {
            ?>
                    <tr>
                        <td><h2 align="center">No tiene metas programadas</h2></td>
                    </tr>	
            <?php	
            }
            ?>
            <br>
        </table>
    <!--
    /*
     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se Modifica presentacion se cambia forma en que se visualizan los datos de las metas principales ,secundarias y avanves 
     * @since February  20, 2017
    */-->
    <?php
    /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se inactivan condicion debido al cambio de estructura
     * Since march 17,2017
     */			
    }
    ?>
    </div>
</div>