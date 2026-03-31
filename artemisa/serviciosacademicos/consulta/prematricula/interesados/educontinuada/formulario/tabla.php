<?php
$rutaado=("../../../../../funciones/adodb/");
require_once("../../../../../Connections/salaado-pear.php");
require_once("../../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../../funciones/sala_genericas/DatosGenerales.php");
//require_once('../../../../../funciones/clases/autenticacion/redirect.php' ); 

class admintablasbase {

var $tabla;
var $objetobase;
var $filascreatetable;
var $camposconstraint;
var $primarykeys;
var $nombretabla;

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
function buscacampopropiedad($campo,$propiedad){
	for($i=0;$i<count($this->filascreatetable);$i++){
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
	foreach($datostabla as $llave=>$valor){
		$columnasdato[$i]=$valor;
		$i++;
	}
	
	return $columnasdato;
	
}
}
$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetoadmintabla= new admintablasbase($_GET['tabla'],$objetobase);
$primarykey=$objetoadmintabla->encuentraprimarykey();
$constraints=$objetoadmintabla->encuentraconstraint();
$objetoadmintabla->encuentranombretabla();
	/*if($objetoadmintabla->llaveautoincrementada($primarykey[0]))
	{
		echo "<h1>TIENE LLAVE AUTOINCREMENTADA</h1>";
	}
	else
	{
		echo "<h1>NO TIENE LLAVE AUTOINCREMENTADA</h1>";
	}*/
	



?>
<link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
<link href="../../../../../funciones/sala_genericas/ajax/suggest/suggest.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>

<form name="form1" action="tabla.php?tabla=<?php echo $_GET['tabla'] ?>&idtabla=<?php echo $_GET['idtabla'] ?>" method="POST" >
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
	
			$formulario->dibujar_fila_titulo(strtoupper($objetoadmintabla->tabla),'labelresaltado');
			$columnas=$objetoadmintabla->campostabla();
			$camposforeignkey=count($objetoadmintabla->camposconstraint);
			if(isset($_GET['idtabla'])&&$_GET['idtabla']!='')
				$columnas2=$objetoadmintabla->obtenerdatosidtabla($_GET['idtabla'],0);
			//echo "FOREIGN KEYS=".$camposforeignkey."<BR>";
			for($i=0;$i<count($columnas);$i++){
				if(!$objetoadmintabla->llaveautoincrementada($columnas[$i])){
					if($objetoadmintabla->buscacampopropiedad($columnas[$i],"NOT NULL"))
						$requerido="requerido";
					else
						$requerido="";
					
					if($filaconstraint=$objetoadmintabla->bucarcampoconstraint($columnas[$i])){
						
						$tmpobjetoadmintabla=new admintablasbase($filaconstraint[1],$objetobase);
						$tmpnumeroregistros=$tmpobjetoadmintabla->numeroregistrostabla();
						if($tmpnumeroregistros<1000){
							$tmpnombretabla=$tmpobjetoadmintabla->encuentranombretabla();
							if(!isset($tmpnombretabla)||trim($tmpnombretabla)==""){
								$tmpnombretabla=$filaconstraint[2];
							}
 							$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($filaconstraint[1],$filaconstraint[2],"CONCAT(".$filaconstraint[2].",'-',".$tmpnombretabla.") nombrebusqueda"," ".$filaconstraint[2]."=".$filaconstraint[2]."  order by ".$tmpnombretabla.",".$filaconstraint[2]."","",0,0);
							$formulario->filatmp[""]="Seleccionar";
							$menu="menu_fila"; $parametrosmenu="'".$filaconstraint[0]."','".$columnas2[$i]."',''";
							$formulario->dibujar_campo($menu,$parametrosmenu,$columnas[$i],"tdtitulogris",$filaconstraint[0],$requerido);
/* 							$datoscamposugerido=$objetobase->recuperar_datos_tabla($filaconstraint[1],$filaconstraint[2],$columnas2[$i],"","",0);
							$parametros="'".$filaconstraint[1]."','".$filaconstraint[2]."','".$tmpnombretabla."','','".$columnas2[$i]."','".$datoscamposugerido[$tmpnombretabla]."','".$filaconstraint[0]."','../../../serviciosacademicos/funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
							//echo $parametros;
							$datoscamposugerido[$tmpnombretabla];
							$campo="campo_sugerido";
							$formulario->dibujar_campo($campo,$parametros,$columnas[$i],"tdtitulogris",$filaconstraint[0],"requerido");
 */
							
							unset($tmpobjetoadmintabla);
							unset($tmpnombretabla);
						}
						else{
							if($objetoadmintabla->buscacampopropiedad($columnas[$i],"date")){
							  $campo="campo_fecha"; $parametros="'text','".$columnas[$i]."','".formato_fecha_defecto($columnas2[$i])."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
							  $formulario->dibujar_campo($campo,$parametros,$columnas[$i],"tdtitulogris",$columnas[$i],$requerido);
							}
							else{	
								/*$parametroboton="'text','".$columnas[$i]."','".$columnas2[$i]."'";
								$boton='boton_tipo'; 
								$formulario->dibujar_campo($boton,$parametroboton,$columnas[$i],"tdtitulogris",$columnas[$i],$requerido);*/
								$tmpnombretabla=$tmpobjetoadmintabla->encuentranombretabla();
								if(!isset($tmpnombretabla)||trim($tmpnombretabla)==""){
									$tmpnombretabla=$filaconstraint[2];
								}

									$datoscamposugerido=$objetobase->recuperar_datos_tabla($filaconstraint[1],$filaconstraint[2],$columnas2[$i],"","",0);
									$parametrossugerido[]="'".$filaconstraint[1]."','".$filaconstraint[2]."','".$tmpnombretabla."','','".$columnas2[$i]."','".$datoscamposugerido[$tmpnombretabla]."','".$filaconstraint[0]."','../../../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
									//echo $parametros;
									$datoscamposugerido[$tmpnombretabla];
									$campossugerido[]="campo_sugerido";
									$columnassugerido[]=$columnas[$i];
									$filaconstraintsugerido[]=$filaconstraint[0];

							}						
						}
					}
					else{
							if($objetoadmintabla->buscacampopropiedad($columnas[$i],"date")){
							  $campo="campo_fecha"; $parametros="'text','".$columnas[$i]."','".formato_fecha_defecto($columnas2[$i])."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
							  $formulario->dibujar_campo($campo,$parametros,$columnas[$i],"tdtitulogris",$columnas[$i],$requerido);
							}
							else{	
								$parametroboton="'text','".$columnas[$i]."','".$columnas2[$i]."'";
								$boton='boton_tipo'; 
								$formulario->dibujar_campo($boton,$parametroboton,$columnas[$i],"tdtitulogris",$columnas[$i],$requerido);
							}
					}
				}
			}
				for($j=0;$j<count($parametrossugerido);$j++)
				$formulario->dibujar_campo($campossugerido[$j],$parametrossugerido[$j],$columnassugerido[$j],"tdtitulogris",$filaconstraintsugerido[$j],"requerido");

