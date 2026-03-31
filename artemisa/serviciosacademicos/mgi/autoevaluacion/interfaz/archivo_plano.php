<?php

session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require("../../templates/templateAutoevaluacion.php");
require("funcionesResultados.php");
$db =writeHeaderBD(false);
$id_instrumento=$_REQUEST['id_ins'];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '192M');

/*$time = microtime(TRUE);
$mem = memory_get_usage();
$start = (float) array_sum(explode(' ',microtime()));*/



$sql_pre=queryConseguirPreguntas($id_instrumento);//SQL de Pregutas o titulos

//echo $sql_pre;

$data_pre= $db->Execute($sql_pre);
$informacionDemografica=false;

$sql_publico = "SELECT ao.idsiq_Apublicoobjetivo,ao.estudiante,ao.docente,ao.admin,csv.idsiq_Apublicoobjetivocsv 
					FROM siq_Apublicoobjetivo ao 
					LEFT JOIN siq_Apublicoobjetivocsv csv on csv.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
					 and csv.codigoestado=100
					WHERE idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' and ao.codigoestado=100 
					GROUP BY ao.idsiq_Apublicoobjetivo";
						
$data_publico= $db->GetRow($sql_publico);

/*print_r(array( 
	'memory' => (memory_get_usage() - $mem) / (1024 * 1024),	 
	'seconds' => microtime(TRUE) - $time
));
 
$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time 1: ". sprintf("%.4f", ($end-$start))." seconds"; 

$start = (float) array_sum(explode(' ',microtime()));*/
$C_Preg = $data_pre->GetArray();

$coun_Pre=count($C_Preg)+5; 
 if($informacionDemografica){ 
	$coun_Pre=$coun_Pre+8; 
 }
?>
<html>
<body>
<table border='1'>
<tr>
<td colspan='<?php echo $coun_Pre; ?>' style='background-color:#3E4729; color: white '>
<b><center>Universidad el Bosque, Resultados encuesta <?php echo utf8_decode($C_Preg[0]['nombre'])?></center></b>
</td>
</tr>
<tr>
<td>Participante</td>
<td>Tipo de Participante</td>
<?php if($data_publico["idsiq_Apublicoobjetivocsv"]!==null){ ?>
<td>Unidad de negocio</td>
<td>Área</td>
<?php } else { ?>
<td>Unidad Academica</td>
<td>Edad</td>
<?php } ?>
<td>Género</td>
<?php if($informacionDemografica){ ?>
<td>Colegio</td>
<td>Puntaje total de admisión</td>
<td>Puntaje prueba de estado - ICFES</td>
<td>Puntaje de examen de admisión</td>
<td>Puntaje de entrevista</td>
<td>Semestre</td>
<td>Código Asignatura</td>
<td>Nota final</td>
<?php } 
$cp=0; 
foreach($data_pre as $dt){//coloca las preguntas
     $titulo=$dt['titulo'];
     $titulo=str_replace('<br>', '', $titulo);
     ?>
     <td><?php echo utf8_decode($titulo)?></td>
     <?php
    $cp++;
}
/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time 2: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));*/
?>
</tr>
<?php


/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time 3: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));*/

	/*$sql_user="select cedula, usuariocreacion, codigorol, nombrerol 
			   from siq_Arespuestainstrumento 
			   inner join usuario on (usuariocreacion=idusuario)
			   inner join rol on (codigorol=idrol)
			   where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by usuariocreacion 
			   union
			   select cedula, usuariocreacion, '' as codigorol, '' nombrerol
			   from siq_Arespuestainstrumento 
			   where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by cedula  ";//SQL de usuarios tipos y id's*/
		   
//ESTO ES PARA ARREGLAR DOCENTES Y ESTUDIANTES EL TOTAL  
//PERO TOCA OPTIMIZARLA PORQUE SE DEMORA DIRECTAMENTE EN EL MOTOR 200 SEGS CON INDICES O ALGO
/*$sql_user="select cedula, usuariocreacion, codigorol, nombrerol, a.numerodocumento 
           from siq_Arespuestainstrumento 
           inner join usuario u on (usuariocreacion=idusuario)
						inner join actualizacionusuario a on u.idusuario=a.usuarioid AND a.estadoactualizacion=2 and a.numerodocumento=0
           inner join rol on (codigorol=idrol)
           where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by usuariocreacion 
           union
           select cedula, usuariocreacion, '' as codigorol, '' nombrerol, a.numerodocumento 
           from siq_Arespuestainstrumento 
						inner join actualizacionusuario a on cedula=a.numerodocumento AND a.estadoactualizacion=2 
           where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by cedula"; */

