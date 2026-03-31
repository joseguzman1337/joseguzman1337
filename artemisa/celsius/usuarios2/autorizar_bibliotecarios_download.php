<?
$pageName = "bibliotecarios.autarizacion_download"; 

require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (!empty($accion)){
	$usuario=array();
	$usuario["Id"]=$id_usuario;
	
	if ($accion == 'autorizar'){
	    $usuario['bibliotecario_permite_download']=1;	  
    }elseif ($accion == 'desautorizar'){
        $usuario['bibliotecario_permite_download']=0;
    }
	
	$servicesFacade->modificarUsuario($usuario); 
}

$bibliotecarios=$servicesFacade->getUsuariosBibliotecarios();
?>

<table class="table-list" width="90%" border="0" cellpadding="3" cellspacing="1" align="center">
	<tr>
    	<td class="table-list-top" colspan="4">
    		<img src="../images/square-w.gif" width="8" height="8"/>
    		<? echo $Mensajes['tt-02']; ?>
    	</td>
    </tr>
	<tr>
    	<th><?=$Mensajes['tt-10']?>:</th>
    	<th><?=$Mensajes['tt-03']?> / <?=$Mensajes['tt-04']?></th>
    	<th>&nbsp;</th>
    	<th>&nbsp;</th>
    </tr>
    
    <? foreach ($bibliotecarios as $bibliotecario){?>
    	<? if ($bibliotecario['bibliotecario_permite_download']){
             $estado_aut = $Mensajes['tt-05'];
             $accion_msg = ucfirst($Mensajes['tt-09']);
             $accion_value = "desautorizar";
		}else{
           	$estado_aut = $Mensajes['tt-06'];
           	$accion_msg = ucfirst($Mensajes['tt-08']);
           	$accion_value = "autorizar";
        } ?> 
			
        <tr>
           	<td><b><?=$bibliotecario['Apellido'].", ".$bibliotecario['Nombres']?></b></td>
		   	<td><?=$bibliotecario['Nombre_Pais']?> / <?=$bibliotecario['Nombre_Institucion']?></td>
		   	<td style="padding:4px;">
		   		<span style="background:<?=($bibliotecario['bibliotecario_permite_download'])?"green":"red";?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
		   	</td>
		   	<td>
			   	<form>
					<input type='hidden' name='id_usuario' value="<?=$bibliotecario['Id']?>">
		        	<input type='submit' value='<?= $accion_msg ?>'  style="width:90px">
		            <input type='hidden' name='accion' value='<?=$accion_value ?>'>
	            </form>
			</td>
		</tr>
	<?}?>

</table>
 <? require "../layouts/base_layout_admin.php";?> 