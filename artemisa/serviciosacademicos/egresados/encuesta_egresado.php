<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

?>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<style>
    button,select , input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>

<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>
<script>
	function mostrar(vlr) {
		if(vlr==1)
			document.getElementById("encuesta").style.display='';
		else
			document.getElementById("encuesta").style.display='none';
	}
	function mostrar2(vlr) {
		if(vlr==4)
			document.getElementById("otrocontrato").style.display='';
		else {
			document.getElementById("otrocontrato").style.display='none';
			document.form3.otrotipocontratoactualestudianteegresado.value='';
		}
	}
	function mostrar3(vlr) {
		if(vlr==2000)
			document.getElementById("otraciudad").style.display='';
		else {
			document.getElementById("otraciudad").style.display='none';
			document.form3.otraciudadresidenciaestudianteegresado.value='';
		}
	}
	function validacion_previa() {
		//if(document.form3.ciudadresidenciaestudiantegeneral.value==2000 && document.form3.otraciudadresidenciaestudianteegresado.value=='') {
		//	alert('Por favor ingrese la ciudad de residencia.');
		//} else {
		//	if(document.form3.tipocontratoactualestudianteegresado.value==4 && document.form3.otrotipocontratoactualestudianteegresado.value=='')
		//		alert('Por favor ingrese el otro tipo de contrato.');
		//	else
				document.form3.submit();
		//}
	}
</script>
<table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='consulta_egresado.php'" value="Regresar" name="addfieldbtn"/>
        </div>
        </td></tr>
    <tr><td colspan="3">Encuesta de Egresados<hr></td></tr>
    <tr><td colspan="3">
<?php
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado = ("../funciones/adodb/");
require_once("../funciones/clases/motorv2/motor.php");
require_once("../Connections/salaado-pear.php");
require_once("../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../funciones/clases/formulario/clase_formulario.php");
require_once("../funciones/sala_genericas/FuncionesCadena.php");
require_once("../funciones/sala_genericas/FuncionesFecha.php");
require_once("../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../funciones/sala_genericas/formulariobaseestudiante.php");

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');

echo "<form name=\"form3\" action=\"\" method=\"post\">";


echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">";

