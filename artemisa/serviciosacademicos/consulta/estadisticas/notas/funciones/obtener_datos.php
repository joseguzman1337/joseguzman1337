<?php
class estadisticasNotas
{
	var $conexion;
	var $codigoperiodo;
	var $codigocarrera;
	var $semestre;
	var $depurar;
	var $codigoestudiante;
	var $fechahoy;
	var $nivelInforme='semestral';
	var $obj;
	var $array_estudiantes=array();
	var $array_materias=array();
	var $array_codigomaterias_leidas=array();
	var $array_cortes_materias=array();
	var $array_definitivas_estudiantes=array();
	var $array_notas_estudiantes=array();
	var $array_historico_situacion_estudiante=array();


	function estadisticasNotas(&$conexion,$codigoperiodo,$depurar=false)
	{
		$this->conexion=&$conexion;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->codigoperiodo=$codigoperiodo	;
		$this->depurar=$depurar;
		if($this->depurar==true)
		{
			$this->conexion->debug=true;
		}
	}

	function leeCantidadSemestresCarrera($codigocarrera)
	{
		$this->codigocarrera=$codigocarrera;
		$query="SELECT MAX(pe.cantidadsemestresplanestudio) as cantidadsemestres
		FROM carrera c, planestudio pe
		WHERE
		pe.codigocarrera=c.codigocarrera
		AND pe.codigoestadoplanestudio=100
		AND '$this->fechahoy' >= pe.fechainioplanestudio
		AND '$this->fechahoy' <= pe.fechavencimientoplanestudio
		AND c.codigocarrera='$codigocarrera'
		GROUP by c.codigocarrera
		";
		$array_interno=$this->ejecutarQuery($query,"array","Leer estudiantes carrera x semestre");
		return $array_interno[0]['cantidadsemestres'];
	}

	function leeEstudiantesSemestre($codigoperiodo,$codigocarrera,$semestre)
	{
		$this->codigocarrera=$codigocarrera;
		$query = "SELECT
		e.codigoestudiante,p.idprematricula,p.semestreprematricula, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento
		FROM estudiante e, prematricula p, estudiantegeneral eg
		WHERE
		e.codigoestudiante = p.codigoestudiante
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND p.codigoperiodo = '".$codigoperiodo."'
		AND e.codigocarrera = '$codigocarrera'
		AND p.codigoestadoprematricula LIKE '4%'
		AND p.semestreprematricula='$semestre'
		ORDER BY 1";
		$array_interno=$this->ejecutarQueryLlave($query,"codigoestudiante","array","Leer estudiantes carrera x semestre");
		$this->array_estudiantes=$array_interno;
		$this->semestre=$semestre;
		return $array_interno;
	}

	function leerEstudiantesCarrera($codigocarrera,$codigoperiodo)
	{
		$cantidad_semestres=$this->leeCantidadSemestresCarrera($codigocarrera);
		for ($i=1;$i<=$cantidad_semestres;$i++)
		{
			$array_interno=$this->leeEstudiantesSemestre($codigoperiodo,$codigocarrera,$i);
			foreach ($array_interno as $llave => $valor)
			{
				$array_estudiantes_carrera[]=$valor;
			}
		}
		$this->array_estudiantes=$array_estudiantes_carrera;
	}

