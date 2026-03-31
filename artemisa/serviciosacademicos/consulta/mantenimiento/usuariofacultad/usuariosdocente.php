<?php 
session_start();
$ruta="../../../";

$rutaado=($ruta."funciones/adodb/");
require_once($ruta."consulta/generacionclaves.php");

require_once($ruta."funciones/clases/motorv2/motor.php");
//require_once("file:///C|/Archivos%20de%20programa/xampp/htdocs/Connections/salaado-pear.php");
require_once($ruta."funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once($ruta."funciones/sala_genericas/FuncionesCadena.php");
require_once($ruta."funciones/sala_genericas/FuncionesFecha.php");
require_once($ruta."funciones/clases/formulario/clase_formulario.php");
require_once($ruta."funciones/sala_genericas/formulariobaseestudiante.php");
require_once($ruta.'funciones/sala_genericas/Excel/reader.php');
require_once($ruta."funciones/clases/autenticacion/claseldap.php");
require_once($ruta."Connections/conexionldap.php");
//require_once($ruta.'funciones/clases/autenticacion/redirect.php');

function crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre){

global $arrayusuarioscreados;

				$fila["usuario"]=$usuario;
				$fila["numerodocumento"]=$numerodocumento;
				$fila["tipodocumento"]="01";
				$fila["apellidos"]=quitartilde($nombreusuario);
				$fila["nombres"]=quitartilde($nombreusuario);
				$fila["codigousuario"]=$numerodocumento;
				$fila["semestre"]="";
				$fila["codigorol"]=1;
				$fila["fechainiciousuario"]=date("Y-m-d H:i:s");
				$fila["fechavencimientousuario"]="2099-12-31";
				$fila["fecharegistrousuario"]=date("Y-m-d H:i:s");
				$fila["codigotipousuario"]=500;
				$fila["idusuariopadre"]=0;
				$fila["ipaccesousuario"]="";
				$fila["codigoestadousuario"]=100;

	if(!($usuariodatos = $objetobase->recuperar_datos_tabla("usuario u","u.numerodocumento",$numerodocumento,"","",0))){
		if(!($usuariodatos = $objetobase->recuperar_datos_tabla("usuario u","u.usuario",$usuario,"","",0))){

			$arrayusuarios=$objetoldap->BusquedaUsuarios("uid=".$usuario);
			if($arrayusuarios["count"]==0){
				

				//$objetobase->insertar_fila_bd("usuario",$fila,0);
				$objetobase->insertar_fila_bd("usuario",$fila,0);
				//$password=$numerodocumento;
				$password="temp".agregarceros(rand(0,9999),4);
				$fila["mail"]=$email;
				$objetoldap->EntradaDocente($usuario,$password,$fila,$dnpadre);

				$objetoldap->CreaUsuarioGoogle($fila);
				//echo "<BR>".$usuario." USUARIO CREADO<BR>"; 
				$arrayusuarioscreados["Nombre"][]=$nombreusuario;
				$arrayusuarioscreados["Documento"][]=$numerodocumento;
				$arrayusuarioscreados["Correo"][]=$email;
				$arrayusuarioscreados["Usuario"][]=$usuario;
				$arrayusuarioscreados["Clave"][]=$password;
				
					
				if(!($docentedatos = $objetobase->recuperar_datos_tabla("docente u","u.numerodocumento",$numerodocumento,"","",0))){			
					
					$filadocente["codigodocente"]=$numerodocumento;
					$filadocente["apellidodocente"]=$nombreusuario;
					$filadocente["nombredocente"]=$nombreusuario;
					$filadocente["tipodocumento"]="01";
					$filadocente["numerodocumento"]=$numerodocumento;
					$filadocente["clavedocente"]="";
					$filadocente["emaildocente"]=$fila["mail"];
					$objetobase->insertar_fila_bd("docente",$filadocente,0);
					$arrayusuarioscreados["Mensaje"][]="CREADO TABLA DOCENTE ";
					//echo "<BR>".$usuario."DOCENTE CREADO<BR>";		
					return true;
						
				}
				else{
				$arrayusuarioscreados["Mensaje"][]="ENCONTRADO EN LA TABLA DOCENTE, NO ENCONTRADO EN EL TABLA USUARIO, NO ENCONTRADO EN EL LDAP";
				
//echo "<BR>".$nombreusuario." ENCONTRADO EN LA TABLA DOCENTE, NO ENCONTRADO EN EL TABLA USUARIO, NO ENCONTRADO EN EL LDAP<BR>";		
				return true;
				}

			}
			else{
			//echo "<BR>".$nombreusuario." ENCONTRADO EN EL LDAP, NO ENCONTRADO EN EL TABLA USUARIO<BR>";
				return false;
			}

		}
		else{
		//echo "<BR>".$usuario." ENCONTRADO EN LA TABLA USUARIO<BR>";
		return false;
		}

	}
	else{
		$password="temp".agregarceros(rand(0,9999),4);
		$arrayusuarioscreados["Nombre"][]=$nombreusuario;
		$arrayusuarioscreados["Documento"][]=$numerodocumento;
		$arrayusuarioscreados["Correo"][]=$email;
		$arrayusuarioscreados["Usuario"][]=$usuariodatos['usuario'];
		$arrayusuarioscreados["Clave"][]=$password;
		

		$fila["clave"]=$password;
		$arrayusuarios=$objetoldap->BusquedaUsuarios("uid=".$usuariodatos['usuario']);
echo "<pre>";
print_r($arrayusuarios);
echo "<pre>";
		if($arrayusuarios["count"]==0){
		$objetoldap->EntradaDocente($usuariodatos['usuario'],$password,$fila,$dnpadre);
		$arrayusuarioscreados["Mensaje"][]="Encontrado y creado en el LDAP";
		}
		else{
		$info["gacctMail"]=$email;
		$info["mail"]=$usuariodatos['usuario']."@unbosque.edu.co";

		$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($password)));
		$objetoldap->ModificacionUsuario($info,$usuariodatos['usuario']);
		$arrayusuarioscreados["Mensaje"][]="Encontrado y modificado en LDAP";
		}
	//echo "<BR>".$nombreusuario." ENCONTRADO EN LA TABLA USUARIO<BR>";
	return true;
	}

}

