<?php
/**
 * Description of EstadisticoDocente
 *
 * @author javeeto
 */
class EstadisticoDocente{

	var $codigoperiodo;
	var $objetobase;
	var $db;
	var $enlinea;
	
	function EstadisticoDocente($codigoperiodo,$objetobase){
		$this->codigoperiodo=$codigoperiodo;
		$this->db=$objetobase->conexion;
		$this->objetobase=$objetobase;
		$this->enlinea=0;
	}
	/*consulta todos los docentes que pertenecen a cierta facultad*/
	function docentesFacultad($codigocarrera){
		
	
		if($datosestadisticodocente=$this->objetobase->recuperar_datos_tabla("estadisticodocente","codigoperiodo",$this->codigoperiodo," and fechaestadisticodocente = '".date("Y-m-d")."'  and codigocarrera= '".$codigocarrera."'","","",0)){
		
			$resultado=$this->objetobase->recuperar_resultado_tabla("detalleestadisticodocente","idestadisticodocente",$datosestadisticodocente["idestadisticodocente"],"","",0);
		
			while ($row_operacion=$resultado->fetchRow())
			{
				$arrayinterno[]=$row_operacion["iddocente"];
			}
		
		
		
		}
		else{
			
		$query="select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,if(ca.nombrecarrera='TODAS LAS CARRERAS','POSTGRADOS',ca.nombrecarrera) Nombre_Carrera,dc3.codigocarrera from  docente d,detallecontratodocente dc,contratodocente c,periodo p
		left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
		dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente
		and c2.codigoestado like '1%'
		and dc2.codigoestado like '1%' 	
		)
		left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
		where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and dc.codigocarrera = '".$codigocarrera."'
		and d.codigoestado like '1%'
		and c.codigoestado like '1%'
		and dc.codigoestado like '1%' 	
		and (c.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  c.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between c.fechainiciocontratodocente and c.fechafinalcontratodocente
		or p.fechavencimientoperiodo between c.fechainiciocontratodocente and c.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by d.iddocente

		
		union
		select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca.nombrecarrera Nombre_Carrera,ca.codigocarrera 
		from  docente d,grupo g,carrera ca,materia m
		where
		d.numerodocumento =g.numerodocumento and
		g.codigoperiodo in ('".$this->codigoperiodo."') and
		g.codigomateria = m.codigomateria and
		m.codigocarrera=ca.codigocarrera
		and ca.codigocarrera = '".$codigocarrera."'
		and d.numerodocumento <> '1'
		and d.iddocente not in(
		select distinct d.iddocente
		from  docente d,detallecontratodocente dc,contratodocente c
		left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
		dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente
		and c2.codigoestado like '1%'
		and dc2.codigoestado like '1%'
		)
		left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
		where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente 
		)
		and d.codigoestado like '1%'
		group by d.iddocente
		union
		select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca2.nombrecarrera Nombre_Carrera,ca2.codigocarrera 
		from  docente d,grupo g,carrera ca,carrera ca2,materia m,contratodocente cp, detallecontratodocente dcp
		where
		d.numerodocumento =g.numerodocumento and
		g.codigoperiodo in ('".$this->codigoperiodo."') and
		g.codigomateria = m.codigomateria and
		m.codigocarrera=ca.codigocarrera
		and ca.codigocarrera = '".$codigocarrera."'
		and d.numerodocumento <> '1'
		and cp.iddocente=d.iddocente
		and dcp.idcontratodocente=cp.idcontratodocente
		and dcp.codigocarrera <> '".$codigocarrera."'
		and d.iddocente not in(
		select distinct d.iddocente
		from  docente d,detallecontratodocente dc,contratodocente c
		left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
		dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente
		and c2.codigoestado like '1%'
		and dc2.codigoestado like '1%'
		)
		left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
		where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and  dc.codigocarrera = '".$codigocarrera."'
		)
		and dcp.codigocarrera=ca2.codigocarrera
		and d.codigoestado like '1%'
		group by d.iddocente		
		";
	
		$operacion=$this->db->query($query);
		if($imprimir)
		echo $query;
	