	function leeMateriasEstudiante($codigoperiodo,$semestre,$codigoestudiante)
	{
		$query = "SELECT e.codigoestudiante,m.codigomateria,p.semestreprematricula
		FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g
		WHERE p.idprematricula = dp.idprematricula
		AND dp.codigomateria= m.codigomateria	
		AND dp.idgrupo = g.idgrupo	
		AND e.codigoestudiante = p.codigoestudiante
		AND g.codigoperiodo = '".$codigoperiodo."'
		AND m.codigoestadomateria = '01'
		AND e.codigoestudiante = '$codigoestudiante'
		AND p.codigoestadoprematricula LIKE '4%'
		AND dp.codigoestadodetalleprematricula  LIKE '3%'
		AND p.semestreprematricula = '".$semestre."'	
		ORDER BY 2";
		//$array_interno=$this->ejecutarQueryLlave($query,"codigomateria","array","Leer materias estudiante");
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();

		do
		{
			if($row_operacion['codigomateria']<>"")
			{
				$array_interno[$row_operacion["codigomateria"]]=$row_operacion;
				$this->array_codigomaterias_leidas[]=$row_operacion['codigomateria'];
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		if(isset($array_interno))
		{
			return $array_interno;
		}
		else
		{
			return false;
		}

	}

	function leeNotasEstudianteMateriaCorte($codigoestudiante,$codigomateria,$codigoperiodo,$numerocorte)
	{
		$query="SELECT DISTINCT dn.codigoestudiante,dn.nota
		FROM grupo g, materia m, detallenota dn,corte c 
		WHERE g.idgrupo = dn.idgrupo 
		AND dn.idcorte = c.idcorte 
		AND g.codigomateria = m.codigomateria									
		AND m.codigomateria = '$codigomateria'
		AND c.idcorte = dn.idcorte 
		AND c.numerocorte = '$numerocorte'
		AND c.codigoperiodo = '$codigoperiodo'
		AND dn.codigoestudiante = '$codigoestudiante'
		ORDER BY 1
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion['nota'];
	}

	function creaArrayNotasPorCorte()
	{
		$contador=0;
		foreach ($this->array_estudiantes as $llave_est => $valor_est)
		{
			foreach ($this->array_cortes_materias as $llave_cort => $valor_cort)
			{
				$array_notas[$contador]['codigoestudiante']=$llave_est;
				$array_notas[$contador]['numerocorte']=$valor_cort['numerocorte'];
				$array_notas[$contador]['codigomateria']=$valor_cort['codigomateria'];
				$array_notas[$contador]['nota']=$this->leeNotasEstudianteMateriaCorte($llave_est,$valor_cort['codigomateria'],$this->codigoperiodo,$valor_cort['numerocorte']);
				$array_notas[$contador]['porcentajecorte']=$valor_cort['porcentajecorte'];
				$contador++;
			}
		}
	}

	function leeHistoricoSituacionEstudiante($codigoestudiante)
	{
		$query="SELECT
		hse.codigoestudiante,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		sce.nombresituacioncarreraestudiante as situacion,
		hse.codigosituacioncarreraestudiante as codigosituacion,
		hse.codigoperiodo as periodo,
		hse.fechahistoricosituacionestudiante as fecha,
		hse.fechainiciohistoricosituacionestudiante as fechainicio,
		hse.fechafinalhistoricosituacionestudiante as fechafinal,
		hse.usuario
		FROM historicosituacionestudiante hse, situacioncarreraestudiante sce, estudiantegeneral eg, estudiante e
		WHERE
		hse.codigoestudiante='$codigoestudiante'
		AND hse.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND hse.codigoestudiante=e.codigoestudiante
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		";
		$array_interno=$this->ejecutarQuery($query);
		return $array_interno;
	}

	function LeerMateriasArrayEstudiantes()
	{
		foreach ($this->array_estudiantes as $llave => $valor)
		{
			$array_interno=$this->leeMateriasEstudiante($this->codigoperiodo,$valor['semestreprematricula'],$valor['codigoestudiante']);
			$array_materias_estudiantes[$llave]=$array_interno;
		}
		$this->array_materias=$array_materias_estudiantes;
	}

	function leerHistoricoArrayEstudiantes()
	{
		foreach ($this->array_estudiantes as $llave => $valor)
		{
			$array_interno=$this->leeHistoricoSituacionEstudiante($valor['codigoestudiante']);
			$array_historico_estudiantes[$llave]=$array_interno;
		}
		$this->array_historico_situacion_estudiante=$array_historico_estudiantes;
	}

	function leeCortesyDatosMaterias()
	{
		$array=array_unique($this->array_codigomaterias_leidas);
		foreach ($array as $llave => $valor)
		{
			$query="SELECT codigomateria,nombremateria,notaminimaaprobatoria,notaminimahabilitacion FROM materia WHERE codigomateria='".$valor."'";
			$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			if($row_operacion['codigomateria']<>"")
			{
				$array_mat[$row_operacion['codigomateria']]=array('codigomateria'=>$row_operacion['codigomateria'],'nombremateria'=>ereg_replace(" ","_",$row_operacion['nombremateria']),"notaminimaaprobatoria"=>$row_operacion['notaminimaaprobatoria'],"notaminimahabilitacion"=>$row_operacion["notaminimahabilitacion"]);
			}
		}

		$this->array_codigomaterias_leidas=$array_mat;

		foreach ($this->array_codigomaterias_leidas as $llave => $valor)
		{
			
			$query="SELECT distinct '".$valor['codigomateria']."' as codigomateria,
					c.numerocorte,
					c.porcentajecorte,
					dn.idcorte
					FROM detallenota dn,corte c
					WHERE c.codigoperiodo = '".$this->codigoperiodo."'
					and dn.idcorte = c.idcorte											
					and dn.codigomateria = '".$valor['codigomateria']."'											
					ORDER BY c.codigomateria									
					";
					
			if($valor['codigomateria']==1161)
			{
				//echo $query,"<br>";
			}
			
			$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			do
			{
				if($row_operacion['idcorte']<>"")
				{
					$array_interno[]=$row_operacion;
				}
				else
				{
					$query2="SELECT distinct '$valor' as codigomateria,c.numerocorte,c.porcentajecorte,dn.idcorte
					FROM detallenota dn,corte c
					WHERE c.codigoperiodo = '".$this->codigoperiodo."'
					and dn.idcorte = c.idcorte											
					and c.codigocarrera = '$this->codigocarrera'
					ORDER BY 1
					";
					$operacion2=$this->conexion->query($query2);
					$row_operacion2=$operacion2->fetchRow();
					if($row_operacion2['idcorte']<>"")
					{
						$array_interno[]=$row_operacion2;
					}
				}
			}
			while ($row_operacion=$operacion->fetchRow());
			$array[$valor['codigomateria']]=$array_interno;
			if($valor['codigomateria']==1161)
			{
				//$this->DibujarTabla($array_interno);
			}
			unset($array_interno);
		}

		if (is_array($array))
		{
			$this->array_cortes_materias=$array;
			return $array;
		}
		else
		{
			echo "<h1>No se encontraron cortes en ninguna materia, para este periodo</h1>";
			exit();
		}
		return $array;
	}

	function calculaNotaDefinitivaMateria($codigomateria,$codigoestudiante)
	{
		$contador_existe_nota=0;
		$cant_cortes=count($this->array_cortes_materias[$codigomateria]);
		$acumulado=0;
		if(is_array($this->array_cortes_materias[$codigomateria]))
		foreach ($this->array_cortes_materias[$codigomateria] as $llave => $valor)
		{
			$nota=$this->leeNotasEstudianteMateriaCorte($codigoestudiante,$codigomateria,$this->codigoperiodo,$valor['numerocorte']);

			if (empty($nota))
			{
				$existenota=false;
			}
			else
			{
				$existenota=true;
				$contador_existe_nota++;
			}

			$calculo=$nota * $valor['porcentajecorte']/100;


			//$calculo=round($calculo*10)/10;



			$acumulado=$acumulado+$calculo;

			if($codigoestudiante==25711 and $codigomateria==88)
			{
				echo $acumulado,"<br>";
			}

			//$acumulado=round($acumulado,1);


			if($existenota)
			{
				$this->array_notas_estudiantes[]=array('codigoestudiante'=>$codigoestudiante,'codigomateria'=>$codigomateria,'numerocorte'=>$valor['numerocorte'],'porcentajecorte'=>$valor['porcentajecorte'],'nota'=>$nota,'existenota'=>$existenota);
			}
		}
		if($contador_existe_nota >0)
		{
			$this->array_definitivas_estudiantes[]=array('codigoestudiante'=>$codigoestudiante,'codigomateria'=>$codigomateria,'notadefinitiva'=>$acumulado,'existennotas'=>$contador_existe_nota);
		}

		if($contador_existe_nota > 0)
		{
			//para redondear y quitar un decimal
			return round($acumulado,1);
			//return $acumulado;
		}
		else
		{
			return false;
		}
	}

	function cuentaMateriasPerdidas($codigoestudiante)
	{
		$conteo=0;
		foreach ($this->array_definitivas_estudiantes as $llave => $valor)
		{
			if($valor['codigoestudiante']==$codigoestudiante)
			{
				if($valor['notadefinitiva']<>0 and $valor['notadefinitiva'] < $this->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimaaprobatoria'] and $valor['existennotas'] > 0)
				{
					$conteo++;
				}
			}
		}
		return $conteo;
	}

	function ejecutarQuery($query,$retorno='array',$nombretransaccion=null)
	{
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());

		if($retorno=='array')
		{
			return $array_interno;
		}
		elseif($retorno=='conteo')
		{
			return count($array_interno);
		}
	}

	function ejecutarQueryLlave($query,$llave,$retorno='array',$nombretransaccion=null)
	{
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[$row_operacion[$llave]]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());

		if($retorno=='array')
		{
			return $array_interno;
		}
		elseif($retorno=='conteo')
		{
			return count($array_interno);
		}
	}


	/*function EscribirCabeceras($matriz)
	{
	echo "<tr>\n";
	echo "<td>Conteo</a></td>\n";
	while($elemento = each($matriz))
	{
	echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
	}*/

	function creaArrayGeneral()
	{
		//print_r($this->array_cortes_materias);
		$contador=0;


		foreach ($this->array_estudiantes as $llave_est => $valor_est)
		{
			$cont_prueba_academica=0;
			$array_interno[$contador]['codigoestudiante']=$valor_est['codigoestudiante'];
			$array_interno[$contador]['nombre']=$valor_est['nombre'];
			$array_interno[$contador]['numerodocumento']=$valor_est['numerodocumento'];
			foreach ($this->array_historico_situacion_estudiante[$valor_est['codigoestudiante']] as $llave_hist => $valor_hist)
			{
				if($valor_hist['codigosituacion']=='100')
				{
					$cont_prueba_academica++;
				}
			}
			$array_interno[$contador]['cant_perdida_calidad_est']=$cont_prueba_academica;
			foreach ($this->array_codigomaterias_leidas as $llave_mat => $valor_mat)
			{
				$nombremateria=ereg_replace('\.',"",$valor_mat['nombremateria']);
				$nombremateria=ereg_replace(',',"",$nombremateria);

				$array_interno[$contador][$valor_mat['codigomateria']."-".$nombremateria]=$this->calculaNotaDefinitivaMateria($valor_mat['codigomateria'],$valor_est['codigoestudiante']);
			}
			$array_interno[$contador]['cant_materias_perdidas']=$this->cuentaMateriasPerdidas($valor_est['codigoestudiante']);
			$contador++;
		}
		return $array_interno;
	}


	function EscribirCabeceras($matriz)
	{
		echo "<tr>\n";
		echo "<td>Conteo</a></td>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function DibujarTabla($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border='1' cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP><h1>$texto</h1></caption>\n";
			$this->EscribirCabeceras($matriz[0]);
			for($i=0; $i < count($matriz); $i++)
			{
				$MostrarConteo=$i+1;
				echo "<tr>\n";
				echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}

	}
}
?>
<?php
/*
* PHP Base Library
*
* Copyright (c) 1998-2000 NetUSE AG
*                    Boris Erdmann, Kristian Koehntopp,
*                    Jeffrey Galbraith
*
* $Id: obtener_datos.php,v 1.28 2007/01/26 17:54:33 Abraham Castro Exp $
*
* History: 990617: Modularized entire table class. Modularity breaks larger
*                  objects into smaller, autonomous objects in order to
*                  exercise OOP requirements of code reuse. This give
*                  programmers the ability to use the high-level code, or
*                  get down and dirty with the low-level code.
*                  Everything I have changed should maintain backwards
*                  compatibility, except for show_table_heading_row_result(),
*                  which was unpreventable in order to get the full
*                  magnitude of OOP.
*          990618: Added table_cell_open(), table_cell_close(),
*                  table_heading_cell_open() and table_heading_cell_close().
*                  Gives better modularity to class.(JSG)
*          990619: Added $add_extra. If set, calls extra cell functions:
*                  table_heading_row_add_extra and table_row_add_extra.
*                  Override these functions in a derived class to add
*                  additional cells to a row of output data.
*          990620: Added column name remapping. This allows the column names
*                  of a database to be remapped into something more useful,
*                  or, perhaps, another language. Array variable "map_cols"
*                  added. (JSG)
*          020424: Fix various undefined variable warnings and a typo in
*                  show_table_heading_cells.
*          020428: Add option to pass full row data to table_row_open.
*                  Default is to pass column names, as was the behaviour
*                  prior to this change.
*/

#==========================================================================
# Table (class)
#--------------------------------------------------------------------------
# Creates an HTML table based on either a PHP array or a
# database result.
#==========================================================================

class Table {
	var $classname = "Table";              ## Persistence Support

