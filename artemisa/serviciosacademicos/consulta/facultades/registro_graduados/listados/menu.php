<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
    unset($_SESSION['codigoperiodo']);
    unset($_SESSION['codigocarrera']);
    unset($_SESSION['codigomodalidadacademica']);
    $fechahoy=date("Y-m-d H:i:s");
    $rutaado=("../../../../funciones/adodb/");
    require_once('../../../../Connections/salaado-pear.php');
    require_once("../../../../funciones/validaciones/validaciongenerica.php");
    $mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
    $validaciongeneral=true;

    class carrera extends ADODB_Active_Record {}
    class periodo extends ADODB_Active_Record {}
    class modalidadacademica extends ADODB_Active_Record {}

    $modalidadacademica=new modalidadacademica('modalidadacademica');
    $row_modalidadacademica=$modalidadacademica->Find('codigoestado=100 order by nombremodalidadacademica asc');
    $carrera=new carrera('carrera');

    if(isset($_GET['codigomodalidadacademica']) && !empty($_GET['codigomodalidadacademica'])){
        $codigomodalidadacademica = $_GET['codigomodalidadacademica'];
    }else{
        $codigomodalidadacademica = "";
    }

    if(isset($_GET['codigocarrera']) && !empty($_GET['codigocarrera'])){
        $codigocarrera = $_GET['codigocarrera'];
    }else{
        $codigocarrera = "";
    }

    if($codigomodalidadacademica!="todos"){
	    $row_carrera=$carrera->Find("codigomodalidadacademica='".$codigomodalidadacademica."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
    }else{
	    $row_carrera=$carrera->Find("fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
    }
    $periodo=new periodo('periodo');
    $row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');
?>
<?php
@session_start();

?>
    <form name="form1" method="get" action="">
        <h2>ESTADISTICAS MATRICULAS - MENU PRINCIPAL </h2>
        <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
            <tr>
                <td width="14%" nowrap id="tdtitulogris">Modalidad acad&eacute;mica </td>
                <td width="86%">
                    <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
                        <option value="">Seleccionar</option>
                        <option value="todos"<?php if($codigomodalidadacademica=="todos"){echo "Selected";}?>>*Todos*</option>
                        <?php foreach ($row_modalidadacademica as $llave => $valor){ ?>
                            <option value="<?php echo $valor->codigomodalidadacademica;?>"<?php if($valor->codigomodalidadacademica==$codigomodalidadacademica){echo "Selected";}?>>
                                <?php echo $valor->nombremodalidadacademica;?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php $validacion['codigomodalidadacademica']= validaciongenerica($codigomodalidadacademica, "requerido", "Modalidad acad&eacute;mica");?>
                </td>
            </tr>
            <tr>
                <td nowrap id="tdtitulogris">Programa</td>
                <td class="amarrillento">
                    <select name="codigocarrera" id="codigocarrera">
                        <option value="">Seleccionar</option>
                        <option value="todos"<?php if($codigocarrera=="todos"){echo "Selected";}?>>*Todos*</option>
                        <?php foreach ($row_carrera as $llave => $valor){?>
                        <option value="<?php echo $valor->codigocarrera?>"<?php if($valor->codigocarrera==$codigocarrera){echo "Selected";}?>><?php echo $valor->nombrecarrera?></option>
                        <?php };?>
                    </select>
                    <?php $validacion['codigocarrera']=validaciongenerica($codigocarrera,"requerido","Programa");?>
                </td>
            </tr>
            <tr>
                <td nowrap id="tdtitulogris">Con incentivos</td>
                <td class="amarrillento">
                    <select name="incentivos" id="incentivos">
                        <option value="no">No</option>
                        <option value="si">Si</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" nowrap>
                    <div align="center" class="verde">
                        <input name="Enviar" type="submit" id="Enviar" value="Enviar">
                        <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <?php if(isset($_GET['Restablecer'])){?>
        <script language="javascript">window.location.href="menu.php"</script>
    <?php } ?>
    <?php
    if(isset($_GET['Enviar'])){
	    foreach ($validacion as $key => $valor){
            if($valor['valido']==0){
                $mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];
                $validaciongeneral=false;
            }
	    }//foreach
	    if($validaciongeneral==true){
		    echo '<script language="javascript">window.location.href="registro_graduados_lista.php?codigomodalidadacademica='.$codigomodalidadacademica.'&codigocarrera='.$codigocarrera.'&codigoperiodo='.$_GET['codigoperiodo'].'&incentivos='.$_GET['incentivos'].'";</script>';
	    }else{
		    echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	    }
    }//if
?>