		//$operacion=$objetobase->conexion->query($query);
		//$row_operacion=$operacion->fetchRow();
				$tabla="estadisticodocente";
				$fila["codigocarrera"]=$codigocarrera;
				$fila["fechaestadisticodocente"]=date("Y-m-d");
				$fila["codigoperiodo"]=$this->codigoperiodo;
				$fila["codigoestado"]="100";
				$condicionactualiza="  codigocarrera=".$fila["codigocarrera"].
						" and fechaestadisticodocente='".$fila["fechaestadisticodocente"]."'".
						" and codigoperiodo='".$fila["codigoperiodo"]."'";
		
				$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		
				$datosestadisticodocente=$this->objetobase->recuperar_datos_tabla("estadisticodocente","codigoperiodo",$this->codigoperiodo," and fechaestadisticodocente = '".date("Y-m-d")."'  and codigocarrera= '".$codigocarrera."'","",0);
		
		
				while ($row_operacion=$operacion->fetchRow())
				{
					if($row_operacion["codigocarrera"]==$codigocarrera){
						$arrayinterno[]=$row_operacion["iddocente"];
		
						$tabladetalle="detalleestadisticodocente";
						$filadetalle["idestadisticodocente"]=$datosestadisticodocente["idestadisticodocente"];
						$filadetalle["iddocente"]=$row_operacion["iddocente"];
						$filadetalle["codigoestado"]="100";
						$condicionactualiza=" idestadisticodocente=".$datosestadisticodocente["idestadisticodocente"].
						" and iddocente=".$filadetalle["iddocente"];			
		
						$this->objetobase->insertar_fila_bd($tabladetalle,$filadetalle,0,$condicionactualiza);
		
						
					}
				}
		}
		return $arrayinterno;
	}
	/*Retorna un array con codigos de carrera .El listado de carreras depende de las opciones de los parametros de entrada*/
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
			
			
		}
		return $arrayinterno;
		
	}
	/*Consulta de docentes por edad*/
	function rangoEdad($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="18";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
					$arrayinterno["Menor de 15 años"][$codigocarrerai]=0;
					$arrayinterno["15 a 20 años"][$codigocarrerai]=0;
					$arrayinterno["21 a 25 años"][$codigocarrerai]=0;
					$arrayinterno["26 a 30 años"][$codigocarrerai]=0;
					$arrayinterno["31 a 35 años"][$codigocarrerai]=0;
					$arrayinterno["36 a 40 años"][$codigocarrerai]=0;
					$arrayinterno["41 a 45 años"][$codigocarrerai]=0;	
					$arrayinterno["Mayor de 45 años"][$codigocarrerai]=0;	
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select
						count(distinct d0.iddocente) menor_de_15,
						count(distinct d1.iddocente) entre_15_y_20,
						count(distinct d2.iddocente) entre_21_y_25,
						count(distinct d3.iddocente) entre_26_y_30,
						count(distinct d4.iddocente) entre_31_y_35,
						count(distinct d5.iddocente) entre_36_y_40,
						count(distinct d6.iddocente) entre_41_y_45,
						count(distinct d7.iddocente) mayor_de_45,
						count(distinct d.iddocente) total 
					from 
					docente d
						left join docente d0 on d.iddocente=d0.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d0.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d0.fechanacimientodocente,5))) < 15 
						
						left join docente d1 on d.iddocente=d1.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d1.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d1.fechanacimientodocente,5))) between 15 and 20
						
						left join docente d2 on d.iddocente=d2.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d2.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d2.fechanacimientodocente,5))) between 21 and 25
						
						left join docente d3 on d.iddocente=d3.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d3.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d3.fechanacimientodocente,5))) between 26 and 30
						
						left join docente d4 on d.iddocente=d4.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d4.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d4.fechanacimientodocente,5))) between 31 and 35
						
						left join docente d5 on d.iddocente=d5.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d5.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d5.fechanacimientodocente,5))) between 36 and 40
						
						left join docente d6 on d.iddocente=d6.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d6.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d6.fechanacimientodocente,5))) between 41 and 45
						
						left join docente d7 on d.iddocente=d7.iddocente and
						((YEAR(CURRENT_DATE) - YEAR(d7.fechanacimientodocente))-
						(RIGHT(CURRENT_DATE,5) < RIGHT(d7.fechanacimientodocente,5))) > 45
					where d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					//$operacion=$objetobase->conexion->query($query);
					//$row_operacion=$operacion->fetchRow();
					while ($row=$operacion->fetchRow())
					{
			
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
	
	/********GENERO******/
	function rangoGenero($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="17";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombregenero nombretipo
			FROM  genero  ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select g.nombregenero,count(distinct d.iddocente) conteo from docente d , genero g where d.iddocente='".$iddocente."' and d.codigogenero=g.codigogenero
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/*****NIVEL EDUCATIVO*****/
	function rangoNivelEducacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="16";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretiponivelacademico nombretipo
			FROM  tiponivelacademico where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="SELECT if(n.nombretiponivelacademico is null,'No diligencia',n.nombretiponivelacademico) nombrenivelacademico,count(distinct d.iddocente) conteo FROM docente d
	
					left join nivelacademicodocente nd on d.iddocente=nd.iddocente
					and nd.codigotiponivelacademico = (select min(n2.codigotiponivelacademico) 
							from tiponivelacademico n2,nivelacademicodocente nd2 where nd2.codigotiponivelacademico=n2.codigotiponivelacademico and nd2.iddocente=d.iddocente)
					and nd.codigoestado like '1%'
					left join tiponivelacademico n on n.codigotiponivelacademico=nd.codigotiponivelacademico
					where d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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


	/*****NACIONALIDAD*****/
	function rangoNacionalidad($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){


		$variableestadistico="15";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		

		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayinterno["Extranjeros"][$codigocarrerai]=0;
				$arrayinterno["Nacionales"][$codigocarrerai]=0;
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="SELECT 	
					count(distinct d2.iddocente) Extranjeros,
					count(distinct d3.iddocente) Nacionales
					from docente d
					left join docente d2  on  d2.iddocente=d.iddocente and d2.idciudadnacimiento=2000
					left join docente d3  on  d3.iddocente=d.iddocente and d3.idciudadnacimiento<>2000
					where d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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

	/*****LINEA DE INVESTIGACION*****/
	function rangoLineaInvestigacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){


		$variableestadistico="14";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arrayinterno["Linea de investigación"][$codigocarrerai]=0;
				$arrayinterno["No registra"][$codigocarrerai]=0;
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
					count(distinct le.iddocente) enlineainvestigacion,
					(count(distinct d.iddocente) - count(distinct le.iddocente)) No_Registra
					FROM docente d
					left join lineainvestigaciondocente le on le.iddocente=d.iddocente
					and le.codigoestado like '1%'
					WHERE d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/*****PARTICIPACION EN BIENESTAR****/
	function rangoParticipacionBienestar($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="13";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipoparticipacionuniversitaria nombretipo
			FROM  tipoparticipacionuniversitaria where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tpe.nombretipoparticipacionuniversitaria is null,'No registra',tpe.nombretipoparticipacionuniversitaria) tipoparticipacion,
						count(distinct d.iddocente) conteo
						FROM  docente d
						left join participacionuniversitariadocente pe on pe.iddocente=d.iddocente
						and pe.codigoestado like '1%'
						left join tipoparticipacionuniversitaria tpe on pe.codigotipoparticipacionuniversitaria=tpe.codigotipoparticipacionuniversitaria
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
						group by tpe.codigotipoparticipacionuniversitaria";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***PARTICIPACION GOBIERNO***/
	function rangoParticipacionGobierno($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="12";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipoconsejouniversidad nombretipo
			FROM  tipoconsejouniversidad where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tpe.nombretipoconsejouniversidad is null,'No registra',tpe.nombretipoconsejouniversidad) tipoparticipacion,
						count(distinct eg.iddocente) conteo
						FROM  docente eg
						left join participacionuniversitariadocente pe on pe.iddocente=eg.iddocente
						and pe.codigoestado like '1%'
						and pe.codigotipoconsejouniversidad <> 400
						left join tipoconsejouniversidad tpe on pe.codigotipoconsejouniversidad=tpe.codigotipoconsejouniversidad
						and tpe.codigotipoconsejouniversidad <> 400
						WHERE eg.iddocente='".$iddocente."'
						and eg.codigoestado like '1%'
					
							group by tpe.codigotipoconsejouniversidad";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***ASOCIACIONES***/
	function rangoAsociacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="11";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipoasociaciondocente nombretipo
			FROM  tipoasociaciondocente where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tpe.nombretipoasociaciondocente is null,'No registra',tpe.nombretipoasociaciondocente) tipoparticipacion,
						count(distinct d.iddocente) conteo
						FROM docente d
						left join asociaciondocente pe on pe.iddocente=d.iddocente
						and pe.codigoestado like '1%'
						left join tipoasociaciondocente tpe on pe.codigotipoasociaciondocente=tpe.codigotipoasociaciondocente
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
							group by tpe.codigotipoasociaciondocente";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***ESTIMULOS****/
	function rangoEstimulo($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="10";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipoestimulodocente nombretipo
						FROM  tipoestimulodocente where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tpe.nombretipoestimulodocente is null,'No registra',tpe.nombretipoestimulodocente) tipoparticipacion,
						count(distinct d.iddocente) conteo
						FROM docente d
						left join estimulodocente pe on pe.iddocente=d.iddocente
						and pe.codigoestado like '1%'
						left join tipoestimulodocente tpe on pe.codigotipoestimulodocente=tpe.codigotipoestimulodocente
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
							group by tpe.codigotipoestimulodocente";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***RECONOCIMIENTOS****/
	function rangoReconocimiento($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="9";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		

		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				//foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno["Reconocimientos"][$codigocarrerai]=0;
				$arrayinterno["No Registra"][$codigocarrerai]=0;		
				//}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
	
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						count(distinct re.iddocente) conteo,
						(count(distinct d.iddocente)-count(distinct re.iddocente)) No_Registra
						FROM docente d
						left join reconocimientodocente re on re.iddocente=d.iddocente
						and re.codigoestado like '1%'
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
						group by d.iddocente";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
					$arrayinterno["Reconocimientos"][$codigocarrerai]+=$row["conteo"];
					$arrayinterno["No Registra"][$codigocarrerai]+=$row["No_Registra"];
	
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
	/***HISTORICO DOCENTES***/
	function rangoHistorico($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$resultperiodo=$this->objetobase->recuperar_resultado_tabla("periodo","1","1","  and codigoperiodo between 20061 and '".$this->codigoperiodo."'","",0);
		$tmpperiodoinicial=$this->codigoperiodo;
		while($rowperiodo = $resultperiodo->fetchRow()){
			$this->codigoperiodo=$rowperiodo["codigoperiodo"];
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				//echo "<br><br>";
				$arrayinterno[$rowperiodo["codigoperiodo"]][$codigocarrerai]=count($arraydocente);
				
			}
		}
		$this->codigoperiodo=$tmpperiodoinicial;
		return $arrayinterno;
	}

        /***HISTORICO DOCENTES PERIODO***/
	function rangoHistoricoXPeriodoActivo($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

		$resultperiodo=$this->objetobase->recuperar_resultado_tabla("periodo","1","1","  and codigoperiodo = '".$this->codigoperiodo."'","",0);
		$tmpperiodoinicial=$this->codigoperiodo;
		while($rowperiodo = $resultperiodo->fetchRow()){
			//$this->codigoperiodo=$rowperiodo["codigoperiodo"];
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				//echo "<br><br>";
				$arrayinterno[$codigocarrerai]=count($arraydocente);
                        }
		}
		//$this->codigoperiodo=$tmpperiodoinicial;
		return $arrayinterno;
	}

	/***CONTRATO DOCENTE****/
	function rangoContrato($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="8";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipocontrato nombretipo
						FROM  tipocontrato where codigoestado like '1%' ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
	
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tpc.nombretipocontrato is null,'Sin contrato activo',tpc.nombretipocontrato) tipocontrato,
						count(distinct d.iddocente) conteo
						FROM docente d
						left join contratodocente cd on d.iddocente = cd.iddocente
						and cd.codigoestado like '1%' and cd.idcontratodocente in (select dcd2.idcontratodocente from detallecontratodocente dcd2 where dcd2.idcontratodocente=cd.idcontratodocente and dcd2.codigocarrera='".$codigocarrerai."')
						and cd.idcontratodocente in (	
							select c2.idcontratodocente from contratodocente c2, periodo p2 where c2.idcontratodocente=cd.idcontratodocente and 
							c2.codigoestado like '1%'
							and (c2.fechainiciocontratodocente between p2.fechainicioperiodo and  p2.fechavencimientoperiodo
							or  c2.fechafinalcontratodocente between p2.fechainicioperiodo and p2.fechavencimientoperiodo
							or p2.fechainicioperiodo between c2.fechainiciocontratodocente and c2.fechafinalcontratodocente
							or p2.fechavencimientoperiodo between c2.fechainiciocontratodocente and c2.fechafinalcontratodocente
							)
							and p2.codigoperiodo ='".$this->codigoperiodo."'
						)
						left join tipocontrato  tpc on cd.codigotipocontrato=tpc.codigotipocontrato
	
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
						group by d.iddocente";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
					$arrayinterno[$row["tipocontrato"]][$codigocarrerai]+=$row["conteo"];
	
	
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
	/***IDIOMA***/

	function rangoIdioma($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="7";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombreidioma nombretipo
						FROM  idioma ";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
	
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(i.nombreidioma is null,'No es bilingüe',i.nombreidioma) idioma,
						count(distinct d.iddocente) conteo
						FROM docente d
						left join idiomadocente id on id.iddocente = d.iddocente
						and id.codigoestado like '1%'
						left join idioma  i on i.ididioma=id.ididioma
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
						group by i.ididioma";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
					$arrayinterno[$row["idioma"]][$codigocarrerai]+=$row["conteo"];
	
	
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
	/***NIVEL ACADEMICO PARA FORMACION DISCIPLINAR***/
	function rangoNivelEducacionDisciplinar($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="6";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretiponivelacademico nombretipo
						FROM  tiponivelacademico where  codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="SELECT if(n.nombretiponivelacademico is null,'No diligencia',n.nombretiponivelacademico) nombrenivelacademico,count(distinct d.iddocente) conteo FROM docente d
	
					left join nivelacademicodocente nd on d.iddocente=nd.iddocente
					and nd.codigotiponivelacademico = (select min(n2.codigotiponivelacademico) 
							from tiponivelacademico n2,nivelacademicodocente nd2 where nd2.codigotiponivelacademico=n2.codigotiponivelacademico
							and nd2.codigotipoformacion='100'
							and nd2.iddocente=d.iddocente)
					and nd.codigotipoformacion='100'
					and nd.codigoestado like '1%'
					left join tiponivelacademico n on n.codigotiponivelacademico=nd.codigotiponivelacademico
					where d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***NIVEL ACADEMICO PARA FORMACION DOCENCIA***/
	function rangoNivelEducacionDocencia($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="5";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretiponivelacademico nombretipo
						FROM  tiponivelacademico where  codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){

			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="SELECT if(n.nombretiponivelacademico is null,'No diligencia',n.nombretiponivelacademico) nombrenivelacademico,count(distinct d.iddocente) conteo FROM docente d
	
					left join nivelacademicodocente nd on d.iddocente=nd.iddocente
					and nd.codigotiponivelacademico = (select min(n2.codigotiponivelacademico) 
							from tiponivelacademico n2,nivelacademicodocente nd2 where nd2.codigotiponivelacademico=n2.codigotiponivelacademico
							and nd2.codigotipoformacion='200'
							and nd2.iddocente=d.iddocente)
					and nd.codigotipoformacion='200'
					and nd.codigoestado like '1%'
					left join tiponivelacademico n on n.codigotiponivelacademico=nd.codigotiponivelacademico
					where d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***NIVEL ACADEMICO PARA FORMACION INVESTIGACION***/
	function rangoNivelEducacionInvestigacion($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="4";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretiponivelacademico nombretipo
						FROM  tiponivelacademico where  codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){


			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="SELECT if(n.nombretiponivelacademico is null,'No diligencia',n.nombretiponivelacademico) nombrenivelacademico,count(distinct d.iddocente) conteo FROM docente d
	
					left join nivelacademicodocente nd on d.iddocente=nd.iddocente
					and nd.codigotiponivelacademico = (select min(n2.codigotiponivelacademico) 
							from tiponivelacademico n2,nivelacademicodocente nd2 where nd2.codigotiponivelacademico=n2.codigotiponivelacademico
							and nd2.codigotipoformacion='300'
							and nd2.iddocente=d.iddocente)
					and nd.codigotipoformacion='300'
					and nd.codigoestado like '1%'
					left join tiponivelacademico n on n.codigotiponivelacademico=nd.codigotiponivelacademico
					where d.iddocente='".$iddocente."'
					and d.codigoestado like '1%'";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
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
	/***MANEJO DE TECNOLOGIAS DE LA INFORMACION***/
	function rangoManejoTic($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){

		$variableestadistico="3";
		$arraycarrera=$this->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		
		$query="select nombretipotecnologiainformacion nombretipo
						FROM  tipotecnologiainformacion where  codigoestado like '1%'";
		if($imprimir)
			echo $query;
		$opertipo=$this->db->query($query);
		while ($rowtipo=$opertipo->fetchRow())
		{
			$arraytipo[]=$rowtipo["nombretipo"];
		}
		
		if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				foreach($arraytipo as $llavetipo=>$nombretipo){
				$arrayinterno[$nombretipo][$codigocarrerai]=0;				
				}
			}

		if(!$this->consultaCarrerasVariable($arraycarrera,$variableestadistico)||($this->enlinea)){


	
			if(is_array($arraycarrera))
			foreach($arraycarrera as $llave=>$codigocarrerai){
				$arraydocente=$this->docentesFacultad($codigocarrerai);
				if(is_array($arraydocente))
	
				foreach($arraydocente as $llavedocente=>$iddocente){
					
					$query="select 
						if(tti.nombretipotecnologiainformacion is null,'No registra',tti.nombretipotecnologiainformacion) tecnologiainformacion,
						count(distinct d.iddocente) conteo
						FROM docente d
						left join tecnologiainformaciondocente ti on ti.iddocente = d.iddocente
						and ti.codigoestado like '1%'
						left join tipotecnologiainformacion  tti on ti.codigotipotecnologiainformacion=tti.codigotipotecnologiainformacion
						WHERE d.iddocente='".$iddocente."'
						and d.codigoestado like '1%'
						group by ti.idtecnologiainformaciondocente";
		
					
					if($imprimir)
					echo $query;
					$operacion=$this->db->query($query);
					while ($row=$operacion->fetchRow())
					{
					$arrayinterno[$row["tecnologiainformacion"]][$codigocarrerai]+=$row["conteo"];
					;
	
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

				$arrayinterno["totalesfinal"][$nombrecolumna]+=$carreravalores[$codigocarrera];

			}
		}	
		
		return $arrayinterno;

	}

	/***Muestra totales por agrupacion Modalidad academica y areadisciplinaria***/
	function porcentajesTotales($funcion,$codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar=""){
		$arrayfuncion=$this->$funcion($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
		$arraycarreras=$this->carrerasDatos($codigomodalidadacademicasic,$codigocarrera,$codigofacultad ,$codigoareadisciplinar);
		
		foreach($arraycarreras as $codigocarrera=>$datoscarrera){
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["carreras"][$codigocarrera]=1;
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["numerocarreras"]++;

			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["areas"][$datoscarrera["codigoareadisciplinar"]]["carreras"][$codigocarrera]=1;
			
			$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]["areas"][$datoscarrera["codigoareadisciplinar"]]["totalcarreras"]++;
	
			foreach($arrayfuncion as $nombrecolumna=>$carreravalores){	
				$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]
				["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];

				$arrayinterno[$datoscarrera["codigomodalidadacademicasic"]]
				["areas"]
				[$datoscarrera["codigoareadisciplinar"]]
				["arraytotales"][$nombrecolumna]+=$carreravalores[$codigocarrera];
				
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