	var $check;                            ## if set, create checkboxes named
	## to the result of $check[$key]
	var $filter = "[A-Za-z][A-Za-z0-9_]*"; ## Regexp: Field names to show
	var $fields;                           ## Array of field names to show
	var $heading;                          ## if set, create <th> section
	var $add_extra;                        ## Call extra cell functions
	var $map_cols;                         ## remap database columns to new names
	var $full_data_to_table_row_open = 0;  ## if set, pass full row data to
	## table_row_open, else just column
	## names (the original behaviour)

	#==========================================================================
	## Public functions
	#==========================================================================



	#==========================================================================
	## Page functions
	#==========================================================================

	#==========================================================================
	# Function : start
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a two-dimensional array in an HTML table
	#            format.
	# Arguments: $ary   - The 2D array to display.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments : See function: show
	# History  :
	#==========================================================================
	function start($ary, $class="") {
		return ($this->show($ary, $class));
	}

	#==========================================================================
	# Function : start_result
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a database query result in an HTML table
	#            format.
	# Arguments: $db    - The database result.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments : See function: show_result
	# History  :
	#==========================================================================
	function start_result($db, $class="") {
		return ($this->show_result($db, $class));
	}

	#==========================================================================
	# Function : show
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a two-dimensional array in an HTML table
	#            format.
	# Arguments: $ary   - The 2D array to diaplay.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments :
	# History  : 990616 - removed redundant code.(JSG)
	#==========================================================================
	function show($ary, $class="") {
		if (!$this->verify_2d_array($ary)) {
			return 0;
		}

		$rows = 0;

		$this->table_open($class);
		if ($this->show_table_heading_row($ary, $class)) {
			$rows = $this->show_table_rows($ary, $class);
		}
		$this->table_close($class);

		return $rows;
	}

