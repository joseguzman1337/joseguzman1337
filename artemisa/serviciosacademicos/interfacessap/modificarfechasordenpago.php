<?php
require_once('../Connections/sala2.php');

mysql_select_db($database_sala, $sala);
require_once('../funciones/funcionip.php');
require_once('../Connections/sap.php');
require_once('../funciones/zfica_sala_crea_aspirante.php');
require_once('../funciones/cambia_fecha_sap.php');
require_once('../funciones/zfica_crea_estudiante.php');
require_once('../funciones/clases/autenticacion/redirect.php');

$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);

if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
    $login = array (                              // Set login data to R/3
    "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],              // application server host name
    "SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
    "CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
    "USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
    "PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],          // password
    "CODEPAGE"=>"1100");                                                            // codepage

    $rfc = saprfc_open($login);
    if(!$rfc)
    {
        // We have failed to connect to the SAP server
        //echo "<br><br>Failed to connect to the SAP server".saprfc_error();
        //exit(1);
    }
}

//echo $row_estadoconexionexterna['mandanteestadoconexionexterna'];


$query_periodo = "SELECT * FROM periodo
WHERE codigoestadoperiodo = '1'";
//echo $query_data,"<br>";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$periodo = $row_periodo['codigoperiodo'];
//echo $periodo;
if(isset($_REQUEST['Aceptar']))
{
    //print_r($_REQUEST);
    // Desde aca se modifican las fechas de la orden y se alamcena en un log el cambio hecho
    $numeroordenpago = $_REQUEST['busqueda_numero'];
    $haymodificacion = false;
    for($i = 1; $i <= $_REQUEST['contador']; $i++)
    {
        if($_REQUEST['fechaordenpagoini'.$i] != $_REQUEST['fecha'.$i])
        {
            // Debe modificar la fecha de la orden y guardar en log
            $query_fechaordenpago = "UPDATE fechaordenpago
            set fechaordenpago = '".$_REQUEST['fecha'.$i]."'
            where numeroordenpago = '".$_REQUEST['busqueda_numero']."'
            and fechaordenpago = '".$_REQUEST['fechaordenpagoini'.$i]."'
            and porcentajefechaordenpago = '".$_REQUEST['porcentajefechaordenpago'.$i]."'
            and valorfechaordenpago = '".$_REQUEST['valorfechaordenpago'.$i]."'";
            // echo $query_ordenpago;
            $rta_fechaordenpago = mysql_db_query($database_sala,$query_fechaordenpago) or die("$query_fechaordenpago<br>".mysql_error());
            $haymodificacion = true;

            // Insertar en el log
            if(isset($_SESSION['MM_Username']))
            {
                $query_id = "select idusuario
                from usuario
                where usuario = '".$_SESSION['MM_Username']."'";
                $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>".mysql_error());
                $row_id = mysql_fetch_assoc($id);
                $idusuario = $row_id['idusuario'];

                $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                VALUES(0, now(), '".$_REQUEST['busqueda_observacion']." -- MODIFICACION FECHA DE ORDEN MANUAL -- FECHA INICIAL:".$_REQUEST['fechaordenpagoini'.$i]." FECHA NUEVA:".$_REQUEST['fecha'.$i]." -- PORCENTAJE ".$_REQUEST['porcentajefechaordenpago'.$i]."', '$numeroordenpago', '$idusuario', '".tomarip()."')";
                //echo "<br>uno".$query_inslogordenpago;
                $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>".mysql_error());
            }
            else
            {
                $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                VALUES(0, now(), '".$_REQUEST['busqueda_observacion']." -- MODIFICACION FECHA DE ORDEN MANUAL -- FECHA INICIAL:".$_REQUEST['fechaordenpagoini'.$i]." FECHA NUEVA:".$_REQUEST['fecha'.$i]." -- PORCENTAJE ".$_REQUEST['porcentajefechaordenpago'.$i]."', '$numeroordenpago', '2', '".tomarip()."')";
                //echo "<br>uno".$query_inslogordenpago;
                $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>".mysql_error());
            }
        }
    }
    if($haymodificacion)
    {
        $query_concepto="SELECT distinct numeroordenpago
        FROM detalleordenpago d,concepto c
        where (cuentaoperacionprincipal = 152 or cuentaoperacionprincipal = 153)
        and d.codigoconcepto = c.codigoconcepto
        and numeroordenpago = '$numeroordenpago'";
        $concepto=mysql_query($query_concepto, $sala) or die("$query_concepto");
        $row_concepto=mysql_fetch_assoc($concepto);
        //echo $query_concepto;

        if ($row_concepto <> "")
        {
            $subirorden = genera_prodiverso($rfc,$sala,$numeroordenpago,$idgrupo = 1);
            echo $subirorden;
        }
        else
        {
            $subirorden = crea_estudiante($rfc,$sala,$numeroordenpago,$idgrupo);
            echo $subirorden ;
        }
        if ($subirorden == "0")
        {
            echo "<script language='javascript'>alert('Operación Exitosa, las fechas se modificaron satisfactoriamente'); window.location.href='modificarfechasordenpago.php'</script>";
        }
        else
        {
            echo "<script language='javascript'>alert('Operación Exitosa, las fechas se modificaron satisfactoriamente'); window.location.href='modificarfechasordenpago.php'</script>";
        }
    }
    else
    {
        echo "<script language='javascript'>
            alert('Las fechas de esta orden no fueron modificadas, por favor verifique');
        </script>";
    }
?>
<?php
}
?>

