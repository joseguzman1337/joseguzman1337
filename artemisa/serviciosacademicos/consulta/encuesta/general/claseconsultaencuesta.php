<?php
class ConsultaEncuesta{

var $codigotipousuario;
var $objetobase;
var $arbolpreguntas;
var $titulospreguntas;
var $tipopregunta;
var $tmpencuesta;
var $encuesta;
var $tmppadrepregunta;
var $respuestausuariopregunta;
var $idusuario;
var $preguntasencuesta;
var $noterminado;
var $contadorpreguntas;

function consultaencuesta($tipousuario,$objetobase,$formulario){
$this->codigotipousuario=$tipousuario;
$this->objetobase=$objetobase;
$this->formulario=$formulario;

}

function consultaprimernivelpreguntas(){
$tabla="preguntatipousuario pt,tipopregunta tp, pregunta p";
$nombreidtabla="pt.codigotipousuario";
$idtabla=$this->codigotipousuario;
$condicion=" and pt.idpregunta=p.idpregunta and	
	tp.idtipopregunta=p.idtipopregunta and
	idpreguntagrupo = '0' and
	p.codigoestado like '1%' and
	pt.codigoestado like '1%'
	order by p.pesopregunta
	 ";

$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,",p.idpregunta codigopregunta",0);
while($row=$resultado->fetchRow()){
	


$tabla="encuestapregunta e";
$nombreidtabla=" e.idpregunta";
$idtabla=$row["codigopregunta"];
$condicion=" and e.codigoestado like '1%' ";
$resultadoencuesta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
$conencuesta=0;
while($rowencuesta=$resultadoencuesta->fetchRow()){
$tmparrayencuesta[]=$rowencuesta["idencuesta"];
}
	//if($conencuesta>0)
	//	unset($this->tmpencuesta);

	$tmprow[$row["codigopregunta"]]["nombre"]=$row["nombrepregunta"];
	$tmprow[$row["codigopregunta"]]["tipopregunta"]=$row["idtipopregunta"];
	$tmprow[$row["codigopregunta"]]["numeroopciones"]=$row["numeroopcionestipopregunta"];
	$tmprow[$row["codigopregunta"]]["menornombreopcion"]=$row["textoinicialtipopregunta"];
	
	$tmprow[$row["codigopregunta"]]["mayornombreopcion"]=$row["textofinaltipopregunta"];
	$tmprow[$row["codigopregunta"]]["idpreguntagrupo"]=$row["idpreguntagrupo"];
	$tmprow[$row["codigopregunta"]]["encuesta"]=$tmparrayencuesta;


	$this->arbolpreguntas[$row["codigopregunta"]]["nombre"]=$row["nombrepregunta"];
	$this->arbolpreguntas[$row["codigopregunta"]]["tipopregunta"]=$row["idtipopregunta"];
	$this->arbolpreguntas[$row["codigopregunta"]]["descripcionpregunta"]=$row["descripcionpregunta"];
	$this->arbolpreguntas[$row["codigopregunta"]]["numeroopciones"]=$row["numeroopcionestipopregunta"];
	$this->arbolpreguntas[$row["codigopregunta"]]["menornombreopcion"]=$row["textoinicialtipopregunta"];
	
	$this->arbolpreguntas[$row["codigopregunta"]]["mayornombreopcion"]=$row["textofinaltipopregunta"];
	$this->arbolpreguntas[$row["codigopregunta"]]["idpreguntagrupo"]=$row["idpreguntagrupo"];
	$this->arbolpreguntas[$row["codigopregunta"]]["encuesta"]=$row["idencuesta"];	
	//$this->arbolpreguntas=$tmprow;
	//$tmptitulospreguntas[]=$tmprow;
	//exit();
	
	$this->arbolpreguntas[$row["codigopregunta"]]["grupo"]=$this->recursivaarmaarbolarray($row["codigopregunta"]);
	
	//if(!is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))
		//unset($this->tmpencuesta);

	unset($tmpencuestas);
	if(is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))	
	foreach($this->arbolpreguntas[$row["codigopregunta"]]["grupo"] as $idpreguntahijo=>$arrayhijos){
		if(is_array($arrayhijos["encuesta"]))
			foreach($arrayhijos["encuesta"] as $tmpi=>$idencuesta)
				$tmpencuestas[$idencuesta]="1";	
	}
	$jtmp=0;
	if(is_array($tmpencuestas))	
	foreach($tmpencuestas as $idencuestatmp=>$valor){
		$this->arbolpreguntas[$row["codigopregunta"]]["encuesta"][$jtmp]=$idencuestatmp;
		$this->encuesta[$idencuestatmp][$row["codigopregunta"]]="1";
		$jtmp++;
	}

	}
	$this->titulospreguntas=$tmprow;
}

