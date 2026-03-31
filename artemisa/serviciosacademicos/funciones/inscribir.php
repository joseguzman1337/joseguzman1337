<?php
/**
* @modifed Ivan dario quintero rios <quinteroivan@unbosque.edu.co>
* @since Mayo 8 del 2019
* Limpieza de codigo, conexion de dase de datos
* Definicion de seccion para validar cuando el registro de pago esta en al anterior pasarela de pagos
*/

class inscribirEstudiante {
    function hacerInscripcion($db, $numeroordenpago){
        //consulta los datos del estudiantes carrera y periodo
        $query_orden = "SELECT o.codigoperiodo, o.codigoestudiante, es.codigocarrera, es.idestudiantegeneral ".
        " FROM ordenpago o ".
        " INNER JOIN detalleordenpago dor on (dor.numeroordenpago = o.numeroordenpago) ".
        " INNER JOIN concepto c on (dor.codigoconcepto = c.codigoconcepto) ".
        " INNER JOIN estudiante es on (es.codigoestudiante = o.codigoestudiante) ".
        " WHERE o.numeroordenpago = '".$numeroordenpago."' ". 
        " AND c.cuentaoperacionprincipal = '153' ".
        " AND es.codigosituacioncarreraestudiante = '106'";      
        $row_orden = $db->GetRow($query_orden);

        if (isset($row_orden['codigoperiodo']) && !empty($row_orden['codigoperiodo'])){
            //consulta el id de inscripcion del estudiante
            $query_inscripcion = "SELECT i.idinscripcion FROM inscripcion i ".
            " inner join estudiantecarrerainscripcion eci on (i.idinscripcion = eci.idinscripcion) ".
            " WHERE eci.codigocarrera = '".$row_orden['codigocarrera']."' ".
            " and i.codigoperiodo = '".$row_orden['codigoperiodo']."' ".
            " and i.idestudiantegeneral = '".$row_orden['idestudiantegeneral']."' ".
            " and i.codigoestado = '100' and eci.idnumeroopcion = 1";        
            $inscripcion = $db->GetRow($query_inscripcion);

            if (isset($inscripcion['idinscripcion']) && !empty($inscripcion['idinscripcion'])){
                //Actualiza el registro del estudiante a 107: inscrito
                $query_updinscripcion = "update inscripcion ".
                " set codigosituacioncarreraestudiante = '107' ".
                " where idinscripcion = '".$inscripcion['idinscripcion']."'";            
                $db->Execute($query_updinscripcion);

                //Si el estudiante tiene notas en el histórico entonces se actualiza el periodo de la cohorte
                $query_idgeneral = "SELECT idestudiantegeneral FROM estudiante where ".
                " codigoestudiante = '".$row_orden['codigoestudiante']."' and codigoperiodo = '".$row_orden['codigoperiodo']."' ".
                " and codigosituacioncarreraestudiante = 106";  
                $idgeneral = $db->GetRow($query_idgeneral);

                if(isset($idgeneral['idestudiantegeneral']) && !empty($idgeneral['idestudiantegeneral'])){
                      // Debe actualizar el periodo de la cohorte y la situación del estudiante
                      $query_updestudiante = "update estudiante ".
                      " set codigosituacioncarreraestudiante = '107', codigoperiodo = '".$row_orden['codigoperiodo']."' ".
                      " where codigoestudiante = '".$row_orden['codigoestudiante']."'";
                      $db->Execute($query_updestudiante);
                  }//if
            }//if   
        }
    }//function hacerInscripcion
}//class
