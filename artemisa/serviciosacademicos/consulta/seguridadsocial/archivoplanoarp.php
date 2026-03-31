<?php
//session_cache_limiter('private');
//session_start();
$rutaado=("../../funciones/adodb/");
//require_once("../../funciones/clases/debug/SADebug.php");
//require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
//require_once("../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
//require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/DatosGenerales.php");
require_once("funciones/FuncionesAportes.php");

		$strType = 'text/plain';
		$strName = "aportespostgradoarp".formato_fecha_mysql("01/".$_POST['mescierre']).".txt";
		//header("Content-Type: $strType ");
		//header('Content-Type: text/html; charset=UTF-8');
		header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Content-Type: public");
		header('Content-Type: text/plain; charset=UTF-8');


class  ArchivoPlano{

	var $nombrearchivo;
	var $matrizcampos;
	var $vectorlongitudes;
	var $apuntadorarchivo;
	var $encabezadoarchivo;
	var $lineas;
	var $titulos;

	function ArchivoPlano($archivo,$matriz,$longitudes,$tituloarchivo){
	$this->nombrearchivo=$archivo;
	//$this->apuntadorarchivo=fopen($this->nombrearchivo,"w+");
	$this->matrizcampos=$matriz;
	$this->vectorlongitudes=$longitudes;	
	$this->encabezadoarchivo=$encabezado;
	$this->titulos=$tituloarchivo;
	}
	function crearlineas(){
		for($i=0;$i<=count($this->matrizcampos);$i++){
			for($j=0;$j<count($this->matrizcampos[0]);$j++)
				 $this->lineas[$i] .=  "".$this->forzarlongitud($this->matrizcampos[$i][$j],$this->vectorlongitudes[$j]);
		  	$this->lineas[$i] .=  chr(13)."\n";
		}
		
	}
	function forzarlongitud($campo,$longitud){
	$longitudcampo=strlen($campo);
	$longitudcampo>$longitud ? $nuevocampo=substr($campo,0,$longitud) : $nuevocampo=agregarespacios($campo,$longitud);
	return $nuevocampo;
	}
	function agregartitulos(){
			for($j=0;$j<count($this->matrizcampos[0]);$j++)
				 $lineastitulo .=  "".$this->forzarlongitud($this->titulos[$j],$this->vectorlongitudes[$j]);
		  	$lineastitulo .=  "\n";
			//fputs($this->apuntadorarchivo,$lineastitulo);
	}
	function creararchivo(){
		//fputs($this->apuntadorarchivo,$this->encabezadoarchivo);
	for($i=0;$i<count($this->lineas);$i++)
		fputs($this->apuntadorarchivo,$this->lineas[$i]);
	fclose($this->apuntadorarchivo);
	}
}
function restringirnombrescortos($listainicial,$listarestringida){
		$con=0;
		for($i=0;$i<count($listainicial);$i++){
			$siga=1;
			for($j=0;$j<count($listarestringida);$j++){
				if($listarestringida[$j]==$listainicial[$i]){
					$siga=0;
				}
			}
			if($siga){
			$listafinal[$con]=$listainicial[$i];
			$con++;
			}
			
		}
		return $listafinal;		

}
function validaagujapajar($pajar,$aguja){
$siga=0;
for($i=0;$i<count($pajar);$i++){
	//echo "if($aguja==".$pajar[$i].")<br>";
	if($aguja==$pajar[$i])
		$siga=1;
		}
return $siga;
}
/*$adjunto=adjuntoquery($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo']);
$query="SELECT distinct 
e.idestudiantegeneral,
e.codigoestudiante ,
d.nombrecortodocumento,
eg.numerodocumento,
eg.apellidosestudiantegeneral apellidos,
eg.nombresestudiantegeneral nombres,
c.nombrecortocarrera,
c.codigocarrera
FROM estudiante e, estudiantegeneral eg, 
carrera c, modalidadacademica ma, documento d,  ordenpago op 
WHERE e.idestudiantegeneral=eg.idestudiantegeneral
AND e.codigocarrera = c.codigocarrera
AND c.codigomodalidadacademica=ma.codigomodalidadacademica
AND eg.tipodocumento=d.tipodocumento
AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
AND ma.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
AND e.codigoestudiante=op.codigoestudiante
AND op.codigoperiodo='".$_POST['codigoperiodo']."'
AND op.codigoestadoordenpago like '4%'
 ".$adjunto["query"]."
order by apellidosestudiantegeneral,nombresestudiantegeneral
";*/
	$defecto="40";
	if($_POST['ordenpago']) $ordenpago=$_POST['ordenpago']; else $ordenpago=$defecto;


