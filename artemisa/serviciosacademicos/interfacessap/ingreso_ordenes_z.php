<?php
require_once('../Connections/sala2.php');

 mysql_select_db($database_sala, $sala);
 require('../Connections/sap.php');
 require('../funciones/zfica_sala_crea_aspirante.php');
 require('../funciones/cambia_fecha_sap.php');
 require('../funciones/zfica_crea_estudiante.php');


 $query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna,
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);

if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
	$login = array (                              // Set login data to R/3
    "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name
	"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
	"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
	"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
	"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
	"CODEPAGE"=>"1100");              												// codepage

	$rfc = saprfc_open($login);
	if(!$rfc)
	{
		// We have failed to connect to the SAP server
		//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
		//exit(1);
	}
}

//echo $row_estadoconexionexterna['mandanteestadoconexionexterna'];


 $query_periodo = "SELECT * FROM periodo
 WHERE codigoestadoperiodo = '1'";
//echo $query_data,"<br>";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$periodo = $row_periodo['codigoperiodo'];
//echo $periodo;
?>

<html>
<head>
<title>Ingreso Ordenes</title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {font-size: xx-small}
.Estilo4 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo6 {font-size: 12px}
.Estilo8 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="ingreso_ordenes_z.php?busqueda=numero";
	}
    if (tipo == 2)
	{
		window.location.href="ingreso_ordenes_z.php?busqueda=masivo";
	}
 }

function buscar()
{
    //tomo el valor del select del tipo elegido
    var busca
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
    //miro a ver si el tipo está definido
    if (busca != 0)
	{
		window.location.href="ingreso_ordenes_z.php?buscar="+busca;
	}
}
</script>
<body>
<h1>Mandante <?php echo $row_estadoconexionexterna['mandanteestadoconexionexterna']; ?></h1>
<div align="center" class="Estilo1">
<form name="f1" action="ingreso_ordenes_z.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo4">CARGAR ORDENES A SAP</p>
  <table width="500" border="1" bordercolor="#003333">
  <tr>
<!--    <td width="209" bgcolor="#C5D5D6"><div align="center"><span class="Estilo6"><strong>Ejecutar por :</strong>
<select name="tipo" onChange="cambia_tipo()">
              <option value="0">Seleccionar</option>
              <option value="1">Nro de Orden</option>
             <!--  <option value="2">Masivo</option>
            </select>
	&nbsp;
	</span></div></td>-->
	<td width="275"><span class="Estilo8">&nbsp;
<?php
	//if(isset($_GET['busqueda']))
	 {
			//if($_GET['busqueda']=="numero")
			{
				echo "Número de Orden : <input name='busqueda_numero' type='text'>";
			}
			/*if($_GET['busqueda']=="masivo")
			{
				echo "Todas las Ordenes : <input name='busqueda_masivo' type='hidden' value='todas'>";
			}*/

?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Ejecutar">
  	  &nbsp;</span></td>
  </tr>
<?php
    }
?>
</table>
<?php
if(isset($_GET['buscar']))
  {
    if (isset($_GET['busqueda_masivo']))
	 {

		     $query_sel_ordenes="SELECT distinct o.numeroordenpago
			 FROM detalleordenpago d,ordenpago o
			 where d.numeroordenpago = o.numeroordenpago
			 and (o.codigoestadoordenpago not like '4%' or o.codigoestadoordenpago not like '2%')
			 and o.codigoperiodo = '$periodo'";
			 $sel_ordenes=mysql_query($query_sel_ordenes, $sala) or die(mysql_error());
			 $row_sel_ordenes=mysql_fetch_assoc($sel_ordenes);
			 $totalRows_sel_ordenes=mysql_num_rows($sel_ordenes);

			 do{
				 $query_concepto="SELECT distinct numeroordenpago
				 FROM detalleordenpago d,concepto c
				 where (cuentaoperacionprincipal = 152 or cuentaoperacionprincipal = 153)
				 and d.codigoconcepto = c.codigoconcepto
				 and numeroordenpago = '".$row_sel_ordenes['numeroordenpago']."'";
				 $concepto=mysql_query($query_concepto, $sala) or die("$query_concepto");
				 $row_concepto=mysql_fetch_assoc($concepto);

				 if ($row_concepto <> "")
				  {
					 $numeroordenpago = $row_sel_ordenes['numeroordenpago'];
					 $subirorden = genera_prodiverso($rfc,$sala,$numeroordenpago);
				  }
				 else
				  {
					 $numeroordenpago = $row_sel_ordenes['numeroordenpago'];
					 $subirorden = crea_estudiante($rfc,$sala,$numeroordenpago,$idgrupo);
				  }
			 }while($row_sel_ordenes=mysql_fetch_assoc($sel_ordenes));

			 if ($subirorden == "0")
			 {
			   echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='ingreso_ordenes_z.php'</script>";
			 }
			else
			 {
			   echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='ingreso_ordenes_z.php'</script>";
			 }

	 }
    else
	 if (isset($_GET['busqueda_numero']) and $_GET['busqueda_numero'] == "")
	 {
	   echo '<script language="javascript">alert("Debe digitar el Número de Orden"); history.go(-1);</script>';
	 }
	else
	 if (isset($_GET['busqueda_numero']) and $_GET['busqueda_numero'] <> "")
	 {
		     $numeroordenpago = $_GET['busqueda_numero'];

			 $query_validaorden="SELECT distinct numeroordenpago
			 FROM ordenpago
			 where numeroordenpago in($numeroordenpago)";
			 $validaorden=mysql_query($query_validaorden, $sala) or die(mysql_error());
			 $row_validaorden=mysql_fetch_assoc($validaorden);
			// echo $query_validaorden;
			 //exit();
			 if (! $row_validaorden)
			 {
			   echo "<script language='javascript'>alert('Número de orden no existe en SALA'); window.location.href='ingreso_ordenes_z.php'</script>";
			 }

            do{
            $numeroordenpago = $row_validaorden['numeroordenpago'];

			 $query_concepto="SELECT distinct numeroordenpago
			 FROM detalleordenpago d,concepto c
			 where (cuentaoperacionprincipal = 152 or cuentaoperacionprincipal = 153)
			 and d.codigoconcepto = c.codigoconcepto
			 and numeroordenpago in($numeroordenpago)";
			 $concepto=mysql_query($query_concepto, $sala) or die("$query_concepto");
			 $row_concepto=mysql_fetch_assoc($concepto);
             //echo $query_concepto;

			 if ($row_concepto <> "")
			  {
			    $subirorden = genera_prodiverso($rfc,$sala,$numeroordenpago,$idgrupo = 1);
                echo $subirorden;
			  }
			 else
			  {

				$subirorden = crea_estudiante($rfc,$sala,$numeroordenpago,$idgrupo);
			    echo $subirorden ;
			  }

            }
            while($row_validaorden=mysql_fetch_assoc($validaorden));

			if ($subirorden == "0")
			 {
			   echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='ingreso_ordenes_z.php'</script>";
			 }
			else
			 {
			   echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='ingreso_ordenes_z.php'</script>";
			 }
	 }
  }
?>
</form>
</div>
</body>
</html>

