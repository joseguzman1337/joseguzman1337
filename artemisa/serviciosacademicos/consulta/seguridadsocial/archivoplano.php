<?php
$rutaado=("../../funciones/adodb/");
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
error_reporting(0);

		$strType = 'text/plain';
		$strName = "aportespostgrado".formato_fecha_mysql("01/".$_POST['mescierre']).".txt";
		header("Content-Type: $strType charset=ASCII");
		header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Content-Type: public");

		//header('Content-Disposition: inline; filename=$strName\r\n\r\n');

		header("Cache-Control: no-cache, must-revalidate"); 
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
	$this->apuntadorarchivo=fopen($this->nombrearchivo,"w+");
	$this->matrizcampos=$matriz;
	$this->vectorlongitudes=$longitudes;	
	$this->encabezadoarchivo=$encabezado;
	$this->titulos=$tituloarchivo;
	$this->lineastitulo;
	}
	function crearlineas(){
		for($i=0;$i<=count($this->matrizcampos);$i++){
			for($j=0;$j<count($this->matrizcampos[1]);$j++)
				 $this->lineas[$i] .=  "".$this->forzarlongitud($this->matrizcampos[$i][$j],$this->vectorlongitudes[$j]);
		  	$this->lineas[$i] .= chr(13)."\n";
		}
		
	}
	function forzarlongitud($campo,$longitud){
	$longitudcampo=strlen($campo);
	$longitudcampo>$longitud ? $nuevocampo=substr($campo,0,$longitud) : $nuevocampo=agregarespacios($campo,$longitud);
	return $nuevocampo;
	}
	function agregartitulos(){
			for($j=0;$j<count($this->matrizcampos[0]);$j++)
				 $this->lineastitulo .=  "".$this->forzarlongitud($this->titulos[$j],$this->vectorlongitudes[$j]);
		  	$this->lineastitulo .=  chr(13)."\n";
			//fputs($this->apuntadorarchivo,$lineastitulo);
	}
	function creararchivo(){
		//fputs($this->apuntadorarchivo,$this->encabezadoarchivo);
	for($i=0;$i<count($this->lineas);$i++)
		fputs($this->apuntadorarchivo,$this->lineas[$i]);
	fclose($this->apuntadorarchivo);
	}
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
 $query=querylistadocierre($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo'],$_POST['codigomodalidadacademica'],0,"15/".$_POST['mescierre']);
//echo "QUERY=".$query;
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
$datos_bd=new BaseDeDatosGeneral($sala);
//$formulario=new formulariobaseestudiante($salad,'form2','post','','true');

$datosciudad=$datos_bd->recuperar_datos_tabla('ciudad','idciudad',$row_operacion_universidad['idciudad']);
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
$total=0;
$letras=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","V","W","X","Y","Z");
do
{
		$mescierre=$_POST['mescierre'];

//echo "IDESTUDIANTEGENERAL=".$row_operacion['idestudiantegeneral']."<BR>";
/*		$condicion=" and c.codigocarrera=e.codigocarrera
		group by idestudiantegeneral";
		$datos_estudiante=$datos_bd->recuperar_datos_tabla("estudiante e, carreracentrotrabajoarp c","idestudiantegeneral",$row_operacion['idestudiantegeneral'],$condicion,', max(codigoestudiante) numeroestudiante');*/
		$queryestudiante="select  max(codigoestudiante) codigoestudiante 
		from estudiante e, carreracentrotrabajoarp c 
		where idestudiantegeneral= '".$row_operacion['idestudiantegeneral']."' and
		c.codigocarrera=e.codigocarrera group by idestudiantegeneral";
		$operacionestudiante=$datos_bd->conexion->query($queryestudiante);
		$datos_estudiante=$operacionestudiante->fetchRow();


	if(validar_estudiante_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd,$_POST['pagoeps'],$_POST['pagoarp'],$_POST['ingresado'])){
		

		$datosnovedad=eps_mes($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		$datosempresaarp=recuperar_empresaarp($datos_bd,$row_operacion['idestudiantegeneral'],$mescierre,0);
		$row_operacion['Codigo_ARP']=$datosempresaarp['codigoempresasalud'];
		$row_operacion['EPS']=$datosnovedad['nombreempresasalud']."";
		$row_operacion['Codigo_EPS']=$datosnovedad['codigoempresasalud']."";
		if(existe_tae_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd)){
		$datosnovedadtae=eps_tae($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		$row_operacion['EPS_Traslado']=$datosnovedadtae['nombreempresasalud']."";
		$row_operacion['Codigo_EPS_Traslado']=$datosnovedadtae['codigoempresasalud']."";
		}
		else{
		$row_operacion['EPS_Traslado']="";
		$row_operacion['Codigo_EPS_Traslado']="";
		}
		$datos_ibc_eps=ibc_eps($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd);
		$datos_ibc_arp=ibc_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd);
			
		$row_operacion['Dias_EPS']=$datos_ibc_eps['dias_eps'];
		//$row_operacion['Codigo_Traslado_EPS']=;
		//$lapso=lapso_resultado_novedad($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'SLN');
	
		$row_operacion['Dias_ARP']=$datos_ibc_arp['dias_arp'];
		//dias_arp($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$datoscentrotrabajo=centrotrabajo($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd);
		//$row_operacion['Salario_basico']=round((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']),-3)."";
		$row_operacion['Salario_basico']=roundmilss((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']))."";		
		$row_operacion['IBC_EPS']=$datos_ibc_eps['ibc_eps']."";
		$row_operacion['IBC_ARP']=$datos_ibc_arp['ibc_arp']."";
		$row_operacion['Tarifa_Aportes']=tarifa_aportes_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['Cotizacion_EPS']=round(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']),-2);
		$row_operacion['Cotizacion_EPS']=roundcienss(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']));		
		$row_operacion['Tarifa_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['porcentajecotizacionarp']."";
		$row_operacion['Codigo_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['codigocentrotrabajoarp']."";
		//$row_operacion['Cotizacion_ARP']=round(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']),-2)."";
		$row_operacion['Cotizacion_ARP']=roundcienss(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']))."";		
		$ing=" ";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'ING'))
		$ing="X";
		$row_operacion['ING']=$ing;
	
		$ing=" ";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'RET'))
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
			$celda=$datos_ibc_arp['dias_irp'];
			else
			$celda="X";
		$row_operacion[$nombrenovedad[$i]]=$celda;
		}

	//if(validar_estudiante_arp($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd)){
	$array_interno[]=$row_operacion;
	$matriz[$total][]=$row_operacion['Tipo']; 								$longitudes[]=2;		$titulos[]="TD"; 
 	$matriz[$total][]=$row_operacion['numerodocumento']; 									$longitudes[]=16;		$titulos[]="CODIGO";
 	//$matriz[$total][]=agregarceros($row_operacion['codigoestudiante'],8); 		$longitudes[]=10;		$titulos[]="Codigo";
	$matriz[$total][]=21;																	$longitudes[]=2;		$titulos[]="TC";
	$apellidos=quitartilde(strtoupper($row_operacion['apellidos']));
	$nombres=quitartilde(strtoupper($row_operacion['nombres']));
	$cuentapalabrasapellidos=cuentapalabras($apellidos);
	$matriz[$total][]=sacarpalabras($apellidos,0,$cuentapalabrasapellidos-2);							$longitudes[]=20;		$titulos[]="AP1";
	$matriz[$total][]=sacarpalabras($apellidos,$cuentapalabrasapellidos-1,$cuentapalabrasapellidos);								$longitudes[]=30;		$titulos[]="AP2";
	$matriz[$total][]=sacarpalabras($nombres,0,0);								$longitudes[]=20;		$titulos[]="NOM1";
	$matriz[$total][]=sacarpalabras($nombres,1);								$longitudes[]=30;		$titulos[]="NOM2";
	
	$nombrenovedad=vector_nombres_cortos_novedad(100,$sala)	;											
	for($i=0;$i<count($nombrenovedad);$i++){	
	$matriz[$total][]=$row_operacion[$nombrenovedad[$i]]."";								$longitudes[]=1;		$titulos[]=$letras[$i];
	}
	$j=$i;
	$nombrenovedad=vector_nombres_cortos_novedad(300,$sala)	;
	for($i=0;$i<count($nombrenovedad);$i++){
	$nombrenovedad[$i]=='IRP'?$esp=" ":$esp="";
	$nombrenovedad[$i]=='IRP'?$lg=2:$lg=1;		
	$matriz[$total][]=$row_operacion[$nombrenovedad[$i]]."$esp";							$longitudes[]=$lg;		$titulos[]=$letras[$i+$j];
	}

	//$matriz[$total][]=$row_operacion['apellidos'];						$longitudes[]=30;
	
	$matriz[$total][]=$row_operacion['Codigo_EPS'];											$longitudes[]=6;		$titulos[]="NoEPS";
	$matriz[$total][]=$row_operacion['Codigo_EPS_Traslado'];								$longitudes[]=6;		$titulos[]="NoEPST";
	$matriz[$total][]=agregarceros($row_operacion['Dias_EPS'],2);							$longitudes[]=2;		$titulos[]="DE";
	$matriz[$total][]=agregarceros($row_operacion['Dias_ARP'],2);							$longitudes[]=2;		$titulos[]="DA";
	$matriz[$total][]=$row_operacion['Salario_basico'];										$longitudes[]=9;		$titulos[]="Salario";
	$matriz[$total][]=$row_operacion['IBC_EPS'];											$longitudes[]=9;		$titulos[]="IBC_EPS";
	$matriz[$total][]=$row_operacion['IBC_ARP'];											$longitudes[]=9;		$titulos[]="IBC_ARP";
	$matriz[$total][]=agregarcerosderecha($row_operacion['Tarifa_Aportes'],7);				$longitudes[]=7;		$titulos[]="Tarifa";
	$matriz[$total][]=$row_operacion['Cotizacion_EPS'];										$longitudes[]=9;		$titulos[]="EPS";
	$matriz[$total][]=agregarcerosderecha($row_operacion['Tarifa_Centro_Trabajo'],9);		$longitudes[]=9;		$titulos[]="TCT";
	$matriz[$total][]=$row_operacion['Codigo_Centro_Trabajo'];								$longitudes[]=9;		$titulos[]="CCT";
	$matriz[$total][]=$row_operacion['Cotizacion_ARP'];										$longitudes[]=9;		$titulos[]="ARP";
	$matriz[$total][]=$row_operacion['Codigo_ARP'];											$longitudes[]=6;		$titulos[]="NFD_A";
	$matriz[$total][]=0;																	$longitudes[]=1;		$titulos[]="P";

//	$matriz[$total][]=";";														$longitudes[]=1;		$titulos[]="Novedades";	
	
	//$matriz[$total][]=substr(strtoupper($tmpespacionovedades),0,26);			$longitudes[]=6;		$titulos[]="Novedades";
	//$matriz[$total][]=substr(strtoupper($tmpespacionovedades),0,26);
	$total++;
		}
	//}
}
while ($row_operacion=$operacion->fetchRow());

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

//$file="/var/documentosestudiantes/seguridadsocial/planotmp.txt";
//touch($file);
$archivoobj= new ArchivoPlano($file,$matriz,$longitudes,$titulos);
$archivoobj->agregartitulos();
$archivoobj->crearlineas();
//$archivoobj->creararchivo();
print_r($archivoobj->lineastitulo);
for($i=0;$i<(count($archivoobj->lineastitulo)-1);$i++)
echo $archivoobj->lineastitulo[$i];

for($i=0;$i<count($archivoobj->lineas);$i++)
echo $archivoobj->lineas[$i];



?>

