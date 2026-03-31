<?php
class MenuSic{

var $objetobase;
var $formulario;
var $arbolsic;
var $tmparrayramahijos;
var $arrayitempadres;
var $codigodocente=0;

function MenuSic($objetobase,$formulario){

$this->objetobase=$objetobase;
$this->formulario=$formulario;

}
function setCodigoEstudiante($codigoestudiante){
if(isset($codigoestudiante)&&trim($codigoestudiante)!='')
$this->codigoestudiante=$codigoestudiante;

}
function consultaprimernivelsic(){

$tabla="formulario f";
$nombreidtabla="f.codigoestado";
$idtabla="100";
$condicion=" and (idformulario = ''  or idformulario = '1' or idformulario is null)	and f.codigoestado like '1%'
	order by f.pesoformulario
	 ";

$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);

while($row=$resultado->fetchRow()){
$this->arbolsic[$row["idformulario"]]=$row;
$this->arbolsic[$row["idformulario"]]["nivelitem"]="0";

$this->arbolsic[$row["idformulario"]]["grupo"]=$this->recursivaarmaarbolarray($row["idformulario"],0);

}

}

function recursivaarmaarbolarray($iditemsicpadre,$nivel){

$tabla="formulario f";
$nombreidtabla="f.codigoestado";
$idtabla="100";
$condiciontipousuario="and f.codigotipousuario = '600'";
if(isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])!='')
$condiciontipousuario="and f.codigotipousuario in ('600','700')";

$condicion=" and idformulariopadre = '".$iditemsicpadre."' 
	and f.codigoestado like '1%'
	".$condiciontipousuario."
	and idformulario <> '1'
	order by f.pesoformulario
	 ";
$nivel++;
$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
//echo "<br><br>";
//exit();
while($row=$resultado->fetchRow()){
$ramaarbolsic[$row["idformulario"]]=$row;
$ramaarbolsic[$row["idformulario"]]["nivelitem"]=$nivel;
$ramaarbolsic[$row["idformulario"]]["grupo"]=$this->recursivaarmaarbolarray($row["idformulario"],($nivel));


}
return $ramaarbolsic;
}

function consultahijos($iditem){
$arrayramaarbol=$this->recursivaarmaarbolarray($iditem,"1");
$this->tmparrayramahijos[]=$iditem;
foreach($arrayramaarbol as $iditem => $ramaarbol){
$this->tmparrayramahijos[]=$iditem;
//echo "<br>item=".$iditem;
$this->armaarrayhijos($ramaarbol["grupo"]);
}
/*echo "<pre>";
print_r($this->tmparrayramahijos);
echo "</pre>";*/
//exit();

}
function consultapapas($iditem){


$tabla="formulario f";
$nombreidtabla="f.codigoestado";
$idtabla="100";
$condicion=" and idformulario = '".$iditem."' 
	and f.codigoestadodiligenciamiento like '1%'
	and f.codigoestado like '1%'
	order by i.pesoformulario
	 ";
$nivel++;
$datositemsic=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
$this->arrayitempadres[$iditem]=$datositemsic["pesoformulario"];
	if(trim($datositemsic["idformulario"])!="0")
	$this->consultapapas($datositemsic["idformulario"]);
}

function armaarrayhijos($ramaarbol){
if(is_array($ramaarbol))
foreach($ramaarbol as $iditem => $ramaarbol){
$this->tmparrayramahijos[]=$iditem;
//echo "<br>item=".$iditem;
$this->armaarrayhijos($ramaarbol["grupo"]);
}

}

function dibujaabreitemul($descripcionul){
echo "	
<ul".$descripcionul.">";
}

function dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul="",$url="",$javascript="",$javascriptdetalle="",$fotomuestra=""){

$checked="";

if($_POST["check".$iditem])
$checked="checked";


if(is_array($this->tmparrayramahijos))
if(in_array($iditem,$this->tmparrayramahijos)){
		$checked=$_GET["checked"];
}
if(trim($fotomuestra)!='')
$imagen="<img id='img".$iditem."' src='../../imagenes/".$fotomuestra."' />";
else
$imagen="";
//<input type='checkbox' name='check$iditem' id='check$iditem' value='1' $javascriptdetalle $checked/>
	echo "
<li id='".$iditem."'  noDrag='true' noSiblings='true' noDelete='true' noRename='true' >".$imagen."<a href='#Javascript' ><a href=".$url." $javascript>".$nombrecorto."</a></a>";

}
function dibujacierraitemli(){
echo " 
</li>";
}
function dibujacierraitemul(){
echo "
</ul>";
}
function recorreprimernivelarbol(){

foreach($this->arbolsic as $iditem => $rama ){
$nombrecorto=$rama["nombreformulario"];
$descripcionitem=$rama["nombreformulario"];
$nivel=$rama["nivelitem"];
//$descripcionul=" id='dhtmlgoodies_tree2' class='dhtmlgoodies_tree'";
$descripcionul=" id='tree'";
$descripcionitem="";

$this->dibujaabreitemul($descripcionul);
$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,"#".$iditem,"");
$this->dibujaabreitemul("");
	$this->recorreramaarbol($rama["grupo"]);
$this->dibujacierraitemul();
$this->dibujacierraitemli();
$this->dibujacierraitemul();
}



}