$objetobase=new BaseDeDatosGeneral($salaobjecttmp);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
$objetoldap->ConexionAdmin();

//$objetobase->conexion->query("select usuario from usuario order by usuario desc");

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo '../matriculas/menu.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo '../matriculas/menu.php';?>";
}
function enviarmenu()
{
form1.action="";
form1.submit();
}
</script>


<form name="form1" action="" method="post" enctype="multipart/form-data" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
	$formulario->dibujar_fila_titulo('CREACION DE USUARIOS DOCENTE','labelresaltado',"2","align='center'");

   	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','');

	//$codigofacultad="05";
	$condicion="c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
				order by c.nombrecarrera";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,'',0);
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');

	$campo="boton_tipo"; $parametros="'file','archivodocentes','".$archivodocentes."'";
    $formulario->dibujar_campo($campo,$parametros,"Numero de Orden Pago","tdtitulogris",'archivodocentes','');
	$parametrobotonenviar="'submit','Enviar','Enviar'";
	$boton='boton_tipo';
	$formulario->dibujar_campo($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	if(isset($_REQUEST['Enviar'])){
		$arrayusuarioscreados=array();
		$dataexcel = new Spreadsheet_Excel_Reader();
		$dataexcel->setOutputEncoding('CP1251');
		$datoscarreraldap=$objetobase->recuperar_datos_tabla("carreraldap","codigocarrera",$_POST["codigocarrera"]," and codigoestado=100","",0);

			if($formulario->valida_formulario()){
			//echo "ENTRO SI? ".$_POST["numeroordenpago"];
				$dataexcel->read($HTTP_POST_FILES['archivodocentes']['tmp_name']);
				for($i=1; $i<($dataexcel->sheets[0]['numRows']+1); $i++)
				{
					
					$nombreusuario=quitartilde($dataexcel->sheets[0]['cells'][$i][1]);
					$cuentapalabrasusuario=cuentapalabras(trim($nombreusuario));
	
					$apellido1=trim(sacarpalabras(trim($nombreusuario),$cuentapalabrasusuario-1,$cuentapalabrasusuario-1));					
					$nombre=trim(sacarpalabras(trim($nombreusuario),0,0));
					$numerodocumento=str_replace(",","",$dataexcel->sheets[0]['cells'][$i][2]);
					$numerodocumento=str_replace(".","",$numerodocumento);
					$email=$dataexcel->sheets[0]['cells'][$i][3];
					
					if(trim($datoscarreraldap["direccioncarreraldap"])!='')
						$dnpadre="ou=Docentes,".$datoscarreraldap["direccioncarreraldap"];
					else
						$dnpadre="ou=Usuarios,".RAIZDIRECTORIO;

					$cuentacorreocreada=false;
					$j=0;
					while($cuentacorreocreada==false){	
					$j++;
					//ob_flush();
					//flush();
			
						switch($j)
						{
							case 1:
							$usuario=strtolower($apellido1.$nombre);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							case 2:
							$usuario=strtolower($apellido1.$nombre.$apellido1[0]);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							case 3:
							$usuario=strtolower($apellido1.$nombre.$apellido1[0].$apellido1[1]);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							case 4:
							$usuario=strtolower($apellido1.$nombre.$apellido1[0].$apellido1[1].$apellido1[2]);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							case 5:
							$usuario=strtolower($apellido1.$nombre.$apellido1[0].$apellido1[1].$apellido1[2].$apellido1[3]);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							case 6:
							$usuario=strtolower($apellido1.$nombre.$apellido1[0].$apellido1[1].$apellido1[2].$apellido1[3].$apellido1[4]);
							$cuentacorreocreada=crearusuariodocente($usuario,$numerodocumento,$nombreusuario,$email,$objetoldap,$objetobase,$dnpadre);
							break;
							default:
							echo "<BR>".$nombreusuario." USUARIO NO CREADO<BR>";			
							$cuentacorreocreada=true;
							break;
						}
						
					}
					echo "<br>";
				}

			}
			echo "<pre>";
			//print_r($arrayusuarioscreados);
			echo "</pre>";
			
			echo "<table>";
			echo "<tr>";
			echo "<td>No</td>";
			foreach ($arrayusuarioscreados as $llave=>$valor)
				echo "<td>".$llave."</td>";
			echo "</tr>";

			foreach ($arrayusuarioscreados[$llave] as $orden=>$fila){
			echo "<tr>";
			echo "<td>".($orden+1)."</td>";
				foreach ($arrayusuarioscreados as $llave=>$valor)
					echo "<td>".$arrayusuarioscreados[$llave][$orden]."</td>";
			echo "</tr>";
			}
			echo "</table>";
	}
?>
  </table>
</form>
