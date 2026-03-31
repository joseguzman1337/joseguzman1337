<?php
    /*
     * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
     * @copyright Dirección de Tecnología Universidad el Bosque
     * actualizacion del proceso.
     */

    ini_set('display_errors','On');

    session_start( );
    require_once'../tools/includes.php';
    require_once '../control/ControlItem.php';
    require_once '../control/ControlPeriodo.php';
    require_once '../control/ControlLineaEstrategica.php';

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
?>

<script src="../js/MainGraficarIndicador.js"></script>


<div align="right">
	<a id="btnRegresar" href="#">
		<img src="../css/images/arrow_leftAzul.png" class="imgCursor" height="20" width="20" />
    	<strong>Regresar al menu</strong>
	</a>
</div>
	
<form id="formConsultar">
	<fieldset>
		<legend>INDICADORES GRAFICOS</legend>   
		<div class="row">		
			<div class="col-md-12">
				<label>Tipo de reporte:</label>
				<select id="selectTipoReporte" name="selectTipoReporte">
					<option value="0"></option>
					<?php
                                          /*
                                           * @Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                           * Se agrega validacion para visualizacion de reportes dependiendo el rol
                                           * rol 101 Planeacion
                                           * rol 96 oficina desarrollo (exito estudiantil)
                                           * rol 4 Administrador Credito y Cartera (recto y vicerecto)
                                           * Adicionalmente se agregan opcion 4 y 5 del select
                                           * Since July 26 , 2018
                                           */
					 if ( $lrol == 101 ){
					?>	
                                        <option value="1">Programas Academicos</option>	
					<option value="2">Líneas Estratégicas--Total</option>				
					<option value="3">Líneas Estratégicas--Detalle</option>
                                        <option value="4">Metas sin Avances Anuales Creados</option>
                                        <option value="5">Metas con alcance diferente al Alcance de los Avances</option>
                                        <?php 
					 }else
                                        /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                         *Se añade option 3 para reporte por linea estrategica
                                         *@Since May 7 , 2018
                                         */ 
                                         if ( $lrol == 96){
                                         ?>
                                        <option value="2">Líneas Estratégicas--Total</option>
                                        <option value="3">Líneas Estratégicas--Detalle</option>                                        
                                        <?php
                                         }else if ( $lrol == 4 ){
                                        ?>     
                                           <option value="1">Programas Academicos</option>
                                           <option value="2">Líneas Estratégicas--Total</option>				
                                           <option value="3">Líneas Estratégicas--Detalle</option>
                                        <?php
                                         } else {
                                         ?>
                                           <option value="1">Programas Academicos</option>
                                        <?php
                                         }
					?>
                                        
                                        
				</select>
			</div>	
		</div>
	</fieldset>
	<div class="clearfix"><br></div>
	<fieldset>
		<div class="row" id="formularioConsultas" style="display:none;">
			<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="consultar"/>			
			<div class="col-md-6 col-xs-12" id="SelectDatos">			
			</div>	
			<div class="col-md-3 col-xs-12" id="periodo" style="display:none">
                            <label>Periodo:</label>
				<select id="codigoperiodo" name="codigoperiodo">
					<option value="0">seleccionar</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
				</select>
			</div>
			<div class="col-md-3 col-xs-12">
				<button id="btnConsultarReporte" class="btn btn-warning">Consultar</button>
			</div>
		</div>
	</fieldset>	
</form>
<div class="clearfix"><br></div>
<fieldset>
	<div class="row" id="reportefacultades" style="display:none;">
	</div>
</fieldset>
<div class="clearfix"><br></div>
<fieldset>
	<div class="row" id="">	</div>
        <div id="msj" style="text-align: center"></div>
</fieldset>