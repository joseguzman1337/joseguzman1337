<?php
 
class RegistroActividadesBienestar {

    var $db;   

    function __construct($db) {
        $this->db = $db;
    }
//__construct

    function ListarRegistroActividadesBienestar($id,$idActividadesBienestar) {
        $SQL = 'SELECT
                    RAB.nombre,
                    RAB.email,
                    RAB.codigoCarrera,
                    RAB.telefono,
                    RAB.audiencia,
                    RAB.fechaRegistro,
                    RAB.codigoEstado
                FROM
                    RegistroActividadesBienestar RAB
                WHERE
                    RAB.id=?
                    AND RAB.idActividadesBienestar=?
                    AND RAB.codigoEstado=100
                ';

        $variable[] = "$id";
        $variable[] = "$idActividadesBienestar";
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
//function ListarRegistroActividadesBienestar

    function InsertarRegistroActividadesBienestar($idActividadesBienestar,$nombre,$email,$codigoCarrera,$telefono,$audiencia,$codigoEstado) {
        $insertar = "INSERT INTO RegistroActividadesBienestar
            (idActividadesBienestar,
            nombre,
            email,
            codigoCarrera,
            telefono,
            audiencia,
            fechaRegistro,
            codigoEstado)
            VALUES
            (?,
            ?,
            ?,
            ?,
            ?,
            ?,
            NOW(),
            ?)
                ";
        $VariablesInsertar = array();
        $VariablesInsertar[] = "$idActividadesBienestar";
        $VariablesInsertar[] = "$nombre";
        $VariablesInsertar[] = "$email";
        $VariablesInsertar[] = "$codigoCarrera";
        $VariablesInsertar[] = "$telefono";
        $VariablesInsertar[] = "$audiencia";
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
    //function InsertarRegistroActividadesBienestar

    function ActualizarRegistroActividadesBienestar($nombre,$email,$codigoCarrera,$telefono,$audiencia,$codigoEstado,$id,$idActividadesBienestar) {
        $actualizar = "UPDATE RegistroActividadesBienestar SET
            nombre=?,
            email=?,
            codigoCarrera=?,
            telefono=?,
            audiencia=?,
            codigoEstado=?
            WHERE
            id=?
            AND idActividadesBienestar=?
                 ";
        $VariablesActualizar = array();
        $VariablesActualizar[] = "$nombre";
        $VariablesActualizar[] = "$email";
        $VariablesActualizar[] = "$codigoCarrera";
        $VariablesActualizar[] = "$telefono";
        $VariablesActualizar[] = "$audiencia";
        $VariablesActualizar[] = "$codigoEstado";
        $VariablesActualizar[] = "$id";
        $VariablesActualizar[] = "$idActividadesBienestar";

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
    //function ActualizarRegistroActividadesBienestar

   
}

//class
?>

