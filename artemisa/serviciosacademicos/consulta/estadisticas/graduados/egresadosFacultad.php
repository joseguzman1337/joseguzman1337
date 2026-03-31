<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(!isset ($_SESSION['MM_Username'])){
	?>
	<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi&oacute;n en el sistema</strong></blink>
	<?PHP
    exit();
} 
$ruta = "../";
while (!is_file($ruta . 'Connections/sala2.php')) {
    $ruta = $ruta . "../";
}
require_once($ruta . 'Connections/sala2.php');
$rutaado = $ruta . "funciones/adodb/";
require_once($ruta . 'Connections/salaado.php');
include("js/template.php");
//$db=writeHeader("Listado Usuarios",true);

                 $SQL = "SELECT
                        nombrefacultad,
                        SUM(Mujeres) AS Mujeres,
                        SUM(Hombres) AS Hombres
                FROM
                        (
                                SELECT
                                        nombrefacultad,
                                        nombrecarrera,
                                        SUM(Mujeres) AS Mujeres,
                                        SUM(Hombres) AS Hombres
                                FROM
                                        (
                                                SELECT
                                                        c.nombrecarrera,
                                                        d.nombrefacultad,
                                                        COUNT(rg.idregistrograduado) AS graduados,
                                                        0 graduadosantiguos,
                                                        COUNT(
                                                                CASE
                                                                WHEN g.codigogenero = 100 THEN
                                                                        1
                                                                END
                                                        ) AS Mujeres,
                                                        COUNT(
                                                                CASE
                                                                WHEN g.codigogenero = 200 THEN
                                                                        1
                                                                END
                                                        ) AS Hombres,
                                                        p.codigoperiodo,

                                                IF (
                                                        substring(p.codigoperiodo, 5, 5) = '2',
                                                        concat(
                                                                substring(p.codigoperiodo, 1, 4),
                                                                '-07-16'
                                                        ),
                                                        concat(
                                                                substring(p.codigoperiodo, 1, 4),
                                                                '-01-01'
                                                        )
                                                ) fecha_inicial,

                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-12-31'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-15'
                                                )
                                        ) fecha_final
                                        FROM
                                                registrograduado rg,
                                                estudiante e,
                                                periodo p,
                                                carrera c,
                                                modalidadacademica m,
                                                genero g,
                                                estudiantegeneral eg,
                                                facultad d
                                        WHERE
                                                rg.codigoestudiante = e.codigoestudiante
                                        AND c.codigomodalidadacademica = m.codigomodalidadacademica
                                        AND c.codigocarrera = e.codigocarrera
                                        AND c.codigofacultad = d.codigofacultad
                                        AND rg.codigoestado = '100'
                                        AND rg.codigoautorizacionregistrograduado = '100'
                                        AND eg.idestudiantegeneral = e.idestudiantegeneral
                                        AND g.codigogenero = eg.codigogenero
                                        AND rg.fechagradoregistrograduado BETWEEN
                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-16'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-01-01'
                                                )
                                        )
                                        AND
                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-12-31'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-15'
                                                )
                                        )
                                        GROUP BY
                                                c.codigocarrera,
                                                p.codigoperiodo,
                                                d.codigofacultad
                                        UNION
                                                SELECT
                                                        c.nombrecarrera,
                                                        0 graduados,
                                                        d.nombrefacultad,
                                                        c.nombrecortocarrera,
                                                        COUNT(
                                                                CASE
                                                                WHEN EG.codigogenero = 100 THEN
                                                                        1
                                                                END
                                                        ) AS Mujeres,
                                                        COUNT(
                                                                CASE
                                                                WHEN EG.codigogenero = 200 THEN
                                                                        1
                                                                END
                                                        ) AS Hombres,
                                                        p.codigoperiodo,

                                                IF (
                                                        substring(p.codigoperiodo, 5, 5) = '2',
                                                        concat(
                                                                substring(p.codigoperiodo, 1, 4),
                                                                '-07-16'
                                                        ),
                                                        concat(
                                                                substring(p.codigoperiodo, 1, 4),
                                                                '-01-01'
                                                        )
                                                ) fecha_inicial,

                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-12-31'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-15'
                                                )
                                        ) fecha_final
                                        FROM
                                                registrograduadoantiguo rg,
                                                periodo p,
                                                carrera c,
                                                modalidadacademica m,
                                                estudiante E,
                                                estudiantegeneral EG,
                                                facultad d
                                        WHERE
                                                c.codigomodalidadacademica = m.codigomodalidadacademica
                                        AND rg.codigocarrera = c.codigocarrera
                                        AND E.codigoestudiante = rg.codigoestudiante
                                        AND EG.idestudiantegeneral = E.idestudiantegeneral
                                        AND rg.codigocarrera = c.codigocarrera
                                        AND c.codigofacultad = d.codigofacultad
                                        AND rg.fechagradoregistrograduadoantiguo BETWEEN
                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-16'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-01-01'
                                                )
                                        )
                                        AND
                                        IF (
                                                substring(p.codigoperiodo, 5, 5) = '2',
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-12-31'
                                                ),
                                                concat(
                                                        substring(p.codigoperiodo, 1, 4),
                                                        '-07-15'
                                                )
                                        )
                                        GROUP BY
                                                c.codigocarrera,
                                                p.codigoperiodo,
                                                d.codigofacultad
                                        ORDER BY
                                                codigoperiodo DESC,
                                                nombrecarrera
                                        ) Ter
                                GROUP BY
                                        nombrecarrera
                        ) fac
                GROUP BY
                        nombrefacultad";

