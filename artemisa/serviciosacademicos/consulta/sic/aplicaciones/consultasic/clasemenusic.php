<?php
class MenuSic{

var $objetobase;
var $formulario;
var $arbolsic;
var $tmparrayramahijos;
var $arrayitempadres;
var $codigocarrera=0;

function MenuSic($objetobase,$formulario){

$this->objetobase=$objetobase;
$this->formulario=$formulario;

}
function setUsuario($usuario)
{
$this->usuario=$usuario;
}
function getPermisoUsuario()
{
$tabla="usuario u,permisousuariomenuopcion up";
$nombreidtabla="u.usuario";
$idtabla=$this->usuario;
$condicion=" and u.idusuario=up.idusuario
		and up.codigoestado like '1%'";


	$datospermisousuario=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
return $datospermisousuario;
}
function setCodigoCarrera($codigocarrera){
if(isset($codigocarrera)&&trim($codigocarrera)!='')
$this->codigocarrera=$codigocarrera;

}
function consultaprimernivelsic(){

$tabla="itemsic i,permisoitemsicdependencia ipu,permisoitemsicdependencia psd";
$nombreidtabla="i.codigoestado";
$idtabla="100";
$datospermiso=$this->getPermisoUsuario();

$condicion="  and i.iditemsic=ipu.iditemsic
 and ipu.codigocarrera='".$this->codigocarrera."'
 and ipu.codigoestado like '1%'
 and i.codigoestado like '1%'
 and i.iditemsic=psd.iditemsic
 and psd.codigocarrera=".$this->codigocarrera."
	order by i.pesoitemsic
	 ";

$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
while($row=$resultado->fetchRow()){
$arbolsictmp[$row["iditemsic"]]=$row;
$arbolsictmp[$row["iditemsic"]]["nivelitem"]="0";

$arbolsictmp[$row["iditemsic"]]["grupo"]=$this->recursivaarmaarbolarray($row["iditemsic"],0);

}

$tabla="itemsic i";

$condicion="  and i.codigoestado like '1%'
	      and i.iditemsic='1'
	      order by i.pesoitemsic";

$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
$row=$resultado->fetchRow();
$this->arbolsic[$row["iditemsic"]]=$row;
$this->arbolsic[$row["iditemsic"]]["nivelitem"]="0";
$this->arbolsic[$row["iditemsic"]]["grupo"]=$arbolsictmp;


}

function recursivaarmaarbolarray($iditemsicpadre,$nivel){

$tabla="itemsic i";
$nombreidtabla="i.codigoestado";
$idtabla="100";
$condicion=" and iditemsicpadre = '".$iditemsicpadre."' 
	and i.codigoestadoitemsic like '1%'
	and i.codigoestado like '1%'
	order by i.pesoitemsic
	 ";
$nivel++;
$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
//echo "<br><br>";
while($row=$resultado->fetchRow()){
$ramaarbolsic[$row["iditemsic"]]=$row;
$ramaarbolsic[$row["iditemsic"]]["nivelitem"]=$nivel;
$ramaarbolsic[$row["iditemsic"]]["grupo"]=$this->recursivaarmaarbolarray($row["iditemsic"],($nivel));


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


$tabla="itemsic i";
$nombreidtabla="i.codigoestado";
$idtabla="100";
$condicion=" and iditemsic = '".$iditem."' 
	and i.codigoestado like '1%'
	order by i.pesoitemsic
	 ";
$nivel++;
$datositemsic=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
$this->arrayitempadres[$iditem]=$datositemsic["pesoitemsic"];
	if(trim($datositemsic["iditemsicpadre"])!="0")
	$this->consultapapas($datositemsic["iditemsicpadre"]);
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

if($fotomuestra!='false'){
	if(is_array($this->tmparrayramahijos))
		if(in_array($iditem,$this->tmparrayramahijos)){
				$checked=$_GET["checked"];
		}
	if(trim($fotomuestra)!='')
		$imagen="<img id='img".$iditem."' src='../../imagenes/".$fotomuestra."' />";
	else
		$imagen="";
	
	echo "
	<li id='".$iditem."'  noDrag='true' noSiblings='true' noDelete='true' noRename='true' >".$imagen."<a href='#Javascript' ><input type='checkbox' name='check$iditem' id='check$iditem' value='1' $javascriptdetalle $checked/><a href=".$url." $javascript>".$nombrecorto."</a></a>";
}


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
//$descripcionul=" id='dhtmlgoodies_tree2' class='dhtmlgoodies_tree'";
$descripcionul=" id='tree'";
$descripcionitem="";

$this->dibujaabreitemul($descripcionul);
$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,"#".$iditem,"onclick=validacheck($iditem);");
$this->dibujaabreitemul("");
	$this->recorreramaarbol($rama["grupo"]);
$this->dibujacierraitemul();
$this->dibujacierraitemli();
$this->dibujacierraitemul();
}



}

