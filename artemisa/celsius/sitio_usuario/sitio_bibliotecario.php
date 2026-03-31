<?
$pageName ="consola_administracion";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);

$usuario = SessionHandler::getUsuario();

$id_usuario = $usuario["Id"];

$id_institucion=$usuario['Codigo_Institucion'];
$institucion=$servicesFacade->getInstitucion($id_institucion);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";
require_once "../pedidos2/funciones_mostrar_pedido.php";
?>
  

<table class="table-form" width="100%" border="0">
	<tr>
		<td width="80%" valign="top">

				
<!-- Parte de carga de pedidos-->

<table class="table-form" width="100%" cellpadding="2" cellspacing="0">
	<tr>
    	<td class="table-form-top-blue" width="50%" >
    		<img src="../images/square-w.gif" width="8" height="8" />
    		<?=$Mensajes["usr-1"]; ?>
    	</td>
		<td class="table-form-top-blue" width="50%" style="text-align:right !important">
			<a href="javascript:ayuda(0,402)"><img src="../images/help.gif" border="0" width="22" height="22"></a>
		</td>
	</tr>
	<tr>
    	<td colspan="2">
    	  <? if ($institucion['habilitado_crear_pedidos']==1){?>
    		<a href="../usuarios2/seleccionar_usuario.php?popup=false&url_destino=pedidos2/seleccionar_tipo_material.php">
    			<?=$Mensajes["usr-20"]?>
    		</a>
    	<? }else{
			 echo $Mensajes["warning.noPuedeGenerarPedidos"]; 
		 } ?>
    	</td>
    </tr>
</table>

<hr align="center" width="100%" size="1" />

<!-- Parte donde muestra si el usuario tiene pdf para descargar -->
<?
$pedidosPDF=$servicesFacade->getPedidosEnEstados(array(ESTADO__LISTO_PARA_BAJARSE),array(),"pedidos",ROL__BIBLIOTECARIO,$id_usuario);
if (!empty($pedidosPDF)){?>
	<table class="table-form" width="100%" cellpadding="2" cellspacing="0" border="0">
    <tr>
    	<tr>
        	<td class="table-form-top-blue" colspan="2" width="77%">
        		<img src="../images/square-w.gif" width="8" height="8" /><?=$Mensajes["st-001"]?>
        	</td>
			<td class="table-form-top-blue"  style="text-align:right !important" width="23%">
				<a href="javascript:ayuda(0,401)"><img src="../images/help.gif" border="0" width="22" height="22"></a>
			</td>
	   	</tr>
        <tr>
        <tr>
        	<th width="25%"  style="text-align:center !important">
        		<?= $Mensajes["campo.id"];?>
        	</th>
        	<th  style="text-align:center !important">
        		<?= $Mensajes["campo.titulo"];?> 
        	</th>
        	<th style="text-align:center !important">
        		<?= $Mensajes["campo.descargar"];?> 
        	</th>
        <tr>
		<? foreach($pedidosPDF as $pedido){?>	
	    <tr>
	    	<td style="text-align:left !important" width="20%">
	    		<?= $pedido["Id"]?>
	       	</td>
	   		<td style="text-align:left !important" >
	  			<?= $servicesFacade->getPedidoDescripcion($pedido);?>
	   		</td>
	  		<td style="text-align:left !important" width="30%">
	  		<? imprimirArchivosPedido($pedido["Id"], ROL__USUARIO,$usuario['habilitar_entrega_pedido']); ?>
			</td>
		</tr>
       	<?}?>
	</tr>
	</table>
	<hr align="center" width="100%" size="1" noshade/>
<? } ?>

