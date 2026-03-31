<?php
/**
 * Description of ArregloTablaEstadistico
 *
 * @author javeeto
 */
class VistaTablaEstadistico{
	var $anchocelda;
	var $altocelda;
	var $arrayhorizontal;
	var $arrayvertical;
	var $estilofila;
	var $estilocolumna;
	var $estilotabla;
	var $indicecolumnas;
	var $indicefilas;
	var $arrayfilas;
	var $arraycolumnas;
	var $muestratotales;
	var $colorgeneral;
	var $colorfacultad;
	var $colorarea;
	var $colornivel;
	var $colorcarrera;
	var $cadenas;

	function VistaTablaEstadistico($anchocelda,$altocelda,$estilocolumna="",$estilofila="",$estilotabla=""){
		$this->anchocelda=$anchocelda;
		$this->altocelda=$altocelda;
		$this->estilocolumna=$estilocolumna;
		$this->estilofila=$estilofila;
		$this->estilotabla=$estilotabla;
		$this->muestratotales=1;
	}
	function setArrayVertical($arrayvertical){
		$this->indicefilas=0;
		unset($this->arrayfilas);
		$this->arrayvertical=$arrayvertical;
	}
	function setArrayHorizontal($arrayhorizontal){
		$this->indicecolumnas=0;
		unset($this->arraycolumnas);
		$this->arrayhorizontal=$arrayhorizontal;
	}
	function setArrayAreaPrincipal($arrayarea){
		$this->arrayareaprincipal=$arrayarea;

	}
	function setMuestraTotales($muestratotales){
		$this->muestratotales=$muestratotales;
	}
	function setColorGeneral($colorgeneral){
		$this->colorgeneral=$colorgeneral;
	}
	function setColorFacultad($colorfacultad){
		$this->colorfacultad=$colorfacultad;
	}
	function setColorArea($colorarea){
		$this->colorarea=$colorarea;
	}
	function setColorNivel($colornivel){
		$this->colornivel=$colornivel;
	}
	function setColorCarrera($colorcarrera){
		$this->colorcarrera=$colorcarrera;
	}

