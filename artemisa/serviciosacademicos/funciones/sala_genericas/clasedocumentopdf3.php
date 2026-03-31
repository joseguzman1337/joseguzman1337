<?php
class DocumentoPDF extends FPDF
{

var $DPDFarraydocumento;
var $DPDFtitulo;
var $DPDFconfilas;
var $DPDFconcolumnas;
var $DPDFcolumnas;
var $DPDFhtml;
var $B;
var $I;
var $U;
var $HREF;
var $anchofuente=2;
var $anchopuntostabla;
var $tamanofuente;
var $DPDFmargen;
var $saltolinea;
var $mostrarpiepagina;
var $mostrarpiefecha;
var $mostrarenumeracion;
var $iniciarpagina=1;
	var $nombrearchivo;
	var $matrizcampos;
	var $vectorlongitudes;
	var $apuntadorarchivo;
	var $encabezadoarchivo;
	var $lineas;
	//var $titulos;
	var $tituloprincipal;

function DocumentoPDF($tituloprincipal="",$orientation='P',$unit='mm',$format='Letter'){

$this->FPDF($orientation,$unit,$format);

//$html="<h1>PRUEBA 1 PDF HTML</h1><h2>PRUEBA 2 PDF HTML</h2><h3>PRUEBA 3 PDF HTML</h3>"; 
//$this->WriteHTML($html);
    $this->FPDF($orientation,$unit,$format);

    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->anchofuente=0;
    $this->tamanofuente=5;
    $this->saltolinea=4;
    $this->lineasxpagina=78;
	$this->mostrarpiefecha=0;
	$this->mostrarpiepagina=0;
   	$this->tituloprincipal=$tituloprincipal;
    	$this->mostrarenumeracion=0;
	//$this->DPDFmargen=10
	//$this->apuntadorarchivo=fopen($this->nombrearchivo,"w+");
	$this->matrizcampos=$matriz;
	$this->vectorlongitudes=$longitudes;	
	//$this->encabezadoarchivo=$encabezado;
	//$this->titulos=$titulos;
	$this->tituloprincipal=$tituloprincipal;
	 $this->SetLeftMargin("10");
    	$this->SetFont('Arial','',$this->tamanofuente);


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

//echo " Y=".($this->y-($linea*$h));
//echo " X=".($this->x+$x);
//echo "<br>";
	$this->SetXY($this->x+$x,$this->y-($linea*$h));
	$this->MultiCell($w,$h,$string,$marco,$align,$fill);
}

	function Footer()
	{

		$Y_ini=$this->GetY();
		$X_ini=$this->GetX();

		//Go to 1.5 cm from bottom
    		$this->SetY(-15);
		$this->SetX("0");
    		//Select Arial italic 8

    		$this->SetFont('Arial','I',$this->tamanofuente);
    		//Print centered page number
 		if($this->mostrarpiepagina){
   		$this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');

		$this->celda($this->w,$this->saltolinea,'Page '.$this->PageNo(),0,'C',1,0);
		}
		$this->SetY(-10);			
		if($this->mostrarpiefecha){
		$this->Cell(0,10,"Fecha de impresion:".date(" d/m/Y"),0,0,'C');
		$this->celda($this->w,$this->saltolinea,"Fecha de impresion:".date(" d/m/Y"),0,'C',1,0);
		}	
		$this->SetY($Y_ini);
		$this->SetX($X_ini);

	}
	function Header()
	{
    	//Select Arial bold 15
	$X_ini=$this->GetX();
    	$this->SetFont('Arial','B',$this->tamanofuente);
	//Move to the right
    	//$this->Cell(80);
    	//Framed title
	$this->SetX("0");
    	//$this->Cell($this->w,$this->saltolinea,$this->tituloprincipal,0,0,'C');
	$this->celda($this->w,$this->saltolinea,$this->tituloprincipal,0,'C',1,0);
    	//Line break
	

    	$this->Ln($this->saltolinea*2);
	$this->SetX($X_ini);
	}

	function forzarlongitud($campo,$longitud){
	$longitudcampo=strlen($campo);
	$longitudcampo>$longitud ? $nuevocampo=substr($campo,0,$longitud) : $nuevocampo=agregarespacios($campo,$longitud);
	return $nuevocampo;
	}
	
