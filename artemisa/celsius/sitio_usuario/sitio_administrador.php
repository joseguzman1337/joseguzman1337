<?
$pageName ="consola_administracion";

require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
 
if (!isset ($_COOKIE['layout'])) {
	//$layout = 'false-true-false-false-false-false-false-true';
	$layout = 'false-true-false-false-false-false-true-true';
	setcookie('layout', $layout);
} else
	$layout = $_COOKIE['layout'];

require "../layouts/top_layout_admin.php";
$pais = $servicesFacade->getPaisPredeterminado();
$institucion = $servicesFacade->getInstitucionPredeterminada();
$pedidoBase = $pais["Abreviatura"] . "-" . $institucion["Abreviatura"] . "-";
$vec = explode('-', $layout);

?>

<script language="JavaScript" type="text/javascript">
	    		
		function mostrarElemento(mostrar, ocultar , mispan , operacion){
			
					
					document.getElementById(mostrar).style.position = 'relative';
					document.getElementById(mostrar).style.visibility = 'visible';
			
					document.getElementById(ocultar).style.position = 'absolute';
					document.getElementById(ocultar).style.visibility = 'hidden';
					
				if (operacion == 0){	
						document.getElementById(mispan).style.display = 'block';
					}else{
						document.getElementById(mispan).style.display = 'none';
					}
				}
		function mostrar(mostrar, ocultar , mispan , operacion){ 
			
			if(document.getElementById(mostrar)  != null) {
				mostrarElemento(mostrar, ocultar , mispan , operacion);
			}
	        var aux;
		    if (document.getElementById('tabla1').style.display != 'none')
				aux = 'true';
			else 
				aux = 'false';
			if (document.getElementById('tabla2').style.display != 'none')
				aux = aux + '-true';
			else
				aux = aux + '-false';

			if (document.getElementById('tabla4').style.display != 'none')
				aux =aux + '-true';
			else 
				aux = aux +'-false';
			
			if (document.getElementById('tabla5').style.display != 'none')
				aux = aux +'-true';
			else 
				aux = aux +'-false';
			
			if (document.getElementById('tabla6').style.display != 'none')
				aux = aux +'-true';
			else 
				aux = aux +'-false';
		    if (document.getElementById('tabla7').style.display != 'none')
				aux =aux + '-true';
			else 
				aux = aux +'-false';
			if (document.getElementById('tabla8').style.display != 'none')
				aux =aux + '-true';
		    else 
		    	aux = aux +'-false';
		    
	        document.cookie = "layout="+aux;
		}
	   
		function titulosNormalizados(){ 
			var Letra = "A";
			if (document.getElementsByName("expresion").item(0).value != '')
				Letra = document.getElementsByName("expresion").item(0).value;
		 	ventana=window.open("../colecciones/seleccionar_titulo_coleccion.php?input_id_coleccion=idColeccion&input_titulo_coleccion=expresion&titulo_coleccion="+Letra, "Seleccione" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
		 	ventana.focus();
		 	document.getElementById('campo').value=2;
		}
	</script>
	
	<style type="text/css">
		<!--
		
		.img-menu{
				border-width:0px;
				margin:3px;
			}
		
		-->
	</style>
	





        
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top">
    		<!-- INICIO TD 1 TABLA 2-->
    			<table width="570" border="0" cellpadding="0" cellspacing="2" bgcolor="#e4e4e4">
  <tr>
    <td>
    	<h2 class="heading">
    		<span><img class="iconito" src="../images/open.gif" ><?=$Mensajes["nn-5"]; ?></span>
    	</h2>
		<ul class="row">
			<li class="linkboton">
				<a href="../usuarios2/seleccionar_usuario.php?generarPedido=1&popup=false&url_destino=pedidos2/seleccionar_tipo_material.php"><?=$Mensajes["hr-4"]; ?></a>
			</li>   	 
			<li class="linkboton">
				<a href='../pedidos2/buscar_pedidos.php'><?= $Mensajes["campo.busquedaAvanzada"];?></a>
			</li>   	 
			<li class="linkboton">
				<a href='../pedidos2/listar_pedidos_por_usuario.php'><?= $Mensajes["link.pedidosEntregados"];?></a>
			</li>
		</ul>
		<ul class="row">
			<li class="linkboton">
				<a href="../usuarios2/listar_usuarios.php"><?= $Mensajes["link.listadoUsuarios"];?></a>
			</li>   	 
		</ul>
			
		<h4>
			<form name="formBusquedaRapida" action='../pedidos2/listar_pedidos_busqueda_rapida.php' style='margin-top: 0px;margin-bottom:0px'>
			<span class="titulo-chico"><?=$Mensajes["link.busquedaRapida"]; ?></span>
  			</span><br />
  			<span class="style22"><?=$Mensajes["nn-6"]; ?></span>
  				<input type="hidden" name="idColeccion" id="idColeccion" value=""/>
        		<input type="text" name="expresion" id="expresion" value="<? echo $pedidoBase;?>" class="style22" size="30"/>				
				<label>
  					<input class="style22" type="submit" value='<?=$Mensajes["nn-16"]; ?>'/>
  				</label>
  			<br />
  				<SELECT NAME="campo" id="campo" class="style22">
                    <option value ="1"><?=$Mensajes["nn-7"]; ?></option>
                    <option value ="2"><?=$Mensajes["nn-9"]; ?></option>
                    <option value ="3"><?=$Mensajes["nn-8"]; ?></option>
                </SELECT>
  				<span id="labelTitulos" style="position:relative" class="style22">
						<a href="javascript:titulosNormalizados();">
							<span class="style22">
								<?=$Mensajes["nn-10"]; ?>
							</span>
						</a>
				</span>
  		</h4>
  		</form>
		<h2 class="heading">
			<img class="iconito" src="../images/close.gif" id='buttonMas2' onclick="mostrar('buttonMenos2' , 'buttonMas2' , 'tabla2' , 0);">
			<img class="iconito" src="../images/open.gif" id='buttonMenos2' onclick="mostrar('buttonMas2' ,'buttonMenos2', 'tabla2' , 1);">
			<?=$Mensajes["ec-5"]; ?>
		</h2>
		<div id="tabla2">		
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-13"]; ?></li>
				<li class="linkboton">
					<a href="../usuarios2/modificar_usuario.php">
						<?=$Mensajes["hr-1"]; ?></a>
				</li>
				<li class="linkboton">
					<a href="../usuarios2/seleccionar_usuario.php?popup=0&url_destino=usuarios2/mostrar_usuario.php">
						<?=$Mensajes["hr-3"]; ?></a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-25"]; ?></li>  	 
				<li class="linkboton">
					<a href="../usuarios2/seleccionar_usuario.php?popup=0&url_destino=mail/enviar_mail2.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<A href="../usuarios2/seleccionar_usuario.php?popup=0&url_destino=mail/listado_mail_usuarios.php">
						<?=$Mensajes["hco-1"]; ?>
					</A>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["hc-27"]; ?></li>  	 
				<li class="linkboton">
					<A href="../usuarios2/seleccionar_usuario.php?popup=0&url_destino=usuarios2/nuevo_mensaje.php">
						<?=$Mensajes["hc-28"]; ?>
					</A>
				</li>   	 
				<li class="linkboton">
					<A href="../usuarios2/seleccionar_usuario.php?popup=0&url_destino=usuarios2/listado_mensajes_usuarios.php">
						<?=$Mensajes["hc-29"]; ?>
					</A>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["nn-3"]; ?></li>  	 
				<li class="linkboton">
					<A href="../usuarios2/autorizar_bibliotecarios_download.php">
						<?=$Mensajes["nn-4"]; ?>
					</A>
				</li>
			</ul>
		</div>
		<h2 class="heading">
			<span>
				<img class="iconito" src="../images/open.gif" id='buttonMenos1' onclick="mostrar('buttonMas1' ,'buttonMenos1', 'tabla1' , 1);" >
				<img class="iconito" src="../images/close.gif" id='buttonMas1' onclick="mostrar('buttonMenos1' , 'buttonMas1' , 'tabla1' , 0);" >
				<?=$Mensajes["ec-3"]; ?>
			</span>
		</h2>
		<div id="tabla1">
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-1"]; ?></li>  	 
				<li class="linkboton">
					<a href="../noticias/modificarOAgregarNoticia.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
						<a href="../noticias/listadoNoticias.php">
							<?=$Mensajes["hr-2"]; ?>
						</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-2"]; ?></li>  	 
				<li class="linkboton">
					<a href="../sugerencias/agregarOModificarSugerencia.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>
				<li class="linkboton">
					<a href="../sugerencias/listar_sugerencias.php">
						<?=$Mensajes["hr-2"]; ?>
					</a>
				</li>
			</ul>
		</div>
		<h2 class="heading">
			<span>
			    <img class="iconito" src="../images/open.gif" id='buttonMenos4' onclick="mostrar('buttonMas4' ,'buttonMenos4', 'tabla4' , 1);" >
			    <img class="iconito" src="../images/close.gif" id='buttonMas4' onclick="mostrar('buttonMenos4' , 'buttonMas4' , 'tabla4' , 0);" >
				<?=$Mensajes["ec-4"]; ?>
				
			</span>
		</h2>
		<div id="tabla4">
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-4"]; ?></li>  	 
				<li class="linkboton">
					<a href="../paises/modificarOAgregarPais.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../paises/listadoPaises.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-5"]; ?></li>  	 
				<li class="linkboton">
					<a href="../localidades/modificarOAgregarLocalidad.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../localidades/seleccionar_localidad.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-6"]; ?></li>  	 
				<li class="linkboton">
					<a href="../instituciones/modificarOAgregarInstitucion.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../instituciones/listadoInstituciones.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row"><li class="consolacat"><?=$Mensajes["tf-7"]; ?></li>  	 
				<li class="linkboton">
					<a href="../dependencias/modificarOAgregarDependencia.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../dependencias/listadoDependencias.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?= $Mensajes["tf-8"]; ?></li>  	
				<li class="linkboton">
						<a href="../unidades/modificarOAgregarUnidad.php">
							<?=$Mensajes["hr-1"]; ?>
						</a>
				</li>   	 
				<li class="linkboton">
					<a href="../unidades/listadoUnidades.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-9"] ?></li>  	 
				<li class="linkboton">
					<a href="../categorias/modificarOAgregarCategoria.php?operacion=0">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../categorias/seleccionar_categoria.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-10"]; ?></li>  	
				<li class="linkboton">
					<a href="../candidatos/agregar_candidato.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../candidatos/listar_candidatos.php?rechazados=0">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["nn-17"]; ?></li>  	 
				<li class="linkboton">
					<a href="../candidatos/listar_candidatos.php?rechazados=2">
						<?=$Mensajes["nn-18"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-11"]; ?></li>  	
				<li class="linkboton">
					<a href="../colecciones/agregarOModificarCol.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../colecciones/seleccionar_titulo_coleccion.php?popup=0&url_destino=colecciones/agregarOModificarCol.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-32"]; ?></li>  	 
				<li class="linkboton">
					<a href="../catalogos/agregarOModificarCatalogo.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../catalogos/seleccionar_catalogo.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["nn-14"]; ?></li>  	 
				<li class="linkboton">
					<a href="../formaentrega/agregarOModificarForma_Entrega.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../formaentrega/seleccionar_forma_entrega.php">
						<?=$Mensajes["hr-3"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["uniones"]; ?></li>
				<li class="linkboton">	
					<a href="../uniones/administracion_uniones.php">
						<?=$Mensajes["tf-28"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-12"]; ?></li>  	 
				<li class="linkboton">
					<a href="../campos/listado_campos.php">
						<?= $Mensajes["link.listadoCampos"]; ?>
					</a>
				</li>
			</ul>
		</div>
		<h2 class="heading">
			<span>
				<img class="iconito" src="../images/open.gif" id='buttonMenos5' onclick="mostrar('buttonMas5' ,'buttonMenos5', 'tabla5' , 1);" >
				<img class="iconito" src="../images/close.gif" id='buttonMas5' onclick="mostrar('buttonMenos5' , 'buttonMas5' , 'tabla5' , 0);" >
				<?=$Mensajes["ec-6"]; ?>
				
			</span>
		</h2>
		<div id="tabla5">
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-26"]; ?></li>  	 
				<li class="linkboton">
					<a href="../plantillaMail/agregarOModificarPMail.php?operacion=0">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../plantillaMail/seleccionar_pmail.php">
						<?=$Mensajes["hr-2"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-27"]; ?></li>  	 
				<li class="linkboton">
					<a href="../lista_correo/seleccionar_usuarios_lista_correo.php">
						<?=$Mensajes["he-7"]; ?>
					</a>
				</li>
			</ul>
		</div>	
		<h2 class="heading">
			<span>
				<img class="iconito" src="../images/open.gif" id='buttonMenos6' onclick="mostrar('buttonMas6' ,'buttonMenos6', 'tabla6' , 1);" >
				<img class="iconito" src="../images/close.gif" id='buttonMas6' onclick="mostrar('buttonMenos6' , 'buttonMas6' , 'tabla6' , 0);" >
				
				<?=$Mensajes["ec-8"]; ?>
				
			</span>
		</h2>
		<div id="tabla6">
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-16"]; ?></li>  	 
				<li class="linkboton">
					<a href="../idiomas/agregarOModificarIdioma.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../idiomas/seleccionar_idioma.php">
						<?=$Mensajes["hr-2"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-17"]; ?></li>  	 
				<li class="linkboton">
					<a href="../pantallas/agregarOModificarPantalla.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>
				<li class="linkboton">
					<a href="../pantallas/listado_pantallas.php">
						<?=$Mensajes["hr-2"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-18"]; ?></li>  	 
				<li class="linkboton">
					<a href="../elementos/agregarOModificarElemento.php">
						<?=$Mensajes["hr-1"]; ?>
					</a>
				</li>   	 
				<li class="linkboton">
					<a href="../elementos/seleccionar_elemento.php">
						<?=$Mensajes["hr-2"]; ?>
					</a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacat"><?=$Mensajes["tf-19"]; ?></li>  	 
				<li class="linkboton">
					<a href="../traducciones/seleccionar_traduccion.php?traduccion_completa=0">
						<?= $Mensajes["link.elementosSinTraducir"];?>
					</a>
				</li>
				<li class="linkboton">
					<a href="../traducciones/seleccionar_traduccion.php"><?=$Mensajes["hr-2"]; ?></a>
				</li>
			</ul>
			<ul class="row">
				<li class="consolacatoff"><?=$Mensajes["tf-19"]; ?></li>
				<li class="linkboton">
					<a href="../traducciones/descargar_traducciones.php?operacion=0">
						<?=$Mensajes["hr-5"]; ?>
					</a>
				</li>
				<li class="linkboton">
					<a href="../traducciones/subir_traducciones.php"><?=$Mensajes["hr-6"]; ?></a>
				</li>
			</ul>
		</div>	
		<h2 class="heading">
			<span>
			<img class="iconito" src="../images/open.gif" id='buttonMenos7' onclick="mostrar('buttonMas7' ,'buttonMenos7', 'tabla7' , 1);" >
			<img class="iconito" src="../images/close.gif" id='buttonMas7' onclick="mostrar('buttonMenos7' , 'buttonMas7' , 'tabla7' , 0);" >
				<?= $Mensajes["campo.configCelsius"]; ?>
			</span>
		</h2>
		<div id="tabla7">
			<ul class="row">
				<li class="consolacat"><?= $Mensajes["campo.parametros"]; ?></li>  	 
				<li class="linkboton">
					<a href="../parametros/modificarParametros.php">
						<?= $Mensajes["link.modificacion"]; ?>
					</a>
				</li>
			</ul>
		  <?if (Configuracion::isNTHabilitado()){?>
				<ul class="row">
					<li class="consolacat"><?= $Mensajes["campo.operacionesNT"]; ?></li>  	 
					<li class="linkboton">
						<a href="../operacionesNT/sincronizarDirectorio.php">
							<?= $Mensajes["link.sincronizacion"]; ?>
						</a>
					</li>
					<li class="linkboton">
						<a href="../operacionesNT/vaciarColaEnvios.php">
							<?= $Mensajes["link.vaciadoColaEnvios"];?>
						</a>
					</li>
				</ul>	
			<?}?>
			<ul class="row">
				<li class="consolacat"><?= $Mensajes["campo.operacionesSobreBBDD"];?> </li>  	 
				<li class="linkboton">
					<a href="../db/ejecutar_sql.php">
						<?=$Mensajes["he-8"]; ?>
					</a>
				</li>
				<li class="linkboton">
					<a href="../db/backup_base.php">
						<?=$Mensajes["nn-15"]; ?>
					</a>
				</li>
			</ul>
	</div>
 </td>
 </tr>
</table>
    			
    	</td>
		<td width="25%" valign="top" bgcolor="#E4E4E4"  >
        <!-- INICIO TD 2 TABLA 2-->
		<h5 class="img">
			<img src="../images/libros.jpg"/>
		</h5>
   		<h5 class="heading">
   			<img class="iconito" src="../images/open.gif" id='buttonMenos8' onclick="mostrar('buttonMas8' ,'buttonMenos8', 'tabla8' , 1);">
			<img class="iconito" src="../images/close.gif" id='buttonMas8' onclick="mostrar('buttonMenos8' , 'buttonMas8' , 'tabla8' , 0);" >
   			<?=$Mensajes["ec-1"]; ?>
   		</h5>
   		<div id="tabla8">
 			<h5 class="menu">
 					<?
						$pendienteLocal = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__PENDIENTE), array ("origen_remoto" => 0));
						$pendienteRemoto = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__PENDIENTE), array("origen_remoto" => 1));
						$totalPendiente = $pendienteLocal + $pendienteRemoto;
						if ($totalPendiente > 1) {
							echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=1'>" . $totalPendiente . " " . $Mensajes["hc-1"];
							if ($pendienteRemoto != '') {
								echo "(" . $pendienteRemoto . " NT)";
							}
							echo "</a>";
						}elseif ($totalPendiente == 1) {
								echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=1'>" . $totalPendiente . " " . $Mensajes["hc-2"];
								if ($pendienteRemoto != '') {
									echo "(" . $pendienteRemoto . " NT)";
								}
						echo "</a>";
						} else {
							echo $Mensajes["hc-3"];
					}
					?>
 				
 			</h5>
 			<h5 class="menu">
 				<?
				  $busquedaLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__BUSQUEDA), array ("origen_remoto" => 0));
				  $busquedaRemoto = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__BUSQUEDA), array("origen_remoto" => 1));
				  $totalBusqueda = $busquedaLocal + $busquedaRemoto;
				  if ($totalBusqueda > 1) {
					echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=2'>" . $totalBusqueda . " " . $Mensajes['hc-4'];
					if ($busquedaRemoto != '') {
						echo "(" . $busquedaRemoto . " NT)";
					}
					echo "</a>";
				  }elseif ($totalBusqueda == 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=2'>" . $totalBusqueda . " " . $Mensajes["hc-5"];
						if ($busquedaRemoto != '') {
							echo "(" . $busquedaRemoto . " NT)";
						}
						echo "</a>";
				  }else {
	                 echo $Mensajes["hc-6"];
                  }
             ?>
 				
 				
 			</h5>
 			<h5 class="menu">
 				<?
					$solicitadoLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__SOLICITADO), array ("origen_remoto" => 0));
					$solicitadoRemoto = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__SOLICITADO), array("origen_remoto" => 1));
					$totalSolicitado = $solicitadoLocal + $solicitadoRemoto;
					if ($totalSolicitado > 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=3'>" . $totalSolicitado . " " . $Mensajes["hc-7"];
						if ($solicitadoRemoto != '') {
							echo "(" . $solicitadoRemoto . " NT)";
						}
						echo "</a>";
					}elseif ($totalSolicitado == 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=3'>" . $totalSolicitado . " " . $Mensajes["hc-8"];
					if ($solicitadoRemoto != '') {
						echo "(" . $solicitadoRemoto . " NT)";
					}
					echo "</a>";
					} else {
						echo $Mensajes["hc-9"];
					}
				?>
 			</h5>
 			<h5 class="menu">
 				<?
         			$pendienteNTLocal = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__PENDIENTE_LLEGADA_NT), array ("origen_remoto" => 0));
					$pendienteNTRemoto = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__PENDIENTE_LLEGADA_NT), array("origen_remoto" => 1));
					$totalPendienteNT = $pendienteNTLocal + $pendienteNTRemoto;
					if ($totalPendienteNT > 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=13'>" . $totalPendienteNT ." ".$Mensajes["mensaje.pedidosPendientesNT"];
						if ($pendienteNTRemoto != '') {
							echo "(" . $pendienteNTRemoto . " NT)";
						}
						echo "</a>";
					}elseif ($totalPendienteNT == 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=13'>" . $totalPendienteNT . " ".$Mensajes["mensaje.pedidoPendienteNT"];
						if ($pendienteNTRemoto != '') {
							echo "(" . $pendienteNTRemoto . " NT)";
						}
					echo "</a>";
					}else{
						echo $Mensajes["mensaje.sinPendientesNT"];
					}
				?>
 			</h5>
 			<h5 class="menu">
 			<?
			$esperandoConfirmacionLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO), array ("origen_remoto" => 0));
			$esperandoConfirmacionRemoto =$servicesFacade->getCountPedidosEnEstados(array(ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO), array("origen_remoto" =>1));
			$totalEsperandoConfirmacion = $esperandoConfirmacionLocal + $esperandoConfirmacionRemoto;
			if ($totalEsperandoConfirmacion > 1) {
				echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=4'>" . $totalEsperandoConfirmacion . " " . $Mensajes["hc-10"];
				if ($esperandoConfirmacionRemoto != '') {
					echo " (" . $esperandoConfirmacionRemoto . " NT)";
				}
				echo "</a>";
			}elseif ($totalEsperandoConfirmacion == 1) {
					echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=4'>" . $totalEsperandoConfirmacion . " " . $Mensajes["hc-11"];
					if ($esperandoConfirmacionRemoto != '') {
						echo " (" . $esperandoConfirmacionRemoto . " NT)";
					}
					echo "</a>";
			}else{
				echo $Mensajes["hc-12"];
			}
			?>
			</h5>
 			<h5 class="menu">
 				<?
					$confirmadoLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__CONFIRMADO_POR_EL_USUARIO),array("origen_remoto" =>0));
					$confirmadoRemoto = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__CONFIRMADO_POR_EL_USUARIO),array("origen_remoto" => 1));
					$totalCorfimado = $confirmadoLocal + $confirmadoRemoto;
					if ($totalCorfimado > 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=5'>" . $totalCorfimado . " " . $Mensajes["hc-13"];
						if ($confirmadoRemoto != '') {
							echo " (" . $confirmadoRemoto . " NT)";
						}
						echo "</a>";
					}elseif ($totalCorfimado == 1) {
						echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=5'>" . $totalCorfimado . " " . $Mensajes["hc-14"];
						if ($confirmadoRemoto != '') {
							echo " (" . $confirmadoRemoto . " NT)";
						}
						echo "</a>";
					}else {
						echo $Mensajes["hc-15"];
					}
				?>
 			</h5>
 			<h5 class="menu">
 			<?
			$confirmadoLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR),array("origen_remoto" => 0));
			$confirmadoRemoto = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR),array("origen_remoto" => 1));
			$totalCorfimado = $confirmadoLocal + $confirmadoRemoto;
			if ($totalCorfimado < 1) {
				echo $Mensajes["mensaje.sinMsjEsperaConfirmacion"];
			}else {
				echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=14'>" . $totalCorfimado . " ";
				echo ($totalCorfimado > 1) ? $Mensajes["hc-33"] : $Mensajes["hc-34"];
				if ($confirmadoRemoto != '') {
					echo " (" . $confirmadoRemoto . " NT)";
				}
				echo "</a>";
			}
			?>
 			</h5>
 			<h5 class="menu">
 			<?
		  	 $reclamadoLocal = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__RECLAMADO_POR_USUARIO), array("origen_remoto" =>0));
			 $reclamadoRemoto = $servicesFacade->getCountPedidosEnEstados(array(ESTADO__RECLAMADO_POR_USUARIO), array("origen_remoto" => 1));
			 $totalReclamados = $reclamadoLocal + $reclamadoRemoto;
			 if ($totalReclamados < 1) {
	         	echo $Mensajes["mensaje.sinPedidosNTReclamados"];
			}else{
				echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=19'>" . $totalReclamados . " ";
				echo ($totalReclamados > 1) ? $Mensajes["mensaje.PedidosReclamados"]." " : $Mensajes["mensaje.PedidoReclamado"];
				if ($reclamadoRemoto != '') {
					echo " (" . $reclamadoRemoto . " NT)";
				}
				echo "</a>";
			}
			?>
 			</h5>
 			<h5 class="select"><a href="../pedidos2/buscar_pedidos_por_destino.php"><?=$Mensajes["hc-23"]; ?></a></h5>
		</div>
		<h5 align="center" class="heading">
				<? echo $Mensajes["tf-10"]; ?>		
			</h5>
 		<h5 class="menu"><?
			$num_candidatos = $servicesFacade->getCount("candidatos", array("rechazados" => 0));
			if ($num_candidatos > 1) {
			?>
			<a href="../candidatos/listar_candidatos.php"><?= $num_candidatos . " " . $Mensajes["hc-17"] ?></a>
			<? }elseif ($num_candidatos == 1) {?>
				<a href="../candidatos/listar_candidatos.php"><?= $num_candidatos . " " . $Mensajes["hc-18"] ?></a>
			<?
			} else {
			echo $Mensajes["hc-19"];
			}
			?>
