<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

class functionsPaymentsMessage
{
    private $db;
    private $valuesData;
    private $errosValidations = array();

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     * listado general de mensajes
     */
    public function listMessagePercentaje()
    {
        $query = "
       select
       OPM.codigoOrdenPagoMensaje,
       OPM.mensaje,
       c.nombrecarrera,
       eOPM.estado,
       OPM.usuarioCreacion,
       u.usuario as 'usuCrea',
       OPM.fechaCreacion,
       OPM.usuarioModificacion,
       u2.usuario as 'usuMod',
       OPM.fechaModificacion
from ordenPagoMensajes OPM
inner join estadoOrdenPagoMensaje eOPM on OPM.codigoEstadoOrdenPagoMensaje = eOPM.codigoEstadoOrdenPagoMensajes
inner join carrera c on OPM.codigocarrera = c.codigocarrera
inner join usuario u on OPM.usuarioCreacion = u.idusuario
left join usuario u2 on OPM.usuarioModificacion = u2.idusuario
        ";

        $response = $this->db->GetAll($query);
        return $response;
    }

    /**
     * @param $modalidty
     * listar modalidalidades
     */
    public function listModalities()
    {
        $query = "
        select * from modalidadacademica
where codigomodalidadacademica in
      (
            200,
            300,
            400,
            600,
            800,
            810
      )
      ";
        $response = $this->db->GetAll($query);
        return $response;

    }

    /**
     * @param $modality
     * @return string
     * listar carrera por modalidad
     */
    public function listCareersByModalityOptions($modality)
    {
        $query = "select codigocarrera, nombrecarrera
from carrera
where codigomodalidadacademica = ".$modality."
  and codigocarrera not in (
    select distinct c.codigocarrera
    from ordenPagoMensajes OPM
             inner join carrera c on OPM.codigocarrera = c.codigocarrera
)
and codigocarrera not in (1,2)
and codigocarrera not in (select codigocarrera from carrera where nombrecarrera = 'HISTORICO')";
        $response = $this->db->GetAll($query);
         $select = "";

         foreach($response as $carrera)
         {
             $select .= "<option value='".$carrera['codigocarrera']."'>".$carrera['nombrecarrera']."</option>";
         }

        return $select;
    }

    /**
     * @param $modality
     * @return string
     * listar carrera por modalidad
     */
    public function listCareersById($carrera)
    {
        $query = "select codigocarrera, nombrecarrera
from carrera
where codigocarrera = ".$carrera."
and codigocarrera not in (1,2)";
        $response = $this->db->GetAll($query);
        $select = "";

        foreach($response as $carrera)
        {
            $select .= "<option value='".$carrera['codigocarrera']."' selected>".$carrera['nombrecarrera']."</option>";
        }

        return $select;
    }
    
    /**
     * @param $id
     * @return mixed
     * listar datos de mensaje por Id
     */
    public function listMessagePercentajeById($id)
    {
        $query = "
            select * from ordenPagoMensajes where codigoOrdenPagoMensaje = ".$id." 
        ";

        $responnse = $this->db->GetRow($query);

        return $responnse;
    }

    /**
     * @param array $values
     *
     * validacion de campos
     */
    public function validationsFields(array $values)
    {
        if(isset($values['mensaje']))
        {
            $this->valuesData['mensaje'] = $values['mensaje'];
        }
        else
            {
                $this->valuesData['mensaje'] = '';
                $this->errosValidations['mensaje'] = "Este campo es obligatorio";
            }

        if(isset($values['codigocarrera']))
        {
            $this->valuesData['codigocarrera'] = $values['codigocarrera'];
        }
        else
        {
            $this->valuesData['codigocarrera'] = '';
            $this->errosValidations['codigocarrera'] = "Este campo es obligatorio";
        }
        if(isset($values['estado']))
        {
            $this->valuesData['estado'] = $values['estado'];
        }
        else
        {
            $this->valuesData['estado'] = 100;
            $this->errosValidations['estado'] = "Este campo es obligatorio";
        }


    }

    /**
     * @param $request
     * @return bool
     * crear mensaje
     */
    public function createMessageOrderPayment($request)
    {
        $this->validationsFields($request);
        $actualDate = date('Y-m-d');
        $query = "
            insert into ordenPagoMensajes(mensaje,
                              codigocarrera,
                              codigoEstadoOrdenPagoMensaje,
                              usuarioCreacion, 
                              fechaCreacion
                              )
values (
        '".$this->valuesData['mensaje']."',
        ".$this->valuesData['codigocarrera'].",
        ".$this->valuesData['estado'].",
        ".$_SESSION['idusuario'].",
        '".$actualDate."'
       )";

        $result = $this->db->Execute($query);

        if(!$result)
        {
            return false;
        }
        return true;
    }


    /**
     * @param $request
     * @return bool
     * crear mensaje
     */
    public function editMessageOrderPayment($request)
    {
        $this->validationsFields($request);
        $actualDate = date('Y-m-d');
        $query = "
UPDATE ordenPagoMensajes t SET t.mensaje = '".$this->valuesData['mensaje']."',
                               t.codigocarrera = ".$this->valuesData['codigocarrera'].",
t.codigoEstadoOrdenPagoMensaje = ".$this->valuesData['estado'].",
t.usuarioModificacion= ".$_SESSION['idusuario'].",
t.fechaModificacion = '".$actualDate."'
WHERE t.codigoOrdenPagoMensaje = ".$request['codigo']."
        ";

        $result = $this->db->Execute($query);

        if(!$result)
        {
            return false;
        }
        return true;
    }

    /**
     * @param $codigocarrera
     * @return mixed
     * obtener modalidad por carrera
     */
    public function getModalityByCarreer($codigocarrera)
    {
        $query = "select codigomodalidadacademica from carrera where codigocarrera = $codigocarrera;";
        $response = $this->db->GetRow($query);

        return $response;
    }

}