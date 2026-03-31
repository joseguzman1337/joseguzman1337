<?php
class DibujaFormulario{

var $tabla;
var $idtabla;
var $objetobase;
var $formulario;
var $objetoadmintabla;
var $columnas;
var $columnasnombres;
var $columnas2;
var $columnasdehabilitadas;
var $arraycolumnasnombres;
var $arrayvalidaciones;

/*Constructor que inicia los array de columnas y nombres de  columna de la tabla seleccionada*/

function DibujaFormulario($tabla,$idtabla,$sala,$idformulario="",$formulario=""){
$this->tabla=$tabla;
$this->idtabla=$idtabla;
$this->objetobase=new BaseDeDatosGeneral($sala);
if(is_object($formulario))
{
	$this->formulario=$formulario;
}
else
{
	$this->formulario=new formulariobaseestudiante($sala,'form1','post','','true');
}
$this->objetoadmintabla= new admintablasbase($this->tabla,$this->objetobase);

$primarykey=$this->objetoadmintabla->encuentraprimarykey();
$constraints=$this->objetoadmintabla->encuentraconstraint();
$this->objetoadmintabla->encuentranombretabla();
$this->columnas=$this->objetoadmintabla->campostabla();
//$arraycolumnasnombrestmp[""][0]="";
$this->idformulario=$idformulario;
$this->crearArrayColumnasNombres();
$this->objetoadmintabla->columnasnombres($this->arraycolumnasnombres);
$this->columnasnombres=$this->objetoadmintabla->getcolumnasnombres();

if(isset($this->idtabla)&&$this->idtabla!='')
	$this->columnas2=$this->objetoadmintabla->obtenerdatosidtabla($this->idtabla,0);
else 
	$this->columnas2=$this->objetoadmintabla->obtenerdatosposttabla();
}

/* funcion para reordenar los array de nombres y valores de columnas de la tabla */
function reordenamiento(){

	$query = "SELECT t.nombretabla,c.nombrecampo,c.nombrecampoformulario FROM campo c,tabla t,formulariotabla ft
 	WHERE ft.idtabla=t.idtabla
		and t.idtabla=c.idtabla
		and ft.idformulario='".$this->idformulario."'
		order by c.pesocampo";
	$result = $this->objetobase->conexion->query($query);
	while($row = $result->fetchRow()){
		/*$this->columnasnombres
		$this->columnas2
		$this->columnas*/
	}
}
/* Asigna el array que sirve para almacenar las validaciones indice=nombrecampo,valor=tipo de validacion */
function setArrayValidaciones($arrayvalidaciones){
$this->arrayvalidaciones=$arrayvalidaciones;


}
/*retorna el tipo de validacion segun el campo*/
function encuentraValidacion($columna){

if($this->objetoadmintabla->buscacampopropiedad($columna,"NOT NULL"))
	$requerido="requerido";
else
	$requerido="";


if(is_array($this->arrayvalidaciones))
{
	foreach($this->arrayvalidaciones as $nombrecolumna=>$validacion)
	{
		if($columna==$nombrecolumna){
		
			$requerido=$validacion;
		}	
	}
}

return $requerido;

}
/*Asigna el atributo de array de lÃ±os nombres de columna de la tabla*/
function crearArrayColumnasNombres(){
	$query = "SELECT t.nombretabla,c.nombrecampo,c.nombrecampoformulario FROM campo c,tabla t,formulariotabla ft
 	WHERE ft.idtabla=t.idtabla
		and t.idtabla=c.idtabla
		and ft.idformulario='".$this->idformulario."'";
	$result = $this->objetobase->conexion->query($query);
	while($row = $result->fetchRow()){
	$this->arraycolumnasnombres[$row["nombretabla"]][$row["nombrecampo"]]=$row["nombrecampoformulario"];

	}
}
/*Quita las columnas de los array atributo correspondiendo al parametro de ingreso que tambien es una array indice=nombrecampo,valor=tipo de validacion*/
function quitarcolumnas($arrayquitacolumnas){
$j=0;
for($i=0;$i<count($this->columnas);$i++){
	if(!in_array($this->columnas[$i],$arrayquitacolumnas)){
		$tmpcolumnas[$j]=$this->columnas[$i];
		$tmpcolumnas2[$j]=$this->columnas2[$i];
		if(isset($this->columnasnombres[$i])&&trim($this->columnasnombres[$i])!='')
		$tmpcolumnasnombres[$j]=$this->columnasnombres[$i];
		$j++;
	}
}

$this->columnas=$tmpcolumnas;
$this->columnasnombres=$tmpcolumnasnombres;
$this->columnas2=$tmpcolumnas2;

}
/*retorna el valor del campo con respecto al nombre asociativo*/
function recuperarValorCampo($nombrecampo){
		$tmpdatosidtabla=$this->objetoadmintabla->obtenerdatosidtabla($this->idtabla,0);
		$tmpcamposidtabla=$this->objetoadmintabla->campostabla();

		foreach($tmpcamposidtabla as $icampo=>$nombrecampotmp){
			//echo "if($nombrecampo==$nombrecampotmp){<br>".$tmpdatosidtabla[$icampo]."<br>";
			if($nombrecampo==$nombrecampotmp){
			
			$valorcampo=$tmpdatosidtabla[$icampo];
			return $valorcampo;
			}
		}
return "";
		
}
/*Almacena en un array a las columnas que apareceran en estado disabled en el formulario*/
function deshabilitarcolumnas($arraydescolumnas){
unset($this->columnasdehabilitadas);
for($i=0;$i<count($this->columnas);$i++){
	if(is_array($arraydescolumnas))
	if(in_array($this->columnas[$i],$arraydescolumnas)){
		$this->columnasdehabilitadas[$i]="readonly=true";
		$j++;
	}

}
//$this->columnasdehabilitadas["otro"]="otro";

}
function columnasnombres($arrayconversioncolumnas){
$this->tabla;


//unset($this->columnasnombres);
for($i=0;$i<count($this->columnas);$i++){
	//echo "<br>arrayconversioncolumnas[".$this->tabla."][".$this->columnas[$i]."]=".$arrayconversioncolumnas[$this->tabla][$this->columnas[$i]];
	if(isset($arrayconversioncolumnas[$this->tabla][$this->columnas[$i]])&&trim($arrayconversioncolumnas[$this->tabla][$this->columnas[$i]])!='')	
		$this->columnasnombres[$i]=$arrayconversioncolumnas[$this->tabla][$this->columnas[$i]];
//	else
//		$this->columnasnombres[$i]=$this->columnas[$i];
}


}
/*Funcion principal que pinta todos los campos del formulario*/
function muestraFormulario(){

			//$this->formulario->dibujar_fila_titulo(strtoupper($objetoadmintabla->tabla),'labelresaltado');
			$this->formulario->dibujar_fila_titulo(str_replace("_"," ",$_GET["titulo"]),'labelresaltado');
			//echo "columnas<pre>";

			//$this->columnasnombres=$this->objetoadmintabla->getcolumnasnombres();
			/*echo "columnasnombres<pre>";
			print_r($this->columnasnombres);
			echo "</pre>";*/

			//$this->columnasnombres=$columnas;
			$camposforeignkey=count($this->objetoadmintabla->camposconstraint);
			//echo "FOREIGN KEYS=".$camposforeignkey."<BR>";
			for($i=0;$i<count($this->columnas);$i++)
			{
				if(!$this->objetoadmintabla->llaveautoincrementada($this->columnas[$i]))
				{
					$comentarioadmintabla=$this->objetoadmintabla->comentariocolumna($this->columnas[$i]);
					if(isset($comentarioadmintabla)&&trim($comentarioadmintabla)!=''){
						$comentario=$comentarioadmintabla;
						
					}
					else{
						$comentario="";
					}
					

					
					$requerido=$this->encuentraValidacion($this->columnas[$i]);

					if($filaconstraint=$this->objetoadmintabla->bucarcampoconstraint($this->columnas[$i])){
					
						$tmpobjetoadmintabla=new admintablasbase($filaconstraint[1],$this->objetobase);
						$tmpnumeroregistros=$tmpobjetoadmintabla->numeroregistrostabla();
						if($tmpnumeroregistros<1000){
							$tmpnombretabla=$tmpobjetoadmintabla->encuentranombretabla();
							if(!isset($tmpnombretabla)||trim($tmpnombretabla)==""){
								$tmpnombretabla=$filaconstraint[2];
							}
 							$this->formulario->filatmp=$this->objetobase->recuperar_datos_tabla_fila($filaconstraint[1],$filaconstraint[2],"CONCAT(".$tmpnombretabla.",' (',".$filaconstraint[2].",')') nombrebusqueda"," ".$filaconstraint[2]."=".$filaconstraint[2]."  order by ".$tmpnombretabla.",".$filaconstraint[2]."","",0,0);
							$this->formulario->filatmp[""]="Seleccionar";
							$menu="menu_fila"; $parametrosmenu="'".$filaconstraint[0]."','".$this->columnas2[$i]."','".$this->columnasdehabilitadas[$i]." ".$comentario."' ";
							$this->formulario->dibujar_campo($menu,$parametrosmenu,$this->columnasnombres[$i],"tdtitulogris",$filaconstraint[0],$requerido,0,"",$comentario);
/* 							$datoscamposugerido=$this->objetobase->recuperar_datos_tabla($filaconstraint[1],$filaconstraint[2],$this->columnas2[$i],"","",0);
							$parametros="'".$filaconstraint[1]."','".$filaconstraint[2]."','".$tmpnombretabla."','','".$this->columnas2[$i]."','".$datoscamposugerido[$tmpnombretabla]."','".$filaconstraint[0]."','../../../../../../serviciosacademicos/funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
							//echo $parametros;
							$datoscamposugerido[$tmpnombretabla];
							$campo="campo_sugerido";
							$this->formulario->dibujar_campo($campo,$parametros,$this->columnasnombres[$i],"tdtitulogris",$filaconstraint[0],"requerido");
 */
							
							unset($tmpobjetoadmintabla);
							unset($tmpnombretabla);
						}
						else{
							if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"date")){
								$fecharecupera=formato_fecha_defecto($this->columnas2[$i]);
								if(trim($fecharecupera)=="//")
									$fecharecupera="";
							  $campo="campo_fecha"; $parametros="'text','".$this->columnas[$i]."','".$fecharecupera."','onKeyUp = \"this.value=formateafecha(this.value);\" ".$this->columnasdehabilitadas[$i]."'";
							  $this->formulario->dibujar_campo($campo,$parametros,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,$comentario);
												
							}
							else if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"tinyint",1)){
								$this->formulario->filatmp=array("1"=>"Si","0"=>"No");
								$this->formulario->filatmp[""]="Seleccionar";
								$menu="menu_fila"; $parametrosmenu="'".$this->columnas[$i]."','".$this->columnas2[$i]."','".$this->columnasdehabilitadas[$i]." ".$comentario."' ";
								$this->formulario->dibujar_campo($menu,$parametrosmenu,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,$comentario);
						
							}
							else{	
								
								$parametroboton="'text','".$this->columnas[$i]."','".$this->columnas2[$i]."','".$comentario."'";
								$boton='boton_tipo'; 
								$this->formulario->dibujar_campo($boton,$parametroboton,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,$comentario);
												
								/*$tmpnombretabla=$tmpobjetoadmintabla->encuentranombretabla();
								//if(!isset($tmpnombretabla)||trim($tmpnombretabla)==""){
									$tmpnombretabla=$filaconstraint[2];
								//}

									$datoscamposugerido=$this->objetobase->recuperar_datos_tabla($filaconstraint[1],$filaconstraint[2],$this->columnas2[$i],"","",0);
									$parametrossugerido[]="'".$filaconstraint[1]."','".$filaconstraint[2]."','".$tmpnombretabla."','','".$this->columnas2[$i]."','".$datoscamposugerido[$tmpnombretabla]."','".$filaconstraint[0]."','../../../../../../serviciosacademicos/funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
									//echo $parametros;
									$datoscamposugerido[$tmpnombretabla];
									$campossugerido[]="campo_sugerido";
									$columnassugerido[]=$this->columnasnombres[$i];
									$filaconstraintsugerido[]=$filaconstraint[0];*/

									

							}						
						}
					}
					else{
							if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"date"))
							{
							  $fecharecupera=formato_fecha_defecto($this->columnas2[$i]);
								if(trim($fecharecupera)=="//")
								$fecharecupera="";
							  $campo="campo_fecha"; $parametros="'text','".$this->columnas[$i]."','".$fecharecupera."','onKeyUp = \"this.value=formateafecha(this.value);\" ".$this->columnasdehabilitadas[$i]."' ";
							  $this->formulario->dibujar_campo($campo,$parametros,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,"",$comentario);
							}
							else if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"longtext"))
							{
								$campo="memo"; $parametros="'".$this->columnas[$i]."','".$this->columnas[$i]."',50,6,'','','',''";
								$this->formulario->dibujar_campo($campo,$parametros,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,"",$comentario);
								$this->formulario->cambiar_valor_campo($this->columnas[$i],quitarsaltolinea($this->columnas2[$i]));
							}
							else if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"tinyint"))
							{
								$this->formulario->filatmp=array("1"=>"Si","0"=>"No");
								$this->formulario->filatmp[""]="Seleccionar";
								$menu="menu_fila"; $parametrosmenu="'".$this->columnas[$i]."','".$this->columnas2[$i]."','".$this->columnasdehabilitadas[$i]."' ";
								$this->formulario->dibujar_campo($menu,$parametrosmenu,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,"",$comentario);
						
							}
							else
							{
								
								$parametroboton="'text','".$this->columnas[$i]."','".$this->columnas2[$i]."','".$this->columnasdehabilitadas[$i]."'";
								$boton='boton_tipo'; 
								$this->formulario->dibujar_campo($boton,$parametroboton,$this->columnasnombres[$i],"tdtitulogris",$this->columnas[$i],$requerido,0,"",$comentario);
							}
							
					}
				}
			}
			//	for($j=0;$j<count($parametrossugerido);$j++)
			//	$this->formulario->dibujar_campo($campossugerido[$j],$parametrossugerido[$j],$columnassugerido[$j],"tdtitulogris",$filaconstraintsugerido[$j],"requerido");

			
}