$query=querylistadocierrearp($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo'],$codigomodalidadacademica,0,$ordenpago);
//echo "QUERY=".$query;
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
$datos_bd=new BaseDeDatosGeneral($sala);
//$formulario=new formulariobaseestudiante($salad,'form2','post','','true');
$encabezado = date("d/m/Y H:i:s").esp(20)."NIT".esp(40)."CLASE".esp(10)."GRANDE".esp(5)."PEQUEÑO\n".
			  $row_operacion_universidad['nombreuniversidad'].esp(19)."X".esp(3).substr($row_operacion_universidad['nituniversidad'],4).esp(24)."APORTANTE".esp(9)."X"."\n".
			  "CONVENIO DOCENTE ASISTENCIAL"."\n\n".
			  $row_operacion_universidad['direccionuniversidad'].esp(5).$encabezadociudad.esp(1).$encabezadotelefono.esp(3)."PERIODO".esp(8)."AA".esp(4)."MM".esp(3).$encabezadoentidadnumero."\n".
			  esp(82)."COTIZACION".esp(3).date("Y").esp(4).date("m")."\n\n".
			  esp(57)."UNICO".esp(3)."CONSOL".esp(5)."SUCURSAL".esp(8)."TOT.ESTU.".esp(8)."PORCENTAJE".esp(3).$encabezadoporcentajecotizacion."\n".
			  esp(43)."PRESENTACION".esp(12)."X".esp(10).$encabezadosucursal.esp(17).$total.esp(11)."LIQUIDACION"."\n".
			  esp(64)."NOVEDADES"."\n\n".
			  "CODIGO".esp(5)."DOCUMENTO".esp(6)."NOMBRE".esp(25).$encabezadonovedades1.esp(2)."D".esp(4)."SALARIO".esp(3)."VALOR".esp(6)."INGRESO".esp(5)."COTIZACION"."\n".
			  esp(57).$encabezadonovedades2.esp(2)."I".esp(4)."BASICO".esp(4)."NETO".esp(7)."BASE DE".esp(5)."OBLIGATORIA"."\n".
			  esp(57).$encabezadonovedades3.esp(2)."A".esp(14)."NOVEDADES".esp(2)."COTIZACION"."\n".
			  esp(80)."S"."\n";
$total=0;
			  

$letras=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","V","W","X","Y","Z");
$total=0;
do
{
		$mescierre=$_POST['mescierre'];
		//echo "IDESTUDIANTEGENERAL=".$row_operacion['idestudiantegeneral']."<BR>";
		$condicion=" and c.codigocarrera=e.codigocarrera
		group by idestudiantegeneral";
		$datos_estudiante=$datos_bd->recuperar_datos_tabla("estudiante e, carreracentrotrabajoarp c","idestudiantegeneral",$row_operacion['idestudiantegeneral'],$condicion,', max(codigoestudiante) numeroestudiante');

		
		if(validar_estudiante_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd,$pagoeps,$pagoarp,$ingresado))
				if(validar_estudiante_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd,$pagoeps,$pagoarp,4)){
		

		$datosnovedad=eps_mes($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		$datosempresaarp=recuperar_empresaarp($datos_bd,$row_operacion['idestudiantegeneral'],$mescierre,0);
		$row_operacion['Codigo_ARP']=$datosempresaarp['codigoempresasalud'];
		//$row_operacion['EPS']=$datosnovedad['nombreempresasalud']."";
		//$row_operacion['Codigo_EPS']=$datosnovedad['codigoempresasalud']."";
		if(existe_tae_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd)){
		$datosnovedadtae=eps_tae($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['EPS_Traslado']=$datosnovedadtae['nombreempresasalud']."";
		//$row_operacion['Codigo_EPS_Traslado']=$datosnovedadtae['codigoempresasalud']."";
		}
		else{
		//$row_operacion['EPS_Traslado']="";
		//$row_operacion['Codigo_EPS_Traslado']="";
		}
		//$datos_ibc_eps=ibc_eps($mescierre,$row_operacion['codigoestudiante'],$datos_bd);
		$datos_ibc_arp=ibc_arp($mescierre,$row_operacion['codigoestudiante'],$datos_bd,$row_operacion['idestudiantegeneral']);
			
		//$row_operacion['Dias_EPS']=$datos_ibc_eps['dias_eps'];
		//$row_operacion['Codigo_Traslado_EPS']=;
		//$lapso=lapso_resultado_novedad($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'SLN');
	
		$row_operacion['Dias_ARP']=$datos_ibc_arp['dias_arp'];
		//dias_arp($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$datoscentrotrabajo=centrotrabajo($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd);
		//$row_operacion['Salario_basico']=round((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']),-3)."";
		$row_operacion['Salario_basico']=roundmilss((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']))."";

		//$row_operacion['IBC_EPS']=$datos_ibc_eps['ibc_eps']."";
		$row_operacion['IBC_ARP']=$datos_ibc_arp['ibc_arp']."";
		$row_operacion['Tarifa_Aportes']=tarifa_aportes_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['Cotizacion_EPS']=round(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']),-2);
		$row_operacion['Tarifa_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['porcentajecotizacionarp']."";
		$row_operacion['Codigo_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['codigocentrotrabajoarp']."";
		//$row_operacion['Cotizacion_ARP']=round(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']),-2)."";
		$row_operacion['Cotizacion_ARP']=roundcienss(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']))."";
		
		$ing=" ";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'INA'))
		$ing="X";
		$row_operacion['ING']=$ing;
	
		$ing=" ";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'REA'))
		$ing="X";
		$row_operacion['RET']=$ing;
	
		$tde=" ";	
		$tae=" ";		
		if($datos_tae=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'TAE')){
			$taevigente_1=validar_novedad_tae($datos_bd,$datos_tae['idestudiantenovedadarp'],formato_fecha_mysql("01/".$mescierre),$row_operacion['idestudiantegeneral'],0);
			$taevigente_2=validar_novedad_tae($datos_bd,$datos_tae['idestudiantenovedadarp'],formato_fecha_mysql(final_mes_fecha("01/".$mescierre)),$row_operacion['idestudiantegeneral'],0);
			if($taevigente_1||$taevigente_2){
				 if(!existe_tae_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd)){ 
					$tde="X";
				}
				else{
					$tae="X";
				}
			}
		}
		$row_operacion['TDE']=$tde;
		$row_operacion['TAE']=$tae;	
	
		$nombrenovedad=vector_nombres_cortos_novedad(300,$sala)	;
		for($i=0;$i<count($nombrenovedad);$i++){		
		$celda=" ";
		if($datos_nvd=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,$nombrenovedad[$i]))	 
			if($nombrenovedad[$i]=='IRP')
			$celda=$datos_ibc_arp['dias_irp']+0;
			else
			$celda="X";
		$row_operacion[$nombrenovedad[$i]]=$celda;
		}

	//if(validar_estudiante_arp($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd)){
	$array_interno[]=$row_operacion;
	$tipodocumento=$row_operacion['Tipo'];
	if($tipodocumento[1]=='I'||$tipodocumento[1]=='A')
	$tipodocumento[1]='E';
	$matriz[$total][]=agregarceros(($total+1),5); 											$longitudes[]=5;		$titulos[]="TD"; 
	$matriz[$total][]=2; 																	$longitudes[]=1;		$titulos[]="TD"; 

	$matriz[$total][]=$tipodocumento[1]; 													$longitudes[]=1;		$titulos[]="TD"; 
 	$matriz[$total][]=agregarceros($row_operacion['numerodocumento'],12);					$longitudes[]=12;		$titulos[]="CODIGO";
 	//$matriz[$total][]=agregarceros($row_operacion['codigoestudiante'],8); 		$longitudes[]=10;		$titulos[]="Codigo";
	//$matriz[$total][]=21;																	$longitudes[]=2;		$titulos[]="TC";
	$apellidos=quitartilde(strtoupper($row_operacion['apellidos']));
	$nombres=quitartilde(strtoupper($row_operacion['nombres']));
	$cuentapalabrasapellidos=cuentapalabras($apellidos);
	
	$matriz[$total][]=$apellidos." ".$nombres;												$longitudes[]=60;		$titulos[]="NOM2";
	
	$listarestringida=array("TDE","TAE","TDP","TAP","AVP");
	$nombrenovedad=restringirnombrescortos(vector_nombres_cortos_novedad(100,$sala),$listarestringida);
	
	//$nombrenovedad=vector_nombres_cortos_novedad(100,$sala)	;											
	for($i=0;$i<count($nombrenovedad);$i++){	
	$matriz[$total][]=$row_operacion[$nombrenovedad[$i]]."";								$longitudes[]=1;		$titulos[]=$letras[$i];
	}
	$j=$i;
//	$nombrenovedad=vector_nombres_cortos_novedad(300,$sala)	;
	$nombrenovedad=restringirnombrescortos(vector_nombres_cortos_novedad(300,$sala),$listarestringida);
	for($i=0;$i<count($nombrenovedad);$i++){
	if ($nombrenovedad[$i]=='IRP'){
	$esp=" "; 
	$lg=2;
		if($row_operacion[$nombrenovedad[$i]]==" ")
			$row_operacion[$nombrenovedad[$i]]=0;
	$matriz[$total][]=agregarceros($row_operacion[$nombrenovedad[$i]],2);
	}
	else{
	$esp=""; $lg=1;
	$matriz[$total][]=$row_operacion[$nombrenovedad[$i]]."$esp";
	}
	$longitudes[]=$lg;		$titulos[]=$letras[$i+$j];
	}

	//$matriz[$total][]=$row_operacion['apellidos'];						$longitudes[]=30;
	
	//$matriz[$total][]=$row_operacion['Codigo_EPS'];											$longitudes[]=6;		$titulos[]="NoEPS";
	//$matriz[$total][]=$row_operacion['Codigo_EPS_Traslado'];								$longitudes[]=6;		$titulos[]="NoEPST";
	//$matriz[$total][]=agregarceros($row_operacion['Dias_EPS'],2);							$longitudes[]=2;		$titulos[]="DE";
	$matriz[$total][]=agregarceros($row_operacion['Dias_ARP'],2);							$longitudes[]=2;		$titulos[]="DA";
	$matriz[$total][]=agregarceros($row_operacion['Salario_basico'],9);										$longitudes[]=9;		$titulos[]="Salario";
	$matriz[$total][]=agregarceros(0,9);													$longitudes[]=9;		$titulos[]="Salario";

	//$matriz[$total][]=$row_operacion['IBC_EPS'];											$longitudes[]=9;		$titulos[]="IBC_EPS";
	$matriz[$total][]=agregarceros($row_operacion['IBC_ARP'],9);							$longitudes[]=9;		$titulos[]="IBC_ARP";
	//$matriz[$total][]=agregarcerosderecha($row_operacion['Tarifa_Aportes'],7);				$longitudes[]=7;		$titulos[]="Tarifa";
	//$matriz[$total][]=$row_operacion['Cotizacion_EPS'];										$longitudes[]=9;		$titulos[]="EPS";
	$matriz[$total][]=agregarceros($row_operacion['Tarifa_Centro_Trabajo'],9);				$longitudes[]=9;		$titulos[]="TCT";
	$matriz[$total][]=agregarceros($row_operacion['Codigo_Centro_Trabajo'],9);				$longitudes[]=9;		$titulos[]="CCT";
	$matriz[$total][]=agregarceros($row_operacion['Cotizacion_ARP'],9);						$longitudes[]=9;		$titulos[]="ARP";
	$matriz[$total][]=agregarceros(0,5);													$longitudes[]=5;		$titulos[]="NFD_A";
	$matriz[$total][]=agregarceros(0,5);													$longitudes[]=5;		$titulos[]="P";

//	$matriz[$total][]=";";														$longitudes[]=1;		$titulos[]="Novedades";	
	
	//$matriz[$total][]=substr(strtoupper($tmpespacionovedades),0,26);			$longitudes[]=6;		$titulos[]="Novedades";
	//$matriz[$total][]=substr(strtoupper($tmpespacionovedades),0,26);{}
	$sumacotizacionarp+=$row_operacion['Cotizacion_ARP'];

	$total++;
		}
	//}
}
while ($row_operacion=$operacion->fetchRow());

