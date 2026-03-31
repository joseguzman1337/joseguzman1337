<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
unset ($_SESSION['sesion_materias']);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

if (isset($_REQUEST['busqueda'])){
    $query ="select m.codigomateria, m.nombremateria, m.codigocarrera, c.nombrecarrera from materia m, carrera c
            where (m.nombremateria like '%".$_REQUEST['busqueda']."%' or m.codigomateria like '".$_REQUEST['busqueda']."')
            and m.codigocarrera = c.codigocarrera
            and m.codigoestadomateria like '01%'
            order by m.nombremateria asc, c.nombrecarrera";
        $rta= $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
    $resultado = $_REQUEST['busqueda'];

        if ($totalRows_rta == 0){
        ?>
        <SCRIPT language="JavaScript">
        alert ('No se Obtuvo Ningún Resultado con el Criterio de Búsqueda por Favor Verifique'); window.location.href='menumodalidad.php';
        </SCRIPT>
        <?php
        }

}
else {
    $query ="select m.codigomateria, m.nombremateria, m.codigocarrera, c.nombrecarrera from materia m, carrera c
            where m.nombremateria like '%".$_REQUEST['buscar']."%'
            and m.codigocarrera = c.codigocarrera
            and m.codigocarrera = '".$_REQUEST['codigocarrera']."'
            and m.codigoestadomateria like '01%'
            order by m.nombremateria asc, c.nombrecarrera";
        $rta= $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        $resultado = $_REQUEST['buscar'];

        if ($totalRows_rta == 0){
        ?>
        <SCRIPT language="JavaScript">
        alert ('No se Obtuvo Ningún Resultado con el Criterio de Búsqueda por Favor Verifique'); window.location.href='lista.php?codigocarrera=<?php echo $_REQUEST['codigocarrera'];?>';
        </SCRIPT>
        <?php
        }

}

?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1"  method="GET">
    <INPUT type="hidden" name="busqueda" value="<?php echo $resultado; ?>">
  <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR >
           <TD align="center"><label id="labelresaltadogrande" >Resultados de la Busqueda "<?php echo $resultado; ?>"</label></TD>
          </TR>
   </table>

       <TABLE width="50%"  border="1" align="center">
        <TR id="trgris">
            <TD align="center"><label id="labelresaltado">Código </label></TD>
            <TD align="center"><label id="labelresaltado">Nombre  Materia </label></TD>
            <TD align="center"><label id="labelresaltado">Nombre  Carrrera </label></TD>
        </TR>
            <?php do {?>
        <TR>
            <TD width="5%" align="center"><?php echo $row_rta['codigomateria']; ?></TD>
            <TD align="center"><A id="aparencialink" href="insertar_modificar.php?codigomateria=<?php echo $row_rta['codigomateria']."&codigocarrera=".$row_rta['codigocarrera']."&busqueda=".$resultado; ?>"><?php echo $row_rta['nombremateria']; ?></A></TD>
            <TD  align="center"><?php echo $row_rta['nombrecarrera']; ?></TD>
        </TR>
        <?php }while($row_rta = $rta->FetchRow());
         ?>
        <TR align="left">
                <TD id="tdtitulogris" colspan="4"  align="center">

                <!--<INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_modificar.php?codigocarrera=<?php echo $row_rta['codigocarrera']; ?>'"> -->
                <?php if (isset($_REQUEST['busqueda'])){ ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='menumodalidad.php'">
                <?php }
                else { ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                <?php } ?>
                </TD>
       </TABLE>

</form>
</body>
</html>