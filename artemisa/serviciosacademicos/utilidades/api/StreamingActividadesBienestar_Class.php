<?php

class StreamingActividadesBienestar {

    var $db;
    
    function __construct($db) {
        $this->db = $db;
    }
//__construct

    function ListarStreamingActividadesBienestar() {
        $SQL = 'SELECT
                    SAB.url,
                    SAB.tipo
                FROM
                    StreamingActividadesBienestar SAB
                WHERE
                    SAB.codigoEstado=100
                ';

        $Datos = $this->db->GetAll($SQL);
        if ($Datos === false) {
            $json["result"] = "ERROR";
            $json["codigoresultado"] = 1;
            $json["mensaje"] = "Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        return $Datos;
    }
//function ListarActividadesBienestar
    
    function TraigaStreamingActividadesBienestar($id) {
        $SQL = 'SELECT
                    SAB.url,
                    SAB.tipo
                FROM
                    StreamingActividadesBienestar SAB
                WHERE
                    SAB.id=?
                    AND SAB.codigoEstado=100
                ';

        $variable[] = "$id";
        $Datos = $this->db->GetAll($SQL, $variable);
        if ($Datos === false) {
            $json["result"] = "ERROR";
            $json["codigoresultado"] = 1;
            $json["mensaje"] = "Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        return $Datos;
    }
//function TraigaActividadesBienestar

    function InsertarStreamingActividadesBienestar($url,$tipo,$usuario,$codigoEstado) {
        $insertar = "INSERT INTO StreamingActividadesBienestar
            (url,
            tipo,
            usuarioCreacion,
            fechaCreacion,
            codigoEstado)
            VALUES
            (?,
            ?,
            ?,
            NOW(),
            ?)
                ";
        $VariablesInsertar = array();
        $VariablesInsertar[] = "$url";
        $VariablesInsertar[] = "$tipo";
        $VariablesInsertar[] = "$usuario";
        $VariablesInsertar[] = "$codigoEstado";

        //$this->db->debug=true;

        $insertarX = $this->db->Execute($insertar, $VariablesInsertar);

        if ($insertarX === false) {
            $json["result"] = "ERROR";
            $json["codigoresultado"] = 1;
            $json["mensaje"] = "Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
    }
    //function InsertarActividadesBienestar

    function ActualizarStreamingActividadesBienestar($url,$tipo,$usuario,$codigoEstado,$id) {
        $actualizar = "UPDATE StreamingActividadesBienestar SET
            url=?,
            tipo=?,
            usuarioModificacion=?,
            fechaModificacion=now(),
            codigoEstado=?
            WHERE
            id=?
                 ";
        $VariablesActualizar = array();
        $VariablesActualizar[] = "$url";
        $VariablesActualizar[] = "$tipo";
        $VariablesActualizar[] = "$usuario";
        $VariablesActualizar[] = "$codigoEstado";
        $VariablesActualizar[] = "$id";

        //$this->db->debug=true;

        $actualizarX = $this->db->Execute($actualizar, $VariablesActualizar);

        if ($actualizarX === false) {
            $json["result"] = "ERROR";
            $json["codigoresultado"] = 1;
            $json["mensaje"] = "Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
    }
    //function ActualizarActividadesBienestar

 
} 

//class
?>