$formulario->dibujar_fila_titulo('MODIFICAR INFORMACION EGRESADOS','labelresaltado',"2","align='center'");
$datos=$objetobase->recuperar_datos_tabla("estudiante e join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral join (select codigoestudiante,fechagradoregistrograduado as fechagrado from registrograduado union select codigoestudiante,fechagradoregistrograduadoantiguo as fechagrado from registrograduadoantiguo) as sub on e.codigoestudiante=sub.codigoestudiante left join egresado ee on eg.idestudiantegeneral=ee.idestudiantegeneral left join egresado_ext ee_e on eg.idestudiantegeneral = ee_e.codigoestudiante ","eg.idestudiantegeneral",$_REQUEST['idestudiantegeneral'],'','',0);
$campo="boton_tipo"; $parametros="'text','apellidosestudiantegeneral','".$datos[apellidosestudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellidosestudiantegeneral','requerido');
$campo="boton_tipo"; $parametros="'text','nombresestudiantegeneral','".$datos[nombresestudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombresestudiantegeneral','requerido');
$campo="boton_tipo"; $parametros="'text','numerodocumento','".$datos[numerodocumento]."'";
$formulario->dibujar_campo($campo,$parametros,"Documento","tdtitulogris",'numerodocumento','requerido');
$campo="boton_tipo"; $parametros="'text','telefonoresidenciaestudiantegeneral','".$datos[telefonoresidenciaestudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"Tel&eacute;fono","tdtitulogris",'telefonoresidenciaestudiantegeneral','requerido');
$campo="boton_tipo"; $parametros="'text','telefono2estudiantegeneral','".$datos[telefono2estudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"Tel&eacute;fono Opcional","tdtitulogris",'telefono2estudiantegeneral','');
$campo="boton_tipo"; $parametros="'text','celularestudiantegeneral','".$datos[celularestudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"Celular","tdtitulogris",'celularestudiantegeneral','');
$campo="boton_tipo"; $parametros="'text','emailestudiantegeneral','".$datos[emailestudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"E-mail","tdtitulogris",'emailestudiantegeneral','email');
$campo="boton_tipo"; $parametros="'text','email2estudiantegeneral','".$datos[email2estudiantegeneral]."'";
$formulario->dibujar_campo($campo,$parametros,"E-mail 2","tdtitulogris",'email2estudiantegeneral','');



echo "<tr><td colspan='2'><table align=\"left\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\"><tr><td colspan='3'><label id='labelresaltado'>Carrera(s) de la cual salio egresado</label></td></tr><tr><td id='tdtitulogris' align='center'>Cod. Carrera</td><td id='tdtitulogris' align='center'>Nombre Carrera</td><td id='tdtitulogris' align='center'>Fecha grado</td></tr>";
$query="select c.codigocarrera,c.nombrecarrera,sub.fechagrado from estudiante e join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral join (select codigoestudiante,fechagradoregistrograduado as fechagrado from registrograduado union select codigoestudiante,fechagradoregistrograduadoantiguo as fechagrado from registrograduadoantiguo) as sub on e.codigoestudiante=sub.codigoestudiante join carrera c on e.codigocarrera=c.codigocarrera where e.idestudiantegeneral=".$_REQUEST['idestudiantegeneral'];
$operacion = $objetobase->conexion->query($query);
while ($row_operacion = $operacion->fetchRow())
	echo "<tr><td>".$row_operacion['codigocarrera']."</td><td>".$row_operacion['nombrecarrera']."</td><td>".$row_operacion['fechagrado']."</td></tr>";
echo "</table></td></tr>";

$query="select * from label a inner join label_type b on a.idlabel_type = b.idlabel_type where table_name ='egresado_ext' and status = 1;";

$labels = $objetobase->conexion->query($query);
while ($row_labels = $labels->fetchRow()){
    $dataArray='';
    $arrrir='';
     $arrrre2='';   
    if($row_labels['function_label']=='dropdown'){
        $campo="menu_fila";
        $datos[$row_labels['field']];
         $parametros="'".$row_labels['field']."','".$datos[$row_labels['field']]."',''";
        $dataArray = explode("|",$row_labels['default_value']);                
        if(is_array($dataArray)){
            foreach ($dataArray as $values){
                $arrrir = explode(":",$values);
                $arrrre2[$arrrir[0]]= $arrrir[1];
            }
        }
        $formulario->filatmp=$arrrre2;
        //$formulario->filatmp["0"]="Seleccionar";
        $formulario->dibujar_campo($campo,$parametros,$row_labels['label_field'],"tdtitulogris",'email2estudiantegeneral','');
        //echo $parametros;
    }else if($row_labels['function_label']=='radio'){
        $campo="radio_fila2";
       $parametros="'".$row_labels['field']."','".$datos[$row_labels['field']]."','".$datos[email2estudiantegeneral]."'";
        $dataArray = explode("|",$row_labels['default_value']);
        if(is_array($dataArray)){
            foreach ($dataArray as $values){
                $arrrir = explode(":",$values);
                $arrrre2[$arrrir[0]]= $arrrir[1];
            }
        }
        $formulario->filatmp=$arrrre2;
        $formulario->dibujar_campo($campo,$parametros,$row_labels['label_field'],"tdtitulogris",'email2estudiantegeneral','');
    }else{
         $campo="boton_tipo"; $parametros="'".$row_labels['function_label']."','".$row_labels['field']."','".$datos[$row_labels['field']]."'";
         $formulario->dibujar_campo($campo,$parametros,$row_labels['label_field'],"tdtitulogris",'email2estudiantegeneral','');
    }
    
    
}
//exit();
//
//$datos_formulario=$objetobase->recuperar_datos_tabla(
//        "estudiante e join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
//            join (select codigoestudiante,fechagradoregistrograduado as fechagrado
//            from registrograduado union select codigoestudiante,fechagradoregistrograduadoantiguo as fechagrado
//            from registrograduadoantiguo) as sub on e.codigoestudiante=sub.codigoestudiante
//            left join estudianteegresado ee on eg.idestudiantegeneral=ee.idestudiantegeneral",
//        "eg.idestudiantegeneral",$_REQUEST['idestudiantegeneral'],'','',0);
//
//
//
//
//
//$campo="boton_tipo"; $parametros="'text','programaactualuebestudianteegresado','".$datos[programaactualuebestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"Programa en el que estudia actualmente en la UEB?","tdtitulogris",'programaactualuebestudianteegresado','');
//$campo="boton_tipo"; $parametros="'text','anioterminacionprogramaactualuebestudianteegresado','".$datos[anioterminacionprogramaactualuebestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"A&ntilde;o de Terminaci&oacute;n Programa de Estudio","tdtitulogris",'anioterminacionprogramaactualuebestudianteegresado','');
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("ciudad","idciudad","nombreciudad","");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'ciudadresidenciaestudiantegeneral','".$datos[ciudadresidenciaestudiantegeneral]."','OnChange=\"mostrar3(this.value)\"'";
//$formulario->dibujar_campo($campo,$parametros,"Ciudad residencia","tdtitulogris",'ciudadresidenciaestudiantegeneral','requerido');
//$display=($datos[ciudadresidenciaestudiantegeneral]==2000)?"":"display:none";
//echo "<tr id='otraciudad' style='$display'><td>&nbsp;</td><td>Cual? <input type='text' name='otraciudadresidenciaestudianteegresado' value='".$datos[otraciudadresidenciaestudianteegresado]."'></td></tr>";
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=1");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'estalaborandoactualmenteestudianteegresado','".$datos[estalaborandoactualmenteestudianteegresado]."','onChange=\"javascript:mostrar(this.value)\"'";
//$formulario->dibujar_campo($campo,$parametros,"Actualmente se encuentra laborando?","tdtitulogris",'estalaborandoactualmenteestudianteegresado','');
//echo "</table><br>";
//$display=($datos[estalaborandoactualmenteestudianteegresado]==1)?"":"display:none";
//echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" id=\"encuesta\" style=\"$display\">";
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=2");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'ustedesestudianteegresado','".$datos[ustedesestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"Usted es?","tdtitulogris",'ustedesestudianteegresado','');
//$campo="boton_tipo"; $parametros="'text','empresadondetrabajaestudianteegresado','".$datos[empresadondetrabajaestudianteegresado]."','size=80'";
//$formulario->dibujar_campo($campo,$parametros,"Me podr&iacute;a dar el nombre de la empresa/organizaci&oacute;n/entidad donde trabaja?","tdtitulogris",'empresadondetrabajaestudianteegresado','');
//
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=3");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'sectordondeseubicasuempresaestudianteegresado','".$datos[sectordondeseubicasuempresaestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"En cu&aacute;l de los siguientes sectores est&aacute; ubicada su empresa?","tdtitulogris",'sectordondeseubicasuempresaestudianteegresado','');
//$campo="boton_tipo"; $parametros="'text','cargoocupaactualmenteestudianteegresado','".$datos[cargoocupaactualmenteestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"El cargo que ocupa actualmente en su empleo es?","tdtitulogris",'cargoocupaactualmenteestudianteegresado','');
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=4");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'coincidenciaactlaboralactualvscarreraestudianteegresado','".$datos[coincidenciaactlaboralactualvscarreraestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"El nivel de coincidencia entre la actividad laboral actual y su carrera profesional es?","tdtitulogris",'coincidenciaactlaboralactualvscarreraestudianteegresado','');
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=5");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'tipocontratoactualestudianteegresado','".$datos[tipocontratoactualestudianteegresado]."','OnChange=\"mostrar2(this.value)\"'";
//$formulario->dibujar_campo($campo,$parametros,"Qu&eacute; tipo de contrato de vinculaci&oacute;n tiene con la empresa en que labora actualmente?","tdtitulogris",'tipocontratoactualestudianteegresado','');
//$display=($datos[tipocontratoactualestudianteegresado]==4)?"":"display:none";
//echo "<tr id='otrocontrato' style='$display'><td>&nbsp;</td><td>Cual? <input type='text' name='otrotipocontratoactualestudianteegresado' value='".$datos[otrotipocontratoactualestudianteegresado]."'></td></tr>";
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=6");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'ingresosalarialactualestudianteegresado','".$datos[ingresosalarialactualestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"Cu&aacute;l es su ingreso salarial actual?","tdtitulogris",'ingresosalarialactualestudianteegresado','');
//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=1");
//$formulario->filatmp["0"]="Seleccionar";
//$campo='menu_fila';
//$parametros="'tienecarnetegresadoestudianteegresado','".$datos[tienecarnetegresadoestudianteegresado]."'";
//$formulario->dibujar_campo($campo,$parametros,"Tiene carnet de egresado?","tdtitulogris",'tienecarnetegresadoestudianteegresado','');
/*$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudianteegresadodatosformulario","valor","descripcion","clasificacion=3");
$formulario->filatmp[""]="Seleccionar";
$campo='menu_fila';
$parametros="'','".$datos[]."'";
$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris",'','');*/

//$campo="boton_tipo"; $parametros="'text','','".$datos[]."'";
//$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris",'','');

//$campo="memo"; $parametros="'observacionesestudianteegresado','estudianteegresado',70,8,'','','',''";
//$formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacionesestudianteegresado');
//$formulario->cambiar_valor_campo('observacionesestudianteegresado',$datos[observacionesestudianteegresado],'form3');
echo "</table><table>";
$campo="boton_tipo"; $parametros="'hidden','codigoestudiante','".$_REQUEST['idestudiantegeneral']."'";
$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris",'codigoestudiante','');
$campo="boton_tipo"; $parametros="'hidden','accion','Enviar'";
$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris",'accion','');


$boton[0]="boton_tipo"; $parametrosboton[0]="'button','accion','Guardar','OnClick=validacion_previa()'";
$boton[1]="boton_tipo"; $parametrosboton[1]="'button','accion','Regresar','OnClick=javascript:location.href=\"consulta_egresado.php\"'";
$formulario->dibujar_campos($boton,$parametrosboton,"&nbsp;","tdtitulogris","","");

echo "</table>";
echo "</form>";
if($_REQUEST['accion']=="Enviar") {
	//print_r($_REQUEST);exit;
	if($formulario->valida_formulario()){

		//print_r($_REQUEST);exit;
		//print_r($_SESSION);exit;

		$nombreidtabla="idestudiantegeneral";
		$idtabla=$_REQUEST["idestudiantegeneral"];
		$tabla="estudiantegeneral";
		$fila['apellidosestudiantegeneral']         =trim($_REQUEST['apellidosestudiantegeneral']);
		$fila['nombresestudiantegeneral']           =trim($_REQUEST['nombresestudiantegeneral']);
		$fila['numerodocumento']                    =trim($_REQUEST['numerodocumento']);
		$fila['telefonoresidenciaestudiantegeneral']=trim($_REQUEST['telefonoresidenciaestudiantegeneral']);
		$fila['telefono2estudiantegeneral']         =trim($_REQUEST['telefono2estudiantegeneral']);
		$fila['celularestudiantegeneral']           =trim($_REQUEST['celularestudiantegeneral']);
		$fila['emailestudiantegeneral']             =trim($_REQUEST['emailestudiantegeneral']);
		$fila['email2estudiantegeneral']            =trim($_REQUEST['email2estudiantegeneral']);
		$fila['ciudadresidenciaestudiantegeneral']  =trim($_REQUEST['ciudadresidenciaestudiantegeneral']);
		$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);

		$fecha_actual=date('Y-m-d H:i:s');

		$fila=array();
		$nombreidtabla="codigoestudiante";
                $tabla="egresado_ext";
                $idtabla=$_REQUEST["codigoestudiante"];
		$fila['codigoestudiante'] =trim($_REQUEST['idestudiantegeneral']);

                $query = "select *from label where table_name = 'egresado_ext' and status = 1;";
                $operacion = $objetobase->conexion->query($query);
                while ($row_operacion = $operacion->fetchRow()) {
                $fila[''.$row_operacion['field'].''] = trim($_REQUEST[$row_operacion['field']]);
                //$elelmentos[] = $row_operacion['field'];
                }
                $query = "select * from egresado_ext where codigoestudiante = trim('".$_REQUEST['idestudiantegeneral']."');";
                $operacion = $objetobase->conexion->query($query);
                if($operacion->numRows()> 0){
                    $objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
                }else{
                    $objetobase->ingresar_actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
                }
                //while ($operacion->countRow()) {

                //}
//		$fila['fechaactualizacionestudianteegresado']                   =$fecha_actual;
//		$fila['otraciudadresidenciaestudianteegresado']                 =trim($_REQUEST['otraciudadresidenciaestudianteegresado']);
//		$fila['programaactualuebestudianteegresado']                    =trim($_REQUEST['programaactualuebestudianteegresado']);
//		$fila['anioterminacionprogramaactualuebestudianteegresado']     =trim($_REQUEST['anioterminacionprogramaactualuebestudianteegresado']);
//		$fila['estalaborandoactualmenteestudianteegresado']             =trim($_REQUEST['estalaborandoactualmenteestudianteegresado']);
//		$fila['ustedesestudianteegresado']                              =trim($_REQUEST['ustedesestudianteegresado']);
//		$fila['empresadondetrabajaestudianteegresado']                  =trim($_REQUEST['empresadondetrabajaestudianteegresado']);
//		$fila['sectordondeseubicasuempresaestudianteegresado']          =trim($_REQUEST['sectordondeseubicasuempresaestudianteegresado']);
//		$fila['cargoocupaactualmenteestudianteegresado']                =trim($_REQUEST['cargoocupaactualmenteestudianteegresado']);
//		$fila['coincidenciaactlaboralactualvscarreraestudianteegresado']=trim($_REQUEST['coincidenciaactlaboralactualvscarreraestudianteegresado']);
//		$fila['tipocontratoactualestudianteegresado']                   =trim($_REQUEST['tipocontratoactualestudianteegresado']);
//		$fila['otrotipocontratoactualestudianteegresado']               =trim($_REQUEST['otrotipocontratoactualestudianteegresado']);
//		$fila['ingresosalarialactualestudianteegresado']                =trim($_REQUEST['ingresosalarialactualestudianteegresado']);
//		$fila['tienecarnetegresadoestudianteegresado']                  =trim($_REQUEST['tienecarnetegresadoestudianteegresado']);
//		$fila['observacionesestudianteegresado']                        =trim($_REQUEST['observacionesestudianteegresado']);
		//$objetobase->ingresar_actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);

//		$fila=array();
//		$tabla="estudianteegresadolog";
//		$fila['usuarioactualizo']						=$_SESSION['MM_Username'];
//		$fila['idestudiantegeneral']						=trim($_REQUEST['idestudiantegeneral']);
//		$fila['fechaactualizacionestudianteegresado']                  		=$fecha_actual;
//		$fila['numerodocumentoestudianteegresadolog']                  		=trim($_REQUEST['numerodocumento']);
//		$fila['nombresestudianteegresadolog']  				        =trim($_REQUEST['nombresestudiantegeneral']);
//		$fila['apellidosestudianteegresadolog']				        =trim($_REQUEST['apellidosestudiantegeneral']);
//		$fila['ciudadresidenciaestudianteegresadolog']				=trim($_REQUEST['ciudadresidenciaestudiantegeneral']);
//		$fila['otraciudadresidenciaestudianteegresadolog']			=trim($_REQUEST['otraciudadresidenciaestudianteegresado']);
//		$fila['telefonoresidenciaestudianteegresadolog']			=trim($_REQUEST['telefonoresidenciaestudiantegeneral']);
//		$fila['telefono2estudianteegresadolog']				        =trim($_REQUEST['telefono2estudiantegeneral']);
//		$fila['celularestudianteegresadolog']				        =trim($_REQUEST['celularestudiantegeneral']);
//		$fila['emailestudianteegresadolog']				        =trim($_REQUEST['emailestudiantegeneral']);
//		$fila['email2estudianteegresadolog']				        =trim($_REQUEST['email2estudiantegeneral']);
//		$fila['programaactualuebestudianteegresadolog']          		=trim($_REQUEST['programaactualuebestudianteegresado']);
//		$fila['anioterminacionprogramaactualuebestudianteegresadolog']		=trim($_REQUEST['anioterminacionprogramaactualuebestudianteegresado']);
//		$fila['estalaborandoactualmenteestudianteegresadolog']			=trim($_REQUEST['estalaborandoactualmenteestudianteegresado']);
//		$fila['ustedesestudianteegresadolog']                                   =trim($_REQUEST['ustedesestudianteegresado']);
//		$fila['empresadondetrabajaestudianteegresadolog']                       =trim($_REQUEST['empresadondetrabajaestudianteegresado']);
//		$fila['sectordondeseubicasuempresaestudianteegresadolog']               =trim($_REQUEST['sectordondeseubicasuempresaestudianteegresado']);
//		$fila['cargoocupaactualmenteestudianteegresadolog']                     =trim($_REQUEST['cargoocupaactualmenteestudianteegresado']);
//		$fila['coincidenciaactlaboralactualvscarreraestudianteegresadolog']     =trim($_REQUEST['coincidenciaactlaboralactualvscarreraestudianteegresado']);
//		$fila['tipocontratoactualestudianteegresadolog']                        =trim($_REQUEST['tipocontratoactualestudianteegresado']);
//		$fila['otrotipocontratoactualestudianteegresadolog']	                =trim($_REQUEST['otrotipocontratoactualestudianteegresado']);
//		$fila['ingresosalarialactualestudianteegresadolog']                     =trim($_REQUEST['ingresosalarialactualestudianteegresado']);
//		$fila['tienecarnetegresadoestudianteegresadolog']                       =trim($_REQUEST['tienecarnetegresadoestudianteegresado']);
//		$fila['observacionesestudianteegresadolog']                             =trim($_REQUEST['observacionesestudianteegresado']);
		//$objetobase->insertar_fila_bd($tabla,$fila);

		alerta_javascript("Datos Modificados Correctamente.");
		echo "<script>location.href='detalle_consulta_egresado.php?idestudiantegeneral=".$_REQUEST['idestudiantegeneral']."'</script>";
	}
}
?>
        </tr>
</table>
