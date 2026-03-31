<?php
class admintablasbase {

var $tabla;
var $objetobase;
var $filascreatetable;
var $camposconstraint;
var $primarykeys;
var $nombretabla;
var $columnasnombres;
var $columnas;

function admintablasbase($tabla,$objetobase)
{

	$this->objetobase=$objetobase;

	$this->tabla=$tabla;
	$this->generafilastabla();	
}
function generafilastabla(){
	$query = 'show  create table '.$this->tabla;
	$result = $this->objetobase->conexion->query($query);
	while ($row = $result->fetchRow()){
		foreach ($row as $llave => $valor){
			$listadocreatetable[]=$row[$llave];
		}
	}
	$this->filascreatetable=explode(chr(10),$listadocreatetable[1]);

}
function comentariocolumna($columna){


$query = "SELECT c.ayudacampo FROM tabla t, campo c
 WHERE  t.nombretabla LIKE '".$this->tabla."'
 AND c.nombrecampo = '".$columna."'
and t.idtabla=c.idtabla";
$result = $this->objetobase->conexion->query($query);
$row = $result->fetchRow();
return $row["ayudacampo"];

}

function encuentraconstraint(){
	$const=0; 
	for($i=0;$i<count($this->filascreatetable);$i++){
		
		//echo "$i)".$this->filascreatetable[$i]."<br>";
	
		if(substr_count($this->filascreatetable[$i],"CONSTRAINT")>0){
			$cadenaconstraints[$const]=explode("FOREIGN KEY",$this->filascreatetable[$i]);
			$cadenaforeignkey[$const]=explode("REFERENCES",$cadenaconstraints[$const][1]);
			$cadenareferences[$const]=explode(" ",trim($cadenaforeignkey[$const][1]));
			
			$camposconstraint[$const][0]=trim(str_replace("`","",$cadenaforeignkey[$const][0]));
			$camposconstraint[$const][0]=str_replace("(","",$camposconstraint[$const][0]);
			$camposconstraint[$const][0]=str_replace(")","",$camposconstraint[$const][0]);
	
			$camposconstraint[$const][1]=trim(str_replace("`","",$cadenareferences[$const][0]));
			$camposconstraint[$const][1]=str_replace("(","",$camposconstraint[$const][1]);
			$camposconstraint[$const][1]=str_replace(")","",$camposconstraint[$const][1]);
	
			$camposconstraint[$const][2]=trim(str_replace("`","",$cadenareferences[$const][1]));
			$camposconstraint[$const][2]=str_replace("(","",$camposconstraint[$const][2]);
			$camposconstraint[$const][2]=str_replace(")","",$camposconstraint[$const][2]);
			$camposconstraint[$const][2]=str_replace(",","",$camposconstraint[$const][2]);
			
			$const++;
		}
	
	}
	$this->camposconstraint=$camposconstraint;
 return $camposconstraint;
}
function encuentraprimarykey(){
 	$pri=0;
	for($i=0;$i<count($this->filascreatetable);$i++){
		if(substr_count($this->filascreatetable[$i],"PRIMARY KEY")>0){
				$cadenaprimarykey[$pri]=explode("PRIMARY KEY",$this->filascreatetable[$i]);
				$primarykeys=explode(",",$cadenaprimarykey[$pri][1]);
				//print_r($primarykeys[$pri]); echo "<br>";
				$pri++;
		}
	}
	for($i=0;$i<count($primarykeys);$i++){
		if(trim($primarykeys[$i])=="")
			unset($primarykeys[$i]);
		else{
			$primarykeys[$i]=trim(str_replace("`","",$primarykeys[$i]));
			$primarykeys[$i]=str_replace("(","",$primarykeys[$i]);
			$primarykeys[$i]=str_replace(")","",$primarykeys[$i]);
			}

	}
	$this->primarykeys=$primarykeys;
return $primarykeys;
} 
function encuentranombretabla(){
	for($i=0;$i<count($this->filascreatetable);$i++){
		if(substr_count($this->filascreatetable[$i],"nombre")>0){
		 $cadenanombretabla=explode(" ",trim($this->filascreatetable[$i]));
		 
		 $nombretabla=trim(str_replace("`","",$cadenanombretabla[0]));
		// print_r($cadenanombretabla);
		// echo "<h1>".$nombretabla."</h1>";

		 break;
		}
	}
	$this->nombretabla=$nombretabla;
return $nombretabla;
}
function llaveautoincrementada($primarykey){
	for($i=0;$i<count($this->filascreatetable);$i++){
//	echo "PRIMARY KEY=".$primarykey."<br>";
		if(substr_count($this->filascreatetable[$i],"`".$primarykey."`")>0){
			if(substr_count($this->filascreatetable[$i],"auto_increment")>0){
				return 1;
			}
		}
	}
return 0;
}
function buscacampopropiedad($campo,$propiedad,$imprimir=0){
	for($i=0;$i<count($this->filascreatetable);$i++){
		//if($imprimir)
		//echo "<br>".$this->filascreatetable[$i]."=".$propiedad;

		if(substr_count($this->filascreatetable[$i],"`".$campo."`")>0){
			if(substr_count($this->filascreatetable[$i],$propiedad)>0){
			
				return 1;
			}
		}
	}
	return 0;
}
function campostabla()
{
	$query = 'describe '.$this->tabla;
	// execute the query and fetch the result
	if ($result = $this->objetobase->conexion->query($query))
	{
		$colum=0;
		while($row = $result->fetchRow()){
		//echo "\n".$row['key'];
			$columnas[$colum]=$row['Field'];					
			$colum++;
		}

	}
		$this->columnas=$columnas;
		return $columnas;
}
function bucarcampoconstraint($campo){
	for($i=0;$i<count($this->camposconstraint);$i++){
		//echo "if(".trim($campo)."==".trim($this->camposconstraint[$i][0])."))<br>";
		 if(trim($campo)==trim($this->camposconstraint[$i][0])){
		 $filaconstraint=$this->camposconstraint[$i];
		 }
	}
	$this->camposconstraint;
	return $filaconstraint;
}
function  numeroregistrostabla(){
	$query = 'select count(*) cuenta from '.$this->tabla;
	// execute the query and fetch the result
	if ($result = $this->objetobase->conexion->query($query))
	{
		while($row = $result->fetchRow()){
		//echo "\n".$row['key'];
			$resultado=$row['cuenta'];					
		
		}

	}
	return $resultado;
}
function obtenerdatosidtabla($idtabla,$imprimir=0){
	$datostabla=$this->objetobase->recuperar_datos_tabla($this->tabla,$this->primarykeys[0],$idtabla,"","",$imprmir);
	$i=0;
	if(is_array($datostabla))
	foreach($datostabla as $llave=>$valor){
		$columnasdato[$i]=$valor;
		$i++;
	}
	
	return $columnasdato;
	
}
function obtenerdatosposttabla(){
	foreach($this->columnas as $llave=>$campo){
		if($this->buscacampopropiedad($this->columnas[$llave],"date")){
			if(isset($_POST[$campo])&&trim($_POST[$campo])!="")
				$columnasdato[]=formato_fecha_mysql($_POST[$campo]);
			else
				$columnasdato[]="";
		}
		else{
		$columnasdato[]=$_POST[$campo];	
		}	
	}
	return $columnasdato;
}
function columnasnombres($arrayconversioncolumnas){
$this->tabla;


unset($this->columnasnombres);
for($i=0;$i<count($this->columnas);$i++){
	//echo "<br>arrayconversioncolumnas[".$this->tabla."][".$this->columnas[$i]."]=".$arrayconversioncolumnas[$this->tabla][$this->columnas[$i]];
	if(isset($arrayconversioncolumnas[$this->tabla][$this->columnas[$i]])&&trim($arrayconversioncolumnas[$this->tabla][$this->columnas[$i]])!='')	
		$this->columnasnombres[$i]=$arrayconversioncolumnas[$this->tabla][$this->columnas[$i]];
	else
		$this->columnasnombres[$i]=$this->columnas[$i];
}


}
function getcolumnasnombres(){
	return $this->columnasnombres;
}
}
?>
