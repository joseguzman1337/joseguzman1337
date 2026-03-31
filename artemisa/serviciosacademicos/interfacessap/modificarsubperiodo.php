<?php
require_once('../Connections/sala2.php');

mysql_select_db($database_sala, $sala);
require_once('../funciones/funcionip.php');

require_once('../Connections/sap.php');
require_once('../funciones/zfica_sala_crea_aspirante.php');
require_once('../funciones/cambia_fecha_sap.php');
require_once('../funciones/zfica_crea_estudiante.php');
require_once('../funciones/clases/autenticacion/redirect.php');

$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna,
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
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
?>

<html>
<head>
<title>Modificación sub periodo ordenes de pago</title>
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
</head>
<body>
<h1>Mandante <?php echo $row_estadoconexionexterna['mandanteestadoconexionexterna']; ?></h1>
<div align="center" class="Estilo1">
<form name="f1" action="modificarsubperiodo.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo4" align="left">MODIFICAR SUBPERIODO DE LA ORDEN DE PAGO</p>
  <table width="500" border="1" bordercolor="#003333" align="left">
  <tr>
    <td width="275"><span class="Estilo8">
    Número de Orden : <input name='busqueda_numero' type='text'>
</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span class="Estilo3">
      <input name="buscar" type="submit" value="Ejecutar">
      &nbsp;</span></td>
  </tr>
</table>
<?php
if(isset($_GET['buscar']))
{
    if (isset($_GET['busqueda_numero']) and $_GET['busqueda_numero'] == "")
    {
        echo '<script language="javascript">alert("Debe digitar el Número de Orden"); history.go(-1);</script>';
        exit();
     }
    elseif (isset($_GET['busqueda_numero']) and $_GET['busqueda_numero'] <> "")
    {
        $numeroordenpago = $_GET['busqueda_numero'];
        $query_validaorden="SELECT distinct o.numeroordenpago, o.codigoperiodo, o.codigoestadoordenpago, e.codigocarrera
        FROM ordenpago o, estudiante e
        where o.numeroordenpago = '$numeroordenpago'
        and e.codigoestudiante = o.codigoestudiante";
        $validaorden=mysql_query($query_validaorden, $sala) or die(mysql_error());
        $row_validaorden=mysql_fetch_assoc($validaorden);
        //echo $query_validaorden;
        //exit();
        if (! $row_validaorden)
        {
            echo "<script language='javascript'>alert('Número de orden no existe en SALA'); window.location.href='modificarsubperiodo.php'</script>";
            exit();
        }
        //do
        {
            if(ereg("^1",$row_validaorden['codigoestadoordenpago']))
            {
                $numeroordenpago = $row_validaorden['numeroordenpago'];
                $codigoperiodo = $row_validaorden['codigoperiodo'];
                $query_subperiodo="select s.idsubperiodo
                from periodo p, carrera c, carreraperiodo cp, subperiodo s
                where c.codigocarrera = cp.codigocarrera
                and cp.codigoperiodo = p.codigoperiodo
                and c.codigocarrera = '".$row_validaorden['codigocarrera']."'
                and s.idcarreraperiodo = cp.idcarreraperiodo
                and '".date("Y-m-d")."' between s.fechainiciofinancierosubperiodo and s.fechafinalfinancierosubperiodo";
                $subperiodo=mysql_query($query_subperiodo, $sala) or die("$query_subperiodo");
                $row_subperiodo=mysql_fetch_assoc($subperiodo);
                if(!$row_subperiodo)
                {
                    echo $query_subperiodo;
                    ?>
                            <script language='javascript'>
                            alert("ERROR: No existe un subperido activo para la fecha actual, debe crear el subperiodo por la opción Periodos y Subperiodos");
                            //window.location.href='modificarsubperiodo.php';
                    </script>
                   <?php
                    exit();
                }
                else
                {
                    //echo $row_subperiodo['idsubperiodo']."DOS";
                    // Modificar subperiodo en la orden
                    $upd_orden="update ordenpago
                    set idsubperiododestino = '".$row_subperiodo['idsubperiodo']."'
                    where numeroordenpago = '$numeroordenpago'";
                    $rta_orden=mysql_query($upd_orden, $sala) or die("$upd_orden");

                    // Cada vez que se modifique una orden de pago guardar en logordenpago si existe sesión de usuario
                    if(isset($_SESSION['MM_Username']))
                    {
                        $query_id = "select idusuario
                        from usuario
                        where usuario = '".$_SESSION['MM_Username']."'";
                        $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>".mysql_error());
                        $row_id = mysql_fetch_assoc($id);

                        $idusuario = $row_id['idusuario'];

                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                        VALUES(0, now(), '".$row_subperiodo['idsubperiodo']." -- MODIFICACION SUBPERIODO', '$numeroordenpago', '$idusuario', '".tomarip()."')";
                        //echo "<br>uno".$query_inslogordenpago;
                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>".mysql_error());
                    }
                    else
                    {
                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                        VALUES(0, now(), '".$row_subperiodo['idsubperiodo']." -- MODIFICACION SUBPERIODO', '$numeroordenpago', '2', '".tomarip()."')";
                        //echo "<br>uno".$query_inslogordenpago;
                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>".mysql_error());
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
            }
            elseif(ereg("^4",$row_validaorden['codigoestadoordenpago']))
            {
?>
<script language='javascript'>
    alert('ADVERTENCIA: Esta orden está paga, por lo tanto no se llevo a cabo ninguna operación');
    window.location.href='modificarsubperiodo.php';
</script>
<?php
            }
            elseif(ereg("^2",$row_validaorden['codigoestadoordenpago']))
            {
?>
<script language='javascript'>
    alert('ADVERTENCIA: Esta orden está anulada, por lo tanto no se permite realizar ninguna operación');
    window.location.href='modificarsubperiodo.php';
</script>
<?php
            }
        }
        //while($row_validaorden=mysql_fetch_assoc($validaorden));
        if ($subirorden == "0")
        {
            echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='modificarsubperiodo.php'</script>";
        }
        else
        {
            echo "<script language='javascript'>alert('Operación Exitosa'); window.location.href='modificarsubperiodo.php'</script>";
        }
    }
}
?>
</form>
</div>
</body>
</html>