//SOLO DOCENTES
if($data_publico["docente"]==1){
$sql_user = 'SELECT a.idactualizacionusuario, a.usuarioid as usuariocreacion, a.numerodocumento as cedula, g.idgrupo, g.codigomateria, 
			m.nombremateria, c.codigocarrera, c.nombrecarrera, "Docentes" nombrerol 
			FROM actualizacionusuario a INNER JOIN usuario u ON u.idusuario=a.usuarioid 
			AND u.codigorol=2 LEFT JOIN grupo g ON g.numerodocumento=u.numerodocumento 
			LEFT JOIN materia m ON m.codigomateria=g.codigomateria 
			LEFT JOIN carrera c ON c.codigocarrera=m.codigocarrera 
			WHERE a.id_instrumento="'.$id_instrumento.'" AND a.codigoestado=100 AND a.estadoactualizacion=2 
			AND c.codigocarrera is NULL GROUP BY a.idactualizacionusuario
			UNION
			SELECT a.idactualizacionusuario, a.usuarioid as usuariocreacion, a.numerodocumento as cedula, g.idgrupo, g.codigomateria, 
			m.nombremateria, c.codigocarrera, c.nombrecarrera, "Docentes" nombrerol  FROM actualizacionusuario a 
			INNER JOIN usuario u ON u.idusuario=a.usuarioid AND u.codigorol=2 
			LEFT JOIN grupo g ON g.numerodocumento=u.numerodocumento 
			LEFT JOIN materia m ON m.codigomateria=g.codigomateria 
			LEFT JOIN carrera c ON c.codigocarrera=m.codigocarrera 
			WHERE a.id_instrumento="'.$id_instrumento.'" AND a.codigoestado=100 AND a.estadoactualizacion=2 AND c.codigocarrera is Not NULL 
			GROUP BY a.idactualizacionusuario';		
	$data_res= $db->Execute($sql_user);
	pintarResultados($db,$data_res,$id_instrumento,$data_pre);
}
		
//SOLO ESTUDIANTES
if($data_publico["estudiante"]==0){
	$sql_publico = "SELECT dao.* from siq_Apublicoobjetivo ao 
						INNER JOIN siq_Adetallepublicoobjetivo dao on dao.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
						where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' and dao.codigoestado=100 and (dao.E_New=1 or E_Old=1)";
		$data_publico3= $db->GetRow($sql_publico);

	if(count($data_publico3)>0){

		$whereCarrera = "";
		//por materias para 1 semestre
		$sql_publico = "select dao.* from siq_Apublicoobjetivo ao 
						INNER JOIN siq_Adetallepublicoobjetivo dao on dao.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
						where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' and dao.codigoestado=100 and codigocarrera IS NOT NULL 
						and filtro=2 and semestre<>99";
		$data_publico2= $db->GetRow($sql_publico);
		$materias = $data_publico2["cadena"];
		$materias = explode("::", $materias);
		if(count($data_publico2)>0){
			$whereCarrera = ' AND e.codigocarrera="'.$data_publico2["codigocarrera"].'" ';
		}
		
//SOLO ESTUDIANTES
$sql_user = '			SELECT
                        
                        a.idactualizacionusuario,
                        a.usuarioid as usuariocreacion,
						a.numerodocumento as cedula,
                        c.codigocarrera,
                        c.nombrecarrera,
                        e.codigoestudiante,
                        e.idestudiantegeneral,
						"Estudiantes" nombrerol, 
						g.nombregenero,
						eg.fechanacimientoestudiantegeneral as fecha_nacimiento
                        
                        FROM
                        
                        actualizacionusuario a INNER JOIN usuario u ON u.idusuario=a.usuarioid
											   INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
											   INNER JOIN genero g ON g.codigogenero=eg.codigogenero
											   INNER JOIN estudiante  e ON e.idestudiantegeneral=eg.idestudiantegeneral 
											   INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
											   INNER JOIN prematricula p ON e.codigoestudiante=p.codigoestudiante
                                               INNER JOIN siq_Arespuestainstrumento AS sari ON (sari.idsiq_Ainstrumentoconfiguracion = a.id_instrumento) AND sari.usuariomodificacion = a.usuarioid
                        
                        
                        WHERE
                        
                        a.codigoestado=100
                        AND 
                        sari.idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                        AND
                        a.estadoactualizacion=2
                        AND
                        c.codigomodalidadacademica="200" 
                        '.$whereCarrera.' 
                        GROUP BY a.idactualizacionusuario';
                        //echo $sql_user;exit;	
		$data_res= $db->Execute($sql_user);
		/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time 3: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));*/
		pintarResultados($db,$data_res,$id_instrumento,$data_pre);
		/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time 4: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));*/
	}

