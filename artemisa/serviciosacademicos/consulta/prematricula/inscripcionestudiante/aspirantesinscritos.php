<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
@session_start();
$carrera = $_SESSION['codigofacultad'];

$query_periodo = "select * from periodo p,carreraperiodo c,carrera ca 
where p.codigoperiodo = c.codigoperiodo
and  c.codigocarrera = ca.codigocarrera
and c.codigocarrera = '$carrera'
and p.codigoestadoperiodo like '1' 
order by p.codigoperiodo";
$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
$totalRows_periodo = mysql_num_rows($periodo);
$row_periodo = mysql_fetch_assoc($periodo);

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,s.nombresituacioncarreraestudiante,ec.codigocarrera 
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,situacioncarreraestudiante s,estudiante ec
WHERE e.codigocarrera = '$carrera'
AND eg.idestudiantegeneral = i.idestudiantegeneral 
AND ec.idestudiantegeneral = i.idestudiantegeneral
AND ec.codigocarrera = e.codigocarrera  
AND s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante 
AND eg.idciudadnacimiento = ci.idciudad 
AND i.idinscripcion = e.idinscripcion 
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica 
AND i.codigoperiodo = '".$row_periodo['codigoperiodo']."'
AND ec.codigoperiodo = i.codigoperiodo
AND i.codigosituacioncarreraestudiante = 300 
AND i.codigoestado LIKE '1%' 
ORDER BY eg.apellidosestudiantegeneral ";
$data = mysql_query($query_data, $sala) or die("$query_data".mysql_error());
$totalRows_data = mysql_num_rows($data);
$row_data = mysql_fetch_assoc($data);
?>

<script language="JavaScript" src="calendario/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="inscripcion" method="post" action="">
<table width="70%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">
 <tr>
  <td>
	 <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
       <tr>
       <td colspan="2" align="center" bgcolor="#CCDADD" class="Estilo2"><a href="aspirantespreinscritos.php">Inscritos</a></td>
       <td colspan="2" align="center" bgcolor="#CCDADD" class="Estilo2"><a href="aspirantesinscritos.php">Admitidos</a></td>
      </tr>
<?php 
  if ($row_data <> "")
   { // if 1
?>		 
	  <tr>
      <td class="Estilo2" align="center" colspan="4" bgcolor="#CCDADD"><?php echo $row_periodo['nombrecarrera'] ?></td>
      </tr>
	  <tr>
       <td class="Estilo2" align="center" colspan="4" bgcolor="#CCDADD">LISTADO DE ESTUDIANTES INSCRITOS PARA <?php echo $row_periodo['nombreperiodo'] ?></td>
      </tr>
	  <tr bgcolor="#CCDADD">
       <td width="18%" class="Estilo2"><div align="center">Documento</div></td>
	   <td colspan="2" class="Estilo2"><div align="center">Nombre</div></td>
	   <td width="31%" class="Estilo2"><div align="center">Estado</div></td>
	   </tr>
<?php 
	     do{
?>
		   <tr>
              <td class="Estilo1"><div align="center"><?php echo $row_data['numerodocumento'] ?> </div></td>
			  <td colspan="2" class="Estilo1"><div align="center"><?php echo $row_data['apellidosestudiantegeneral'] ?> <?php echo $row_data['nombresestudiantegeneral'] ?> </div></td>
		      <td class="Estilo1"><div align="center"><?php echo $row_data['nombresituacioncarreraestudiante'];?></div></td>
		   </tr>
<?php		 
		 }while($row_data = mysql_fetch_assoc($data));

?>

    </table>	
<?php 
   } // if 1
?>
   </td>
 </tr>
</table>

<br><br>
<div align="center">
<!--  <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->

   <input type="hidden" name="grabado" value="grabado">
</div>
</form>
 <script language="javascript">
function HabilitarTodos(chkbox, seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if(elemento.type == "checkbox")
		{
			if (elemento.title == "estudiante")
			{
				elemento.checked = chkbox.checked
			}
		}
	}
}

function grabar()
 {
  document.inscripcion.submit();
 }
</script> 