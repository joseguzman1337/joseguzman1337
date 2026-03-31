<?php
$fechahoy=date("Y-m-d H:i:s");
session_start();
require_once('../../../Connections/sala2.php');
$nombrearchivo = 'Convenios';
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
$filtroTipoConvenio = "";
$filtroNombreCarrera = "";
$filtroResponsableConvenio = "";
$filtroInicioConvenio = "";
$filtroFinConvenio = "";

if(isset($_REQUEST['entidadconvenio'])) {
    $filtroNombreConvenio = " and c.nombreentidadconvenio like '%".$_REQUEST['entidadconvenio']."%'";
}
if(isset($_REQUEST['tipoconvenio'])) {
    $filtroTipoConvenio = " and tc.nombretipoconvenio like '%".$_REQUEST['tipoconvenio']."%'";
}
if(isset($_REQUEST['nombrecarrera'])) {
    $filtroNombreCarrera = " and cc.nombrecarrera like '%".$_REQUEST['nombrecarrera']."%'";
}
if(isset($_REQUEST['responsable'])) {
    $filtroResponsableConvenio = " and c.responsableconvenio like '%".$_REQUEST['responsable']."%'";
}
if(isset($_REQUEST['inicio'])) {
    $filtroInicioConvenio = " and c.fechainiciovigenciaconvenio like '%".$_REQUEST['inicio']."%'";
}
if(isset($_REQUEST['fin'])) {
    $filtroFinConvenio = " and c.fechafinvigenciaconvenio like '%".$_REQUEST['fin']."%'";
}
$query_convenio ="SELECT c.idconvenio,c.nombreentidadconvenio, c.contraprestacionconvenio,
tc.nombretipoconvenio,  c.adjuntoconvenio, c.objetivoconvenio, c.fechainiciovigenciaconvenio, c.fechafinvigenciaconvenio, c.responsableconvenio, c.renovacionconvenio
FROM convenio c, tipoconvenio tc
WHERE c.codigotipoconvenio=tc.codigotipoconvenio
and c.codigoestado like '1%'
$filtroNombreConvenio
$filtroTipoConvenio
$filtroResponsableConvenio
$filtroInicioConvenio
$filtroFinConvenio
group by idconvenio
order by idconvenio";
$convenio= $db->Execute($query_convenio) or die("$query_convenio".mysql_error());
$totalRows_convenio = $convenio->RecordCount();
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
            content: "<iframe id='#idadjunto' width='300px' height='300px' src='vista_adjunto.php'>",
            windowType: "iframe",
            posx : 400,
            posy : 80,
            width: 300,
            height: 180
        });
    $("img").click(function(){
        //alert(this.value);
        var idconvenio = $(this).attr("name");
        //alert('asdasdas=' + idconvenio);
        $("#idconvenio").attr("value", idconvenio);
    });
})
</script>
    </head>
    <body>
     <form name="form1" id="form1"  method="POST" action="">
            <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD align="center" colspan="<?php if(!isset($_REQUEST['formato']))
                { 
                echo "11";
                }
                else
                echo "9";
                ?>
                ">
                        <label id="labelresaltadogrande" >Lista de Convenios</label>
                    </TD>
                </TR>
            </table>

        <input id="idconvenio" type="hidden" value="">
        <TABLE width="100%"  border="1" align="center">
            <TR id="trgris">
                <TD align="center"><label id="labelresaltado">Id</label></TD>
                <TD align="center"><label id="labelresaltado">Nombre </BR> Entidad Convenio</label></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><label id="labelresaltado">Novedades</label></TD>
                <?php
                }
                ?>
                <TD align="center"><label id="labelresaltado">Nombre </BR> Tipo Convenio</label></TD>
                <TD align="center"><label id="labelresaltado">Nombre Carrera</label></TD>
                <TD width="35%" align="center"><label id="labelresaltado">Objetivo</label></TD>
                <TD width="35%" align="center"><label id="labelresaltado">Contraprestación</label></TD>
                <TD align="center"><label id="labelresaltado">Responsable</label></TD>
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
                <TD align="center"><INPUT type="text" name="entidadconvenio" id="entidadconvenio" size="14" value="<?php if ($_REQUEST['entidadconvenio']!=""){
                        echo $_REQUEST['entidadconvenio']; } ?>"></TD>
                <TD>&nbsp;</TD>
                <TD align="center"><INPUT type="text" name="tipoconvenio" id="tipoconvenio" size="10"  value="<?php if ($_REQUEST['tipoconvenio']!=""){
                        echo $_REQUEST['tipoconvenio']; } ?>"></TD>
                <TD align="center"><INPUT type="text" name="nombrecarrera" id="nombrecarrera" size="15"  value="<?php if ($_REQUEST['nombrecarrera']!=""){
                        echo $_REQUEST['nombrecarrera']; } ?>"></TD>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD align="center"><INPUT type="text" name="responsable" id="responsable" size="15" value="<?php if ($_REQUEST['responsable']!=""){
                        echo $_REQUEST['responsable']; } ?>"></TD>
                <TD><INPUT type="text" name="inicio" id="inicio" size="12" value="<?php if ($_REQUEST['inicio']!=""){
                        echo $_REQUEST['inicio']; } ?>"></TD>
                <TD align="center"><INPUT type="text" name="fin" id="fin" size="12" value="<?php if ($_REQUEST['fin']!=""){
                        echo $_REQUEST['fin']; } ?>"></TD>
                <TD align="center">&nbsp;<input type="submit" name="Filtrar" value="Filtrar"></TD>
            </TR>
            <?php
            }
            ?>
            <?php while($row_convenio = $convenio->FetchRow()) {
                                        $query_activos = "SELECT distinct c.idconvenio, d.codigocarrera, d.idconveniocarrera, cc.nombrecarrera FROM convenio c, conveniocarrera d, carrera cc 
                                        where c.idconvenio=d.idconvenio
                                        and d.codigocarrera=cc.codigocarrera
                                        and c.idconvenio = '".$row_convenio['idconvenio']."'
                                        $filtroNombreCarrera
                                        and d.codigoestado like '1%'";
                                        $activos = $db->Execute($query_activos);
                                        $totalRows_activos = $activos->RecordCount();
                                        if ($totalRows_activos == 0 && $filtroNombreCarrera !='') 
                                        continue;
            ?>
            <TR valign="baseline">
                <TD align="center"><?php echo $row_convenio['idconvenio']; ?></TD>
                <TD align="center" ><?php if(!isset($_REQUEST['formato']))
                { ?><A id="aparencialink" href="insertar_convenio.php?idconvenio=<?php echo $row_convenio['idconvenio']."&iditemsic=".$_REQUEST['iditemsic']; ?>"><?php echo $row_convenio['nombreentidadconvenio']; ?></A><?php } else { echo $row_convenio['nombreentidadconvenio']; } ?></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><INPUT type="button" value="Novedades" onclick="window.location.href='lista_novedades_convenio.php?idconvenio=<?php echo $row_convenio['idconvenio']."&entidadconvenio=".$_REQUEST['entidadconvenio']."&tipoconvenio=".$_REQUEST['tipoconvenio']."&nombrecarrera=".$_REQUEST['nombrecarrera']."&responsable=".$_REQUEST['responsable']."&inicio=".$_REQUEST['inicio']."&fin=".$_REQUEST['fin']; ?>'"></TD>
                <?php
                }
                ?>
                <TD align="center"><?php echo $row_convenio['nombretipoconvenio']; ?></TD>
                <TD align="center"><?php 
                                        
                                        $row_activos = $activos->FetchRow();
                                        $carreras='';
                                        do{
                                        $carreras.= $row_activos['nombrecarrera'].", " ;
                                        }
                                        while($row_activos = $activos->FetchRow());
                                        echo $carreras; ?>
                </TD>
                <TD width="35%" style="text-align:justify;"><?php echo $row_convenio['objetivoconvenio']; ?></TD>
                <TD width="35%" style="text-align:justify;"><?php echo $row_convenio['contraprestacionconvenio']; ?></TD>
                <TD align="center"><?php echo $row_convenio['responsableconvenio']; ?></TD>
                <TD align="center"><?php echo $row_convenio['fechainiciovigenciaconvenio']; ?></TD>
                <TD width="5%" align="center"><?php echo $row_convenio['fechafinvigenciaconvenio']; ?></br><?php echo $row_convenio['renovacionconvenio']; ?></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><?php
                        if($row_convenio['adjuntoconvenio'] == '') {
                            echo "Sin Adjunto";
                        }
                        else {
                            ?>
                    <a href="adjuntos/<?php echo $row_convenio['adjuntoconvenio']; ?>" target="_blank">Ver Adjunto</a>
                        <?php
                        }
                        ?><img name="<?php echo $row_convenio['idconvenio']; ?>" src="https://artemisa.unbosque.edu.co/imagenes/correo1.png" alt="Adjuntar" style="cursor:pointer;"></TD>
                <?php
                }
                ?>
            </TR>
            <?php 
            }
            ?>
            <?php if(!isset($_REQUEST['formato']))
                { ?>
            <TR align="left">
                <TD id="tdtitulogris" colspan="11"  align="center">
                    <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_convenio.php?iditemsic=<?php echo $_REQUEST['iditemsic']; ?>'">
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