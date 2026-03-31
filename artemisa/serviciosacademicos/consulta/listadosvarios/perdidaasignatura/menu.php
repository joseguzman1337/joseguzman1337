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


if($_SESSION["rol"]==2){
	//para los docentes solo la carrera
		  $query_carrera='SELECT 
                                
                                                c.nombrecarrera,
                                                c.codigocarrera
                                                                                                
                                                FROM 
                                                
                                                grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                                				INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
                                                
                                                WHERE
                                                c.codigomodalidadacademica="'.$_POST['codigomodalidadacademica'].'" AND 
                                                g.codigoperiodo="'.$_SESSION['codigoperiodosesion'].'"
                                                AND
                                                g.numerodocumento="'.$_SESSION['numerodocumento'].'"
                                                
                                                GROUP BY c.codigocarrera
                                                
                                                UNION

SELECT 

                                        c.nombrecarrera,
                                        c.codigocarrera
                                        
                                        FROM 
                                        
                                        Obs_AsignarCarrera  a INNER JOIN carrera c ON c.codigocarrera=a.id_Carrera 
                                        											INNER JOIN docente d ON d.iddocente=a.id_Docente
                                        
                                        WHERE
                                        c.codigomodalidadacademica="'.$_POST['codigomodalidadacademica'].'" AND 
                                        d.numerodocumento="'.$_SESSION['numerodocumento'].'"
                                        AND
                                        a.codigoestado=100
                                        AND
                                        a.codigoperiodo<="'.$_SESSION['codigoperiodosesion'].'" 
										AND
										(a.CodigoPeriodoFinal>="'.$_SESSION['codigoperiodosesion'].'" OR a.CodigoPeriodoFinal IS NULL)

GROUP BY  c.codigocarrera';
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
} else {
             
        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
        where codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
        order by nombrecarrera";
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();           

}
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
                 
                 window.location.href='listadoasignaturas.php?codigocarrera=".$_POST['codigocarrera']."&idplanestudio=".$_POST['idplanestudio']."&codigoperiodo=".$_POST['periodo']."&exportar=1';
                </script>";
                 print_r($_POST);
            // require('carreras.php');

             }
         }
         ?>
   </form>
  </body>
</html>
