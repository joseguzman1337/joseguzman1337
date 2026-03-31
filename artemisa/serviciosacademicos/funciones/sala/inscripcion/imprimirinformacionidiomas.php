<?php
//$db->debug = true;$codigoinscripcion = $_SESSION['numerodocumentosesion'];
$query_idiomaestudiante = "SELECT *FROM estudianteidioma eWHERE  e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.codigoestado like '1%'ORDER BY 2";$idiomaestudiante = $db->Execute($query_idiomaestudiante);$totalRows_idiomaestudiante = $idiomaestudiante->RecordCount();$row_idiomaestudiante = $idiomaestudiante->FetchRow();
$sinidioma = "i.ididioma <> ".$row_idiomaestudiante['ididioma'];if ($row_idiomaestudiante <> ""){			do
	{		$sinidioma = $sinidioma ." and i.ididioma <> ".$row_idiomaestudiante['ididioma'];		//echo $sinidioma ,"<br>";	}
	while($row_idiomaestudiante = $idiomaestudiante->FetchRow());	$query_idioma = "SELECT *	FROM idioma i	WHERE ($sinidioma)						ORDER BY 2";	$idioma = $db->Execute($query_idioma);	$totalRows_idioma = $idioma->RecordCount();	$row_idioma = $idioma->FetchRow();}else{   	$query_idioma = "SELECT *    FROM idioma i								   	ORDER BY 2";	$idioma = $db->Execute($query_idioma);	$totalRows_idioma = $idioma->RecordCount();	$row_idioma = $idioma->FetchRow(); }	//echo $query_idioma;// vista previa	   $query_datosgrabados = "SELECT i.nombreidioma , e.porcentajeleeestudianteidioma, e.porcentajehablaestudianteidioma,
e.porcentajeescribeestudianteidioma, e.descripcionestudianteidioma, e.idestudianteidioma, i.ididiomaFROM estudianteidioma e, idioma iWHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'and e.ididioma = i.ididioma								 and e.codigoestado like '1%'order by nombreidioma";			  $datosgrabados = $db->Execute($query_datosgrabados);$totalRows_datosgrabados = $datosgrabados->RecordCount();$row_datosgrabados = $datosgrabados->FetchRow();if ($row_datosgrabados <> ""){ 
?>			   <table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">                <tr id="trtitulogris">					<td>Idioma</td>
					<td>Nivel</td>					<!-- <td>Lee</td>					<td>Habla</td>					<td>Escribe</td>					<td>Descripción</td> -->                </tr><?php 	do
	{
		$porcentajeidioma = ($row_datosgrabados['porcentajeleeestudianteidioma'] + $row_datosgrabados['porcentajehablaestudianteidioma'] + $row_datosgrabados['porcentajeescribeestudianteidioma']) / 3;
		if($porcentajeidioma <= 30)
			$nivel = "BASICO";
		if($porcentajeidioma > 30 && $porcentaje <= 70)
			$nivel = "INTERMEDIO";
		if($porcentajeidioma > 70)
			$nivel = "AVANZADO";
			
?>			        <tr>                     <td><?php echo $row_datosgrabados['nombreidioma'];?></td>
                     <td><?php echo $nivel; ?><?php if($row_datosgrabados['ididioma'] == 10) echo " -- ".$row_datosgrabados['descripcionestudianteidioma'];?></td>					 <!-- <td><?php echo $row_datosgrabados['porcentajeleeestudianteidioma'];?>%</td>                     <td><?php echo $row_datosgrabados['porcentajehablaestudianteidioma'];?>%</td>					 <td><?php echo $row_datosgrabados['porcentajeescribeestudianteidioma'];?>%</td>					 <td><?php echo $row_datosgrabados['descripcionestudianteidioma'];?></td>  -->					 				 </tr>			   <?php  	 }
	 while($row_datosgrabados = $datosgrabados->FetchRow());?>	    </table> <?php}else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) {?><!-- <tr><td>Sin datos diligenciados</td></tr> --><?php}	     	      //if(isset($_POST['inicial']) or isset($_GET['inicial'])) ?><script language="javascript">/*function recargar(dir){	window.location.reload("idiomas.php"+dir);	history.go();}*/</script> 