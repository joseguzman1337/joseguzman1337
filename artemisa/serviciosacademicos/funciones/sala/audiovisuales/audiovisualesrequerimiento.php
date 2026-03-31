<?php
class audiovisualesrequerimiento
{
    // Variables
    var $idaudiovisualesrequerimiento;
    var $numerodocumento;
    var $descripcionaudiovisualesrequerimiento;
    var $fechainicialaudiovisualesrequerimiento;
    var $fechavencimientoaudiovisualesrequerimiento;
    var $fechaentregaaudiovisualesrequerimiento;
    var $codigoestadoaudiovisualesrequerimiento;

    // This is the constructor for this class
    // Initialize all your default iables here
    function audiovisualesrequerimiento($numerodocumento)
    {
        $this->setNumerodocumento($numerodocumento);
    }

    function cargarDatos($idaudiovisualesrequerimiento)
    {
        global $db;
        $query_requerimiento = "select a.idaudiovisualesrequerimiento, a.numerodocumento,
        a.descripcionaudiovisualesrequerimiento, a.fechainicialaudiovisualesrequerimiento, a.fechavencimientoaudiovisualesrequerimiento, a.fechaentregaaudiovisualesrequerimiento,
        a.codigoestadoaudiovisualesrequerimiento
        from audiovisualesrequerimiento a
        where a.numerodocumento = '$this->numerodocumento'
        and a.idaudiovisualesrequerimiento = '$idaudiovisualesrequerimiento'";
        $requerimiento = $db->Execute($query_requerimiento);
        $totalRows_requerimiento = $requerimiento->RecordCount();
        $row_requerimiento = $requerimiento->FetchRow();

        $this->setIdaudiovisualesrequerimiento($row_requerimiento['idaudiovisualesrequerimiento']);
        $this->setDescripcionaudiovisualesrequerimiento($row_requerimiento['descripcionaudiovisualesrequerimiento']);
        $this->setFechainicialaudiovisualesrequerimiento($row_requerimiento['fechainicialaudiovisualesrequerimiento']);
        $this->setFechavencimientoaudiovisualesrequerimiento($row_requerimiento['fechavencimientoaudiovisualesrequerimiento']);
        $this->setFechaentregaaudiovisualesrequerimiento($row_requerimiento['fechaentregaaudiovisualesrequerimiento']);
        $this->setCodigoestadoaudiovisualesrequerimiento($row_requerimiento['codigoestadoaudiovisualesrequerimiento']);
    }

