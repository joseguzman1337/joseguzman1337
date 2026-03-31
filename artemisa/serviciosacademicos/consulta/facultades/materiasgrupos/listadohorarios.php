<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();





$materiasunserial = unserialize(stripcslashes($_GET['materiassinhorarios']));





// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre


$materiaselegidas = $materiasunserial;





$materiasserial = serialize($materiasunserial);


/*foreach($materiasunserial as $llave => $codigomateria)


{


	echo "$llave => $codigomateria<br>";


}


exit();*/


?>


<html>


<head>


<title>Listado De Horarios</title>


<style type="text/css">


<!--


.Estilo1 {font-weight: bold}


.Estilo2 {font-size: small}


.Estilo3 {font-size: xx-small}


-->


</style>





</head>


<body>


<?php


$codigocarrera = '100';


$codigoperiodo = '20052';





// Seleccion de las materias del plan de estudio


$query_materiasplanestudio = "select distinct d.codigomateria, m.nombremateria, 


d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 


t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, m.idgrupomateria


from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t


where p.idplanestudio = d.idplanestudio


and p.codigoestadoplanestudioestudiante like '1%'


and d.codigoestadodetalleplanestudio like '1%'


and d.codigomateria = m.codigomateria


and d.codigotipomateria = t.codigotipomateria


and m.codigocarrera = '$codigocarrera'


order by 3,4";


//echo "$query_horarioinicial<br>";


$materiasplanestudio = mysql_db_query($database_sala,$query_materiasplanestudio) or die("$query_materiasplanestudio");


$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);


while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))


{


	$materiasplan[] = $row_materiasplanestudio;


	// Para cada materia selecciono los grupos sin horario


	$codigomateria = $row_materiasplanestudio['codigomateria'];


	// Para cada materia selecciono los grupos sin horario


	$query_grupoinicial = "SELECT g.nombregrupo, g.idgrupo,	g.codigoindicadorhorario, 


	concat(d.apellidodocente,' ',d.nombredocente) as nombre, g.matriculadosgrupo, g.maximogrupo


	FROM grupo g, docente d 


	where g.codigoperiodo = '$codigoperiodo' 


	and g.codigomateria = '".$row_materiasplanestudio['codigomateria']."'


	and g.codigoestadogrupo like '1%'


	and d.numerodocumento = g.numerodocumento";


	//echo "$query_horarioinicial<br>";


	$grupoinicial=mysql_db_query($database_sala,$query_grupoinicial);


	$totalRows_grupoinicial = mysql_num_rows($grupoinicial);


	if($totalRows_grupoinicial != "")


	{


		while($row_grupoinicial = mysql_fetch_array($grupoinicial))


		{


			$idgrupo = $row_grupoinicial['idgrupo'];


			$grupos[$codigomateria][] = $row_grupoinicial;


			$query_horarioinicial = "select h.horainicial, h.horafinal, h.codigotiposalon, h.codigosalon, s.nombresalon, d.nombredia


			from horario h, dia d, salon s


			where h.idgrupo = '$idgrupo'


			and h.codigosalon = s.codigosalon


			and h.codigodia = d.codigodia";


			//echo "$query_horarioinicial<br>";


			$horarioinicial=mysql_db_query($database_sala,$query_horarioinicial);


			$totalRows_horarioinicial = mysql_num_rows($horarioinicial);


			if($totalRows_horarioinicial != "")


			{


				while($row_horarioinicial = mysql_fetch_array($horarioinicial))


				{


					$horarios[$idgrupo][] = $row_horarioinicial; 


				}


			}


		}


	}


}


?>


<style type="text/css">


<!--


.Estilo1 {


	font-family: tahoma;


	font-size: xx-small;


}


.Estilo2 {font-size: xx-small}


.Estilo3 {font-size: x-small}


-->


</style>


<form name="form1" method="post" action='listadohorarios.php?programausadopor=<?php echo $_GET['programausadopor']."&materiassinhorarios=$materiasserial&".$_POST['tieneenfasis']."";?>'>   


<div align="center" class="Estilo2">


  <p align="center"><span class="Estilo1 Estilo6 Estilo3"><strong><font size="2" face="Tahoma">HORARIOS 


    </font></strong></span></p>


  <p class="Estilo1"> <font size="2" face="Tahoma"> 


  </font></p>


<?php


// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante


$semestre = 0;


foreach($materiasplan as $llave => $materias)


