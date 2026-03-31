<?php


/**
 * Description of EstadisticoEstudiante
 *
 * @author javeeto
 */
class EstadisticoEstudiante {

	var $codigoperiodo;
	var $objetobase;
	var $db;

	function EstadisticoEstudiante($codigoperiodo,$objetobase){
		$this->codigoperiodo=$codigoperiodo;
		$this->db=$objetobase->conexion;
		$this->objetobase=$objetobase;

	}
	function estudianteFacultad($codigocarrera){


		if($datosestadisticoestudiante=$this->objetobase->recuperar_datos_tabla("estadisticamatriculados","codigoperiodo",$this->codigoperiodo," and fechaestadisticamatriculados = '".date("Y-m-d")."'  and codigocarrera= '".$codigocarrera."'","",0)){
		
			$resultado=$this->objetobase->recuperar_resultado_tabla("detalleestadisticamatriculados","idestadisticamatriculados",$datosestadisticoestudiante["idestadisticamatriculados"],"","",0);
		
			while ($row_operacion=$resultado->fetchRow())
			{
				$arrayinterno[]=$row_operacion["idestudiantegeneral"];
			}
		
		
		
		}
		else{
			$query="SELECT distinct 0, ca.codigocarrera, o.codigoperiodo, e.idestudiantegeneral
			from ordenpago o, detalleordenpago d, estudiante e, carrera ca, concepto co
			WHERE o.numeroordenpago=d.numeroordenpago
			AND e.codigoestudiante=o.codigoestudiante
			AND ca.codigocarrera=e.codigocarrera
			AND d.codigoconcepto=co.codigoconcepto
			AND co.cuentaoperacionprincipal='151'
			AND o.codigoestadoordenpago LIKE '4%'
			and o.codigoperiodo ='".$this->codigoperiodo."'
			and ca.codigocarrera='".$codigocarrera."'
			order by o.codigoperiodo, ca.codigocarrera";
	
			$operacion=$this->db->query($query);
			if($imprimir)
			echo $query;


			$tabla="estadisticamatriculados";
				$fila["codigocarrera"]=$codigocarrera;
				$fila["fechaestadisticamatriculados"]=date("Y-m-d");
				$fila["codigoperiodo"]=$this->codigoperiodo;
				$fila["codigoestado"]="100";
				$condicionactualiza="  codigocarrera=".$fila["codigocarrera"].
						" and fechaestadisticamatriculados='".$fila["fechaestadisticamatriculados"]."'".
						" and codigoperiodo='".$fila["codigoperiodo"]."'";
		
				$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		
				$datosestadisticoestudiante=$this->objetobase->recuperar_datos_tabla("estadisticamatriculados","codigoperiodo",$this->codigoperiodo," and fechaestadisticamatriculados = '".date("Y-m-d")."'  and codigocarrera= '".$codigocarrera."'","",0);
			while ($row_operacion=$operacion->fetchRow())
			{
				$arrayinterno[]=$row_operacion["idestudiantegeneral"];
				
				$tabladetalle="detalleestadisticamatriculados";
				$filadetalle["idestadisticamatriculados"]=$datosestadisticoestudiante["idestadisticamatriculados"];
				$filadetalle["idestudiantegeneral"]=$row_operacion["idestudiantegeneral"];
				$filadetalle["codigoestado"]="100";
				$condicionactualiza=" idestadisticamatriculados=".$datosestadisticoestudiante["idestadisticamatriculados"].
						" and idestudiantegeneral=".$filadetalle["idestudiantegeneral"];			
				//echo "<pre>";
				$this->objetobase->insertar_fila_bd($tabladetalle,$filadetalle,0,$condicionactualiza);
				//echo "</pre>";
			}
		}
		return $arrayinterno;
	}
	/*****CARRERAS*****/
	function carreraOpciones($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
				$tablasagregadas="";
		$condicionagregada="";
		if($codigocarrera!=""){
			$condicionagregada.=" and c.codigocarrera='".$codigocarrera."'";
			
		}
		if($codigofacultad!=""){
			$condicionagregada.=" and c.codigofacultad='".$codigofacultad."'";
			$tablasagregadas.=",modalidadacademica m";
		}
		if($codigomodalidadacademicasic!=""){
			$condicionagregada.=" and c.codigomodalidadacademicasic ='".$codigomodalidadacademicasic."'";
		}
		if($codigoareadisciplinar!=""){
			$tablasagregadas=",facultad fd";	
			$condicionagregada.="  and c.codigofacultad=fd.codigofacultad and fd.codigoareadisciplinar  = '".$codigoareadisciplinar."'";
		}

		$query="select c.codigocarrera from carrera c ".$tablasagregadas." where 1=1  ".$condicionagregada."";	
	

		if($imprimir)
		echo $query;
		$operacion=$this->db->query($query);
	
		//$operacion=$objetobase->conexion->query($query);
		//$row_operacion=$operacion->fetchRow();
		while ($row_operacion=$operacion->fetchRow())
		{
			$arrayinterno[]=$row_operacion["codigocarrera"];
			
			
			
		}
		return $arrayinterno;
		
	}

/*Retorna un array con datos de carrera .El listado de carreras depende de las opciones de los parametros de entrada*/
	function carrerasDatos($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
			
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad ,$codigoareadisciplinar);
		
