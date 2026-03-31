<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
session_start();
$nombrearchivo = 'Novedades_Convenios';
if(isset($_REQUEST['formato']))
{
	$formato = $_REQUEST['formato'];
	$formato = 'xls';
	switch ($formato)
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
	}
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//header("Cache-Control: no-store, no-cache");
	header("Pragma: public");
}
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
$filtroNombreConvenio = "";
$filtroTipoNovedad = "";
$filtroObservacionNovedad = "";
$filtroInicioNovedad = "";
$filtroFinNovedad = "";

/*if(isset($_POST['entidadconvenio'])) {
    $filtroNombreConvenio = " and c.nombreentidadconvenio like '%".$_POST['entidadconvenio']."%'";
}*/
if(isset($_POST['tiponovedad'])) {
    $filtroTipoNovedad = " and tn.nombretiponovedadesconvenio like '%".$_POST['tiponovedad']."%'";
}
if(isset($_POST['observacionnovedad'])) {
    $filtroObservacionNovedad = " and n.observacionnovedadesconvenio like '%".$_POST['observacionnovedad']."%'";
}
if(isset($_POST['inicionovedad'])) {
    $filtroInicioNovedad = " and n.fechainicionovedadesconvenio like '%".$_POST['inicionovedad']."%'";
}
if(isset($_POST['finnovedad'])) {
    $filtroFinNovedad = " and n.fechafinnovedadesconvenio like '%".$_POST['finnovedad']."%'";
}
$query_novedades ="SELECT n.idnovedadesconvenio, n.adjuntonovedadesconvenio, n.observacionnovedadesconvenio, n.fechainicionovedadesconvenio, n.fechafinnovedadesconvenio, tn.nombretiponovedadesconvenio, c.nombreentidadconvenio
FROM convenio c, novedadesconvenio n, tiponovedadesconvenio tn
WHERE c.idconvenio = '".$_REQUEST['idconvenio']."'
and c.idconvenio=n.idconvenio
and n.codigotiponovedadesconvenio=tn.codigotiponovedadesconvenio
and c.codigoestado like '1%'
and n.codigoestado like '1%'
$filtroTipoNovedad 
$filtroObservacionNovedad 
$filtroInicioNovedad
$filtroFinNovedad 
group by idnovedadesconvenio
order by idnovedadesconvenio";
$novedades= $db->Execute($query_novedades) or die("$query_novedades".mysql_error());
$totalRows_novedades = $novedades->RecordCount();

$query_nombrenovedad ="SELECT c.nombreentidadconvenio
FROM convenio c
WHERE c.idconvenio = '".$_REQUEST['idconvenio']."'";
$nombrenovedad= $db->Execute($query_nombrenovedad) or die("$query_nombrenovedad".mysql_error());
$totalRows_nombrenovedad = $nombrenovedad->RecordCount();
$row_nombrenovedad = $nombrenovedad->FetchRow();

