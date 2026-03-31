<?
/**
 * Cambia el tipo de material de un pedido
 * 
 * @param string id_pedido
 * @param integer tipoOrigen
 * @param integer tipoDestino 
 */
$pageName="pedidos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
	
$usuario = SessionHandler::getUsuario();

//$campos = array();
//$campos[revista,libro]=$campos[libro, revista]= array(nombre_campo_origen => nombre_campo_destino);

/*matrices para hacer el matching de los tipos de materiales. Por cada tipo de material origen ---> los campos correspondientes en cada tipo de material destino*/
$campos_revista= array( 
				 "Codigo_Titulo_Revista"=>array(TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'') , 
	 			 "Titulo_Revista"       =>array(TIPO_MATERIAL__LIBRO=>'Titulo_Libro', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'TituloTesis', TIPO_MATERIAL__CONGRESO=>'TituloCongreso'),
	 			 "Titulo_Articulo"		=>array(TIPO_MATERIAL__LIBRO=>'Capitulo_Libro', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
	 			 "Volumen_Revista"		=>array(TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
	 			 "Autor_Detalle1"		=>array(TIPO_MATERIAL__LIBRO=>'Autor_Libro', TIPO_MATERIAL__PATENTE=>'Autor_Detalle1', TIPO_MATERIAL__TESIS=>'AutorTesis', TIPO_MATERIAL__CONGRESO=>'Autor_Detalle1'),
	 			 "Numero_Revista"		=>array(TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'Numero_Patente', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'NumeroLugar'),
	 			 "Anio_Revista"			=>array(TIPO_MATERIAL__LIBRO=>'Anio_Libro', TIPO_MATERIAL__PATENTE=>'Anio_Patente', TIPO_MATERIAL__TESIS=>'Anio_Tesis', TIPO_MATERIAL__CONGRESO=>'Anio_Congreso'),
	 			 "Pagina_Desde"			=>array(TIPO_MATERIAL__LIBRO=>'Pagina_Desde', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
	 			 "Pagina_Hasta"			=>array(TIPO_MATERIAL__LIBRO=>'Pagina_Hasta', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'')
	 		     );
$campos_libro=   array( 
				 "Titulo_Libro"			=>array(TIPO_MATERIAL__REVISTA=>'Titulo_Revista', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'TituloTesis', TIPO_MATERIAL__CONGRESO=>'TituloCongreso'),
				 "Autor_Libro"			=>array(TIPO_MATERIAL__REVISTA=>'Autor_Detalle1', TIPO_MATERIAL__PATENTE=>'Autor_Detalle1', TIPO_MATERIAL__TESIS=>'AutorTesis', TIPO_MATERIAL__CONGRESO=>'Autor_Detalle1'),
				 "Anio_Libro"			=>array(TIPO_MATERIAL__REVISTA=>'Anio_Revista', TIPO_MATERIAL__PATENTE=>'Anio_Patente', TIPO_MATERIAL__TESIS=>'Anio_Tesis', TIPO_MATERIAL__CONGRESO=>'Anio_Congreso'),
				 "Editor_Libro"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Desea_Indice"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Capitulo_Libro"		=>array(TIPO_MATERIAL__REVISTA=>'Titulo_Articulo', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Pagina_Desde"			=>array(TIPO_MATERIAL__REVISTA=>'Pagina_Desde', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>''),
	 			 "Pagina_Hasta"			=>array(TIPO_MATERIAL__REVISTA=>'Pagina_Hasta', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'')
				 );
$campos_patente= array( 
				 "Codigo_Pais_Patente" 	=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__TESIS=>'Codigo_Pais_Tesis', TIPO_MATERIAL__CONGRESO=>'Codigo_Pais_Congreso'),
				 "Anio_Patente"			=>array(TIPO_MATERIAL__REVISTA=>'Anio_Revista', TIPO_MATERIAL__LIBRO=>'Anio_Libro', TIPO_MATERIAL__TESIS=>'Anio_Tesis', TIPO_MATERIAL__CONGRESO=>'Anio_Congreso'),
				 "Autor_Detalle1"		=>array(TIPO_MATERIAL__REVISTA=>'Autor_Detalle1', TIPO_MATERIAL__LIBRO=>'Autor_Libro', TIPO_MATERIAL__TESIS=>'AutorTesis', TIPO_MATERIAL__CONGRESO=>'Autor_Detalle1'),
				 "Numero_Patente"		=>array(TIPO_MATERIAL__REVISTA=>'Numero_Revista', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'NumeroLugar'),
				 "Pais_Patente"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__TESIS=>'', TIPO_MATERIAL__CONGRESO=>'')
			     );
$campos_tesis=   array( 
				 "TituloTesis"					=>array(TIPO_MATERIAL__REVISTA=>'Titulo_Revista', TIPO_MATERIAL__LIBRO=>'Titulo_Libro', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>'TituloCongreso'),
				 "AutorTesis"					=>array(TIPO_MATERIAL__REVISTA=>'Autor_Detalle1', TIPO_MATERIAL__LIBRO=>'Autor_Libro', TIPO_MATERIAL__PATENTE=>'Autor_Detalle1', TIPO_MATERIAL__CONGRESO=>'Autor_Detalle1'),
				 "Codigo_Pais_Tesis"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'Codigo_Pais_Patente', TIPO_MATERIAL__CONGRESO=>'Codigo_Pais_Congreso'),
				 "Anio_Tesis"					=>array(TIPO_MATERIAL__REVISTA=>'Anio_Revista', TIPO_MATERIAL__LIBRO=>'Anio_Libro', TIPO_MATERIAL__PATENTE=>'Anio_Patente', TIPO_MATERIAL__CONGRESO=>'Anio_Congreso'),
				 "DirectorTesis"				=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "GradoAccede"					=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Otro_Pais_Tesis"				=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>'Otro_Pais_Congreso'),
				 "Codigo_Institucion_Tesis"		=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Otra_Institucion_Tesis"		=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Codigo_Dependencia_Tesis"		=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "Otra_Dependencia_Tesis"		=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>''),
				 "PagCapitulo"					=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__CONGRESO=>'PaginaCapitulo')
				 );
