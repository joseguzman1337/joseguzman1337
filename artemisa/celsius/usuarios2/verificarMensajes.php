<?
/* Verificacion de mensajes de los usuarios.
 * Se visualizan los mensajes de los usuarios (max 3 en forma simultanea)
 * 
 * */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
 
?>
<script type="text/javascript" src="../js/dragdrop.js"></script>
<?
/* Primero veo si tengo que actualizar algun mensaje */
if (isset ($idMensaje) && ($idMensaje > 0)) {
	$res = $servicesFacade->setMensajeLeido($idMensaje);
	if (is_a($res,"Celsius_Exception"))
        	return $res;
}
$mensajes = $servicesFacade->getMensajes_Usuarios(array (
	"idUsuario" => $id_usuario,
	"leido" => 0
));

$cant = 0;
?>
<script language="JavaScript" type="text/javascript">
	var cant =<?=count($mensajes);?>;
	<?for ($i = 1; $i <= count($mensajes); $i++) {?>
	var moviendo<?=$i?>;
	<?}?>
</script>

<?
foreach($mensajes as $mensaje){
	//se muestra un solo cuadro de texto
	$cant++;
	$pos = $cant * 100;
	?>
	<style>
		#mensaje<? echo $cant ?> {
			position:absolute;
		    width:100px;
		    background-color:yellow;
			left:10px;
		    top:<? echo $pos ?>;
		    visibility:visible;
		}
	    #texto<? echo $cant ?> {
			visibility:visible;
		}
	</style>
	<script language="JavaScript" type="text/javascript">
		existe<? echo $cant ?> = 1;
		var elem1=0;
		var elem2=0;
		var elem3=0;
	  	var existe1=0;
	  	var existe2=0;
	  	var existe3=0;
		//el vector frames guarda la visibilidad de las tablas
	 
		var valor = 0;
			  	
		function cerrar(superelem,elem){
			document.getElementById(superelem).style.visibility='hidden';
	   		document.getElementById(elem).style.visibility='hidden';
		}
	
		function minimizar(elem,superelem){
			document.getElementById(superelem).style.height = 5;
			document.getElementById(elem).style.height = 0;
	   		document.getElementById(elem).style.position = 'absolute';
	   		document.getElementById(elem).style.visibility='hidden';
	  	}
	
	  	function maximizar(elem,superelem){
	   		document.getElementById(elem).style.visibility='visible';
	   		//document.getElementById(superelem).style.height='*'
	   		document.getElementById(elem).style.position = 'relative';
	  	}
	   
	   	function marcarLeido(idMensaje,formName){
	    	var formulario = document.getElementById(formName);
			formulario.submit();
	   	}
	   	   		  
		function cambiarValor(elem){
	   		var e = window.event;
	    	if (elem==1)
	      		if (elem1==0)
		    		elem1 = 1;
				else
					elem1 = 0;
	    	else
	    		if (elem==2)
	         		if (elem2==0)
		        		elem2 = 1;
			  		else
						elem2 = 0;
	        	else
					if (elem==3)
	             		if (elem3==0)
		           			elem3 = 1;
	      				else
		    				elem3 = 0;
		}
			
	</script>
	<div id='mensaje<? echo $cant ?>' style='position:absolute;width:150px;left:10px;top:<? echo $pos ?>px;visibility:visible;color:1380C3;background:#1380C3'>
		<table >
	    	<tr>
				<td width='250' bgcolor='#1380C3'>
					<table width='100%'>
						<tr>
							<td align='right' width='*' bgcolor='#1380C3'>
								<input type='button' style='color:1380C3;background:#FFFFBF;width:18px;height:18px' value='-' onclick="minimizar('texto<? echo $cant ?>','mensaje<? echo $cant ?>');">
								<input type='button' style='color:1380C3;background:#FFFFBF;width:18px;height:18px' value='+' onclick="maximizar('texto<? echo $cant ?>','mensaje<? echo $cant ?>');">
								<input type='button' style='color:1380C3;background:#FFFFBF;width:18px;height:18px' value='x' onclick="cerrar('mensaje<? echo $cant ?>','texto<? echo $cant ?>');">
							</td>
						</tr>
						<tr>
							<td align='center' width='*'  bgcolor='#1380C3' onclick='cambiarValor(<? echo $cant ?>)'>
								<font size="1" color='#E6CF73'>Creado <b><? echo $mensaje["fecha_creado"] ?></b></font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr id='texto<? echo $cant ?>' style='visibility:visible'>
				<td width='250' align='center' bgcolor='#1380C3'>
					<span onclick='cambiarValor(<? echo $cant ?>)'>
						<font size=2 color='#FFFFFF'><? echo $mensaje["texto"]; ?></font>
					</span>
				</td>
			</tr>
			<tr onclick='cambiarValor(<? echo $cant ?>)'>
				<td align='right' bgcolor='#1380C3' width='*'>
					<form id='form<? echo $cant; ?>' name='form<? echo $cant; ?>'>
						<input type='hidden' name='idMensaje' value='<? echo $mensaje["id"] ?>'>
						<input type='submit' style='width:140px;color:#1380C3;font-size:8pt;background:#FFFFBF' value='Marcar como leido' onclick="marcarLeido(<? echo $mensaje["id"] ?>,'form<? echo $cant ?>')">
					</form>
				</td>
			</tr>
		</table>
	</div>
	<? 
	if ($cant >= 3)
		//muestro como mucho 3 mensajes, para que no quede toda la pantalla llena de mensajes
		break;
 } ?>

<script language="JavaScript" type="text/javascript">
<!--
SET_DHTML("mensaje1", "mensaje2", "mensaje3", "mensaje4");
//-->
</script>