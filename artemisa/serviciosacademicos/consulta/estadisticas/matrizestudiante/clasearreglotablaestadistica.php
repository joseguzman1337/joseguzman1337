<?php
/**
 * Description of ArregloTablaEstadistico
 *
 * @author javeeto
 */
class ArregloTablaEstadistico{

	var $objestadistico;
	var $tipoestadistico;
	var $tituloprincipal;
	var $arrayopciones;	
	var $arraycampos;
	var $arraytotalescolumnas;	
	var $estructuracolumna;	
	var $arraytotalescolumnasparcial;
	var $totalesvertical;
	var $mostrarporcentajes;
	var $arrayarea;
	var $arraysintotalmodalidad;
	var $arraysintotalfacultad;
	var $arraysintotalarea;
	var $arraysintotalgeneral;

	function ArregloTablaEstadistico($objestadistico,$tipoestadistico,$arraycampos,$tituloprincipal=""){
		$this->objestadistico=$objestadistico;
		$this->tipoestadistico=$tipoestadistico;
		$this->arraycampos=$arraycampos;
		//echo "ARRAY CAMPOS<pre>".print_r($arraycampos)."</pre>";
		if($tituloprincipal==""){
			$this->tituloprincipal="MATRIZ DE INFORMACIÓN ESTADÍSTICA I";
		}
		else
		{
		 $this->tituloprincipal=$tituloprincipal;
		}
		$this->mostrarporcentajes=1;
	}
	function setMostrarPorcentajes($mostrarporcentajes){
		$this->mostrarporcentajes=$mostrarporcentajes;
	}
	function setArrayOpciones($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
	
		$this->arrayopciones["codigomodalidadacademicasic"]=$codigomodalidadacademicasic;
		$this->arrayopciones["codigocarrera"]=$codigocarrera;
		$this->arrayopciones["codigofacultad"]=$codigofacultad;
		$this->arrayopciones["codigoareadisciplinar"]=$codigoareadisciplinar;

	}
	function setArraySinTotalModalidad($arraysintotalmodalidad){
		$this->arraysintotalmodalidad=$arraysintotalmodalidad;
	}
	function setArraySinTotalFacultad($arraysintotalfacultad){
		$this->arraysintotalfacultad=$arraysintotalfacultad;
	}
	function setArraySinTotalGeneral($arraysintotalgeneral){
		$this->arraysintotalgeneral=$arraysintotalgeneral;
	}
	function setArraySinTotalArea($arraysintotalarea){
		$this->arraysintotalarea=$arraysintotalarea;
	}
	function setArraySinTotales($arraysintotales){
		$this->arraysintotalmodalidad=$arraysintotales;
		$this->arraysintotalfacultad=$arraysintotales;
		$this->arraysintotalgeneral=$arraysintotales;
		$this->arraysintotalarea=$arraysintotales;
	}
	
	function horizontalTituloArea(){
		$estructuramuestran1["TOTAL ".strtoupper($tipoestadistico)]=1;
		$estructuramuestran1["AREA DISCIPLINAR"]=1;
		$estructuramuestran1["FACULTAD"]=1;
		$estructuramuestran1["NIVEL"]=1;
		$estructuramuestran1["PROGRAMA"]=1;
		$estructuramuestra[$this->tituloprincipal]=$estructuramuestran1;
		return $estructuramuestra;
	}
	
