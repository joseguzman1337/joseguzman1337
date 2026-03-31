<?php
require('../Connections/sala2.php');
require_once('../funciones/clases/autenticacion/redirect.php');
mysql_select_db($database_sala, $sala);
/* echo $_GET['CREA'],"crea<br>";
echo $_GET['aufnr'],"orden<br>";
echo $_GET['GARANTIA'],"garantia<br>"; */
//$_GET['aufnr'] = $_GET['parametro'];
//  http://172.16.7.109/calidad/desarrollo/serviciosacademicos/interfacessap/zfica_plan_pago.php?aufnr=$1  //Este pedazo de codigo se coloca en sala2
$query_estadoconexionexterna = "select codigoestadoconexionexterna, nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
from estadoconexionexterna
where codigoestado like '1%'";
//echo $query_estadoconexionexterna;
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
//echo $_GET['aufnr'],"orden<br>";
$host     = $row_estadoconexionexterna['hostestadoconexionexterna'];
$sistema  = $row_estadoconexionexterna['numerosistemaestadoconexionexterna'];
$mandante = $row_estadoconexionexterna['mandanteestadoconexionexterna'];
$usuario  = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
$clave    = $row_estadoconexionexterna['passwordestadoconexionexterna'];

$login = array (                       // Set login data to R/3
            "ASHOST"  =>"$host",           // application server host name
            "SYSNR"   =>"$sistema",        // system number
            "CLIENT"  =>"$mandante",       // client
            "USER"    =>"$usuario",        // user
            "PASSWD"  =>"$clave",          // Clave
            "CODEPAGE"=>"1100");           // codepage
$rfc = saprfc_open($login);
?>
<html>
<head>
<title>Plan de Pagos</title>
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
<div class="Estilo1">
<form name="f1" action="plandepago.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo4" align="left">PERMITE LA GENERACION DE CUOTAS DE PLAN DE PAGOS</p>
  <table width="500" border="1" bordercolor="#003333" align="left">
  <tr>
    <td width="275"><span class="Estilo8">&nbsp;
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
if(isset($_REQUEST['buscar']))
{
    $rfcfunction  = "ZFICA_REPORTAR_PLAN_PAGOS";
    $entrego      = "F_AUFNR";
    $resultstable = "SALIDA";
    $rfchandle    = saprfc_function_discover($rfc, $rfcfunction);

    $numeroplan = '';
    $documentocuentaxcobrarsap = '';

    if(!$rfchandle)
    {
       echo "We have failed to discover the function".saprfc_error($rfc);
       // exit(1);
    }
    // traigo la tabla interna de SAP
    saprfc_table_init($rfchandle,$resultstable);
    // importo el numero de documento a consultar

    $orden = '00000'.$_REQUEST['busqueda_numero'];
    //echo $orden;
    //$orden = '000001047108';
    saprfc_import($rfchandle,$entrego,$orden);
    $rfcresults = saprfc_call_and_receive($rfchandle);
    $numrows = saprfc_table_rows($rfchandle,$resultstable);

    for ($i=1; $i <= $numrows; $i++)
    {
       $tabla[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
    }
    if ($tabla <> "")
    {  // if 1
        foreach ($tabla as $valortabla => $totaltabla)
        { // foreach 1
            foreach ($totaltabla as $valor1tabla => $total1tabla)
            { // foreach 2
                if ($valor1tabla == "DOCPP_SAP")
                {
                    $numeroplan = $total1tabla;
                    echo $numeroplan,"<br>";
                }
                if ($valor1tabla == "DOCCC_SAP")
                {
                    $documentocuentaxcobrarsap = $total1tabla;
                    echo $documentocuentaxcobrarsap,"<br>";
                }
                if ($valor1tabla == "AUFNR")
                {
                    $numeroordenpago = $total1tabla;
                    echo $numeroordenpago,"<br>";
                }
            } // foreach 2
        } // foreach 1
        if ($numeroplan != '')
        {
            $query_plan = "SELECT o.*
            FROM ordenpagoplandepago o
            WHERE o.numerorodenpagoplandepagosap = '$numeroordenpago'";
            //echo $query_data,"<br>";
            $plan = mysql_query($query_plan, $sala) or die(mysql_error());
            $row_plan = mysql_fetch_assoc($plan);
            $totalRows_plan = mysql_num_rows($plan);
            $mensaje = '';

            if ($totalRows_plan == 0)
            {
                // Inserta el plan de pago
                $insertSQL = "INSERT INTO ordenpagoplandepago (idordenpagoplandepago,fechaordenpagoplandepago,numerodocumentoplandepagosap,cuentaxcobrarplandepagosap,numerorodenpagoplandepagosap,numerorodencoutaplandepagosap,codigoestado,codigoindicadorprocesosap)";
                $insertSQL.= "VALUES ('0','".date("Y-m-d")."','$numeroplan','$documentocuentaxcobrarsap','$numeroordenpago','1','100','100')";
                $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
                $mensaje = 'Se ha insertado el plan de pagos.';
            }

            // Registra garantias en sala
            $insertSQL = "update ordenpagoplandepago
            set codigoindicadorprocesosap = '200'
            where numerorodenpagoplandepagosap = '$numeroordenpago'";
            $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
            $mensaje .= ' Se han registrado garantias';

?>
<script language="JavaScript">
    alert("<?php echo $mensaje; ?>");
</script>
<?php

        }
        /*
        if ($_GET['ANULA'] == '1')
        {
            $insertSQL = "update ordenpagoplandepago
            set codigoestado = '200'
            where numerorodenpagoplandepagosap = '$numeroordenpago'";
            $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
        }*/

        /*if ($_GET['GARANTIA'] == '1')
        {
            $insertSQL = "update ordenpagoplandepago
            set codigoindicadorprocesosap   = '200'
            where numerorodenpagoplandepagosap = '$numeroordenpago'";
            $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
        }*/
    }
    else
    {
?>
<script language="JavaScript">
    window.location.href='plandepago.php'
</script>
<script language="JavaScript">
    alert("La orden de pago ingresada no tiene plan de pagos en SAP, por favor verifique que el número de orden");
</script>
<?php
    }
?>

<?php
}
//echo "$insertSQL";
saprfc_close($rfc);
?>