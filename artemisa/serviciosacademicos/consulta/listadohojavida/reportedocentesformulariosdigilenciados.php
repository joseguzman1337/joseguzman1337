<?php
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("docente.php");

/*if(isset($_SESSION['debug_sesion']))
{
   //$db->debug = true;
}
//print_r($_SERVER);*/
//$db->debug = true;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado de Históricos</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<SCRIPT language="JavaScript" type="text/javascript">
function enviar()
{

    document.form1.submit();
}
</SCRIPT>
</head>
<body>
<form name="form1" id="form1"  method="POST">
<?php

            $query_selec = "select * from carrera
            where codigomodalidadacademica like '2%'
            and now() between fechainiciocarrera and fechavencimientocarrera
            order by nombrecarrera";
            $selec = $db->Execute($query_selec);
            $totalRows_selec = $selec->RecordCount();
            ?>
             <select name="selec" id="selec" onchange="enviar()" >
             <OPTION value="">Seleccionar</OPTION>
            <option value="todas">Todas</option>
            <?php while($row_selec = $selec->FetchRow()){?>
            <option value="<?php echo $row_selec['codigocarrera']?>"

<?php
 if ($row_selec['codigocarrera']==$_POST['selec']) {
                        echo "Selected";

                    }
?>>
                                <?php echo $row_selec['nombrecarrera'];
                                ?>
                            </option><?php }?>
                            </select></br>

<?php
if($_POST['selec'] == "todas") {
    $query_carrera = "select * from carrera
            where codigomodalidadacademica like '2%'
            and now() between fechainiciocarrera and fechavencimientocarrera
            order by nombrecarrera";
}
else
    $query_carrera = "select codigocarrera from carrera where codigocarrera='".$_POST['selec']."'";
$carrera = $db->Execute($query_carrera);
$totalRows_carrera = $carrera->RecordCount();
?>
</br>
</br>
<TABLE border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <TR id=trtitulogris>
        <TD>Carrera</TD>
        <TD>Total Docentes</TD>
        <TD>Total Docentes Diligenciados</TD>
    </TR>