$row_operacion_universidad=$datos_bd->recuperar_datos_tabla('universidad','iduniversidad','1');
$condicion=" and c.iddepartamento=d.iddepartamento";
$datosciudad=$datos_bd->recuperar_datos_tabla('ciudad c, departamento d','c.idciudad',$row_operacion_universidad['idciudad'],$condicion);
$idempresasalud=108;
$datosarp=$datos_bd->recuperar_datos_tabla('empresasalud','idempresasalud',$idempresasalud);
$encabezadociudad=$datosciudad['nombreciudad']."  ".substr($datosciudad['codigosapciudad'],2)." ".$datosciudad['nombreciudad']."  ".substr($datosciudad['codigosapciudad'],0,2);
$encabezadotelefono=$row_operacion_universidad['faxuniversidad']."  ".$row_operacion_universidad['telefonouniversidad'];
$encabezadoentidadnumero=$datosarp['nombreempresasalud'].":".esp(3)."028";
$encabezadoporcentajecotizacion="2.436%";
$encabezadosucursal="2";
$encabezadonovedades1="I R V V V S I L V V I";
$encabezadonovedades2="N E S T S L G M A C R";
$encabezadonovedades3="G T P E T N E A C T P";
$tmpespacionovedades="; ; ; ; ; ; ; ; ; ; ; ;";

