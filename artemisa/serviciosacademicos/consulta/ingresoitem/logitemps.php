<?php
session_start();

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../funciones/funcionip.php' );
	$ip = "SIN DEFINIR";
	$ip = tomarip();
 /*echo "<pre>";
 print_r($_SESSION);
 echo "</pre>";
 exit;*/


 /*$query_maxid="SELECT max(idlog_registroitem) as maxid FROM log_registroitem ";
 $maxid= $db->Execute($query_maxid);
 $totalRows_maxid= $maxid->RecordCount();
 $row_maxid= $maxid->FetchRow();

 if($row_maxid['maxid']==NULL || $row_maxid['maxid']==''){
    $idproximo=1;
 }
 else{
     $idproximo=$row_maxid['maxid'] + 1;
 }*/
 
 
 
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="form1"  method="POST" action="">
            <TABLE  border="1" align="left" cellpadding="3">
                <TR >
                    <TD align="center" colspan="2"><label id="labelresaltadogrande">Informe Cargue Ítems PS-SALA</label> </TD>
                </TR>
                <TR >
                    <TD align="left" colspan="2"><?php
						 $query_maxid="SELECT usuario, fechalog_registroitem,detalle_log FROM log_registroitem WHERE idlog_registroitem=".$_GET["id"];
						
						 $maxid= $db->Execute($query_maxid);
						 $totalRows_maxid= $maxid->RecordCount();
						 $row_maxid= $maxid->FetchRow();
						
						 echo $row_maxid["detalle_log"];
                            /*$generador=fopen("logitem.txt",'r');
                            $bufer="";
							$contenido = "";
                            while (!feof($generador)) {
                                $bufer = fgets($generador);
								$contenido .= $bufer;
                                echo $bufer."<br>";
                            }
                            fclose($generador);

                            //$origen="logitem.txt";
                            //$destino="logarchivos/logitem_".$idproximo.".txt";
                            //if(copy($origen, $destino)) {
                                $query_insertalog="insert into log_registroitem
                                values(0,'$usuario',now(),null,'$ip','$contenido')";
                                $insertalog=$db->Execute($query_insertalog) or die(mysql_error());
                            /*}
                            else{
                                echo "<script language='javascript'>
                                alert('Ha ocurrido un error al guardar el archivo de log, comuníquese con el área de tecnología.');
                                </script>";
                            }*/

                            ?>
                    </TD>					
                </TR>
					<tr>
						<td>Por <?php echo $row_maxid["usuario"]; ?> en <?php echo $row_maxid["fechalog_registroitem"]; ?></td>
					</tr>
                <TR >
                    <TD align="center" colspan="2"><INPUT type="button" value="Regresar" onclick="window.location.href='ingresoitemps.php'">
                        <!--<INPUT type="button" value="Descargar Archivo Log" onclick="window.location.href='generaarchivo.php?file=<?php //echo $destino; ?>'">--->
                    </TD>
                </TR>
            </TABLE>
        </form>
    </body>
</html>
