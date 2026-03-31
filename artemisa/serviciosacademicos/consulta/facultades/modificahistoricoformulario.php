<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'NotaHistorico');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}
      
require('../../Connections/sala2.php');

$codigoestudiante = $_GET['codigoestudiante'];
mysql_select_db($database_sala, $sala);
$query_Recordset2 = "select p.codigoperiodo, p.nombreperiodo
from periodo p, estudiante e, carreraperiodo cp
where cp.codigocarrera = e.codigocarrera
and p.codigoperiodo = cp.codigoperiodo
and e.codigoestudiante = '$codigoestudiante'
ORDER BY p.codigoperiodo DESC";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$periodo = 0;


$usuario = $_SESSION['MM_Username'];


$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

$carrera  = $row_tipousuario['codigofacultad'];
$documento = $_GET['documento'];
?>
<style type="text/css">
<!--
.Estilo1 {
    font-family: TAHOMA;
    font-size: xx-small;
}
.Estilo3 {
    font-weight: bold;
    font-size: 14px;
    font-family: Tahoma;
}
.Estilo7 {font-size: 10px}
.Estilo8 {font-size: 10px}
.Estilo10 {font-size: 10px; font-family: Tahoma; }
.Estilo12 {font-family: TAHOMA; font-size: 10; }
.Estilo13 {font-size: 10}
.Estilo14 {font-size: 12px}
.Estilo15 {
    font-size: 12;
    font-weight: bold;
    font-family: Tahoma;
}
.Estilo17 {font-size: 12; font-family: Tahoma; }
-->
</style>
<form name="form1" method="get" action="">
<p align="center"><span class="Estilo3">Modificaci&oacute;n Historico de Notas </span></p>
<div align="center">
 <select name="periodo" id="periodo" onChange="enviar()">
