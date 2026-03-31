<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
session_start();
//print_r($_SESSION);
unset ($_SESSION['sesion_planestudioporcarrera']);
    $query_facultad ="select cc.codigocarrera, cc.nombrecarrera, f.nombrefacultad
                        from carrera cc, facultad f
                        where cc.codigofacultad in(
                        select cf.codigofacultad
                        from carrera ca, facultad cf
                        where ca.codigofacultad = cf.codigofacultad
                        and ca.codigocarrera = '".$_SESSION['codigofacultad']."')
                        and cc.codigofacultad = f.codigofacultad";
        $facultad= $db->Execute($query_facultad);
                $totalRows_facultad = $facultad->RecordCount();
                $row_facultad = $facultad->FetchRow();
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1"  method="GET">
  <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR >
           <TD align="center"><label id="labelresaltadogrande" >Lista de Carreras Para  <?php echo $row_facultad['nombrefacultad']; ?></label></TD>
          </TR>
   </table>

       <TABLE width="50%"  border="1" align="center">
        <TR id="trgris">
            <TD align="center"><label id="labelresaltado">Codigo Carrera</label></TD>
            <TD align="center"><label id="labelresaltado">Nombre de  Carrera</label></TD>


        </TR>
            <?php do {?>
        <TR>
            <TD width="5%" align="center"><?php echo $row_facultad['codigocarrera']; ?></TD>
            <TD align="center"><A id="aparencialink" href="plandeestudioinicial.php?nacodigocarrera=<?php echo $row_facultad['codigocarrera']; ?>"><?php echo $row_facultad['nombrecarrera']; ?></A></TD>

        </TR>
        <?php }
                while($row_facultad = $facultad->FetchRow());
         ?>

       </TABLE>

</form>
</body>
</html>