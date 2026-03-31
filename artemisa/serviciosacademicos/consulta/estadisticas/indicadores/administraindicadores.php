<?php

class AdministracionIndicadores{
var $codigomodalidadacademicasic;
var $codigocarrera;
var $codigofacultad;
var $objcacheindicadores;
var $objindicadores;
var $arraytablaprincipal;
var $arraytablaprincipalsesion;
var $indicecolumnas;
var $indicefilas;
var $objetobase;
var $objvistaestadistico;
var $objtitulos;
var $datoscarrera;

function AdministracionIndicadores($objindicadores,$objcacheindicadores,$objetobase){
$this->objcacheindicadores=$objcacheindicadores;
$this->objindicadores=$objindicadores;
$this->indicecolumnas=0;
$this->indicefilas=0;
$this->anchocelda="120";
$this->objetobase=$objetobase;

$this->objvistaestadistico=new VistaTablaEstadistico($this->anchocelda,"70","class='estilocelda' ","","cellpadding='0' cellspacing='0' ");
$this->datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION["codigofacultad"],"","",0);
//exit();
$this->objtitulos=new TitulosIndicadores($this->datoscarrera);


//$this->objvistaestadistico=$objvistaestadistico;
}
function setRangoPeriodo($periodoinicial,$periodofinal)
{

$resrangoperiodo=$this->objetobase->recuperar_resultado_tabla("periodo","codigoperiodo",$periodoinicial," or codigoperiodo between ".$periodoinicial." and ".$periodofinal."","",0);
while($row = $resrangoperiodo->fetchRow())
{
	$this->periodos[]=$row["codigoperiodo"];
}

//$this->periodos[]="TOTAL";

/*
echo "<H1>PERIODOS</H1><pre>";
print_r($this->periodos);
echo "</pre>";*/
}
function getAnchoTablaPrincipal(){
return $this->anchocelda*count($this->periodos);

}

function complementaArrayVertical($arrayvertical,$titulo=""){
	if(is_array($arrayvertical)){
	foreach($arrayvertical as $llave=>$detalleArray){
		
		if($llave=="funcion")
		{
			
			$tmpindicefilas=$this->indicefilas;
			//$this->indicefilas++;
			unset($tmpvalorllave);
			foreach($this->periodos as  $i => $periodo ){
				$this->objcacheindicadores->codigoperiodo=$periodo;
				$arraydatos=$this->objcacheindicadores->consultaCacheIndicador($titulo);
				$this->indicefilas=$tmpindicefilas;
				/*echo "<pre>";
					print_r($arraydatos);
				echo "</pre>";*/
				if(is_array($arraydatos)){
					if(is_array($tmpvalorllave))
					foreach($tmpvalorllave as $llave=>$valor)
						$tmpvalorllave[$llave]="0";
					$convalorllave=1;
					foreach($arraydatos["total"][$titulo] as $llave => $valor){
						//if(!is_array($valor))
						//echo "<h1>ENTRO</h1>";
						//$arrayfin["<font  color='White'>".$this->indicefilas."] ".$llave]["fin"]=0;	
						$tmpvalorllave[$llave]=$valor;
						//$this->indicefilas++;	
					//"<tr><td>&nbsp;</td><td>".$llave."</td><td>".$valor."</td></tr>";
					}

					foreach($tmpvalorllave as $llave=>$valor)
					{	

						$_SESSION["titulosindicador"][$this->indicefilas]=quitartilde($titulo." - ".$llave);

						$llave="<a href='Javascript:mostrargrafica(".$this->indicefilas.");'>".ucwords($llave)."</a>";
						$arrayfin["<font  color='White'>".$this->indicefilas."</font> ".$llave]["fin"]=0;


						$this->arraytablaprincipal["<font  color='White'>".$this->indicefilas."</font> ".$llave][$periodo]["valor"]=$valor;

						$this->arraytablaprincipalsesion[$this->indicefilas][$periodo]=$valor;
						$this->indicefilas+=$convalorllave;	
		
						$convalorllave++;
					}
				}
				else{
					
					if(!is_array($detalleArray)){
						//echo "<h1>ENTRO 2</h1>";
						$this->objindicadores->codigoperiodo=$periodo;
						$arraydatos=$this->objindicadores->$detalleArray($titulo);
						/*echo "<br>$titulo<pre>";
						print_r($arraydatos);
						echo "</pre>";*/
						//$this->indicefilas=$tmpindicefilas;
						if(is_array($tmpvalorllave))
						foreach($tmpvalorllave as $llave=>$valor)
							$tmpvalorllave[$llave]="0";

						$this->objcacheindicadores->codigoperiodo=$periodo;
						$this->objcacheindicadores->insertarCacheIndicador($arraydatos);
						if(is_array($arraydatos))
						foreach($arraydatos["total"][$titulo] as $llave => $valor){
							//if(!is_array($valor))
								$tmpvalorllave[$llave]=$valor;

								//echo "<tr><td>&nbsp;</td><td>".$llave."</td><td>".$valor."</td></tr>";
						}
						$convalorllave=1;
						if(is_array($tmpvalorllave))
						foreach($tmpvalorllave as $llave=>$valor)
						{	

							$_SESSION["titulosindicador"][$this->indicefilas]=quitartilde($titulo." - ".$llave);

							$llave="<a href='Javascript:mostrargrafica(".$this->indicefilas.");'>".ucwords($llave)."</a>";
	
							$arrayfin["<font  color='White'>".$this->indicefilas."</font> ".$llave]["fin"]=0;

							$this->arraytablaprincipal["<font  color='White'>".$this->indicefilas."</font> ".$llave][$periodo]["valor"]=$valor;
							$this->arraytablaprincipalsesion[$this->indicefilas][$periodo]=$valor;
							$this->indicefilas+=$convalorllave;		
							$convalorllave++;
						}
						
					}
				}
			}
			
			return $arrayfin;
		}
		else
		{

			//echo "<br>NO FUNCION llave=".$llave." detalle=Array";
			if($llave=="fin"){
				$this->indicefilas++;
				$_SESSION["titulosindicador"][$this->indicefilas]=htmlspecialchars($titulo." - ".$llave);

				$llave="<a href='Javascript:mostrargrafica(".$this->indicefilas.");'>Indicador</a>";

				$arrayComplemento["<font  color='White'>".$this->indicefilas."</font> ".$llave]["fin"]="0";
				//$this->indicefilas=0;
				foreach($this->periodos as  $i => $periodo ){

					$this->arraytablaprincipal["<font  color='White'>".$this->indicefilas."</font> ".$llave][$periodo]["valor"]=0;
					$this->arraytablaprincipalsesion[$this->indicefilas][$periodo]=$valor;
					$this->indicecolumnas++;
					
				}
			}
			else
			{
				$arrayComplemento[$llave]=$this->complementaArrayVertical($detalleArray,$llave);
			}
			
		}
	}
		$_SESSION["arraytablaprincipal"]=$this->arraytablaprincipalsesion;
		/*echo "indicefila<pre>";
			print_r($_SESSION["titulosindicador"]);
		echo "</pre>";*/
		return $arrayComplemento;
	}
	else{
		/*echo "indicefila<pre>";
			print_r($_SESSION["arraytablaprincipal"]);
		echo "</pre>";*/
		$_SESSION["arraytablaprincipal"]=$this->arraytablaprincipalsesion;
		return "0";
	}
}

