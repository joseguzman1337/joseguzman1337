<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

//unset ($_SESSION['sesion_planestudioporcarrera']);
?>
<html>
    <head>
        <title>Plan de Estudio Por Carrera</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">
<?php
if(isset($_SESSION['codigofacultad'])) {
?>
window.location.href='lista.php?<?php echo "&codigocarrera=".$_SESSION['codigofacultad'];?>';
<?php
}
?>
function prueba()
{
    document.form1.submit();
}
function redireccionar()
{
    var carrera = document.getElementById("codigocarrera");
    var nombrecarrera = carrera[carrera.selectedIndex].text;
    window.location.href='lista.php?<?php echo "&codigocarrera=".$_REQUEST['codigocarrera'];?>';
}
         </SCRIPT>
    </head>
 <body>
    <form name="form1" id="form1"  method="POST">
        <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
            <TR><TD align="center"><img src="../../../../imagenes/noticias_logo.gif" height="71" ></TD></TR>
            <TR><TD id="tdtitulogris" align="center"><label id="labelresaltadogrande" >MATERIAS POR CARRERA</label></TD></TR>
        </table>
                <?php
                $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado=100";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();


                        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
                        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
                        order by nombrecarrera";


                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
              // print_r($_POST);
                ?>
                  <table width="40%"  border="0" align="center" cellpadding="3" cellspacing="3">
                   <tr>
                    <td width="22%" id="tdtitulogris" >Seleccione la Modalidad
                        <div align="center">
                            <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="prueba()">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['codigomodalidadacademica']) {
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
                            <select name="codigocarrera" id="codigocarrera" onchange="prueba()">
                            <option value="">Seleccionar</option>
                            <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                if ($row_carrera['codigocarrera']==$_POST['codigocarrera']) {
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
if(isset($_REQUEST['codigocarrera']) && isset($_REQUEST['codigomodalidadacademica'])) {
    if($_REQUEST['codigocarrera'] != '' && $_REQUEST['codigomodalidadacademica'] != '') {
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
   <FORM name="form2" id="form2"  method="GET" action="listabusquedamaterias.php" >
        <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
        <TR><TD id="tdtitulogris" align="center"><label id="labelresaltadogrande" >BUSQUEDA DE MATERIAS (Digite el código o el nombre)</label></TD></TR>
        <TR>
            <TD align="center"><INPUT type="text" name="busqueda" id="busqueda">
            </TD>

        </TR>

        <TR>
            <TD align="center"><INPUT type="submit" value="Consultar">
            </TD>

        </TR>
        </table>
   </FORM>
 </body>
</html>