    function insertar()
    {
        global $db;
        $query = "INSERT INTO audiovisualesrequerimiento(idaudiovisualesrequerimiento, numerodocumento,
        descripcionaudiovisualesrequerimiento, fechainicialaudiovisualesrequerimiento, fechavencimientoaudiovisualesrequerimiento, fechaentregaaudiovisualesrequerimiento,
        codigoestadoaudiovisualesrequerimiento)
        VALUES(0, '$this->numerodocumento','".$_REQUEST['descripcionaudiovisualesrequerimiento']."', now(), '".$_REQUEST['fechavencimientoaudiovisualesrequerimiento']."','','100')";
       //echo "$query_insestudiantedocumento <br>";
        $ins = $db->Execute($query);

    }

    function entregar()
    {
        global $db;
        //$db->debug = true;
        $query = "update audiovisualesrequerimiento
        set fechaentregaaudiovisualesrequerimiento = now(), codigoestadoaudiovisualesrequerimiento = 300
        where idaudiovisualesrequerimiento = $this->idaudiovisualesrequerimiento";
        //echo "$query_insestudiantedocumento <br>";
        $upd = $db->Execute($query);
    }

    /**
    * @return returns value of iable $idaudiovisualesrequerimiento
    * @desc getIdaudiovisualesrequerimiento : Getting value for iable $idaudiovisualesrequerimiento
    */
    function imprime()
    {
        return $this->idaudiovisualesrequerimiento;
    }

    /**
    * @return returns value of iable $idaudiovisualesrequerimiento
    * @desc getIdaudiovisualesrequerimiento : Getting value for iable $idaudiovisualesrequerimiento
    */
    function getIdaudiovisualesrequerimiento()
    {
        return $this->idaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $idaudiovisualesrequerimiento
    * @desc setIdaudiovisualesrequerimiento : Setting value for $idaudiovisualesrequerimiento
    */
    function setIdaudiovisualesrequerimiento($value)
    {
        $this->idaudiovisualesrequerimiento = $value;
    }

    /**
    * @return returns value of iable $numerodocumento
    * @desc getNumerodocumento : Getting value for iable $numerodocumento
    */
    function getNumerodocumento()
    {
        return $this->numerodocumento;
    }

    /**
    * @param param : value to be saved in iable $numerodocumento
    * @desc setNumerodocumento : Setting value for $numerodocumento
    */
    function setNumerodocumento($value)
    {
        $this->numerodocumento = $value;
    }

    /**
    * @return returns value of iable $descripcionaudiovisualesrequerimiento
    * @desc getDescripcionaudiovisualesrequerimiento : Getting value for iable $descripcionaudiovisualesrequerimiento
    */
    function getDescripcionaudiovisualesrequerimiento()
    {
            return $this->descripcionaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $descripcionaudiovisualesrequerimiento
    * @desc setDescripcionaudiovisualesrequerimiento : Setting value for $descripcionaudiovisualesrequerimiento
    */
    function setDescripcionaudiovisualesrequerimiento($value)
    {
            $this->descripcionaudiovisualesrequerimiento = $value;
    }

    /**
    * @return returns value of iable $fechainicialaudiovisualesrequerimiento
    * @desc getFechainicialaudiovisualesrequerimiento : Getting value for iable $fechainicialaudiovisualesrequerimiento
    */
    function getFechainicialaudiovisualesrequerimiento()
    {
            return $this->fechainicialaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $fechainicialaudiovisualesrequerimiento
    * @desc setFechainicialaudiovisualesrequerimiento : Setting value for $fechainicialaudiovisualesrequerimiento
    */
    function setFechainicialaudiovisualesrequerimiento($value)
    {
            $this->fechainicialaudiovisualesrequerimiento = $value;
    }

    /**
    * @return returns value of iable $fechavencimientoaudiovisualesrequerimiento
    * @desc getFechavencimientoaudiovisualesrequerimiento : Getting value for iable $fechavencimientoaudiovisualesrequerimiento
    */
    function getFechavencimientoaudiovisualesrequerimiento()
    {
            return $this->fechavencimientoaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $fechavencimientoaudiovisualesrequerimiento
    * @desc setFechavencimientoaudiovisualesrequerimiento : Setting value for $fechavencimientoaudiovisualesrequerimiento
    */
    function setFechavencimientoaudiovisualesrequerimiento($value)
    {
            $this->fechavencimientoaudiovisualesrequerimiento = $value;
    }

    /**
    * @return returns value of iable $fechaentregaaudiovisualesrequerimiento
    * @desc getFechaentregaaudiovisualesrequerimiento : Getting value for iable $fechaentregaaudiovisualesrequerimiento
    */
    function getFechaentregaaudiovisualesrequerimiento()
    {
            return $this->fechaentregaaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $fechaentregaaudiovisualesrequerimiento
    * @desc setFechaentregaaudiovisualesrequerimiento : Setting value for $fechaentregaaudiovisualesrequerimiento
    */
    function setFechaentregaaudiovisualesrequerimiento($value)
    {
            $this->fechaentregaaudiovisualesrequerimiento = $value;
    }

    /**
    * @return returns value of iable $codigoestadoaudiovisualesrequerimiento
    * @desc getCodigoestadoaudiovisualesrequerimiento : Getting value for iable $codigoestadoaudiovisualesrequerimiento
    */
    function getCodigoestadoaudiovisualesrequerimiento()
    {
            return $this->codigoestadoaudiovisualesrequerimiento;
    }

    /**
    * @param param : value to be saved in iable $codigoestadoaudiovisualesrequerimiento
    * @desc setCodigoestadoaudiovisualesrequerimiento : Setting value for $codigoestadoaudiovisualesrequerimiento
    */
    function setCodigoestadoaudiovisualesrequerimiento($value)
    {
            $this->codigoestadoaudiovisualesrequerimiento = $value;
    }
}

/**
* @return nada
* @desc imprimirAudiovisualesRequerimientos : Imprime los requerimientos que tiene un usuario
*/
function requerimientosAudiovisuales($numerodocumento, $tiporequerimiento='Activos')
{
    global $db;
    //$db->debug = true;
    switch($tiporequerimiento)
    {
        case 'Activos' :
            $query_requerimiento = "select a.idaudiovisualesrequerimiento, a.numerodocumento,
            a.descripcionaudiovisualesrequerimiento, a.fechainicialaudiovisualesrequerimiento, a.fechavencimientoaudiovisualesrequerimiento, a.fechaentregaaudiovisualesrequerimiento,
            a.codigoestadoaudiovisualesrequerimiento, e.nombreestadoaudiovisualesrequerimiento
            from audiovisualesrequerimiento a, estadoaudiovisualesrequerimiento e
            where a.numerodocumento = '$numerodocumento'
            and a.fechavencimientoaudiovisualesrequerimiento >= now()
            and a.codigoestadoaudiovisualesrequerimiento like '1%'
            and e.codigoestadoaudiovisualesrequerimiento = a.codigoestadoaudiovisualesrequerimiento
            order by a.fechainicialaudiovisualesrequerimiento desc";
            $requerimiento = $db->Execute($query_requerimiento);
            $totalRows_requerimiento = $requerimiento->RecordCount();
            //$row_requerimiento = $requerimiento->FetchRow();
            while($row_requerimiento = $requerimiento->FetchRow())
            {
                $datos[] = $row_requerimiento;
            }
        break;
        case 'Vencidos' :
            $query_requerimiento = "select a.idaudiovisualesrequerimiento, a.numerodocumento,
            a.descripcionaudiovisualesrequerimiento, a.fechainicialaudiovisualesrequerimiento, a.fechavencimientoaudiovisualesrequerimiento, a.fechaentregaaudiovisualesrequerimiento,
            a.codigoestadoaudiovisualesrequerimiento, e.nombreestadoaudiovisualesrequerimiento
            from audiovisualesrequerimiento a, estadoaudiovisualesrequerimiento e
            where a.numerodocumento = '$numerodocumento'
            and a.fechavencimientoaudiovisualesrequerimiento < now()
            and a.codigoestadoaudiovisualesrequerimiento like '1%'
            and e.codigoestadoaudiovisualesrequerimiento = a.codigoestadoaudiovisualesrequerimiento
            order by a.fechainicialaudiovisualesrequerimiento desc";
            $requerimiento = $db->Execute($query_requerimiento);
            $totalRows_requerimiento = $requerimiento->RecordCount();
            //$row_requerimiento = $requerimiento->FetchRow();
            while($row_requerimiento = $requerimiento->FetchRow())
            {
                $datos[] = $row_requerimiento;
            }
        break;
        case 'Entregados' :
            $query_requerimiento = "select a.idaudiovisualesrequerimiento, a.numerodocumento,
            a.descripcionaudiovisualesrequerimiento, a.fechainicialaudiovisualesrequerimiento, a.fechavencimientoaudiovisualesrequerimiento, a.fechaentregaaudiovisualesrequerimiento,
            a.codigoestadoaudiovisualesrequerimiento, e.nombreestadoaudiovisualesrequerimiento
            from audiovisualesrequerimiento a, estadoaudiovisualesrequerimiento e
            where a.numerodocumento = '$numerodocumento'
            and a.codigoestadoaudiovisualesrequerimiento like '3%'
            and e.codigoestadoaudiovisualesrequerimiento = a.codigoestadoaudiovisualesrequerimiento
            order by a.fechainicialaudiovisualesrequerimiento desc";
            $requerimiento = $db->Execute($query_requerimiento);
            $totalRows_requerimiento = $requerimiento->RecordCount();
            //$row_requerimiento = $requerimiento->FetchRow();
            while($row_requerimiento = $requerimiento->FetchRow())
            {
                $datos[] = $row_requerimiento;
            }
        break;

    }
    return $datos;
}

?>