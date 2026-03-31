<?php
session_start();
//la siguiente validacion se realiza para el cambio de rol a docentes
if($_POST['segClave'] =='segClave')
{
    $_SESSION['2clavereq']='SEGCLAVE';      
    $_SESSION['auth']=false;
}

//validacion de acceso de seccion
if($_SESSION['auth']==false){
	if($_SESSION['2clavereq'] <> 'SEGCLAVE')
	foreach ($_SESSION as $llave => $valor){
		if ($_SESSION[$llave]<>'idusuario') {
			unset($_SESSION[$llave]);
		}
	} 
}
require_once("../../Connections/sala2.php");
include './Tree.php';
$rutaado='../../funciones/adodb/';
require_once('../../Connections/salaado-pear.php');

//la siguiente condicion consulta el rol del usuario y la validacion del ingreso.
if($_POST['cambiorol'])
{
    $idrol=$_POST['rol'];
    $rol = $_POST['cambiorol'];
    
    //si el usuario actual es estudiante se valida su idgeneral para identifcar el usuario
    if($_SESSION['MM_Username'] === 'estudiante')
    {
        //consulta el usuario que tiene asignado el idgeneral
        $sqlusuario = "SELECT u.usuario FROM usuario u inner join estudiantegeneral eg on u.numerodocumento = eg.numerodocumento where eg.idestudiantegeneral = '".$_SESSION['sesion_idestudiantegeneral']."' and u.codigorol = '1'";        
        $sql_buscarusuario = $sala->query($sqlusuario);    
        $sql_buscarusuario = $sql_buscarusuario->fetchRow();
        //asigna el usuario consultado al username
        $_SESSION['MM_Username'] = $sql_buscarusuario['usuario'];
    }
    //consulta de l usuario por su tipo de rol y diferente al usuario actual.
    $nombre_usuario = "select distinct u.usuario from usuario u inner join UsuarioTipo t on t.UsuarioId = u.idusuario where u.numerodocumento = (select numerodocumento from usuario where usuario ='".$_SESSION['MM_Username']."') and  u.usuario <> '".$_SESSION['MM_Username']."' and t.codigoestado ='100' and t.CodigoTipoUsuario ='".$rol."'";         
    $sqlusuario = $sala->query($nombre_usuario);    
    $row_usuario = $sqlusuario->fetchRow();
    
    //is el rol es 2 "Docente" ingresa la validacion para segunda contraseña
    if($idrol=='2')
    {
        $_SESSION['2clavereq']='SEGCLAVE';
        $_SESSION['MM_Username'] = $row_usuario['usuario'];
    }else
    {
        //si el rol es 1 "Estudiante" 
        if($idrol=='1' || $idrol=='4')
        {
            //ingresa para la validacion de datos que tiene el estudiante.
            $sqlidgeneral ="SELECT eg.idestudiantegeneral, eg.numerodocumento FROM estudiantegeneral eg inner join usuario u on u.numerodocumento = eg.numerodocumento where u.usuario ='".$_SESSION['MM_Username']."'";
            $sqlid = $sala->query($sqlidgeneral);    
            $row_idgeneral = $sqlid->fetchRow();
            //se crean las variables para usuario
            $_SESSION['sesion_idestudiantegeneral'] = $row_idgeneral['idestudiantegeneral'];            
            $_SESSION['codigo'] = $row_idgeneral['numerodocumento'];
            if($idrol == '4')
            {
                $_SESSION['MM_Username'] = 'padre';
            }else
            {
                $_SESSION['MM_Username'] = 'estudiante';
            }
            
            $usuario = $_SESSION['MM_Username'];
        }else
        {
            $usuario = $row_usuario['usuario']; 
            $_SESSION['MM_Username'] = $usuario;
            $_SESSION['usuario'] = $usuario; 
        }//else 1
        //se asigna el rol
        $_SESSION['rol']=$idrol; 
    }//else 2
}else
{    
    $usuario=$_SESSION['MM_Username'];
    if($usuario)
    {
        //Codigo para saber el nombre del periodo
        $query_selperiodo = "select p.codigoperiodo, e.nombreestadoperiodo, e.codigoestadoperiodo, p.nombreperiodo
        from periodo p, estadoperiodo e
        where p.codigoestadoperiodo = e.codigoestadoperiodo
        and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
        order by 1 desc";

        $selperiodo = $sala->query($query_selperiodo);
        $totalRows_selperiodo = $selperiodo->numRows();
        $row_selperiodo = $selperiodo->fetchRow();    
        //$query_usuariorol = "SELECT idrol FROM usuariorol u WHERE u.usuario='".$usuario."'";
        $query_usuariorol = "SELECT rol.idrol FROM usuariorol rol INNER JOIN UsuarioTipo ut on ut.UsuarioTipoId = rol.idusuariotipo INNER JOIN usuario u on u.idusuario = ut.UsuarioId WHERE u.usuario = '".$usuario."'";
        $operacion=$sala->query($query_usuariorol);
        $row_operacion=$operacion->fetchRow();    
        $idrol=$row_operacion['idrol'];
    }
}
?>
<html>
<head>
<style type="text/css"> 