$sql_publico = "SELECT dao.* from siq_Apublicoobjetivo ao 
						INNER JOIN siq_Adetallepublicoobjetivo dao on dao.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
						where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' and dao.codigoestado=100 and (dao.E_Gra=1)";
		$data_publico3= $db->GetRow($sql_publico);
					
//EGRESADOS
	if(count($data_publico3)>0){
   $sql_user = '		SELECT
                        
                        a.idactualizacionusuario,
                        a.usuarioid as usuariocreacion,
						a.numerodocumento as cedula,
                        c.codigocarrera,
                        c.nombrecarrera,
                        e.codigoestudiante,
                        e.idestudiantegeneral,
						"Estudiantes" nombrerol, 
						g.nombregenero,
						eg.fechanacimientoestudiantegeneral as fecha_nacimiento 
                        
                        FROM
                        
                        actualizacionusuario a INNER JOIN usuario u ON u.numerodocumento=a.numerodocumento
											   INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
											   INNER JOIN genero g ON g.codigogenero=eg.codigogenero
											   INNER JOIN estudiante  e ON e.idestudiantegeneral=eg.idestudiantegeneral 
											   INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                        
                        
                        WHERE
                        
                        a.codigoestado=100
                        AND
                        a.id_instrumento="'.$id_instrumento.'"
                        AND
                        a.estadoactualizacion IN (1,2)
                        
                        GROUP BY a.numerodocumento';
		$data_res= $db->Execute($sql_user);
		pintarResultados($db,$data_res,$id_instrumento,$data_pre);
	}
}

//EXTERNOS
if($data_publico["idsiq_Apublicoobjetivocsv"]!==null){
 $sql_user = 'SELECT
                        
                        a.idactualizacionusuario,
                        "" as usuariocreacion,
						a.numerodocumento as cedula,
                        "" codigocarrera,
                        "" nombrecarrera,
                        "" codigoestudiante,
                        "" idestudiantegeneral,
						(CASE
						WHEN csv.docente=1 THEN "Docente"
						WHEN csv.estudiante=1 THEN "Estudiante"
						WHEN csv.padre=1 THEN "Padre"
						WHEN csv.administrativos=1 THEN "Administrativo"
						WHEN csv.otros=1 THEN "Egresado"
						END) AS nombrerol,
						IF (
							csv.texto3 IS NOT NULL,
							csv.texto3,
							""
						) AS nombrerol2,
						csv.texto as unidad,
						csv.texto2 as area				
                        
                        FROM
                        
                        actualizacionusuario a           
						INNER JOIN siq_Apublicoobjetivocsv csv on csv.cedula=a.numerodocumento and csv.codigoestado=100 
						AND csv.idsiq_Apublicoobjetivo="'.$data_publico["idsiq_Apublicoobjetivo"].'" 
                        
                        WHERE
                        
                        a.codigoestado=100 
                        AND
                        a.id_instrumento="'.$id_instrumento.'"
                        AND
                        a.estadoactualizacion IN (1,2)
                        
                        GROUP BY a.numerodocumento';	
					//echo $sql_user; die;
	/*$sql_user = 'SELECT
                        
                        a.idactualizacionusuario,
                        "" as usuariocreacion,
						a.numerodocumento as cedula,
                        "" codigocarrera,
                        csv.texto as nombrecarrera,
                        "" codigoestudiante,
                        "" idestudiantegeneral,
						IF(csv.texto3 IS NOT NULL,csv.texto3,"Administrativo") AS nombrerol,
						csv.texto as unidad,
						csv.texto2 as area,
							a.entrydate
                        
                        FROM
                        
                        actualizacionusuario a           
						INNER JOIN siq_Apublicoobjetivocsv csv on csv.cedula=a.numerodocumento and csv.codigoestado=100 
						AND csv.idsiq_Apublicoobjetivo="'.$data_publico["idsiq_Apublicoobjetivo"].'" 
                        
                        WHERE
                        
                        a.codigoestado=100 
                        AND
                        a.id_instrumento="'.$id_instrumento.'"
                        AND
                        a.estadoactualizacion IN (1,2)
                        AND a.entrydate>="2014-10-09 13:00:00"
                        GROUP BY a.numerodocumento';	*/
						
		/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time externos 1: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));	*/
	$data_res= $db->Execute($sql_user);
	pintarResultados($db,$data_res,$id_instrumento,$data_pre);
	/*	$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time externos 2: ". sprintf("%.4f", ($end-$start))." seconds"; 
$start = (float) array_sum(explode(' ',microtime()));*/
}	

//echo $sql_user;
  	

echo "</table>";
/*$end = (float) array_sum(explode(' ',microtime())); 
echo "Processing time final: ". sprintf("%.4f", ($end-$start))." seconds"; */
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
</body>
</html>