{


	$codigomateria = $materias['codigomateria'];


	$semestrenuevo = $materias['semestredetalleplanestudio'];


	if($semestrenuevo != $semestre)


	{


?>


	<p><strong>Semestre <?php echo $semestrenuevo; ?></strong></p>


<?php


		$semestre = $semestrenuevo;


	}


	//echo "$codigomateria".${$codigomateria}; 


?>


  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" width="700">


    <tr> 


      <td bgcolor="#607766" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1" colspan="8"><div align="center"></div>


        <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo "<font color = \"#FFFFFF\">",$materias['nombremateria'];?></span></font></div>


      <div align="center"></div></td>


      <td bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center"><font size="2" face="Tahoma"><strong>C&oacute;digo</strong></font></div></td>


      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1" width="5%"><div align="center"></div>


        <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $materias['codigomateria'];?></span></font></div>


      <div align="center"></div></td>


    </tr>


<?php


	if(isset($grupos[$codigomateria]))


	{ 


		foreach($grupos[$codigomateria] as $llave2 => $grupohorario)


		{


?>


    <tr> 


      <td width="1%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Grupo</strong></font></div></td>


      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['idgrupo'];?></span></font></div></td>


      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Docente</strong></font></div></td>


      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['nombre'];?></span></font></div></td>


      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Nombre Grupo</strong></font></div></td>


      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['nombregrupo'];?></span></font></div></td><td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Max. Grupo</strong></font></div></td>


      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['maximogrupo'];?></span></font></div></td>


      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 


      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Prematri.</strong></font></div></td>


      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> <div align="center"></div>


      <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['matriculadosgrupo'];?></span></font></div></td>


    </tr>


<?php


			$idgrupo = $grupohorario['idgrupo'];


			if(isset($horarios[$idgrupo]))


			{


?>


	 <tr>


	 <td colspan="11"> 


	  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">


	    <tr bgcolor="#C5D5D6"> 


		  <td class="Estilo5 Estilo1 Estilo2"> 


			<div align="center"><font face="Tahoma"><strong>D&iacute;a</strong> 


			  </font></div>


		  <div align="center"></div></td>


		  <td class="Estilo5 Estilo1 Estilo2"><div align="center"><font face="Tahoma"><strong>H. Inicial</strong></font></div>


		  <div align="center"></div></td>


		  <td class="Estilo1 Estilo2 Estilo5 Estilo1"> 


		  <div align="center" class="Estilo2"><font face="Tahoma"><strong>H. Final</strong></font></div></td>


		  <td class="Estilo1 Estilo2 Estilo5 Estilo1"> 


		  <div align="center" class="Estilo2"><font face="Tahoma"><strong>Sal&oacute;n</strong></font></div></td>


 	    </tr>


<?php


				foreach($horarios[$idgrupo] as $llave2 => $horariogrupo)


				{	


?>


	    <tr bordercolor="#FF9900">


		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"></div>


		  <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['nombredia'];?></span></font></div></td>


		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['horainicial'];?></span></font></div></td>


		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['horafinal'];?></span></font></div></td>


		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['codigosalon'];?></span> 


			  </font></div></td>


	    </tr>


<?php


				}


?>


		<tr></tr>


		<tr></tr>


		<tr></tr>


		<tr></tr>


		<tr></tr>


		<tr></tr>


	</table>


	</td>


	</tr>


<?php


			}			


			else


			{


?>


	<tr><td colspan="11" align="center"><strong><font color="#800000">Este grupo No tiene Horario</font></strong></td></tr>


<?php


			}


		}


	}


	else


	{ 


?>


	<tr><td colspan="11" align="center"><strong><font color="#800000">Esta materia no tiene grupos</font></strong></td></tr>


<?php


	}


?>


<tr><td colspan="11">&nbsp;</td></tr>


</table>


<?php


}


?>


  <font size="2" face="Tahoma"><span class="Estilo1"> 


<p><hr></p>


</p>


  </span></font><span class="Estilo1"> </span> 


  <p align="center" class="Estilo1">


    <input name="grabar" type="submit" id="grabar" value="Grabar"  onClick="habilitar(this.form.habilita)">


&nbsp; 


<input name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.reload('matriculaautomatica.php?programausadopor=<?php echo $_GET['programausadopor'];?>')"> 


</p>


</div>


</form>


<?php


?>


<script language="javascript">


function habilitar(campo)


{


	var entro = false;


	for (i = 0; i < campo.length; i++)


	{


		campo[i].disabled = false;


		entro = true;


	}


	if(!entro)


	{


		form1.habilita.disabled = false;


	}


}


</script>


</body>


</html>