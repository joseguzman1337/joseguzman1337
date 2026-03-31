<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("funcionesreclamos.php");
$varguardar = 0;
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
?>
<html>
    <head>
        <title>EL Bosque Te Escucha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <SCRIPT language="JavaScript" type="text/javascript">

function contar(form,form1) {
  n = 0;
  if(form1!=''){
	n = document.forms[form][form1].value.length;
  }
  t = 3000;
  if (n > t) {
    document.forms[form][form1].value = document.forms[form][form1].value.substring(0, t);
  }
  else {
    document.forms[form]['result'].value = t-n;
  }
}

function prueba()
{

//document.form1.tipodoc.disabled=false;
    document.form1.submit();
}

function confirmar() {
        if(confirm('¿Está seguro de Hacer la Solicitud?')) {
            document.getElementById('guardar').value='ok';
            document.form1.submit();
        }
    }



function valida_envia(){

document.form1.enviar.value="1";
alert("!!Gracias!! La Solicitud se ha Enviado Correctamente")
document.form1.enviar.value="1";
document.getElementById('tipodoc').disabled = false;
document.form1.submit();
window.location.href='index.php';
}
function generabasicos(){
  if(document.form1.datosbasicos.checked == true){
      //alert ("Hola");
    datosusuario.style.display ='';
  }
  else{
    datosusuario.style.display ='none';
  }
}


</script>
    </head>
    <body>
<?php

if(existePersona($_REQUEST['idpersonaquejareclamo'])){
    $dataPersona = obtenerPersona($_REQUEST['idpersonaquejareclamo']);
}

