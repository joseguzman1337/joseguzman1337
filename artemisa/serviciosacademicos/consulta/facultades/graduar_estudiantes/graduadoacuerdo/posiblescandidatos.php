<?php
session_start();
ini_set('max_execution_time','6000');
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../Connections/sala2.php');

require_once('../../../../Connections/salaado.php');
require('funciones/validaciones_2.php');
//require('funciones/generar_cartas.php');

if($_GET['depurar']=='si')
{
	$debug=true;
}
else
{
	$debug=false;
}

$query_periodo_activo="SELECT p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo in (1,3)";
$operacion_periodo_activo=$db->Execute($query_periodo_activo);
$row_periodo_activo=$operacion_periodo_activo->fetchRow();
$codigoperiodo=$row_periodo_activo['codigoperiodo'];

$query_estudiante="select c.codigocarrera,c.nombrecarrera,e.codigoestudiante,
			s.nombresituacioncarreraestudiante,
			e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
			eg.codigogenero
			from estudiantegeneral eg, estudiante e, carrera c,situacioncarreraestudiante s
			where
			e.idestudiantegeneral=eg.idestudiantegeneral and
			c.codigocarrera=e.codigocarrera and
			e.codigosituacioncarreraestudiante in (104, 301) and
			e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante			
			and c.codigomodalidadacademica in(200, 300)
			and e.codigoestudiante not in (SELECT r.codigoestudiante FROM registrograduado r)
                        group by e.codigoestudiante
			order by nombrecarrera,apellidosestudiantegeneral,nombresestudiantegeneral  ";

$estudiante = $db->Execute($query_estudiante) or die("$query_estudiante".mysql_error());;
$totalRows_estudiante = $estudiante->RecordCount();

if($totalRows_estudiante !=""){
     $i=0;
    while($row_estudiante = $estudiante->FetchRow()){
       
        $codigoestudiante=$row_estudiante['codigoestudiante'];        
        $validaciones=new validaciones_requeridas($sala,$codigoestudiante,$codigoperiodo,$debug);
        $valido=$validaciones->verifica_validaciones();        
        $array_materias_pendientes=$validaciones->retorna_array_materias_pendientes();
        $array_materias_actuales=$validaciones->retorna_array_materias_actuales();

        $cuentapendientes=count($array_materias_pendientes);
       if($cuentapendientes==0){
            $query_guardadetalle = "INSERT INTO tmpposiblescandidatosgrado (idtmpposiblescandidatosgrado,
            codigoestudiante, codigoperiodo, fechaconsulta, codigoestado)
            values (0, '$codigoestudiante','$codigoperiodo','$fechahoy',100)";
            $guardadetalle = $db->execute ($query_guardadetalle) or die("$query_guardadetalle".mysql_error());
            
            //echo $i." - ".$codigoestudiante."<br>"; $i++;
       }
        else{
            $cuentaactuales=count($array_materias_actuales);
            if($cuentapendientes == $cuentaactuales || $cuentapendientes < $cuentaactuales){
                $query_guardadetalle = "INSERT INTO tmpposiblescandidatosgrado (idtmpposiblescandidatosgrado,
                codigoestudiante, codigoperiodo, fechaconsulta, codigoestado)
                values (0, '$codigoestudiante','$codigoperiodo','$fechahoy',100)";
                $guardadetalle = $db->execute ($query_guardadetalle) or die("$query_guardadetalle".mysql_error());
                /*echo "<b>".$codigoestudiante."</b><br>";
                //print_r($array_materias_pendientes);
                print_r($array_materias_actuales);
                echo "<br><b> pendientes : ".count($array_materias_pendientes)."</b>";
                echo "<br><b> actuales : ".count($array_materias_actuales)."</b><hr>";*/
            }
        }
        
    }

    
}


?>
