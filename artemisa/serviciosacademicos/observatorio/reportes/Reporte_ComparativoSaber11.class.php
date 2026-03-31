<?php
class Reporte_ComparativoSaber11{
    public function CantidadRangosPuntajeEstudiantes($pinicial,$pfinal){
        global $db,$userid;
       
        $query="SELECT
                COUNT(*) as cantidadrango FROM
                resultadopruebaestado
                WHERE
                (resultadopruebaestado.PuntajeGlobal BETWEEN '".$pinicial."' AND '".$pfinal."')";
            
        if($CantEstudiantesRango=&$db->Execute($query)===false){
            echo 'Error en Consulta...<br><br>'.$query;
            die;
        }
        $result=$CantEstudiantesRango->GetArray();
        return $result[0]["cantidadrango"];
    }////CantidadRangosPuntajeEstudiantes()
    
    public function RangosEstudiantes($pinicial,$pfinal){
        global $db,$userid;
        
        $SQL="SELECT
                estudiantegeneral.numerodocumento,
                estudiantegeneral.nombresestudiantegeneral,
                estudiantegeneral.apellidosestudiantegeneral,
                resultadopruebaestado.PuntajeGlobal
            FROM
                resultadopruebaestado
                INNER JOIN estudiantegeneral ON (resultadopruebaestado.idestudiantegeneral = estudiantegeneral.idestudiantegeneral)
            WHERE
                (resultadopruebaestado.PuntajeGlobal BETWEEN '".$pinicial."' AND '".$pfinal."') ORDER BY resultadopruebaestado.PuntajeGlobal DESC";
        if($EstudiantesRangolista=&$db->Execute($SQL)===false){
            echo 'Error en Consulta...<br><br>'.$SQL;
            die;
        }
        $result=$EstudiantesRangolista->GetArray();
        
        return $result;
    }////CantidadRangosPuntajeEstudiantes()

}///Reporte_ComparativoSaber11



?>