<?php
    
// Esta funciï¿½ retorna el porcentaje de diligenciaciï¿½ de un formulario 
// El cero indica que el campo no ha sido diligenciado
function valida_formulario($query_seltabla, $db)
{
	$tablaini = 0;
	$strcampo = "";
	//print_r($querys);
	$cuentavacios = 0;
	$cuentacampos = 0;
	if(isset($query_seltabla)&&$query_seltabla!=""){

	$seltabla = $db->Execute($query_seltabla);
	$totalRows_seltabla = $seltabla->RecordCount();
	$ratadiligenciada = 0;
	if($totalRows_seltabla != "")
	{
		$row_seltabla = $seltabla->FetchRow();
        $cuentallenos =0;
		if(is_array($row_seltabla))
		foreach($row_seltabla as $campo => $valor)
		{
			if($valor != "" && $valor != "0" && $valor != "Campo Faltante")
			{
				$cuentallenos++;
			}
			$cuentacampos++;
		}
		$ratadiligenciada = $cuentallenos/$cuentacampos;
	}
	}
	return $ratadiligenciada;
}

function cabecera_formulario($nombremodulo, $cuentamodulos, $modulos, $row_data, $ratatotal)
{
?>
   <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr>        
        <td colspan="2" >
		   <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
		       <tr valign="top">                
<?php
	for($i= 1; $i < $cuentamodulos;$i++)
	{
		if ($i == $_REQUEST['inicial'])
		{
?>   
	    <td border='3' align='left' cellpadding='3' id="tdtitulogris">
        <label id="labelresaltado"><?php echo "$i.<br>".$nombremodulo[$i] ?></label>
		</td>
<?php
		}
		else if($ratatotal == 1 || $i < $_REQUEST['inicial'])
		{
?>
	   <td id="tdtitulonegrilla" onClick="window.location.reload('<?php echo $modulos[$i] ?>?inicial=<?php echo $i ?>')" style="cursor:pointer"><a id="aparencialink"><?php echo "$i.<br>".$nombremodulo[$i] ?></a></td>
<?PHP
		}
		else
		{
			//echo "<h1>dsd".$ratatotal[$nombremodulo[1]]."</h1>";
?>	
		<td id="tdtitulonegrilla" onClick="window.location.reload('<?php echo $modulos[$i] ?>?inicial=<?php echo $i ?>')" style="cursor:pointer"><a id="aparencialink"><?php echo "$i.<br>".$nombremodulo[$i] ?></a></td>
	<!--Comentado para agilizar inscripciones de medicina 19-10-2007 E.G.R
	 <td id="tdtitulonegrilla" onClick="alert('Debe terminar de diligenciar los campos requeridos de este formulario y dar clic en enviar para poder continuar')" style="cursor:pointer"><a id="apariencialink"><?php echo "$i.<br>".$nombremodulo[$i] ?></a></td> -->
<?php
		}
	}				   
?>		
               </tr>	   
		   </table>
		</td>
      </tr>	 
<?php 
	if ($_SESSION['inscripcionsession'] <> "")
	{
?>
	  <tr id="trgris">
        <td id="tdtitulogris">Nombre</td>
        <td><?php echo $row_data['nombresestudiantegeneral'];?> <?php echo $row_data['apellidosestudiantegeneral'];?></td>
    </tr>
      <tr id="trgris">
        <td id="tdtitulogris">Modalidad Acad&eacute;mica</td>
        <td><?php echo $row_data['nombremodalidadacademica'];?></td>
      </tr> 
      <tr id="trgris">
        <td id="tdtitulogris">Nombre del Programa</td>
        <td><?php echo $row_data['nombrecarrera'];?></td>
      </tr>
<?php 
	} // if ($_SESSION['inscripcionsession'])
?>
    </table> 
<?php
}

function barra($nombre, $porcentaje)
{
	//ANCHO DE NUESTRA BARRA
	$ancho = 1;

	//LARGO Mï¿½IMO
	$largo = 10;
?>
<table width="40%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr id="trtitulogris">
<td colspan="2"><?php echo $nombre; ?></td>
</tr>
<tr>
<td width="70%"><img src="../../../../imagenes/punto.gif" height="<?php echo $largo ?>" width="<?php echo $porcentaje ?>%" style="color:#FEF7ED"></td>
<td width="30%"><?php echo round($porcentaje,1)." %"; ?></td>
</tr>
</table>
<br>
<?php
}
?>