/*Funcion que pinta todos los botones de envio dependiendo si es de modificaciÃ³n o un registro nuevo*/
function botonesEnvio($anular=1,$modificar=1,$enviar=1){

					$conboton=0;
					//if(isset($this->objetoadmintabla->$primarykey))
						if(isset($this->idtabla)&&trim($this->idtabla)!=''){
							if($modificar){
								$parametrobotonenviarv[$conboton]="'submit','Modificar','Modificar'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
							}
							if($anular){
								$parametrobotonenviarv[$conboton]="'submit','Anular','Anular'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
							}						
							//$this->formulario->boton_tipo('hidden','idestudiantenovedadarp',$_GET[$this->objetoadmintabla->$primarykey[0]]);	
						}
						else{
							if($enviar){
								$parametrobotonenviarv[$conboton]="'submit','Enviar','Enviar'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
							}	
						}
					//else{
							/*$parametrobotonenviarv[$conboton]="'submit','Enviar','Enviar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;	*/
					//}
					
					/*$parametrobotonenviarv[$conboton]="'button','Cerrar','Cerrar','onclick=window.close();'";
					$botonv[$conboton]='boton_tipo';*/

					//$conboton++;
					//$boton[$conboton]='boton_tipo';
					$this->formulario->dibujar_campos($botonv,$parametrobotonenviarv,"","tdtitulogris",'Enviar');

}

