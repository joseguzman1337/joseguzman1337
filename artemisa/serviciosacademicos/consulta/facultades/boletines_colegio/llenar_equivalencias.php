<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
error_reporting(2047);
require("../../../../funciones/conexion/conexionpear.php");
//$query_materias_colegio="select m.* from materia m where codigoestadomateria=01 and codigocarrera=98";
/* $query_materias_colegio="select m.* from materia m 
where codigoestadomateria=01 and (m.codigomateria=2503 or m.codigomateria=2504 or m.codigomateria=9106 or m.codigomateria=9113)";
 */
$query_materias_colegio="select m.* from materia m 
where codigoestadomateria=01 and 
(m.codigomateria=9243)";

$materia_colegio=$sala->query($query_materias_colegio);
$row_materia_colegio=$materia_colegio->fetchRow();
do
{
	$query_insertar_equivalencia_e="insert into notaequivalencia(idusuario,nombrenotaequivalencia, nombrecortoequivalencia, notainicionotaequivalencia,notafinalnotaequivalencia,codigomateria,codigocarrera,codigotipoequivalencianota,fechainicionotaequivalencia,fechafinalnotaequivalencia) values ('1','EXCELENTE','E','4.5','5.0','".$row_materia_colegio['codigomateria']."','98','10','2006-01-01','2999-12-31')";
	$query_insertar_equivalencia_s="insert into notaequivalencia(idusuario,nombrenotaequivalencia, nombrecortoequivalencia, notainicionotaequivalencia,notafinalnotaequivalencia,codigomateria,codigocarrera,codigotipoequivalencianota,fechainicionotaequivalencia,fechafinalnotaequivalencia) values ('1','SOBRESALIENTE','S','4.0','4.49','".$row_materia_colegio['codigomateria']."','98','10','2006-01-01','2999-12-31')";
	$query_insertar_equivalencia_a="insert into notaequivalencia(idusuario,nombrenotaequivalencia, nombrecortoequivalencia, notainicionotaequivalencia,notafinalnotaequivalencia,codigomateria,codigocarrera,codigotipoequivalencianota,fechainicionotaequivalencia,fechafinalnotaequivalencia) values ('1','ACEPTABLE','A','3.0','3.99','".$row_materia_colegio['codigomateria']."','98','10','2006-01-01','2999-12-31')";
	$query_insertar_equivalencia_i="insert into notaequivalencia(idusuario,nombrenotaequivalencia, nombrecortoequivalencia, notainicionotaequivalencia,notafinalnotaequivalencia,codigomateria,codigocarrera,codigotipoequivalencianota,fechainicionotaequivalencia,fechafinalnotaequivalencia) values ('1','INSUFICIENTE','I','2.0','2.99','".$row_materia_colegio['codigomateria']."','98','10','2006-01-01','2999-12-31')";
	$query_insertar_equivalencia_d="insert into notaequivalencia(idusuario,nombrenotaequivalencia, nombrecortoequivalencia, notainicionotaequivalencia,notafinalnotaequivalencia,codigomateria,codigocarrera,codigotipoequivalencianota,fechainicionotaequivalencia,fechafinalnotaequivalencia) values ('1','DEFICIENTE','D','0','1.99','".$row_materia_colegio['codigomateria']."','98','10','2006-01-01','2999-12-31')";
	
	$sala->query($query_insertar_equivalencia_e);
	$sala->query($query_insertar_equivalencia_s);
	$sala->query($query_insertar_equivalencia_a);
	$sala->query($query_insertar_equivalencia_i);
	$sala->query($query_insertar_equivalencia_d);
}
while($row_materia_colegio=$materia_colegio->fetchRow());
?>