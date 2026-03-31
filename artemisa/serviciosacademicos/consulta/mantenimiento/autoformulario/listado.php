<?php
session_start();
ini_set('memory_limit', '256M');
ini_set('max_execution_time','216000');

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../../sala/includes/adaptador.php");
require_once("../../../funciones/clases/motor/motor_mod.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("funciones/paginador.php");

$permission = getPermissionByUser($db);

if(count($permission) == 0)
{
    ?>
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
    <?php

    echo "
        <div class='alert alert-danger' role='alert'>
          Usted no tiene permiso para ver esta página
        </div>";
    exit();
}

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>

<style>
    .sa_trace_start_link, .sa_trace_start_link:hover
    {
        color: lime;
        text-decoration: none;
    }
    .sa_trace_start
    {
        padding: 2px;
        text-align: center;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
    .sa_trace_dump
    {
        border: solid;
        border-color: lime;
        padding: 20px;
        position: absolute;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        visibility: hidden;
        color: lime;
    }
    .sa_trace_end
    {
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
</style>

<script language="JavaScript" type="text/JavaScript">

</script>

<form name="form1" method="GET" action="">
    <?php
    ob_start();
    define('ENABLE_DEBUG', true);
    $link_origen=$_GET['link_origen'];
    $ruta="/var/tmp/";
    if($_SESSION['filasporpagina']<>"")
    {
        $FilasPorPagina = $_SESSION['filasporpagina'];
    }
    else
    {
        $FilasPorPagina=50;
    }
    if($_SESSION['tabla']<>$_GET['tabla'])
    {
        $tabla=$_GET['tabla'];
        if(!file_exists($ruta.$tabla.".txt"))
        {
            require('generador_archivos.php');
        }
        //obtener cantidad filas
        if(isset($_SESSION['where']) and $_SESSION['where'] <> "")
        {
            $query_cant_filas="SELECT COUNT(*) AS cant_filas FROM $tabla WHERE ".stripslashes($_SESSION['where'])."";
        }
        else
        {
            $query_cant_filas="SELECT COUNT(*) AS cant_filas FROM $tabla";
        }

        $operacionCantFilas=$sala->query($query_cant_filas);
        $row_operacionCantFilas=$operacionCantFilas->fetchRow();
        $CantidadFilasTabla=$row_operacionCantFilas['cant_filas'];
        echo "Cantidad de filas de toda la tabla: ".$CantidadFilasTabla."<br>";
        echo "Condición WHERE: ".stripslashes($_SESSION['where']);

        // Poner pagina por defecto
        if (!isset($_GET['pagina']))
        {
            $_GET['pagina'] = 1;
        }
        //instanciar paginador
        $pager = new Paginador($FilasPorPagina, $CantidadFilasTabla,$_GET['pagina']);
        //html para el paginador
        echo "<table align=\"center\">\n<tr>\n";
        for ($i = 1; $i <= $pager->ObtenerTotalPaginas(); $i++)
        {
            echo "<td><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=$i&tabla=$tabla&link_origen=$link_origen\">";
            if ($i == $_GET['pagina'])
            {
                echo "<strong>$i</strong>";
            }
            else
            {
                echo $i;
            }
            echo "</a></td>\n";
        }
        echo "</tr>\n</table>\n";

        ////Tomar atributos de la tabla
        $obj=new ADODB_Active_Record($tabla);
        $atributos=$obj->GetAttributeNames();
        $info=$obj->TableInfo();
        $llave=array_keys($info->keys);
        /////*****************************
        if(isset($_SESSION['where']) and $_SESSION['where']<>"")
        {
            $query="SELECT * FROM $tabla WHERE ".stripslashes($_SESSION['where'])." LIMIT " . $pager->ObtenerPaginaInicio() . ", " . $FilasPorPagina;
        }

        else
        {
            $query="SELECT * FROM $tabla LIMIT " . $pager->ObtenerPaginaInicio() . ", " . $FilasPorPagina;
        }
        //echo $query;
        $operacion=$sala->query($query);
        $row_operacion=$operacion->fetchRow();
        do
        {
            $array_interno[]=$row_operacion;
        }
        while($row_operacion=$operacion->fetchRow());
        $motor = new matriz($array_interno,$tabla,"listado.php?tabla=$tabla&inferior=$inferior&superior=$superior","si","si","menu.php");
        $motor->agregarllave_drilldown($llave[0],'listado.php','formulario.php','form',$llave[0],"tabla=$tabla&inferior=$inferior&superior=$superior");
        $motor->mostrar();
        $motor->MuestraBotonVentanaEmergente("Agregar_Registro","formulario.php","tabla=$tabla&inferior=$inferior&superior=$superior",800,600);
    }
    else
    {
        echo "<h1>No ha seleccionado tabla</h1>";
    }

    function getPermissionByUser($db)
    {
        $query = "
        SELECT p.id, p.idTipoPermiso, idRelacionUsuario,
                       p.idUsuario, p.editar, p.ver, p.insertar, p.eliminar,p.idComponenteModulo,mo.nombremenuopcion
                  FROM Permiso p
                      inner join usuario u on p.idUsuario = u.idusuario
                      inner join menuopcion mo on mo.idmenuopcion = p.idComponenteModulo
            INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso)
            where u.usuario = '".$_SESSION['usuario']."'
            and p.idComponenteModulo = 117;
    ";

        $data = $db->GetRow($query);
        return $data;
    }
    ?>
</form>