<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once('../../../../Connections/sala2.php');  $rutaado = "../../../../funciones/adodb/";
    require_once('../../../../Connections/salaado.php');

    $query_registros_anteror="SELECT * FROM contenidoprogramatico c where c.codigomateria = '".$_REQUEST['codigomateria']."' and c.codigoestado like '1%' GROUP BY c.codigoperiodo desc";
    $query_registros_anteror = $db->Execute ($query_registros_anteror) or die("$query_registros_anteror".mysql_error());    
?>
<html>
    <head>         
        <script src="../../js/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" language="javascript" src="../../../../js/jquery.js"></script>   
        <script type="text/javascript" language="javascript" src="../../../../js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="../../../../css/jquery.dataTables.css">
        <script>
            $(document).ready(function(){
               $('#Jtabla').DataTable(); 
            });
        </script>
    </head>
    <body>
        <center>
            <div style="width:60%;">
         <table id="Jtabla" cellpadding="0" cellspacing="0" border="0" class="display"> 
            <tr>
                <th>Periodo</th><th>Usuario</th><th>Syllabus</th><th>Contenido del Programa</th>
            </tr>
            <?php
            while ($query_registros_anteror_row = $query_registros_anteror->FetchRow()) 
                {
				    echo "<tr><td>".$query_registros_anteror_row["codigoperiodo"]."</td>";                    
                    echo "<td>".$query_registros_anteror_row["usuario"]."</td>"; 
                    if($query_registros_anteror_row['urlcontenidoprogramatico'])
                    {
                        echo "<td><a href='contenidoprogramatico/".$query_registros_anteror_row["urlasyllabuscontenidoprogramatico"]."' target='_blank' >Ver Documento</a></td>";
                        echo "<td><a href='contenidoprogramatico/".$query_registros_anteror_row["urlaarchivofinalcontenidoprogramatico"]."' target='_blank' >Ver Documento</a></td>";
                    }else
                    {
                        $sqldetalle = "select iddetallecontenidoprogramatico from detallecontenidoprogramatico WHERE idcontenidoprogramatico ='".$query_registros_anteror_row["idcontenidoprogramatico"]."' limit 1";
                        $sqlDetalles = $db->Execute ($sqldetalle) or die("$sqldetalle".mysql_error());
                        $sqlDetallesdatos = $sqlDetalles->FetchRow();            
                        if($sqlDetallesdatos['iddetallecontenidoprogramatico'])
                        {
                           echo "<td><a href='toPdf.php?codigomateria=".$_REQUEST['codigomateria']."&type=1&periodosesion=".$query_registros_anteror_row["codigoperiodo"]."&usuariosesion=".$_SESSION['MM_Username']."' target='_blank' title='Syllabus' >Ver Documento</a></td>";
                           echo "<td><a href='toPdf.php?codigomateria=".$_REQUEST['codigomateria']."&type=2&periodosesion=".$query_registros_anteror_row["codigoperiodo"]."&usuariosesion=".$_SESSION['MM_Username']."' target='_blank' title='Asignatura'>Ver Documento</a></td></tr>";
                        }else
                        {
                            echo "<td>Documento no Adjunto</td>";
                            echo "<td>Documento no Adjunto</td></tr>";
                        }
                    }//else
				}//while
        ?>
        </table>
                <br><br>
            <form action="../contenidoprogramatico/contenidoprograma.php" method="post">                               
                <input type="submit" value="regresar"/>
        </form>
        </div>
        </center>
    </body>
</html>