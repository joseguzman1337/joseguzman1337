<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//print_r($_SESSION);

?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
function enviarmodalidad(){
var codigocarrera=document.getElementById("codigocarrera");
//document.getElementById("tr0")
if(codigocarrera!=null)
codigocarrera.value="";
form1.submit();
}

</script>

<script language="javascript">
function cambia_tipo()
{ 
//alert("Entra Cambio tipo")
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.form1.tipo[document.form1.tipo.selectedIndex].value 
    //miro a ver si el tipo est? definido 
    if (tipo == 1){
		window.location.href="menuparametrizacionadmisiones.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	} 
	if (tipo == 2)
	{
		window.location.href="AsignacionAutomaticaSalones.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	} 
	if (tipo == 3)
	{
		window.location.href="listado_general.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 4)
	{
		window.location.href="menuasignacionsalones.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 5)
	{
		window.location.href="menu_subirexamen.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 6)
	{
		window.location.href="calcula_listado_resultados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 7)
	{
		window.location.href="menuadministracionresultados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 8)
	{
		window.location.href="calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 9)
	{
		window.location.href="calcula_listado_resultados.php?asignaestado&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 10)
	{
		window.location.href="listado_general_interesados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}
	if (tipo == 11)
	{
		window.location.href="menu_subirarchivosegundaopcion.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"; 
	}


}
</script>

<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
unset($_SESSION['admisioncodigocarrera']);
unset($_SESSION['admisioncodigoperiodo']);
unset($_SESSION['admisioncodigomodalidadacademica']);

if(!isset($_SESSION['admisiones_codigomodalidadacademica'])||trim($_SESSION['admisiones_codigomodalidadacademica'])=='')
$_SESSION['admisiones_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];
else
	if(isset($_POST['codigomodalidadacademica'])&&$_SESSION['admisiones_codigomodalidadacademica']!=$_POST['codigomodalidadacademica'])
		$_SESSION['admisiones_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];

if(!isset($_SESSION['admisiones_codigocarrera'])||trim($_SESSION['admisiones_codigocarrera'])=='')
$_SESSION['admisiones_codigocarrera']=$_POST['codigocarrera'];
else	
  if(isset($_POST['codigocarrera'])&&$_SESSION['admisiones_codigocarrera']!=$_POST['codigocarrera'])
	$_SESSION['admisiones_codigocarrera']=$_POST['codigocarrera'];

	
if(!isset($_SESSION['admisiones_codigoperiodo'])||trim($_SESSION['admisiones_codigoperiodo'])=='')
$_SESSION['admisiones_codigoperiodo']=$_POST['codigoperiodo'];
else
  if(isset($_POST['codigoperiodo'])&&$_SESSION['admisiones_codigoperiodo']!=$_POST['codigoperiodo'])
	$_SESSION['admisiones_codigoperiodo']=$_POST['codigoperiodo'];

if(!isset($_SESSION['admisiones_tipo'])||trim($_SESSION['admisiones_tipo'])=='')
$_SESSION['admisiones_tipo']=$_POST['tipo'];
else
  if(isset($_POST['tipo'])&&$_SESSION['admisiones_tipo']!=$_POST['tipo'])
	$_SESSION['admisiones_tipo']=$_POST['tipo'];



$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once('../../../../funciones/clases/autenticacion/redirect.php');

$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
class carrera extends ADODB_Active_Record {}
class periodo extends ADODB_Active_Record {}
class modalidadacademica extends ADODB_Active_Record {}
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
//$idmenuopcion=116;
$usuario=$formulario->datos_usuario();

$idmenuopcion=116;
$estadomenuopcion=validaUsuarioMenuOpcion($idmenuopcion,$formulario,$objetobase);
//echo "<h1>valida:".$estadomenuopcion."</h1>";
if($estadomenuopcion)
{
	/* echo "<script language='javascript'>
		 	alert('Usted no tiene permiso para entrar a esta opcion 2');
	   		//parent.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
	 	  </script>";*/

/*$condicion=" and u.usuario=ur.usuario 
			and ur.idrol=p.idrol".
		   " and p.idmenuopcion=".$idmenuopcion;
if($datosrolusuario=$objetobase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorol p","u.idusuario",$usuario['idusuario'],$condicion,'',1)){*/


$modalidadacademica=new modalidadacademica('modalidadacademica');
$row_modalidadacademica=$modalidadacademica->Find('codigoestado=100 order by nombremodalidadacademica asc');
$carrera=new carrera('carrera');
if($_SESSION['admisiones_codigomodalidadacademica']!="todos")
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
else
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
$periodo=new periodo('periodo');
//$periodo=$sala->GetActiveRecords('periodo');
$row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');


echo "<form name='form1' action='menu.php' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>
	"; 
				
		$postcodigocarrera=$_POST["codigocarrera"];
		//$condicion=" codigomodalidadacademica=".$_GET['codigomodalidadacademica']."";
		$formulario->dibujar_fila_titulo('MENU PROCESO ADMISIONES','labelresaltado');
		$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_SESSION['admisiones_codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		
		//if(!empty($_POST['codigomodalidadacademica'])){
			if($usuario["idusuario"]==4186){
				$condicion=" codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			$campo='menu_fila'; $parametros="'codigocarrera','".$_SESSION['admisiones_codigocarrera']."','onchange=enviar();'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		
		//}
?>
<!--<form name="form1" method="get" action="">
  <p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
          <tr>
          <td width="14%" nowrap id="tdtitulogris">Modalidad acad&eacute;mica </td>
          <td width="86%"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_SESSION['admisiones_codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_modalidadacademica as $llave => $valor){?>
              <option value="<?php echo $valor->codigomodalidadacademica;?>"<?php if($valor->codigomodalidadacademica==$_SESSION['admisiones_codigomodalidadacademica']){echo "Selected";}?>><?php echo $valor->nombremodalidadacademica?></option>
              <?php }?>
            </select>
              <?php $validacion['codigomodalidadacademica']=validaciongenerica($_SESSION['admisiones_codigomodalidadacademica'], "requerido", "Modalidad académica");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Programa</td>
          <td class="amarrillento"><select name="codigocarrera" id="codigocarrera" onchange="enviar()">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_SESSION['admisiones_codigocarrera']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_carrera as $llave => $valor){?>
              <option value="<?php echo $valor->codigocarrera?>"<?php if($valor->codigocarrera==$_SESSION['admisiones_codigocarrera']){echo "Selected";}?>><?php echo $valor->nombrecarrera?></option>
              <?php };?>
            </select>
              <?php $validacion['codigocarrera']=validaciongenerica($_SESSION['admisiones_codigocarrera'],"requerido","Programa");?></td>
        </tr>-->
        <tr>
          <td nowrap id="tdtitulogris">Periodo</td>
          <td class="amarrillento"><select name="codigoperiodo" id="codigoperiodo" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_SESSION['admisiones_codigoperiodo']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
            </select>
              <?php $validacion['codigoperiodo']=validaciongenerica($_SESSION['admisiones_codigoperiodo'],"requerido","Periodo");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Acción</td>
          <td class="amarrillento"><select name="tipo" id="tipo" onchange="enviar()">
            <option value="">Seleccionar</option>
            <option value="1"<?php if($_SESSION['admisiones_tipo']==1){echo "Selected";}?>> 1. Parametrizaci&oacute;n de Admisiones</option>
            <!--<option value="4"<?php if($_SESSION['admisiones_tipo']==4){echo "Selected";}?>>Listado de No asignados</option>-->
	        <option value="4"<?php if($_SESSION['admisiones_tipo']==4){echo "Selected";}?>>2. Asignacion salones</option>
		   <!-- <option value="3"<?php if($_SESSION['admisiones_tipo']==3){echo "Selected";}?>>Listado Asignaci&oacute;n Salones</option>-->
			<!-- <option value="2"<?php if($_SESSION['admisiones_tipo']==2){echo "Selected";}?>>Proceso Autom&aacute;tico Asignaci&oacute;n Salones</option>-->
           <!-- <option value="5"<?php if($_SESSION['admisiones_tipo']==5){echo "Selected";}?>>3. Subir Archivo Plano de Ex&aacute;menes</option>-->
            <!--<option value="6"<?php if($_SESSION['admisiones_tipo']==6){echo "Selected";}?>>Listado Resultados</option>-->
			<!--<option value="8"<?php if($_SESSION['admisiones_tipo']==8){echo "Selected";}?>>Asignacion de nuevo estado</option>-->
			<!--<option value="9"<?php if($_SESSION['admisiones_tipo']==9){echo "Selected";}?>>Asignacion de horario a estado</option>-->
			<option value="7"<?php if($_SESSION['admisiones_tipo']==7){echo "Selected";}?>>3. Administracion resultados</option>
			<!--<option value="10"<?php if($_SESSION['admisiones_tipo']==10){echo "Selected";}?>>Listado general</option>-->
			<!--<option value="11"<?php if($_SESSION['admisiones_tipo']==11){echo "Selected";}?>>Subir Archivo Segunda Opcion</option>-->

          </select>
		  <?php $validacion['accion']=validaciongenerica($_SESSION['admisiones_tipo'],"requerido","Acción");?></td>
		  </td>
        </tr>
        <tr>
          <td colspan="2" nowrap><div align="center" class="verde">
              <input name="Continuar" type="submit" id="Continuar" value="Continuar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
          </div></td>
        </tr>
  </table>
</form>
<?php if(isset($_POST['Restablecer'])){?>
<script language="javascript">window.location.href="menu.php")</script>
<?php } ?>
<?php
if(isset($_POST['Continuar']))
{
	foreach ($validacion as $key => $valor){/*echo $valor['valido'];*/if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		/**
		 * Si existe array de recarga, se podrá recargar de nuevo
		 */
		$array_recarga[]=array('variable'=>'codigoperiodo','valor_variable'=>$_SESSION['admisiones_codigoperiodo']);
		$array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_SESSION['admisiones_codigomodalidadacademica']);
		$array_recarga[]=array('variable'=>'codigocarrera','valor_variable'=>$_SESSION['admisiones_codigocarrera']);
		$_SESSION['archivo_ejecuta_recarga']='tabla_estadisticas_matriculas.php';
		$_SESSION['array_recarga']=$array_recarga;
		$_SESSION['codigoperiodo_seleccionado']=$_POST['codigoperiodo'];
		$_SESSION['codigocarrera']=$_POST['codigocarrera'];
		$_SESSION['codigomodalidadacademica']=$_POST['codigomodalidadacademica'];
		$_SESSION['accion']=$_POST['accion'];
		//echo '<script language="javascript">window.location.href("admision_listado.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php");</script>';
		echo '<script language="javascript">cambia_tipo();</script>';
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}

}
else{
	echo "<script language='javascript'>alert('Ud no tiene permiso para ver esta opcion');</script>";
}

?>
