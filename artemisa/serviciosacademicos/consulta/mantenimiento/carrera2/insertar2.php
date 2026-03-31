<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
//require_once('datos_sap.php');
/*$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
    e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna,
    e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
    from estadoconexionexterna e
    where e.codigoestado like '1%'";
    //and dop.codigoconcepto = '151'
   //echo "sdas $query_ordenes<br>";
   $estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
   $totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
   $row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);

    if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
    {
        $login = array (                              // Set login data to R/3
        "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],              // application server host name
        "SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
        "CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
        "USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
        "PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],          // password
        "CODEPAGE"=>"1100");                                                            // codepage

        $rfc = saprfc_open($login);
        if(!$rfc)
        {
            // We have failed to connect to the SAP server
            //echo "<br><br>Failed to connect to the SAP server".saprfc_error();
            //exit(1);
        }
    }*/

$_REQUEST['codigomodalidadacademica'] = $_POST['modalidadacademica'];

//$array_combo_centrobeneficio=valida_centrobeneficio($rfc);

$varguardar = 0;
  if (isset($_POST['grabar'])) {
    if ($_POST['modalidadacademica']== 0){
                  echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Modalidad")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['facultad'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la facultad")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['tipocosto'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Costo ")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['centrobeneficio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Centro de Beneficio ")</script>';
                $varguardar = 1;
                }
       elseif ($_POST['directivo'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Directivo")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['titulo'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Título")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['sucursal'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Sucursal")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['indicadorcobroinscripcioncarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador Cobro de Inscripción")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['indicadorprocesoadmisioncarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador Proceso de Admisión")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['indicadorplanestudio'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador de Plan de Estudio")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['indicadortipocarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador Tipo de Carrera")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['referenciacobromatriculacarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Referencia de Cobro Matrícula")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechainicio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['fechavencimiento'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['nombre'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['codigocorto'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Codigo Corto")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['abreviatura'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Abreviatura")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['centrocosto'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Centro de Costo")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['numerodias'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Número de Días")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['indicadorcarreragrupofechainscripcion'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador de Grupo")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['modalidadacademicasic']== 0){
             echo '<script language="JavaScript">alert("Debe Seleccionar la Modalidad Académica SIC")</script>';
                    $varguardar = 1;
              }
        elseif ($varguardar == 0) {
                if (isset($_REQUEST['codigocarrera'])){

           $query_actualizar = "UPDATE carrera SET codigocortocarrera='".$_POST['codigocorto']."', nombrecortocarrera='".$_POST['nombre']."',  nombrecarrera='".$_POST['nombre']."',codigofacultad='".$_POST['facultad']."', centrocosto='".$_POST['centrocosto']."', codigocentrobeneficio='".$_POST['centrobeneficio']."', codigosucursal='".$_POST['sucursal']."', codigomodalidadacademica='".$_POST['modalidadacademica']."', fechainiciocarrera='".$_POST['fechainicio']."', fechavencimientocarrera='".$_POST['fechavencimiento']."', abreviaturacodigocarrera='".$_POST['abreviatura']."', iddirectivo='".$_POST['directivo']."', codigotitulo='".$_POST['titulo']."', codigotipocosto='".$_POST['tipocosto']."', codigoindicadorcobroinscripcioncarrera='".$_POST['indicadorcobroinscripcioncarrera']."', codigoindicadorprocesoadmisioncarrera='".$_POST['indicadorprocesoadmisioncarrera']."', codigoindicadorplanestudio='".$_POST['indicadorplanestudio']."', codigoindicadortipocarrera='".$_POST['indicadortipocarrera']."', codigoreferenciacobromatriculacarrera='".$_POST['referenciacobromatriculacarrera']."', numerodiaaspirantecarrera='".$_POST['numerodias']."', codigoindicadorcarreragrupofechainscripcion='".$_POST['indicadorcarreragrupofechainscripcion']."', codigomodalidadacademicasic='".$_POST['modalidadacademicasic']."'
            where codigocarrera = '".$_REQUEST['codigocarrera']."'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";

            }
            else {
            $query_guardar = "INSERT INTO carrera (codigocarrera, codigocortocarrera, nombrecortocarrera, nombrecarrera, codigofacultad, centrocosto, codigocentrobeneficio, codigosucursal, codigomodalidadacademica, fechainiciocarrera, fechavencimientocarrera, abreviaturacodigocarrera, iddirectivo, codigotitulo, codigotipocosto, codigoindicadorcobroinscripcioncarrera, codigoindicadorprocesoadmisioncarrera, codigoindicadorplanestudio, codigoindicadortipocarrera, codigoreferenciacobromatriculacarrera, numerodiaaspirantecarrera, codigoindicadorcarreragrupofechainscripcion, codigomodalidadacademicasic) values (0, '{$_POST['codigocorto']}','{$_POST['nombre']}','{$_POST['nombre']}','{$_POST['facultad']}','{$_POST['centrocosto']}','{$_POST['centrobeneficio']}','{$_POST['sucursal']}','{$_POST['modalidadacademica']}','{$_POST['fechainicio']}','{$_POST['fechavencimiento']}','{$_POST['abreviatura']}','{$_POST['directivo']}','{$_POST['titulo']}','{$_POST['tipocosto']}','{$_POST['indicadorcobroinscripcioncarrera']}','{$_POST['indicadorprocesoadmisioncarrera']}','{$_POST['indicadorplanestudio']}','{$_POST['indicadortipocarrera']}','{$_POST['referenciacobromatriculacarrera']}','{$_POST['numerodias']}','{$_POST['indicadorcarreragrupofechainscripcion']}','{$_POST['modalidadacademicasic']}')";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['codigocarrera'] = $db->Insert_ID();
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
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">
         <tr>
           <td bgcolor="#8AB200" colspan="3" valign="center"><img src="../../../../imagenes/noticias_logo.gif" height="71"></td>
         </tr>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO DE CARRERAS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['codigocarrera'])){
            $query_nomcarrera = "select nombrecarrera from carrera where codigocarrera = '".$_REQUEST['codigocarrera']."'";
                $nomcarrera= $db->Execute($query_nomcarrera);
                $totalRows_nomcarrera = $nomcarrera->RecordCount();
                $row_nomcarrera = $nomcarrera->FetchRow();
                echo $row_nomcarrera['nombrecarrera'];
                 }
             ?>
            </label></TD>
         </TR>
    </table>
        <?php


        $query_carrera ="select c.codigocortocarrera,c.nombrecarrera, c.abreviaturacodigocarrera, c.centrocosto, c.numerodiaaspirantecarrera, c.fechainiciocarrera, c.fechavencimientocarrera, c.codigocentrobeneficio, ma.codigomodalidadacademica,  ma.nombremodalidadacademica, f.codigofacultad, f.nombrefacultad, tc.codigotipocosto, tc.nombretipocosto, d.iddirectivo, concat(d.apellidosdirectivo, '', d.nombresdirectivo), t.codigotitulo, t.nombretitulo, s.codigosucursal, s.nombresucursal, ii.codigoindicadorcobroinscripcioncarrera, ii.nombreindicadorcobroinscripcioncarrera, ia.codigoindicadorprocesoadmisioncarrera, ia.nombreindicadorprocesoadmisioncarrera, ip.codigoindicadorplanestudio, ip.nombreindicadorplanestudio, ic.codigoindicadortipocarrera, ic.nombrendicadortipocarrera, rm.codigoreferenciacobromatriculacarrera, rm.nombrereferenciacobromatriculacarrera, ig.codigoindicadorcarreragrupofechainscripcion, ig.nombreindicadorcarreragrupofechainscripcion, ms.codigomodalidadacademicasic, ms.nombremodalidadacademicasic
        from carrera c, modalidadacademica ma, facultad f, tipocosto tc, directivo d, titulo t, sucursal s, indicadorcobroinscripcioncarrera ii, indicadorprocesoadmicioncarrera ia, indicadorplanestudio ip, indicadortipocarrera ic, referenciacobromatriculacarrera rm, indicadorcarreragrupofechainscripcion ig, modalidadacademicasic ms
        where
        c.codigofacultad = f.codigofacultad
        and c.codigotipocosto = tc.codigotipocosto
        and c.iddirectivo = d.iddirectivo
        and c.codigotitulo = t.codigotitulo
        and c.codigosucursal = s.codigosucursal
        and c.codigoindicadorcobroinscripcioncarrera = ii.codigoindicadorcobroinscripcioncarrera
        and c.codigoindicadorprocesoadmisioncarrera = ia.codigoindicadorprocesoadmisioncarrera
        and c.codigoindicadorplanestudio = ip.codigoindicadorplanestudio
        and c.codigoindicadortipocarrera = ic.codigoindicadortipocarrera
        and c.codigoreferenciacobromatriculacarrera = rm.codigoreferenciacobromatriculacarrera
        and c.codigoindicadorcarreragrupofechainscripcion = ig.codigoindicadorcarreragrupofechainscripcion
        and ma.codigomodalidadacademica = c.codigomodalidadacademica
        and ms.codigomodalidadacademicasic = c.codigomodalidadacademicasic
        and c.codigocarrera='".$_REQUEST['codigocarrera']."'";
                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
                $row_carrera = $carrera->FetchRow();

          $query_modalidadacademica ="SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica ";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
        ?>

            <TABLE width="750px"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Modalidad Académica<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="modalidadacademica" id="modalidadacademica" <?php if (!isset($_REQUEST['codigocarrera'])){ ?> onchange="guardar()" <?php } ?>>
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?>
                            <option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                                <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['modalidadacademica']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigomodalidadacademica']==$row_modalidadacademica['codigomodalidadacademica'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
            $query_facultad ="SELECT codigofacultad, nombrefacultad FROM facultad";
                $facultad= $db->Execute($query_facultad);
                $totalRows_facultad = $facultad->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Facultad<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="facultad" id="facultad">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_facultad = $facultad->FetchRow()){?>
                            <option value="<?php echo $row_facultad['codigofacultad'];?>"
                                <?php
                                 if($row_facultad['codigofacultad']==$_POST['facultad']) {
                                echo "Selected";
                                 }
                                 else if($row_carrera['codigofacultad']==$row_facultad['codigofacultad'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_facultad['nombrefacultad'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
            $query_tipocosto ="SELECT codigotipocosto, nombretipocosto FROM tipocosto where codigoestado like '1%'";
                $tipocosto= $db->Execute($query_tipocosto);
                $totalRows_tipocosto = $tipocosto->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Tipo de Costo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="tipocosto" id="tipocosto">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_tipocosto = $tipocosto->FetchRow()){?>
                            <option value="<?php echo $row_tipocosto['codigotipocosto'];?>"
                                <?php
                                 if($row_tipocosto['codigotipocosto']==$_POST['tipocosto']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigotipocosto']==$row_tipocosto['codigotipocosto'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_tipocosto['nombretipocosto'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
    <?php
                $query_centrobeneficio ="SELECT codigocentrobeneficio, concat(codigocentrobeneficio, ' - ' ,nombrecentrobeneficio) as nombrecentrobeneficio FROM centrobeneficio ";
                $centrobeneficio= $db->Execute($query_centrobeneficio);
                $totalRows_centrobeneficio = $centrobeneficio->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Centro de Beneficio<label  id="labelasterisco">*</label>
<table>
<TR>
    <TD>Listado:</TD>
    <TD>
<?php
$forzar = true;
$checkedListado = '';
$checkedManual = '';
if(is_array($array_combo_centrobeneficio) && !isset($_REQUEST['selcentrobeneficio'])){
foreach($array_combo_centrobeneficio as $centrobeneficio) {
    if($row_carrera['codigocentrobeneficio']==$centrobeneficio['valor']) {
        $forzar = false;
        $checkedListado = ' checked="true"';
        $visibleListado = ' style="visibility: visible;"';
        break;
        }
    }
}
$visibleListado = '';
$visibleManual = ' style="visibility: hidden;"';
$desabilitar = ' disabled="true"';
if(!isset($_REQUEST['selcentrobeneficio']) && $row_carrera['codigocentrobeneficio']=='') {
    $checkedListado = ' checked="true"';
    $visibleListado = ' style="visibility: visible;"';
    $forzar = false;
}
else if($_REQUEST['selcentrobeneficio'] == 'listado') {
    $checkedListado = ' checked="true"';
    $visibleListado = ' style="visibility: visible;"';
    $forzar = false;
}
else if($_REQUEST['selcentrobeneficio'] == 'manual') {
    $checkedManual = ' checked="true"';
    $visibleListado = ' style="visibility: hidden;"';
    $visibleManual = ' style="visibility: visible;"';
    $desabilitar = ' disabled="false"';
    $desabilitarFinal = 'document.getElementById("idtextocentro").disabled=false';
}
if($forzar && !isset($_REQUEST['selcentrobeneficio'])) {
    $checkedManual = ' checked="true"';
    $visibleListado = ' style="visibility: hidden;"';
    $visibleManual = ' style="visibility: visible;"';
    $desabilitar = ' disabled="false"';
    $desabilitarFinal = 'document.getElementById("idtextocentro").disabled=false';
}
?>
    <input id="centro1" type="radio" name="selcentrobeneficio" <?php echo $checkedListado; ?> onclick="document.getElementById('textomodalidad').style.visibility = 'hidden'; document.getElementById('listamodalidad').style.visibility = 'visible'; document.getElementById('idtextocentro').disabled=true" value="listado" ></TD>
</TR>
<TR>
    <TD>Manual:</TD>
    <TD><input id="centro2" type="radio" name="selcentrobeneficio" <?php echo $checkedManual; ?> onclick="document.getElementById('listamodalidad').style.visibility = 'hidden'; document.getElementById('textomodalidad').style.visibility = 'visible'; document.getElementById('idtextocentro').disabled=false" value="manual"></TD>
</TR>
</table>

</div>
                    </td>
                    <td id="tdtitulogris">
                         <div id="listamodalidad" align="justify" <?php echo $visibleListado; ?>>
                            <select name="centrobeneficio" id="codigocentrobeneficio">
                            <option value="" selected>
                                Seleccionar
                            </option>
                            <option value="1" <?php if($_POST['centrobeneficio'] == 1) { echo "Selected"; } ?>>
                                No Tiene
                            </option>

                                <?php foreach($array_combo_centrobeneficio as $centrobeneficio) {
                                ?>
                            <option value="<?php echo $centrobeneficio['valor'];?>"
                                <?php
                                 if($centrobeneficio['valor']==$_POST['centrobeneficio']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigocentrobeneficio']==$centrobeneficio['valor'])
                                echo "Selected";
                                ?>>
                                <?php echo $centrobeneficio['etiqueta'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                        <div id="textomodalidad" <?php echo $visibleManual; ?>>
                        <?php  if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['codigocentrobeneficio']==$_POST['centrobeneficio']; ?>
                        <input id="idtextocentro" type="text" name="centrobeneficio" value="<?php echo $row_carrera['codigocentrobeneficio']; ?>" <?php echo $desabilitar; ?>>
                        <?php }
                         else {
                         ?>
                         <input id="idtextocentro" type="text" name="centrobeneficio" value="<?php if ($_POST['centrobeneficio']!=""){ echo $_POST['centrobeneficio']; } ?>" <?php echo $desabilitar; ?>>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php
             $query_directivo ="SELECT iddirectivo, concat(apellidosdirectivo, ' ', nombresdirectivo) as nombre FROM directivo order by apellidosdirectivo";
                $directivo= $db->Execute($query_directivo);
                $totalRows_directivo = $directivo->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Directivo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="directivo" id="directivo">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_directivo = $directivo->FetchRow()){?>
                            <option value="<?php echo $row_directivo['iddirectivo'];?>"
                                <?php
                                 if($row_directivo['iddirectivo']==$_POST['directivo']) {
                                echo "Selected";
                                 }
                                elseif ($row_carrera['iddirectivo']==$row_directivo['iddirectivo']){
                                echo "Selected";
                                }?>>
                                <?php echo $row_directivo['nombre'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_titulo ="SELECT codigotitulo, nombretitulo FROM titulo where '".$fechahoy."' between fechainiciotitulo and fechafintitulo";
                $titulo= $db->Execute($query_titulo);
                $totalRows_titulo = $titulo->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Título<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="titulo" id="titulo">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_titulo = $titulo->FetchRow()){?>
                            <option value="<?php echo $row_titulo['codigotitulo'];?>"
                                <?php
                                 if($row_titulo['codigotitulo']==$_POST['titulo']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigotitulo']==$row_titulo['codigotitulo'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_titulo['nombretitulo'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_sucursal ="SELECT * FROM sucursal";
                $sucursal= $db->Execute($query_sucursal);
                $totalRows_sucursal = $sucursal->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Sucursal<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="sucursal" id="sucursal">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_sucursal = $sucursal->FetchRow()){?>
                            <option value="<?php echo $row_sucursal['codigosucursal'];?>"
                                <?php
                                 if($row_sucursal['codigosucursal']==$_POST['sucursal']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigosucursal']==$row_sucursal['codigosucursal'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_sucursal['nombresucursal'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_indicadorcobroinscripcioncarrera ="SELECT codigoindicadorcobroinscripcioncarrera, nombreindicadorcobroinscripcioncarrera FROM indicadorcobroinscripcioncarrera where codigoestado like '1%'";
                $indicadorcobroinscripcioncarrera= $db->Execute($query_indicadorcobroinscripcioncarrera);
                $totalRows_indicadorcobroinscripcioncarrera = $indicadorcobroinscripcioncarrera->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Cobro Inscripción<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="indicadorcobroinscripcioncarrera" id="indicadorcobroinscripcioncarrera">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_indicadorcobroinscripcioncarrera = $indicadorcobroinscripcioncarrera->FetchRow()){?>
                            <option value="<?php echo $row_indicadorcobroinscripcioncarrera['codigoindicadorcobroinscripcioncarrera'];?>"
                                <?php
                                 if($row_indicadorcobroinscripcioncarrera['codigoindicadorcobroinscripcioncarrera']==$_POST['indicadorcobroinscripcioncarrera']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigoindicadorcobroinscripcioncarrera']==$row_indicadorcobroinscripcioncarrera['codigoindicadorcobroinscripcioncarrera'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_indicadorcobroinscripcioncarrera['nombreindicadorcobroinscripcioncarrera'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
           <?php
                $query_indicadorprocesoadmisioncarrera ="SELECT * FROM indicadorprocesoadmicioncarrera where codigoestado like '1%'";
                $indicadorprocesoadmisioncarrera= $db->Execute($query_indicadorprocesoadmisioncarrera);
                $totalRows_indicadorprocesoadmisioncarrera = $indicadorprocesoadmisioncarrera->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Proceso de Admisión<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="indicadorprocesoadmisioncarrera" id="indicadorprocesoadmisioncarrera">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_indicadorprocesoadmisioncarrera = $indicadorprocesoadmisioncarrera->FetchRow()){?>
                            <option value="<?php echo $row_indicadorprocesoadmisioncarrera['codigoindicadorprocesoadmisioncarrera'];?>"
                                <?php
                                 if($row_indicadorprocesoadmisioncarrera['codigoindicadorprocesoadmisioncarrera']==$_POST['indicadorprocesoadmisioncarrera']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigoindicadorprocesoadmisioncarrera']==$row_indicadorprocesoadmisioncarrera['codigoindicadorprocesoadmisioncarrera'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_indicadorprocesoadmisioncarrera['nombreindicadorprocesoadmisioncarrera'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_indicadorplanestudio ="SELECT * FROM indicadorplanestudio";
                $indicadorplanestudio= $db->Execute($query_indicadorplanestudio);
                $totalRows_indicadorplanestudio = $indicadorplanestudio->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador de Plan de Estudio<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="indicadorplanestudio" id="indicadorplanestudio">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_indicadorplanestudio = $indicadorplanestudio->FetchRow()){?>
                            <option value="<?php echo $row_indicadorplanestudio['codigoindicadorplanestudio'];?>"
                                <?php
                                 if($row_indicadorplanestudio['codigoindicadorplanestudio']==$_POST['indicadorplanestudio']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigoindicadorplanestudio']==$row_indicadorplanestudio['codigoindicadorplanestudio'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_indicadorplanestudio['nombreindicadorplanestudio'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_indicadortipocarrera ="SELECT * FROM indicadortipocarrera where codigoestado like '1%'";
                $indicadortipocarrera= $db->Execute($query_indicadortipocarrera);
                $totalRows_indicadortipocarrera = $indicadortipocarrera->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Tipo de Carrera<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="indicadortipocarrera" id="indicadortipocarrera">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_indicadortipocarrera = $indicadortipocarrera->FetchRow()){?>
                            <option value="<?php echo $row_indicadortipocarrera['codigoindicadortipocarrera'];?>"
                                <?php
                                 if($row_indicadortipocarrera['codigoindicadortipocarrera']==$_POST['indicadortipocarrera']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigoindicadortipocarrera']==$row_indicadortipocarrera['codigoindicadortipocarrera'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_indicadortipocarrera['nombrendicadortipocarrera'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
                $query_referenciacobromatriculacarrera ="SELECT * FROM referenciacobromatriculacarrera";
                $referenciacobromatriculacarrera= $db->Execute($query_referenciacobromatriculacarrera);
                $totalRows_referenciacobromatriculacarrera = $referenciacobromatriculacarrera->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Referencia de Cobro Matrícula<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="referenciacobromatriculacarrera" id="referenciacobromatriculacarrera">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_referenciacobromatriculacarrera = $referenciacobromatriculacarrera->FetchRow()){?>
                            <option value="<?php echo $row_referenciacobromatriculacarrera['codigoreferenciacobromatriculacarrera'];?>"
                                <?php
                                 if($row_referenciacobromatriculacarrera['codigoreferenciacobromatriculacarrera']==$_POST['referenciacobromatriculacarrera']) {
                                echo "Selected";
                                 }
                                else if($row_carrera['codigoreferenciacobromatriculacarrera']==$row_referenciacobromatriculacarrera['codigoreferenciacobromatriculacarrera'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_referenciacobromatriculacarrera['nombrereferenciacobromatriculacarrera'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Fecha de Inicio<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['fechainiciocarrera']==$_POST['fechainicio'];
                        ?>
                        <INPUT type="text" name="fechainicio" id="fechainicio" readonly="true" value="<?php echo $row_carrera['fechainiciocarrera'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainicio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechainicio" id="fechainicio" readonly="true" value="<?php if ($_POST['fechainicio']!=""){ echo $_POST['fechainicio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainicio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php } ?>

                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Fecha de Vencimiento<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['fechavencimientocarrera']==$_POST['fechavencimiento'];
                        ?>
                        <INPUT type="text" name="fechavencimiento" id="fechavencimiento" readonly="true" value="<?php echo $row_carrera['fechavencimientocarrera'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechavencimiento",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechavencimiento" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                          }
                          else {
                           ?>
                          <INPUT type="text" name="fechavencimiento" id="fechavencimiento" readonly="true" value="<?php if ($_POST['fechavencimiento']!=""){ echo $_POST['fechavencimiento']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechavencimiento",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechavencimiento" // ID of the button
                                  }
                                 );
                        </script>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['nombrecarrera']==$_POST['nombre'];?>
                        <INPUT type="text" name="nombre" id="nombre" size="25px" value="<?php echo $row_carrera['nombrecarrera']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombre" id="nombre" value="<?php if ($_POST['nombre']!=""){
                        echo $_POST['nombre']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Codigo Corto<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['codigocortocarrera']==$_POST['codigocorto'];?>
                        <INPUT type="text" name="codigocorto" id="codigocorto" value="<?php echo $row_carrera['codigocortocarrera']; ?>">
                        <?php
                         }
                         else {?>
                            <INPUT type="text" name="codigocorto" id="codigocorto" value="<?php if ($_POST['codigocorto']!=""){ echo $_POST['codigocorto']; } ?>">
                            <?php }
                             ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Abreviatura<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['abreviaturacodigocarrera']==$_POST['abreviatura'];?>
                        <INPUT type="text" name="abreviatura" id="abreviatura" value="<?php echo $row_carrera['abreviaturacodigocarrera']; ?>">
                        <?php
                         }
                         else {?>
                            <INPUT type="text" name="abreviatura" id="abreviatura" value="<?php if ($_POST['abreviatura']!=""){ echo $_POST['abreviatura']; } ?>">
                             <?php }
                             ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Centro de Costo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                         <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['centrocosto']==$_POST['centrocosto'];?>
                        <INPUT type="text" name="centrocosto" id="centrocosto" value="<?php echo $row_carrera['centrocosto']; ?>">
                        <?php
                         }
                         else {?>
                          <INPUT type="text" name="centrocosto" id="centrocosto" value="<?php if ($_POST['centrocosto']!=""){ echo $_POST['centrocosto']; } ?>">
                           <?php }
                             ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Numero Días aspirante<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigocarrera'])){
                        $row_carrera['numerodiaaspirantecarrera']==$_POST['numerodias'];?>
                        <INPUT type="text" name="numerodias" id="numerodias" value="<?php echo $row_carrera['numerodiaaspirantecarrera']; ?>">
                         <?php
                         }
                         else {?>
                            <INPUT type="text" name="numerodias" id="numerodias" value="<?php if ($_POST['numerodias']!=""){ echo $_POST['numerodias']; } ?>">
                            <?php }
                             ?>
                        </div>
                    </td>
                </tr>
            <?php
                $query_indicadorcarreragrupofechainscripcion ="SELECT * FROM indicadorcarreragrupofechainscripcion where codigoestado like '1%' ";
                $indicadorcarreragrupofechainscripcion= $db->Execute($query_indicadorcarreragrupofechainscripcion);
                $totalRows_indicadorcarreragrupofechainscripcion = $indicadorcarreragrupofechainscripcion->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Grupo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="indicadorcarreragrupofechainscripcion" id="indicadorcarreragrupofechainscripcion">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_indicadorcarreragrupofechainscripcion= $indicadorcarreragrupofechainscripcion->FetchRow()){?>
                            <option value="<?php echo $row_indicadorcarreragrupofechainscripcion['codigoindicadorcarreragrupofechainscripcion'];?>"
                                <?php
                                 if($row_indicadorcarreragrupofechainscripcion['codigoindicadorcarreragrupofechainscripcion']==$_POST['indicadorcarreragrupofechainscripcion']) {
                                echo "Selected";
                                 }
                                 else if($row_carrera['codigoindicadorcarreragrupofechainscripcion']==$row_indicadorcarreragrupofechainscripcion['codigoindicadorcarreragrupofechainscripcion'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_indicadorcarreragrupofechainscripcion['nombreindicadorcarreragrupofechainscripcion'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
<?php
                $query_modalidadacademicasic ="SELECT * FROM modalidadacademicasic ";
                $modalidadacademicasic= $db->Execute($query_modalidadacademicasic);
                $totalRows_modalidadacademicasic = $modalidadacademicasic->RecordCount();
            ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Modalidad Académica SIC<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="modalidadacademicasic" id="modalidadacademicasic">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_modalidadacademicasic= $modalidadacademicasic->FetchRow()){?>
                            <option value="<?php echo $row_modalidadacademicasic['codigomodalidadacademicasic'];?>"
                                <?php
                                 if($row_modalidadacademicasic['codigomodalidadacademicasic']==$_POST['modalidadacademicasic']) {
                                echo "Selected";
                                 }
                                 else if($row_carrera['codigomodalidadacademicasic']==$row_modalidadacademicasic['codigomodalidadacademicasic'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_modalidadacademicasic['nombremodalidadacademicasic'];?>
                            </option>
                            <?php }?>
                            </select>
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
                <input type="submit" name="grabar" value="Guardar">
                <?php

                    if (isset($_REQUEST['codigocarrera'])){
                ?>
                <input type="hidden" name="codigocarrera" value="<?php echo $_REQUEST['codigocarrera']; ?>">
                    <?php
                    }
                    ?>
                <?php
                    if (isset($_REQUEST['codigocarrera'])){
                ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='consultarcarrera.php'">
                <INPUT type="button" value="Objetivos Carrera" onClick="window.location.href='../objetivos/lista_objetivos_carrera.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                <?php
                }
                    else {
                ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='menu.php'">
                <?php
                 }
                ?>
                </TD>
              </TR>
        </TABLE>
                <?php
                 $query_jornada ="SELECT jc.idjornadacarrera, jc.nombrejornadacarrera, j.nombrejornada, j.codigojornada   FROM jornadacarrera jc, jornada j where
                 jc.codigojornada=j.codigojornada
                 and  codigocarrera = '".$_REQUEST['codigocarrera']."'";
                 $jornada= $db->Execute($query_jornada);
                 $totalRows_jornada = $jornada->RecordCount();
                ?>
</br></br>
        <TABLE width="30%"  border="1" align="center">
            <TR id="trgris">
                <TD colspan="2" align="center"><label id="labelresaltadogrande">JORNADAS</label></TD>
            </TR>
            <TR id="trgris">
                <TD align="center"><label id="labelresaltado">Jornada </label></TD>
                <TD align="center"><label id="labelresaltado">Nombre Jornada</label></TD>

            </TR>
                <?php while($row_jornada = $jornada->FetchRow()){?>
            <TR>
                <TD align="center"><A id="aparencialink" href="insertarjornada.php?idjornadacarrera=<?php echo $row_jornada['idjornadacarrera']."&codigocarrera=".$_REQUEST['codigocarrera']; ?>"><?php echo $row_jornada['nombrejornada']; ?></A></TD>
                <TD align="center"><?php echo $row_jornada['nombrejornadacarrera']; ?></TD>
            </TR>
            <?php
                 }
            ?>
            <TR align="left">
                    <TD id="tdtitulogris" colspan="4"  align="center">

                    <INPUT type="button" value="Nueva Jornada" onClick="window.location.href='insertarjornada.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                    </TD>
        </TABLE>

</form>
</body>
</html>
<script type="text/javascript">
<?php
if($_REQUEST['selcentrobeneficio'] == 'manual' || $forzar ) {
?>
//alert(document.getElementById("idtextocentro").disabled);
document.getElementById("idtextocentro").disabled=false;
<?php
}
?>
</script>
