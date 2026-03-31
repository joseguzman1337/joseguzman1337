<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;

        $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica
            from modalidadacademica where codigomodalidadacademica in (200,300)";
        $modalidadacademica= $db->Execute($query_modalidadacademica);
        $totalRows_modalidadacademica = $modalidadacademica->RecordCount();


        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
        where codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
        order by nombrecarrera";
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
      // print_r($_POST);

        $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo order by 1 desc";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();

        $query_planesdeestudio = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio, p.codigoestadoplanestudio
        from planestudio p, carrera c
        where c.codigocarrera = p.codigocarrera
        and c.codigocarrera = '".$_POST['codigocarrera']."'
        and p.codigoestadoplanestudio ='100'";
        $planesdeestudio = $db->Execute($query_planesdeestudio);
        $totalRows_planesdeestudio= $planesdeestudio->RecordCount();

        $query_planesdeestudio2 = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio, p.codigoestadoplanestudio
        from planestudio p, carrera c
        where c.codigocarrera = p.codigocarrera
        and c.codigocarrera = '".$_POST['codigocarrera']."'
        and p.codigoestadoplanestudio ='101'";
        $planesdeestudio2 = $db->Execute($query_planesdeestudio2);
        $totalRows_planesdeestudio2= $planesdeestudio2->RecordCount();
        


?>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
         <script language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}
         </script>

    </head>
 <body>
     <form action=""  name="form1" method="POST">
             <table  border="0" cellpadding="3" cellspacing="3">
                 <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >PERDIDA ASIGNATURA</label>
                     </TD>
                 </TR>
                 <tr>
                      <td id="tdtitulogris" >Seleccione la Modalidad </td>
                      <td>
                          <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="prueba()">
                              <option value="">
                                Seleccionar
                              </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['codigomodalidadacademica']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                              </option><?php }?>
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td  id="tdtitulogris">Seleccione la Carrera </td>
                      <td>
                          <select name="codigocarrera" id="codigocarrera" onchange="prueba()">
                              <option value="">Seleccionar</option>
                                <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                    if ($row_carrera['codigocarrera']==$_POST['codigocarrera']) {
                                    echo "Selected";
                                    $nombrecarrera = $row_carrera['nombrecarrera'];
                                     }?>>
                                    <?php echo $row_carrera['nombrecarrera'];
                                    ?>
                                </option><?php };?>
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td  id="tdtitulogris">Seleccione el Plan de Estudio </td>
                      <td>
                          <select name="idplanestudio" id="idplanestudio">
                              <option value="">Seleccionar</option>
                              <?php
                              if($totalRows_planesdeestudio > 0){
                              ?>
                              <optgroup label="Planes Activos">                                  
                                    <?php while ($row_planesdeestudio = $planesdeestudio->FetchRow()){?><option value="<?php echo $row_planesdeestudio['idplanestudio'] ?>"<?php
                                        if ($row_planesdeestudio['idplanestudio']==$_POST['idplanestudio']) {
                                        echo "Selected";
                                         }?>>
                                        <?php echo $row_planesdeestudio['nombreplanestudio'];
                                        ?>
                                    </option><?php };?>
                              </optgroup>
                              <?php
                              }
                              if($totalRows_planesdeestudio2 > 0){
                              ?>
                              <optgroup label="Planes en Costrucción">                                  
                                    <?php while ($row_planesdeestudio2 = $planesdeestudio2->FetchRow()){?><option value="<?php echo $row_planesdeestudio2['idplanestudio'] ?>"<?php
                                        if ($row_planesdeestudio2['idplanestudio']==$_POST['idplanestudio']) {
                                        echo "Selected";
                                         }?>>
                                        <?php echo $row_planesdeestudio2['nombreplanestudio'];
                                        ?>
                                    </option><?php };?>
                              </optgroup>
                              <?php
                              }
                              ?>
                          </select>
                      </td>
                  </tr>
                  
                  <tr>
                      <td  id="tdtitulogris" >Seleccione el Periodo
                      </td>
                      <td>
                          <select name="periodo" id="periodo">
                              <option value="">
                                  Seleccionar
                              </option>
                              <?php while ($row_periodo = $periodo->FetchRow()) { ?>
                              <option value="<?php echo $row_periodo['codigoperiodo']; ?>"
                                  <?php
                                  if ($row_periodo['codigoperiodo'] == $_REQUEST['periodo']) {
                                  echo "Selected";
                                  } ?>>
                              <?php echo $row_periodo['nombreperiodo']; ?>
                              </option><?php } ?>
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td id="tdtitulogris" ><input type="submit" name="generar" value="Generar Listado"></td>
                      <td id="tdtitulogris" ><input type="submit" name="Excel" id="Excel" value="Generar Excel"></td>
                  </tr>                  
              </table>
         <?php
         if(isset($_REQUEST['generar'])){
             if(isset($_POST['codigomodalidadacademica']) && $_POST['codigomodalidadacademica']==''){
                    echo '<script language="JavaScript">alert("Debe Seleccionar la modalidad academica.")</script>';
                    $varguardar = 1;
             }
             elseif(isset($_POST['codigocarrera']) && $_POST['codigocarrera']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar la carrera")</script>';
                 $varguardar = 1;
             }
             elseif(isset($_POST['idplanestudio']) && $_POST['idplanestudio']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el Plan de Estudio")</script>';
                 $varguardar = 1;
             }
             elseif(isset($_POST['periodo']) && $_POST['periodo']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el periodo.")</script>';
                 $varguardar = 1;
             }
             elseif($varguardar == 0) {

                 echo "<script language='javascript'>
                 window.location.href='listadoasignaturas.php?codigocarrera=".$_POST['codigocarrera']."&idplanestudio=".$_POST['idplanestudio']."&codigoperiodo=".$_POST['periodo']."';
                </script>";
                 print_r($_POST);
            // require('carreras.php');

             }
         }else if(isset($_REQUEST['Excel'])){
            if(isset($_POST['codigomodalidadacademica']) && $_POST['codigomodalidadacademica']==''){
                    echo '<script language="JavaScript">alert("Debe Seleccionar la modalidad academica.")</script>';
                    $varguardar = 1;
             }
             elseif(isset($_POST['codigocarrera']) && $_POST['codigocarrera']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar la carrera")</script>';
                 $varguardar = 1;
             }
             elseif(isset($_POST['idplanestudio']) && $_POST['idplanestudio']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el Plan de Estudio")</script>';
                 $varguardar = 1;
             }
             elseif(isset($_POST['periodo']) && $_POST['periodo']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el periodo.")</script>';
                 $varguardar = 1;
             }
             else if($varguardar == 0) {
                 
                  echo "<script language='javascript'>
                 
                 window.location.href='listadoasignaturas_antiguo.php?codigocarrera=".$_POST['codigocarrera']."&idplanestudio=".$_POST['idplanestudio']."&codigoperiodo=".$_POST['periodo']."&exportar=1';
                </script>";
                 print_r($_POST);
            // require('carreras.php');

             }
         }
         ?>
   </form>
  </body>
</html>