	function tablaVertical(){
		echo "<table ".$this->estilotabla.">";
		echo $this->recursivoTablaVertical($this->arrayvertical,0);
		echo "</table>";
	}
	function recursivoTablaVertical($arrayvertical,$nivel,$nombrenivel=""){
		$nivel++;
		if(is_array($arrayvertical)){			
			if($nivel>1){
				$this->indicefilas++;
				$this->arrayfilas[$this->indicefilas]="";
			}
			if($this->muestratotales){
				switch($nivel)
				{
					/*case 1:
					$nombretotal="Total General ".$nombrenivel;
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna." colspan='5' height='".$this->altocelda."'>".$nombretotal." $nivel</td></tr>";
					break;*/
	
					case 2:
					$nombretotal="Total General";
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='4'  height='".$this->altocelda."'><table  class='estilototalgeneral' width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'><tr><td>".$nombretotal." ".$arrayvertical["total"]."</td></tr></table></td></tr>";
					break;
	
					case 3:
					$nombretotal="Total Area ".$nombrenivel;
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='3'  height='".$this->altocelda."' ><table class='estilototalarea' width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'><tr><td>".$nombretotal." ".$arrayvertical["total"]."</td></tr></table></td></tr>";
					break;
	
					case 4:
					$nombretotal="Total ".$nombrenivel;
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='2'  height='".$this->altocelda."'><table class='estilototalfacultad' width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'><tr><td>".$nombretotal." ".$arrayvertical["total"]."</td></tr></table></td></tr>";
					break;
	
					case 5:
					$nombretotal="Total ".$nombrenivel."";
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna."    height='".$this->altocelda."'><table  class='estilototalmodalidad' width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'><tr><td>".$nombretotal." ".$arrayvertical["total"]."</td></tr></table></td></tr>";
					break;
	
					default:
						$nombretotal="";
					break;
				}
				if($nombretotal!=""){
					$this->indicefilas++;
					$this->arrayfilas[$this->indicefilas]=$nombretotal;
				}

			}
			//if($nivel!=5){

			//}
			$estilotablatmp=$this->estilotabla;			
			
			foreach($arrayvertical as $llave=>$arrayrecursivo){
				if($arrayrecursivo["total"]>0){
					if(!isset($arrayrecursivo["fin"])&&$llave!="total"){
						
						$cadena .= "<tr>
						<td width='".$this->anchocelda."' ".$this->estilocolumna.">
						".$llave."
						</td>
						<td '".$this->anchocelda."' ".$this->estilocolumna.">
							<table ".$estilotablatmp."  >
							".$this->recursivoTablaVertical($arrayrecursivo,$nivel,$llave)."
							</table>
						</td>
						</tr>";
	
					}
					else{
						if($llave!="total"){
						$this->indicefilas++;
						$this->arrayfilas[$this->indicefilas]=$llave;
						}
						if($llave!="total")
						{
							$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna." height='".$this->altocelda."'>".$arrayrecursivo["total"]." ".substr(ucwords(strtolower($llave)),0,28)."</td></tr>";	
						}
								
					}
				}

			}
				

		
		}
		return $cadena;	

	}
	function tablaVerticalEx(){
		$this->muestratotales=1;
		$retornorecursivo=$this->recursivoTablaVerticalEx($this->arrayvertical,0);
		$cadena .= "<table ".$this->estilotabla.">";
		$cadena .= "<tr>";
		$cadena .= $retornorecursivo["cadena"];
		$cadena .= "</table>";
		return $cadena;
	}
	function recursivoTablaVerticalEx($arrayvertical,$nivel,$nombrenivel=""){
		$nivel++;
		$rowspan=0;
		if(is_array($arrayvertical)){			
			if($nivel>1){
			//	$this->indicefilas++;
			//	$this->arrayfilas[$this->indicefilas]="";
			}
			/*if($this->muestratotales){
				switch($nivel)
				{
					/*case 1:
					$nombretotal="Total General ".$nombrenivel;
					$cadena .= "<tr><td  width ='".$this->anchocelda."' ".$this->estilocolumna." colspan='5' height='".$this->altocelda."'>".$nombretotal." $nivel</td></tr>";
					break;*/

			/*		case 2:
					$nombretotal="Total General";
					$cadena .= "<td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='4'  height='".$this->altocelda."' bgcolor='".$this->colorgeneral."'>".$nombretotal." ".$arrayvertical["total"]."</td></tr><tr>";
					$rowspan++;	
					break;
	
					case 3:
					$nombretotal="Total Area ".$nombrenivel;
					$cadena .= "<td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='3'  height='".$this->altocelda."' bgcolor='".$this->colorarea."' >".$nombretotal." ".$arrayvertical["total"]."</td></tr><tr>";
					$rowspan++;
					break;
	
					case 4:
					$nombretotal="Total ".$nombrenivel;
					$cadena .= "<td  width ='".$this->anchocelda."' ".$this->estilocolumna."  colspan='2'  height='".$this->altocelda."' bgcolor='".$this->colorfacultad."'>".$nombretotal." ".$arrayvertical["total"]."</td></tr><tr>";
					$rowspan++;
					break;
	
					case 5:
					$nombretotal="Total ".$nombrenivel."";
					$cadena .= "<td  width ='".$this->anchocelda."' ".$this->estilocolumna."    height='".$this->altocelda."' bgcolor='".$this->colornivel."'>".$nombretotal." ".$arrayvertical["total"]."</td></tr><tr>";
					$rowspan++;
					break;
	
					default:
						$nombretotal="";
					break;
				}
				if($nombretotal!=""){
					$this->indicefilas++;
					$this->arrayfilas[$this->indicefilas]=$nombretotal;
				}

			}*/
			//if($nivel!=5){

			//}
			$estilotablatmp=$this->estilotabla;			
			
			$hijos=0;
			
			foreach($arrayvertical as $llave=>$arrayrecursivo){
				//if($arrayrecursivo["total"]>0){

					$retornorecursivo=$this->recursivoTablaVerticalEx($arrayrecursivo,$nivel,$llave);
					
					if(!isset($arrayrecursivo["fin"])&&$llave!="total"){

												
						$muestrarowspan=$retornorecursivo["rowspan"];
						$cadena .= "
						<td width='".$this->anchocelda."' ".$this->estilocolumna." rowspan='".$muestrarowspan."'>
						".$llave."
						</td>
						".$retornorecursivo["cadena"]."";

						//echo $rowspan."-".$llave."<br>";
						$rowspan+=$retornorecursivo["rowspan"];	
			
						$hijos++;
					}
					else{
						if($llave!="total"&&$llave!="fin"){
						$this->indicefilas++;
						$this->arrayfilas[$this->indicefilas]=$llave;
						}
						if($llave!="total")
						{
							$cadena .= "<td  width ='".$this->anchocelda."' ".$this->estilocolumna." height='".$this->altocelda."'>".$arrayrecursivo["total"]." ".substr(ucwords($llave),0,100)."</td>";
							$cadena .= "</tr>";
							$cadena .= "<tr>";
							$rowspan++;
							
							//echo $rowspan."-".$llave."<br>";
							$hijos++;
						}
								
					}
					
					
				//}

			}
			
				

		
		}
		$retornoarray["rowspan"]=$rowspan;
		$retornoarray["cadena"]=$cadena;
		$retornoarray["hijos"]=$hijos;

		return $retornoarray;	

	}

