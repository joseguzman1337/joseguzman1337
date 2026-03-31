<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;


        $query_periodo = "SELECT codigocicloelectivoPS, nombrecicloelectivoPS from cicloelectivoPS order by 1 desc";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();

        


?>
<html>
    <head>

        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}
         </SCRIPT>

    </head>
 <body>
     <form action=""  name="form1" method="POST">
             <table  border="0" cellpadding="3" cellspacing="3">
                 <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >Reporte PS Credito y Cartera</label>
                     </TD>
                 </TR>
                 
                  
                  
                  <tr>
                      <td  id="tdtitulogris" >Seleccione el Periodo
                      </td>
                      <td>
                          <select name="periodo" id="periodo">
                              <option value="">
                                  Seleccionar
                              </option>
                              <?php while ($row_periodo = $periodo->FetchRow()) { ?>
                              <option value="<?php echo $row_periodo['codigocicloelectivoPS']; ?>"
                                  <?php
                                  if ($row_periodo['codigocicloelectivoPS'] == $_REQUEST['periodo']) {
                                  echo "Selected";
                                  } ?>>
                              <?php echo $row_periodo['nombrecicloelectivoPS']; ?>
                              </option><?php } ?>
                          </select>
                      </td>
                  </tr>
                  <TR>
                      <TD  id="tdtitulogris" colspan="2"><input type="submit" name="generar" value="Generar Reporte"></TD>
                  </TR>                  
              </table>
         <?php
         if(isset($_REQUEST['generar'])){
              if(isset($_POST['periodo']) && $_POST['periodo']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el Ciclo Electivo.")</script>';
                 $varguardar = 1;
             }
             elseif($varguardar == 0) {

                 echo "<script language='javascript'>
                 window.location.href='generar_reportePS.php?codigoperiodo=".$_POST['periodo']."';
                </script>";
                 //print_r($_POST);
            // require('carreras.php');

             }
         }
         ?>
   </form>
  </body>
</html>