if (isset($_POST['guardar']) && $_POST['guardar'] != '') {
//echo $_REQUEST['datosbasicos'];
    /*if ($_POST['nombres'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar su Nombre")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['apellidos'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar su Apellido")</script>';
            $varguardar = 1;
    }
    elseif (!ereg("^([a-zA-Z0-9\._]+)\@([a-zA-Z0-9\.-]+)\.([a-zA-Z]{2,4})",$_POST['email'])) {
            echo '<script language="JavaScript"> alert("Debe Digitar una Dirección de E-mail o hacerlo de forma Correcta")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['email'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar E-mail")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['telefono'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar Número Telefónico")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['tipo_usuario'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Usuario")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['codigomodalidadacademica'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Área a la que Pertenece")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['codigocarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el programa o dependencia")</script>';
            $varguardar = 1;
    }
     * este pedazo comentado es la validacion de los datos basicos de usuario
     */
    if ($_POST['tipo_asunto'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Requerimiento")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['codigomodalidad'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Área Destino")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['codigocarrera2'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Programa o Dependencia Destino")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['tipo_aspecto'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Aspecto a Analizar")</script>';
            $varguardar = 1;
    }
    elseif ($_POST['comentario'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar un Comentario")</script>';
            $varguardar = 1;
    }
    elseif ($varguardar == 0) {
        if(!existePersona($_REQUEST['idpersonaquejareclamo'])){

            if($_REQUEST['datosbasicos']=='on'){
                if($_REQUEST['codigocarrera']==''){
                    $_REQUEST['codigocarrera']=222;
                }
                $query_insertarpersonaquejareclamo ="INSERT INTO personaquejareclamo (idpersonaquejareclamo, codigousuarioquejareclamo, nombrespersonaquejareclamo, apellidospersonaquejareclamo, tipodocumento, numerodocumentopersonaquejareclamo, emailpersonaquejareclamo, iddependenciaquejareclamo, telefonopersonaquejareclamo) values (0, '{$_REQUEST['tipo_usuario']}','{$_REQUEST['nombres']}','{$_REQUEST['apellidos']}',
                '{$_REQUEST['tipodoc']}','{$_REQUEST['documento']}','{$_REQUEST['email']}','{$_REQUEST['codigocarrera']}','{$_REQUEST['telefono']}')";
                $insertarpersonaquejareclamo = $db->Execute ($query_insertarpersonaquejareclamo) or die("$query_insertarpersonaquejareclamo".mysql_error());
                $idpersonaquejareclamo = $db->Insert_ID();

                $query_insertarsolicitudquejareclamo = "INSERT INTO solicitudquejareclamo (idsolicitudquejareclamo, idpersonaquejareclamo, codigotipoasuntoquejareclamo, iddependenciaquejareclamo, codigoaspectotipoasuntoquejareclamo, comentariosolicitudquejareclamo, fechasolicitudquejareclamo, codigoestadoquejareclamo)
                values (0,'$idpersonaquejareclamo', '{$_REQUEST['tipo_asunto']}','{$_REQUEST['codigocarrera2']}','{$_REQUEST['tipo_aspecto']}','{$_REQUEST['comentario']}', now(), '100')";
                $insertarsolicitudquejareclamo = $db->Execute ($query_insertarsolicitudquejareclamo);
                $idsolicitudquejareclamo = $db->Insert_ID();

                $query_generarestado = "INSERT INTO descripcionsolicitudquejareclamo (iddescripcionsolicitudquejareclamo,
                idsolicitudquejareclamo, descripcionsolicitudquejareclamo, estadoorigen, estadodestino,
                fechadescripcionsolicitudquejareclamo)
                values (0,'$idsolicitudquejareclamo','{$_REQUEST['comentario']}',
                '100', '100', now())";
                $generarestado = $db->Execute ($query_generarestado) or die("$query_generarestado".mysql_error());

                echo "<script language='javascript'>
                alert('Para Hacer seguimiento a su sugerencia por favor recuerde este número.  $idsolicitudquejareclamo.\\n!!Gracias!! La Sugerencia se ha Enviado Correctamente');    window.location.href='listadoestado.php?idpersonaquejareclamo=".$idpersonaquejareclamo."';
                </script>";
            }
            else{
                $query_insertarpersonaquejareclamo ="INSERT INTO personaquejareclamo (idpersonaquejareclamo, codigousuarioquejareclamo, nombrespersonaquejareclamo, apellidospersonaquejareclamo, tipodocumento, numerodocumentopersonaquejareclamo, emailpersonaquejareclamo, iddependenciaquejareclamo, telefonopersonaquejareclamo)
                values (0, 800, ' ', ' ', ' ', ' ', ' ', 222, ' ')";
                $insertarpersonaquejareclamo = $db->Execute ($query_insertarpersonaquejareclamo) or die("$query_insertarpersonaquejareclamo".mysql_error());
                $idpersonaquejareclamo = $db->Insert_ID();

                $query_insertarsolicitudquejareclamo = "INSERT INTO solicitudquejareclamo (idsolicitudquejareclamo, idpersonaquejareclamo, codigotipoasuntoquejareclamo, iddependenciaquejareclamo, codigoaspectotipoasuntoquejareclamo, comentariosolicitudquejareclamo, fechasolicitudquejareclamo, codigoestadoquejareclamo)
                values (0,'$idpersonaquejareclamo', '{$_REQUEST['tipo_asunto']}','{$_REQUEST['codigocarrera2']}','{$_REQUEST['tipo_aspecto']}','{$_REQUEST['comentario']}', now(), '100')";
                $insertarsolicitudquejareclamo = $db->Execute ($query_insertarsolicitudquejareclamo);
                $idsolicitudquejareclamo = $db->Insert_ID();

                $query_generarestado = "INSERT INTO descripcionsolicitudquejareclamo (iddescripcionsolicitudquejareclamo,
                idsolicitudquejareclamo, descripcionsolicitudquejareclamo, estadoorigen, estadodestino,
                fechadescripcionsolicitudquejareclamo)
                values (0,'$idsolicitudquejareclamo','{$_REQUEST['comentario']}',
                '100', '100', now())";
                $generarestado = $db->Execute ($query_generarestado) or die("$query_generarestado".mysql_error());

                echo "<script language='javascript'>
                alert('Para Hacer seguimiento a su sugerencia por favor recuerde este número.  $idsolicitudquejareclamo.\\n!!Gracias!! La Sugerencia se ha Enviado Correctamente');    window.location.href='listadoestado.php?idpersonaquejareclamo=".$idpersonaquejareclamo."';
                </script>";
            }

        }
        else {
            /*$query_idpersona="select idpersonaquejareclamo from personaquejareclamo where idpersonaquejareclamo = '".$_REQUEST['idpersonaquejareclamo']."'";
            $resultpersona=$db->Execute ($query_idpersona);
            $rowpersona=$resultpersona->FetchRow();*/
            $query_actualizar = "UPDATE personaquejareclamo SET idpersonaquejareclamo = '".$_REQUEST ['idpersonaquejareclamo']."', codigousuarioquejareclamo='".$_REQUEST['tipo_usuario']."', nombrespersonaquejareclamo='".$_REQUEST['nombres']."', apellidospersonaquejareclamo='".$_REQUEST['apellidos']."', tipodocumento='".$_REQUEST['tipodoc']."', numerodocumentopersonaquejareclamo='".$_REQUEST['documento']."', emailpersonaquejareclamo='".$_REQUEST['email']."', iddependenciaquejareclamo='".$_REQUEST['codigocarrera']."',
            telefonopersonaquejareclamo = '".$_REQUEST['telefono']."'
            where idpersonaquejareclamo = '".$_REQUEST['idpersonaquejareclamo']."'";
            $actualizar = $db->Execute ($query_actualizar);

            $query_insertarsolicitudquejareclamo = "INSERT INTO solicitudquejareclamo (idsolicitudquejareclamo, idpersonaquejareclamo, codigotipoasuntoquejareclamo, iddependenciaquejareclamo, codigoaspectotipoasuntoquejareclamo, comentariosolicitudquejareclamo, fechasolicitudquejareclamo, codigoestadoquejareclamo)
                values (0,'".$_REQUEST ['idpersonaquejareclamo']."','{$_REQUEST['tipo_asunto']}', '{$_REQUEST['codigocarrera2']}', '{$_REQUEST['tipo_aspecto']}','{$_REQUEST['comentario']}', now(), '100')";
            $insertarsolicitudquejareclamo = $db->Execute ($query_insertarsolicitudquejareclamo);
            echo "<script language='javascript'>
            alert('!!Gracias!! La Solicitud se ha Enviado Correctamente');    window.location.href='listadoestado.php?idpersonaquejareclamo=".$_REQUEST['idpersonaquejareclamo']."';
          </script>";
        }
    }
}