	function horizontalArea(){

		$estmuestran3["¿QUÍENES SON?"]["rangoEstrato"]="ESTRATO AL QUE PERTENECE";
		$estmuestran3["¿QUÍENES SON?"]["rangoEdad"]="RANGO DE EDAD";
		$estmuestran3["¿QUÍENES SON?"]["rangoGenero"]="GENERO";
		$estmuestran3["¿QUÍENES SON?"]["rangoNivelEducacion"]="NIVEL EDUCATIVO";
		$estmuestran3["¿QUÍENES SON?"]["rangoPuestoIcfes"]="PUESTO ICFES";
		$estmuestran3["¿DE DONDE PROVIENEN?"]["rangoNacionalidad"]="NACIONALIDAD";
		
		$estructuramuestratmp["CARACTERÍSTICAS DEMOGRÁFICAS"]=$estmuestran3;
		
		unset($estmuestran3);
		
		
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoParticipacionAcademica"]="ACADÉMICAS";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoLineaInvestigacion"]="INVESTIGATIVAS";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoProyeccionSocial"]="PROYECCIÓN SOCIAL";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoParticipacionBienestar"]="BIENESTAR UNIVERSITARIO";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoParticipacionGobierno"]="GOBIERNO UNIVERSITARIO";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoAsociacion"]="ASOCIACIONES ESTUDIANTILES";
		$estmuestran3["TIPO DE ACTIVIDAD"]["rangoParticipacionGestion"]="GESTIÓN UNIVERSITARIA";
		
		$estructuramuestratmp["ACTIVIDADES DEL ESTUDIANTE"]=$estmuestran3;
		
		unset($estmuestran3);
		
		
		$estmuestran3["ESTÍMULOS, RECONOCIMIENTOS Y DISTINCIONES"]["rangoReconocimiento"]="CATEGORIA";
		$estmuestran3["FINANCIACIÓN"]["rangoTipoFinanciacion"]="TIPO DE FINANCIACION";
		//$estmuestran3["BENEFICIARIOS DE BECAS Y ESTIMULOS"]["rangoTipoBeneficio"]="TIPO DE BENEFICIO";
		$estmuestran3["PROGRAMA DE ACOMPAÑAMIENTO"]["rangoEstadoEstudiante"]="ESTADO DEL ESTUDIANTE";
		
		$estructuramuestratmp["INFORMACION COMPLEMENTARIA"]=$estmuestran3;


		unset($estmuestran3);
			$estmuestran3["HISTORICO"]["historicoEstudiante"]="HISTORICO ESTUDIANTE";
			$estructuramuestratmp["INFORMACION HISTORICA"]=$estmuestran3;

		$this->estructuracolumna=$estructuramuestratmp;


		unset($estmuestran3);

		$tmparraycampos=$this->arraycampos;
		foreach($tmparraycampos as $llave=>$columna){
			$tmparraytotales=$this->objestadistico->porcentajesTotalesArea($columna,$this->arrayopciones["codigomodalidadacademicasic"],$this->arrayopciones["codigocarrera"],$this->arrayopciones["codigofacultad"],$this->arrayopciones["codigoareadisciplinar"]);
			
			foreach($tmparraytotales["totalesfinal"] as $llavetotales=>$rowtotales){
				$arraytitulosfinal[$columna][$llavetotales]=1;

			}
			$this->arraytotalescolumnasparcial[$columna]=$tmparraytotales;
			
			
		}
		foreach($estructuramuestratmp as $llaven1=>$estructuran1){
			foreach($estructuran1 as $llaven2=>$estructuran2){
				foreach($estructuran2 as $llaven3=>$estructuran3){
					//echo $llaven3 .":<pre>".print_r($this->arraycampos)."</pre>";
					if(is_array($this->arraycampos))
					if(in_array($llaven3,$this->arraycampos)){
						foreach($arraytitulosfinal[$llaven3] as $titulofinal=>$valor){
							$estructuramuestra[$llaven1][$llaven2][$estructuran3][$titulofinal]=1;
						}
					}
				}
			}
		}
		return $estructuramuestra;
	}
	function sumaArray($arrayTotal){
		if(is_array($arrayTotal))
		foreach($arrayTotal as $llave=>$valor){
			$suma+=$valor;
		}
		return $suma;
	}
	function titulosVerticalArea(){
		$tmparraycampos=$this->arraycampos;
		foreach($tmparraycampos as $llave=>$columna){
			$this->arraytotalescolumnas[$columna]=$this->objestadistico->porcentajesTotalesArea($columna,"");
		}
		$this->arraytotalescolumnas["rangoTemporal"]=$this->objestadistico->porcentajesTotalesArea("rangoEdad","");
		/*echo "arraytotalescolumnas<pre>";
		print_r($this->arraytotalescolumnas["rangoEdad"]);
		echo "</pre>";*/

		$carrerasDatos=$this->objestadistico->carrerasDatos($this->arrayopciones["codigomodalidadacademicasic"],$this->arrayopciones["codigocarrera"],$this->arrayopciones["codigofacultad"],$this->arrayopciones["codigoareadisciplinar"]);

		$estructuramuestra["TOTALES"]["total"]=$this->sumaArray($this->arraytotalescolumnas["rangoTemporal"]["totalesfinal"]);
		foreach($carrerasDatos as $codigocarrera=>$rowCarrera){
			$estructuramuestra["TOTALES"]
			[$rowCarrera["nombreareadisciplinar"]]
			[$rowCarrera["nombrefacultad"]]
			[$rowCarrera["nombremodalidadacademicasic"]."<!--".$rowCarrera["codigofacultad"]."-->"]
			[$rowCarrera["nombrecarrera"]]["fin"]=1;
			
			$arrayTotalAreaTmp=$this->arraytotalescolumnas["rangoTemporal"][$rowCarrera["codigoareadisciplinar"]];
			
			$estructuramuestra["TOTALES"]
			[$rowCarrera["nombreareadisciplinar"]]
			["total"]=$this->sumaArray($arrayTotalAreaTmp["arraytotales"]);

			$arrayTotalFacultadTmp=$arrayTotalAreaTmp["facultades"][$rowCarrera["codigofacultad"]];

			$estructuramuestra["TOTALES"]
			[$rowCarrera["nombreareadisciplinar"]]
			[$rowCarrera["nombrefacultad"]]
			["total"]=$this->sumaArray($arrayTotalFacultadTmp["arraytotales"]);

			$arrayTotalModalidad=$arrayTotalFacultadTmp["modalidades"][$rowCarrera["codigomodalidadacademicasic"]];
			/*echo "MODALIDAD<pre>";
				print_r($arrayTotalModalidad);
			echo "</pre>";*/
			$estructuramuestra["TOTALES"]
			[$rowCarrera["nombreareadisciplinar"]]
			[$rowCarrera["nombrefacultad"]]
			[$rowCarrera["nombremodalidadacademicasic"]."<!--".$rowCarrera["codigofacultad"]."-->"]
			["total"]=$this->sumaArray($arrayTotalModalidad["arraytotales"]);


			$arrayTotalCarrera=$arrayTotalModalidad["carreras"][$codigocarrera];

			$estructuramuestra["TOTALES"]
			[$rowCarrera["nombreareadisciplinar"]]
			[$rowCarrera["nombrefacultad"]]
			[$rowCarrera["nombremodalidadacademicasic"]."<!--".$rowCarrera["codigofacultad"]."-->"]
			[$rowCarrera["nombrecarrera"]]
			["total"]=$this->sumaArray($arrayTotalCarrera["arraytotales"]);
			//$estructuramuestra["TOTALES"][$rowCarrera["nombreareadisciplinar"]][$rowCarrera["nombrefacultad"]][$rowCarrera["nombremodalidadacademicasic"]]["total"]=$this->sumaArray($arrayTotalModalidadTmp["arraytotales"]);


			

		}
		$this->totalesvertical=$this->arraytotalescolumnas["rangoTemporal"];
		unset($this->arraytotalescolumnas["rangoTemporal"]);
		return $estructuramuestra;
	}

	function encontrarTotalVertical($opcion,$codigomodalidadacademicasic="",$codigocarrera="",$codigofacultad="",$codigoareadisciplinar=""){
		switch($opcion){
			
			case "modalidad":
				$arraytotales=$this->totalesvertical[$codigoareadisciplinar]
						["facultades"]
						[$codigofacultad]
						["modalidades"]
						[$codigomodalidadacademicasic]
						["arraytotales"];
				break;
			case "carrera":
				$arraytotales=$this->totalesvertical[$codigoareadisciplinar]
						["facultades"]
						[$codigofacultad]
						["modalidades"]
						[$codigomodalidadacademicasic]
						["carreras"]
						[$codigocarrera]
						["arraytotales"];
				break;
			case "facultad":
				$arraytotales=$this->totalesvertical[$codigoareadisciplinar]
						["facultades"]
						[$codigofacultad]
						["arraytotales"];
				break;
			case "area":
				$arraytotales=$this->totalesvertical[$codigoareadisciplinar]			["arraytotales"];
				break;
			case "totalfinal":
				$arraytotales=$this->totalesvertical["totalesfinal"];
				break;



		
		}
		return $this->sumaArray($arraytotales);
	
	}
	function complementaArrayArea($arraytmp,$totalverticaltmp,$nombrefila,$estilo,$totalvacio="0",$ampliatabla="1"){

		foreach($arraytmp as $llavecolumna => $valorcolumna){
			$porcentajeceldatmp="";	
			if($this->mostrarporcentajes){
				$porcentajeceldatmp="<td>".@round(($valorcolumna/$totalverticaltmp)*100,2)."%</td>";
			}
			$propiedadamplia="";
			if($ampliatabla){
				$propiedadamplia="width='100%' height='100%'";
			}
			if(!$totalvacio){
			$this->arrayarea[$nombrefila][$llavecolumna]="<table  class='".$estilo."' ".$propiedadamplia." border='0' cellpadding='0' cellspacing='0'><tr><td width='30'>".$valorcolumna."</td>".$porcentajeceldatmp."</tr></table>";
					//$arrayarea[$rowCarrera["nombrecarrera"]][$llavecolumna]=$valorcolumna;
			}
			else{
			$this->arrayarea[$nombrefila][$llavecolumna]="";
			}
		}
		//return $arrayarea;
	}
	function areaPrincipal(){
		unset($this->arrayarea);
		$carrerasDatos=$this->objestadistico->carrerasDatos($this->arrayopciones["codigomodalidadacademicasic"],$this->arrayopciones["codigocarrera"],$this->arrayopciones["codigofacultad"],$this->arrayopciones["codigoareadisciplinar"]);

		foreach($this->arraytotalescolumnas as $columna=>$arraycolumnasn1){
			/*echo "$columna<pre>";
			print_r($arraycolumnasn1);
			echo "</pre>";*/
			
			foreach($carrerasDatos as $codigocarrera=>$rowCarrera){
				


				
				
				/*TOTALES POR MODALIDAD*/
				$totalverticaltmp=$this->encontrarTotalVertical("modalidad",$rowCarrera["codigomodalidadacademicasic"],$codigocarrera,$rowCarrera["codigofacultad"],$rowCarrera["codigoareadisciplinar"]);

				
				$arraymodalidadtmp=$arraycolumnasn1[$rowCarrera["codigoareadisciplinar"]]
				["facultades"]
				[$rowCarrera["codigofacultad"]]
				["modalidades"]
				[$rowCarrera["codigomodalidadacademicasic"]]
				["arraytotales"];
				$nombrefila="Total ".$rowCarrera["nombremodalidadacademicasic"]."<!--".$rowCarrera["codigofacultad"]."-->";
				$estilo="estilototalmodalidad";
				
				$totalvacio="0";
				if(is_array($this->arraysintotalmodalidad))
				if(in_array($columna,$this->arraysintotalmodalidad))
					$totalvacio="1";

				$this->complementaArrayArea($arraymodalidadtmp,$totalverticaltmp,$nombrefila,$estilo,$totalvacio);

				/*TOTALES POR CARRERA*/
				
				if($totalvacio=="1")
				{
					$tmpmostrarporcentajes=$this->mostrarporcentajes;
					$this->mostrarporcentajes=0;
				}
				
				$totalverticaltmp=$this->encontrarTotalVertical("carrera",$rowCarrera["codigomodalidadacademicasic"],$codigocarrera,$rowCarrera["codigofacultad"],$rowCarrera["codigoareadisciplinar"]);
				
				
				$arraycarreratmp=$arraycolumnasn1[$rowCarrera["codigoareadisciplinar"]]
				["facultades"]
				[$rowCarrera["codigofacultad"]]
				["modalidades"]
				[$rowCarrera["codigomodalidadacademicasic"]]
				["carreras"]
				[$codigocarrera]
				["arraytotales"];
				$nombrefila=$rowCarrera["nombrecarrera"];
				$estilo="";
				$this->complementaArrayArea($arraycarreratmp,$totalverticaltmp,$nombrefila,$estilo,0,0);
				if($totalvacio=="1")
				{
					$this->mostrarporcentajes=$tmpmostrarporcentajes;
				}
				/*TOTALES POR FACULTAD*/
				$totalverticaltmp=$this->encontrarTotalVertical("facultad",$rowCarrera["codigomodalidadacademicasic"],$codigocarrera,$rowCarrera["codigofacultad"],$rowCarrera["codigoareadisciplinar"]);


				$arrayfacultadtmp=$arraycolumnasn1[$rowCarrera["codigoareadisciplinar"]]
				["facultades"]
				[$rowCarrera["codigofacultad"]]
				["arraytotales"];
				$nombrefila="Total ".$rowCarrera["nombrefacultad"];
				$estilo="estilototalfacultad";

				$totalvacio="0";
				if(is_array($this->arraysintotalfacultad))
				if(in_array($columna,$this->arraysintotalfacultad))
					$totalvacio="1";

				$this->complementaArrayArea($arrayfacultadtmp,$totalverticaltmp,$nombrefila,$estilo,$totalvacio);


				/*TOTALES POR AREA*/

				$totalverticaltmp=$this->encontrarTotalVertical("area",$rowCarrera["codigomodalidadacademicasic"],$codigocarrera,$rowCarrera["codigofacultad"],$rowCarrera["codigoareadisciplinar"]);

				$arrayareatmp=$arraycolumnasn1[$rowCarrera["codigoareadisciplinar"]]
				["arraytotales"];

				$nombrefila="Total Area ".$rowCarrera["nombreareadisciplinar"];
				$estilo="estilototalarea";

				$totalvacio="0";
				if(is_array($this->arraysintotalarea))
				if(in_array($columna,$this->arraysintotalarea))
					$totalvacio="1";
				$this->complementaArrayArea($arrayareatmp,$totalverticaltmp,$nombrefila,$estilo,$totalvacio);

					

				/*TOTALES FINAL*/
				$totalverticaltmp=$this->encontrarTotalVertical("totalfinal",$rowCarrera["codigomodalidadacademicasic"],$codigocarrera,$rowCarrera["codigofacultad"],$rowCarrera["codigoareadisciplinar"]);



				$arraygeneraltmp=$arraycolumnasn1["totalesfinal"];

				$nombrefila="Total General";
				$estilo="estilototalgeneral";
				$totalvacio="0";
				if(is_array($this->arraysintotalgeneral))
				if(in_array($columna,$this->arraysintotalgeneral))
					$totalvacio="1";
				$this->complementaArrayArea($arraygeneraltmp,$totalverticaltmp,$nombrefila,$estilo,$totalvacio);

			
			}
		}
		return $this->arrayarea;
	}

}