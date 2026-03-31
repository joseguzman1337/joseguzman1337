<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

ini_set('display_errors','On');

session_start( );
/*
 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
 * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
 * con los modulos y donde se van a registar
 * @since  marzo 21, 2017
*/
require_once('../../../assets/lib/Permisos.php');
$permisoInsertar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "insertar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "insertar");
/* FIN MODIFICACION */
include '../tools/includes.php';



//include '../control/ControlRol.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlLineaEstrategica.php';
/*include '../control/ControlTipoIndicador.php';*/

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

$txtIdPlanDesarrollo= intval($_GET["idPlanDesarrollo"]);

$controlPlanDesarrollo = new ControlPlanDesarrollo( $persistencia );
//$planDesarrollo = $controlPlanDesarrollo->buscarFacultadesPlanDesarrollo( $txtCodigoFacultad );



$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia );
//$controlTipoIndicador = new ControlTipoIndicador( $persistencia );

$lineaEstrategicas = $controlLineaEstrategica->consultarLineaEstrategica( );
//$tipoIndicadores = $controlTipoIndicador->consultarTipoIndicadores( );

$controlFacultad = new ControlFacultad( $persistencia );
if( isset( $txtCodigoFacultad ) && $txtCodigoFacultad != "" ){
	
//
    if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10"){
         $planDesarrollo = $controlLineaEstrategica->consultarFacultades();
    }
    else{
         $planDesarrollo = $controlFacultad->buscarFacultadId( $txtCodigoFacultad );	
    }

    $controlCarrera = new ControlCarrera( $persistencia );
    $carreras = $controlCarrera->consultar( $txtCodigoFacultad );
}

?>
  <script>
        $(document).ready(function (){
          $('.campoNumeros').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });
   </script>

<script src="../js/MainRegistrar.js"></script>
<div align="right">
	<a href="#"  id="btnRegresar"><img src="../css/images/arrow_leftAzul.png" class="imgCursor" height="20" width="20" /><strong >Regresar al menu</strong></a>
</div>
<br />
<form id="formRegistrar" >
<p>
    <input type="hidden" id="txtIdPlanDesarrollo" name="txtIdPlanDesarrollo" value="<?php echo $txtIdPlanDesarrollo; ?>" />
    <input type="hidden" id="tipoOperacion" name="tipoOperacion" value="registrar" />
