<?php

session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;
$codigoperiodo=$_SESSION['codigoperiodosesion'];
$codigomateria= $_REQUEST['codigomateria'];
$idgrupo = $_REQUEST['idgrupo'];
$corte= $_REQUEST['corte'];

        $query_nombregr="SELECT m.nombremateria, g.nombregrupo
        from materia m, grupo g
        where 
        g.codigomateria=m.codigomateria
        and m.codigomateria='$codigomateria'
        and g.idgrupo='$idgrupo'";
        $nombregr= $db->Execute($query_nombregr);
        $totalRows_nombregr= $nombregr->RecordCount();
        $row_nombregr= $nombregr->FetchRow();
       //print_r($row_nombregr);

       

        $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo where codigoperiodo='$codigoperiodo'";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();
        $row_periodo= $periodo->FetchRow();

        $query_estrategiaasig="SELECT * FROM estrategiaasignatura
        where codigomateria='$codigomateria'
        and idgrupo='$idgrupo'
        and numerocorte='$corte'
        and codigoperiodo='$codigoperiodo'
        and codigoestado like '1%'";
        $estrategiaasig= $db->Execute($query_estrategiaasig);
        $totalRows_estrategiaasig= $estrategiaasig->RecordCount();
        $row_estrategiaasig= $estrategiaasig->FetchRow();
?>
<html>
    <head>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

    </head>
 <body>
     <form action=""  name="form1" method="POST">
                <table  border="0" cellpadding="3" cellspacing="3">
                    <TR>
                        <TD id="tdtitulogris" align="center" colspan="2">
                         <label id="labelresaltadogrande" >ESTRATEGIAS PÉRDIDA ASIGNATURAS
                         </label>
                     </TD>
                    </TR>
                    <TR>
                        <TD id="tdtitulogris" align="left" colspan="2">
                         <?php echo strtoupper($row_periodo['nombreperiodo']); ?>
                     </TD>
                    </TR>
                    <tr>
                        <TD id="tdtitulogris" align="left" colspan="2">
                         MATERIA: <?php echo $row_nombregr['nombremateria']; ?>
                     </TD>
                    </tr>
                    <tr>
                        <TD id="tdtitulogris" align="left" colspan="2">
                         GRUPO: <?php echo $row_nombregr['nombregrupo']; ?>
                     </TD>
                    </tr>                    
                    <TR>
                        <TD id="tdtitulogris" align="left" colspan="2" >
                         <?php if($corte!=5){ echo "CORTE ".$corte; }else{ echo "CORTE DEFINITIVO"; } ?>
                     </TD>
                    </TR>
                     <TR>
                         <TD id="tdtitulogris" align="center" >Estrategia:</TD>
                         <td align="left" >
                            <TEXTAREA name=estrategia cols="35" rows="3" ><?php if($row_estrategiaasig['estrategiaasignatura']!=""){
                            echo $row_estrategiaasig['estrategiaasignatura']; }
                            else { echo $_POST['estrategia']; }
                            ?></TEXTAREA>
                         </td>
                     </TR>                     
                     <TR>
                         <TD  id="tdtitulogris" colspan="2" align="center"><input type="submit" name="almacenar" value="Guardar Modificar">
                          <input type="button" name="Regresar" value="Regresar" onclick="window.location.href='ingresoestrategiaasignatura.php'">
                      <?php if($totalRows_estrategiaasig!=""){ ?>
                          <input type="submit" name="anular" value="Anular">
                          <?php } ?>
                      </TD>
                  </TR>
                   <input type="hidden" name="estrategiaasig" value="<?php echo $row_estrategiaasig['idestrategiaasignatura']; ?>">
                   <input type="hidden" name="codigomateria" value="<?php echo $codigomateria; ?>">
                   <input type="hidden" name="idgrupo" value="<?php echo $idgrupo; ?>">
                   <input type="hidden" name="codigoperiodo" value="<?php echo $codigoperiodo; ?>">
                   <input type="hidden" name="corte" value="<?php echo $corte; ?>">
                </table>

         <?php
         if(isset($_REQUEST['almacenar'])){
             if(isset($_POST['estrategia']) && $_POST['estrategia']==''){
                 echo '<script language="JavaScript">alert("Debe Digitar la Estrategia Semestral.")</script>';
                 $varguardar = 1;
             }             
             elseif($varguardar == 0) {
                if($_POST['estrategiaasig']==""){
                    $query_insertaestrategia = "INSERT INTO estrategiaasignatura (idestrategiaasignatura, idgrupo,
                    codigomateria, numerocorte, estrategiaasignatura, codigoperiodo, fechaestrategiaasignatura, codigoestado)
                    values (0,'".$_POST['idgrupo']."','".$_POST['codigomateria']."','".$_POST['corte']."','".$_POST['estrategia']."',
                    '".$_POST['codigoperiodo']."','$fechahoy', '100')";
                    $insertaestrategia = $db->Execute ($query_insertaestrategia);
                    echo '<script language="JavaScript">alert("Se ha guardado la información correctamente.");
                        window.location.href="ingresoestrategiaasignatura.php"</script>';
                }
                else{
                    $query_actualizar = "UPDATE estrategiaasignatura SET estrategiaasignatura = '".$_POST['estrategia']."'
                    where idestrategiaasignatura = '".$_POST['estrategiaasig']."'";
                    $actualizar = $db->Execute ($query_actualizar);
                     echo '<script language="JavaScript">alert("Se ha actualizado la información correctamente.");
                        window.location.href="ingresoestrategiaasignatura.php"</script>';
                }
             }
         }
         if(isset($_REQUEST['anular'])){
             $query_anular= "UPDATE estrategiaasignatura SET codigoestado= '200'
                    where idestrategiaasignatura = '".$_POST['estrategiaasig']."'";
                    $anular= $db->Execute ($query_anular);
                     echo '<script language="JavaScript">alert("Ha Anulado las estrategias y observaciones del periodo.");
                        window.location.href="ingresoestrategiaasignatura.php"</script>';
         }
         ?>
</form>
  </body>
</html>