	#==========================================================================
	# Function : show_result
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a database query result in an HTML table
	#            format.
	# Arguments: $db    - The database result.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments :
	# History  :
	#==========================================================================
	function show_result($db, $class="") {
		if (!$this->verify_db($db)) {
			return 0;
		}

		$rows = 0;

		$this->table_open($class);
		if ($this->show_table_heading_row_result($db, $class)) {
			$rows = $this->show_table_rows_result($db, $class);
		}
		$this->table_close($class);

		return $rows;
	}

	#==========================================================================
	# Function : show_page
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a two-dimensional array in an HTML table
	#            format. Only the rows $start to $start+$num are displayed.
	# Arguments: $ary   - The 2D array to diaplay.
	#            $start - The starting row to display.
	#            $num   - The number of rows to display.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments :
	# History  :
	#==========================================================================
	function show_page($ary, $start, $num, $class ="") {
		if (!$this->verify_2d_array($ary)) {
			return 0;
		}

		$rows = 0;

		$this->table_open($class);
		if ($this->show_table_heading_row($ary, $class)) {
			$rows = $this->show_table_page_rows($ary, $start, $num, $class="");
		}
		$this->table_close($class);

		return $rows;
	}

	#==========================================================================
	# Function : show_result_page
	#--------------------------------------------------------------------------
	# Purpose  : Starts the display of a database object in an HTML table
	#            format. Only the rows $start to $start+$num are displayed.
	# Arguments: $db    - The database result.
	#            $start - The starting row to display.
	#            $num   - The number of rows to display.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed.
	# Comments :
	# History  :
	#==========================================================================
	function show_result_page($db, $start, $num, $class="") {
		if (!$this->verify_db($db)) {
			return 0;
		}

		$rows = 0;

		$this->table_open($class);
		if ($this->show_table_heading_row_result($db, $class)) {
			$rows = $this->show_table_page_rows_result($db, $start, $num, $class);
		}
		$this->table_close($class);

		return $rows;
	}