		for($i=0;$i<count($arraycarrera);$i++){
			if($i==0)
			{	
				$listacarreras=$arraycarrera[$i];
			}
			else
			{
				$listacarreras.=",".$arraycarrera[$i];
			}
		
		}
		
		$query="select * from carrera c, facultad f, areadisciplinar a,modalidadacademicasic m where c.codigocarrera in (".$listacarreras.")  and f.codigofacultad=c.codigofacultad and f.codigoareadisciplinar=a.codigoareadisciplinar and c.codigomodalidadacademicasic=m.codigomodalidadacademicasic
		group by c.codigocarrera";
	

		if($imprimir)
		echo $query;
		$operacion=$this->db->query($query);
	
		//$operacion=$objetobase->conexion->query($query);
		//$row_operacion=$operacion->fetchRow();
		while ($row_operacion=$operacion->fetchRow())
		{
			$arrayinterno[$row_operacion["codigocarrera"]]["codigomodalidadacademicasic"]=$row_operacion["codigomodalidadacademicasic"];
			$arrayinterno[$row_operacion["codigocarrera"]]["codigofacultad"]=$row_operacion["codigofacultad"];
			$arrayinterno[$row_operacion["codigocarrera"]]["codigoareadisciplinar"]=$row_operacion["codigoareadisciplinar"];
			$arrayinterno[$row_operacion["codigocarrera"]]["nombremodalidadacademicasic"]=$row_operacion["nombremodalidadacademicasic"];
			$arrayinterno[$row_operacion["codigocarrera"]]["nombrefacultad"]=$row_operacion["nombrefacultad"];
			$arrayinterno[$row_operacion["codigocarrera"]]["nombreareadisciplinar"]=$row_operacion["nombreareadisciplinar"];
			$arrayinterno[$row_operacion["codigocarrera"]]["nombrecarrera"]=$row_operacion["nombrecarrera"];
			
			
		}
		return $arrayinterno;
		
	}

	/*Cuenta estudiantes matriculados por estrato*/
	function rangoEstrato($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="33";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select concat('Estrato ',nombreestrato) nombretipo
						FROM  estrato where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
	
				
					$query="SELECT concat('Estrato ',et.nombreestrato) tituloestrato,count(distinct eh.idestudiantegeneral) conteo
					,(count(distinct eg.idestudiantegeneral)-count(distinct eh.idestudiantegeneral)) conteototal
					FROM estudiantegeneral eg
					left join estratohistorico eh on eh.idestudiantegeneral=eg.idestudiantegeneral
					and eh.codigoestado='100'
					left join estrato et on et.idestrato=eh.idestrato 
					WHERE eg.idestudiantegeneral = '".$idestudiantegeneral."'";
					//exit();
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						if((trim($row["tituloestrato"])!="")&&isset($row["tituloestrato"])){
							$arrayinterno[$row["tituloestrato"]][$codigocarrerai]+=$row["conteo"];
						}
						$arrayinterno["No Registra"][$codigocarrerai]+=$row["conteototal"];	
					}
						
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}


		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por rango de edades y retorna un array con dicha informacion*/
	function rangoEdad($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="32";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				$arrayinterno["Menor de 15 años"][$codigocarrerai]=0;
				$arrayinterno["15 a 20 años"][$codigocarrerai]=0;
				$arrayinterno["21 a 25 años"][$codigocarrerai]=0;
				$arrayinterno["26 a 30 años"][$codigocarrerai]=0;
				$arrayinterno["31 a 35 años"][$codigocarrerai]=0;
				$arrayinterno["36 a 40 años"][$codigocarrerai]=0;
				$arrayinterno["41 a 45 años"][$codigocarrerai]=0;
				$arrayinterno["Mayor de 45 años"][$codigocarrerai]=0;
			}


		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
	
						
				$query="SELECT		
				count(distinct eg0.idestudiantegeneral) menor_de_15,
				count(distinct eg1.idestudiantegeneral) entre_15_y_20,
				count(distinct eg2.idestudiantegeneral) entre_21_y_25,
				count(distinct eg3.idestudiantegeneral) entre_26_y_30,
				count(distinct eg4.idestudiantegeneral) entre_31_y_35,
				count(distinct eg5.idestudiantegeneral) entre_36_y_40,
				count(distinct eg6.idestudiantegeneral) entre_41_y_45,
				count(distinct eg7.idestudiantegeneral) mayor_de_45,
				count(distinct eg.idestudiantegeneral) total
				
					FROM  estudiantegeneral eg
				left join estudiantegeneral eg0 on eg.idestudiantegeneral=eg0.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg0.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg0.fechanacimientoestudiantegeneral,5))) < 15 
				
				left join estudiantegeneral eg1 on eg.idestudiantegeneral=eg1.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg1.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg1.fechanacimientoestudiantegeneral,5))) between 15 and 20
				
				left join estudiantegeneral eg2 on eg.idestudiantegeneral=eg2.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg2.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg2.fechanacimientoestudiantegeneral,5))) between 21 and 25
				
				left join estudiantegeneral eg3 on eg.idestudiantegeneral=eg3.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg3.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg3.fechanacimientoestudiantegeneral,5))) between 26 and 30
				
				left join estudiantegeneral eg4 on eg.idestudiantegeneral=eg4.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg4.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg4.fechanacimientoestudiantegeneral,5))) between 31 and 35
				
				left join estudiantegeneral eg5 on eg.idestudiantegeneral=eg5.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg5.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg5.fechanacimientoestudiantegeneral,5))) between 36 and 40
				
				left join estudiantegeneral eg6 on eg.idestudiantegeneral=eg6.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg6.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg6.fechanacimientoestudiantegeneral,5))) between 41 and 45
				
				left join estudiantegeneral eg7 on eg.idestudiantegeneral=eg7.idestudiantegeneral and
				((YEAR(CURRENT_DATE) - YEAR(eg7.fechanacimientoestudiantegeneral))-
				(RIGHT(CURRENT_DATE,5) < RIGHT(eg7.fechanacimientoestudiantegeneral,5))) > 45
			
				WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'";
	
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
					$arrayinterno["Menor de 15 años"][$codigocarrerai]+=$row["menor_de_15"];
					$arrayinterno["15 a 20 años"][$codigocarrerai]+=$row["entre_15_y_20"];
					$arrayinterno["21 a 25 años"][$codigocarrerai]+=$row["entre_21_y_25"];
					$arrayinterno["26 a 30 años"][$codigocarrerai]+=$row["entre_26_y_30"];
					$arrayinterno["31 a 35 años"][$codigocarrerai]+=$row["entre_31_y_35"];
					$arrayinterno["36 a 40 años"][$codigocarrerai]+=$row["entre_36_y_40"];
	
					$arrayinterno["41 a 45 años"][$codigocarrerai]+=$row["entre_41_y_45"];	
					$arrayinterno["Mayor de 45 años"][$codigocarrerai]+=$row["mayor_de_45"];	
		
					}
						
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

	return $arrayinterno;

	}

	/*Cuenta estudiantes matriculados por genero*/
	function rangoGenero($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="31";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombregenero nombretipo
						FROM  genero ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
					$query="SELECT g.nombregenero,count(distinct eg.idestudiantegeneral) conteo
					FROM estudiantegeneral eg, genero g 
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
					and eg.codigogenero=g.codigogenero";
				
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["nombregenero"]][$codigocarrerai]+=$row["conteo"];			
					}				
						
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por nivel de educacion*/
	function rangoNivelEducacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="30";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombreniveleducacion nombretipo
						FROM  niveleducacion ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
					$query="SELECT if(n.nombreniveleducacion is null,'No diligencia',n.nombreniveleducacion) nombrenivelacademico,count(distinct eg.idestudiantegeneral) conteo FROM estudiantegeneral eg
					left join estudianteestudio ee on eg.idestudiantegeneral=ee.idestudiantegeneral	
					and ee.codigoestado like '1%'
			
					and ee.idniveleducacion = (select n3.idniveleducacion from niveleducacion n3 where  ee.idniveleducacion=n3.idniveleducacion
					and n3.pesoniveleducacion=(select max(n2.pesoniveleducacion) 
							from niveleducacion n2,estudianteestudio ee2 where n2.idniveleducacion=ee2.idniveleducacion and ee2.idestudiantegeneral=eg.idestudiantegeneral))
			
					left join niveleducacion n on n.idniveleducacion=ee.idniveleducacion
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
						group by ee.idniveleducacion
						";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["nombrenivelacademico"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por puesto icfes*/
	function rangoPuestoIcfes($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="29";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				$arrayinterno["1 - 199"][$codigocarrerai]=0;
				$arrayinterno["200 - 499"][$codigocarrerai]=0;
				$arrayinterno["500 - 799"][$codigocarrerai]=0;
				$arrayinterno["800 - 1000"][$codigocarrerai]=0;
				$arrayinterno["Mayor a 1000"][$codigocarrerai]=0;
				$arrayinterno["No registra"][$codigocarrerai]=0;
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
				
					$query="select
					count(distinct r1.idestudiantegeneral) entre_1_199,
					count(distinct r2.idestudiantegeneral) entre_200_499,
					count(distinct r3.idestudiantegeneral) entre_500_799,
					count(distinct r4.idestudiantegeneral) entre_800_1000,
					count(distinct r5.idestudiantegeneral) mayor_a_1000,
					
					count(distinct eg.idestudiantegeneral)-
					(count(distinct r1.idestudiantegeneral)+
					count(distinct r2.idestudiantegeneral)+
					count(distinct r3.idestudiantegeneral)+
					count(distinct r4.idestudiantegeneral)+
					count(distinct r5.idestudiantegeneral)) No_Registra
					
					FROM  estudiantegeneral eg
					left join resultadopruebaestado r1 on r1.idestudiantegeneral=eg.idestudiantegeneral
					and r1.puestoresultadopruebaestado between 1 and 199
					left join resultadopruebaestado r2 on r2.idestudiantegeneral=eg.idestudiantegeneral
					and r2.puestoresultadopruebaestado between 200 and 499
					left join resultadopruebaestado r3 on r3.idestudiantegeneral=eg.idestudiantegeneral
					and r3.puestoresultadopruebaestado between 500 and 799
					left join resultadopruebaestado r4 on r4.idestudiantegeneral=eg.idestudiantegeneral
					and r4.puestoresultadopruebaestado between 800 and 1000
					left join resultadopruebaestado r5 on r5.idestudiantegeneral=eg.idestudiantegeneral
					and r5.puestoresultadopruebaestado > 1000					
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno["1 - 199"][$codigocarrerai]+=$row["entre_1_199"];
						$arrayinterno["200 - 499"][$codigocarrerai]+=$row["entre_200_499"];
						$arrayinterno["500 - 799"][$codigocarrerai]+=$row["entre_500_799"];
						$arrayinterno["800 - 1000"][$codigocarrerai]+=$row["entre_800_1000"];
						$arrayinterno["Mayor a 1000"][$codigocarrerai]+=$row["mayor_a_1000"];
						$arrayinterno["No registra"][$codigocarrerai]+=$row["No_Registra"];
			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}


		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por Nacionalidades*/
	function rangoNacionalidad($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="28";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				$arrayinterno["Extranjeros"][$codigocarrerai]=0;
				$arrayinterno["Nacionales"][$codigocarrerai]=0;
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
					
					$query="select 
					count(distinct eg2.idestudiantegeneral) Extranjeros,
					count(distinct eg3.idestudiantegeneral) Nacionales
					
					FROM  estudiantegeneral eg
					left join estudiantegeneral eg2  on  eg2.idestudiantegeneral=eg.idestudiantegeneral and eg2.idciudadnacimiento=2000
					left join estudiantegeneral eg3  on  eg3.idestudiantegeneral=eg.idestudiantegeneral and eg3.idciudadnacimiento<>2000
					
					
					WHERE  eg.idestudiantegeneral='".$idestudiantegeneral."'";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno["Extranjeros"][$codigocarrerai]+=$row["Extranjeros"];
						$arrayinterno["Nacionales"][$codigocarrerai]+=$row["Nacionales"];
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

	
		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por participacion academica*/
	function rangoParticipacionAcademica($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="27";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoparticipacionacademicaestudiante nombretipo
						FROM  tipoparticipacionacademicaestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
					$query="select 
					if(tpe.nombretipoparticipacionacademicaestudiante is null,'No registra',tpe.nombretipoparticipacionacademicaestudiante) tipoparticipacion,
					count(distinct eg.idestudiantegeneral) conteo
					FROM estudiantegeneral eg
					left join participacionacademicaestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
					and pe.codigoestado like '1%'
					left join tipoparticipacionacademicaestudiante tpe on pe.codigotipoparticipacionacademicaestudiante=tpe.codigotipoparticipacionacademicaestudiante
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'			
					group by tpe.codigotipoparticipacionacademicaestudiante	";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

		return $arrayinterno;
	}
	/*Cuenta estudiantes matriculados en linea de investigacion*/
	function rangoLineaInvestigacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="26";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				$arrayinterno["Linea de investigación"][$codigocarrerai]=0;
				$arrayinterno["No registra"][$codigocarrerai]=0;
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
					$query="select 
					count(distinct le.idestudiantegeneral) enlineainvestigacion,
					(count(distinct eg.idestudiantegeneral) - count(distinct le.idestudiantegeneral)) No_Registra
					FROM estudiantegeneral eg
					left join lineainvestigacionestudiante le on le.idestudiantegeneral=eg.idestudiantegeneral
						and le.codigoestado like '1%'
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno["Linea de investigación"][$codigocarrerai]+=$row["enlineainvestigacion"];
						$arrayinterno["No registra"][$codigocarrerai]+=$row["No_Registra"];	
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}
		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por proyeccion social*/
	function rangoProyeccionSocial($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="25";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoproyeccionsocialestudiante nombretipo
						FROM  tipoproyeccionsocialestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
				
					$query="select 
						if(tpe.nombretipoproyeccionsocialestudiante is null,'No registra',tpe.nombretipoproyeccionsocialestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM  estudiantegeneral eg
						left join proyeccionsocialestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
						and pe.codigoestado like '1%'
						left join tipoproyeccionsocialestudiante tpe on pe.codigotipoproyeccionsocialestudiante=tpe.codigotipoproyeccionsocialestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
						
							group by tpe.codigotipoproyeccionsocialestudiante
							";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}
		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por tipo  de participaciones en bienestar universitario*/
	function rangoParticipacionBienestar($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="24";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoparticipacionuniversitariaestudiante nombretipo
						FROM  tipoparticipacionuniversitariaestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
				
					$query="select 
						if(tpe.nombretipoparticipacionuniversitariaestudiante is null,'No registra',tpe.nombretipoparticipacionuniversitariaestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM  estudiantegeneral eg
						left join participacionuniversitariaestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
						and pe.codigoestado like '1%'
						left join tipoparticipacionuniversitariaestudiante tpe on pe.codigotipoparticipacionuniversitariaestudiante=tpe.codigotipoparticipacionuniversitariaestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
						group by tpe.codigotipoparticipacionuniversitariaestudiante";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
		
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}


	return $arrayinterno;
	}
	/*Cuenta estudiantes matriculados por tipo  de participaciones en gobierno universitario*/
	function rangoParticipacionGobierno($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="23";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoparticipaciongobiernoestudiante nombretipo
						FROM  tipoparticipaciongobiernoestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
				
					$query="select 
						if(tpe.nombretipoparticipaciongobiernoestudiante is null,'No registra',tpe.nombretipoparticipaciongobiernoestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM  estudiantegeneral eg
						left join participaciongobiernoestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
							and pe.codigoestado like '1%'
						left join tipoparticipaciongobiernoestudiante tpe on pe.codigotipoparticipaciongobiernoestudiante=tpe.codigotipoparticipaciongobiernoestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
							group by tpe.codigotipoparticipaciongobiernoestudiante
							";
			
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}


		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por tipo  de participaciones en asociaciones universitario*/
	function rangoAsociacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="22";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoasociacionestudiante nombretipo
						FROM  tipoasociacionestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
		
					$query="select 
						if(tpe.nombretipoasociacionestudiante is null,'No registra',tpe.nombretipoasociacionestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM estudiantegeneral eg
						left join asociacionestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
						and pe.codigoestado like '1%'
						left join tipoasociacionestudiante tpe on pe.codigotipoasociacionestudiante=tpe.codigotipoasociacionestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
							group by tpe.codigotipoasociacionestudiante";
						
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
	
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

		return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por tipo  de participaciones en gestion universitario*/
	function rangoParticipacionGestion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="21";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoparticipaciongestionestudiante nombretipo
						FROM  tipoparticipaciongestionestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
			
					$query="select 
						if(tpe.nombretipoparticipaciongestionestudiante is null,'No registra',tpe.nombretipoparticipaciongestionestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM  estudiantegeneral eg
						left join participaciongestionestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
						and pe.codigoestado like '1%'
						left join tipoparticipaciongestionestudiante tpe on pe.codigotipoparticipaciongestionestudiante=tpe.codigotipoparticipaciongestionestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
						
							group by pe.codigotipoparticipaciongestionestudiante"
							;
						
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

		
		return $arrayinterno;
	}


	/*Cuenta estudiantes matriculados por tipo  de participaciones en reconocimientos universitarios*/
	function rangoReconocimiento($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="20";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretiporeconocimientoestudiante nombretipo
						FROM  tiporeconocimientoestudiante where codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
		
					$query="select 
						if(tpe.nombretiporeconocimientoestudiante is null,'No registra',tpe.nombretiporeconocimientoestudiante) tipoparticipacion,
						count(distinct eg.idestudiantegeneral) conteo
						FROM estudiantegeneral eg
						left join reconocimientoestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral
						and pe.codigoestado like '1%'
						left join tiporeconocimientoestudiante tpe on pe.codigotiporeconocimientoestudiante=tpe.codigotiporeconocimientoestudiante
						WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'
						
							group by tpe.codigotiporeconocimientoestudiante
							";
						
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}

			return $arrayinterno;
	}

	/*Cuenta estudiantes matriculados por tipo  de financiacion  */
	function rangoTipoFinanciacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$variableestadistico="19";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$query="select nombretipoestudianterecursofinanciero nombretipo
						FROM  tipoestudianterecursofinanciero";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai)
			{
				foreach($arraytipo as $llavetipo=>$nombretipo)
				{
					$arrayinterno[$nombretipo][$codigocarrerai]=0;

				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){

				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
				$query="SELECT if(t.nombretipoestudianterecursofinanciero is null,'No diligencia',t.nombretipoestudianterecursofinanciero) tipoparticipacion,count(distinct eg.idestudiantegeneral) conteo FROM  estudiantegeneral eg
					left join estudianterecursofinanciero er on eg.idestudiantegeneral=er.idestudiantegeneral	
					and er.idestudianterecursofinanciero=(select max(r2.idestudianterecursofinanciero) 
							from estudianterecursofinanciero r2 where r2.idestudiantegeneral=eg.idestudiantegeneral)
					left join tipoestudianterecursofinanciero t on t.idtipoestudianterecursofinanciero=er.idtipoestudianterecursofinanciero
					WHERE eg.idestudiantegeneral='".$idestudiantegeneral."'	
					
						group by t.idtipoestudianterecursofinanciero";
						
					$result=$this->db->query($query);
					while($row= $result->fetchRow()){
						$arrayinterno[$row["tipoparticipacion"]][$codigocarrerai]+=$row["conteo"];			
					}
				}
				
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
		}
		else
		{
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}
		return $arrayinterno;
	}


	/*Cuenta estudiantes matriculados por estado */
	function rangoEstadoEstudiante($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){


		$variableestadistico="2";

		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
		
				$arrayinterno["Estudiante en acompañamiento"][$codigocarrerai]=0;
				$arrayinterno["Estudiante en situación academica normal"][$codigocarrerai]=0;
			}


		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)){
			foreach($arraycarrera as $llave=>$codigocarrerai){

				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);	
				if(is_array($arrayestudiante))
				foreach($arrayestudiante as $llavedocente=>$idestudiantegeneral){
				
					$query="SELECT ca.codigocarrera, o.codigoperiodo, e.codigoestudiante
						from ordenpago o, detalleordenpago d, estudiante e, carrera ca, concepto co
						WHERE o.numeroordenpago=d.numeroordenpago
						AND e.codigoestudiante=o.codigoestudiante
						AND ca.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal='151'
						AND o.codigoestadoordenpago LIKE '4%'
						and o.codigoperiodo ='".$this->codigoperiodo."'
						and ca.codigocarrera='".$codigocarrerai."'
						and e.idestudiantegeneral='".$idestudiantegeneral."'
						group by e.idestudiantegeneral
						order by o.codigoperiodo, ca.codigocarrera";
						
					$result=$this->db->query($query);
					//$arrayinterno["Estudiante en acompañamiento"][$row["codigocarrera"]]=0;
					//$arrayinterno["Estudiante en situación academica normal"][$row["codigocarrera"]]=0;
			
					$row= $result->fetchRow();
						//$db=$this->db;
						//$arrayinterno["Estudiante en situación academica normal"][$codigocarrerai]++;
						$detallenotai = new detallenota($row["codigoestudiante"], $this->codigoperiodo);
						//if($detallenota->tieneNotas())
						
							if(@$detallenotai->esAltoRiesgo())
							{
								$cuentaregistros++;			
								$arrayinterno["Estudiante en acompañamiento"][$codigocarrerai]++;
			
							}
							else{
								$arrayinterno["Estudiante en situación academica normal"][$codigocarrerai]++;
			
							}
					
					
				}
			}
			$this->insertarVariableEstadistica($arrayinterno,$variableestadistico);
			/*echo "estado<pre>";
			print_r($arrayinterno);
			echo "</pre>";*/
		}
		else{
			
			$arrayinterno=$this->consultaArrayVariable($arraycarrera,$variableestadistico);
		}
	

		return $arrayinterno;
	}


	/*Cuenta estudiantes matriculados por tipo  de participaciones en gestion universitario*/
	function historicoEstudiante($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$resultperiodo=$this->objetobase->recuperar_resultado_tabla("periodo","1","1","  and codigoperiodo between 20061 and '".$this->codigoperiodo."'","",0);
		$tmpperiodoinicial=$this->codigoperiodo;
		while($rowperiodo = $resultperiodo->fetchRow()){
			$this->codigoperiodo=$rowperiodo["codigoperiodo"];
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
				//echo "<br><br>";
				$arrayinterno[$rowperiodo["codigoperiodo"]][$codigocarrerai]=count($arrayestudiante);
				
			}
		}
		$this->codigoperiodo=$tmpperiodoinicial;
		return $arrayinterno;

		
	}
	/***HISTORICO DOCENTES PERIODO***/
	function rangoHistoricoXPeriodoActivo($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		$resultperiodo=$this->objetobase->recuperar_resultado_tabla("periodo","1","1"," and codigoperiodo = '".$this->codigoperiodo."'","",0);
		$tmpperiodoinicial=$this->codigoperiodo;
		while($rowperiodo = $resultperiodo->fetchRow()){
			//$this->codigoperiodo=$rowperiodo["codigoperiodo"];
			if(is_array($arraycarrera))
				foreach($arraycarrera as $llave=>$codigocarrerai){
					$arrayestudiante=$this->estudianteFacultad($codigocarrerai);
					//echo "<br><br>";
					$arrayinterno[$codigocarrerai]=count($arrayestudiante);
				}
		}
		//$this->codigoperiodo=$tmpperiodoinicial;
		return $arrayinterno;
	}
	/***Muestra totales por agrupacion Modalidad academica y areadisciplinaria***/
	function porcentajesTotalesArea($funcion,$codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arrayfuncion=$this->$funcion($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		$arraycarreras=$this->carrerasDatos($codigomodalidadacademicasic,$codigocarrera,$codigofacultad ,$codigoareadisciplinar);
		
		foreach($arraycarreras as $codigocarrera=>$datoscarrera){
			/*$arrayinterno[$datoscarrera["codigoareadisciplinar"]]["carreras"][$codigocarrera]=1;
			$arrayinterno[$datoscarrera["codigoareadisciplinar"]]["numerocarreras"]++;

			$arrayinterno[$datoscarrera["codigoareadisciplinar"]]["facultades"][$datoscarrera["codigofacultad"]]["carreras"][$codigocarrera]=1;
			
			$arrayinterno[$datoscarrera["codigoareadisciplinar"]]["facultades"][$datoscarrera["codigofacultad"]]["totalcarreras"]++;
	

			$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
			["facultades"]
			[$datoscarrera["codigofacultad"]]
			["modalidades"]
			[$datoscarrera["codigomodalidadacademicasic"]]["carreras"][$codigocarrera]=1;
			
			$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
			["facultades"]
			[$datoscarrera["codigofacultad"]]
			["modalidades"]
			[$datoscarrera["codigomodalidadacademicasic"]]["totalcarreras"]++;*/

			
			foreach($arrayfuncion as $nombrecolumna=>$carreravalores){
	
				$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
				["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];

				$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
				["facultades"]
				[$datoscarrera["codigofacultad"]]
				["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];


				$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
				["facultades"]
				[$datoscarrera["codigofacultad"]]
				["modalidades"]
				[$datoscarrera["codigomodalidadacademicasic"]]
				["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];

				$arrayinterno[$datoscarrera["codigoareadisciplinar"]]
				["facultades"]
				[$datoscarrera["codigofacultad"]]
				["modalidades"]
				[$datoscarrera["codigomodalidadacademicasic"]]
				["carreras"]
				[$codigocarrera]
				["arraytotales"][$nombrecolumna]=$carreravalores[$codigocarrera];


				$arrayinterno["totalesfinal"][$nombrecolumna]+=$carreravalores[$codigocarrera];

			}
		}	
		
		return $arrayinterno;

	}
	/***Muestra totales por agrupacion areadisciplinaria y facultad***/
	function porcentajesTotales($funcion,$codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arrayfuncion=$this->$funcion($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		$arraycarreras=$this->carrerasDatos($codigomodalidadacademicasic,$codigocarrera,$codigofacultad ,$codigoareadisciplinar);
		
		foreach($arraycarreras as $codigocarrera=>$datoscarrera){
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["carreras"][$codigocarrera]=1;
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["numerocarreras"]++;

			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["areas"][$datoscarrera["codigoareadisciplinar"]]["carreras"][$codigocarrera]=1;
			
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["areas"][$datoscarrera["codigoareadisciplinar"]]["totalcarreras"]++;

	
			foreach($arrayfuncion as $nombrecolumna=>$carreravalores){	
				$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];
				$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["areas"][$datoscarrera["codigoareadisciplinar"]]["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];
				
				$arrayinterno["totalesfinal"][$nombrecolumna]+=$carreravalores[$codigocarrera];

			}
		}	
		
		return $arrayinterno;

	}
	/*Inserta array de valores de carreras y columnas por variable estadistica*/
	function insertarVariableEstadistica($arrayvariable,$idvariable){
		$tabla="detallevariableestadistico";
		$fila["idvariableestadistico"]=$idvariable;
		$fila["fechadetallevariableestadistico"]=date("Y-m-d");
		$fila["codigoperiodo"]=$this->codigoperiodo;
		$fila["codigoestado"]="100";
		$condicionactualiza="   fechadetallevariableestadistico='".$fila["fechadetallevariableestadistico"]."'".
		" and codigoperiodo=".$fila["codigoperiodo"].
		" and idvariableestadistico=".$fila["idvariableestadistico"];
	
		$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		
		//echo "<br><h1>1</h1><br>";
		$datosdetallevariable=$this->objetobase->recuperar_datos_tabla("detallevariableestadistico","codigoestado","100"," and ".$condicionactualiza,"",0);


		foreach($arrayvariable as $llavenombre=>$valores){
			$tabladetalle="campovariableestadistico";
			$filadetalle["iddetallevariableestadistico"]=$datosdetallevariable["iddetallevariableestadistico"];
			$filadetalle["valorcampovariableestadistico"]=$llavenombre;
			$filadetalle["estitulocampovariableestadistico"]="1";
			$filadetalle["codigocarrera"]="1";
			$filadetalle["idpadrecampovariableestadistico"]="1";
			$filadetalle["codigoestado"]="100";
			$condicionactualizadetalle=" iddetallevariableestadistico=".$filadetalle["iddetallevariableestadistico"].
			" and    valorcampovariableestadistico='".$filadetalle["valorcampovariableestadistico"]."' ".
			" and estitulocampovariableestadistico=1".
			" and codigocarrera=".$filadetalle["codigocarrera"].
			" and idpadrecampovariableestadistico=".$filadetalle["idpadrecampovariableestadistico"];

			$this->objetobase->insertar_fila_bd($tabladetalle,$filadetalle,0,$condicionactualizadetalle);
			//echo "<br><h1>2</h1><br>";
			$datoscampopapa=$this->objetobase->recuperar_datos_tabla("campovariableestadistico","codigoestado","100"," and ".$condicionactualizadetalle,"",0);

			foreach($valores as $codigocarrera=>$valor){
				$tablahijo="campovariableestadistico";
				$filahijo["iddetallevariableestadistico"]=$datosdetallevariable["iddetallevariableestadistico"];
				$filahijo["valorcampovariableestadistico"]=$valor;
				$filahijo["estitulocampovariableestadistico"]="0";
				$filahijo["codigocarrera"]=$codigocarrera;
				$filahijo["idpadrecampovariableestadistico"]=$datoscampopapa["idcampovariableestadistico"];
				$filahijo["codigoestado"]="100";
				$condicionactualizahijo=" iddetallevariableestadistico=".$filahijo["iddetallevariableestadistico"].
				" and estitulocampovariableestadistico=0".
				" and codigocarrera=".$filahijo["codigocarrera"].
				" and idpadrecampovariableestadistico=".$filahijo["idpadrecampovariableestadistico"];
	
				$this->objetobase->insertar_fila_bd($tablahijo,$filahijo,0,$condicionactualizahijo);

			}
		}

	}
	/*Consulta carreras cache si no se encuentran todas las consultadas del array $arraycarreras retorna un falso*/	
	function consultaCarrerasVariable($arraycarreras,$idvariable){
		$condicion=" and fechadetallevariableestadistico='".date("Y-m-d")."'".
		" and codigoperiodo=".$this->codigoperiodo.
		" and idvariableestadistico=".$idvariable;

		$datosdetalle=$this->objetobase->recuperar_datos_tabla("detallevariableestadistico d","codigoestado","100",$condicion,"",0);
		
		for($i=0;$i<count($arraycarreras);$i++){
			if($i==0)
			{	
				$listacarreras=$arraycarreras[$i];
			}
			else
			{
				$listacarreras.=",".$arraycarreras[$i];
			}
		
		}

		$query="select cv.idcampovariableestadistico from carrera c left join campovariableestadistico cv 
		on cv.codigocarrera=c.codigocarrera and iddetallevariableestadistico='".$datosdetalle["iddetallevariableestadistico"]."' where c.codigocarrera in (".$listacarreras.")  having idcampovariableestadistico is null";
		$result=$this->db->query($query);
		//$arrayinterno["Estudiante en acompañamiento"][$row["codigocarrera"]]=0;
		//$arrayinterno["Estudiante en situación academica normal"][$row["codigocarrera"]]=0;
		$cuenta=$result->RecordCount();
		if($cuenta>0){
			return 0;
		}
		return 1;

	}
	/*Consulta array variable estadistica en cache */
	function consultaArrayVariable($arraycarrera,$idvariable){

		for($i=0;$i<count($arraycarrera);$i++){
			if($i==0)
			{	
				$listacarreras=$arraycarrera[$i];
			}
			else
			{
				$listacarreras.=",".$arraycarrera[$i];
			}
		
		}
		
		$condicion=" and fechadetallevariableestadistico='".date("Y-m-d")."'".
		" and codigoperiodo=".$this->codigoperiodo.
		" and idvariableestadistico=".$idvariable;

		$datosdetalle=$this->objetobase->recuperar_datos_tabla("detallevariableestadistico d","codigoestado","100",$condicion,"",0);
		

		$condicion="  and iddetallevariableestadistico=".$datosdetalle["iddetallevariableestadistico"].
			" and estitulocampovariableestadistico=1".
			" and codigocarrera=1".
			" and idpadrecampovariableestadistico=1";

		$resultpapa=$this->objetobase->recuperar_resultado_tabla("campovariableestadistico c","codigoestado","100",$condicion,"",0);
		while($rowpapa=$resultpapa->fetchRow())
		{
			$condicion="  and iddetallevariableestadistico=".$datosdetalle["iddetallevariableestadistico"].
			" and estitulocampovariableestadistico=0".
			" and codigocarrera in (".$listacarreras.")".
			" and idpadrecampovariableestadistico='".$rowpapa["idcampovariableestadistico"]."'";

			$resulthijo=$this->objetobase->recuperar_resultado_tabla("campovariableestadistico c","codigoestado","100",$condicion,"",0);
			while($rowhijo=$resulthijo->fetchRow())
			{
				$arrayinterno[$rowpapa["valorcampovariableestadistico"]][$rowhijo["codigocarrera"]]=$rowhijo["valorcampovariableestadistico"];
			}
		}

		return $arrayinterno;
	}

}

?>