<?php
$totalDocentesFinal = 0;
while($row_carrera = $carrera->FetchRow()) {
    unset($Arraydocentes);
    $query_docentecarrera="select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,if(ca.nombrecarrera='TODAS LAS CARRERAS','POSTGRADOS',ca.nombrecarrera) Nombre_Carrera,dc3.codigocarrera from  docente d,detallecontratodocente dc,contratodocente c
    left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
    dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
    left join carrera ca on ca.codigocarrera =dc3.codigocarrera
    where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and dc.codigocarrera = '".$row_carrera['codigocarrera']."'
    and d.codigoestado like '1%'
    group by d.iddocente
    union
    select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca.nombrecarrera Nombre_Carrera,ca.codigocarrera
    from  docente d,grupo g,carrera ca,materia m
    where
    d.numerodocumento =g.numerodocumento and
    g.codigoperiodo in ('20092') and
    g.codigomateria = m.codigomateria and
    m.codigocarrera=ca.codigocarrera
    and ca.codigocarrera = '".$row_carrera['codigocarrera']."'
    and d.numerodocumento <> '1'
    and d.iddocente not in(
    select distinct d.iddocente
    from  docente d,detallecontratodocente dc,contratodocente c
    left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
    dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
    left join carrera ca on ca.codigocarrera =dc3.codigocarrera
    where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente
    )
    and d.codigoestado like '1%'
    group by d.iddocente
    union
    select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca2.nombrecarrera Nombre_Carrera,ca2.codigocarrera
    from  docente d,grupo g,carrera ca,carrera ca2,materia m,contratodocente cp, detallecontratodocente dcp
    where
    d.numerodocumento =g.numerodocumento and
    g.codigoperiodo in ('20092') and
    g.codigomateria = m.codigomateria and
    m.codigocarrera=ca.codigocarrera
    and ca.codigocarrera = '".$row_carrera['codigocarrera']."'
    and d.numerodocumento <> '1'
    and cp.iddocente=d.iddocente
    and dcp.idcontratodocente=cp.idcontratodocente
    and dcp.codigocarrera <> '".$row_carrera['codigocarrera']."'
    and d.iddocente not in(
    select distinct d.iddocente
    from  docente d,detallecontratodocente dc,contratodocente c
    left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
    dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
    left join carrera ca on ca.codigocarrera =dc3.codigocarrera
    where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and  dc.codigocarrera = '".$row_carrera['codigocarrera']."'
    )
    and dcp.codigocarrera=ca2.codigocarrera
    and d.codigoestado like '1%'
    group by d.iddocente";

    $docentecarrera = $db->Execute($query_docentecarrera);
        $totalRows_docentecarrera = $docentecarrera->RecordCount();
        //$row_docentecarrera = $docentecarrera->FetchRow();
    $cuenta = 0;
    
        while ($row_docentecarrera=$docentecarrera->fetchRow()){
        if($row_docentecarrera['codigocarrera'] == $row_carrera['codigocarrera']) {
            $cuenta++;
            //echo "$cuenta -- ";
            $docentetest=new docente();
            $docentetest->atributos($row_docentecarrera['iddocente'], $row_docentecarrera['codigocarrera'], $row_docentecarrera['apellidodocente'], $row_docentecarrera['nombredocente']);
            //$docentetest->imprimir();
            $Arraydocentes[$row_docentecarrera['Nombre_Carrera']][] = $docentetest;
        }
    }
    //echo "<h1>$cuenta</h1>";
    if(is_array($Arraydocentes)) {
?>
<TR>
<?php
        foreach($Arraydocentes as $nombreCarrera => $aDocenteCarrera) {
?>
<TD id=tdtitulogris><?php echo $nombreCarrera; ?> </TD>
<?php
    $totalDocentes = count($Arraydocentes[$nombreCarrera]);
    $totalDocentesFinal +=$totalDocentes;
   
?>
<TD><?php echo $totalDocentes; ?> </TD>

<?php
    $cuentaFormularios = array(
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
        9 => 0,
        10 => 0
    );
            //echo "<h1>$totalDocentes</h1>";
            foreach($aDocenteCarrera as $docente) {
                unset($aFormularios);
                $cuentaFormularios[$docente->cuentaformulariosiniciados]++;
            }
?>
<TD>
<TABLE border="1" width="100%" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr id=trtitulogris><TD>Número Formularios</TD><TD>Total Docentes X Formulario</TD></tr>
<?php
            foreach($cuentaFormularios as $numeroformularios => $totaldocentesformulario) {
                
                 $totalFinal[$numeroformularios]+=$totaldocentesformulario;
               
       ?><TR>
<TD><?php echo $numeroformularios;?>
</TD>
<TD><?php echo $totaldocentesformulario;?>
</TD>
</TR>
<?php
        //echo "$numeroformularios => $totaldocentesformulario<br>";
            }
?>
</table>
</TD>
<?php

        }
?>
</TR>
<?php
    }
}
?>


<?php if($_POST['selec'] == "todas") { ?>

    <TR >
        <TD id="tdtitulogris">TOTAL DOCENTES</TD>
        <TD><?php echo $totalDocentesFinal; ?> </TD>
        <TD>
            <TABLE border="1" width="100%" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                <tr id=trtitulogris><TD>Número Formularios</TD><TD>Total Docentes X Formulario</TD></tr>
                <?php
                            foreach($totalFinal as $numeroformularios => $totaldocentesformulario) {
                                
                                
                            
                    ?><TR>
                <TD><?php echo $numeroformularios;?>
                </TD>
                <TD><?php echo $totaldocentesformulario;?>
                </TD>
                </TR>
                <?php
                        //echo "$numeroformularios => $totaldocentesformulario<br>";
                            }
                ?>
            </table>
        </TD>
    </TR>



<?php } ?>
</TABLE>
</form>
</body>
</html>