	#==========================================================================
	## Row functions
	#==========================================================================

	#==========================================================================
	# Function : show_table_heading_row
	#--------------------------------------------------------------------------
	# Purpose  : Uses the passed array to create an HTML header row.
	# Arguments: $ary   - The array to use.
	#            $class - [optional] Used for CSS control.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  :
	#==========================================================================
	function show_table_heading_row($ary, $class="") {
		if (!$this->verify_2d_array($ary)) {
			return 0;
		}

		if (isset($this->heading) && $this->heading) {
			reset($ary);
			list($key, $val) = each($ary);
			$this->table_heading_row($val, $class);
		}

		return 1;
	}

	#==========================================================================
	# Function : show_table_heading_row_result
	#--------------------------------------------------------------------------
	# Purpose  : Uses the passed database object to create an HTML header row.
	# Arguments: $db    - The database object
	#            $class - [optional] Used for CSS control.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  :
	#==========================================================================
	function show_table_heading_row_result($db, $class="") {
		if (!$this->verify_db($db)) {
			return 0;
		}

		if ($this->heading) {
			if ($db->next_record()) {
				$this->table_heading_row($db->Record, $class);
				$db->seek($db->Row-1);
				return 1;
			}
			else {
				return 0;
			}
		}
		return 1;
	}

	#==========================================================================
	# Function : table_heading_row
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to create a table heading row.
	# Arguments: $data  - The array of data that represents cells within a row.
	#            $class - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  : 990618 - Fixed return on select_colnames (JSG).
	#          : 020424 - Assume $row = 0 for header.  Avoid PHP uninitialized
	#                     variable error (LEH).
	#          : 020428 - Pass whole $data array to table_row_open if
	#                     $this->full_data_to_table_row_open is set.
	#==========================================================================
	function table_heading_row($data, $class="") {
		$row = 0;
		if (!is_array($data)) {
			return;
		}

		if ($this->full_data_to_table_row_open) {
			$this->table_row_open($row, $data, $class);
		} else {
			$d = $this->select_colnames($data);
			$this->table_row_open($row, $d, $class);
		}
		$this->set_checkbox_heading($class);
		$this->show_table_heading_cells($data, $class);

		# call virtual function
		if (isset($this->add_extra) && $this->add_extra) {
			$this->table_heading_row_add_extra($data, $class);
		}

		$this->table_row_close(0, $class);
	}

	#==========================================================================
	# Function : show_table_rows
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed array displaying each row of data as an HTML
	#            table row.
	# Arguments: $ary   - The array of data to display.
	#            $class - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function show_table_rows($ary, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_rows()<br>\n");
		}

		if (!$this->verify_2d_array($ary)) {
			return 0;
		}

		$row = 0;

		reset($ary);
		while(list($key, $val) = each($ary)) {
			## Process a single row
			$this->table_row($row++, $key, $val, $class);
		}

