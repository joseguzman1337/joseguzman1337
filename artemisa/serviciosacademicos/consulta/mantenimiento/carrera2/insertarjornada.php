<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$varguardar = 0;
  if (isset($_POST['grabar'])) {
    if ($_POST['nombrejornadacarrera']== ""){
                  echo '<script language="JavaScript">alert("Debe Digitar el Nombre de la Jornada")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['codigojornada'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Jornada")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['numerominimocreditosjornadacarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Número Mínimo de Créditos ")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['numeromaximocreditosjornadacarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Número Maximo de Créditos ")</script>';
                $varguardar = 1;
                }
       elseif ($_POST['fechadesdejornadacarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Fecha Inicial de la Carrera")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechahastajornadacarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Fecha Final de la Carrera")</script>';
                $varguardar = 1;
                }
        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idjornadacarrera'])){

                $query_actualizar = "UPDATE jornadacarrera SET nombrejornadacarrera='".$_POST['nombrejornadacarrera']."', codigocarrera='".$_REQUEST['codigocarrera']."',  codigojornada='".$_POST['codigojornada']."', numerominimocreditosjornadacarrera='".$_POST['numerominimocreditosjornadacarrera']."', numeromaximocreditosjornadacarrera='".$_POST['numeromaximocreditosjornadacarrera']."', fechajornadacarrera = '$fechahoy', fechadesdejornadacarrera='".$_POST['fechadesdejornadacarrera']."', fechahastajornadacarrera='".$_POST['fechahastajornadacarrera']."'
                where idjornadacarrera = '".$_REQUEST['idjornadacarrera']."'
                and codigocarrera = '".$_REQUEST['codigocarrera']."'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
                }
                else {
                $query_guardar = "INSERT INTO jornadacarrera (idjornadacarrera, nombrejornadacarrera, codigocarrera, codigojornada, numerominimocreditosjornadacarrera, numeromaximocreditosjornadacarrera, fechajornadacarrera, fechadesdejornadacarrera, fechahastajornadacarrera) values (0, '{$_POST['nombrejornadacarrera']}','{$_REQUEST['codigocarrera']}','{$_POST['codigojornada']}','{$_POST['numerominimocreditosjornadacarrera']}','{$_POST['numeromaximocreditosjornadacarrera']}','{$fechahoy}','{$_POST['fechadesdejornadacarrera']}','{$_POST['fechahastajornadacarrera']}')";
                $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                $_REQUEST['idjornadacarrera'] = $db->Insert_ID();
                echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";

            }
        }
}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>
    <body>
