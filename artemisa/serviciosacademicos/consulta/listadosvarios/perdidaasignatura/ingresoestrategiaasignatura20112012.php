<?php
session_start();

if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";

header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");

exit();
}

$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;
$usuario=$_SESSION['MM_Username'];
    $query_documentod = "SELECT numerodocumento, codigorol
    FROM usuario
    WHERE usuario = '$usuario'";
    $documentod= $db->Execute($query_documentod);
    $totalRows_documentod= $documentod->RecordCount();
    $row_documentod = $documentod->FetchRow();
    $numerodocumento=$row_documentod['numerodocumento'];
    
    $codigoperiodo=$_SESSION['codigoperiodosesion'];

   /* echo "<pre>";
print_r($_SESSION);
exit();*/
        

        $query_materias= "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo,
        g.codigomateria, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
	FROM grupo g, materia m
	where g.codigomateria = m.codigomateria
	and g.codigoestadogrupo like '1%'
	and g.numerodocumento = '$numerodocumento'
	and g.codigoperiodo = '$codigoperiodo'
	order by m.nombremateria, g.idgrupo";
        $materias= $db->Execute($query_materias);
        $totalRows_materias= $materias->RecordCount();
        $row_materias= $materias->FetchRow();
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
             <table  border="1" cellpadding="3" cellspacing="3">
                 <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >ESTRATEGIAS PÉRDIDA ASIGNATURAS</label>
                     </TD>
                 </TR>
                  <tr>
                      <td id="tdtitulogris" colspan="2">Seleccione el Corte: </td>
                      <td colspan="2" id="tdtitulogris"><select name="corte" onchange="prueba()">
                              <option value="">Seleccionar</option>
                            <?php
                            $corte = 1;
                            while ($corte <= 5) :
                            ?>
                                  <option value="<?php echo $corte ?>"
                                      <?php if ($corte==$_POST['corte']) {
                                    echo "Selected";
                                     } ?>><?php if($corte!=5){ echo $corte; } else{ echo "Definitiva"; } ?></option>
                            <?php
                                    $corte++;
                            endwhile;
                            ?>
                                  
                            </select>
                      </td>
                  </tr>
                  <tr>
                      <td  id="tdtitulogris" colspan="4">Seleccione la Asignatura que va a consultar o a ingresar la estrategia.
                      </td>
                  </tr>
                  <tr align="center">
                      <td id="tdtitulogris" >MATERIA</td>
                      <td id="tdtitulogris">CODIGOMATERIA</td>
                      <td id="tdtitulogris">GRUPO</td>
                      <td id="tdtitulogris">IDGRUPO</td>
                  </tr>
                  
                      <?php
                      do{
                      ?>
                  <tr>
                      <td><a href="guardaestrategiaasignatura.php?codigomateria=<?php echo $row_materias['codigomateria']; ?>&idgrupo=<?php echo $row_materias['idgrupo']; ?>&corte=<?php echo $_POST['corte']; ?>" ><?php echo $row_materias['nombremateria']; ?></a>
                      </td>
                      <td><?php echo $row_materias['codigomateria']; ?>
                      </td>
                      <td><?php echo $row_materias['nombregrupo']; ?>
                      </td>
                      <td><?php echo $row_materias['idgrupo']; ?>
                      </td>
                  </tr>
                      <?php } while ($row_materias= $materias->FetchRow()) ?> 
              </table>         
   </form>
  </body>
</html>