					$conboton=0;
					//if(isset($objetoadmintabla->$primarykey))
						if(isset($_GET['idtabla'])){
							$parametrobotonenviarv[$conboton]="'submit','Modificar','Modificar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;
							/*$parametrobotonenviarv[$conboton]="'submit','Anular','Anular'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;						*/
							//$formulario->boton_tipo('hidden','idestudiantenovedadarp',$_GET[$objetoadmintabla->$primarykey[0]]);	
						}
						else{
							$parametrobotonenviarv[$conboton]="'submit','Enviar','Enviar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;	
						}
					//else{
							/*$parametrobotonenviarv[$conboton]="'submit','Enviar','Enviar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;	*/
					//}
					
					$parametrobotonenviarv[$conboton]="'button','Cerrar','Cerrar','onclick=window.close();'";
					$botonv[$conboton]='boton_tipo';

					//$conboton++;
					//$boton[$conboton]='boton_tipo';
					$formulario->dibujar_campos($botonv,$parametrobotonenviarv,"","tdtitulogris",'Enviar');

if(isset($_REQUEST['Enviar'])){

		if($formulario->valida_formulario()){
				$tabla=$objetoadmintabla->tabla;
				$col=0;
					for($i=0;$i<count($columnas);$i++){
						if(!$objetoadmintabla->llaveautoincrementada($columnas[$i])){
							if($i>=0&&$i<(count($columnas)-1))
								$and="and";
							else
								$and=""; 
								
							if($objetoadmintabla->buscacampopropiedad($columnas[$i],"date")){
								$fila[$columnas[$i]]=formato_fecha_mysql($_POST[$columnas[$i]]);
								$condicionactualiza.=$columnas[$i]."='".$_POST[$columnas[$i]]."' ".$and." ";
							}
							else{
								$fila[$columnas[$i]]=$_POST[$columnas[$i]];
								$condicionactualiza.=$columnas[$i]."='".$_POST[$columnas[$i]]."' ".$and." ";
								}
								
						}
					}
					$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
			}
}

if(isset($_REQUEST['Modificar'])){

		if($formulario->valida_formulario()){
				$tabla=$objetoadmintabla->tabla;
				$col=0;
					for($i=0;$i<count($columnas);$i++){
						if(!$objetoadmintabla->llaveautoincrementada($columnas[$i])){
							if($i>=0&&$i<(count($columnas)-1))
								$and="and";
							else
								$and=""; 
								
							if($objetoadmintabla->buscacampopropiedad($columnas[$i],"date")){
								$fila[$columnas[$i]]=formato_fecha_mysql($_POST[$columnas[$i]]);
								$condicionactualiza.=$columnas[$i]."='".$_POST[$columnas[$i]]."' ".$and." ";
							}
							else{
								$fila[$columnas[$i]]=$_POST[$columnas[$i]];
								$condicionactualiza.=$columnas[$i]."='".$_POST[$columnas[$i]]."' ".$and." ";
								}
								
						}
					}
					$objetobase->actualizar_fila_bd($tabla,$fila,$objetoadmintabla->primarykeys[0],$_GET['idtabla'],"",0);
			}
}

?>
  </table>
</form>