$campos_congreso= array(
				"TituloCongreso"				=>array(TIPO_MATERIAL__REVISTA=>'Titulo_Revista', TIPO_MATERIAL__LIBRO=>'Titulo_Libro', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'TituloTesis'),
				"Codigo_Pais_Congreso"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'Codigo_Pais_Patente', TIPO_MATERIAL__TESIS=>'Codigo_Pais_Tesis'),
				"Anio_Congreso"					=>array(TIPO_MATERIAL__REVISTA=>'Anio_Revista', TIPO_MATERIAL__LIBRO=>'Anio_Libro', TIPO_MATERIAL__PATENTE=>'Anio_Patente', TIPO_MATERIAL__TESIS=>'Anio_Tesis'),
				"NumeroLugar"					=>array(TIPO_MATERIAL__REVISTA=>'Numero_Revista', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'Numero_Patente', TIPO_MATERIAL__TESIS=>''),
				"Autor_Detalle1"				=>array(TIPO_MATERIAL__REVISTA=>'Autor_Detalle1', TIPO_MATERIAL__LIBRO=>'Autor_Libro', TIPO_MATERIAL__PATENTE=>'Autor_Detalle1', TIPO_MATERIAL__TESIS=>'AutorTesis'),
				"Otro_Pais_Congreso"			=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'Otro_Pais_Tesis'),
				"PaginaCapitulo"				=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'PagCapitulo'),
				"PonenciaActa"					=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>''),
				"Organizador"					=>array(TIPO_MATERIAL__REVISTA=>'', TIPO_MATERIAL__LIBRO=>'', TIPO_MATERIAL__PATENTE=>'', TIPO_MATERIAL__TESIS=>'')
				);

$matrices= array(TIPO_MATERIAL__REVISTA  => $campos_revista, TIPO_MATERIAL__LIBRO    => $campos_libro, TIPO_MATERIAL__PATENTE  => $campos_patente, TIPO_MATERIAL__TESIS    => $campos_tesis, TIPO_MATERIAL__CONGRESO => $campos_congreso);

if ((!empty($tipoOrigen)) and (!empty($tipoDestino))) {
	
	$res= $servicesFacade->cambiar_tipo_material($id_pedido, $tipoOrigen, $tipoDestino, $matrices[$tipoOrigen]);
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.cambioTipoMaterial"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	?>
	<div align="center">
		<?=$Mensajes["mensaje.tipoMaterialCambiado"];?>
		<script language="JavaScript" type="text/javascript">
  			window.opener.location.reload();
			setTimeout('self.close()',4000)
		</script>
		<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
}
else{

	$cond= "Tipo_Material";
	$datosPedido= $servicesFacade->getPedido($id_pedido, "pedidos", $cond);
	$tipoOrigen= $datosPedido["Tipo_Material"];
	$tipos_material = TraduccionesUtils::Traducir_Tipos_Material($VectorIdioma);
	?>
	
	<script language="JavaScript" type="text/javascript">
		
		function valida_entrada(){
	 		var tipo_origen= document.getElementById("tipoOrigen").value;
	 		var tipo_destino= document.getElementById("tipoDestino").value;
	 		
	 		if (tipo_origen==tipo_destino){
		  		alert ('<?=$Mensajes["warning.tiposIguales"];?>');
		  		return false;	  
			}
			
			var entrar = confirm("<?=$Mensajes["confirm.cambiarTipoMaterial"];?>");
			if (!entrar)
				return false;
			else
				return true;
		}
	</script>
	
	<form method="POST" name="form1" action="cambiar_tipo_material.php" onsubmit="return valida_entrada();">
		<input type="hidden" name="id_pedido" value="<?=$id_pedido?>">
		<input type="hidden" name="tipoOrigen" id="tipoOrigen" value="<?=$tipoOrigen?>">
				
	<table  width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="table-form">
		<tr>
	    	<td colspan="2" class="table-form-top">
				<?=$Mensajes["titulo.tipoMaterial"]; ?>: &nbsp;<? echo $id_pedido; ?>
			</td>
	    </tr>
		<tr>
	    	<th><?=$Mensajes["campo.tipoOrigen"]; ?>: </th>
	    	<td><? echo TraduccionesUtils :: Traducir_Tipo_Material($VectorIdioma, $tipoOrigen);?> </td>
		</tr>
	  	<tr>
		   	<th><?=$Mensajes["campo.tipoDestino"];?>: </th>
	    	<td>
	    		<select size="1" id="tipoDestino" name="tipoDestino">
	    		<?	foreach($tipos_material as $codigo_material => $texto_tipo_material){?>
            		<option value="<?=$codigo_material?>"><?= $texto_tipo_material ?></option>
            	<?}?>
	    		</select>
	    	</td>
	   	</tr>
	   	<tr>
	   		<th>&nbsp;</th>
	   		<td align="center" colspan="2">
		   		<input type="submit" value="<?=$Mensajes["boton.cambiar"];?>" name="cambiar">
	     		<input type="button" value="<?=$Mensajes["boton.cancelar"];?>" name="B2" OnClick="javascript:self.close()">
	     	</td>
		</tr>
	</table>
	
	</form>

	<?
}
require "../layouts/base_layout_popup.php";?>