<!-- Informacion sobre los pedidos -->
<table class="table-form" width="100%" cellpadding="2" cellspacing="0">
	<tr>
    	<td class="table-form-top-blue" width="50%" >
    		<img src="../images/square-w.gif" width="8" height="8">
    		<?=$Mensajes["st-002"]; ?>
    	</td>
    	<td class="table-form-top-blue"  width="50%" style="text-align:right !important">
    		<a href="javascript:ayuda(0,402)"><img src="../images/help.gif" border="0" width="22" height="22"></a>
    	</td>
    </tr>
	<tr>
    	<td>
	  		<? /** PEDIDOS EN CURSO **/
			$cantidadPedidosEnCurso=$servicesFacade->getCountPedidosEnEstados(array(ESTADO__PENDIENTE,ESTADO__BUSQUEDA,ESTADO__SOLICITADO),array(),"pedidos",ROL__BIBLIOTECARIO,$id_usuario);
			if ($cantidadPedidosEnCurso>1){?>
	   			<a href="../pedidos2/listar_pedidos_usuario.php?estado[]=<?= ESTADO__PENDIENTE ?>&estado[]=<?= ESTADO__BUSQUEDA?>&estado[]=<?= ESTADO__SOLICITADO?>" class='style22'>
	             	<?=$cantidadPedidosEnCurso ?>&nbsp;<?=$Mensajes["usr-2"]; ?>
				</a>
	        <?}elseif ($cantidadPedidosEnCurso==1){?>
	             <a href="../pedidos2/listar_pedidos_usuario.php?estado[]=<?= ESTADO__PENDIENTE ?>&estado[]=<?= ESTADO__BUSQUEDA?>&estado[]=<?= ESTADO__SOLICITADO?>" class='style22'>
	             	<?=$cantidadPedidosEnCurso ?>&nbsp;<?=$Mensajes["usr-3"]; ?>
				</a>
	        <?}else{ ?>
	        	<?=$Mensajes["usr-4"]; ?>
	        <?}?>
        </td>
        
 		<td>
			<?
			/** PEDIDOS LISTOS PARA ENTREGAR **/
			$cantidadPedidosListoParaEntregar=$servicesFacade->getCountPedidosEnEstados(array(ESTADO__RECIBIDO,ESTADO__LISTO_PARA_BAJARSE),array(),"pedidos",ROL__BIBLIOTECARIO,$id_usuario);
			
			if( $cantidadPedidosListoParaEntregar>1){?>
	           	 <a href="../pedidos2/listar_pedidos_usuario.php?estado[]=<?= ESTADO__RECIBIDO ?>&estado[]=<?= ESTADO__LISTO_PARA_BAJARSE ?>" class='style22'>
	             	<?=$cantidadPedidosListoParaEntregar." ".$Mensajes['usr-5']?>
	             </a>
	       	<?}elseif ($cantidadPedidosListoParaEntregar==1){?>
				<a href="../pedidos2/listar_pedidos_usuario.php?estado[]=<?= ESTADO__RECIBIDO ?>&estado[]=<?= ESTADO__LISTO_PARA_BAJARSE ?>" class='style22'>
	             	<?=$cantidadPedidosListoParaEntregar." ".$Mensajes['usr-6']?>
	             </a>
	        <?}else{
	        		echo $Mensajes["usr-7"];
	        }?>
        </td>
    </tr>

	<tr>
		<td>
    		<a href="../pedidos2/listar_pedidos_usuario.php?tablaPedidos=pedhist"><? echo $Mensajes["usr-18"]; ?></a>
    	</td>
    	<td>
	        <? /** PEDIDOS PENDIENTES DE ATENCION **/
			$cantidadPedidosPendienteAtencion=$servicesFacade->getCountPedidosEnEstados(array(ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO),array(),"pedidos",ROL__BIBLIOTECARIO,$id_usuario);
			if ($cantidadPedidosPendienteAtencion > 1 ){?>
	             <a href="../pedidos2/listar_pedidos_usuario.php?estado=<?= ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO ?>" class='style22'>
	             	<?= $cantidadPedidosPendienteAtencion." ".$Mensajes['usr-8'] ?>
	             </a>
	        <?}elseif ($cantidadPedidosPendienteAtencion==1){?>
	             <a href="../pedidos2/listar_pedidos_usuario.php?estado=<?= ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO ?>" class='style22'>
	             	<?= $cantidadPedidosPendienteAtencion." ".$Mensajes['usr-9'] ?>
	             </a>
	        <?}else{
	              echo $Mensajes["usr-10"];
	        }?>
		</td>
	</tr>
	
</table>

<hr align="center" width="100%" size="1" noshade />

<table class="table-form" width="100%" cellpadding="2" cellspacing="0">
    <tr>
	    <td class="table-form-top-blue" colspan="2" width="95%">
	    	<img src="../images/square-w.gif" width="8" height="8">
	    	<? echo $Mensajes["usr-13"]; ?>
	    </td>
	    <td class="table-form-top-blue" align="right">
	    	<a href="javascript:ayuda(0,403)"><img src="../images/help.gif" border="0" width="22" height="22"></a>
	    </td>
    </tr>
    <tr>
    	<td><img src="../images/user.gif" width="18" height="18"></td>
       	<td><a href="../usuarios2/modificar_usuario_bibliotecario.php?operacion=0"><? echo $Mensajes["st-003"]; ?></a></td>
       	<td>&nbsp;</td>
    </tr>
	<tr>
     	<td><img src="../images/edit_user.gif" width="18" height="18"></td>
        <td><a href="../usuarios2/seleccionar_usuario.php?popup=false&url_destino=usuarios2/modificar_usuario_bibliotecario.php?operacion=1"><? echo $Mensajes["st-004"]; ?></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td><img src="../images/arrow_right.gif" width="16" height="11"></td>
        <td><a href="../pedidos2/listar_pedidos_por_usuario.php"><? echo $Mensajes["link.listarPedidos"]; ?></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td><img src="../images/m_2_s.gif" width="16" height="11"></td>
        <td><a HREF="../mail/listado_mail_usuarios.php"><? echo $Mensajes["usr-14"]; ?></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
		<td><img src="../images/estadisticas.gif" width="18" height="18"></td>
      	<td><a href="../estadisticas/us_pedinic.php" ><? echo $Mensajes["usr-15"]; ?></a></td>
      	<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img src="../images/estadisticas.gif" width="18" height="18"></td>
    	<td><a href="../estadisticas/10pedidas_us.php"><? echo $Mensajes["usr-16"]; ?></a></td>
		<td>&nbsp;</td>
	</tr>
</table>

		</td>
		<td width="20%">


<table class="table-form" cellpadding="2" cellspacing="0" width="100%">
	<tr>
		<td><?=$usuario["Apellido"].", ".$usuario["Nombres"] ?></td>
	</tr>
	<tr>
		<td><img src="../images/user.jpg" width="150" height="177"></td>
	</tr>
	<tr>
		<td>
			<img src="../images/square-w.gif" width="8" height="8">
			<a href="../usuarios2/modificar_perfil.php" ><?=$Mensajes["link.modificar_perfil"]?></a>
		</td>
	</tr>
</table>

		</td>
	</tr>
</table>

<? require "../usuarios2/verificarMensajes.php"; ?>
<? require "../layouts/base_layout_admin.php"; ?>