function encuentramuestraicono($iditem){
if($this->codigocarrera){
	$tabla="itemsiccarrera ic";
	$nombreidtabla="ic.codigoestado";
	$idtabla="100";
	$condicion=" and ic.iditemsic = '".$iditem."' 
		and now() between ic.fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		and ic.codigocarrera=".$this->codigocarrera."
		and ic.codigoestado like '1%'
		";
	$nivel++;
	if($datositemsiccarrera=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0)){
		$tmpfoto="poraprobar.gif";
		if($datositemsiccarrera["codigoestadoitemsiccarrera"]=="200")
			$tmpfoto="aprobado.gif";	
	
	}
	else{
	 	$tmpfoto="noiniciado.gif";
		$tmpfoto="false";
	}	
}
else{
	$tmpfoto="noiniciado.gif";
	$tmpfoto="false";
}
return $tmpfoto;
}
function recorreramaarbol($ramaarbol){
if(is_array($ramaarbol)){
	foreach($ramaarbol as $iditem => $rama ){
	$nombrecorto=$rama["nombreitemsic"];
	$descripcionitem=$rama["nombreitemsic"];
	$nivel=$rama["nivelitem"];
	$descripcionul="";
	
	$tienehijos=0;
	$javascriptdetalle="";
	$javascriptdemas="validacheck($iditem);";
	if(is_array($rama["grupo"])){
		$tienehijos=1;
		$javascriptdetalle="onclick=enviarconsultahijos(".$iditem.");";
		$javascriptdemas=" enviarconsultahijos(".$iditem.");";
	}

$fotomuestra="";
if(!$tienehijos)
$fotomuestra=$this->encuentramuestraicono($iditem);


$this->dibujaabreitemli($iditem,$nombrecorto,$descripcionitem,$nivel,$descripcionul,"#Javascript","onclick='".$javascriptdemas."'",$javascriptdetalle,$fotomuestra);
if($tienehijos)
	$this->dibujaabreitemul($descripcionul);


if($tienehijos)
	$this->recorreramaarbol($rama["grupo"]);
if($tienehijos)
	$this->dibujacierraitemul();
$this->dibujacierraitemli();


}

}
else
{
	//alerta_javascript("Este usuario no tiene item asignados");
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

//echo "<H1>CONSULTA:".$datositemsic["enlaceconsultaitemsic"]."</H1>";

	if(isset($datositemsic["itemsiccarrera"])&&trim($datositemsic["itemsiccarrera"])!=''){
		$objconsultasic=new ConsultaSic($iditem,$tipovisualiza,$this->objetobase,$this->formulario);
		if(trim($datositemsic["enlaceconsultaitemsic"]) != '')
			$contenido=$objconsultasic->$datositemsic["enlaceconsultaitemsic"]();
		else
			$contenido=$objconsultasic->descripcionxfacultad();
		
	//$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$contenido)."",'',"2","align='left'","td");	
	}
}
	
}
}

}