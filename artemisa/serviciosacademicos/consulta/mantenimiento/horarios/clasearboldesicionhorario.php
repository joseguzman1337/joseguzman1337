<?php
class arbolDesicionHorario {

var $horarios; 
var $materiasinicial;
var $estadofinderama=0;
var $mejoresramas;
var $sumatendenciamanana=0;
var $sumatendenciatarde=0;
var $tendenciajornada=0;
var $tendenciavacio=0;
var $tiemporestriccionjornada=0;
var $vecesrestriccionjornada=0;

var $codigocarrera;
var $codigoperiodo;
var $codigojornada;
var $objetobase;
var $restringejornada;


function arbolDesicionHorario($estructurahorarios,$estructuradatosmateria,$codigocarrera,$codigoperiodo,$codigojornada,$objetobase){
	
	$this->horarios=$estructurahorarios;
	$this->materias=$estructuradatosmateria;
	$this->codigocarrera=$codigocarrera;
	$this->codigoperiodo=$codigoperiodo;
	$this->codigojornada=$codigojornada;
	$this->objetobase=$objetobase;
	
	
	$this->mejoresramas[0][0]=0;
	$this->mejoresramas[1][0]=0;
	$this->mejoresramas[2][0]=0;
	$this->mejoresramas[3][0]=0;
	$this->mejoresramas[4][0]=0;
	
}
function rastreoarbolhorarios(){

	$this->restriccionJornada();
	$rama[0]=0;

		foreach ($this->horarios as $materiai => $grupos){
			foreach ($grupos as $idgrupo => $obj){
				$materiasinicial[$materiai][$idgrupo]=1;
			}
		}
		$i=0;
		$estructuradatosmateria2=$this->materias;
		$tmpsemestremenor=9999999;
		foreach ($this->materias as $materiai => $datosmateria){
			
			foreach ($estructuradatosmateria2 as $materiai2 => $datosmateria2){
			if(trim($datosmateria2['prioridad'])<100){
			$datosmateria2['prioridad']=999;
			}
				if($tmpsemestremenor>$datosmateria2['prioridad']){
					$tmpsemestremenor=$datosmateria2['prioridad'];
					$tmpmateriamenor=$materiai2;
				}
			}
			unset($estructuradatosmateria2[$tmpmateriamenor]);
			$pilamaterias[$i]=$tmpmateriamenor;
			$i++;
			$tmpsemestremenor=9999999;

		}
		//echo "<br>";
		//print_r($pilamaterias);
		//echo "<br>";

		$cabezapila=$pilamaterias[0];
		array_shift($pilamaterias);
		foreach ($this->horarios as $materiai => $grupos){
			foreach ($grupos as $grupoi => $obj){
			//echo "MATERIA=$materiai, GRUPO=$grupoi<BR>";
				if($cabezapila==$materiai){
						$this->rastreomaterias($materiasinicial,$cabezapila,$grupoi,$rama,$pilamaterias,0);
						
				}
			}
		}
		

}

function insertaramaposicion($rama){
$posicion=0;
for($i=0;$i<count($this->mejoresramas);$i++)
	if($this->mejoresramas[$i][0]<=$rama[0]){
		//echo "ENTRA CELDA $posicion<BR>";
		$mejoresramas=InsertaCeldaPosicion($this->mejoresramas,$rama,$i);

		return $mejoresramas;
	}
return $this->mejoresramas;

}
function restriccionJornada(){

$condicion=" and sp.idcarreraperiodo=cp.idcarreraperiodo and
			cp.codigocarrera=".$this->codigocarrera." and
			cp.codigoperiodo=".$this->codigoperiodo." and 
			sp.idsubperiodo=cj.idsubperiodo and
			cj.codigocarrera=cp.codigocarrera and 
			cj.codigojornada=".$this->codigojornada." and
			dcj.idcobroexcedentecambiojornada=cj.idcobroexcedentecambiojornada";

$tablas="subperiodo sp,carreraperiodo cp,cobroexcedentecambiojornada cj,detallecobroexcedentecambiojornada dcj";
$resultado_jornada= $this->objetobase->recuperar_resultado_tabla($tablas,"cj.codigocarrera",$this->codigocarrera,$condicion,"",0);
$i=0;
while ($row = $resultado_jornada->fetchRow()){
$this->restringejornada[$i]['dia']=$row['codigodia'];
echo "--HORA INICIAL=";
echo $this->restringejornada[$i]['horainicial']=horaaminutos($row['horainiciodetallecobroexcedentecambiojornada'])+$row['codigodia']*10000;
echo "--HORA FINAL=";
echo $this->restringejornada[$i]['horafinal']=horaaminutos($row['horafinaldetallecobroexcedentecambiojornada'])+$row['codigodia']*10000;
echo "<br>";
$i++;
}

}
function restringeJornada($grupo,$materia){


		for($h=0;$h<count($this->horarios[$materia][$grupo]);$h++){
		
		$horainicial=$this->horarios[$materia][$grupo][$h]['horainicial'];
		$horafinal=$this->horarios[$materia][$grupo][$h]['horafinal'];
		$dia=$this->horarios[$materia][$grupo][$h]['dia'];

				if(is_array($this->restringejornada)){
						for($ir=0;$ir<count($this->restringejornada);$ir++){
							$horaioniciorestringida=$this->restringejornada[$ir]['horainicial'];
							$horafinalrestringida=$this->restringejornada[$ir]['horafinal'];

							if($this->restringejornada[$ir]['dia']==$dia){
								//echo " if(!this->horascruzadas($horaioniciorestringida,$horafinalrestringida,$horainicial,$horafinal)){<br>";
								if(!$this->horascruzadas($horaioniciorestringida,$horafinalrestringida,$horainicial,$horafinal)){
													//echo "HORA RESTRINGIDA POR JORNADA<br>";
													//echo "<h3>if(!this->horascruzadas(".$horaioniciorestringida.",".$horafinalrestringida.",".$horainicial.",".$horafinal.")){</h3>";
													return 1;
													//$this->tendenciajornada+=500;
								}
							}
						}
				}
		}
return 0;


}
function  cruceFechaHorario($grupo,$materia,$ramamateria,$ramagrupo,$rh,$h){

$fechainicio=$this->horarios[$materia][$grupo]['fechainiciogrupo'];
$fechafinal=$this->horarios[$materia][$grupo]['fechafinalgrupo'];

$fecharamainicio=$this->horarios[$ramamateria][$ramagrupo]['fechainiciogrupo'];
$fecharamafinal=$this->horarios[$ramamateria][$ramagrupo]['fechafinalgrupo'];

//echo "horascruzadas($fechainicio,$fechafinal,$fecharamainicio,$fecharamafinal)<br>";
if($this->horascruzadas($fechainicio,$fechafinal,$fecharamainicio,$fecharamafinal))
return 1;

return 0;



}
function  cruceDetalleFechaHorario($grupo,$materia,$ramamateria,$ramagrupo,$rh,$h){
			 
		 if(is_array($this->horarios[$materia][$grupo][$h]['detallehorario'])){
			 foreach($this->horarios[$materia][$grupo][$h]['detallehorario'] as $iddetallehorario => $datosdetalle){
				 if(is_array($this->horarios[$ramagrupo][$ramagrupo][$rh]['detallehorario'])){
					 foreach($this->horarios[$ramamateria][$ramagrupo][$rh]['detallehorario'] as $idramadetallehoario => $datosramadetalle){
					
						$fechadesdegrupo=$datosdetalle['fechadesde'];
						$fechahastagrupo=$datosdetalle['fechahasta'];
					
						$fecharamadesdegrupo=$datosramadetalle['fechadesde'];
						$fecharamahastagrupo=$datosramadetalle['fechahasta'];
						if($this->horascruzadas($fechadesdegrupo,$fechahastagrupo,$fecharamadesdegrupo,$fecharamahastagrupo))
							return 1;		
													
					}
				}
				else{
					return 1;
				}
			}
		}
		else{
			return 1;
		}
			
		return 0;
		

}

function  cruceHorasHorario($grupo,$materia,$ramahorainicial,$ramahorafinal,$h){
			//$ramahorainicial=horaaminutos($this->horarios[$ramamateria][$ramagrupo][$rh]['horainicial']);
			//$ramahorafinal=horaaminutos($this->horarios[$ramamateria][$ramagrupo][$rh]['horafinal']);
			//$ramadia=$this->horarios[$ramamateria][$ramagrupo][$rh]['dia'];
								
			//$horainicial=horaaminutos($this->horarios[$materia][$grupo][$h]['horainicial']);
			//$horafinal=horaaminutos($this->horarios[$materia][$grupo][$h]['horafinal']);
			//$dia=$this->horarios[$materia][$grupo][$h]['dia'];
								
			//$mediodia=horaaminutos("12:00:00");
			//$mañana=horaaminutos("05:00");
			//$tarde=horaaminutos("19:00");
			//if($ramadia==$dia){
				if($this->horascruzadas($ramahorainicial,$ramahorafinal,$this->horarios[$materia][$grupo][$h]['horainicial'],$this->horarios[$materia][$grupo][$h]['horafinal'])){
						return 1;
				}
			//}
		return 0;

}

function cruceHorario($grupo,$materia,$arrayramagrupo){

	if(is_array($arrayramagrupo['horarios']))
			foreach($arrayramagrupo['horarios'] as $ramahorainicial => $datosrama){
					//for($rh=0;$rh<count($this->horarios[$ramamateria][$ramagrupo]);$rh++){
						for($h=0;$h<count($this->horarios[$materia][$grupo]);$h++){
								
								if($this->cruceFechaHorario($grupo,$materia,$datosrama['ramamateria'],$datosrama['ramagrupo'],$rh,$h)){	
										 if($this->cruceHorasHorario($grupo,$materia,$ramahorainicial,$datosrama['horafinal'],$h)){
											if($this->cruceDetalleFechaHorario($grupo,$materia,$datosrama['ramamateria'],$datosrama['ramagrupo'],$rh,$h)){
												$cruce[0]=$datosrama['ramamateria'];
												$cruce[1]=$datosrama['ramagrupo'];
												return $cruce;
											}
										}
								}
																
						}
					//}
			}
			

	return 0;
}
function  horascruzadas ($horainicial1,$horafinal1,$horainicial2,$horafinal2){

if($horainicial1>=$horainicial2&&$horainicial1<$horafinal2)
return 1;

if($horafinal1>$horainicial2&&$horafinal1<=$horafinal2)
return 1;

if($horainicial2>=$horainicial1&&$horainicial2<$horafinal1)
return 1;

if($horafinal2>$horainicial1&&$horafinal2<=$horafinal1)
return 1;

return 0;
}
function  horascruzadasabierto ($horainicial1,$horafinal1,$horainicial2,$horafinal2){

if($horainicial1>=$horainicial2&&$horainicial1<=$horafinal2)
return 1;

if($horafinal1>=$horainicial2&&$horafinal1<=$horafinal2)
return 1;

if($horainicial2>=$horainicial1&&$horainicial2<=$horafinal1)
return 1;

if($horafinal2>=$horainicial1&&$horafinal2<=$horafinal1)
return 1;

return 0;
}
function rastreomaterias($vectorimateria,$materiai,$grupoi,$rama,$pilamaterias,$i){
$i++;
	$this->estadofinderama=0;

/*if($materiai==1873){
echo "AQUI SE BRINCA?<BR>";
	print_r($pilamaterias);
echo "<br>";
}*/

	if(!$this->horarios[$materiai][$grupoi]['cupolleno']){
			if($this->horariovacio($materiai,$grupoi)){
					if(!$this->cruceHorario($grupoi,$materiai,$rama)){				
						if(!$this->restringeJornada($grupoi,$materiai)){
							if(!is_array($this->horarios[$materiai][$grupoi][0]))
								$rama[0]-=10;
						$grupomateriai[$materiai]=$grupoi;
						$rama[1][$materiai]=$grupoi;
						$rama[0]+=1000;
						$rama[0]+=1000-$i*100;
							for($rh=0;$rh<count($this->horarios[$materiai][$grupoi]);$rh++){
								if(!empty($this->horarios[$materiai][$grupoi][$rh]['horainicial'])){
									$rama['horarios'][$this->horarios[$materiai][$grupoi][$rh]['horainicial']]['horafinal']=$this->horarios[$materiai][$grupoi][$rh]['horafinal'];
									$rama['horarios'][$this->horarios[$materiai][$grupoi][$rh]['horainicial']]['ramamateria']=$materiai;
									$rama['horarios'][$this->horarios[$materiai][$grupoi][$rh]['horainicial']]['ramagrupo']=$grupoi;
								}
							}

					}
					else{
						$rama[2][$materiai][$grupoi]=1;
						$rama[0]+=1;
						//Por fuera de la Jornada (Recargo)
					}

				}
				else{
					$rama[2][$materiai][$grupoi]=4;
					//Cruce de horarios Ver Articulo 41 Reglamento Estudiantil
				}

		}
		else
		{
			$rama[2][$materiai][$grupoi]=3;
			//Este grupo requiere horario, dirijase a su facultad para informarlo
		}
	}
	else
	{
		$rama[2][$materiai][$grupoi]=2;
		//Sin cupo Ver Articulo 41 Reglamento Estudiantil
	}
	

			$codigomateria=$pilamaterias[0];
			
			if(!empty($pilamaterias)){
				array_shift($pilamaterias);
				foreach ($vectorimateria[$codigomateria] as $codigogrupo=>$estado){
				//echo "$codigomateria - rastreomaterias($vectorimateria,$codigomateria,$codigogrupo,$rama,$pilamaterias,$i)";
				//print_r($pilamaterias);
				//echo "<br>";
				
						$this->rastreomaterias($vectorimateria,$codigomateria,$codigogrupo,$rama,$pilamaterias,$i);
				}
			}

			foreach ($vectorimateria as $codigomateria => $vectorgrupos)
			{
				if($codigomateria==$materiai){
					unset($vectorimateria[$codigomateria]);
				}
	
			}

	
	
	if(!$this->estadofinderama){
				$this->estadofinderama=1;
				$haydiferencia=1;
				for($j=0;$j<count($this->mejoresramas);$j++){
					if(is_array($this->mejoresramas[$j][1])&&is_array($rama[1])){
						$diferencia=array_diff($rama[1],$this->mejoresramas[$j][1]);
						if(empty($diferencia)){
							$haydiferencia=0;
						}		
					}
				}
				if($haydiferencia){
					$this->mejoresramas=$this->insertaramaposicion($rama);
				}
			$this->tendenciavacio=0;			
	}
	
}
function horariovacio($materiai,$grupoi)
{

	if(!is_array($this->horarios[$materiai][$grupoi][0])){
		if(ereg("^1+",$this->horarios[$materiai][$grupoi]['codigoindicadorhorario']))
		{
			//echo "<BR>ENCONTRO MATERIA $materiai CON GRUPO $grupoi VACIO DE HORARIOS  <BR>";
			return 0;
		}
	}
return 1;

}

}

?>