<html>
<head>
<title>Modificación de fechas en una orden de pago</title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {font-size: xx-small}
.Estilo4 {
    font-size: 14px;
    font-weight: bold;
}
.Estilo6 {font-size: 12px}
.Estilo8 {font-size: 12px; font-weight: bold; }
-->
</style>
<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>

<script language="javascript">
function validar(formulario)
{
    var contador;
    contador = document.getElementById("contador").value;
    fechas = new Array();
    //alert(contador);
    for(i = 1; i <= contador; i++)
    {
        fechas[i] = document.getElementById("fecha" + i).value.replace("-","");
        fechas[i] = parseInt(fechas[i].replace("-",""));
    }

    for(i = 1; i <= contador; i++)
    {
        for(j = i; j <= contador; j++)
        {
            if(i != j)
            {
                //alert("Fechas: " + fechas[i] + " y " + fechas[j]);
                if(fechas[i] >= fechas[j])
                {
                    alert("Las fechas: " + fechas[i] + " y " + fechas[j] + " tienen cruce, por favor verifique");
                    return false;
                }
            }
        }
    }
    return true;
}
</script>

</head>
<body>
<h1>Mandante <?php echo $row_estadoconexionexterna['mandanteestadoconexionexterna']; ?></h1>
<div align="center" class="Estilo1">
  <p class="Estilo4" align="left">MODIFICAR FECHAS EN ORDEN DE PAGO</p>