BODY{ 
	background-color: #edf0d5;
}

.cajaTexto {
	border: 0px none;
}

A:link {text-decoration:none;color:#f38a01;}
A:visited {text-decoration:none;color:#464c19; }
A:active {text-decoration:none;color:#464c19;}
A:hover {text-decoration:underline;color:#464c19 ;} 
	
.textoSubrayado {
	color: #f38a01;
	text-decoration: underline;
}

</style>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<link rel="stylesheet" type="text/css" href="css/listadinamica.css">
<link rel="stylesheet" type="text/css" href="css/ajax-tooltip.css">
<script type="text/javascript" src="../../funciones/clases/autenticacion/inc.js"></script>
<script type="text/javascript" src="../js/md5.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-content.js"></script>
<script type="text/javascript" src="js/ajax-tooltip.js"></script>
<script src="TreeMenu.js" language="JavaScript" type="text/javascript"></script>
<script type='text/javascript' language="javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="js/perfiles.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) 
{  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<?php         

    
if(!empty($usuario)){
    //consulta de opciones para armar el arbol de opciones del usuario//si el usuario es tipo estudiante la consulta tendra la palabra estudiante como usuario.
	$query_arbol="select
	mu.idmenuopcion as id, mu.idpadremenuopcion as parent_id, concat(mu.transaccionmenuopcion,'-',mu.nombremenuopcion) as text, mu.linkmenuopcion as link, mu.framedestinomenuopcion as linkTarget
	from 
	usuario u
	inner join permisousuariomenuopcion pumu on u.idusuario=pumu.idusuario
	inner join permisomenuopcion pmu on pumu.idpermisomenuopcion=pmu.idpermisomenuopcion
	inner join detallepermisomenuopcion dpmu on pmu.idpermisomenuopcion=dpmu.idpermisomenuopcion
	inner join tipousuario tu on u.codigotipousuario=tu.codigotipousuario
	inner join menuopcion mu on dpmu.idmenuopcion=mu.idmenuopcion
	and now() between u.fechainiciousuario and u.fechavencimientousuario
	and pmu.codigoestado=100 and pumu.codigoestado=100 
	and dpmu.codigoestado=100
	and mu.codigoestadomenuopcion='01'
	and u.usuario='$usuario'
	ORDER BY mu.codigotipomenuopcion,mu.idpadremenuopcion,mu.posicionmenuopcion,mu.nombremenuopcion";
}

if(!empty($_SESSION['codigofacultad']))
{
	$query_carrera="SELECT c.codigocarrera,c.nombrecarrera FROM carrera c WHERE c.codigocarrera = '".$_SESSION['codigofacultad']."'";
	$opCarrera=$sala->execute($query_carrera);
	$nombrecarrera=$opCarrera->fields['nombrecarrera'];
}
?>
<?php
    
$tree = &Tree::createFromMySQL(array('host'=>$hostname_sala,'user'=> $username_sala,'pass'=> $password_sala,'database' => $database_sala,'query'=>$query_arbol));
include './TreeMenu.php';
$nodeOptions = array('icon'=> 'folder.gif','expandedIcon'=>'openfoldericon.png','class'=>'','expanded'=>false,'linkTarget'=> '_self','isDynamic'=>'true');
$options = array('structure' => $tree,'type' => 'heyes','nodeOptions' => $nodeOptions);
$menu = &HTML_TreeMenu::createFromStructure($options);
$treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => 'imagesAlt2', 'defaultClass' => 'treeMenuDefault'));

mysql_close($sala);
?>

<body leftmargin="0" oncontextmenu="return false">
<div align="center" id="cargando" style="position:absolute;z-index:6; left: 100px; top: 180px;"></div>
<div align="center" id="cargandoTexto" style="position:absolute;z-index:6; left: 28px; top: 210px;"></div>
<!--<div id="flechasuperior" style="visibility:hidden;position:absolute; width:24px; height:21px; z-index:8; left: 204px; top: 8px;">
  <input type="image" src="imagesAlt2/flechacierra.gif" onclick="cambiar(this)" value="Q">
</div>-->
<br>
<div align="center"></div>

  <div id="arbol" style="visibility:hidden;position:absolute; width:21px; height:22px; z-index:5; left: 4px; top: 229px;">
<?php $treeMenu->printMenu(); ?>
<br>
<br>
<input type="image" src="imagesAlt2/cerrar.gif" onClick="cerrar()">
<br>
<br>
<!--<div id="flechainferior" style="visibility:hidden"><input type="image" src="imagesAlt2/flechaabre.gif" onClick="cambiar(this)" value="Q"></div> -->
</div>

<div id="trans" style="visibility:hidden;position:absolute; width:46px; height:35px; z-index:4; left: 70px; top: 185px;">
<table  align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td colspan="2" align="center"><img src="imagesAlt2/transaccion.gif"></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="transaccion"  id="transaccion" type="text" size="10" class="cajaTexto">
    </div></td>
    <td><input type="image" src="imagesAlt2/ir.gif" value="Ir" onClick="cargaPrograma(transaccion)"></td>
  </tr>
</table>
</div>
<br> 
<br>
<br>
<div id="infoSala" style="position:absolute; width:139px; height:318px; z-index:11; left: 21px; top: 250px;">
<input type="image" src="imagesAlt2/preguntas_botpreguntas.jpg" width="189" height="47" value="Pregunta" onClick="cargaPreguntas()">
  <p><img src="imagesAlt2/preguntas_texto.gif" width="189" height="231"></p>
</div>
<div id="usuario" style="visibility:hidden;position:absolute; width:90px; height:23px; z-index:1; left: 50px; top: 33px;">
<table  align="center" border="0" cellpadding="0" cellspacing="0" width="150%">
<tr>
    <td height="20" align="center" valign="middle"><img src="imagesAlt2/usuario.gif" width="83" height="18"></td>
</tr>
<tr>
   	<td align="center" nowrap><?php echo "<strong>".$_SESSION['MM_Username']."</strong>";?> 
    </td>
</tr>
<tr>
<td style="text-align:center"><strong>Perfil</strong>
    <select id="PerfilRol" name="PerfilRol" onchange="CambioRolPerfil(this.value)">        
        <?PHP 
        /*
         * If para cuando ingrese un usuario padre este le muestre solo rol padre
         * de lo contrario muestre los demas roles
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Agregado 13 de junio de 2017.
         */
        if($_SESSION['MM_Username'] == 'padre'){
                ?>
                <option value="4"><?php echo 'Padre';?></option>
                <?PHP    
    }else{
        $num_r = count($_SESSION['rolesmuliple']);
        
        for($i=0;$i<$num_r;$i++){
            switch($_SESSION['rolesmuliple'][$i]){
                case '3':{$nameRolPerfil = 'Administrativo';}break;
                case '2':{$nameRolPerfil = 'Docente';}break;
                case '1':{$nameRolPerfil = 'Estudiante';}break;
                case '4':{$nameRolPerfil = 'Padre';}break;    
            }//switch
            if($_SESSION['rol'] != $_SESSION['rolesmuliple'][$i])
            {
                ?>
                <option value="<?PHP echo $_SESSION['rolesmuliple'][$i]?>"><?PHP echo $nameRolPerfil;?></option>
                <?PHP    
            }else
            {
                ?>
                <option selected value="<?PHP echo $_SESSION['rolesmuliple'][$i]?>"><?PHP echo $nameRolPerfil;?></option>
                <?PHP    
            }
        }//for
    }
    //end
        ?>
    </select>
</td>
</tr>
<tr>
    <td wrap align="center" ><?php echo $row_selperiodo['nombreperiodo'];?></td>
</tr>
</table>
</div>
  	<div id="divlogin" style="visibility:hidden;position:absolute; width:26px; height:22px; z-index:1; left: 59px; top: 86px;">
	<table  align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td height="20" align="center" valign="middle"><div align="center"><img src="imagesAlt2/usuario.gif" width="83" height="18"></div></td>
	    <td height="20" align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr>
    	<td><div align="center"><input name="login" type="text" id="login" size="15" class="cajaTexto" <?php if($_SESSION['2clavereq']=='SEGCLAVE'){ echo "disabled";}?> value="<?php echo $_SESSION['MM_Username']?>"></div></td>
    	<td>&nbsp;</td>
	</tr>
	<tr>
	  <td height="20" align="center" valign="middle"><div align="center"><img src="<?php if($_SESSION['2clavereq'] <> 'SEGCLAVE'){echo "imagesAlt2/clave.gif";}else{echo "imagesAlt2/segundaclave.gif";}?>"></div></td>
	  <td>&nbsp;</td>
  </tr>
	<tr>
	  <td><input name="clave" type="password" id="clave" size="15" class="cajaTexto"></td>
	  <td><input type="image" id="irClave" src="imagesAlt2/ir.gif" value="Ir" onClick="login();"></td>
	</tr>
	<tr>
	<td colspan="2">
	<?php if(!($_SESSION['2clavereq'] =='SEGCLAVE')){ ?>
	<br>	    
	<a href="http://openldap.unbosque.edu.co/gapps/google/gaas/recuperacion.php" class="textoSubrayado" target="new">
       <!-- <a href="http://correo.unbosque.edu.co:8080/cloudkey/a/unbosque.edu.co/user/password/recovery/email" class="textoSubrayado" target="new">-->He olvidado mi contraseña</a><br>
        <br><a href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php" class="textoSubrayado" target="new">PADRES-Modificar contraseña</a><br>
	<?php }?>
</td></tr>
	<?php if($_SESSION['2clavereq'] =='SEGCLAVE'){ ?>
	<tr><td align="center" style=""><br><div class="textoSubrayado" onClick="recuerdaPasswd();">Si ha olvidado, o quiere cambiar su <br>SEGUNDA CLAVE<br>haga clic AQUÍ.</div></td></tr><?php } ?>
</table>
</div>
    <div id="busqueda" style="visibility:hidden;position:absolute; width:165px; height:64px; z-index:9; left: 34px; top: 118px;">
      <table width="163" height="61" border="0">
        <tr>
          <td width="157" height="20"><div align="center"><img src="imagesAlt2/txtbusqueda.gif" width="83" height="18"></div></td>
        </tr>
        <tr>
          <td height="35" background="imagesAlt2/busqueda.gif">
              <div align="center">
                  <input size="15" type="text" id="menu" name="menu"  value="" required onKeyUp="listaAutoCompletadoMenu(this)" class="cajaTexto">
            </div></td></tr>
      </table>
</div>
    <div id="carrera" align="center" style="position:absolute; width:234px; height:22px; z-index:10; left: 3px; top: 8px; visibility: hidden;">
<?php echo $nombrecarrera; ?>
    </div>
</body>
</html>
<?php
/*
 * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
 * Se agrega la variable codigotipousuario
 * @since Febrero 10, 2017
*/
if(!empty($_SESSION['MM_Username']) and !empty($_SESSION['rol']) and $_SESSION['auth']==true and !empty($_SESSION['codigotipousuario'])){
/*
* END
*/
	echo '
	<script language="javascript">
	/*if (document.location.protocol == "https:"){
		var direccion=document.location.href;
		var direccioncentral=parent.contenidocentral.location.href;

		var ssl=(direccion.replace(/https/, "http"));
		var ssll=(direccioncentral.replace(/https/, "http"));
		parent.contenidocentral.location.href=ssll;
		document.location.href=ssl;
	}*/
	Visible();
	</script>';
}
else {
	?>
	<script language="javascript">
	/*if (document.location.protocol == "http:"){
		var direccion=document.location.href;
		var direccioncentral=parent.contenidocentral.location.href;
		var ssl=(direccion.replace(/http/, "https"));
		var ssll=(direccioncentral.replace(/http/, "https"));
		parent.contenidocentral.location.href=ssll;
		document.location.href=ssl;
	
	}*/ 	
	noVisible();
	document.getElementById('divlogin').style.visibility='visible';
	</script>
<?php  
foreach ($_SESSION as $llave => $valor){
	if($llave <> '2clavereq' and $llave <> 'MM_Username' and $llave <> 'idusuario'){
		unset($_SESSION[$llave]);
	}

}
}

function validaciondocente()
{
    
}

?>