function encuentramuestraicono($iditem){
//if($this->codigocarrera){
	$tabla="formularioestudiante fe";
	$nombreidtabla="fe.codigoestado";
	$idtabla="100";
	$condicion=" and fe.idformulario = '".$iditem."' 
		and fe.idestudiantegeneral='".$this->codigoestudiante."'
		and fe.codigoestado like '1%'
		and fe.codigoestadodiligenciamiento in ('200','300')";
	$nivel++;
	if($datositemsiccarrera=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0)){
		$tmpfoto="poraprobar.gif";
		if($datositemsiccarrera["codigoestadodiligenciamiento"]=="300")
			$tmpfoto="aprobado.gif";	
	
	}
	else{
	 	$tmpfoto="noiniciado.gif";
	}	
/*}
else{
	$tmpfoto="noiniciado.gif";
}*/
return $tmpfoto;
}

function recorreramaarbol($ramaarbol){
if(is_array($ramaarbol))
foreach($ramaarbol as $iditem => $rama ){
$nombrecorto=$rama["nombreformulario"];
$descripcionitem=$rama["nombreformulario"];
$nivel=$rama["nivelitem"];
$descripcionul="";

$tienehijos=0;
$javascriptdetalle="";
$javascriptdemas="validacheck($iditem);";
if(is_array($rama["grupo"])){
	$tienehijos=1;
	//$javascriptdetalle="onclick=enviarconsultahijos(".$iditem.");";
	//$javascriptdemas=" enviarconsultahijos(".$iditem.");";
}
$fotomuestra="";
if(!$tienehijos)
$fotomuestra=$this->encuentramuestraicono($iditem);


$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,$rama["enlaceingresoformulario"]."?idformulario=".$rama["idformulario"]," target='marcocentral' ",$javascriptdetalle,$fotomuestra);
if($tienehijos)
	$this->dibujaabreitemul($descripcionul);


if($tienehijos)
	$this->recorreramaarbol($rama["grupo"]);
if($tienehijos)
	$this->dibujacierraitemul();
$this->dibujacierraitemli();


}


}


function mostrarconsultacarreraitem($codigocarrera,$tipovisualiza=""){

asort($this->arrayitempadres);
foreach($this->arrayitempadres as $iditem => $pesoitem){
	if($iditem!="1"){
		$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$codigocarrera."'
			and ic.codigoestado like '1%'";
		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$iditem."'";	
		$nivel++;
		$datositemsic=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

$botoncheck="";
if($tipovisualiza=='previsualiza')
	if(isset($datositemsic["itemsiccarrera"])&&trim($datositemsic["itemsiccarrera"])!='')
		if($datositemsic["codigoestadoitemsiccarrera"]=="200")
			$botoncheck="<input type='checkbox' onclick='selaprueba(this,$iditem);' checked/>";
		else
			$botoncheck="<input type='checkbox' onclick='selaprueba(this,$iditem);' />";

	if($datositemsic["codigotipoitemsic"]=="100")
	$this->formulario->dibujar_fila_titulo("<b>".$datositemsic["nombreitemsic"]."</b><br>",'',"2","align='center'","td");
	else
	$this->formulario->dibujar_fila_titulo("<br>".$botoncheck."<b>".$datositemsic["nombreitemsic"]."</b><br><br>",'',"2","align='left'","td");

	


//$cadenaurl="http://".$_SERVER["HTTP_HOST"]."/".str_replace("central.php","",$_SERVER["PHP_SELF"]);
//$contenido=file_get_contents($cadenaurl.$datositemsic["enlaceconsultaitemsic"]."?tipovisualiza=".$tipovisualiza."&iditem=".$iditem."&codigocarrera=".$codigocarrera);



	if(isset($datositemsic["itemsiccarrera"])&&trim($datositemsic["itemsiccarrera"])!=''){
		$objconsultasic=new ConsultaSic($iditem,$tipovisualiza,$this->objetobase,$this->formulario);
		$contenido=$objconsultasic->$datositemsic["enlaceconsultaitemsic"]();
	
	//$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$contenido)."",'',"2","align='left'","td");	
	}
}
	
}
}

}