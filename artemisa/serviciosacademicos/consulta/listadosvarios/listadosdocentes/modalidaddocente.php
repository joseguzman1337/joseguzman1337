<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

?>
<html>
    <head>
        <title>Modalidad Listado Docentes con Contrato</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">
function prueba()
{
    document.form1.submit();
}
function redireccionar()
{
    var carrera = document.getElementById("nacodigocarrera");
    var nombrecarrera = carrera[carrera.selectedIndex].text;
    window.location.href='listadosdocentescontratos.php?<?php echo "nacodigomodalidadacademica=".$_REQUEST['nacodigomodalidadacademica']."&nacodigocarrera=".$_REQUEST['nacodigocarrera']. "&nanombrecarrera="; ?>' + nombrecarrera;
}
         </SCRIPT>
    </head>
 <body>
    <form name="form1" id="form1"  method="GET">
        <table width="20%"  border="0" align="center" cellpadding="3" cellspacing="3">
            <TR><TD><img src="../../../../imagenes/noticias_logo.gif" height="71" ></TD></TR>
            <TR><TD id="tdtitulogris" align="center"><H2>Listado Docentes con Contrato</H2></TD></TR>
                <?php
                $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado=100";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();


                        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='".$_GET['nacodigomodalidadacademica']."'
                        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
                        order by nombrecarrera";


                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
              // print_r($_GET);
                ?>
                   <tr>
                    <td width="22%" id="tdtitulogris" >Seleccione la Modalidad
                        <div align="center">
                            <select name="nacodigomodalidadacademica" id="nacodigomodalidadacademica" onchange="prueba()">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_GET['nacodigomodalidadacademica']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option><?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td  id="tdtitulogris">Seleccione la Carrera
                        <div align="center">
                            <select name="nacodigocarrera" id="nacodigocarrera" onchange="prueba()">

                            <option value="todas">TODAS</option>
                            <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                if ($row_carrera['codigocarrera']==$_GET['nacodigocarrera']) {
                                echo "Selected";
                                $nombrecarrera = $row_carrera['nombrecarrera'];
                                 }?>>
                                <?php echo $row_carrera['nombrecarrera'];
                                ?>

                            </option><?php };?>
                            </select>


<input type="hidden" name="nanombrecarrera" value="<?php echo $nombrecarrera;?>">
                        </div>
                    </td>
                </tr>
<?php
if(isset($_REQUEST['nacodigocarrera']) && isset($_REQUEST['nacodigomodalidadacademica'])) {
    if($_REQUEST['nacodigocarrera'] != '' && $_REQUEST['nacodigomodalidadacademica'] != '') {
?>
                <tr>
                    <td id="tdtitulogris">
                        <div align="center">
                         <input type="button" value="Consultar" onclick="redireccionar()">
                        </div>
                    </td>
                </tr>
<?php
    }
}

?>
    </table>
   </form>
 </body>
</html>