<form name="form1" id="form1"  method="POST">

            <?php
                $query_jornadacarrera = "SELECT jc.nombrejornadacarrera, jc.codigocarrera, jc.codigojornada, jc.numerominimocreditosjornadacarrera, jc.numeromaximocreditosjornadacarrera, jc.fechajornadacarrera, jc.fechadesdejornadacarrera, jc.fechahastajornadacarrera, j.codigojornada, j.nombrejornada FROM jornadacarrera jc, jornada j
                where
                jc.codigojornada=j.codigojornada
                and  idjornadacarrera = '".$_REQUEST['idjornadacarrera']."'";
                $jornadacarrera= $db->Execute($query_jornadacarrera);
                $totalRows_jornadacarrera = $jornadacarrera->RecordCount();
                $row_jornadacarrera = $jornadacarrera->FetchRow();
            ?>
        <TABLE width="750px"  border="1" align="center">
            <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre Jornada<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idjornadacarrera'])){
                        $row_jornadacarrera['nombrejornadacarrera']==$_POST['nombrejornadacarrera'];?>
                        <INPUT type="text" name="nombrejornadacarrera" id="nombrejornadacarrera" value="<?php echo $row_jornadacarrera['nombrejornadacarrera']; ?>">
                        <?php
                         }
                         else {?>
                            <INPUT type="text" name="nombrejornadacarrera" id="nombrejornadacarrera" value="<?php if ($_POST['nombrejornadacarrera']!=""){ echo $_POST['nombrejornadacarrera']; } ?>">
                            <?php }
                             ?>
                        </div>
                    </td>
                </tr>
            <?php
                $query_tipojornada ="SELECT * FROM jornada ";
                $tipojornada= $db->Execute($query_tipojornada);
                $totalRows_tipojornada = $tipojornada->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Jornada<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigojornada" id="codigojornada">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_tipojornada= $tipojornada->FetchRow()){?>
                            <option value="<?php echo $row_tipojornada['codigojornada'];?>"
                                <?php
                                 if($row_tipojornada['codigojornada']==$_POST['codigojornada']) {
                                echo "Selected";
                                 }
                                 else if($row_jornadacarrera['codigojornada']==$row_tipojornada['codigojornada'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_tipojornada['nombrejornada'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Número Mínimo de Créditos*<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idjornadacarrera'])){
                        $row_jornadacarrera['numerominimocreditosjornadacarrera']==$_POST['numerominimocreditosjornadacarrera'];?>
                        <INPUT type="text" name="numerominimocreditosjornadacarrera" id="numerominimocreditosjornadacarrera" value="<?php echo $row_jornadacarrera['numerominimocreditosjornadacarrera']; ?>">
                        <?php
                         }
                         else {?>
                            <INPUT type="text" name="numerominimocreditosjornadacarrera" id="numerominimocreditosjornadacarrera" value="<?php if ($_POST['numerominimocreditosjornadacarrera']!=""){ echo $_POST['numerominimocreditosjornadacarrera']; } ?>">
                            <?php }
                             ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Número Maximo de Créditos<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idjornadacarrera'])){
                        $row_jornadacarrera['numeromaximocreditosjornadacarrera']==$_POST['numeromaximocreditosjornadacarrera'];?>
                        <INPUT type="text" name="numeromaximocreditosjornadacarrera" id="numeromaximocreditosjornadacarrera" value="<?php echo $row_jornadacarrera['numeromaximocreditosjornadacarrera']; ?>">
                        <?php
                         }
                         else {?>
                            <INPUT type="text" name="numeromaximocreditosjornadacarrera" id="numeromaximocreditosjornadacarrera" value="<?php if ($_POST['numeromaximocreditosjornadacarrera']!=""){ echo $_POST['numeromaximocreditosjornadacarrera']; } ?>">
                            <?php }
                             ?>
                        </div>
                    </td>
                </tr>
                 <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Fecha Inicial de la Jornada<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idjornadacarrera'])){
                        $row_jornadacarrera['fechadesdejornadacarrera']==$_POST['fechadesdejornadacarrera'];
                        ?>
                        <INPUT type="text" name="fechadesdejornadacarrera" id="fechadesdejornadacarrera" readonly="true" value="<?php echo $row_jornadacarrera['fechadesdejornadacarrera'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechadesdejornadacarrera",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechadesdejornadacarrera" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechadesdejornadacarrera" id="fechadesdejornadacarrera" readonly="true" value="<?php if ($_POST['fechadesdejornadacarrera']!=""){ echo $_POST['fechadesdejornadacarrera']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechadesdejornadacarrera",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechadesdejornadacarrera" // ID of the button
                                  }
                                 );
                        </script>
                        <?php } ?>

                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Fecha Final de la Jornada<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idjornadacarrera'])){
                        $row_jornadacarrera['fechahastajornadacarrera']==$_POST['fechahastajornadacarrera'];
                        ?>
                        <INPUT type="text" name="fechahastajornadacarrera" id="fechahastajornadacarrera" readonly="true" value="<?php echo $row_jornadacarrera['fechahastajornadacarrera'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechahastajornadacarrera",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechahastajornadacarrera" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechahastajornadacarrera" id="fechahastajornadacarrera" readonly="true" value="<?php if ($_POST['fechahastajornadacarrera']!=""){ echo $_POST['fechahastajornadacarrera']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechahastajornadacarrera",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechahastajornadacarrera" // ID of the button
                                  }
                                 );
                        </script>
                        <?php } ?>

                        </div>
                    </td>
                </tr>
                <script language="javascript">
                function guardar()
                {
                    document.form1.submit();
                }
            </script>
                <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" name="guardar" id="guardar" value="Guardar" onClick="guardar()">
                <input type="hidden" name="grabar" value="grabar">
                <?php

                    if (isset($_REQUEST['idjornadacarrera'])){
                ?>
                <input type="hidden" name="idjornadacarrera" value="<?php echo $_REQUEST['idjornadacarrera']; ?>">
                <input type="hidden" name="codigocarrera" value="<?php echo $_REQUEST['codigocarrera']; ?>">
                    <?php
                    }
                    ?>
                <?php if (isset($_REQUEST['idjornadacarrera'])){?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='insertar2.php?codigocarrera=<?php echo $row_jornadacarrera['codigocarrera']; ?>'">
                <?php }
                else {
                 ?>
                    <INPUT type="button" value="Regresar" onClick="window.location.href='insertar2.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                  <?php } ?>
                </TD>
              </TR>
        </TABLE>

</form>
</body>
</html>