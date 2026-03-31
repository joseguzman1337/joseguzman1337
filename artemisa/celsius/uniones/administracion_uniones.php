<?php
$pageName = "uniones1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  
?>
<table class="table-form" width="100%">
	<tr>
		<td class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["tit-1"]?>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>
						<img src="../images/square-lb.gif" width="8" height="8"> <a href="../colecciones/union_titulosColecciones.php"><? echo $Mensajes["h-1"]; ?></a>
                    </td>
                </tr>    
                <tr>
					<td>
					    <img src="../images/square-lb.gif" width="8" height="8"> <a href="../paises/union_paises.php"><? echo $Mensajes["h-2"]; ?></a>
                    </td>
                </tr>
                <tr>
					<td>
					    <img src="../images/square-lb.gif" width="8" height="8"> <a href="../instituciones/union_instituciones.php"><? echo $Mensajes["h-3"]; ?></a>
                    </td>
                </tr>
                <tr>
					<td>
					    <img src="../images/square-lb.gif" width="8" height="8"> <a href="../dependencias/union_dependencias.php"><? echo $Mensajes["h-4"]; ?></a>
                    </td>
                </tr>
                <tr>
					<td>
					     <img src="../images/square-lb.gif" width="8" height="8"> <a href="../unidades/union_unidades.php"><? echo $Mensajes["h-5"]; ?></a>
                    </td>
                </tr>
                <tr>
					<td>
					     <img src="../images/square-lb.gif" width="8" height="8"> <a href="../usuarios2/union_usuarios.php"><? echo $Mensajes["h-6"]; ?></a>
                    </td>
                </tr>
                <tr>
					<td>
					     <img src="../images/square-lb.gif" width="8" height="8"> <a href="../categorias/union_categorias.php"><? echo $Mensajes["h-8"]; ?></a>
                    </td>
                </tr>    
  			</table>
		</td>
	</tr>	
</table>
<? require "../layouts/base_layout_admin.php";?> 
