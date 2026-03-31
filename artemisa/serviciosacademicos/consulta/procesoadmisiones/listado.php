<?php
require_once('../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
?>
<html>
<head>

<title>Consulta Admitido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<body>
<form name="f1" method="get" >
        
    <table width="50%" align="center"  border="0"  cellpadding="3" cellspacing="3">
        <TR>
            <TD colspan="2"><img src="../../../imagenes/noticias_logo.gif" ></TD>
        </TR>    
        <tr id="trtitulogris">
            <TD align="center"  colspan="2"><LABEL  id="labelresaltadogrande">BÚSQUEDA ASPIRANTE</LABEL></TD>
        </tr>
        <TR id="trtitulogris">
            <td align="left" width="30%">Ingrese el Número de Documento:</td>
            <td align="left"><INPUT type="text" name="documento" value="<?php echo $_REQUEST['documento'] ?>">&nbsp;&nbsp;<INPUT type="submit" name="aceptar" value="Aceptar"></TD></td>            
        </TR>
        <TR>
            <TD>
        </TR>
    </table>  
       <BR><BR>
  
    <?php 
    if (isset($_REQUEST['aceptar'])){
        /*
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega la condicional tr.codigoperiodo... para que no muestre informacion de periodos anteriores.
         * @since Noviembre 6, 2018
         */           
        $query_aspirante = "SELECT tr.documento, tr.nombre, tr.estado, tr.fecha, tr.hora, tr.salon, tr.edificio, tt.descripciontmptiporesultadoadmisiones, c.nombrecarrera, tr.idtmptiporesultadoadmisiones, tr.carrerasegundaopcion, tr.codigoperiodo, tt.nombretmptiporesultadoadmisiones, tr.cuentavecesingresado   
        FROM tmpresultadoadmisiones tr, tmptiporesultadoadmisiones tt, carrera c 
        where documento= '".$_REQUEST['documento']."'
        and tr.idtmptiporesultadoadmisiones = tt.idtmptiporesultadoadmisiones
        and c.codigocarrera=tr.codigocarreraadmision
        and tr.codigoperiodo=(SELECT MAX(codigoperiodo) codigoperiodo FROM periodo WHERE (codigoestadoperiodo=1 OR codigoestadoperiodo=4))
        and tr.codigoestado like '1%'
        ";
        $aspirante= $db->Execute($query_aspirante);
        $totalRows_aspirante = $aspirante->RecordCount();  
        $row_aspirante = $aspirante->FetchRow();      
           
        if ($totalRows_aspirante >0){ 
               
            $cuenta=$row_aspirante['cuentavecesingresado'];
            $cuenta++;
            $query_actualizar = "UPDATE tmpresultadoadmisiones SET 
            cuentavecesingresado='$cuenta'                
            where documento = '{$row_aspirante['documento']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());    
        ?>       
            <table width="60%" align="center"   border="1"  cellpadding="3" cellspacing="3">
                <TR id="trtitulogris">
                    <TD colspan="8" align="center"><LABEL id="labelresaltadogrande">PROCESO DE ADMISIONES 
                    <?php 
                    if ($totalRows_aspirante == 1){
                    ?>
                    </BR> <?php echo $row_aspirante['nombrecarrera']; ?>
                    <?php 
                    }
                    ?>
                    PARA EL PERIODO <?php echo substr($row_aspirante['codigoperiodo'],0,4)."-".substr($row_aspirante['codigoperiodo'],4,1); ?>
                    </BR><?php echo $row_aspirante['nombretmptiporesultadoadmisiones']; ?></LABEL>           
                    <P align="left"><LABEL id="labelresaltadogrande"><?php echo $row_aspirante['nombre']; ?></LABEL>
                    </P>
                    </TD>
                </TR>
                <?php 
                if ($totalRows_aspirante == 1){
                 ?>
                    <TR align="justify">
                        <TD colspan="8" style="text-align: justify;" ><font color="#596221" size="2"><?php echo str_replace("<carrera>",$row_aspirante['carrerasegundaopcion'],$row_aspirante['descripciontmptiporesultadoadmisiones']); ?></font></P>
                        </TD>
                    </TR>
                <?php 
                }
                if ($row_aspirante['idtmptiporesultadoadmisiones'] != 1 and $row_aspirante['idtmptiporesultadoadmisiones'] != 5){ 
                ?>
                    <TR id="trtitulogris">
                        <TD width="10%" align="center">Número Documento</TD>                    
                        <TD align="center">Estado</TD>
                        <TD align="center">Salón</TD>
                        <TD align="center">Edificio</TD>
                        <TD align="center">Fecha Citación</TD>
                        <TD align="center">Hora Citación</TD>
                        <?php 
                        if ($row_aspirante['idtmptiporesultadoadmisiones'] == 3) {                    
                        ?>
                            <TD align="center">Segunda Opción</TD>
                        <?php 
                        }
                        ?>
                        <?php 
                        if ($totalRows_aspirante > 1){
                        ?>
                            <TD align="center">Carrera</TD>
                            <TD align="center">Observación</TD>
                        <?php 
                        }
                        ?>                                      
                    </TR>                
                    <?php                  
                    do { ?>
                    <TR>
                        <TD align="left">                    
                        <?php echo $row_aspirante['documento']; ?>                    
                        </TD>                    
                        <TD align="left"><?php echo $row_aspirante['estado']; ?>
                        </TD>
                        <TD align="left"><?php echo $row_aspirante['salon']; ?>
                        </TD>
                        <TD align="left"><?php echo $row_aspirante['edificio']; ?>
                        </TD>
                        <TD align="left"><?php echo $row_aspirante['fecha']; ?>
                        </TD>
                        <TD align="left"><?php echo $row_aspirante['hora']; ?>
                        </TD>
                        <?php 
                        if ($row_aspirante['idtmptiporesultadoadmisiones'] == 3) {                    
                        ?>
                            <TD align="left"><?php echo $row_aspirante['carrerasegundaopcion']; ?>
                            </TD>
                        <?php 
                        }
                        ?>
                        <?php 
                        if ($totalRows_aspirante > 1){
                        ?>
                            <TD align="left"><?php echo $row_aspirante['nombrecarrera']; ?>
                            </TD>
                            <TD align="left"><?php echo $row_aspirante['descripciontmptiporesultadoadmisiones']; ?>
                            </TD>
                        <?php 
                        }
                        ?> 
                    </TR>
                    <?php 
                    } while($row_aspirante = $aspirante->FetchRow());
                }
                ?>                           
            </table>
            </BR>
            </BR>
            </BR>
            <table width="60%" align="center"   border="0"  cellpadding="3" cellspacing="3">
                <TR id="trtitulogris">
                    <TD colspan="8" align="left">Para imprimir su resultado haga clic en el botón&nbsp;&nbsp;<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
                    </TD>
                </TR>
            </table>        
        <?php
        }
        else {
            $query_periodo = "SELECT codigoperiodo FROM periodo where codigoestadoperiodo = '4'";
            $periodo= $db->Execute($query_periodo);
            $totalRows_periodo = $periodo->RecordCount();  
            $row_periodo = $periodo->FetchRow();
            
                    
            $query_aspi = "SELECT eg.numerodocumento
            ,e.codigocarrera
            ,c.nombrecarrera
            FROM estudiantegeneral eg
            INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
            INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
            WHERE eg.numerodocumento='".$_REQUEST['documento']."'
            AND e.codigosituacioncarreraestudiante='113'
            AND e.codigocarrera='10'
            AND e.codigoperiodo='".$row_periodo['codigoperiodo']."'
            ";
            $aspi= $db->Execute($query_aspi);
            $totalRows_aspi = $aspi->RecordCount();  
            $row_aspi = $aspi->FetchRow(); 
            
            $query_actualizar = "UPDATE tmpresultadoadmisiones SET 
            cuentavecesingresado=cuentavecesingresado+1                 
            where idtmpresultadoadmisiones = '1094'
            and codigoestado like '2%'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());                  
            
            if($totalRows_aspi>0){                
                echo "<script language='javascript'> 
                alert ('Usted no fue admitido para el programa de ".$row_aspi['nombrecarrera'].". La Universidad se contactará con usted para revisar la segunda opción.');
                </script>";                
            }else{
                echo "<script language='javascript'> 
                alert ('El documento con el que intenta ingresar,  no se encuentra registrado  en el proceso de admisiones del periodo ".$row_periodo['codigoperiodo'].". Por favor verifíquelo y digítelo nuevamente.');
                </script>";                
            }
            
            
            
        }
    }
    ?>
  
    
</form>
</body>
</html>