function recursivaarmaarbolarray($idpregunta){
$tabla="preguntatipousuario pt,tipopregunta tp, pregunta p";
$nombreidtabla="pt.codigotipousuario";
$idtabla=$this->codigotipousuario;
$condicion=" and pt.idpregunta=p.idpregunta and	
	tp.idtipopregunta=p.idtipopregunta and
	  idpreguntagrupo = '".$idpregunta."' and 
	p.codigoestado like '1%' and
	pt.codigoestado like '1%' 
	order by p.pesopregunta";
/*left join encuestapregunta ep on   ep.idpregunta=p.idpregunta
left join encuesta e on ep.idencuesta=e.idencuesta and '".date("Y-m-d")."'
 between e.fechainicioencuesta and fechafinalencuesta and e.codigoestado like '1%'*/


$resultadopregunta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,",p.idpregunta codigopregunta",0);
//echo "<br><br>";
//if(is_array($resultadopregunta)){

while($datospregunta = $resultadopregunta->fetchRow()){

$tabla="encuestapregunta e";
$nombreidtabla=" e.idpregunta";
$idtabla=$datospregunta["codigopregunta"];
$condicion=" and e.codigoestado like '1%' ";
$resultadoencuesta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
unset($tmparrayencuesta);
while($rowencuesta=$resultadoencuesta->fetchRow()){
$tmparrayencuesta[]=$rowencuesta["idencuesta"];

$conencuesta++;
}

$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["nombre"]=$datospregunta["nombrepregunta"];
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["tipopregunta"]=$datospregunta["idtipopregunta"];
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["descripcionpregunta"]=$datospregunta["descripcionpregunta"];

$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["numeroopciones"]=$datospregunta["numeroopcionestipopregunta"];
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["menornombreopcion"]=$datospregunta["textoinicialtipopregunta"];

$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["mayornombreopcion"]=$datospregunta["textofinaltipopregunta"];
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["idpreguntagrupo"]=$datospregunta["idpreguntagrupo"];
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["encuesta"]=$tmparrayencuesta;
$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"]=$this->recursivaarmaarbolarray($datospregunta["codigopregunta"]);

if(!is_array($tmparrayencuesta)){
unset($tmpencuestas);
	if(is_array($ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"]))	
	foreach($ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"] as $idpreguntahijo=>$arrayhijos){
		if(is_array($arrayhijos["encuesta"]))
			foreach($arrayhijos["encuesta"] as $tmpi=>$idencuesta)
				$tmpencuestas[$idencuesta]="1";	
	}
	$jtmp=0;
	if(is_array($tmpencuestas))	
	foreach($tmpencuestas as $idencuestatmp=>$valor){
		$ramaarbolpreguntas[$datospregunta["codigopregunta"]]["encuesta"][$jtmp]=$idencuestatmp;
		$this->encuesta[$idencuestatmp][$datospregunta["codigopregunta"]]="1";
		$jtmp++;
	}
}
else{
	foreach($tmparrayencuesta as $tmpi=>$idencuestatmp)
		$this->encuesta[$idencuestatmp][$datospregunta["codigopregunta"]]="1";
}	

//if(!is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))
	//	unset($this->tmpencuesta);

}
return $ramaarbolpreguntas;
//}


}

function recuperarpadrepreguntas(){

return $this->titulospreguntas;
}
function recuperarencuestapreguntas(){

$tabla="encuestapregunta ep,encuesta e,pregunta p";
$nombreidtabla="e.codigotipousuario";
$idtabla=$this->codigotipousuario;
$condicion=" and e.idencuesta= ep.idencuesta
	and ep.idpregunta=p.idpregunta	
	and ep.codigoestado like '1%'
	and e.codigoestado like '1%'
	and p.codigoestado like '1%'";
$resultadoencuesta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
unset($this->encuesta);

while($rowencuesta=$resultadoencuesta->fetchRow()){


$this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpregunta"]]="1";
$this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpreguntagrupo"]]="1";
$this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"],$rowencuesta["idencuesta"]);

}
return $this->encuesta;
}

function recursivorecuperarencuestapreguntas($idpregunta,$idencuesta){

$tabla="pregunta p";
$nombreidtabla="p.idpregunta";
$idtabla=$idpregunta;
$condicion="and idpreguntagrupo <> '0'
	    and	p.codigoestado like '1%'";
$resultadoencuesta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
//echo "<br>";
//unset($this->encuesta);

while($rowencuesta=$resultadoencuesta->fetchRow()){
	$this->encuesta[$idencuesta][$idpregunta]="1";
	$this->encuesta[$idencuesta][$rowencuesta["idpreguntagrupo"]]="1";
	$this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"],$idencuesta);
}

}


function recuperartitulosencuesta(){
$tabla="encuesta e";
$nombreidtabla="1";
$idtabla="1";
$condicion=" '".date("Y-m-d")."' between e.fechainicioencuesta and fechafinalencuesta 
	e.codigoestado like '1%' and
";
$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
while($row=$resultado->fetchRow()){
$this->tituloencuesta[]["nombreencuesta"]=$row["nombreencuesta"];
}

}
function recuperartipopregunta(){
	$tabla="tipopregunta t";
	$nombreidtabla="1";
	$idtabla="1";
	$condicion=" and t.codigoestado like '1%'";
	$resultado=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
	$i=0;
	while($row=$resultado->fetchRow()){
	$this->tipopregunta[$i]["nombretipopregunta"]=$row["nombretipopregunta"];
	$this->tipopregunta[$i]["idtipopregunta"]=$row["idtipopregunta"];
	$i++;
}
}

function recuperaidencuestapregunta($idpregunta,$idencuesta){
$tabla="encuestapregunta ep";
	$nombreidtabla="ep.idpregunta";
	$idtabla=$idpregunta;
	$condicion=" 	and ep.idencuesta=".$idencuesta."
			and ep.codigoestado like '1%'";

$datosrespuestapregunta=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);

return $datosrespuestapregunta["idencuestapregunta"];
}
function recuperarrespuestapreguntausuario($idusuario){

$this->idusuario=$idusuario;

$tabla="respuestadetalleencuestapregunta rp,encuesta e,encuestapregunta ep";
	$nombreidtabla="rp.idusuario";
	$idtabla=$idusuario;
	$condicion=" 	
			and e.idencuesta=ep.idencuesta
			and rp.idencuestapregunta=ep.idencuestapregunta
			and '".date("Y-m-d")."'
 			between e.fechainicioencuesta and fechafinalencuesta
			and e.codigoestado like '1%'
			and ep.codigoestado like '1%'
			and rp.codigoestado like '1%'
			group by ep.idpregunta";

$resultadorespuestapregunta=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,",ep.idpregunta pregunta,rp.valorrespuestadetalleencuestapregunta valor,ep.idencuesta encuesta",0);

