<?php
 
class ActividadesBienestar {

    var $db;
    var $usuario;    

    function __construct($db, $usuario) {
        $this->db = $db;
        $this->usuario = $usuario;
    }
//__construct

    function ListarActividadesBienestar() {
        $SQL = 'SELECT
                    AB.id,
                    AB.nombre,
                    AB.descripcion,
                    AB.fechaLimite,
                    AB.cupo,
                    AB.codigoEstado,
                    AB.emailResponsable,
                    AB.horaFin,
                    AB.imagen,
                    AB.url
                FROM
                    ActividadesBienestar AB
                WHERE
                    AB.codigoEstado=100
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
    
    function TraigaActividadesBienestar($id) {
        $SQL = 'SELECT
                    AB.nombre,
                    AB.descripcion,
                    AB.fechaLimite,
                    AB.cupo,
                    AB.codigoEstado,
                    AB.emailResponsable,
                    AB.horaFin,
                    AB.imagen,
                    AB.url
                FROM
                    ActividadesBienestar AB
                WHERE
                     AB.id=?
                    AND AB.codigoEstado=100
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

    function InsertarActividadesBienestar($nombre,$descripción,$fechaLimite,$cupo,$usuario,$codigoEstado) {
        $insertar = "INSERT INTO ActividadesBienestar
            (nombre,
            descripción,
            fechaLimite,
            cupo,
            usuarioCreacion,
            fechaCreacion,
            codigoEstado)
            VALUES
            (?,
            ?,
            ?,
            ?,
            ?,
            NOW(),
            ?)
                ";
        $VariablesInsertar = array();
        $VariablesInsertar[] = "$nombre";
        $VariablesInsertar[] = "$descripcion";
        $VariablesInsertar[] = "$fechaLimite";
        $VariablesInsertar[] = "$cupo";
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

    function ActualizarActividadesBienestar($nombre,$descripción,$fechaLimite,$cupo,$usuario,$codigoEstado,$id) {
        $actualizar = "UPDATE ActividadesBienestar SET
            nombre=?,
            descripción=?,
            fechaLimite=?,
            cupo=?,
            usuarioModificacion=?,
            fechaModificacion=now(),
            codigoEstado=?
            WHERE
            id=?
                 ";
        $VariablesActualizar = array();
        $VariablesActualizar[] = "$nombre";
        $VariablesActualizar[] = "$descripción";
        $VariablesActualizar[] = "$fechaLimite";
        $VariablesActualizar[] = "$cupo";
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