	function DibujarFilas($tituloprincipal){
	/*echo "vectorlongitudes<pre>";
	print_r($tpiehis->vectorlongitudes);
	echo "</pre>";*/
  		$this->SetLeftMargin($this->DPDFmargen);
    		$this->SetFont('Arial','',$this->tamanofuente);
		if($this->iniciarpagina)
		$this->AddPage();
		$nopage=1;
		for($i=0;$i<count($this->matrizcampos);$i++){
		if($i==0){
		//$this->Footer();
		//$nopage++;
		}
		if(($i%$this->lineasxpagina)==0){
			
			if($i>0){
			$this->SetLeftMargin($this->DPDFmargen);
 			$this->AddPage();
			}
			$this->DibujarTitulo($tituloprincipal,$nopage);
			$nopage++;

		}
		$longitudes=0;
			for($j=0;$j<count($this->matrizcampos[1]);$j++){
				$this->lineas[$i] .= "".$this->forzarlongitud($this->matrizcampos[$i][$j],$this->vectorlongitudes[$j]);
				$cadena=$this->matrizcampos[$i][$j];
				$this->celda($this->vectorlongitudes[$j],$this->saltolinea,trim($this->matrizcampos[$i][$j]),$longitudes,'L',1,1);
				$longitudes+=$this->vectorlongitudes[$j];				
			}
			$this->Ln($this->saltolinea);
			
		}
	}
	function agregartitulos(){
	
	$longitudes=0;
$this->SetLeftMargin($this->DPDFmargen);
			//$this->Ln(30);
//count($this->vectorlongitudes)
			for($j=0;$j<count($this->vectorlongitudes);$j++){
				$this->celda($this->vectorlongitudes[$j],$this->saltolinea,trim($this->DPDFcolumnas[$j]),$longitudes,'L',1,1);
				//$this->celda(10,5,"columna".$this->vectorlongitudes[$j],$longitudes,'L',1,1);
				//$this->celda(20,5,"columna",$longitudes,'L',1,0,0);
				$longitudes+=$this->vectorlongitudes[$j];
			}
			$this->Ln($this->saltolinea);
	}




function CargarArray($arrayprincipal){

$this->DPDFarraydocumento=$arrayprincipal;
$this->DPDFconfilas=count($arrayprincipal);

$i=0;
if($this->mostrarenumeracion){
$this->DPDFcolumnas[$i]="No";
$this->vectorlongitudes[$i]=3;
$i++;
}
foreach($arrayprincipal[0] as $columna=>$valor){
	
	$this->DPDFcolumnas[$i]=strtoupper($columna);
	$this->vectorlongitudes[$i]=0;

	$this->vectorlongitudes[$i]=$this->GetStringWidth(str_replace(" ","_",$this->DPDFcolumnas[$i]));
	$palabraslargas[$i]=$this->DPDFcolumnas[$i];

	$i++;	

}

$this->DPDFconcolumnas=count($this->DPDFcolumnas);



foreach($this->DPDFarraydocumento as $i=>$fila){
	if($this->mostrarenumeracion){
		$j=1;
		$this->matrizcampos[$i][]=$i+1;	
	}
	else{
		$j=0;
	}
	foreach($fila as $columna=>$valor){	
		$this->matrizcampos[$i][]=$valor;

		if($this->vectorlongitudes[$j] < $this->GetStringWidth(str_replace(" ","_",$valor))){
			$this->vectorlongitudes[$j]=$this->GetStringWidth(str_replace(" ","_",$valor));
			$palabraslargas[$j]=$valor;
		}
		$j++;
	}

}

foreach($this->vectorlongitudes as $j=>$valor){
	$this->vectorlongitudes[$j]=$this->vectorlongitudes[$j]+$this->anchofuente;
}

foreach($this->vectorlongitudes as $j=>$valor){
	$sumaancho+=$valor;
}

$this->anchopuntostabla=$sumaancho;
$this->DPDFmargen=($this->w/2)-($this->anchopuntostabla/2);

}
function DibujarTitulo($tituloprincipal,$nopage){
	
	$this->DPDFtitulo=$tituloprincipal;
 	$this->SetFont('Arial','B',$this->tamanofuente);
	$Y_ini=$this->GetY();
	$X_ini=$this->GetX();
	$this->SetLeftMargin($this->DPDFmargen);
	$this->agregartitulos();	
	$this->SetFont('Arial','',$this->tamanofuente);
}

function CerrarDocumento($archivo="archivo.pdf"){
//echo $this->DPDFhtml;
//$this->WriteHTML($this->DPDFhtml);
$this->Output($archivo,"I");
}

}
?>