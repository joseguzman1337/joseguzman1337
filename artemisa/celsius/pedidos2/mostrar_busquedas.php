<?php

/**
 * @param string id_pedido
 */
$pageName="busquedas_catalogo";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>
  
<script language="JavaScript" type="text/javascript">

	function registrar_busqueda(id_pedido, id_catalogo, resultado_busqueda, abrir_popup){
		var url = "registrar_busqueda.php?id_pedido="+id_pedido + "&id_catalogo=" + id_catalogo;
		if (abrir_popup){
			ventana=window.open(url, "Busqueda", "dependent=yes,toolbar=no,width=530 ,height=380");
		}else{
			url = url + "&resultado_busqueda=" + resultado_busqueda;
			retrieveNoResultURL(url);
		}
	}
</script>
 
<table border="0" align="center" cellpadding="3" cellspacing="0" class="table-list">
	<tr>
		<td colspan="5" class="table-form-top">
			<?= $Mensajes["tit-1"] ?> <span style="color: #66FFFF"><?= $id_pedido; ?></span>
		</td>
	</tr>
    <tr>
    	<th>&nbsp;</th>
		<th><? echo $Mensajes["tf-1"]; ?></th>
		<th><? echo $Mensajes["tf-2"]; ?></th>
		<th><? echo $Mensajes["tf-3"]; ?></th>
		<th><? echo $Mensajes["campo.acciones"];?></th>
	</tr>
	
	<?
	$busquedasPedido = $servicesFacade->getBusquedasPedido($id_pedido);
	$i = 0;
	foreach($busquedasPedido as $catalogoBuscado){?> 
		<tr>
			<?
				$resultado_busqueda = empty($catalogoBuscado["Resultado_Busqueda"])?0:$catalogoBuscado["Resultado_Busqueda"];
				if ($resultado_busqueda == 1)
					$color="green";
				elseif ($resultado_busqueda == 2)
					$color="yellow";
				elseif ($resultado_busqueda == 3)
					$color="red";
				else
					$color="inherit";
			?>
			<td><div style="width:10px; height:15px; background-color:<?=$color;?>"></div></td>
	    	<td>
				<span style="color:#006699"><?= $catalogoBuscado["Nombre_Catalogo"]; ?></span>
				<br/>
				<? if (!empty($catalogoBuscado["URL_Catalogo"])){
					$url_catalogo = htmlentities($catalogoBuscado["URL_Catalogo"]); ?>
					<a href="<?= $url_catalogo ?>" target="_blank">
						<?= (strlen($url_catalogo) < 50)?$url_catalogo:substr($url_catalogo, 0, 50)."..."; ?>
					</a>
					<?
				}?>
			</td>
			<td bgcolor="#CCCCCC" style="color:#666666">
				<?= empty($catalogoBuscado["Fecha_Busqueda"])?"":$catalogoBuscado["Fecha_Busqueda"] ?>
			</td>
			<td>
				
				<select id="resultado_busqueda<?=$i?>" size="1" onchange="registrar_busqueda('<?= $id_pedido ?>',<?= $catalogoBuscado["Id_Catalogo"] ?>,this.value, false)" style="width:150px">
					<option value="0" <? if ($resultado_busqueda == 0) echo "selected"; ?>><?= $Mensajes["ley-1"];?></option><!-- No Buscado -->
				    <option value="1" <? if ($resultado_busqueda == 1) echo "selected"; ?>><?= $Mensajes["ley-2"];?></option><!-- Documento Hallado -->
				    <option value="2" <? if ($resultado_busqueda == 2) echo "selected"; ?>><?= $Mensajes["ley-3"];?></option><!-- Título Hallado -->
				    <option value="3" <? if ($resultado_busqueda == 3) echo "selected"; ?>><?= $Mensajes["ley-4"];?></option><!-- Título no hallado -->
				</select>
				<script language="JavaScript" type="text/javascript" >
					document.getElementById("resultado_busqueda<?=$i?>").selectedIndex = <?= $resultado_busqueda; ?>;
				</script>
  
  			</td>
			<td bgcolor="#CCCCCC">
				<input type="button" value="<?= $Mensajes["boton.mas"];?>" onclick="registrar_busqueda('<?= $id_pedido; ?>',<?= $catalogoBuscado["Id_Catalogo"]; ?>,0, true);" />
			</td>
		</tr>
		<? $i++; 
	} ?>
</table>

<br/><br/>
<input type="button" name="name" value="cerrar" onclick="window.opener.location.reload();self.close();"/>

  
<? require "../layouts/base_layout_popup.php"; ?>