$rutaJS = "../../sic/librerias/js/";
$rutaEstilos = "../../sic/estilos/";
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.css" />
        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-ui/css/ui-lightness/jquery-ui-3.6.0.custom.css" />
        <link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sic_normal.css" />
        <link rel="stylesheet" href="<?php echo $rutaEstilos; ?>jquery.lightbox-0.5.css" />

        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery.layout.js"></script>
        <script src="<?php echo $rutaJS; ?>jquery.lightbox-0.5.min.js"></script>
        <script src="<?php echo $rutaJS; ?>jquery.maxlength-min.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.css" />
        <script src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    //var idconvenio;
    $("img").newWindow({
            //alert('asdasd' + idconvenio);
            windowTitle:"Adjuntar Archivos",
            content: "<iframe id='#idadjunto' width='300px' height='300px' src='vista_adjunto_novedad.php'>",
            windowType: "iframe",
            posx : 400,
            posy : 80,
            width: 300,
            height: 180
        });
    $("img").click(function(){
        //alert(this.value);
        var idnovedadesconvenio = $(this).attr("name");
        //alert('asdasdas=' + idconvenio);
        $("#idnovedadesconvenio").attr("value", idnovedadesconvenio);
    });
})
</script>

    </head>
    <body>
     <form name="form1" id="form1"  method="POST" action="">
            <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD colspan="<?php if(!isset($_REQUEST['formato']))
                { 
                echo "6";
                }
                else
                echo "5";
                ?>
                " align="center">
                        <label id="labelresaltadogrande" >Lista Novedades Convenios </BR>
                        <?php echo $row_nombrenovedad['nombreentidadconvenio']; ?>
                        </label>
                    </TD>
                </TR>
            </table>

        <input id="idnovedadesconvenio" type="hidden" value="">
        <TABLE width="100%"  border="1" align="center">
            <TR id="trgris">
                <TD align="center"><label id="labelresaltado">Id</label></TD>                
                <TD align="center"><label id="labelresaltado">Nombre </BR> Tipo Novedad</label></TD>               
                <TD align="center"><label id="labelresaltado">Observaciones</label></TD>
                <TD align="center"><label id="labelresaltado">Vigencia</BR>Desde</label></TD>
                <TD align="center"><label id="labelresaltado">Vigencia</BR>Hasta</label></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><label id="labelresaltado">Adjuntos</label></TD>
                <?php
                }
                ?>
            </TR>
            <?php if(!isset($_REQUEST['formato']))
                { ?>
            <TR>
                <TD >&nbsp;</TD>                
                <TD align="center"><INPUT type="text" name="tiponovedad" id="tiponovedad" size="13"  value="<?php if ($_POST['tiponovedad']!=""){
                        echo $_POST['tiponovedad']; } ?>"></TD>
                <TD align="center"><INPUT type="text" name="observacionnovedad" id="observacionnovedad"  value="<?php if ($_POST['observacionnovedad']!=""){
                        echo $_POST['observacionnovedad']; } ?>"></TD>               
                <TD align="center"><INPUT type="text" name="inicionovedad" id="inicionovedad" size="10" value="<?php if ($_POST['inicionovedad']!=""){
                        echo $_POST['inicionovedad']; } ?>"></TD>
                <TD align="center"><INPUT type="text" name="finnovedad" id="finnovedad" size="10" value="<?php if ($_POST['finnovedad']!=""){
                        echo $_POST['finnovedad']; } ?>"></TD>
                <TD align="center">&nbsp;<input type="submit" name="Filtrar" value="Filtrar"></TD>
            </TR>
            <?php
            }
            ?>
            <?php while($row_novedades = $novedades->FetchRow()) {
                                        /*$query_activos = "SELECT distinct c.idconvenio, d.codigocarrera, d.idconveniocarrera, cc.nombrecarrera FROM convenio c, conveniocarrera d, carrera cc 
                                        where c.idconvenio=d.idconvenio
                                        and d.codigocarrera=cc.codigocarrera
                                        and c.idconvenio = '".$row_convenio['idconvenio']."'
                                        $filtroNombreCarrera
                                        and d.codigoestado like '1%'";
                                        $activos = $db->Execute($query_activos);
                                        $totalRows_activos = $activos->RecordCount();
                                        if ($totalRows_activos == 0 && $filtroNombreCarrera !='') 
                                        continue;*/
            ?>
            <TR valign="baseline">
                <TD align="center"><?php if(!isset($_REQUEST['formato']))
                { ?>
                <A id="aparencialink" href="novedades_convenio.php?idnovedadesconvenio=<?php echo $row_novedades['idnovedadesconvenio']."&iditemsic=".$_REQUEST['iditemsic']."&idconvenio=".$_REQUEST['idconvenio']; ?>"><?php echo $row_novedades['idnovedadesconvenio']; ?></A>
                <?php 
                } else {
                echo $row_novedades['idnovedadesconvenio']; 
                } 
                ?></TD>
                <TD align="center"><?php echo $row_novedades['nombretiponovedadesconvenio']; ?></TD>        
                <TD style="text-align:justify;"><?php echo $row_novedades['observacionnovedadesconvenio']; ?></TD>       
                <TD align="center"><?php echo $row_novedades['fechainicionovedadesconvenio']; ?></TD>
                <TD align="center"><?php echo $row_novedades['fechafinnovedadesconvenio']; ?></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><?php
                        if($row_novedades['adjuntonovedadesconvenio'] == '') {
                            echo "Sin Adjunto";
                        }
                        else {
                            ?>
                    <a href="adjuntos_novedades/<?php echo $row_novedades['adjuntonovedadesconvenio']; ?>" target="_blank">Ver Adjunto</a>
                        <?php
                        }
                        ?><img name="<?php echo $row_novedades['idnovedadesconvenio']; ?>" src="https://artemisa.unbosque.edu.co/imagenes/correo1.png" alt="Adjuntar" style="cursor:pointer;"></TD>
                <?php 
                }
                ?>
            </TR>
            <?php }
            ?>
            <?php if(!isset($_REQUEST['formato']))
                { ?>
            <TR align="left">
                <TD id="tdtitulogris" colspan="6"  align="center">

                    <INPUT type="button" value="Adicionar" onClick="window.location.href='novedades_convenio.php?iditemsic=<?php echo $_REQUEST['iditemsic']."&idconvenio=".$_REQUEST['idconvenio']; ?>'">
                    <INPUT type="button" value="Regresar" onClick="window.location.href='lista_convenio.php?entidadconvenio=<?php echo $_REQUEST['entidadconvenio']."&tipoconvenio=".$_REQUEST['tipoconvenio']."&nombrecarrera=".$_REQUEST['nombrecarrera']."&responsable=".$_REQUEST['responsable']."&inicio=".$_REQUEST['inicio']."&fin=".$_REQUEST['fin'];?>'">
                    <INPUT type="submit" name="formato" id="formato" value="Exportar">
                </TD>
            </TR>
            <?php 
            }
            ?>
        </TABLE>
      </form>
    </body>
</html>