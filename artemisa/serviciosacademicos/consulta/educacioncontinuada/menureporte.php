<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
session_start();

$varguardar=0;

//unset ($_SESSION['sesion_planestudioporcarrera']);
?>
<html>
    <head>
        <title>Interesados Educontinuada</title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
    </head>
 <body>
    <form name="form1" id="form1"  method="POST">
        <table   border="0" align="left" cellpadding="3" cellspacing="3">
            <TR><TD id="tdtitulogris" align="center" colspan="2"><label id="labelresaltadogrande" >INTERESADOS EDUCACION CONTINUADA</label></TD></TR>
       
                <?php
                        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='400'
                        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
                        order by nombrecarrera";

                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
              // print_r($_POST);
                ?>
                <tr>
                    <td  id="tdtitulogris">Seleccione la Carrera</td>
                    <td>        <select name="codigocarrera" id="codigocarrera">
                            <option value="">Seleccionar</option>
                            <option value="todos">*Todos*</option>
                            <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                if ($row_carrera['codigocarrera']==$_POST['codigocarrera']) {
                                echo "Selected";
                                $nombrecarrera = $row_carrera['nombrecarrera'];
                                 }?>>
                                <?php echo $row_carrera['nombrecarrera'];
                                ?>
                            </option><?php };?>
                            </select>
                    </td>
                </tr>
		
		<tr align="left" >
                    <td id="tdtitulogris">Fecha Inicial<label  id="labelasterisco">*</label></td>
		    <td>
                        <div align="justify">
                        <INPUT type="text" name="fechainicio" id="fechainicio"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainicio" // ID of the button
                                  }
                                 );
                        </script>
                        </div>
                    </td>
                </tr>
		<tr align="left" >
                    <td id="tdtitulogris">Fecha Final<label  id="labelasterisco">*</label></td>
                    <td>
                        <div align="justify">
                        <INPUT type="text" name="fechafin" id="fechafin"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafin",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafin" // ID of the button
                                  }
                                 );
                        </script>
                        </div>
                    </td>
                </tr>
		<tr align="left">
		   <td id="tdtitulogris" colspan="2"><input type="submit" name="enviar" value="Enviar">
		   </td>
		</tr>
    </table>

<?php
if(isset($_POST['enviar'])){ 
	if ($_POST['codigocarrera'] == "") {
            echo '<script language="JavaScript">alert("Campo requerido debe seleccionar la carrera")</script>';
            $varguardar = 1;
        }
	else if ($_POST['fechainicio'] == "") {
            echo '<script language="JavaScript">alert("Campo requerido debe seleccionar o digitar la fecha de inicio")</script>';
            $varguardar = 1;
        }
	else if ($_POST['fechafin'] == "") {
            echo '<script language="JavaScript">alert("Campo requerido debe seleccionar o digitar la fecha fin")</script>';
            $varguardar = 1;
        } 
	else if ($_POST['fechafin'] < $_POST['fechainicio']) {
            echo '<script language="JavaScript">alert("La fecha inicial  no puede ser mayor a la fecha final.")</script>';
            $varguardar = 1;
        }
	elseif ($varguardar == 0) {
	
	    echo "<script language='JavaScript'>window.location.href='informecapturainfo.php?codigocarrera=".$_POST["codigocarrera"]."&fechainicio=".$_POST["fechainicio"]."&fechafin=".$_POST["fechafin"]."'
                           </script>";
	}
}
?>


   </form>
</body>
</html>
