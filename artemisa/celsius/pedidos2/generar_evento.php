<?php
/**
 * Pagina de generacion de eventos. Segun el evento que se especifique como parametro se deberan mostrar determinados campos.
 * @param string $id_pedido El id del pedido sobre el que se va a generar el evento
 * @param string $codigo_evento El codigo del evento que se quiere generar.
 * 
 */
$pageName = "eventos1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);

if ($codigo_evento == EVENTO__A_BUSQUEDA || $codigo_evento == EVENTO__A_ENTREGADO_IMPRESO || $codigo_evento == EVENTO__A_PDF_DESCARGADO){
	//si el evento a generar es uno de los mencionados en el if ==> se registra el evento directamente.
	header("Location: guardar_evento.php?id_pedido=".$id_pedido."&codigo_evento=".$codigo_evento);
	exit;
}

$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];
$pedido = $servicesFacade->getPedido($id_pedido);

require "../layouts/top_layout_popup.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<script language="JavaScript" type="text/javascript">
  	function validar_datos_evento(){
		<? if ($codigo_evento == EVENTO__A_ESPERA_DE_CONF_USUARIO || $codigo_evento == EVENTO__A_OBSERVACION){?>
			var observaciones = document.getElementsByName('Observaciones')[0];
			if(observaciones.value == ''){
					alert('<?=$Mensajes["warning.faltaObservaciones"];?>');
					return false;
			}
		<? }elseif ($codigo_evento == EVENTO__A_SOLICITADO ){?>
				if (document.getElementsByName('Paises')[0].value == 0 ){
					alert('<?=$Mensajes["warning.faltaPais"];?>')
					return false;
				}
				if (document.getElementsByName('Instituciones')[0].value == 0 ){
					alert('<?=$Mensajes["warning.faltaInstitucion"];?>')
					return false;
				}
		<?} elseif ($codigo_evento == EVENTO__A_RECIBIDO ){?>
				if (!document.getElementById('Numero_Paginas').value){
					alert('<?=$Mensajes["warning.faltaNroPaginas"];?>')
					return false;
				}
				if (document.getElementById('formaEntregaPDF').checked){
					if (!document.getElementById('userfile').value){
						alert('<?=$Mensajes["warning.faltaCargaPDF"]?>');
						return false;
					}
				}
		<?} ?>
		return true;
	}
	function abrir_popup(url){
		ventana=window.open(url, "", "dependent=yes, toolbar=no, width=530, height=380, scrollbars=yes");
	}
	function agregar_pais(){
		abrir_popup('../paises/modificarOAgregarPais.php?popup=1', "");
	}
	function agregar_institucion(){
		if (document.getElementsByName('Paises').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaPais"];?>')
			return false;
		}
		abrir_popup('../instituciones/modificarOAgregarInstitucion.php?popup=1&Codigo_Pais=' + document.getElementsByName('Paises').item(0).value, "");
	}
	function agregar_dependencia(){
		if (document.getElementsByName('Instituciones').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaInstitucion"];?>')
			return false;
		}
		abrir_popup('../dependencias/modificarOAgregarDependencia.php?popup=1&Codigo_Institucion=' + document.getElementsByName('Instituciones').item(0).value, "");
	}
	function agregar_unidad(){
		if (document.getElementsByName('Dependencias').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaDependencia"];?>')
			return false;
		}
		abrir_popup('../unidades/modificarOAgregarUnidad.php?popup=1&Codigo_Dependencia=' + document.getElementsByName('Dependencias').item(0).value, "");
	}
</script>

<form enctype="multipart/form-data" method="post" action="guardar_evento.php" onsubmit="return validar_datos_evento();">