$matrizencabezado[0][]=agregarceros(0,5);																		$longitudencabezado[]=5;		$titulosencabezado[]="";
$matrizencabezado[0][]="1";																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]="02";																					$longitudencabezado[]=2;		$titulosencabezado[]="";
$matrizencabezado[0][]=$datosarp['nombreempresasalud'];														$longitudencabezado[]=40;		$titulosencabezado[]="";
$matrizencabezado[0][]=agregarceros('800256161',9);															$longitudencabezado[]=9;		$titulosencabezado[]="";
$matrizencabezado[0][]='9';																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]=$row_operacion_universidad['nombreuniversidad'];										$longitudencabezado[]=40;		$titulosencabezado[]="";
$matrizencabezado[0][]='N';																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]=agregarceros(sacarnumeros($row_operacion_universidad['nituniversidad']),9);				$longitudencabezado[]=9;		$titulosencabezado[]="";
$matrizencabezado[0][]='6';																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]='G';																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]=$row_operacion_universidad['direccionuniversidad'];										$longitudencabezado[]=40;		$titulosencabezado[]="";
$matrizencabezado[0][]=$datosciudad['nombreciudad'];															$longitudencabezado[]=15;		$titulosencabezado[]="";
$matrizencabezado[0][]=agregarceros(1,4);																		$longitudencabezado[]=4;		$titulosencabezado[]="";
$matrizencabezado[0][]=$datosciudad['nombrecortodepartamento'];												$longitudencabezado[]=15;		$titulosencabezado[]="";
$matrizencabezado[0][]=agregarceros(11,2);																		$longitudencabezado[]=2;		$titulosencabezado[]="";
$matrizencabezado[0][]=$row_operacion_universidad['telefonouniversidad'];										$longitudencabezado[]=10;		$titulosencabezado[]="";
$matrizencabezado[0][]=$row_operacion_universidad['faxuniversidad'];											$longitudencabezado[]=10;		$titulosencabezado[]="";
$fechaperiodo=vector_fecha("01/".$_POST['mescierre']);
$matrizencabezado[0][]=$fechaperiodo["anio"].$fechaperiodo["mes"];												$longitudencabezado[]=6;		$titulosencabezado[]="";
$matrizencabezado[0][]="";																						$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]="";																						$longitudencabezado[]=6;		$titulosencabezado[]="";
$fechapago=vector_fecha($_POST['fechapago']);
$matrizencabezado[0][]=$fechapago["anio"].$fechapago["mes"].$fechapago["dia"];									$longitudencabezado[]=8;		$titulosencabezado[]="";
$matrizencabezado[0][]="";																						$longitudencabezado[]=10;		$titulosencabezado[]="";
$matrizencabezado[0][]="";																						$longitudencabezado[]=10;		$titulosencabezado[]="";
$matrizencabezado[0][]="S";																					$longitudencabezado[]=1;		$titulosencabezado[]="";
$matrizencabezado[0][]=esp(6)."0002";																			$longitudencabezado[]=10;		$titulosencabezado[]="";
$matrizencabezado[0][]=agregarceros($total,5);																	$longitudencabezado[]=5;		$titulosencabezado[]="";

