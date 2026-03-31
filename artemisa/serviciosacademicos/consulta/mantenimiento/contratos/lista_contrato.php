<?php
$fechahoy=date("Y-m-d H:i:s");
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$nombrearchivo = 'Contratos';
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
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
$filtroNombrecontrato = "";
$filtrotipocontratosec = "";
$filtroSupervisorcontrato = "";
$filtroResponsablecontrato = "";
$filtroIniciocontrato = "";
$filtroFincontrato = "";

if(isset($_REQUEST['entidadcontrato'])) {
    $filtroNombrecontrato = " and c.nombreentidadcontrato like '%".$_REQUEST['entidadcontrato']."%'";
}
if(isset($_REQUEST['tipocontratosec'])) {
    $filtrotipocontratosec = " and tc.nombretipocontratosec like '%".$_REQUEST['tipocontratosec']."%'";
}
if(isset($_REQUEST['supervisor'])) {
    $filtroSupervisorcontrato = " and c.supervisorcontrato like '%".$_REQUEST['supervisor']."%'";
}
if(isset($_REQUEST['responsable'])) {
    $filtroResponsablecontrato = " and c.responsablecontrato like '%".$_REQUEST['responsable']."%'";
}
if(isset($_REQUEST['inicio'])) {
    $filtroIniciocontrato = " and c.fechainiciovigenciacontrato like '%".$_REQUEST['inicio']."%'";
}
if(isset($_REQUEST['fin'])) {
    $filtroFincontrato = " and c.fechafinvigenciacontrato like '%".$_REQUEST['fin']."%'";
}
$query_contrato ="SELECT c.idcontrato,c.nombreentidadcontrato, c.contraprestacioncontrato,
tc.nombretipocontratosec,  c.adjuntocontrato, c.objetivocontrato, c.fechainiciovigenciacontrato,
c.fechafinvigenciacontrato, c.responsablecontrato, c.renovacioncontrato, c.supervisorcontrato
FROM contrato c, tipocontratosec tc
WHERE c.codigotipocontratosec=tc.codigotipocontratosec
and c.codigoestado like '1%'
$filtroNombrecontrato
$filtrotipocontratosec
$filtroSupervisorcontrato
$filtroResponsablecontrato
$filtroIniciocontrato
$filtroFincontrato
group by idcontrato
order by idcontrato";
$contrato= $db->Execute($query_contrato) or die("$query_contrato".mysql_error());
$totalRows_contrato = $contrato->RecordCount();
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
    //var idcontrato;
    $("img").newWindow({
            //alert('asdasd' + idcontrato);
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
        var idcontrato = $(this).attr("name");
        //alert('asdasdas=' + idcontrato);
        $("#idcontrato").attr("value", idcontrato);
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
                        <label id="labelresaltadogrande" >Lista de contratos</label>
                    </TD>
                </TR>
            </table>

        <input id="idcontrato" type="hidden" value="">
        <TABLE width="100%"  border="1" align="center">
            <TR id="trgris">
                <TD align="center"><label id="labelresaltado">Id</label></TD>
                <TD align="center"><label id="labelresaltado">Entidad </label></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><label id="labelresaltado">Novedades</label></TD>
                <?php
                }
                ?>
                <TD align="center"><label id="labelresaltado">Tipo contrato</label></TD>
                <TD align="center"><label id="labelresaltado">Supervisor</label></TD>
                <TD width="35%" align="center"><label id="labelresaltado">Objetivo</label></TD>
                <TD width="35%" align="center"><label id="labelresaltado">Valor/Contraprestación</label></TD>
                <TD align="center"><label id="labelresaltado">Responsable</label></TD>
                <TD align="center"><label id="labelresaltado">Vigencia<BR>Desde</label></TD>
                <TD align="center"><label id="labelresaltado">Vigencia<BR>Hasta</label></TD>
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
                <TD align="center"><INPUT type="text" name="entidadcontrato" id="entidadcontrato" size="14" value="<?php if ($_REQUEST['entidadcontrato']!=""){
                        echo $_REQUEST['entidadcontrato']; } ?>"></TD>
                <TD>&nbsp;</TD>
                <TD align="center"><INPUT type="text" name="tipocontratosec" id="tipocontratosec" size="10"  value="<?php if ($_REQUEST['tipocontratosec']!=""){
                        echo $_REQUEST['tipocontratosec']; } ?>"></TD>
                <TD align="center"><INPUT type="text" name="supervisor" id="supervisor" size="15"  value="<?php if ($_REQUEST['supervisor']!=""){
                        echo $_REQUEST['supervisor']; } ?>"></TD>
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
            <?php while($row_contrato = $contrato->FetchRow()) {
                                        
            ?>
            <TR valign="baseline">
                <TD align="center"><?php echo $row_contrato['idcontrato']; ?></TD>
                <TD align="center" ><?php if(!isset($_REQUEST['formato']))
                { ?><A id="aparencialink" href="insertar_contrato.php?idcontrato=<?php echo $row_contrato['idcontrato']."&iditemsic=".$_REQUEST['iditemsic']; ?>"><?php echo $row_contrato['nombreentidadcontrato']; ?></A><?php } else { echo $row_contrato['nombreentidadcontrato']; } ?></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><INPUT type="button" value="Novedades" onclick="window.location.href='lista_novedades_contrato.php?idcontrato=<?php echo $row_contrato['idcontrato']."&entidadcontrato=".$_REQUEST['entidadcontrato']."&tipocontratosec=".$_REQUEST['tipocontratosec']."&nombrecarrera=".$_REQUEST['nombrecarrera']."&responsable=".$_REQUEST['responsable']."&inicio=".$_REQUEST['inicio']."&fin=".$_REQUEST['fin']; ?>'"></TD>
                <?php
                }
                ?>
                <TD align="center"><?php echo $row_contrato['nombretipocontratosec']; ?></TD>
                <TD align="center"><?php echo $row_contrato['supervisorcontrato']; ?></TD>
                <TD width="35%" style="text-align:justify;"><?php echo $row_contrato['objetivocontrato']; ?></TD>
                <TD width="35%" style="text-align:justify;"><?php echo $row_contrato['contraprestacioncontrato']; ?></TD>
                <TD align="center"><?php echo $row_contrato['responsablecontrato']; ?></TD>
                <TD align="center"><?php echo $row_contrato['fechainiciovigenciacontrato']; ?></TD>
                <TD width="5%" align="center"><?php echo $row_contrato['fechafinvigenciacontrato']; ?><br><?php echo $row_contrato['renovacioncontrato']; ?></TD>
                <?php if(!isset($_REQUEST['formato']))
                { ?>
                <TD align="center"><?php
                        if($row_contrato['adjuntocontrato'] == '') {
                            echo "Sin Adjunto";
                        }
                        else {
                            ?>
                    <a href="adjuntos/<?php echo $row_contrato['adjuntocontrato']; ?>" target="_blank">Ver Adjunto</a>
                        <?php
                        }
                        ?><img name="<?php echo $row_contrato['idcontrato']; ?>" src="https://artemisa.unbosque.edu.co/imagenes/correo1.png" alt="Adjuntar" style="cursor:pointer;"></TD>
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
                    <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_contrato.php?iditemsic=<?php echo $_REQUEST['iditemsic']; ?>'">
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