//print_r($_POST);
?>
        <form name="form1" id="form1"  method="POST">
            <table  border="0" align="center" cellpadding="3" cellspacing="3">
                <tr>
                    <td bgcolor="#8AB200" valign="center"><img src="../../../imagenes/logo_quejas.gif" height="71"></td>
                </tr>
            </table>
            <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <tr align="left" id="trgris">
                    <td colspan="2" style="text-align:justify;">
                       <p>
                         <label id="labelresaltado"> Este formato le permitirá a usted expresar sus felicitaciones, sugerencias, ideas, reclamos, peticiones y oportunidades de mejora  sobre el servicio suministrado por la Universidad.</label>
                        </p>
                    </td>
                </tr>
                <tr align="left" id="trgris">
                    <td colspan="2" style="text-align:justify;">
                        <p>
                            <label id="labelresaltado">A. DATOS BASICOS</label><BR> Si usted desea hacer sus comentarios ingresando sus datos personales, use la casilla correspondiente. Si desea conservar el anonimato, prosiga con el diligenciamiento de este formato.<BR>
                            También puede comunicarnos sus observaciones llamando al teléfono 6489000 extensión  170 <br><br>
                        </p>
                        <INPUT type="checkbox" name="datosbasicos" onclick="generabasicos()" <?php if($_POST['datosbasicos']=='on') { ?>checked="true" <?php } ?> > &nbsp; <label id="labelresaltado">Registrar Datos Personales</label>
                        <p>
                            Diligencie a continuación la siguiente información. (Los campos con * son obligatorios)
                        </p>
                    </td>                    
                </tr>
                <tr >
                    <td colspan="2">
                        <div  id="datosusuario" <?php if(!$_POST['datosbasicos']=='on') { ?>style="display: none " <?php } ?>>
                            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                                <tr align="left" id="trgris">
                                    <td colspan="2">
                                        <p>
                                            <label id="labelresaltado">DATOS BASICOS DE USUARIO:</label>
                                        </p>
                                    </td>
                                </tr>
                                <tr align="left" >
                                    <td >
                                        Nombres
                                    </td>
                                    <td>
                                        <input name="nombres" type="text" id="nombres" value="<?php
                                            if($dataPersona['nombrespersonaquejareclamo'] != "")
                                                echo $dataPersona['nombrespersonaquejareclamo'];
                                            else
                                                echo $_REQUEST["nombres"]; ?>" size="18">
                                    </td>
                                </tr>
                                <tr align="left" >
                                    <td >
                                        Apellidos
                                    </td>
                                    <td>
                                        <INPUT name="apellidos" type="text" id="apellidos" value="<?php
                                            if($dataPersona['apellidospersonaquejareclamo'] != "")
                                                echo $dataPersona['apellidospersonaquejareclamo'];
                                            else
                                                echo $_REQUEST["apellidos"]; ?>" size="18">
                                    </td>
                                </tr>
                                <?php
                                $query_tipodoc = "select * from documento  where tipodocumento not in (07, 08, 09, 10)";
                                $tipodoc = $db->Execute($query_tipodoc);
                                $totalRows_tipodoc = $tipodoc->RecordCount();
                                ?>
                                <tr align="left" >
                                    <TD >
                                        Tipo de Documento
                                    </TD>
                                    <TD>
                                        <select name="tipodoc" id="tipodoc" >
                                    <?php while($row_tipodoc = $tipodoc->FetchRow())
                                            {
                                     ?>
                                            <option value="<?php echo $row_tipodoc['tipodocumento']?>"
                                            <?php
                                            if($dataPersona['tipodocumento'] == $row_tipodoc['tipodocumento']){
                                                echo "Selected";
                                            }
                                            else if ($row_tipodoc['tipodocumento']==$_REQUEST['tipodoc']) {
                                                echo "Selected";
                                            }?>>
                                            <?php echo $row_tipodoc['nombredocumento']; ?>
                                                    </option>
                                    <?php
                                    }
                                    ?>
                                        </select>
                                    </TD>
                                </tr>
                                <tr align="left" >
                                    <td >
                                        Número del Documento
                                    </td>
                                    <td>
                                        <input name="documento" type="text" id="documento" value="<?php
                                            if($dataPersona['numerodocumentopersonaquejareclamo'] != "")
                                                echo $dataPersona['numerodocumentopersonaquejareclamo'];
                                            else
                                                echo $_REQUEST["documento"]; ?>" size="18">
                                    </td>
                                </tr>
                                <tr align="left" >
                                    <td >
                                        E-mail
                                    </td>
                                    <td>
                                        <input name="email" type="text" id="email"
                                        value="<?php
                                            if($dataPersona['emailpersonaquejareclamo'] != "")
                                                echo $dataPersona['emailpersonaquejareclamo'];
                                            else
                                                echo $_REQUEST["email"]; ?>" size="18">
                                    </td>
                                </tr>
                                <tr align="left" >
                                    <td >
                                        Télefono
                                    </td>
                                    <td>
                                        <input name="telefono" type="text" id="telefono"
                                        value="<?php
                                            if($dataPersona['emailpersonaquejareclamo'] != "")
                                                echo $dataPersona['emailpersonaquejareclamo'];
                                            else
                                                echo $_REQUEST["telefono"]; ?>" size="18">
                                    </td>
                                </tr>
                                <?php
                                $query_tipo_usuario ="select * from usuarioquejareclamo where codigoestado like '1%' ORDER BY  nombreusuarioquejareclamo";
                                $tipo_usuario = $db->Execute ($query_tipo_usuario);
                                $total_Rows_tipo_usuario = $tipo_usuario->RecordCount();
                                ?>
                                <tr align="left" >
                                    <TD >
                                        Tipo de Usuario
                                    </TD>
                                    <TD align="left" >
                                        <select name="tipo_usuario" onchange="prueba()">
                                            <option value="">
                                                    Seleccionar
                                            </option>
                                            <?php while ($row_tipo_usuario = $tipo_usuario->FetchRow())
                                                    { ?>
                                                        <option value="<?php echo $row_tipo_usuario['codigousuarioquejareclamo']?>"
                                                        <?php if($dataPersona['codigousuarioquejareclamo'] == $row_tipo_usuario['codigousuarioquejareclamo']){echo "Selected";} else if ($row_tipo_usuario['codigousuarioquejareclamo']==$_REQUEST['tipo_usuario']) {echo "Selected";}?>>
                                                        <?php echo $row_tipo_usuario['nombreusuarioquejareclamo'];
                                                        ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                        </select>
                                    </TD>
                                </tr>
                                <?php
                                $query_modalidadacademica = "SELECT codigoareaquejareclamo, nombreareaquejareclamo from areaquejareclamo where codigoareaquejareclamo not in (700, 800, 100)";
                                $modalidadacademica= $db->Execute($query_modalidadacademica);
                                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
                                if(isset($_REQUEST['codigomodalidadacademica'])){
                                    if($_REQUEST['codigomodalidadacademica'] == 500){
                                        $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where codigoareaquejareclamo='".$_REQUEST['codigomodalidadacademica']."'
                                        order by nombredependenciaquejareclamo";
                                    }
                                    else{
                                        $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where codigoareaquejareclamo='".$_REQUEST['codigomodalidadacademica']."'
                                        and '".$fechahoy."' between fechainiciodependencioaquejareclamo and fechafindependenciaquejareclamo
                                        order by nombredependenciaquejareclamo";
                                    }
                                }
                                else
                                {

                                    $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where iddependenciaquejareclamo='".$dataPersona['iddependenciaquejareclamo']."'";
                                    $dataPersona['codigoareaquejareclamo'] = obtenerCodigoAreaQuejaReclamo($_REQUEST['idpersonaquejareclamo']);
                                }
                                $carrera= $db->Execute($query_carrera);
                                $totalRows_carrera = $carrera->RecordCount();
                                if($_REQUEST['tipo_usuario'] != '600' && $_REQUEST['tipo_usuario'] != '700'){
                                ?>
                                <tr>
                                    <td >
                                        Área
                                    </td>
                                    <td  >
                                        <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="prueba()">
                                            <option value="">
                                                Seleccionar
                                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow())
                                                    {
                                                ?>
                                            <option value="<?php echo $row_modalidadacademica['codigoareaquejareclamo'];?>"

                                            <?php if($dataPersona['codigoareaquejareclamo']==$row_modalidadacademica['codigoareaquejareclamo'])
                                              { echo "Selected"; }
                                                   elseif($row_modalidadacademica['codigoareaquejareclamo']==$_REQUEST['codigomodalidadacademica']) {
                                                echo "Selected";
                                                 }
                                                 ?>>
                                            <?php echo $row_modalidadacademica['nombreareaquejareclamo'];?>
                                            </option><?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        Programa o Dependencia
                                    </td>
                                    <td  >
                                        <select name="codigocarrera" id="codigocarrera">
                                            <option value="">
                                                Seleccionar
                                            </option><?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['iddependenciaquejareclamo'] ?>"<?php
                                                if($dataPersona['iddependenciaquejareclamo'] == $row_carrera['iddependenciaquejareclamo']){
                                                echo "Selected";
                                                    }
                                                 else if ($row_carrera['iddependenciaquejareclamo']==$_REQUEST['codigocarrera']) {
                                                echo "Selected";
                                                 }?>>
                                                <?php echo $row_carrera['nombredependenciaquejareclamo'];
                                                ?>
                                            </option><?php };?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                }
                                else {
                                ?>
                                    <input type="hidden" name="codigomodalidadacademica" value="1">
                                    <input type="hidden" name="codigocarrera" value="221">
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td colspan="2" id="tdtitulogris">
                        <p>
                            <label id="labelresaltado">B.TIPO DE REQUERIMIENTO:</label>
                            <br>Seleccione el tipo de requerimiento que desea hacer.
                        </p>
                    </td>
                </tr>
                <?php
                $query_tipo_asunto = "SELECT * from tipoasuntoquejareclamo";
                $tipo_asunto = $db->Execute($query_tipo_asunto);
                $totalRows_tipo_asunto = $tipo_asunto->RecordCount();
                ?>
                <tr align="left" >
                    <TD>
                        <LABEL id="labelasterisco">*</LABEL> Requerimiento
                    </TD>
                    <TD>
                        <select name="tipo_asunto" id="tipo_asunto">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_tipo_asunto = $tipo_asunto->FetchRow()){?><option value="<?php echo $row_tipo_asunto['codigotipoasuntoquejareclamo']?>"
                            <?php if($row_tipo_asunto['codigotipoasuntoquejareclamo']==$_REQUEST['tipo_asunto']){echo "Selected";}?>>
                                <?php echo $row_tipo_asunto['nombretipoasuntoquejareclamo']
                                ?>
                            </option><?php }?>
                        </select>
                    </TD>
                </tr>
                <tr align="left" id="trgris">
                    <td colspan="2">
                        <p>
                            <label id="labelresaltado">C.ÁREA PARA FELICITAR, ANALIZAR O PRESENTAR SOLICITUD:</label>
                            <br>Seleccione la dependencia sobre la cual va a presentar la solicitud.
                        </p>
                    </td>
                </tr>
                <?php
                $modalidadacademica->Move(0);
                if($_REQUEST['codigomodalidad'] == 500){
                    $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where codigoareaquejareclamo='".$_REQUEST['codigomodalidad']."'
                    order by nombredependenciaquejareclamo";
                }
                else{
                    $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where codigoareaquejareclamo='".$_REQUEST['codigomodalidad']."'
                    and '".$fechahoy."' between fechainiciodependencioaquejareclamo and fechafindependenciaquejareclamo
                    order by nombredependenciaquejareclamo";
                }
                
                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
                ?>
                <tr>
                    <td >
                        <LABEL id="labelasterisco">*</LABEL>Área
                    </td>
                    <td >
                        <select name="codigomodalidad" id="codigomodalidad" onchange="prueba()">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigoareaquejareclamo'];?>"<?php if($row_modalidadacademica['codigoareaquejareclamo']==$_REQUEST['codigomodalidad']){echo "Selected";}?>>
                                <?php echo $row_modalidadacademica['nombreareaquejareclamo'];
                                ?>
                            </option><?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td  >
                        <LABEL id="labelasterisco">*</LABEL>Programa o Dependencia
                    </td>
                    <td  >
                        <select name="codigocarrera2" id="codigocarrera2">
                            <option value="">
                                Seleccionar
                            </option><?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['iddependenciaquejareclamo'] ?>"<?php if($row_carrera['iddependenciaquejareclamo']==$_REQUEST['codigocarrera2']){echo "Selected";}?>>
                                <?php echo $row_carrera['nombredependenciaquejareclamo']
                                ?>
                            </option><?php };?>
                        </select>
                    </td>
                </tr>
                <tr align="left" >
                    <td colspan="2" id="tdtitulogris">
                            <p>
                                <label id="labelresaltado">Aspecto para analizar:</label></br>Seleccione el aspecto sobre el que desea presentar el requerimiento.
                            </p>
                    </td>
                </tr>
                <?php
                $query_tipo_aspecto = "SELECT * from aspectotipoasuntoquejareclamo";
                $tipo_aspecto = $db->Execute($query_tipo_aspecto);
                $totalRows_tipo_aspecto = $tipo_aspecto->RecordCount();
                    ?>
                <tr align="left">
                    <TD >
                        <LABEL id="labelasterisco">*</LABEL> Aspecto del Asunto
                    </TD>
                    <TD>
                        <select name="tipo_aspecto" id="tipo_aspecto" >
                            <option value="">
                                Seleccionar
                            </option><?php while($row_tipo_aspecto = $tipo_aspecto->FetchRow()){?><option value="<?php echo $row_tipo_aspecto['codigoaspectotipoasuntoquejareclamo']?>"
                            <?php if($row_tipo_aspecto['codigoaspectotipoasuntoquejareclamo']==$_REQUEST['tipo_aspecto']){echo "Selected";}?>>
                            <?php echo $row_tipo_aspecto['nombreaspectotipoasuntoquejareclamo']
                             ?>
                            </option><?php }?>
                        </select>
                    </TD>
                </tr>
                <tr align="left" >
                    <td colspan="2" id="tdtitulogris">
                            <p>
                                <label id="labelresaltado">D.COMENTARIOS:</label></br>Describa a continuación el requerimiento:
                            </p>
                    </td>
                </tr>
                <tr align="left" >                    
                    <td align="left" >
                        <TEXTAREA name="comentario" cols="50" rows="5"  onkeydown="contar('form1','comentario')" onkeyup="contar('form1','comentario')" ><?php if ($_POST['comentario']!=""){
                        echo $_POST['comentario']; } ?></TEXTAREA>
                        <br>
                        Quedan &nbsp;<INPUT name="result" value="3000" size="4" readonly="true"> &nbsp; Caracteres
                    </td>
                </tr>
                <tr align="left" id=trtitulogris>
                    <td colspan="2">
                            <label id="labelresaltado">Agradecemos su valiosa información y aporte a nuestro proceso de mejoramiento.</br> Cordialmente:</br>
                            Jefe de Atención al Usuario</br>
                            E-mail: atencionalusuario@unbosque.edu.co</br>
                            Teléfono: 6489000 Ext. 170 </label>
                    </td>
                </tr>
                <tr align="left" >
                    <td align="right" colspan="2">
                        <input type="hidden" name="enviar" value="0">
                        <INPUT type="hidden" value="" name="guardar" id="guardar">
                        <INPUT type="button" value="Enviar" onclick="return confirmar()">
                        <input type="button" value="Regresar" onclick="window.location.href='inicio.php'">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>