$conlinea=1;
$conmat=0;
$filasespcolumna1=array(2,8);
$filastotalcolumna2=array(1,5,7,9);
for($i=0;$i<9;$i++){
if(validaagujapajar($filasespcolumna1,$conlinea))
$columna1="";
else
$columna1=agregarceros(0,10);

if(validaagujapajar($filastotalcolumna2,$conlinea))
$columna2=agregarceros($sumacotizacionarp,10);	
else
$columna2=agregarceros(0,10);
if ($conlinea!=3){

$matrizfinal[$conmat][]=agregarceros(3,4);																			$longitudfinal[]=4;			$titulosfinal[]="";
$matrizfinal[$conmat][]=$conlinea++;																					$longitudfinal[]=1;			$titulosfinal[]="";
$matrizfinal[$conmat][]="3";																							$longitudfinal[]=1;			$titulosfinal[]="";
$matrizfinal[$conmat][]=$columna1;																			$longitudfinal[]=10;		$titulosfinal[]="";

$matrizfinal[$conmat][]=$columna2;																		$longitudfinal[]=10;		$titulosfinal[]="";
$conmat++;
}
else
$conlinea++;

}

//$file="/var/documentosestudiantes/seguridadsocial/planotmp.txt";
//touch($file);
$encabezadoobj= new ArchivoPlano($file,$matrizencabezado,$longitudencabezado,$titulosencabezado);
$encabezadoobj->agregartitulos();
$encabezadoobj->crearlineas();
//for($i=0;$i<count($encabezadoobj->lineas);$i++)
//echo $encabezadoobj->lineas[0];

echo $encabezadoobj->lineas[0];

$archivoobj= new ArchivoPlano($file,$matriz,$longitudes,$titulos);
$archivoobj->agregartitulos();
$archivoobj->crearlineas();

	/*$apuntadorarchivo=fopen($file,"w+");
	fputs($apuntadorarchivo,$encabezadoobj->lineas[0]);
	for($i=0;$i<count($archivoobj->lineas);$i++)
		fputs($apuntadorarchivo,$archivoobj->lineas[$i]);
	fclose($apuntadorarchivo);
		
	$gestor = fopen($file, "rb");
	$contenido = fread($gestor, filesize($file));
	echo $contenido;
	fclose($gestor);*/


//$archivoobj->creararchivo();
//for($i=0;$i<count($archivoobj->lineastitulo);$i++)
//echo $archivoobj->lineastitulo[$i];
for($i=0;$i<(count($archivoobj->lineas)-1);$i++)
echo $archivoobj->lineas[$i];

$finalobj= new ArchivoPlano($file,$matrizfinal,$longitudfinal,$titulosfinal);
$finalobj->crearlineas();

for($i=0;$i<(count($finalobj->lineas)-1);$i++)
echo $finalobj->lineas[$i];
echo "999994";
echo chr(13)."\n";
?>
