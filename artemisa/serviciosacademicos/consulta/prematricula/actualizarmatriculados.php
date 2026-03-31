<?php
require('DatosActualizacionPrematricula.php');
$ruta = "../../funciones/";
require_once(dirname(__FILE__)."/../../funciones/ordenpago/claseordenpago.php");

function  actualizarValorPrematricula($codigoEstudiante,$codigoperiodo,$codigocarrera){
   $db = Factory::createDbo();

      $ordenPagoActual = ordenPagoPrematriculaAct($db,$codigoEstudiante,$codigoperiodo);
      $updatePrematricula = new DatosActualizacionPrematricula($ordenPagoActual,$codigoEstudiante,$codigoperiodo,
      $codigocarrera);

      if(!in_array($ordenPagoActual['codigoestadoordenpago'],array(40,41))) {
         $semesterCalculado = $updatePrematricula->getCalculoSemestre()->calculoSemestreEstudiantes();
         $updatePrematricula->updatePrematricula($ordenPagoActual['idprematricula'],$semesterCalculado);
         $valorNuevoPrematricula = $updatePrematricula->calculoNuevoValorPrematricula();
         $idNuevaOrden = $updatePrematricula->crearNuevaOrdenPago($ordenPagoActual, $codigoEstudiante);

         //actaulizar la tabla AporteBecas para anular el registro antiguo e insertar el nuevo
         $updatePrematricula->updateAporteBecas($idNuevaOrden);

         //anula la orden actual en sala y people
         $updatePrematricula->anulaOrdenPagoActual();
         $updatePrematricula->updateDetalleOrdenPago($valorNuevoPrematricula, $idNuevaOrden);
         // se inactiva la siguiente funciona para que no se inserten concepto semillas en detalle ordenpago
         //$updatePrematricula->updateDetalleSemillasOrdenPago($idNuevaOrden);
         $updatePrematricula->crearFechaOrdenPago($idNuevaOrden, $valorNuevoPrematricula);
         $updatePrematricula->actualizarOrdenDetallePrematricula($idNuevaOrden);

         $ordenPagoClass = new Ordenpago(getSalaConection(), $codigoEstudiante, $codigoperiodo, $idNuevaOrden);
         //enviar orden a people
         $ordenPagoClass->enviarsap_orden();
      }
}

function getSalaConection()
{
   require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
   $Configuration = Configuration::getInstance();

   $hostname_sala = $Configuration->getHostName();
   $database_sala = $Configuration->getDbName();
   $username_sala = $Configuration->getDbUserName();
   $password_sala = $Configuration->getDbUserPasswd();

   $sala = mysql_connect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR);
   return $sala;
}

function ordenPagoPrematriculaAct($db,$codigoEstudiante,$codigoperiodo) {
// consulta la orden de pago del estudiante activas y pagas de MATRICULA
     $sqlOrdenPagoEstudiante = "select o.* from ordenpago o ".
      " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago ".
      " where codigoestudiante = '".$codigoEstudiante."' ".
      " and o.codigoperiodo = '".$codigoperiodo."' ".
      " and o.codigoestadoordenpago in (10,11,40,41) ".
      " and d.codigoconcepto = '151' order by numeroordenpago desc limit 1";

   $ordenPagoActual = $db->GetRow($sqlOrdenPagoEstudiante);
   if(count($ordenPagoActual)>0){
      return $ordenPagoActual;
   }else {
       return array();
   }
}