if ($Data = &$db->Execute($SQL) === false) {
    echo 'Error en el SQL Data Solicitudes....<br><br>' . $SQL;
    die;
}
$Resultado = $Data->GetArray();
?>
            <!--<img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" onclick="ExportarExcel();" title="Exportar a Excel" />-->
            

<link type="text/css" rel="stylesheet" href="js/jquery.dataTables.css" />
<script type="text/javascript" language="javascript" src="js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>  
<form>
    <body>
<div id="container" style="width:50%">
    <div id="test">                
        <h2>Distribuci&oacute;n de los egresados por facultad</h2>
        <table width="100%" cellpadding="0" cellspacing="0" border="1" class="display" id="example">
            <thead>
                <tr>
                    <th colspan="1">Facultad</th>						                    
                    <th colspan="2">Mujeres</th>
                    <th colspan="2">Hombres</th>
                </tr>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>%</th>     
                    <th>#</th>                                   
                    <th>%</th> 
                </tr>
            </thead>
            <tbody> 
<?PHP
$num = count($Resultado);
$totalH=0;
for ($i = 0; $i <= count($Resultado); $i++) {
       $totalH=$totalH+$Resultado[$i]['Hombres'];
       $totalM=$totalM+$Resultado[$i]['Mujeres'];
}
for ($i = 0; $i <= count($Resultado); $i++) {
    if($Resultado[$i]['nombrefacultad'] <> '0'){
    $id = $Resultado[$i]['SolicitudAsignacionEspacioId'];
    //  print_r ($Resultado[$i]['SolicitudAsignacionEspacioId']);
        
             if($i <> count($Resultado)){
    ?>
                  <tr>
                      <td><b><?PHP echo ($Resultado[$i]['nombrefacultad']);?></b></td>
                        <td align="center"><?PHP echo $Resultado[$i]['Mujeres']; ?></td>
                        <td align="center"><?PHP echo number_format(($Resultado[$i]['Mujeres']*100)/$totalM,2, ',', ' ');?></td>
                        <td align="center"><?PHP echo $Resultado[$i]['Hombres']; ?></td>                       
                        <td align="center"><?PHP echo number_format(($Resultado[$i]['Hombres']*100)/$totalH,2, ',', ' ');?></td>
    <?PHP
    /*     * ************************************************** */
             }else{
                 echo "<td><b>Total</b></td>";
                 echo "<td align='center'>".$totalM."</td>";
                 echo "<td align='center'>".($totalM*100)/$totalM."</td>";
                 echo "<td align='center'>".$totalH."</td>";
                 echo "<td align='center'>".($totalH*100)/$totalH."</td>";
             }
       echo "</tr>" ;
    }
}//for
?>    
                        
            </tbody>
        </table>
    </div>
</div>
</body>
</form>
     <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion" >
                <body>
                    <table border="1" align="left" width=0.5%>
                        <tr>
                            <td align="center">
                                <p><img src="js/images/Office-Excel-icon.png" width="30" style="cursor: pointer;" class="botonExcel" /></button></p><FONT SIZE=1><b>Exportar a Excel</b></FONT></b>
                                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                            </td>
                             <td align="center" >
                                <p><a href="menugraduados.php" ><img  width="30" src="js/images/return.png" /></a></p><b><FONT SIZE=1>Retornar</FONT></b>

                         </td>
                        </tr> 
                    </table>
                </body>
            </form>


<script type="text/javascript">
      $(".botonExcel").click(function (event) {
            $("#datos_a_enviar").val($("<div>").append($("#example").eq(0).clone()).html());
            $("#FormularioExportacion").submit();

        });
</script>


<?php writeFooter();
?>       


