<?php
      /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors','On');

session_start( );


include '../tools/includes.php';

//include '../control/ControlRol.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlReferencia.php';
include '../control/ControlTipoGrado.php';
include '../control/ControlDocumentoDuplicado.php';


    if($_POST){
            $keys_post = array_keys($_POST);
            foreach ($keys_post as $key_post) {
              $$key_post = strip_tags(trim($_POST[$key_post]));
            }
    }

    if($_GET){
            $keys_get = array_keys($_GET); 
            foreach ($keys_get as $key_get){ 
                    $$key_get = strip_tags(trim($_GET[$key_get])); 
             } 
    }

    if( isset ( $_SESSION["datoSesion"] ) ){
            $user = $_SESSION["datoSesion"];
            $idPersona = $user[ 0 ];
            $luser = $user[ 1 ];
            $lrol = $user[3];
            $persistencia = new Singleton( );
            $persistencia = $persistencia->unserializar( $user[ 4 ] );
            $persistencia->conectar( );
    }else{
            header("Location:error.php");
    }


    $controlReferencia = new ControlReferencia( $persistencia );
    $controlTipoGrado = new ControlTipoGrado( $persistencia );

    $tipoReportes = $controlReferencia->consultar( );

    $controlPeriodo = new ControlPeriodo( $persistencia );
    $controlFacultad = new ControlFacultad( $persistencia );

    $periodos = $controlPeriodo->consultar( );
    $tipoGrados = $controlTipoGrado->consultarTipoGrado( );
    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se añade validacion de rol 92 (usuario egresados )para realizar consulta todas las facultades
     *Since May 9 ,2018
     */
    if( $lrol != "25" && $lrol != "53" && $lrol != "92" ){
        $facultades = $controlFacultad->consultar($idPersona);
    } else {
        $facultades = $controlFacultad->consultarFacultad( );
    }

    $cuenta = count($facultades);
    if( !isset($txtCodigoReferencia) ){

    ?>
        <div id="dvReporte" style="display: block;" >
        <script src="../js/MainReportes.js"></script>
        <form id="formReporte">
            <fieldset>
            <legend align="right">Tipo de Reportes</legend>
            <div style="margin:10px; text-align: left;">
                <div style="margin: 30px;">
                        <span>Por favor seleccione el tipo de reporte:</span>
                </div>
                <dl style="margin: 30px;">
                    <dt style="font-size: 12px; ">Reportes</dt>
                    <dd>
                    <?php 
                        $i = 1;
                        foreach( $tipoReportes as $tipoReporte ) {
                         ?>	
                            <span>▸</span>&nbsp;&nbsp;<button id="btnTipoReporte<?php echo $tipoReporte->getCodigoReferencia( ); ?>" name="btnTipoReporte<?php echo $tipoReporte->getCodigoReferencia( ); ?>" class="btnTipoReporte" value="<?php echo $tipoReporte->getCodigoReferencia( ); ?>" style="cursor: pointer;"><?php echo $tipoReporte->getNombreReferencia( ); ?>
                            </button><br /><br />
                    <?php 
                        }
                    ?>
                    </dd>
                </dl>
            </div>
            </fieldset>
        </form>
        </div>
    <?php 

    } else {
    ?>
	<script src="../js/MainReportes.js"></script>
	<div id="dvBotonVolver" align="right">
		<a id="btnVolver" style="cursor: pointer;" ><img src="../css/images/arrow_left.png" height="20" width="20" /></a>
	</div>
	<input type="hidden" id="txtCodigoReferencia" name="txtCodigoReferencia" value="<?php echo $txtCodigoReferencia; ?>" />
	<?php
	
	switch( $txtCodigoReferencia ){

            case "1":
            case "2":
            case "3":
            case "4":
            case "9":
        ?>
            <div id="dvTipoReporte">
                <script src="../js/MainTipoReporte.js"></script>
                <form id="formTipoReporte"  target="_blank">
                    <p>
                        <input type="hidden" id="tipoOperacion" name="tipoOperacion" value="exportar" />
                        <input type="hidden" id="txtCodigoReferencia" name="txtCodigoReferencia" value="<?php echo $txtCodigoReferencia; ?>" />
                        <input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
                        <input type="hidden" id="txtCuentaFacultad" name="txtCuentaFacultad" value="<?php echo $cuenta; ?>"
                    </p>
                    <fieldset>
                        <legend>Requisitos de Cumplimiento</legend>
                        <br />
                        <table width="100%" border="0">
                                <tr valign="top">
                                    <td>
                                        <fieldset>
                                            <legend>Consultar Detalle Paz y Salvo Estudiantes</legend>
                                            <br />
                                            <table width="100%">
                                                    <tr>
                                                        <td id="tdFacultadTReporte">Facultad</td>
                                                        <td id="tdCmbFacultadTReporte" >
                                                                <select id="cmbFacultadTReporte" name="cmbFacultadTReporte" class="campobox">
                                                                    <option value="-1">Seleccione la Facultad</option>
                                                                    <?php 
                                                                        foreach ( $facultades as $facultad ) {?>
                                                                            <option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
                                                                    <?php 
                                                                        }
                                                                    ?>
                                                                </select>
                                                        </td>
                                                        <td>Programa</td>
                                                        <td>
                                                            <select id="cmbCarreraTReporte" name="cmbCarreraTReporte" class="combobox">
                                                                <option value="-1">Seleccione la Carrera</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Período</td>
                                                        <td>
                                                            <select id="cmbPeriodoTReporte" name="cmbPeriodoTReporte" class="combobox">
                                                                <option value="-1">Seleccione el Período</option>
                                                                <?php 
                                                                     foreach ( $periodos as $periodo ) {?>
                                                                        <option value="<?php echo $periodo->getCodigo( ); ?>"><?php echo $periodo->getNombrePeriodo( ) ;?></option>
                                                                <?php 
                                                                     }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>Tipo Grado</td>
                                                        <td>
                                                            <select id="cmbTipoGradoTReporte" name="cmbTipoGradoTReporte" class="campobox">
                                                                <option value="-1">Seleccione el Tipo de Grado</option>
                                                                <?php 
                                                                  foreach ( $tipoGrados as $tipoGrado ) {?>
                                                                        <option value="<?php echo $tipoGrado->getIdTipoGrado( ); ?>"><?php echo $tipoGrado->getNombreTipoGrado( );?></option>
                                                                <?php 
                                                                  }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                            </table>
                                            <br />
                                        </fieldset>
                                    </td>
                                </tr>
                        </table>
                        <br />
                    </fieldset>
                    </br>
                    <div align="left"><a id="btnBuscarTReporte">Consultar</a>
                        <a id="btnRestaurarTReporte">Restaurar</a>
                        <input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
                        <?php 
                            if($txtCodigoReferencia <> 9){ 
                        ?>
                                  <input type="submit" id="btnExportarRGradoPDF" value="Exportar PDF" onclick="this.form.action='../servicio/pdf.php'"/>  
                         <?php 
                                }
                            if( $txtCodigoReferencia == 4 ) {
                        ?>
                                <a id="btnGenerarCarta">Generar Carta</a>
                        <?php	
                            }
                            if( $txtCodigoReferencia == 1){
                        ?>
                               <a id="btnGenerarCertificados">Certificados de notas</a>
                        <?php 
                            }
                        ?>
                    </div>
                </form>
                </br>
                <div style="overflow: auto; width: 100%; top: 0px; height: 100%px">
                    <table width="100%" >
                            <tbody id="TablaTipoReporte">
                            </tbody>
                    </table>
                    <br />
                </div>
            </div>

        <?php 
            break; 

            /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
            *Se añade case 7 -- hace referencia al nuevo registro en la tabla ReferenciaGrado para identificar el reporte de indexacion
            *Since january 29 , 2018
            */
            case "7":
            //case "8":
        ?>
            <div id="dvTipoReporte">
                <script src="../js/MainTipoReporte.js"></script>
                <form id="formTipoReporte"  target="_blank">
                    <p>
                        <input type="hidden" id="tipoOperacion" name="tipoOperacion" value="exportar" />
                        <input type="hidden" id="txtCodigoReferencia" name="txtCodigoReferencia" value="<?php echo $txtCodigoReferencia; ?>" />
                        <input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
                        <input type="hidden" id="txtCuentaFacultad" name="txtCuentaFacultad" value="<?php echo $cuenta; ?>"
                    </p>
                        <fieldset>
                            <legend>Requisitos de Cumplimiento</legend>
                            <br />
                            <table width="100%" border="0">
                                <tr valign="top">
                                    <td>
                                        <fieldset>
                                        <legend>Consultar Detalle Paz y Salvo Estudiantes</legend>
                                        <br />
                                        <table width="100%">
                                            <tr>
                                                <td id="tdFacultadTReporte">Facultad</td>
                                                <td id="tdCmbFacultadTReporte" ><select id="cmbFacultadTReporte" name="cmbFacultadTReporte" class="campobox">
                                                        <option value="-1">Seleccione la Facultad</option>
                                                        <?php 
                                                        foreach ( $facultades as $facultad ) {?>
                                                                <option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
                                                        <?php }?>
                                                        </select>
                                                </td>
                                                <td>Programa</td>
                                                <td><select id="cmbCarreraTReporte" name="cmbCarreraTReporte" class="combobox">
                                                                <option value="-1">Seleccione la Carrera</option>
                                                                <option value="pregrados">TODOS LOS PROGRAMAS DE PREGRADO</option>
                                                                <option value="posgrados">TODOS LOS PROGRAMAS DE POSGRADO</option>
                                                        </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Período</td>
                                                <td><select id="cmbPeriodoTReporte" name="cmbPeriodoTReporte" class="combobox">
                                                        <option value="-1">Seleccione el Período</option>
                                                        <?php 
                                                        foreach ( $periodos as $periodo ) {?>
                                                                <option value="<?php echo $periodo->getCodigo( ); ?>"><?php echo $periodo->getNombrePeriodo( ) ;?></option>
                                                        <?php }?>
                                                        </select>
                                                </td>
                                                <td>Tipo Grado</td>
                                                <td><select id="cmbTipoGradoTReporte" name="cmbTipoGradoTReporte" class="campobox">
                                                        <option value="-1">Seleccione el Tipo de Grado</option>
                                                        <?php 
                                                        foreach ( $tipoGrados as $tipoGrado ) {?>
                                                                <option value="<?php echo $tipoGrado->getIdTipoGrado( ); ?>"><?php echo $tipoGrado->getNombreTipoGrado( );?></option>
                                                        <?php }?>
                                                        </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <br />
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </fieldset>
                        </br>
                          <div align="left"><a id="btnBuscarTReporte">Consultar</a>
                                <a id="btnRestaurarTReporte">Restaurar</a>
                                <input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
                          </div>
                </form>
            </br>
            <div style="overflow: auto; width: 100%; top: 0px; height: 100%px">
            <table width="100%" >
                    <tbody id="TablaTipoReporte">
                    </tbody>
            </table>
            <br />
            </div>
            </div>	
    <?php 
        break;
        
          case '8':
                ?>
        <div id="diplomasduplicados">
        <script src="../js/MainTipoReporte.js"></script>  
           <?php
           $duplicado =new ControlDocumentoDuplicado($persistencia);
           $lista = $duplicado ->listar();
           
            echo " <div style=\"
                  width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
                <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
                    <thead>
                        <tr >
                            <th style=\"width: 5%;\" >No</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Nombre</th>
                            <th>Registro Grado</th>
                            <th>Carrera</th>
                            <th>Periodo</th>
                            <th>Diploma Anterior</th>
                            <th>Diploma Nuevo</th>
                        </tr>
                    </thead>
                <tbody class=\"listaEstudiantes\">";
            $contador=1;
            foreach ($lista as $listado){
              echo "<tr>"
                      . "<td>".$contador."</td>"
                      . "<td>".$listado->getReferenciaGrado()->documento."</td>"
                      . "<td>".$listado->getReferenciaGrado()->numeroDocumento."</td>"
                      . "<td>".$listado->getReferenciaGrado()->nombre."</td>"
                      . "<td>".$listado->getRegistroGrado()."</td>"
                      . "<td>".$listado->getReferenciaGrado()->carrera."</td>"
                      . "<td>".$listado->getReferenciaGrado()->periodo."</td>"
                      . "<td>".$listado->getReferenciaGrado()->diplomaAntiguo."</td>"
                      . "<td>".$listado->getNumeroDiploma()."</td>"
                    . "</tr>";      
                
             $contador++;       
                }
                echo "</tbody></table></div>";
                break; 
                
	}
          
    } ?>

<div id="dvResultado"></div>
