<?php

class CacheIndicadores{
var $codigomodalidadacademicasic;
var $codigocarrera;
var $codigofacultad;
var $codigoareadisciplinar;
var $codigoperiodo;
var $objetobase;

	function CacheIndicadores($codigoperiodo,$objetobase){
		$this->codigoperiodo=$codigoperiodo;
		$this->objetobase=$objetobase;

	}
	function setCarreraOpciones($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$this->codigomodalidadacademicasic=$codigomodalidadacademicasic;
		$this->codigocarrera=$codigocarrera;
		$this->codigofacultad=$codigofacultad;
		$this->codigoareadisciplinar=$codigoareadisciplinar;		
	}
	/*Consulta el indicador en la fecha actual con respecto al titulo*/
	function consultaCacheIndicador($titulo){

		$tabla="cacheindicadores c,tipocacheindicadores tc,detallecacheindicadores dc";
		$nombreidtabla="c.codigoestado";
		$idtabla="100";
		$condicion=" and c.idtipocacheindicadores=tc.idtipocacheindicadores and dc.idcacheindicadores=c.idcacheindicadores and tc.nombretipocacheindicadores = '".$titulo."'
		and c.codigomodalidadacademicasic='".$this->codigomodalidadacademicasic."'
		and c.codigocarrera='".$this->codigocarrera."'
		and c.codigofacultad='".$this->codigofacultad."'
		and c.codigoperiodo='".$this->codigoperiodo."'
		and c.codigoareadisciplinar='".$this->codigoareadisciplinar."'
		and c.fechacacheindicadores='".date("Y-m-d")."'
		 order by tc.pesotipocacheindicadores";
		$resultadocache=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);
		//echo "<br>";
		$i=0;
		while($rowcache=$resultadocache->fetchRow())
		{
			$arrayinterno["total"][$titulo][$rowcache["nombredetallecacheindicadores"]]=$rowcache["valordetallecacheindicadores"];
			$i++;
		}
		if($i>0)
		{
			
			return $arrayinterno;
		}
		else
		{
			return 0;
		}

	}
	function insertarCacheIndicador($arrayindicador)
	{
		if(is_array($arrayindicador["total"]))
		foreach($arrayindicador["total"] as $titulo => $arraydetalleindica)
		{
			if($datostipocache=$this->objetobase->recuperar_datos_tabla("tipocacheindicadores","nombretipocacheindicadores",$titulo,"","",0)){
				$filacachein["idtipocacheindicadores"]=$datostipocache["idtipocacheindicadores"];
			}
			else
			{
				$tablatipocache="tipocacheindicadores";
				$filatipocachein["nombretipocacheindicadores"]=$titulo;
				$filatipocachein["pesotipocacheindicadores"]=0;
				$filatipocachein["codigoestado"]='100';
				$condicionactualizatipocache=" nombretipocacheindicadores='".$titulo."'";
				$this->objetobase->insertar_fila_bd($tablatipocache,$filatipocachein,0,$condicionactualizatipocache);
				$datostipocache=$this->objetobase->recuperar_datos_tabla("tipocacheindicadores","nombretipocacheindicadores",$titulo,"","",0);
				$filacachein["idtipocacheindicadores"]=$datostipocache["idtipocacheindicadores"];
			}
			
			$tablacache="cacheindicadores";
			$filacachein["codigoareadisciplinar"]=$this->codigoareadisciplinar;
			$filacachein["codigofacultad"]=$this->codigofacultad;
			$filacachein["codigocarrera"]=$this->codigocarrera;
			$filacachein["codigomodalidadacademicasic"]=$this->codigomodalidadacademicasic;
			$filacachein["codigoperiodo"]=$this->codigoperiodo;
			$filacachein["fechacacheindicadores"]=date("Y-m-d");
			$filacachein["codigoestado"]="100";
			$condicionactualizacache=" idtipocacheindicadores='".$filacachein["idtipocacheindicadores"]."'
			and codigofacultad='".$filacachein["codigofacultad"]."'
			and codigocarrera='".$filacachein["codigocarrera"]."'
			and codigomodalidadacademicasic='".$filacachein["codigomodalidadacademicasic"]."'
			and codigoperiodo='".$filacachein["codigoperiodo"]."'
			and fechacacheindicadores='".$filacachein["fechacacheindicadores"]."'
			and idtipocacheindicadores='".$filacachein["idtipocacheindicadores"]."'";
			$this->objetobase->insertar_fila_bd($tablacache,$filacachein,0,$condicionactualizacache);
			
			$datoscache=$this->objetobase->recuperar_datos_tabla("cacheindicadores","codigoestado","100"," and ".$condicionactualizacache,"",0);
			foreach($arraydetalleindica as $llave=>$valor)
			{
				$tabladetallecache="detallecacheindicadores";
				$filadetallecache["idcacheindicadores"]=$datoscache["idcacheindicadores"];
				$filadetallecache["valordetallecacheindicadores"]=$valor;
				$filadetallecache["nombredetallecacheindicadores"]=$llave;
				$filadetallecache["codigoestado"]="100";	
				$condicionactualizadetallecache="
		idcacheindicadores='".$filadetallecache["idcacheindicadores"]."'
		and valordetallecacheindicadores='".$filadetallecache["valordetallecacheindicadores"]."'
		and nombredetallecacheindicadores='".$filadetallecache["nombredetallecacheindicadores"]."'";
				//echo "<pre>";
				//print_r($filadetallecache);
				
				$this->objetobase->insertar_fila_bd($tabladetallecache,$filadetallecache,0,$condicionactualizadetallecache);
				//echo "</pre>";

				
			}
			
		}
	}
}

?>