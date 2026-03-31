<?php
class itemsiccarrera
{ 

        // Variables 
        var $iditemsiccarrera;
        var $iditemsic;
        var $codigocarrera;
        var $valoritemsiccarrera;
        var $codigoestadoitemsiccarrera;
        var $fechacreacionitemsiccarrera;
        var $fechamodificacionitemsiccarrera;
        var $fechahastaitemsiccarrera;
        var $codigoperiodoitemsic;
        var $codigoestado;


        /**
        * @return returns value of variable $iditemsiccarrera
        * @desc getIditemsiccarrera : Getting value for variable $iditemsiccarrera
        */
        function getIditemsiccarrera()
        {
                return $this->iditemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $iditemsiccarrera
        * @desc setIditemsiccarrera : Setting value for $iditemsiccarrera
        */
        function setIditemsiccarrera($value)
        {
                $this->iditemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $iditemsic
        * @desc getIditemsic : Getting value for variable $iditemsic
        */
        function getIditemsic()
        {
                return $this->iditemsic;
        }

        /**
        * @param param : value to be saved in variable $iditemsic
        * @desc setIditemsic : Setting value for $iditemsic
        */
        function setIditemsic($value)
        {
                $this->iditemsic = $value;
        }

        /**
        * @return returns value of variable $codigocarrera
        * @desc getCodigocarrera : Getting value for variable $codigocarrera
        */
        function getCodigocarrera()
        {
                return $this->codigocarrera;
        }

        /**
        * @param param : value to be saved in variable $codigocarrera
        * @desc setCodigocarrera : Setting value for $codigocarrera
        */
        function setCodigocarrera($value)
        {
                $this->codigocarrera = $value;
        }

        /**
        * @return returns value of variable $valoritemsiccarrera
        * @desc getValoritemsiccarrera : Getting value for variable $valoritemsiccarrera
        */
        function getValoritemsiccarrera()
        {
                return $this->valoritemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $valoritemsiccarrera
        * @desc setValoritemsiccarrera : Setting value for $valoritemsiccarrera
        */
        function setValoritemsiccarrera($value)
        {
                $this->valoritemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $codigoestadoitemsiccarrera
        * @desc getCodigoestadoitemsiccarrera : Getting value for variable $codigoestadoitemsiccarrera
        */
        function getCodigoestadoitemsiccarrera()
        {
                return $this->codigoestadoitemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $codigoestadoitemsiccarrera
        * @desc setCodigoestadoitemsiccarrera : Setting value for $codigoestadoitemsiccarrera
        */
        function setCodigoestadoitemsiccarrera($value)
        {
                $this->codigoestadoitemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $fechacreacionitemsiccarrera
        * @desc getFechacreacionitemsiccarrera : Getting value for variable $fechacreacionitemsiccarrera
        */
        function getFechacreacionitemsiccarrera()
        {
                return $this->fechacreacionitemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $fechacreacionitemsiccarrera
        * @desc setFechacreacionitemsiccarrera : Setting value for $fechacreacionitemsiccarrera
        */
        function setFechacreacionitemsiccarrera($value)
        {
                $this->fechacreacionitemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $fechamodificacionitemsiccarrera
        * @desc getFechamodificacionitemsiccarrera : Getting value for variable $fechamodificacionitemsiccarrera
        */
        function getFechamodificacionitemsiccarrera()
        {
                return $this->fechamodificacionitemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $fechamodificacionitemsiccarrera
        * @desc setFechamodificacionitemsiccarrera : Setting value for $fechamodificacionitemsiccarrera
        */
        function setFechamodificacionitemsiccarrera($value)
        {
                $this->fechamodificacionitemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $fechahastaitemsiccarrera
        * @desc getFechahastaitemsiccarrera : Getting value for variable $fechahastaitemsiccarrera
        */
        function getFechahastaitemsiccarrera()
        {
                return $this->fechahastaitemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $fechahastaitemsiccarrera
        * @desc setFechahastaitemsiccarrera : Setting value for $fechahastaitemsiccarrera
        */
        function setFechahastaitemsiccarrera($value)
        {
                $this->fechahastaitemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $codigoperiodoitemsic
        * @desc getCodigoperiodoitemsic : Getting value for variable $codigoperiodoitemsic
        */
        function getCodigoperiodoitemsic()
        {
                return $this->codigoperiodoitemsic;
        }

        /**
        * @param param : value to be saved in variable $codigoperiodoitemsic
        * @desc setCodigoperiodoitemsic : Setting value for $codigoperiodoitemsic
        */
        function setCodigoperiodoitemsic($value)
        {
                $this->codigoperiodoitemsic = $value;
        }

        /**
        * @return returns value of variable $codigoestado
        * @desc getCodigoestado : Getting value for variable $codigoestado
        */
        function getCodigoestado()
        {
                return $this->codigoestado;
        }

        /**
        * @param param : value to be saved in variable $codigoestado
        * @desc setCodigoestado : Setting value for $codigoestado
        */
        function setCodigoestado($value)
        {
                $this->codigoestado = $value;
        }

        // This is the constructor for this class
        // Initialize all your default variables here
        function itemsiccarrera($iditemsiccarrera)
        {
            global $db;
            $query = "SELECT iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoperiodoitemsic, codigoestado
            FROM itemsiccarrera
            WHERE iditemsiccarrera  = '$iditemsiccarrera'";
            $rta = $db->Execute($query);
            $totalRows_rta = $rta->RecordCount();
            if($totalRows_rta != 0)
            {
                $row = $rta->FetchRow();
                $this->iditemsiccarrera = $row['iditemsiccarrera'];
                $this->iditemsic = $row['iditemsic'];
                $this->codigocarrera = $row['codigocarrera'];
                $this->valoritemsiccarrera = $row['valoritemsiccarrera'];
                $this->codigoestadoitemsiccarrera = $row['codigoestadoitemsiccarrera'];
                $this->fechacreacionitemsiccarrera = $row['fechacreacionitemsiccarrera'];
                $this->fechamodificacionitemsiccarrera = $row['fechamodificacionitemsiccarrera'];
                $this->fechahastaitemsiccarrera = $row['fechahastaitemsiccarrera'];
                $this->codigoperiodoitemsic = $row['codigoperiodoitemsic'];
                $this->codigoestado = $row['codigoestado'];
            }
        }

        function existeItemsiccarrera()
        {
            if($this->iditemsiccarrera != "")
            {
                return true;
            }
            return false;
        }

        function insertarItemsiccarrera($valoritemsiccarrera, $codigoperiodoitemsic)
        {
            global $db, $codigocarrera;
            $retornar = false;
            //$valoritemsiccarrera = utf8_decode($_REQUEST['valoritemsiccarrera']);
            // Insertar el item
            $query_ins = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoperiodoitemsic, codigoestado)
            values (0, $this->iditemsic, '$codigocarrera', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', '$codigoperiodoitemsic', 100)";
            //echo "$query_hijos<br>";
            if(isset($_SESSION['sesion_carreraitemsic'])) {
                $query_ins = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoperiodoitemsic, codigoestado)
                values (0, $this->iditemsic, '".$_SESSION['sesion_carreraitemsic']."', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', '$codigoperiodoitemsic', 100)";
            }
            if($ins = $db->Execute($query_ins))
            {
                $this->iditemsiccarrera = $db->Insert_ID();
                $this->itemsiccarrera($this->iditemsiccarrera);
                $retornar = true;
            }
            else
            {
                $retornar = false;
            }
            return $retornar;
        }
}
?>