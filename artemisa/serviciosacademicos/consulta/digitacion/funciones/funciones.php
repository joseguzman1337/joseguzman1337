<?php
/*
 * Clase encargada las funciones estaticas para la digitacion de notas
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since Febrero 16, 2017
*/

require_once("../../../kint/Kint.class.php");
//@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
//@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
require_once('../../Connections/sala2.php');

class Funciones{
	/*
	 * Funcion estatica para validar los permisos de ingreso a la página
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 16, 2017
	*/
	static function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
	    $isValid = False;
		//ddd($UserName);
	    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
	    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
	    if (!empty($UserName)) {
	        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
	        // Parse the strings into arrays.
	        $arrUsers = Explode(",", $strUsers);
	        $arrGroups = Explode(",", $strGroups);
	        if (in_array($UserName, $arrUsers)) {
	            $isValid = true;
	        }
	        // Or, you may restrict access to only certain users based on their username.
	        if (in_array($UserGroup, $arrGroups)) {
	            $isValid = true;
	        }
	        if (($strUsers == "") && true) {
	            $isValid = true;
	        }
	    }
	    return $isValid;
	}
	
	/*
	 * Funcion estatica para retornar los cursos (carreras)
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 16, 2017
	*/
	static function getCursos($database_sala, $sala, $colname_cursos){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_cursos = "SELECT *
						   FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
						  WHERE g.numerodocumento = '".$colname_cursos."'
						  	AND c.codigocarrera = m.codigocarrera
						  	AND g.codigomateria = m.codigomateria
						  	AND m.codigoestadomateria = '01'
						  	AND g.codigoestadogrupo like '1%'
						  	AND g.codigoperiodo = cp.codigoperiodo
						  	AND p.codigoperiodo = cp.codigoperiodo
						  	AND p.codigoestadoperiodo = '3'
						  	AND cp.codigoestado like '1%'
						  	AND cp.codigocarrera = c.codigocarrera";
		//AND g.codigomaterianovasoft = m.codigomaterianovasoft
		//echo $query_cursos;
		$cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
		return $cursos;
	}
	
	/*
	 * Funcion estatica para retornar los cursos (carreras) con otra condicion en el codigo estado periodo
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getCursos2($database_sala, $sala, $colname_cursos){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_cursos = "SELECT *
						   FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
						  WHERE g.numerodocumento = '".$colname_cursos."'
						    AND c.codigocarrera = m.codigocarrera
						    AND g.codigomateria = m.codigomateria
						    AND m.codigoestadomateria = '01'
						    AND g.codigoestadogrupo like '1%'
						    AND g.codigoperiodo = cp.codigoperiodo
						    AND p.codigoperiodo = cp.codigoperiodo
						    AND p.codigoestadoperiodo = '1'
						    AND cp.codigoestado like '1%'
						    AND cp.codigocarrera = c.codigocarrera";
		//AND g.codigomaterianovasoft = m.codigomaterianovasoft
		//echo $query_cursos;
		$cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
		return $cursos;
	}
	
	/*
	 * Funcion estatica para retornar los Estudiantes
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getEstudiantes($database_sala, $sala, $grupos){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_estudiantes ="SELECT e.codigoestudiante, eg.numerodocumento, eg.nombresestudiantegeneral,
									eg.apellidosestudiantegeneral
							   FROM prematricula p,detalleprematricula d,estudiante e,estudiantegeneral eg
							  WHERE eg.idestudiantegeneral = e.idestudiantegeneral
							    AND p.codigoestudiante = e.codigoestudiante
							    AND p.idprematricula = d.idprematricula
							    AND d.idgrupo = '".$grupos."'
							    AND p.codigoestadoprematricula LIKE '4%'
							    AND d.codigoestadodetalleprematricula LIKE '3%'
						   ORDER BY 4";
		$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
		return $estudiantes;
	}
	
	/*
	 * Funcion estatica para retornar las Fechas
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getFecha($database_sala, $sala, $materias, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_fecha ="SELECT *
						 FROM corte c,materia g
						WHERE c.codigomateria = '".$materias."'
						  AND c.codigoperiodo = '".$periodoactual."'
						  AND c.codigomateria = g.codigomateria
						  AND g.codigoestadomateria = '01' ";
								
		$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
		return $fecha;
	}
	
	/*
	 * Funcion estatica para retornar las Fechas (Version 2, se cambian las condiciones y se agrega un order by)
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getFecha2($database_sala, $sala, $facultades, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_fecha = "SELECT *
						  FROM corte
						 WHERE codigocarrera = '".$facultades."'
						   AND codigoperiodo = '".$periodoactual."'
					  ORDER BY numerocorte";
		
		$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
		return $fecha;
	}
	
	/*
	 * Funcion estatica para retornar los Nombres Materias
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getNombreMateria($database_sala, $sala, $materias, $grupos, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_nombremateria = "SELECT materia.nombremateria, materia.codigomateria
								  FROM materia,grupo
								 WHERE grupo.codigomateria = '".$materias."'
								   AND grupo.idgrupo = '".$grupos."'
								   AND grupo.codigomateria = materia.codigomateria
								   AND materia.codigoestadomateria = '01'
								   AND grupo.codigoperiodo = '".$periodoactual."'";
		
		$nombremateria = mysql_query($query_nombremateria, $sala) or die(mysql_error());
		return $nombremateria;
	}
	
	/*
	 * Funcion estatica para retornar los docentes
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getDocente($database_sala, $sala, $colname_docente){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_docente = "SELECT * 
							FROM docente
						   WHERE numerodocumento = '".$colname_docente."'";
		
		$docente = mysql_query($query_docente, $sala) or die(mysql_error());
		return $docente;
	}
	
	/*
	 * Funcion estatica para retornar las Areas
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getArea($database_sala, $sala, $idgrupo, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_area = "SELECT *
						 FROM notaarea n
						WHERE n.idgrupo = '".$idgrupo."'
						  AND n.codigoperiodo = '".$periodoactual."'
						  AND n.codigoestadonotaarea LIKE '1%'";
	
	    $area = mysql_query($query_area,$sala) or die(mysql_error());
		return $area;
	}
	
	/*
	 * Funcion estatica para retornar las Areas2 (Se cambia la condicion para el quiery)
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getArea2($database_sala, $sala, $colname_docente, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_area = "SELECT *
						 FROM notaarea n
						WHERE n.numerodocumento = '".$colname_docente."'
						  AND n.codigoperiodo = '".$periodoactual."'
						  AND n.codigoestadonotaarea LIKE '1%'";
	
	    $area = mysql_query($query_area,$sala) or die(mysql_error());
		return $area;
	}
	
	/*
	 * Funcion estatica para retornar los cursos (carreras) con otra condicion y otras tablas
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getCursos3($database_sala, $sala, $idgrupo, $periodoactual){
		//  Query real
		mysql_select_db($database_sala, $sala);
		$query_cursos = "SELECT *
						   FROM grupo g,materia m,carrera c
						  WHERE g.idgrupo = '".$idgrupo."'
						  	AND c.codigocarrera = m.codigocarrera
						  	AND g.codigomateria = m.codigomateria
						  	AND g.codigoperiodo = '".$periodoactual."'
						  	AND m.codigoestadomateria = '01'";
        
		$cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
		return $cursos;
	}
	
	/*
	 * Funcion estatica para retornar los estudiantes de una materia  en determinado corte
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getEstudiantes1($database_sala, $sala, $codigoestudiante, $i, $periodoactual, $materias){
		//  Query real
		mysql_select_db($database_sala, $sala);
		
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Se corrige la condicion que estaba generando el error en p.codigoperiodo = "20162"
		 * caso de inconsintencia de notas reportado por Diana Rojas - Registro y Control Académico <dianarojas@unbosque.edu.co>
		 * Fecha: 15 de febrero de 2017, 18:07
		 * Asunto: Inconsistencia notas
		 * @since  Febrero 17, 2017
		*/
		$query_estudiantes1 =' SELECT c.idcorte, d.idgrupo
								 FROM corte c
						    LEFT JOIN materia m ON (m.codigomateria = c.codigomateria OR m.codigocarrera = c.codigocarrera)
						   INNER JOIN detalleprematricula d ON (d.codigomateria = m.codigomateria AND d.codigoestadodetalleprematricula = 30)
						   INNER JOIN prematricula p ON (
														      p.idprematricula = d.idprematricula 
													      AND p.codigoestudiante = "'.$codigoestudiante.'"
													      AND p.codigoperiodo = c.codigoperiodo 
													      AND p.codigoestadoprematricula LIKE "4%"
													     )
							    WHERE c.numerocorte = "'.$i.'"
							      AND c.codigoperiodo = "'.$periodoactual.'"
							      AND m.codigomateria = "'.$materias.'" 
								  and m.codigomateria = c.codigomateria
						     ORDER BY d.idgrupo desc';
		  /*AND p.codigoperiodo = "20162" Andres ariza <- creo que este periodo NO deberia estar quemado*/		
		$estudiantes1 = mysql_query($query_estudiantes1,$sala) OR die(mysql_error());
		return $estudiantes1;
	}
	
	/*
	 * Funcion estatica para retornar los estudiantes de una materia  en determinado corte
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getEstudiantes12($database_sala, $sala, $codigoestudiante, $i, $periodoactual, $materias){
		//  Query real
		mysql_select_db($database_sala, $sala);
		
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Se corrige la condicion que estaba generando el error en p.codigoperiodo = "20162"
		 * caso de inconsintencia de notas reportado por Diana Rojas - Registro y Control Académico <dianarojas@unbosque.edu.co>
		 * Fecha: 15 de febrero de 2017, 18:07
		 * Asunto: Inconsistencia notas
		 * @since  Febrero 17, 2017
		*/
		$query_estudiantes1 = ' SELECT c.idcorte, d.idgrupo
								  FROM corte c
							 LEFT JOIN materia m ON (m.codigomateria = c.codigomateria OR m.codigocarrera = c.codigocarrera)
							INNER JOIN detalleprematricula d ON (d.codigomateria = m.codigomateria AND d.codigoestadodetalleprematricula = 30)
							INNER JOIN prematricula p ON (
														      p.idprematricula = d.idprematricula
														   AND p.codigoestudiante = "'.$codigoestudiante.'"
														   /*AND p.codigoperiodo = "20162" Andres ariza <- creo que este periodo NO deberia estar quemado*/
														   AND p.codigoperiodo = c.codigoperiodo 
														   AND p.codigoestadoprematricula LIKE "4%"
														  )
								 WHERE c.numerocorte = "'.$i.'"
								   AND c.codigoperiodo = "'.$periodoactual.'"
								   AND m.codigomateria = "'.$materias.'"
								   AND c.codigomateria <> "1"
							  ORDER BY d.idgrupo desc';
           
		     
		//echo $query_estudiantes1.' <br /><br /> ';
	    $estudiantes1 = mysql_query($query_estudiantes1,$sala) OR die(mysql_error());
		return $estudiantes1;
	}
	
	/*
	 * Funcion estatica para retornar la Nota
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getNota($database_sala, $sala, $idcorteactivo, $grupos){
		//  Query real
		mysql_select_db($database_sala, $sala);
		
		$query_nota="SELECT *
					   FROM nota n
					  WHERE idcorte = '".$idcorteactivo."'
					    AND idgrupo = '".$grupos."'";

		$nota = mysql_query($query_nota,$sala) OR die(mysql_error());
		return $nota;
	}

	/*
	 * Funcion estatica para retornar los detalles de la Nota
	 * @author Andres Ariza <arizaandres@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @since Febrero 17, 2017
	*/
	static function getDetallesNota($database_sala, $sala, $idcorteactivo, $grupos){
		//  Query real
		mysql_select_db($database_sala, $sala);
		
		$query_detallenota="SELECT *
							  FROM detallenota
							 WHERE idcorte = '".$idcorteactivo."'
							   AND idgrupo = '".$grupos."'";  
        
		$detallenota = mysql_query($query_detallenota,$sala) OR die(mysql_error());
		return $detallenota;
	}
}
?>