</p>
    <fieldset>
        <legend>Registrar Plan de Desarrollo</legend>
        <table width="100%" border="0">
            <tr>
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="27%">Facultad</td>
                            <td width="73%">
                            <?php 
                            if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10" ){
                            ?>
                                    <select id="cmbFacultadPlanDesarrollo" name="cmbFacultadPlanDesarrollo"  >
                                        <option value="-1">Seleccionar</option>
                                    <?php
                                      if($lrol == 101){
                                    ?>        
                                        <option value="10000">Plan Desarrollo Institucional</option>
                                    <?php 

                                      } else {

                                      }
                                    ?>
                                    <?php  	
                                        $no_permitidas= array ("Ñ","Á","É","Í´","Ó","Ú");
                                        $permitidas = array("ñ","á","é","í","ó","ú");

                                        foreach( $planDesarrollo as $verFa){ 
                                    ?>
                                         <option value="<?php  echo $verFa->getCodigoFacultad();?>"><?php  echo str_replace($no_permitidas,$permitidas,ucwords(strtolower ($verFa->getNombreFacultad())));?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                            <?php 
                                } else {
                                        $no_permitidas= array ("Ñ","Á","É","Í´","Ó","Ú");
                                        $permitidas = array("ñ","á","é","í","ó","ú");
                             ?>
                                    <select id="cmbFacultadPlanDesarrollo" name="cmbFacultadPlanDesarrollo"  >
                                        <option value="-1">Seleccionar</option>
                                        <option value="<?php echo $planDesarrollo->getCodigoFacultad( ); ?>"><?php echo str_replace($no_permitidas,$permitidas,ucwords(strtolower ($planDesarrollo->getNombrefacultad( )))) ;?></option>
                                    </select>
                            <?php
                                  }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <?php 
                        /*
                        * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                        * se modifica combo para que cargue planes de desarrollo de las facultad seleccionada
                        * @since  March 03, 2017
                        */
                        ?>
                        <tr>
                            <td width="27%">Programa Académico</td>
                            <td width="73%">
                                <select id="cmbCarreraRegistrar" name="cmbCarreraRegistrar" >
                                    <option value="-1">Seleccionar</option>
                                </select>
                            </td>
                        </tr>
                        <?php // fin modificacion?>   
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                            
                        <tr>
                            <td width="27%">Línea Estratégica</td>
                            <td width="73%">
                                <select id="cmbLineaEstrategica" name="cmbLineaEstrategica" >
                                    <option value="-1">Seleccionar</option>
                                    <?php foreach( $lineaEstrategicas as $lineaEstrategica ){?>
                                    <option value="<?php echo $lineaEstrategica->getIdLineaEstrategica( ); ?>"><?php echo $lineaEstrategica->getNombreLineaEstrategica( ); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                  <div id="dvPrograma">
                    <table width="100%" border="0">
                        <tr>
                            <td width="27%">Programa</td>
                            <td width="73%"><input type="text" id="txtPrograma" name="txtPrograma" /><img id="addPrograma" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    
                    <table width="100%" border="0">
                    	<tr>
                            <td>
                                <div id="dvDetallePrograma" style="display: none;">
                                    <fieldset>
                                    <legend>Detalles Programa</legend>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="23%"><span>Justificación:</span></td>
                                            <td width="67%"><textarea id="justifiPrograma" name="justifiPrograma" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><span>Descripción:</span></td>
                                            <td><textarea id="descPrograma" name="descPrograma" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
					</tr>
					<tr>
                                            <td><span>Email:</span></td>
                                            <td>
                                                <div id="responsableProgramaEmail">
                                                    <input type="text" id="txtResponsableProgramaEmail" name="txtResponsableProgramaEmail" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
					    <td>&nbsp;</td>
					</tr>

                                        <tr>
                                            <td><span>Responsable:</span></td>
                                            <td>
                                                <div id="responsablePrograma">
                                                        <input type="text" id="txtResponsablePrograma" name="txtResponsablePrograma" />
                                                        <!--<img id="addResponsablePrograma" class="addResponsable" src="../css/images/add2.png" width="16" height="16" />
                                                        <img id="deleteResponsablePrograma" class="addResponsable" src="../css/images/deletePD.png" width="16" height="16" />-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
					</tr>
                                    </table>
                                    </fieldset>
                                </div>
                            </td>
			</tr>
                    </table>
                    <div id="dvProyecto">
                    <table width="100%" border="0">
                        <tr>
                            <td width="23%"><span>Proyecto:</span></td>
                            <!--
                             /*Modified Diego Fernando Rivera <riveradiego@unbosque.edu.co>
                              *se cambia de ubicacion el boton <button id="btnAddProyecto" class="btn btn-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Proyecto</button>	
                               se deja al final de la pagina
                              *Since April 18 , 2017 
                            -->
                            <td width="63%"><input type="text" id="txtProyecto" name="txtProyecto[]" /><img id="addProyecto" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /></td>
                        </tr>
                        <tr>
                        	<td>&nbsp;</td>
                        </tr>
                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td>
                                <div id="dvDetalleProyecto" style="display: none;">
                                <fieldset>
                                <legend>Detalles Proyecto</legend>
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="23%"><span>Justificación:</span></td>
                                        <td width="77%"><textarea id="justifiProyecto" name="justifiProyecto[]" rows="3"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><span>Descripción:</span></td>
                                        <td><textarea id="descProyecto" name="descProyecto[]" rows="3"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><span>Objetivos:</span></td>
                                        <td><textarea id="objProyecto" name="objProyecto[]" rows="3"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><span>Acciones:</span></td>
                                        <td><textarea id="accProyecto" name="accProyecto[]" rows="3"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td><span>Email:</span></td>
                                        <td>
                                                <div id="contenedorResponsableEmail">
                                                        <input type="text" id="txtResponsableProyectoEmail" name="txtResponsableProyectoEmail[]" />
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><span>Responsable:</span></td>
                                        <td>
                                            <div id="contenedorResponsable">
                                                    <input type="text" id="txtResponsableProyecto" name="txtResponsableProyecto[]" />
                                                    <!--<img id="addResponsableProyecto" class="addResponsable" src="../css/images/add2.png" width="16" height="16" />
                                                    <img id="deleteResponsableProyecto" class="addResponsable" src="../css/images/deletePD.png" width="16" height="16" />-->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                </fieldset>
                                </div>
                            </td>
			</tr>
                    </table>
                        <div id="dvIndicador">
                        <table width="100%" border="0">
                            <tr>
                               <div class="strike" ><span><strong>Indicadores</strong></span></div>
                                <td width="27%">Tipo Indicador:</td>
                                <td width="35%"><input type="radio" id="ckTipoIndicadorCuantitativo" name="ckTipoIndicador[0][]" value="1" />Cuantitativo</td>
                                <td width="38%"><input type="radio" id="ckTipoIndicadorCualitativo" name="ckTipoIndicador[0][]" value="2" />Cualitativo<button id="btnAddIndicador" class="btn btn-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Indicador</button></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
	                    </tr>
                        </table>
                        <table width="100%" border="0">
                            <tr>
                                <td width="27%">Indicador</td>
                                <td width="73%"><input type="text" id="txtIndicador" name="txtIndicador[0][]" /><img id="addMeta" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /><!--<a id="btnMetaPrincipal" class="btnMetaPrincipal">+ Meta Principal</a>--></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
	                    </tr>
                        </table>
                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <div id="detalleIndicador" class="dvDetalleIndicador" style="display: none;">
                                        <fieldset>
                                            <legend>Metas Indicador</legend>
                                            <div id="dvMetaIndicador" class="dvMetaIndicador">
                                                <br />
	                                        <table width="100%" border="0">
                                                    <tr>
                                                        <td width="30%">Meta Principal</td>
                                                        <td width="70%"><input type="text" id="txtMetaPrincipal" name="txtMetaPrincipal[0][]" style="width: 600px" /> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vigencia</td>
                                                        <?php
                                                        /*
                                                         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                                                         * Se cambia el valor de la vigencia de la meta de 2021 por 2026
                                                         * @since  January 02, 2017
                                                        */
                                                        /*
                                                         * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                                                         * Se cambia el valor de la vigencia de la meta de 2026 por 2021
                                                         * @since  February 21, 2017
                                                        */
                                                        //<td><input type="text" id="txtVigenciaMetaPrincipal" name="txtVigenciaMetaPrincipal[0][]" value="2021" /> </td>
                                                        ?>
                                                        <td><input type="text" class="campoNumeros" id="txtVigenciaMetaPrincipal" name="txtVigenciaMetaPrincipal[0][]" value="2021" style="width: 100px" /> </td>
                                                        <?php /*Fin Modificacion*/ ?>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Valor Meta</td>
                                                        <td><input type="text" class="campoNumeros" id="txtValorMetaPrincipal" name="txtValorMetaPrincipal[0][]"  style="width: 100px"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
	                                        </table>
                                                <legend>Avances Anuales</legend>
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td width="27%">Meta Secundaria:</td>
                                                        <td width="73%" ><input type="text" id="txtMeta" name="txtMeta[0][0][]" style="width: 450px" /><button id="btnAddMeta" class="btnAddMeta btn btn-warning" ><i class="fa fa-plus-circle"></i> Meta</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
	                                        <table width="75%" border="0">
                                                    <tr>
                                                        <td width="195">Fecha Inicio: </td>
                                                        <td width="144"><input type="text" id="txtFechaInicioMeta" name="txtFechaInicioMeta[0][0][]" /></td>
                                                        <td width="92">Fecha Final: </td>
                                                        <td width="144"><input type="text" id="txtFechaFinalMeta" name="txtFechaFinalMeta[0][0][]" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
	                                        </table>
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td width="195">Avance Esperado:</td>
                                                        <td width="388"><input type="text" class="campoNumeros" id="txtValorMeta" name="txtValorMeta[0][0][]" style="width: 100px"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Acciones:</td>
                                                        <td><textarea id="txtAccionMeta" name="txtAccionMeta[0][0][]" rows="3" style="width: 550px"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="195">Email:</td>
                                                        <td width="388"><input type="text" id="txtResponsableMetaEmail" name="txtResponsableMetaEmail[0][0][]" style="width: 550px" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="195">Responsable:</td>
                                                        <td width="388"><input type="text" id="txtResponsableMeta" name="txtResponsableMeta[0][0][]" style="width: 550px" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>													
                                            </div>
                                            <div id="dvAgregarMeta" class="dvAgregarMeta"></div>
                                        </fieldset>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                  </div>
                </td>
            </tr>
        </table>
    </fieldset>
</form>
<br />
<br />
<br />
<div><button id="btnAddProyecto" class="btn btn-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Proyecto</button></div>
<div>
	<br />
	<br />
	<br />
    <?php
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
         * con los modulos y donde se van a registar
         * @since  marzo 21, 2017
        */
        if( $permisoInsertar ){
        	/* 93 rol decano
        	 101 rol planeacion
        	 102 rol apoyo decano
        	*/
        	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
			 *se quita opcion de guardar solicita Claudia Neisa 
			 * if( $lrol ==  93 or $lrol == 101 or $lrol == 102  ){
			 * Since July 4,2017
			 * */
        	
			if( $lrol == 101   ){
    ?>
        		<button id="btnRegistrarPlan" class="btn btn-warning">Guardar</button>
    <?php        
			}
        }
        /* FIN MODIFICACION */
    ?>
	<button id="btnRestaurar" class="btn btn-warning">Cancelar</button>
</div>
<br />