	function tablaHorizontal($anchotabla=""){
		echo "<table ".$this->estilotabla." ".$anchotabla.">";
		echo "<tr><td align='left'>";	
		echo "<table ".$this->estilotabla.">";
		echo $this->recursivoTablaHorizontal($this->arrayhorizontal,0);
		echo "</table>";
		echo "</td></tr>";
		echo "</table>";
		/*echo "<pre>";
		print_r($this->arrayhorizontal);
		echo "</pre>";*/
	}
	function recursivoTablaHorizontal($arrayhorizontal,$nivel){

		if(is_array($arrayhorizontal)){			
		$this->indicecolumnas++;
		$this->arraycolumnas[$this->indicecolumnas]="";
			$estilotablatmp=$this->estilotabla;	
			$cadena .= "<tr>";
			foreach($arrayhorizontal as $llave=>$arrayrecursivo)
			{
				if(is_array($arrayrecursivo)){
					$cadena .= "<td ".$this->estilocolumna." height='".$this->altocelda."' align='center' >".$llave."</td>";
				}
				else
				{
					$this->indicecolumnas++;
					$this->arraycolumnas[$this->indicecolumnas]=$llave;
					$cadena .= "<td width ='".$this->anchocelda."' ".$this->estilocolumna." height='".$this->altocelda."'>".$llave."</td>";

				}
			}		
			$cadena .= "</tr>";
			$cadena .= "<tr>";
			foreach($arrayhorizontal as $llave=>$arrayrecursivo)
			{
				if(is_array($arrayrecursivo)){
					$cadena	.= "<td ".$this->estilocolumna."><table ".$estilotablatmp."  >".$this->recursivoTablaHorizontal($arrayrecursivo,$nivel++)."</table></td>";
				}
				else
				{
					$cadena	.= "<td ".$this->estilocolumna."   width ='".$this->anchocelda."' ><table ".$estilotablatmp."  >".$this->recursivoTablaHorizontal($arrayrecursivo,$nivel++)."</table></td>";
				}

			}
			$cadena .= "</tr>";
		}
		return $cadena;
	}
	function tablaHorizontalEx($anchotabla="",$columnasex){
		//echo "<table ".$this->estilotabla." ".$anchotabla.">";
		//echo "<tr><td align='left'>";	
		unset($this->arraycolumnas);
		$this->indicecolumnas=0;
		$cadena .= "<table ".$this->estilotabla." >";
		unset($this->cadenas);
		$retornorecursivo= $this->recursivoTablaHorizontalEx($this->arrayhorizontal,0,1,$columnasex);

		for($i=0;$i<=count($this->cadenas);$i++){
			$cadena .= "<tr>".$this->cadenas[$i]."</tr>";
		}
		$cadena .= "</table>";
		return $cadena;

	}
	function recursivoTablaHorizontalEx($arrayhorizontal,$nivel,$finalrecursivo=0,$columnasex){
			$nivel++;
		if(is_array($arrayhorizontal)){			
		//$this->indicecolumnas++;
		//$this->arraycolumnas[$this->indicecolumnas]="";
			$estilotablatmp=$this->estilotabla;

			//if($finalrecursivo)	

			foreach($arrayhorizontal as $llave=>$arrayrecursivo)
			{	

				if(is_array($arrayrecursivo)){

					$retornorecursivo=$this->recursivoTablaHorizontalEx($arrayrecursivo,$nivel,0,$columnasex);
					$cadenatmp.=$retornorecursivo["cadena"];
					
					$this->cadenas[$nivel] .= "<td ".$this->estilocolumna." height='".$this->altocelda."' align='center' colspan='".$retornorecursivo["colspan"]."' >".$llave."</td>";
					$colspan+=$retornorecursivo["colspan"];

					//echo "<br>".$nivel."-".$llave;
				}
				else
				{
					$this->indicecolumnas++;
					$this->arraycolumnas[$this->indicecolumnas]=$llave;
					$this->cadenas[$nivel] .= "<td width ='".$this->anchocelda."' ".$this->estilocolumna." height='".$this->altocelda."' colspan='".$columnasex."'>".$llave."</td>";
					//echo "<br>".$nivel."-".$llave;
					$colspan+=$columnasex;
					
				}
				//$i++;
				//

				
			}

			
			//if($finalrecursivo&&$final)	
			//$cadena .= "\n</tr>";	
			//$cadena .= "</tr>";
			//$cadena .= "\n<tr>";
				

		}
		$retornoarray["colspan"]=$colspan;
		//echo "<br>";
		//$retornoarray["cadena"]=$cadena;

		return $retornoarray;
	}

