<?php
// Con esta clase se pretende manejar el proceso de auditorias en sala

// Como primera medida vamos a mirar genéricamente que se coloca en las tablas de auditoria

class auditoria
{
    var $usuario;
    var $idusuario;
    var $ip;
    var $observacion;

    function auditoria()
    {
        $this->usuario = $_SESSION['MM_Username'];
        $this->putIp();
        $this->putIdusuario();
        //echo $this->usuario;
    }

    function putIp()
    {
        if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else
        {
            if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"]))
            {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            else
            {
                if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"]))
                {
                    $ip = $_SERVER["REMOTE_HOST"];
                }
                else
                {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }
            }
        }
        $this->ip = $ip;
    }

    function putIdusuario()
    {
        global $db;

        $query_id = "select idusuario
        from usuario
        where usuario = '$this->usuario'";
        $id = $db->Execute($query_id);
        $totalRows_id = $id->RecordCount();
        $row_id = $id->FetchRow();

        $this->idusuario = $row_id['idusuario'];
    }
}

?>