$this->noterminado=0;
$i=0;
while($row=$resultadorespuestapregunta->fetchRow()){
$arraydatosrespuesta["idencuesta"]=$row["encuesta"];
$arraydatosrespuesta[$row["pregunta"]]=$row["valor"];

if(trim($row["valor"])=="")
$this->noterminado=1;
$i++;
}
if($i==0)
$this->noterminado=1;

$this->respuestausuariopregunta=$arraydatosrespuesta;
return $arraydatosrespuesta;
}
function muestraformularioasignapreguntas($ramapregunta,$idpregunta,$idencuesta="1"){

	unset($formulario->filatmp);

	$idpregunta=$idpregunta;
//echo "<br>TIPOPREGUNTA=";
	$opcionmenuidpregunta=$ramapregunta["tipopregunta"];
//echo "<br>";
	$idpreguntapadre=$ramapregunta["idpreguntagrupo"];
	unset($observacionpregunta);
 	$observacionpregunta=$ramapregunta["nombre"];
	unset($this->formulario->filatmp);

	if(ereg("^3.",$ramapregunta["tipopregunta"])){	


				
			

			$conboton=0;
			$parametrobotonenviar[$conboton]="'observacionpregunta".$idpregunta."','pregunta',60,2,'','','',''";
			$boton[$conboton]='memo';


			$cuentaencuesta=count($ramapregunta["encuesta"]);
			if($cuentaencuesta>0){
				$conboton++;				
				$parametrobotonenviar[$conboton]="'text','cuentaencuesta".$idpregunta."','".$cuentaencuesta."','size=2 readonly=true'";
				$boton[$conboton]='boton_tipo';
			}
			for($id=0;$id<count($this->tipopregunta);$id++){	
				$opcionparametrizacion=$this->tipopregunta[$id]["idtipopregunta"];
				$this->formulario->filatmp[$opcionparametrizacion]=$this->tipopregunta[$id]["nombretipopregunta"];
			}
			$conboton++;				
		
			$parametrobotonenviar[$conboton]="'menu".$idpregunta."','".$opcionmenuidpregunta."',''";
			$boton[$conboton]='menu_fila';
	
			

			$checked="";
			if(is_array($ramapregunta["encuesta"]))
				if(in_array($idencuesta,$ramapregunta["encuesta"])){
					$checked="checked";
					$conboton++;				
					$parametrobotonenviar[$conboton]="'hidden','preguntaschecadas[]','".$idpregunta."',''";
					$boton[$conboton]='boton_tipo';
				}			

			$conboton++;				
			$parametrobotonenviar[$conboton]="'checkbox','check".$idpregunta."','1','".$checked."'";
			$boton[$conboton]='boton_tipo';
	
			$conboton++;				
			$parametrobotonenviar[$conboton]="'text','padre".$idpregunta."','".$idpreguntapadre."','size=5'";
			$boton[$conboton]='boton_tipo';
			
			$conboton++;				
			$parametrobotonenviar[$conboton]="'hidden','preguntas[]','".$idpregunta."',''";
			$boton[$conboton]='boton_tipo';

			$this->formulario->dibujar_campos($boton,$parametrobotonenviar,$idpregunta,"labelresaltado",'observacionpregunta','');
			$this->formulario->cambiar_valor_campo('observacionpregunta'.$idpregunta,$observacionpregunta);
	
	}


	if(ereg("^1.",$ramapregunta["tipopregunta"])){	


			$conboton=0;
			$parametrobotonenviar[$conboton]="'observacionpregunta".$idpregunta."','pregunta',60,2,'','','',''";
			$boton[$conboton]='memo';

			$cuentaencuesta=count($ramapregunta["encuesta"]);
			if($cuentaencuesta>0){
				$conboton++;				
				$parametrobotonenviar[$conboton]="'text','cuentaencuesta".$idpregunta."','".$cuentaencuesta."','size=2 readonly=true'";
				$boton[$conboton]='boton_tipo';
			}

			for($id=0;$id<count($this->tipopregunta);$id++){	
				$opcionparametrizacion=$this->tipopregunta[$id]["idtipopregunta"];
				$this->formulario->filatmp[$opcionparametrizacion]=$this->tipopregunta[$id]["nombretipopregunta"];
			}
			$conboton++;				
		
			$parametrobotonenviar[$conboton]="'menu".$idpregunta."','".$opcionmenuidpregunta."',''";
			$boton[$conboton]='menu_fila';

			$checked="";

			if(is_array($ramapregunta["encuesta"]))
				if(in_array($idencuesta,$ramapregunta["encuesta"])){
					$checked="checked";
					$conboton++;				
					$parametrobotonenviar[$conboton]="'hidden','preguntaschecadas[]','".$idpregunta."',''";
					$boton[$conboton]='boton_tipo';
						
				}
			/*$conboton++;				
			$parametrobotonenviar[$conboton]="'checkbox','check".$idpregunta."','1','".$checked."'";
			$boton[$conboton]='boton_tipo';*/
	
		$conboton++;				
			$parametrobotonenviar[$conboton]="'text','padre".$idpregunta."','".$idpreguntapadre."','size=5'";
			$boton[$conboton]='boton_tipo';
	
			$conboton++;				
			$parametrobotonenviar[$conboton]="'hidden','preguntas[]','".$idpregunta."',''";
			$boton[$conboton]='boton_tipo';

			$this->formulario->dibujar_campos($boton,$parametrobotonenviar,$idpregunta,"tdtitulogris",'observacionpregunta','');
			$this->formulario->cambiar_valor_campo('observacionpregunta'.$idpregunta,$observacionpregunta);
	
	}

	if(is_array($ramapregunta["grupo"]))
	foreach($ramapregunta["grupo"] as $llave=>$grupo){
		
	$this->muestraformularioasignapreguntas($grupo,$llave,$idencuesta);
	
	
	}


}
function recuperaobjetoformulario(){
return $this->formulario;
}