function imprimirTitulosVertical($titulos,$postseleccion){

$arreglovertical=$this->objtitulos->$titulos();
//echo "<pre>".print_r($postseleccion)."</pre>";
$arreglovertical=$this->objtitulos->filtraTitulos($postseleccion);
$arreglovertical2=$this->complementaArrayVertical($arreglovertical["titulovertical"],"");
/*
echo "arreglovertical<pre>";
print_r($arreglovertical2);
echo "</pre>";
*/
$objvistaestadistico->muestratotales=0;
		$this->objvistaestadistico->setArrayVertical($arreglovertical2);
		/* $_SESSION["estudianteestadisticosesion"]["titulovertical"]=$objvistaestadistico->tablaVerticalEx();
		echo $_SESSION["estudianteestadisticosesion"]["titulovertical"];*/
		$_SESSION["estadisticosesion"]["titulovertical"]= $this->objvistaestadistico->tablaVerticalEx();
		echo $_SESSION["estadisticosesion"]["titulovertical"];
}

function imprimirAreaPrincipal(){
/*echo "arraytablaprincipal<pre>";
print_r($this->arraytablaprincipal);
echo "</pre>";*/
	$this->objvistaestadistico->setArrayAreaPrincipal($this->arraytablaprincipal);
	$_SESSION["estadisticosesion"]["areaprincipal"]=$this->objvistaestadistico->tablaAreaPrincipalEx();
	echo $_SESSION["estadisticosesion"]["areaprincipal"];
}
function imprimirAreaHorizontal(){
	for($i=0;$i<count($this->periodos);$i++)
	{
		$arrayhorizontaltmp[$this->periodos[$i]]="1";
	}
	$arrayhorizontall["RANGO DE PERIODOS"]=$arrayhorizontaltmp;
	$this->objvistaestadistico->setArrayHorizontal($arrayhorizontall);
	$_SESSION["estadisticosesion"]["titulohorizontal"]=$this->objvistaestadistico->tablaHorizontalEx("",1);
	echo $_SESSION["estadisticosesion"]["titulohorizontal"];
}

function imprimirHorizontalVertical($titulos){
/*echo "arraytablaprincipal<pre>";
print_r($this->arraytablaprincipal);
echo "</pre>";*/

	$arraytitulohtmp["Objetivo Estratégico"]=0;
	$arraytitulohtmp["Indicador"]=0;
	$arraytitulohtmp["Detalle Indicador"]=0;
	$arreglovertical=$this->objtitulos->$titulos();
	$arraytituloh["<b>".$arreglovertical["titulo"]."</b>"]=$arraytitulohtmp;

	$this->objvistaestadistico->setArrayHorizontal($arraytituloh);
	$_SESSION["estadisticosesion"]["titulohorizontalvertical"]=$this->objvistaestadistico->tablaHorizontalEx("",1);
	echo $_SESSION["estadisticosesion"]["titulohorizontalvertical"];
}
}
?>