/*Ingresa un nuevo resgistro de base de datos despues de un Submit con el boton Enviar*/
function ingresarNuevo($imprimir=0,$botonenvio="Enviar"){
if(isset($_REQUEST[$botonenvio])){

		if($this->formulario->valida_formulario()){
				$tabla=$this->objetoadmintabla->tabla;
				$col=0;
					for($i=0;$i<count($this->columnas);$i++){
						if(!$this->objetoadmintabla->llaveautoincrementada($this->columnas[$i])){
							if($i>=0&&$i<(count($this->columnas)-1))
								$and="and";
							else
								$and=""; 
								
							if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"date")){
								$fila[$this->columnas[$i]]=formato_fecha_mysql($_POST[$this->columnas[$i]]);
								$condicionactualiza.=$this->columnas[$i]."='".$_POST[$this->columnas[$i]]."' ".$and." ";
							}
							else{
								$fila[$this->columnas[$i]]=$_POST[$this->columnas[$i]];
								$condicionactualiza.=$this->columnas[$i]."='".$_POST[$this->columnas[$i]]."' ".$and." ";
								}
								
						}
					}
					if($imprimir)
						echo "<pre>";
					$this->objetobase->insertar_fila_bd($tabla,$fila,$imprimir,$condicionactualiza);
					if($imprimir)
						echo "</pre>";
					return 1;
			}
}
return 0;
}
/*Modifica un resgistro en base de datos despues de un Submit con el boton Modificar*/
function ingresarModificacion($imprimir=0,$botonenvio="Modificar"){
if(isset($_REQUEST[$botonenvio])){
/*
echo "formulario<pre>";
print_r($this->formulario);
echo "</pre>";
*/
		if($this->formulario->valida_formulario()){
				$tabla=$this->objetoadmintabla->tabla;
				$col=0;
					for($i=0;$i<count($this->columnas);$i++){
						if(!$this->objetoadmintabla->llaveautoincrementada($this->columnas[$i])){
							if($i>=0&&$i<(count($this->columnas)-1))
								$and="and";
							else
								$and=""; 
								
							if($this->objetoadmintabla->buscacampopropiedad($this->columnas[$i],"date")){
								if(trim($_POST[$this->columnas[$i]])!="//"){
									$fila[$this->columnas[$i]]=formato_fecha_mysql($_POST[$this->columnas[$i]]);
									$condicionactualiza.=$this->columnas[$i]."='".$_POST[$this->columnas[$i]]."' ".$and." ";
								}
							}
							else{
								$fila[$this->columnas[$i]]=$_POST[$this->columnas[$i]];
								$condicionactualiza.=$this->columnas[$i]."='".$_POST[$this->columnas[$i]]."' ".$and." ";
								}
								
						}
					}
					$this->objetobase->actualizar_fila_bd($tabla,$fila,$this->objetoadmintabla->primarykeys[0],$this->idtabla,"",$imprimir);
				return 1;				
			}

}
return 0;
}
/*MAnula un resgistro en base de datos despues de un Submit con el boton Anular*/
function ingresarAnulacion($imprimir=0,$botonenvio="Anular"){
if(isset($_REQUEST[$botonenvio])){
$tabla=$this->objetoadmintabla->tabla;
$fila["codigoestado"]="200";
$this->objetobase->actualizar_fila_bd($tabla,$fila,$this->objetoadmintabla->primarykeys[0],$this->idtabla,"",$imprimir);
return 1;
}

}

}
?>