<table width="100%"  border="0" align="center" cellpadding="2" cellspacing="1" class="table-form">
	<tr>
    	<td colspan="2" class="table-form-top">
			<? echo $Mensajes["ec-1"]; ?>: &nbsp;<? echo $id_pedido; ?>
		</td>
    </tr>

	<? if ($codigo_evento == EVENTO__A_SOLICITADO || ($codigo_evento == EVENTO__A_RECIBIDO)){
		require "../utils/pidui.php"; 
		if ($codigo_evento == EVENTO__A_RECIBIDO)
			$soloLectura = " disabled ";
		else
			$soloLectura = "";
		?>
	    <tr>
	    	<th><? echo $Mensajes["tf-2"]; ?></th>
	    	<td>
	    		<select size="1" name="Paises" OnChange="generar_instituciones(0);" <?= $soloLectura;?> style="width:250px">
	    		</select>
	    		<input type="button" onclick="agregar_pais();" value="<?=$Mensajes["boton.agregarPais"];?>" />
	    	</td>
	    </tr>
	    <tr>
			<th><? echo $Mensajes["tf-3"]; ?></th>
			<td>
				<select size="1" name="Instituciones" OnChange="generar_dependencias(0)" <?= $soloLectura;?> style="width:250px">
	       		</select>
	       		<input type="button" onclick="agregar_institucion();" value="<?=$Mensajes["boton.agregarInstitucion"];?>" />
	       	</td>
	    </tr>
	    <tr>
			<th><? echo $Mensajes["tf-4"]; ?></th>
			<td>
				<select size="1" name="Dependencias" OnChange="generar_unidades(0)" <?= $soloLectura;?> style="width:250px">
	      		</select>
	      		<input type="button" onclick="agregar_dependencia();" value="<?=$Mensajes["boton.agregarDependencia"];?>" />
	      	</td>
	    </tr>
	    <tr>
			<th><?=$Mensajes["campo.unidad"];?></th>
			<td>
				<select name="Unidades" OnChange="generar_instancias_celsius(0)" <?= $soloLectura;?> style="width:250px">
				</select>
				<input type="button" onclick="agregar_unidad();" value="<?=$Mensajes["boton.agregarUnidad"];?>" />
			</td>
	    </tr>
		<tr>
	    	<th><?=$Mensajes["campo.instanciaCelsius"];?></th>
			<td>
				<select name="id_instancia_celsius" <?= $soloLectura;?> style="width:250px">
				</select>
			</td>
	    </tr>
    	<script language="JavaScript" type="text/javascript">
			listNames[0] = new Array();
			listNames[0]["paises"]="Paises";
			listNames[0]["instituciones"]="Instituciones";
			listNames[0]["dependencias"]="Dependencias";
			listNames[0]["unidades"]="Unidades";
			listNames[0]["instancias_celsius"]="id_instancia_celsius";
			
			<?
			
			if (!empty($id_evento_origen))
				$eventoOrigen = $servicesFacade->getEvento($id_evento_origen);
			else 
				$eventoOrigen = array("Codigo_Pais" =>0,"Codigo_Institucion" =>0,"Codigo_Dependencia" =>0,"Codigo_Unidad" =>0,"Id_Instancia_Celsius" =>'');
			
			echo "generar_paises(".$eventoOrigen["Codigo_Pais"].");\n";
			echo "generar_instituciones(".$eventoOrigen["Codigo_Institucion"].");\n";
			echo "generar_dependencias(".$eventoOrigen["Codigo_Dependencia"].");\n";
			echo "generar_unidades(".$eventoOrigen["Codigo_Unidad"].");\n";
			echo "generar_instancias_celsius('".$eventoOrigen["Id_Instancia_Celsius"]."');\n";
			?>
		</script>
    	
    	<? if ($codigo_evento == EVENTO__A_RECIBIDO){?>
    		<? if  (!empty($id_evento_origen)){?>
				<input type="hidden" name="Paises" value="<?=$eventoOrigen["Codigo_Pais"];?>">
				<input type="hidden" name="Instituciones" value="<?=$eventoOrigen["Codigo_Institucion"];?>">
				<input type="hidden" name="Dependencias" value="<?=$eventoOrigen["Codigo_Dependencia"];?>">
				<input type="hidden" name="Unidades" value="<?=$eventoOrigen["Codigo_Unidad"];?>">
				<input type="hidden" name="id_instancia_celsius" value="<?=$eventoOrigen["Id_Instancia_Celsius"];?>">
			<?} ?>
			
		    <tr>
		    	<th><? echo $Mensajes["tf-8"]; ?></th>
		    	<td><input type="text" id="Numero_Paginas" name="Numero_Paginas" size="15"/></td>
		    </tr>
		    		    
		    <tr id="formaEntrega">
		    	<th><?=$Mensajes["campo.formaDeEntrega"]; ?></th>
		    	<td> 
		    		<input type="radio" name="formaEntrega" id="formaEntregaPDF" value="pdf" checked/>
		    		<?=$Mensajes["opcion.pdf"]; ?>
		    		<br/>
		    		<input type="radio" name="formaEntrega" id="formaEntregaImpreso" value="impreso"/>
		    		<?=$Mensajes["opcion.impreso"]; ?>
		    	</td>
		    </tr>
		    <tr>
				<th><? echo $Mensajes["tf-12"]; ?></th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
					<input name="userfile" id="userfile" type="file" size="20" class="fixed" />
				</td>
		    </tr>
			<tr id="userfile1">
				<th><? echo $Mensajes["tf-12"]; ?></th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
					<input name="userfile1" id="userfile1" type="file" size="20" class="fixed" />
				</td>
			</tr>
			<tr id="userfile2">
				<th><? echo $Mensajes["tf-12"]; ?></th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
					<input name="userfile2" id="userfile2" type="file" size="20" class="fixed" />
				</td>
		    </tr>
		    <tr id="userfile3">
				<th><? echo $Mensajes["tf-12"]; ?></th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
					<input name="userfile3" id="userfile3" type="file" size="20" class="fixed" />
				</td>
		    </tr>
		    <tr id="userfile4">
				<th><? echo $Mensajes["tf-12"]; ?></th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
					<input name="userfile4" id="userfile4" type="file" size="20" class="fixed" />
				</td>
		    </tr>
		<?}//fin del evento recibido
    }?>
    
    <tr id="Es_Privado">
		<th><? echo $Mensajes["tf-6"]; ?></th>
		<td><input type="checkbox" name="Es_Privado" value="ON"></td>
    </tr>
    
    <tr id="Env_Mail">
    	<th><? echo $Mensajes["tf-9"]; ?></th>
    	<td>
    		<? 
    		$enviar_mail = $codigo_evento == EVENTO__A_CANCELADO_POR_USUARIO 
    					|| $codigo_evento == EVENTO__A_CANCELADO_POR_OPERADOR 
    					|| $codigo_evento == EVENTO__A_RECIBIDO
    					|| $codigo_evento == EVENTO__A_ESPERA_DE_CONF_USUARIO;
    		?>
    		<input type="checkbox" name="Env_Mail" value="ON" <?if ($pedido["origen_remoto"] == 1) echo "disabled"; elseif($enviar_mail) echo " checked";?>/>
    	</td>
    </tr>
    
    <tr>
		<th valign="top"><? echo $Mensajes["tf-11"]; ?></th>
		<td><textarea rows="3" name="Observaciones" cols="41"></textarea></td>
    </tr>
    
    <tr>
		<th>&nbsp;</th>
		<td>
			<input type="hidden" name="id_pedido" value="<? echo $id_pedido;?>">
			<input type="hidden" name="codigo_evento" value="<? echo $codigo_evento;?>">
			
			<!--
			<script language="JavaScript" type="text/javascript">
  				var openerURL = window.opener.location.href;
  				openerURL = openerURL.split("?");
  				openerURL = openerURL[0];
			</script>
			<input type ="hidden" name="url_destino" value="javascript: document.write(openerURL);">
  			-->
			
			<?if(!empty($id_evento_origen)){ ?>
				<input type="hidden" name="id_evento_origen" value="<?=$id_evento_origen;?>">
			<?} ?>
			<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" >
			<input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B2"  OnClick="javascript:self.close()">
		</td>
	</tr>
	
</table>
</form>


<?
require "../layouts/base_layout_popup.php" 
?>