		return $row;
	}

	#==========================================================================
	# Function : show_table_rows_result
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed database object displaying each record as an
	#            HTML table row.
	# Arguments: $db    - The database object
	#            $class - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  : 990617 - fixed return. Was "row" changed to "$row".
	#==========================================================================
	function show_table_rows_result($db, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_rows_result()<br>\n");
		}

		if (!$this->verify_db($db)) {
			return 0;
		}

		$row = 0;

		while($db->next_record()) {
			## Process a table row
			$this->table_row($row, $row, $db->Record, $class);
			$row++;
		}

		return $row;
	}

	#==========================================================================
	# Function : show_table_page_rows
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed array displaying each row of data as an HTML
	#            table row. However, data does not start displaying until
	#            $start element and end after $num rows.
	# Arguments: $ary   - The array object.
	#            $start - Start row displaying at this element.
	#            $num   - The number of rows to display.
	#            $class - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  : 990616 - $row was incrementing (++) in for loop and within
	#                     the table_row function call.
	#==========================================================================
	function show_table_page_rows($ary, $start, $num, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_page_rows()<br>\n");
		}

		if (!$this->verify_2d_array($ary)) {
			return 0;
		}

		$row = 0;

		$max = count($ary);
		if (($start < 0 ) || ($start > $max)) {
			return 0;
		}
		$max = min($start+$num, $max);

		for ($row = $start; $row < $max; $row++) {
			## Process a single row
			$this->table_row($row, $row, $ary[$row], $class);
		}

		return ($row - $start);
	}

	#==========================================================================
	# Function : show_table_page_rows_result
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed database object displaying each record as an
	#            HTML table row. However, data does not start displaying until
	#            $start record and ends after $num records have been displayed.
	# Arguments: $db    - The database object.
	#            $start - Start row displaying at this record.
	#            $num   - The number of rows to display.
	#            $class - [optional] Used for CSS control.
	# Returns  : The number of rows displayed
	# Comments :
	# History  :
	#==========================================================================
	function show_table_page_rows_result($db, $start, $num, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_page_rows_result()<br>\n");
		}

		if (!$this->verify_db($db)) {
			return 0;
		}

		$row = $start;
		$fin = $start + $num;

		$db->seek($start);
		while($db->next_record() && ($row < $fin)) {
			## Process a table row
			$this->table_row($row, $row, $db->Record, $class);
			$row++;
		}

		return ($row - $start);
	}

	#==========================================================================
	# Function : table_row
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to create a table row. Calls all of the
	#            cell-related functions.
	# Arguments: $row     -
	#            $row_key -
	#            $data    - The array of data that represents cells within a row.
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  : 020428 - Pass whole $data array to table_row_open if
	#                     $this->full_data_to_table_row_open is set.
	#==========================================================================
	function table_row($row, $row_key, $data, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>table_row()<br>\n");
		}

		if ($this->full_data_to_table_row_open) {
			$this->table_row_open($row, $data, $class);
		} else {
			$d = $this->select_colnames($data);
			$this->table_row_open($row, $d, $class);
		}
		$this->set_checkbox($row, $row_key, $data, $class);
		$this->show_table_cells($row, $row_key, $data, $class);

		# call virtual function
		if (isset($this->add_extra) && $this->add_extra) {
			$this->table_row_add_extra($row, $row_key, $data, $class);
		}

		$this->table_row_close($row, $class);
	}



	#==========================================================================
	## Field/Cell functions
	#==========================================================================

	#==========================================================================
	# Function : set_checkbox_heading
	#--------------------------------------------------------------------------
	# Purpose  : This function creates an empty header cell to coincide with
	#            the checkbox option for that column.
	# Arguments: $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function set_checkbox_heading($class="") {
		global $debug;

		if ($debug) {
			printf("<p>set_checkbox_heading()<br>\n");
		}

		## Checkbox handling...
		if (isset($this->check) && $this->check) {
			$this->table_heading_cell(0, "&nbsp;", $class);
		}
	}

	#==========================================================================
	# Function : set_checkbox
	#--------------------------------------------------------------------------
	# Purpose  : Creates an HTML checkbox based on the passed data, only if
	#            the member variable $check is set.
	# Arguments: $row     - The row number.
	#            $row_key - The row key.
	#            $data    - The data array.
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function set_checkbox($row, $row_key, $data, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>set_checkbox()<br>\n");
		}

		## Checkbox handling...
		if (isset($this->check) && $this->check) {
			$this->table_checkbox_cell($row, $row_key, $data, $class);
		}
	}

	#==========================================================================
	# Function : show_table_heading_cells
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed array and displays each item in an HTML table
	#            header cell.
	# Arguments: $data    - The data array.
	#            $class   - [optional] Used for CSS control.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  : 990618 - Fixed problem with filtering headers (JSG).
	#          : 020424 - Fixed code typo - changed $cell=0 to $col=0 (LEH).
	#==========================================================================
	function show_table_heading_cells($data, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_heading_cells()<br>\n");
		}

		if (!$this->verify_array($data)) {
			return 0;
		}

		$col = 0;
		$d = $this->select_colnames($data);

		## Create regular cells
		reset($d);
		while(list($key, $val) = each($d)) {
			$this->table_heading_cell($col++, $val, $class);
		}

		return 1;
	}

	#==========================================================================
	# Function : show_table_cells
	#--------------------------------------------------------------------------
	# Purpose  : Walks the passed array and displays each item in an HTML table
	#            cell.
	# Arguments: $row     - The row number.
	#            $row_key - The row key.                  [for derived classes]
	#            $data    - The data array.
	#            $class   - [optional] Used for CSS control.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  :
	#==========================================================================
	function show_table_cells($row, $row_key, $data, $class="") {
		global $debug;

		if ($debug) {
			printf("<p>show_table_cells()<br>\n");
		}

		if (!$this->verify_array($data)) {
			return 0;
		}

		$cell = 0;
		$d = $this->select_colnames($data);

		## Create regular cells
		reset($d);
		while(list($key, $val) = each($d)) {
			if (isset($data[$val])) {
				$this->table_cell($row, $cell++, $val, $data[$val], $class);
			}
		}

		return 1;
	}

	#==========================================================================
	# Function : table_cell
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to render a single cell.
	# Arguments: $row   - The row number.                 [for derived classes]
	#            $col   - The column number.              [for derived classes]
	#            $key   - The key value.                  [for derived classes]
	#            $val   - The data value.
	#            $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments :
	# History  :
	#==========================================================================
	function table_cell($row, $col, $key, $val, $class="") {
		$this->table_cell_open($class);
		printf("%s", $val);
		$this->table_cell_close($class);
	}

	function table_cell_open($class="") {
		printf("  <td%s>",
		$class?" class=$class":"");
	}

	function table_cell_close($class="") {
		printf("</td>\n");
	}

	#==========================================================================
	# Function : table_heading_cell
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to render a single header cell.
	# Arguments: $col   - The column number.              [for derived classes]
	#            $val   - The data value.
	#            $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments :
	# History  : 990620 - Added column remapping.
	#==========================================================================
	function table_heading_cell($col, $val, $class="") {
		$this->table_heading_cell_open($class);

		## Check for column name remapping
		if (isset($this->map_cols) && $this->verify_array($this->map_cols)) {
			reset($this->map_cols);
			while(list($key, $name) = each($this->map_cols)) {
				if ($key == $val) {
					$val = $name;
					break;
				}
			}
		}

		printf("%s", $val);
		$this->table_heading_cell_close($class);
	}

	#==========================================================================
	# Function : table_heading_cell_open
	#--------------------------------------------------------------------------
	# Purpose  : Starts a header cell.
	# Arguments: $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments : Low-level function for table_heading_cell()
	# History  :
	#==========================================================================
	function table_heading_cell_open($class="") {
		printf("  <th%s>", $class?" class=$class":"");
	}

	#==========================================================================
	# Function : table_heading_cell_close
	#--------------------------------------------------------------------------
	# Purpose  : Ends a header cell.
	# Arguments: $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments : Low-level function for table_heading_cell()
	# History  :
	#==========================================================================
	function table_heading_cell_close($class="") {
		printf("</th>\n");
	}

	#==========================================================================
	# Function : table_checkbox_cell
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to display a checkbox. This function runs
	#            if the member variable $check has been set. $check should be
	#            set to some key within the $data array (ex: if $data["myKey"],
	#            then set $check="myKey").
	# Arguments: $row     - The row currently being written.
	#            $row_key - If $data[$this-check] is empty, then this variable
	#                       is used instead.
	#            $data    - An array of data information.
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function table_checkbox_cell($row, $row_key, $data, $class="") {
		if ($this->check) {
			printf("  <td%s><input type=\"checkbox\" name=\"%s[%s]\" value=\"%s\"></td>\n",
			$class?" class=$class":"",
			$this->check,
			$row,
			empty($data[$this->check])?$row_key:$data[$this->check]);
		}
	}

	#==========================================================================
	## Utility functions (used to be in util.inc, but were used only here and
	## did create a lot of confusion on installation) -- KK
	#==========================================================================

	#==========================================================================
	# Function : verify_array
	#--------------------------------------------------------------------------
	# Purpose  : Verifies an array
	# Arguments: $ary   - The array to verify.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  :
	#==========================================================================
	function verify_array($ary) {
		if (!is_array($ary)) {
			return 0;
		}

		return 1;
	}

	#==========================================================================
	# Function : verify_2d_array
	#--------------------------------------------------------------------------
	# Purpose  : Verifies a 2D array
	# Arguments: $ary   - The array to verify.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  : 990616 - Removed "$this->" from "verify_array". (JSG)
	#==========================================================================
	function verify_2d_array($ary) {
		if (!$this->verify_array($ary)) {
			return 0;
		}

		reset($ary);
		if (!is_array(current($ary))) {
			return 0;
		}

		reset($ary);

		return 1;
	}

	#==========================================================================
	# Function : verify_db
	#--------------------------------------------------------------------------
	# Purpose  : Verifies a database object for results.
	# Arguments: $db   - The database object to verify.
	# Returns  : 1 on success, 0 on error.
	# Comments :
	# History  :
	#==========================================================================
	function verify_db($db) {
		if (!isset($db) && !$db) {
			return 0;
		}

		if ($db->num_rows() > 0) {
			return 1;
		}

		return 0;
	}

	#==========================================================================
	# Function : print_array
	#--------------------------------------------------------------------------
	# Purpose  : Debugging function that prints an array
	# Arguments: $ary   - The array to print.
	# Returns  :
	# Comments : Recursive if an array is found within $ary
	# History  :
	#==========================================================================
	function print_array($ary) {
		if (is_array($ary)) {
			while(list($key, $val) = each($ary)) {
				echo "&nbsp;&nbsp;$key = $val<br>\n";
				if (is_array($val)) {
					$this->print_array($val);
				}
			}
		}
	}

	#==========================================================================
	## Helper functions
	#==========================================================================

	#==========================================================================
	# Function : select_colnames
	#--------------------------------------------------------------------------
	# Purpose  : Selects the column names that should be displayed in an HTML
	#            table. This is based on the $fields variable, if set. If it
	#            is not set, then all fields names are used. This is how you
	#            filter displayed data.
	# Arguments: $data - A array containing information about the column
	#                    names. If $fields is not used, then this variable is
	#                    used instead.
	# Returns  : An array containing the column names.
	# Comments :
	# History  :
	#==========================================================================
	function select_colnames($data) {
		global $debug;

		if ($debug) {
			printf("<p>select_colnames()<br>\n");
		}

		if (!(isset($this->fields) && is_array($this->fields)) && is_array($data)) {
			reset($data);
			while(list($key, $val) = each($data)) {
				if (ereg($this->filter, $key)) {
					$this->fields[] = $key;
				}
			}
		}
		$d = $this->fields;

		if ($debug) {
			$this->print_array($d);
			printf("select_colnames() return<br>");
		}

		return $d;
	}

	#==========================================================================
	# Misc. functions
	#==========================================================================

	#--------------------------------------------------------------------------
	## The following functions provide a very basic rendering
	## of a HTML table with CSS class tags. Table is useable
	## with them or the functions can be overridden for a
	## more complex functionality.
	#--------------------------------------------------------------------------

	#--------------------------------------------------------------------------
	## Table open and close functions.
	#--------------------------------------------------------------------------

	#==========================================================================
	# Function : table_open
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to open a table.
	# Arguments: $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments :
	# History  :
	#==========================================================================
	function table_open($class="") {
		global $debug;

		if ($debug) {
			printf("<p>table_open()<br>\n");
		}

		printf("<table%s>\n", $class?" class=$class":"");
	}

	#==========================================================================
	# Function : table_close
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to close a table.
	# Arguments: $class - [optional] Used for CSS control.
	# Returns  : Nothing
	# Comments : $class is not used by this function, but is available for
	#            derived classes that override this function.
	# History  :
	#==========================================================================
	function table_close($class="") {
		global $debug;

		if ($debug) {
			printf("<p>table_close()<br>\n");
		}

		printf("</table>\n");
	}

	## Row open and close functions.

	#==========================================================================
	# Function : table_row_open
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to open a table row.
	# Arguments: $row -   This variable is for derived classes that override
	#                     this function that want access to the row number for
	#                     the row about to be opened.
	#            $data -  This variable is for derived classes that override
	#                     this function that want access to the row data for
	#                     the row about to be opened.
	#            $class - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function table_row_open($row, $data, $class="") {
		printf(" <tr%s>\n", $class?" class=$class":"");
	}

	#==========================================================================
	# Function : table_row_close
	#--------------------------------------------------------------------------
	# Purpose  : Outputs HTML code to close a table row.
	# Arguments: $row -     This variable is for derived classes that override
	#                       this function that want access to the row number
	#                       for the row about to be closed.
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments : $class is not used by this function, but is available for
	#            derived classes that override this function.
	# History  :
	#==========================================================================
	function table_row_close($row, $class="") {
		printf(" </tr>\n");
	}

	#==========================================================================
	## Function overrides
	#==========================================================================

	#==========================================================================
	# Function : table_heading_row_add_extra
	#--------------------------------------------------------------------------
	# Purpose  : Virtual function for derived classes. This function is called
	#            after all header cells have been created. It allows the
	#            programmer to add additional HTML code to the header row
	#            before it is closed.
	# Arguments: $data
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function table_heading_row_add_extra($data, $class="") {
	}

	#==========================================================================
	# Function : table_row_add_extra
	#--------------------------------------------------------------------------
	# Purpose  : Virtual function for derived classes. This function is called
	#            after all cells have been created. It allows the programmer to
	#            add additional HTML code to the row before it is closed.
	# Arguments: $row
	#            $row_key
	#            $data
	#            $class   - [optional] Used for CSS control.
	# Returns  :
	# Comments :
	# History  :
	#==========================================================================
	function table_row_add_extra($row, $row_key, $data, $class="") {
	}
}
?>