function muestraformulariopreguntas($ramapregunta,$idpregunta,$encuesta,$idencuesta){

/*echo "$idpregunta,$encuesta ENCUESTA<pre>";
print_r($encuesta);
echo "</pre>";*/

	if(in_array($idpregunta,$encuesta)){

/*echo "tipopregunta=".$ramapregunta["tipopregunta"]." RAMAPREGUNTA<pre>";
print_r($ramapregunta);
echo "</pre>";*/
		$valorpregunta=$this->respuestausuariopregunta[$idpregunta];
		
		unset($this->formulario->filatmp);
		if($ramapregunta["tipopregunta"]=="101"){
			$this->formulario->dibujar_fila_titulo($ramapregunta["nombre"],'tdtitulosubgrupoencuesta',"2","align='left'","td");
			if(isset($ramapregunta["descripcionpregunta"])&&trim($ramapregunta["descripcionpregunta"])!='')
				$this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"],'tdtituloencuestadescripcion',"2","align='left'","td");
		}
		
		if($ramapregunta["tipopregunta"]=="100"){
			$this->formulario->dibujar_fila_titulo($ramapregunta["nombre"],'tdtituloencuesta',"2","align='center'","td");
			if(isset($ramapregunta["descripcionpregunta"])&&trim($ramapregunta["descripcionpregunta"])!='')
				$this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"],'tdtituloencuestadescripcion',"2","align='left'","td");
		}
		if(ereg("^3.",$ramapregunta["tipopregunta"])){
			$this->preguntasencuesta[]=$idpregunta;
			$this->contadorpreguntas++;
			$opcionparametrizacion="1";
			$this->formulario->filatmp[$opcionparametrizacion]=$ramapregunta["menornombreopcion"];
			for($i=2;$i<$ramapregunta["numeroopciones"];$i++){	
					$opcionparametrizacion=$i;
					$this->formulario->filatmp[$opcionparametrizacion]="";
			}
			$opcionparametrizacion=$ramapregunta["numeroopciones"];
			$this->formulario->filatmp[$opcionparametrizacion]=$ramapregunta["mayornombreopcion"];

			$javascript="enviarrespuesta(this,".$idpregunta.",".$this->idusuario.",".$idencuesta.")";
					$menu='radio_fila'; $parametros="'".$idpregunta."','".$valorpregunta."','onclick=\'return ".$javascript."\''";
					$this->formulario->dibujar_campo($menu,$parametros,$this->contadorpreguntas.") ".$ramapregunta["nombre"],"tdtitulogris",$idpregunta,'requerido');
						$conboton++;				
			echo "<input type='hidden' name='preguntas[]' value='".$idpregunta."' />";
				
		}
		if(ereg("^2.",$ramapregunta["tipopregunta"])){
			$this->contadorpreguntas++;
			$conboton=0;
			$parametrobotonenviar[$conboton]="'".$idpregunta."','pregunta',30,3,'','','',''";
			$boton[$conboton]='memo';
			$requerido="requerido";
			if($ramapregunta["tipopregunta"]=='201'){
				$requerido="";
				if($valorpregunta=='')
				$valorpregunta=" ";
			 }

			$this->formulario->dibujar_campos($boton,$parametrobotonenviar,$this->contadorpreguntas.") ".$ramapregunta["nombre"],"tdtitulogris",$idpregunta,$requerido,"0");
			$this->formulario->cambiar_valor_campo($idpregunta,$valorpregunta);
			echo "<input type='hidden' name='preguntas[]' value='".$idpregunta."' />";

		}

	
		if(is_array($ramapregunta["grupo"]))
			foreach($ramapregunta["grupo"] as $llave=>$grupo){	
				$this->muestraformulariopreguntas($ramapregunta["grupo"][$llave],$llave,$encuesta,$idencuesta);
			}
	}
}	

}
?>