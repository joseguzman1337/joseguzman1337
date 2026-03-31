<?
 if (!empty($usuarios)){
 	
 
?>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="table-list">
	<tr>
		<td colspan="3" class="table-list-top">
			<img src="../images/square-lb.gif" width="8" height="8">
			
		</td>
	</tr>
<?
	foreach ($usuarios as $usuarioI){
		if ($usuarioI['Personal']==1)
			$color = "#DFE9EC";
		elseif ($usuarioI['Bibliotecario']>=1)
			$color = "#C4D5DB";
		else
			$color = "inherit";
?>
	<tr style="background-color:<?=$color?>">
		<td width="30%">
		<strong>    
		<? if (($usuarioI['habilitado_crear_pedidos']==1)||(empty($generarPedido))){?>
				<a href="javascript: retornaCon('<?= $usuarioI['Apellido']. ', '. $usuarioI['Nombres'];?>','<?= $usuarioI['Id'] ?>');">
							<?=$usuarioI['Apellido'].", ".$usuarioI['Nombres']; ?>
				</a>
			<? } ?>	
			
			</strong>
			</td>
			<td><?= $usuarioI['Nombre_Institucion']." - ".$usuarioI['Nombre_Dependencia']." - ".$usuarioI['Nombre_Unidad']; ?></td>
			<td>
				<a href="mostrar_usuario.php?id_usuario=<?= $usuarioI['Id'] ?>">
						<img border="0" src="../images/action_forward.gif">
				</a>
			</td>
		</tr>
	<? } ?>
</table>
<?
 }else{?>
     No Existen usuarios para el PIDU seleccionado(TRAD!!)	
<? }
?>