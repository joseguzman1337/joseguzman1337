<?php
$rutaado=("../../funciones/adodb/");
//require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
//require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once("../../funciones/sala_genericas/DatosGenerales.php");
require_once("funciones/FuncionesAportes.php");
define('FPDF_FONTPATH','../../funciones/clases/fpdf/font/');
require('../../funciones/clases/fpdf/fpdf.php');
ini_set('max_execution_time','6000');

class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;
	var $nombrearchivo;
	var $matrizcampos;
	var $vectorlongitudes;
	var $apuntadorarchivo;
	var $encabezadoarchivo;
	var $lineas;
	var $titulos;
	var $tituloprincipal;


function PDF($orientation='P',$unit='mm',$format='A4',$matriz,$longitudes,$titulos,$tituloprincipal)
{
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
	//$this->apuntadorarchivo=fopen($this->nombrearchivo,"w+");
	$this->matrizcampos=$matriz;
	$this->vectorlongitudes=$longitudes;	
	$this->encabezadoarchivo=$encabezado;
	$this->titulos=$titulos;
	$this->tituloprincipal=$tituloprincipal;

}

function WriteHTML($html)
{
    //Intérprete de HTML
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Etiqueta
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extraer atributos
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{
    //Etiqueta de apertura
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    //Etiqueta de cierre
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}

function SetStyle($tag,$enable)
{
    //Modificar estilo y escoger la fuente correspondiente
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
    //Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
function celda($w,$h,$string,$x,$align='C',$linea=2,$marco=1,$fill=0)
{
	$this->SetXY($this->x+$x,$this->y-($linea*$h));
	$this->MultiCell($w,$h,$string,$marco,$align,$fill);
}

	function forzarlongitud($campo,$longitud){
	$longitudcampo=strlen($campo);
	$longitudcampo>$longitud ? $nuevocampo=substr($campo,0,$longitud) : $nuevocampo=agregarespacios($campo,$longitud);
	return $nuevocampo;
	}
	
	function crearlineas(){
		for($i=0;$i<count($this->matrizcampos);$i++){
		if($i==0){
		$this->SetFont('Arial','B',7);
		$this->celda(200,5,$this->tituloprincipal,0,'C',1,0);
		$this->SetFont('Arial','',6);
		}
		if(($i%35)==0){
		 if($i>0)
 			$this->AddPage();
			
			$this->Ln(5);
			$this->celda(200,5,"Fecha de impresion:".date(" d/m/Y"),0,'L',1,0);
			$this->Ln(5);
			$this->agregartitulos();
		}
		$longitudes=0;
			for($j=0;$j<count($this->matrizcampos[1]);$j++){
				$this->lineas[$i] .= "".$this->forzarlongitud($this->matrizcampos[$i][$j],$this->vectorlongitudes[$j]);
				$cadena=$this->matrizcampos[$i][$j];
				$this->celda($this->vectorlongitudes[$j]*4,5,trim($this->matrizcampos[$i][$j]),$longitudes,'L',1,1);
				$longitudes+=$this->vectorlongitudes[$j]*4;				
			}
			$this->Ln(5);

		}
	}
	function agregartitulos(){
	$this->SetLeftMargin('20');
	$longitudes=0;
			for($j=0;$j<count($this->matrizcampos[1]);$j++){
				$this->celda($this->vectorlongitudes[$j]*4,5,trim($this->titulos[$j]),$longitudes,'L',1,1);
				$longitudes+=$this->vectorlongitudes[$j]*4;				
			}
			$this->Ln(5);
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
carrera c, modalidadacademica ma, documento d, ordenpago op 
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
if(isset($_POST['codigomodalidadacademica'])){
$query=querylistadocierre($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo'],$_POST['codigomodalidadacademica'],0,"15/".$_POST['mescierre']);
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
$encabezadonovedades1="I R T T T T V V V S I L V A V I";
$encabezadonovedades2="N E D A D A S T S L G M A V C R";
$encabezadonovedades3="G T E E P P P E T N E A C P T P";
$tmpespacionovedades="; ; ; ; ; ; ; ; ; ; ; ;";
//ING RET TDE TAE TDP TAP VSP VTE VST SLN IGE LMA VAC AVP VCT IRP 
$total=0;
$coneps=0;;
do
{
		$mescierre=$_POST['mescierre'];
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
		if(!EncuentraFilaVector($vectoreps,$row_operacion['Codigo_EPS'])){
			$vectoreps[$coneps]=$row_operacion['Codigo_EPS'];
			$subtotalconteoalumnoseps[$row_operacion['Codigo_EPS']]=0;
			$subtotaleps[$row_operacion['Codigo_EPS']]=0;
			 $nombreseps[$row_operacion['Codigo_EPS']]=$row_operacion['EPS'];
			//echo "<br>";
			$coneps++;
		}
		$datos_ibc_eps=ibc_eps($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd);
		$datos_ibc_arp=ibc_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd);
			
		$row_operacion['Dias_EPS']=$datos_ibc_eps['dias_eps'];
		//$row_operacion['Codigo_Traslado_EPS']=;
		//$lapso=lapso_resultado_novedad($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'SLN');
	
		$row_operacion['Dias_ARP']=$datos_ibc_arp['dias_arp'];
		//dias_arp($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$datoscentrotrabajo=centrotrabajo($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd);
		$row_operacion['Salario_basico']=$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']."";
		$row_operacion['IBC_EPS']=$datos_ibc_eps['ibc_eps']."";
		$row_operacion['IBC_ARP']=$datos_ibc_arp['ibc_arp']."";
		$row_operacion['Tarifa_Aportes']=tarifa_aportes_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['Cotizacion_EPS']=round(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']),-2);
		$row_operacion['Cotizacion_EPS']=roundcienss(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']),-2);
		$row_operacion['Tarifa_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['porcentajecotizacionarp']."";
		$row_operacion['Codigo_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['codigocentrotrabajoarp']."";
		//$row_operacion['Cotizacion_ARP']=round(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']),-2)."";
		$row_operacion['Cotizacion_ARP']=roundcienss(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']),-2)."";
		
		$subtotaleps[$row_operacion['Codigo_EPS']]+=$row_operacion['Cotizacion_EPS'];
		$subtotalconteoalumnoseps[$row_operacion['Codigo_EPS']]++;
		
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
	//$matriz[$total][]=$total-1; 								$longitudes[]=2;		$titulos[]="No"; 

	$sumacotizacioneps+=$row_operacion['Cotizacion_EPS'];
	$sumacotizacionarp+=$row_operacion['Cotizacion_ARP'];
	$sumaibceps+=$row_operacion['IBC_EPS'];
	$sumaibcarp+=$row_operacion['IBC_ARP'];

	$total++;
		}
	//}
}
while ($row_operacion=$operacion->fetchRow());

//$total
//$sumacotizacionarp
$file="plano.txt";

for($i=0;$i<count($vectoreps);$i++){
	$matriz[$i][]=$nombreseps[$vectoreps[$i]]; 								$longitudes[]=10;		$titulos[]="NOMBRE EPS"; 
	$matriz[$i][]=$vectoreps[$i]; 												$longitudes[]=5;		$titulos[]="CODIGO EPS"; 
	$matriz[$i][]=$subtotaleps[$vectoreps[$i]]; 								$longitudes[]=10;		$titulos[]="TOTAL COTIZACION"; 
	$matriz[$i][]=$subtotalconteoalumnoseps[$vectoreps[$i]]; 					$longitudes[]=15;		$titulos[]="TOTAL ESTUDIANTES"; 
	$totaleps+=$subtotaleps[$vectoreps[$i]];
	$totalalumnos+=$subtotalconteoalumnoseps[$vectoreps[$i]];
	//echo $nombreseps[$vectoreps[$i]]." ".$vectoreps[$i]." ".$subtotaleps[$vectoreps[$i]]." ".$subtotalconteoalumnoseps[$vectoreps[$i]]."<br>";
}

$matriz[$i][]="Totales";
$matriz[$i][]="";
$matriz[$i][]=$totaleps;
$matriz[$i][]=$totalalumnos;



/*for($i=0;$i<=24;$i++){
	$matriz[$total][]="";
}
			
$matriz[$total][]="Totales";
$matriz[$total][]=$sumaibceps;
$matriz[$total][]=$sumaibcarp;
$matriz[$total][]="";
$matriz[$total][]=$sumacotizacioneps;
$matriz[$total][]="";
$matriz[$total][]="";
$matriz[$total][]=$sumacotizacionarp;
*/
//$matriz[$total][]="";

//$archivoobj->agregartitulos();
//$archivoobj->lineas;

//$hoja[0]=215;
//$hoja[1]=90;
$meses=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");

$hoja="Letter";
$mescierrevector=vector_fecha("01/".$mescierre);
$tituloprincipal="UNIVERSIDAD EL BOSQUE\nTotales Seguridad Social Estudiantes de Postgrado por EPS\n ".$meses[($mescierrevector["mes"]-1)]." ".$mescierrevector["anio"];
$pdf=new PDF('P','mm',$hoja,$matriz,$longitudes,$titulos,$tituloprincipal);
$pdf->AddPage();
$pdf->SetLeftMargin('20');
$pdf->SetFont('Arial','',6);



$nombresarp[$datosempresaarp["Codigo_ARP"]]=$datosempresaarp["nombreempresasalud"];
$subtotalarp[$datosempresaarp["Codigo_ARP"]]=$sumacotizacionarp;
$subtotalconteoalumnosarp[$datosempresaarp["Codigo_ARP"]]=$total;
$vectorarp[]=$datosempresaarp["Codigo_ARP"];
unset($longitudes);
unset($titulos);
for($i=0;$i<count($vectorarp);$i++){
	$matrizarp[$i][]=$nombresarp[$vectorarp[$i]]; 								$longitudes[]=10;		$titulos[]="NOMBRE ARP"; 
	$matrizarp[$i][]=$vectorarp[$i]; 												$longitudes[]=5;		$titulos[]="CODIGO ARP"; 
	$matrizarp[$i][]=$subtotalarp[$vectorarp[$i]]; 								$longitudes[]=10;		$titulos[]="TOTAL COTIZACION"; 
	$matrizarp[$i][]=$subtotalconteoalumnosarp[$vectorarp[$i]]; 					$longitudes[]=15;		$titulos[]="TOTAL ESTUDIANTES"; 
	$totalarp+=$subtotalarp[$vectorarp[$i]];
	$totalalumnosarp+=$subtotalconteoalumnosarp[$vectorarp[$i]];

}
$matrizarp[$i][]="Totales";
$matrizarp[$i][]="";
$matrizarp[$i][]=$totalarp;
$matrizarp[$i][]=$totalalumnosarp;

//$pdf->FPDF('L','mm',$hoja);


//Primera página

//$archivoobj= new ArchivoPlano($file,$matriz,$longitudes,$titulos);
//$archivoobj->agregartitulos();
//$pdf->agregartitulos();
$pdf->crearlineas();
$tituloprincipal="\n\n\nTotales Seguridad Social Estudiantes de Postgrado ARP\n ".$meses[($mescierrevector["mes"]-1)]." ".$mescierrevector["anio"];

	$pdf->matrizcampos=$matrizarp;
	$pdf->vectorlongitudes=$longitudes;	
	$pdf->encabezadoarchivo=$encabezado;
	$pdf->titulos=$titulos;
	$pdf->tituloprincipal=$tituloprincipal;
$pdf->crearlineas();

$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes=$meses[date("n")];
//$dia=strftime("Dado en Bucaramanga, a los %d dias del mes de $mes de %Y");

	$pdf->celda(170,4,"$dia",0,'L',1,0);
	$pdf->Ln(20);

$pdf->SetLeftMargin('20');
	
	$pdf->celda(100,4,"____________________________________________________".
	"\nREVISA:",0,'L',1,0);
	$pdf->celda(100,4,"____________________________________________________".
	"\nAUTORIZA:",100,'L',1,0);

	//for($i=0;$i<count($archivoobj->lineas);$i++){
	//$pdf->celda(400,5,$archivoobj->lineas[$i],0,'C',1,0);
	//$pdf->celda(400,5,"Haber si imprime",0,'L',1,0);
	//$pdf->Ln(5);
	//}
	//$pdf->MultiCell(200,5,"Haber si imprime",0,'C',1);
	//Output([string name [, string dest]])
	//$archivoremoto="aportespostgrado".formato_fecha_mysql("01/".$mescierre);
	$pdf->Output();
//$archivoobj->creararchivo();
}
?>