<option value="" selected>Periodo</option>
<?php
do
{
    if($_GET['periodo'] == $row_Recordset2['codigoperiodo'])
    {
        $nombreperiodo = $row_Recordset2['nombreperiodo'];
    }

?>
<option value="<?php echo $row_Recordset2['codigoperiodo']?>"<?php if (!(strcmp($row_Recordset2['codigoperiodo'], $_GET['periodo']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['codigoperiodo']."-".$row_Recordset2['nombreperiodo'];?></option>
<?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
      $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
</select>
</div>
<br>

<?php
if (isset($_GET['periodo']))
 {
    $periodo = $_GET['periodo'];

    mysql_select_db($database_sala, $sala);
    $query_Recordset1 = "SELECT *
                         from notahistorico n,materia m,tiponotahistorico t
                         where n.codigoestudiante = '$codigoestudiante'
                         and t.codigotiponotahistorico = n.codigotiponotahistorico
                         and n.codigoperiodo = '$periodo'
                         and m.codigomateria = n.codigomateria
                         and codigoestadonotahistorico like '1%'
                         order by nombremateria
    ";
    $Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
    //echo $query_Recordset1;
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysql_num_rows($Recordset1);
    
 }

 if ($_GET['Submit3'])
 {
    if ($_GET['periodo'] == "")
     {
       echo '<font style="Tahoma" size="2"><script language="JavaScript">alert("Debe elegir un periodo");history.back()</script></font>'; exit();
     }

   echo '<script language="JavaScript">window.location.href="modificahistoriconuevamateria.php?codigoestudiante='.$codigoestudiante.'&periodo='.$periodo.'&documento='.$documento.'";</script>';
 }
if ($_GET['Submit2'])
 {

   if ($row_tipousuario['codigotipousuariofacultad'] == 100)
    {
       echo '<script language="JavaScript">window.location.href="../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad";</script>';
    }
    else
    {
      echo '<script language="JavaScript">window.location.href="modificarhistoricobusqueda.php";</script>';
    }

 }
 if (!$row_Recordset1)
  {
    echo '<font face="Tahoma" size="2"><div align="center"><strong>No presenta notas en este periodo</strong></div></font><br>';
  }

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT * FROM estudiante e,estudiantegeneral eg
                      WHERE e.idestudiantegeneral = eg.idestudiantegeneral
                      and e.codigoestudiante = '$codigoestudiante'";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if($row_Recordset2['codigosituacioncarreraestudiante'] == '400')
{
?>
<script language="javascript">
    alert("La situación académica del estudiante es Graduado, por lo \n tanto no se pueden hacer modificaciones en el histórico");
    history.go(-1);
</script>
<?php
}
$facultad=$row_Recordset2['codigocarrera'];

mysql_select_db($database_sala, $sala);
$query_Recordset3 = sprintf("SELECT * FROM carrera WHERE codigocarrera = '%s'",$facultad);
$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);



mysql_select_db($database_sala, $sala);
$query_valoracion = "SELECT *
                    FROM tiponotahistorico
                    order by 1";
$valoracion = mysql_query($query_valoracion, $sala) or die(mysql_error());
$row_valoracion = mysql_fetch_assoc($valoracion);
$totalRows_valoracion = mysql_num_rows($valoracion);


  if ($row_Recordset1 <> "")
   {// if 1
    
    
   ?>

  <table width="700"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="2" bgcolor="#C5D5D6" class="Estilo1"><div align="center" class="Estilo15">Nombre</div></td>
      <td class="Estilo1"><div align="center" class="Estilo17"><?php echo $row_Recordset2['apellidosestudiantegeneral']."&nbsp;".$row_Recordset2['nombresestudiantegeneral'] ?></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1"><div align="center" class="Estilo17"> <strong>Documento</strong></div></td>
      <td class="Estilo1"><div align="center" class="Estilo17"><?php echo $row_Recordset2['numerodocumento']; ?></div>        <div align="center" class="Estilo17"></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1"><div align="center"><span class="Estilo14"><strong>Fecha</strong></span></div></td>
      <td class="Estilo1" align="center"><span class="Estilo17"><?php echo date("j/m/Y",time());?></span></td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="#C5D5D6" class="Estilo1"><div align="center" class="Estilo14"><strong>Programa</strong></div></td>
      <td class="Estilo1"><div align="center" class="Estilo14"><?php echo $row_Recordset3['nombrecarrera']; ?></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1"><div align="center" class="Estilo14"><strong>Periodo </strong></div></td>
      <td class="Estilo1" align="center" colspan="3"><span class="Estilo14"><?php echo $nombreperiodo;?></span></td>
      </tr>
  </table>
  <table  border="1" align="center" cellpadding="2" bordercolor="#E97914" width="700">
    <tr>
      <td height="22"  class="Estilo1"><div align="center" class="Estilo7"><span class="Estilo14"><strong>C&oacute;digo</strong></span></div></td>
      <td class="Estilo1"><div align="center" class="Estilo7"><span class="Estilo14"> <strong>Nombre</strong></span></div></td>
      <td  class="Estilo1"><div align="center" class="Estilo7"><span class="Estilo14"> <strong>Nota</strong></span></div></td>
      <td  class="Estilo1"><div align="center" class="Estilo7"><span class="Estilo14 "><strong>Tipo Nota</strong></span></div></td>
      <td  class="Estilo1" align="center"><span class="Estilo14 Estilo7"><strong>Modificar</strong></span></td>
      <td  class="Estilo1" align="center"><span class="Estilo14 Estilo7"><strong>Rotación</strong></span></td>
    </tr>
    <?php
     $j = 1;
    do {?>
    <tr>
      <td  class="Estilo1"><div align="center" class="Estilo8"><span class="Estilo14 "><?php if($row_Recordset1['codigomateriaelectiva']!=1){
		echo $row_Recordset1['codigomateriaelectiva']." / "; } echo $row_Recordset1['codigomateria']; 
	   ?></span></div></td>
      <td class="Estilo1"><div align="left" class="Estilo8">
        <span class="Estilo14  Estilo13"><?php echo $row_Recordset1['nombremateria']; ?> </span></div>
     </td>
      <td  class="Estilo1"><div align="center" class="Estilo8"><span class="Estilo14 ">
        <?php
        echo number_format($row_Recordset1['notadefinitiva'],1);
    ?>
      </span></div></td>
      <td  class="Estilo12"><div align="center" class="Estilo14"><?php echo $row_Recordset1['nombretiponotahistorico']?></div></td>
 <?php
   // echo $row_tipousuario['codigotipousuariofacultad'],"&nbsp;",$carrera," <>", $row_Recordset1['codigocarrera'];
  if ($row_tipousuario['codigotipousuariofacultad'] == 200 and $carrera <> $row_Recordset1['codigocarrera'])
    {

 ?>
      <td  class="Estilo12"><div align="center"><span class="Estilo8"><span class="Estilo8">&nbsp;</span></span></div></td>
      <td  class="Estilo12"><div align="center"><span class="Estilo8"><span class="Estilo8">&nbsp;</span></span></div></td>
 <?php
    }
   else
   {
 ?>
      <td  class="Estilo1"><div align="center" class="Estilo8">
      <a style="cursor: pointer" onClick="window.open('modificahistoricoformularioventana.php?idhistorico=<?php echo $row_Recordset1["idnotahistorico"];?>&codigoestudiante=<?php echo $codigoestudiante?>','modificahistorico','width=800,height=200,left=150,top=50,scrollbars=yes')"><img src="../../../imagenes/editar.png" width="23" height="23" alt="Modificar"></a>&nbsp;</div></td>
      <td  class="Estilo1"><div align="center" class="Estilo8">
      <a style="cursor: pointer" onClick="window.open('modificahistoricorotacion.php?idhistorico=<?php echo $row_Recordset1["idnotahistorico"]."&codmateria=".$row_Recordset1['codigomateria']."&periodo=".$_GET['periodo']."&codigoestudiante=".$_GET['codigoestudiante'];?>','modificahistorico','width=700,height=400,left=150,top=50,scrollbars=yes')">
      <img src="../../../imagenes/adicionar.png" width="23" height="23" alt="Ingresar"></a>
      </div></td>
<?php
   }
?>
<?php
			$query_modif2 = "select	 id
						,observaciones
						,codigoestadosolicitud
						,nombreestadosolicitudcredito
						,observaciones
						,notamodificada
						,fechaaprobacion
					from solicitudaprobacionmodificacionnotas s 
					join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
					where s.codigoestudiante='".$codigoestudiante."'
						and s.codigoperiodo='".$periodo."'
						and s.codigomateria='".$row_Recordset1['codigomateria']."'
						and codigoestadosolicitud=11
						and idtiposolicitudaprobacionmodificacionnotas=30
					order by id desc
					limit 1";
                    //echo $query_modif2."<br>";
			$reg_modif2 = mysql_query($query_modif2, $sala) or die(mysql_error());
			$count_modif2 = mysql_num_rows($reg_modif2);
			if($count_modif==0 && $count_modif2>0) {
				$row_modif2 = mysql_fetch_assoc($reg_modif2);
				echo "	<td>
						<div align='center' class='Estilo1'>
							<table width='100%' bgcolor='#CFFFEC'>
								<tr class='Estilo1'><td>NOTA:</td><th align='right'>".$row_modif2['notamodificada']."</th></tr>
							</table>
							<table width='100%' style='border: solid 2px #000000; '>
								<tr class='Estilo1'><td>Id Solicitud:</td><td><b>".$row_modif2['id']."</b></td></tr>
								<tr class='Estilo1'><td>Fecha aprobación:</td><td><b>".$row_modif2['fechaaprobacion']."</b></td></tr>
								<tr class='Estilo1'><td>Estado:</td><td><b><font color='#006822'>".$row_modif2['nombreestadosolicitudcredito']."</font></b></td></tr>
							</table>
						</div>
				       	</td>";
			}
?>
</tr>
<?php
      $j++;
     }while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
} //if 1
?>
      <td colspan="6"><div align="center">

        &nbsp;&nbsp;

        <input type='submit' value='Regresar' name="Submit2">

        &nbsp;&nbsp;
        <input type="submit" name="Submit3" value="Ingreso Nueva Materia">
      </div></td>
</table>
  <div align="center"><span class="Estilo10">
    <input type="hidden" name="codigoestudiante" value=<?php echo $codigoestudiante;?>>
</span>
  </div>
</form>
<div align="left" class="Estilo10">
  <script language="javascript"></script>

</div>
<span class="Estilo10">
<script language="javascript"></script>
</span><span class="Estilo8"><script language="javascript"></script>
</span>
<script language="javascript">
function recargar(dir)
{
    window.location.href="modificahistoricoformulario.php"+dir;
    history.go();
}
</script>
<script language="javascript">
function enviar()
 {
  document.form1.submit();
 }
</script>
