<?php
class MenuSic{

var $objetobase;
var $formulario;
var $arbolsic;


function MenuSic($objetobase,$formulario){

$this->objetobase=$objetobase;
$this->formulario=$formulario;

}
function consultaprimernivelsic(){

$tabla="itemsic i";
$nombreidtabla="i.codigoestado";
$idtabla="100";
$condicion=" and (iditemsicpadre = ''  or iditemsicpadre = '0' or iditemsicpadre is null)		
	order by i.pesoitemsic
	 ";

$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
while($row=$resultado->fetchRow()){
$this->arbolsic[$row["iditemsic"]]=$row;
$this->arbolsic[$row["iditemsic"]]["nivelitem"]="0";

$this->arbolsic[$row["iditemsic"]]["grupo"]=$this->recursivaarmaarbolarray($row["iditemsic"],0);

}

}

function recursivaarmaarbolarray($iditemsicpadre,$nivel){

$tabla="itemsic i";
$nombreidtabla="i.codigoestado";
$idtabla="100";
$condicion=" and iditemsicpadre = '".$iditemsicpadre."' 		
	order by i.pesoitemsic
	 ";
$nivel++;
$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
while($row=$resultado->fetchRow()){
$ramaarbolsic[$row["iditemsic"]]=$row;
$ramaarbolsic[$row["iditemsic"]]["nivelitem"]=$nivel;

$ramaarbolsic[$row["iditemsic"]]["grupo"]=$this->recursivaarmaarbolarray($row["iditemsic"],($nivel));


}
return $ramaarbolsic;
}
function dibujaabreitemul($descripcionul){
echo "	
<ul".$descripcionul.">";
}

function dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul="",$url="",$javascript=""){
	echo "
<li id='".$iditem."'  ><a href=".$url." $javascript>".$nombrecorto."</a>";

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
$nombrecorto=$rama["nombreitemsic"];
$descripcionitem=$rama["nombreitemsic"];
$nivel=$rama["nivelitem"];
$descripcionul=" id='dhtmlgoodies_tree2' class='dhtmlgoodies_tree'";
$this->dibujaabreitemul($descripcionul);
$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,"formularioitem.php?iditem=$iditem"," target='marcocentral'");
$this->dibujaabreitemul("");
	$this->recorreramaarbol($rama["grupo"]);
$this->dibujacierraitemul();
$this->dibujacierraitemli();
$this->dibujacierraitemul();
}



}

function recorreramaarbol($ramaarbol){

foreach($ramaarbol as $iditem => $rama ){
$nombrecorto=$rama["nombreitemsic"];
$descripcionitem=$rama["nombreitemsic"];
$nivel=$rama["nivelitem"];
$descripcionul="";

$tienehijos=0;
if(is_array($rama["grupo"]))
	$tienehijos=1;



$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,"formularioitem.php?iditem=$iditem"," target='marcocentral'");
if($tienehijos)
	$this->dibujaabreitemul($descripcionul);


if($tienehijos)
	$this->recorreramaarbol($rama["grupo"]);
if($tienehijos)
	$this->dibujacierraitemul();
$this->dibujacierraitemli();


}


}

}