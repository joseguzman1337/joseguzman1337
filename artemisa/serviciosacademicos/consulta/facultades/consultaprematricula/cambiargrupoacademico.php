<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//require_once('sala.php'); 
?>
<?php 
require_once('../../../Connections/sala2.php'); 
session_start();
require_once('seguridadlistagrupos.php'); 

?>
<html>
<head>
<style type="text/css">
<!--
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<h2 align="center">Cambio de  grupo academico por grupo o estudiante</h2>
<h2 align="center" class="Estilo2">CUIDADO!!! No se validan cruces de horarios </h2>
<p align="center"><form name="formulario" method="post" action="cambiargrupoacademico.php">
  <table width="514" border="1">
  <tr>
    <td width="504">Digite grupo academico origen:    <input type="text" name="trasladarde">&nbsp;</td>
  </tr>
  <tr>
    <td>Digite grupo academico Destino:   <input type="text" name="trasladara">&nbsp;</td>
  </tr>
  <tr>
    <td>DIGITE CODIGO DEL ALUMNO O DEJAR EN BLANCO PARA APLICAR TODO EL GRUPO:   <input type="text" name="codigoestudiante">&nbsp;</td>
  </tr>
</table>
<br>
<input type="submit" name="aceptar" value="Aceptar"><input type="button" name="salir" value="Salir" onClick="window.close()">
</form>
<?php 
if($_POST['aceptar'])
{
	begin;
	$trasladar_de=$_POST['trasladarde'];//105;
	$trasladar_a=$_POST['trasladara'];//'2005-01-01';
	$codigoestudiante=$_POST['codigoestudiante'];//1000105;
	if ($codigoestudiante=='')
	{	
?>
<script language="javascript">
if(!confirm("Esta seguro de aplicar para todo el grupo"))
{
	history.go(-1);
}
</script>
<?php
	}
	$trasladarde="SELECT *
	from grupo g
	where g.idgrupo='".$trasladar_de."'
	and codigoestadogrupo like '1%'";
	$trasladarde1=mysql_db_query($database_sala,$trasladarde);
	$trasladarde2=mysql_fetch_array($trasladarde1);
	//echo $trasladarde;
	$trasladara="SELECT *
	from grupo g
	where g.idgrupo='".$trasladar_a."'
	and codigoestadogrupo like '1%'";
	$trasladara1=mysql_db_query($database_sala,$trasladara);
	$trasladara2=mysql_fetch_array($trasladara1);
	//echo $trasladara;
	//echo 'hola a', $trasladara2['codigomateria'], 'hola de', $trasladarde2['codigomateria'];
?>
<body>
<?php
	if ($trasladara2['codigomateria']<>$trasladarde2['codigomateria'] AND
	$trasladara2['codigomaterianovasoft']<>$trasladarde2['codigomaterianovasoft'])
	{
		echo 'Los grupos academicos no pertenecen a la misma materia, uno de los grupos esta cerrado, o no pertenece a su facultad';
		echo "<h1 align='center'>Operacion NO realizada</h1>";
	}
	else
	{
		if ($codigoestudiante=='')
		{
			// Pasar todos los almunos del grupo trasladar al grupo origenm
			  echo 'estudiante en null aplica para todo el grupos ';
			
			// traslada alumnos de grupo_de a grupo_a
			
			$modificadetalleprematriculagrupo="UPDATE detalleprematricula dp SET dp.idgrupo='".$trasladar_a."'
			WHERE dp.idgrupo='".$trasladar_de."'";
			$modificadetalleprematriculagrupo1=mysql_db_query($database_sala,$modificadetalleprematriculagrupo);

			// cambiar estado de grupo a 20 y deja matriculados grupo en cero de grupo_de
			$modificagrupoestado="UPDATE grupo set codigoestadogrupo='20', matriculadosgrupo=0
			WHERE idgrupo='".$trasladar_de."'";
			$modificagrupoestado1=mysql_db_query($database_sala,$modificagrupoestado);
			//echo $modificagrupoestado;
			
			// cuenta cuantoa alumnos hay matriculas y prematriculados
			
			$cuentaalumnos="SELECT COUNT(*) totalalumnosgrupo
			FROM detalleprematricula
			WHERE idgrupo='".$trasladar_a."'
			AND (codigoestadodetalleprematricula LIKE '1%' OR 
				codigoestadodetalleprematricula LIKE '3%')";
			$cuentaalumnos1=mysql_db_query($database_sala,$cuentaalumnos);
			$cuentaalumnos2=mysql_fetch_array($cuentaalumnos1);
			
			// actualiza total prematriculados y matriculados en grupos a
			
			$modificaalumnos="UPDATE grupo SET matriculadosgrupo='".$cuentaalumnos2['totalalumnosgrupo']."'
			WHERE idgrupo='".$trasladar_a."'";
			$modificaalumnos1=mysql_db_query($database_sala,$modificaalumnos);
			echo "<h1 align='center'>Operacion realizada</h1>";
		}
		else
		{
			echo 'Aplica solo para el codigo del alumnos digitado';
			$grupoestudiante="SELECT *
			FROM detalleprematricula dp, prematricula p
			WHERE dp.idprematricula=p.idprematricula
			AND dp.idgrupo='".$trasladar_de."'
			AND p.codigoestudiante='".$codigoestudiante."'
			AND (p.codigoestadoprematricula LIKE '1%' OR p.codigoestadoprematricula LIKE '4%')";
			$grupoestudiante1=mysql_db_query($database_sala,$grupoestudiante);
			$grupoestudiante2=mysql_fetch_array($grupoestudiante1);
			$cuentagrupoestudiante2=mysql_num_rows($grupoestudiante1);
			if ($cuentagrupoestudiante2=='')
			{
				echo 'No coinceden los datos estudiante y grupo trasladar de';
				echo "<h1 align='center'>Operacion NO realizada</h1>";
			}
			else
			{
				echo "<h1 align='center'>Operacion  realizada</h1>";
				// traslada alumnos de grupo_de a grupo_a
				
				$modificadetalleprematriculagrupoe="UPDATE detalleprematricula dp, prematricula p SET dp.idgrupo='".$trasladar_a."'
				WHERE dp.idgrupo='".$trasladar_de."'
				and p.codigoestudiante='".$codigoestudiante."'
				and p.idprematricula=dp.idprematricula";
				$modificadetalleprematriculagrupoe1=mysql_db_query($database_sala,$modificadetalleprematriculagrupoe);
				//echo $modificadetalleprematriculagrupoe;
				
				// cuanta alumnos pre y matriculados en trasladar a
					
				$cuentaalumnose="SELECT COUNT(*) totalalumnosgrupo_a
				FROM detalleprematricula
				WHERE idgrupo='".$trasladar_a."'
				AND (codigoestadodetalleprematricula LIKE '1%' OR 
					codigoestadodetalleprematricula LIKE '3%')";
				$cuentaalumnose1=mysql_db_query($database_sala,$cuentaalumnose);
				$cuentaalumnose2=mysql_fetch_array($cuentaalumnose1);
				//echo 'trasladar a', $cuentaalumnose2['totalalumnosgrupo_a'];
				if ($cuentaalumnose2['totalalumnosgrupo_a']==0)
				{
					$modificagrupoestado1="UPDATE grupo set codigoestadogrupo='20', matriculadosgrupo=0
					WHERE idgrupo='".$trasladar_a."'";
					$modificagrupoestado11=mysql_db_query($database_sala,$modificagrupoestado1);
				}
				else
				{
					$modificagrupoestado2="UPDATE grupo set matriculadosgrupo='".$cuentaalumnose2['totalalumnosgrupo_a']."'
					WHERE idgrupo='".$trasladar_a."'";
					$modificagrupoestado21=mysql_db_query($database_sala,$modificagrupoestado2);
				}
				$cuentaalumnose1="SELECT COUNT(*) totalalumnosgrupo_de
				FROM detalleprematricula
				WHERE idgrupo='".$trasladar_de."'
				AND (codigoestadodetalleprematricula LIKE '1%' OR 
					codigoestadodetalleprematricula LIKE '3%')";
				$cuentaalumnose11=mysql_db_query($database_sala,$cuentaalumnose1);
				$cuentaalumnose12=mysql_fetch_array($cuentaalumnose11);
				//echo 'trasladar de', $cuentaalumnose12['totalalumnosgrupo_de'];
				if ($cuentaalumnose12['totalalumnosgrupo_de']==0)
				{
					$modificagrupoestado3="UPDATE grupo set codigoestadogrupo='20', matriculadosgrupo=0
					WHERE idgrupo='".$trasladar_de."'";
					$modificagrupoestado31=mysql_db_query($database_sala,$modificagrupoestado3);
				}
				else
				{
					$modificagrupoestado4="UPDATE grupo set matriculadosgrupo='".$cuentaalumnose12['totalalumnosgrupo_de']."'
					WHERE idgrupo='".$trasladar_de."'";
					$modificagrupoestado41=mysql_db_query($database_sala,$modificagrupoestado4);
				}
			}
		}
	}
	commit;
//echo "<h1>Operacion realizada</h1>";
}
?>
</p>
</body>
</html>