<?php
if(!isset($_REQUEST['buscar']))
{
?>
<form name="f1" action="" method="get">
  <table width="500" border="1" bordercolor="#003333" align="left">
  <tr>
    <td width="275"><span class="Estilo8">
    Número de Orden : <input name='busqueda_numero' type='text'>
</span></td>
    <td width="275"><span class="Estilo8">
    Observacion : <input name='busqueda_observacion' type='text'>
</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span class="Estilo3">
      <input name="buscar" type="submit" value="Ejecutar">
      &nbsp;</span></td>
  </tr>
</table>
</form>
<?php
}
?>
<?php
if(isset($_REQUEST['buscar']))
{
    if (isset($_REQUEST['busqueda_numero']) and $_REQUEST['busqueda_numero'] == "")
    {
        echo '<script language="javascript">alert("Debe digitar el Número de Orden"); history.go(-1);</script>';
     }
    elseif (isset($_REQUEST['busqueda_numero']) and $_REQUEST['busqueda_numero'] <> "")
    {
        if($_REQUEST['busqueda_observacion'] != '')
        {
?>
<form name="f2" method="POST" onsubmit="return validar(this)">
<input type="hidden" name="busqueda_observacion" value="<?php echo $_REQUEST['busqueda_observacion']; ?>">
<input type="hidden" name="buscar" value="<?php echo $_REQUEST['buscar']; ?>">
<input type="hidden" name="busqueda_numero" value="<?php echo $_REQUEST['busqueda_numero']; ?>">
<table width="500" border="1" bordercolor="#003333" align="left">
<tr><td colspan="2"><strong>Número de orden de pago</strong></td><td><strong><?php echo $_REQUEST['busqueda_numero']; ?></strong></td></tr>
<tr><TD colspan="3">&nbsp;</TD></tr>
<tr>
    <td><strong>Fecha Orden Pago</strong></td>
    <td><strong>Porcentaje Fecha Orden Pago</strong></td>
    <td><strong>Valor Fecha Orden Pago</strong></td></tr>
<?php
            $numeroordenpago = $_GET['busqueda_numero'];
            $query_validaorden="SELECT distinct o.numeroordenpago, o.codigoperiodo, o.codigoestadoordenpago, e.codigocarrera, fo.fechaordenpago, fo.valorfechaordenpago, fo.porcentajefechaordenpago
            FROM ordenpago o, estudiante e, fechaordenpago fo
            where o.numeroordenpago = '$numeroordenpago'
            and e.codigoestudiante = o.codigoestudiante
            and fo.numeroordenpago = o.numeroordenpago";
            $validaorden=mysql_query($query_validaorden, $sala) or die(mysql_error());
            $cuentafechas = 0;
            while($row_validaorden=mysql_fetch_assoc($validaorden))
            {
                if(ereg("^1",$row_validaorden['codigoestadoordenpago']))
                {
                    $cuentafechas++;
?>
    <input type="hidden" name="fechaordenpagoini<?php echo $cuentafechas; ?>" value="<?php echo $row_validaorden['fechaordenpago']; ?>">
    <input type="hidden" name="valorfechaordenpago<?php echo $cuentafechas; ?>" value="<?php echo $row_validaorden['valorfechaordenpago']; ?>">
    <input type="hidden" name="porcentajefechaordenpago<?php echo $cuentafechas; ?>" value="<?php echo $row_validaorden['porcentajefechaordenpago']; ?>">

    <tr>
        <td><input type="text" id="fecha<?php echo $cuentafechas; ?>" name="fecha<?php echo $cuentafechas; ?>" size="8" maxlength="10" readonly="true" value="<?php echo $row_validaorden['fechaordenpago']; ?>"></td>
        <td><?php echo $row_validaorden['porcentajefechaordenpago']; ?></td>
        <td><?php echo $row_validaorden['valorfechaordenpago']; ?></td>
    </tr>
<script type="text/javascript">
    Calendar.setup(
    {
        inputField : "fecha<?php echo $cuentafechas; ?>", // ID of the input field
        ifFormat : "%Y-%m-%d", // the date format
        text : "fecha<?php echo $cuentafechas; ?>" // ID of the button
    });
</script>
<?php
                }
                elseif(ereg("^2",$row_validaorden['codigoestadoordenpago']))
                {
?>
<script language="JavaScript">
    alert("ADVERTENCIA: La orden está inactiva, no se permite el cambio de fechas");
    window.location.href='modificarfechasordenpago.php';
</script>
<?php
                    exit();
                }
                elseif(ereg("^4",$row_validaorden['codigoestadoordenpago']))
                {
?>
<script language="JavaScript">
    alert("ADVERTENCIA: La orden está paga, no se permite el cambio de fechas");
    window.location.href='modificarfechasordenpago.php';
</script>
<?php
                    exit();
                }
            }
?>
            <input type="hidden" name="contador" id="contador" value="<?php echo $cuentafechas; ?>">
<?php

            // echo $query_validaorden;
            //exit();
/*            if(isset($_SESSION['MM_Username']))
                    {
                        $query_id = "select idusuario
                        from usuario
                        where usuario = '".$_SESSION['MM_Username']."'";
                        $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>".mysql_error());
                        $row_id = mysql_fetch_assoc($id);

                        $idusuario = $row_id['idusuario'];

                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                        VALUES(0, now(), '".$_REQUEST['busqueda_onservacion']." -- ACTIVADA MANUALMENTE', '$numeroordenpago', '$idusuario', '".tomarip()."')";
                        //echo "<br>uno".$query_inslogordenpago;
                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>".mysql_error());
                    }
                    else
                    {
                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                        VALUES(0, now(), '".$_REQUEST['busqueda_onservacion']." -- ACTIVADA MANUALMENTE', '$numeroordenpago', '2', '".tomarip()."')";
                        //echo "<br>uno".$query_inslogordenpago;
                        $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>".mysql_error());
                    }

                    $query_concepto="SELECT distinct numeroordenpago
                    FROM detalleordenpago d,concepto c
                    where (cuentaoperacionprincipal = 152 or cuentaoperacionprincipal = 153)
                    and d.codigoconcepto = c.codigoconcepto
                    and numeroordenpago in($numeroordenpago)";
                    $concepto=mysql_query($query_concepto, $sala) or die("$query_concepto");
                    $row_concepto=mysql_fetch_assoc($concepto);
                    //echo $query_concepto;

                    if ($row_concepto <> "")
                    {
                        $subirorden = genera_prodiverso($rfc,$sala,$numeroordenpago,$idgrupo = 1);
                        echo $subirorden;
                    }
                    else
                    {
                        $subirorden = crea_estudiante($rfc,$sala,$numeroordenpago,$idgrupo);
                        echo $subirorden ;
                    }
                }
                elseif(ereg("^4",$row_validaorden['codigoestadoordenpago']))
                {
    ?>
    <script language='javascript'>
        alert('ADVERTENCIA: Esta orden ya estaba paga, por lo tanto no se llevo a cabo ninguna operación');
        window.location.href='activarorden.php';
    </script>
    <?php
                }
                elseif(ereg("^1",$row_validaorden['codigoestadoordenpago']))
                {
    ?>
    <script language='javascript'>
        alert('ADVERTENCIA: Esta orden ya se encontraba activa');
        window.location.href='activarorden.php';
    </script>
    <?php
                }
            }
            //while($row_validaorden=mysql_fetch_assoc($validaorden));
            if ($subirorden == "0")
            {
                echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='activarorden.php'</script>";
            }
            else
            {
                echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='activarorden.php'</script>";
            }*/
?>
<tr><TD colspan="3">&nbsp;</TD></tr>
<tr><TD colspan="3"><input type="submit" name="Aceptar" value="Aceptar">&nbsp;</TD></tr>
</table>
</form>
<?php
        }
        else
        {
            echo '<script language="javascript">alert("ADVERTENCIA: Debe digitar una observación para que la orden se pueda modificar"); </script>';
        }
    }
}
?>
</form>
</div>
</body>
</html>

