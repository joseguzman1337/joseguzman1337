<?php
function obtener_prematriculados($codigocarrera, $codigosituacion, $fecha, $codigoperiodo=20081)
{
    global $db;
    $query = "select c.nombrecarrera, if(s.nombresituacioncarreraestudiante is null,
    (select nombresituacioncarreraestudiante from situacioncarreraestudiante 
    where codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante),s.nombresituacioncarreraestudiante
    ) as situacion, count(*) as total
    from carrera c, estudiantegeneral eg, estudiante e
    left join historicosituacionestudiante h 
    on h.codigoestudiante = e.codigoestudiante 
    and '$fecha' between h.fechainiciohistoricosituacionestudiante and h.fechafinalhistoricosituacionestudiante
    left join situacioncarreraestudiante s 
    on s.codigosituacioncarreraestudiante = h.codigosituacioncarreraestudiante
    inner join ordenpago o 
    on o.codigoestudiante = e.codigoestudiante 
    and o.codigoperiodo = '$codigoperiodo'
    and ('$fecha' < o.fechapagosapordenpago or o.fechapagosapordenpago = '0000-00-00')
    and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
    and o.numeroordenpago in (
    select do.numeroordenpago
    from detalleordenpago do
    where do.numeroordenpago = o.numeroordenpago
    and do.codigoconcepto = '151'
    )
    where e.idestudiantegeneral = eg.idestudiantegeneral
    and c.codigomodalidadacademica like '2%'
    and c.codigocarrera = e.codigocarrera
    and c.codigocarrera = '$codigocarrera'
    and e.codigosituacioncarreraestudiante = '$codigosituacion'
    group by c.nombrecarrera, situacion
    order by c.nombrecarrera, s.nombresituacioncarreraestudiante";
    $rta = $db->Execute($query);
    $totalRows_rta = $rta->RecordCount();
    $row_rta = $rta->FetchRow();
    return $row_rta['total'];    
}

function obtener_noprematriculados($codigocarrera, $codigosituacion, $fecha, $codigoperiodo=20081, $codigoperiodoini=20072)
{
    global $db;
    $query = "select c.nombrecarrera, if(s.nombresituacioncarreraestudiante is null,
    (select nombresituacioncarreraestudiante from situacioncarreraestudiante 
    where codigosituacioncarreraestudiante = et.codigosituacioncarreraestudiante),s.nombresituacioncarreraestudiante
    ) as situacion, count(*) as total
    from carrera c, estudiantegeneral eg, ordenpago o, detalleordenpago do, estudiante et
    left join historicosituacionestudiante h 
    on h.codigoestudiante = et.codigoestudiante 
    and '$fecha' between h.fechainiciohistoricosituacionestudiante and h.fechafinalhistoricosituacionestudiante
    left join situacioncarreraestudiante s 
    on s.codigosituacioncarreraestudiante = h.codigosituacioncarreraestudiante
    where et.idestudiantegeneral = eg.idestudiantegeneral
    and o.codigoestudiante = et.codigoestudiante
    and o.codigoestadoordenpago like '4%'
    and do.codigoconcepto = '151'
    and o.numeroordenpago = do.numeroordenpago
    and o.codigoperiodo = '$codigoperiodoini'
    and et.codigocarrera = c.codigocarrera
    and et.codigoestudiante 
    not in
    (
        select e.codigoestudiante
        from estudiantegeneral eg, estudiante e
        inner join ordenpago o 
        on o.codigoestudiante = e.codigoestudiante 
        and o.codigoperiodo = '$codigoperiodo'
        and ('$fecha' > o.fechapagosapordenpago or o.fechapagosapordenpago = '0000-00-00')
        and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
        and o.numeroordenpago in (
            select do.numeroordenpago
            from detalleordenpago do
            where do.numeroordenpago = o.numeroordenpago
            and do.codigoconcepto = '151'
        )
        where e.idestudiantegeneral = eg.idestudiantegeneral
        and e.codigoestudiante = et.codigoestudiante
    )
    and c.codigomodalidadacademica like '2%'
    and et.codigocarrera = '$codigocarrera'
    and et.codigosituacioncarreraestudiante = '$codigosituacion'
    group by c.nombrecarrera, situacion
    order by c.nombrecarrera, s.nombresituacioncarreraestudiante";
    $rta = $db->Execute($query);
    $totalRows_rta = $rta->RecordCount();
    $row_rta = $rta->FetchRow();
    return $row_rta['total'];    
}

class CDesercion
{ 
        // Variables 
        var $codigocarrera ;
        var $Asituacion;
        var $fecha;

		/**
        * @return put return description here..
        * @param param :  $codigocarrera es le codigo de la carrera y $situacion un arreglo con las situaciones
        * @desc  :  put function description here ... 
        */
        function CDesercion($codigocarrera, $situacion, $fecha)
        {
            $this->codigocarrera = $codigocarrera;
            foreach($situacion as $key => $value) :
                $this->Asituacion[$value]['prematriculados'] = 0;
                $this->Asituacion[$value]['noprematriculados'] = 0;
            endforeach;
            $this->fecha = $fecha;
        }
        
        /**
        * @return returns value of variable $codigocarrera
        * @desc getCodigocarrera  : Getting value for variable $codigocarrera
        */
        function getCodigocarrera ()
        {
                return $this->codigocarrera ;
        }

        /**
        * @param param : value to be saved in variable $codigocarrera
        * @desc setCodigocarrera  : Setting value for $codigocarrera
        */
        function setCodigocarrera ($value)
        {
                $this->codigocarrera  = $value;
        }

        /**
        * @return returns value of variable $Asituacion
        * @desc getAsituacion : Getting value for variable $Asituacion
        */
        function getAsituacion()
        {
                return $this->Asituacion;
        }

        /**
        * @param param : value to be saved in variable $Asituacion
        * @desc setAsituacion : Setting value for $Asituacion
        */
        function setAsituacion($value)
        {
                $this->Asituacion = $value;
        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setCodigocarrera ("");
                $this->setAsituacion("");
        }
        
		/**
        * @return put return description here..
        * @param param :  No recibe nada
        * @desc  :  Carga los datos de estudiantes prematriculados y no prematriculados por situacion 
        */
        function cargarDesercion()
        {
            
        }

} 
?>