	function tablaAreaPrincipal(){
		echo "<table ".$this->estilotabla.">";
		echo $this->recursivoTablaPrincipal($this->arrayareaprincipal,0);
		echo "</table>";
	}
	function recursivoTablaPrincipal($arrayarea,$nivel){
		/*echo "arrayfilas<pre>";
		print_r($this->arrayfilas);
		echo "</pre>";	
		echo "arraycolumnas<pre>";
		print_r($this->arraycolumnas);
		echo "</pre>";	*/

		foreach($this->arrayfilas as $llavefila=>$fila){
			if($fila=="")
			{
				$cadena.="<tr>";
				foreach($this->arraycolumnas as $llavecolumna=>$columna){
					$cadena.="<td ".$this->estilocolumna."></td>";
				}
				$cadena.="</tr>";
			}
			else{
				$cadena.="<tr>";
				foreach($this->arraycolumnas as $llavecolumna=>$columna){
					if($columna==""){
						$cadena.="<td ".$this->estilocolumna."></td>";
					}
					else
					{
						$cadena.="<td ".$this->estilocolumna."   width ='".$this->anchocelda."' height='".$this->altocelda."'>".$arrayarea[$fila][$columna]."</td>";
					}
				}
				$cadena.="</tr>";
			}
		}
		return $cadena;
	}
	function tablaAreaPrincipalEx($exportar=0){
		$cadena .= "<table ".$this->estilotabla.">";
		$cadena .= $this->recursivoTablaPrincipalEx($this->arrayareaprincipal,0,$exportar);
		$cadena .= "</table>";
		return $cadena;
	}
	function recursivoTablaPrincipalEx($arrayarea,$nivel,$exportar=0){
		/*echo "arrayfilas<pre>";
		print_r($this->arrayfilas);
		echo "</pre>";	
		echo "arraycolumnas<pre>";
		print_r($this->arraycolumnas);
		echo "</pre>";	*/

		foreach($this->arrayfilas as $llavefila=>$fila){
			if($fila=="")
			{
				/*$cadena.="<tr>";
				foreach($this->arraycolumnas as $llavecolumna=>$columna){
					$cadena.="<td ".$this->estilocolumna."></td>";
				}
				$cadena.="</tr>";*/
			}
			else{
				$cadena.="<tr>";
				foreach($this->arraycolumnas as $llavecolumna=>$columna){
					//echo "<br>$fila][$columna";
					if($columna==""){
						//$cadena.="<td ".$this->estilocolumna."></td>";
					}
					else
					{
						if(isset($this->$arrayarea[$fila][$columna]["estilo"]))
						$color=$this->$arrayarea[$fila][$columna]["estilo"];
						if($exportar){
							$cadena.="<td  width ='".($this->anchocelda)."' height='".$this->altocelda."' bgcolor='".$color."' 	".$this->estilocolumna."><table border='1' cellpadding='0' cellspacing='0'><td >".$arrayarea[$fila][$columna]["valor"]."</td></table></td>";
							//width='40'<td> ".$arrayarea[$fila][$columna]["porcentaje"]."</td>
						}
						else{
						$cadena.="<td  width ='".($this->anchocelda)."' height='".$this->altocelda."' bgcolor='".$color."' 	".$this->estilocolumna."><table border='0' cellpadding='0' cellspacing='0'><td >".$arrayarea[$fila][$columna]["valor"]."</td></table></td>";
						//width='40'<td> ".$arrayarea[$fila][$columna]["porcentaje"]."</td>
						}
					}
				}
				$cadena.="</tr>";
			}
		}
		return $cadena;
	}

}