</h5>
		<h5 align="center" class="heading"><?=$Mensajes["ec-9"]; ?></h5>
 		<h5 class="menu">
 		<?
		$recibidos = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__RECIBIDO));
		if ($recibidos > 1) {
			echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=6'>" . $recibidos . " " . $Mensajes["hc-20"] . "</a>";
		}elseif ($recibidos == 1) {
			echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=6'>" . $recibidos . " " . $Mensajes["hc-21"] . "</a>";
		} else {
			echo $Mensajes["hc-22"];
		}
		?> 
 		</h5>
 		<h5 class="menu">
 			<?
				$listoParaBajarse = $servicesFacade->getCountPedidosEnEstados(array (ESTADO__LISTO_PARA_BAJARSE));
				if ($listoParaBajarse > 1) {
					echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=11'>" . $listoParaBajarse . " " . $Mensajes["hc-31"] . "</a>";
				}elseif ($listoParaBajarse == 1) {
					echo "<a href='../pedidos2/listar_pedidos_administracion.php?Estado=11'>" . $listoParaBajarse . " " . $Mensajes["hc-30"] . "</a>";
				} else {
					echo $Mensajes["hc-32"];
				}
			?> 
 			
 			</h5>
 		<h5 class="select"><?=$Mensajes["ec-10"]; ?> <?=$usuario["Apellido"].", ".$usuario["Nombres"] ?></h5>
		<h5 align="center" class="heading"><a href="../sitio_usuario/login_usuario_submit.php?logout=true"><? echo $Mensajes["ss-1"]; ?></a></h5>





		</td>
	</tr>
</table>
<!-- FIN TABLA 2-->


<script language="JavaScript" type="text/javascript">
	<?
	for ($i = 1; $i < 3; $i++) {
		$index = $i;
		
		if ($vec[$i-1] == 'true'){
			echo "mostrarElemento('buttonMenos$index' ,'buttonMas$index', 'tabla$index' , 0);";
		    
		}else{
			echo "mostrarElemento('buttonMas$index' ,'buttonMenos$index', 'tabla$index' , 1);";
		}
	}
	for ($i = 4; $i < 9; $i++) {
		$index = $i;
		if ($vec[$i-2] == 'true')
			echo "mostrarElemento('buttonMenos$index' ,'buttonMas$index', 'tabla$index' , 0);";
		else
			echo "mostrarElemento('buttonMas$index' ,'buttonMenos$index', 'tabla$index' , 1);";
	}
	?>
		document.forms.formBusquedaRapida.expresion.focus();
	
	
</script>
<? require "../usuarios2/verificarMensajes.php";?> 
<? require "../layouts/base_layout_admin.php"; ?>