function actualizarmatriculadosNew($idgrupo, $codigoperiodo, $codigocarrera, $sala){
    $query_cupoelectiva = "select g.maximogrupoelectiva, m.codigomateria, g.maximogrupo, m.nombremateria, g.idgrupo, m.codigocarrera
   from grupo g, materia m
   where g.codigomateria = m.codigomateria
   and g.codigoperiodo = '$codigoperiodo'
   and g.maximogrupoelectiva > 0
   and g.idgrupo = '$idgrupo'";
   $cupoelectiva = mysql_query($query_cupoelectiva, $sala) or die(mysql_error());
   $totalRows_cupoelectiva = mysql_num_rows($cupoelectiva);
   if($totalRows_cupoelectiva == "")
   {
      $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
      FROM detalleprematricula d, estudiante e, prematricula p
      WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
      and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
      and p.idprematricula = d.idprematricula
      and p.codigoestudiante = e.codigoestudiante
      and e.codigosituacioncarreraestudiante not like '1%'
      and e.codigosituacioncarreraestudiante not like '5%'
      AND d.idgrupo = '$idgrupo'
      and p.codigoperiodo = '$codigoperiodo'";
      $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
      $totalRows_actualizar = mysql_num_rows($actualizar);
      $row_actualizar = mysql_fetch_assoc($actualizar);
      $matriculados = $row_actualizar['matriculados'];

        $SQL='SELECT
            maximogrupo,
            matriculadosgrupo,
            maximogrupoelectiva,
            matriculadosgrupoelectiva
          FROM
            grupo      
          WHERE
            idgrupo="'.$idgrupo.'"';


        $cupoelectiva_2 = mysql_query($SQL, $sala) or die(mysql_error());

        $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva_2);

        if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']<1){
            $query_updgrupo="UPDATE grupo SET 
                            matriculadosgrupo = '$matriculados'
                            WHERE idgrupo = '$idgrupo'";
        }else if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']>0){
            $query_updgrupo="UPDATE grupo SET 
                            matriculadosgrupoelectiva = '$matriculados'
                            WHERE idgrupo = '$idgrupo'";
        }
      //echo "<br> $query_updgrupo";
      $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
   }
   else
   {
      //echo "<br>Hay maximo grupo electiva<br>";
      $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva);
      // Si la carrera es la misma para en la que se encuentra el estudiante
      // Adiciona el cupo en maximocupogrupo tomando solamente los estudiantes de la carrera
      // echo $row_cupoelectiva['codigocarrera']."== $codigocarrera <br>";
      if($row_cupoelectiva['codigocarrera'] == $codigocarrera)
      {
         $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
         FROM detalleprematricula d, estudiante e, prematricula p
         WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
         and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
         and p.idprematricula = d.idprematricula
         and p.codigoestudiante = e.codigoestudiante
         and e.codigosituacioncarreraestudiante not like '1%'
         and e.codigosituacioncarreraestudiante not like '5%'
         AND d.idgrupo = '$idgrupo'
         and p.codigoperiodo = '$codigoperiodo'
         and e.codigocarrera = '$codigocarrera'";
         $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
         $totalRows_actualizar = mysql_num_rows($actualizar);
         $row_actualizar = mysql_fetch_assoc($actualizar);
         $matriculados = $row_actualizar['matriculados'];

         $SQL='SELECT
            maximogrupo,
            matriculadosgrupo,
            maximogrupoelectiva,
            matriculadosgrupoelectiva
          FROM
            grupo      
          WHERE
            idgrupo="'.$idgrupo.'"';


        $cupoelectiva_2 = mysql_query($SQL, $sala) or die(mysql_error());

        $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva_2);

             if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']<1){
                $query_updgrupo="UPDATE grupo SET 
                                matriculadosgrupo = '$matriculados'
                                WHERE idgrupo = '$idgrupo'";
                }else if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']>0){
                    $query_updgrupo="UPDATE grupo SET 
                                    matriculadosgrupoelectiva = '$matriculados'
                                    WHERE idgrupo = '$idgrupo'";
                }
         $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
      }
      else
      {
         // Actualiza el maximogrupoelectiva
         $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
         FROM detalleprematricula d, estudiante e, prematricula p
         WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
         and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
         and p.idprematricula = d.idprematricula
         and p.codigoestudiante = e.codigoestudiante
         and e.codigosituacioncarreraestudiante not like '1%'
         and e.codigosituacioncarreraestudiante not like '5%'
         AND d.idgrupo = '$idgrupo'
         and p.codigoperiodo = '$codigoperiodo'
         and e.codigocarrera = '$codigocarrera'";
         $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
         $totalRows_actualizar = mysql_num_rows($actualizar);
         $row_actualizar = mysql_fetch_assoc($actualizar);
         $matriculados = $row_actualizar['matriculados'];

         $query_updgrupo="UPDATE grupo SET 
         matriculadosgrupoelectiva = '$matriculados'
         WHERE idgrupo = '$idgrupo'";
         //echo "<br> $query_updgrupo";
         $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
      }
   }
}//function name
function actualizarmatriculadosOther($idgrupo, $codigoperiodo, $codigocarrera,$sala){

   $query_cupoelectiva = "select g.maximogrupoelectiva, m.codigomateria, g.maximogrupo, m.nombremateria, g.idgrupo, m.codigocarrera
   from grupo g, materia m
   where g.codigomateria = m.codigomateria
   and g.codigoperiodo = '$codigoperiodo'
   and g.maximogrupoelectiva > 0
   and g.idgrupo = '$idgrupo'";
   $cupoelectiva = mysql_query($query_cupoelectiva, $sala) or die(mysql_error());
   $totalRows_cupoelectiva = mysql_num_rows($cupoelectiva);
   if($totalRows_cupoelectiva == "")
   {
      $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
      FROM detalleprematricula d, estudiante e, prematricula p
      WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
      and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
      and p.idprematricula = d.idprematricula
      and p.codigoestudiante = e.codigoestudiante
      and e.codigosituacioncarreraestudiante not like '1%'
      and e.codigosituacioncarreraestudiante not like '5%'
      AND d.idgrupo = '$idgrupo'
      and p.codigoperiodo = '$codigoperiodo'";
      $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
      $totalRows_actualizar = mysql_num_rows($actualizar);
      $row_actualizar = mysql_fetch_assoc($actualizar);
      $matriculados = $row_actualizar['matriculados'];

        $SQL='SELECT
            maximogrupo,
            matriculadosgrupo,
            maximogrupoelectiva,
            matriculadosgrupoelectiva
          FROM
            grupo      
          WHERE
            idgrupo="'.$idgrupo.'"';


        $cupoelectiva_2 = mysql_query($SQL, $sala) or die(mysql_error());

        $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva_2);


        if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']<1){
            $query_updgrupo="UPDATE grupo SET 
                            matriculadosgrupo = '$matriculados'
                            WHERE idgrupo = '$idgrupo'";
        }else if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']>0){
            $query_updgrupo="UPDATE grupo SET 
                            matriculadosgrupoelectiva = '$matriculados'
                            WHERE idgrupo = '$idgrupo'";
        }
      //cho "<br>1-> $query_updgrupo";die;
      $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
   }
   else
   {
      //echo "<br>Hay maximo grupo electiva<br>";
      $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva);
      // Si la carrera es la misma para en la que se encuentra el estudiante
      // Adiciona el cupo en maximocupogrupo tomando solamente los estudiantes de la carrera
      // echo $row_cupoelectiva['codigocarrera']."== $codigocarrera <br>";
      if($row_cupoelectiva['codigocarrera'] == $codigocarrera)
      {
         $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
         FROM detalleprematricula d, estudiante e, prematricula p
         WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
         and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
         and p.idprematricula = d.idprematricula
         and p.codigoestudiante = e.codigoestudiante
         and e.codigosituacioncarreraestudiante not like '1%'
         and e.codigosituacioncarreraestudiante not like '5%'
         AND d.idgrupo = '$idgrupo'
         and p.codigoperiodo = '$codigoperiodo'
         and e.codigocarrera = '$codigocarrera'";
         $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
         $totalRows_actualizar = mysql_num_rows($actualizar);
         $row_actualizar = mysql_fetch_assoc($actualizar);
         $matriculados = $row_actualizar['matriculados'];

           $SQL='SELECT
            maximogrupo,
            matriculadosgrupo,
            maximogrupoelectiva,
            matriculadosgrupoelectiva
          FROM
            grupo      
          WHERE
            idgrupo="'.$idgrupo.'"';


        $cupoelectiva_2 = mysql_query($SQL, $sala) or die(mysql_error());

        $row_cupoelectiva = mysql_fetch_assoc($cupoelectiva_2);

             if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']<1){
                $query_updgrupo="UPDATE grupo SET 
                                matriculadosgrupo = '$matriculados'
                                WHERE idgrupo = '$idgrupo'";
                }else if($row_cupoelectiva['maximogrupo']>0 && $row_cupoelectiva['maximogrupoelectiva']>0){
                    $query_updgrupo="UPDATE grupo SET 
                                    matriculadosgrupoelectiva = '$matriculados'
                                    WHERE idgrupo = '$idgrupo'";
                }

           // echo "<br>3-> $query_updgrupo";die;
         $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
      }
      else
      {
         // Actualiza el maximogrupoelectiva
         $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
         FROM detalleprematricula d, estudiante e, prematricula p
         WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
         and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
         and p.idprematricula = d.idprematricula
         and p.codigoestudiante = e.codigoestudiante
         and e.codigosituacioncarreraestudiante not like '1%'
         and e.codigosituacioncarreraestudiante not like '5%'
         AND d.idgrupo = '$idgrupo'
         and p.codigoperiodo = '$codigoperiodo'
         and e.codigocarrera = '$codigocarrera'";
         $actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
         $totalRows_actualizar = mysql_num_rows($actualizar);
         $row_actualizar = mysql_fetch_assoc($actualizar);
         $matriculados = $row_actualizar['matriculados'];

         $query_updgrupo="UPDATE grupo SET 
         matriculadosgrupoelectiva = '$matriculados'
         WHERE idgrupo = '$idgrupo'";
         //echo "<br>2-> $query_updgrupo";die;
         $updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
      }
   }
}//function name

?>
