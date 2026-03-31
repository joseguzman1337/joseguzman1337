<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$varguardar=0;/*
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}*/


if(isset ($_REQUEST['idadministrativosdocentes'])){
    
    $query_datosadmin = "SELECT * FROM administrativosdocentes da,tipogruposanguineo t,
genero g,estado e,documento d, tipousuarioadmdocen td
where  da.idtipousuarioadmdocen=td.idtipousuarioadmdocen
and da.codigogenero=g.codigogenero
and da.codigoestado=e.codigoestado
and da.tipodocumento=d.tipodocumento
and da.idtipogruposanguineo=t.idtipogruposanguineo
and da.idadministrativosdocentes= '".$_REQUEST['idadministrativosdocentes']."'  and da.codigoestado=100";
$datosadmin= $db->Execute($query_datosadmin)or die(mysql_error());
$totalRows_datosadmin= $datosadmin->RecordCount();
$row_datosadmin= $datosadmin->FetchRow();
}

if($_REQUEST['accion'] == "actualizar"){  
    $apellidos = $_REQUEST['apellidos'];
    $nombres =$_REQUEST['nombres'];
    $tipodoc=$_REQUEST['tipodoc'];
    $numerodocumento=$_REQUEST['numerodocumento'];
    $expedidodocumento=$_REQUEST['expedidodocumento'];
    $tipogruposanguineo=$_REQUEST['tipogruposanguineo'];
    $genero=$_REQUEST['genero'];
    $tipousuarioadmdocen=$_REQUEST['tipousuarioadmdocen'];
    $celular=$_REQUEST['celular'];
    $email=$_REQUEST['email'];
    $direccion=$_REQUEST['direccion'];
    $telefono=$_REQUEST['telefono'];
    $cargo=$_REQUEST['cargo'];
    
    $idadministrativosdocentes=$_REQUEST['idadministrativosdocentes'];
    $query_update = "UPDATE administrativosdocentes  SET 
     idtipousuarioadmdocen ='$tipousuarioadmdocen',     
     cargoadministrativosdocentes ='$cargo',
     fechaterminancioncontratoadministrativosdocentes ='',
     telefonoadministrativosdocentes ='$telefono',
     direccionadministrativosdocentes ='$direccion',
     emailadministrativosdocentes ='$email',
     celularadministrativosdocentes ='$celular',
     codigogenero ='$genero',
     idtipogruposanguineo ='$tipogruposanguineo',
     expedidodocumento ='$expedidodocumento',
     numerodocumento ='$numerodocumento',
     tipodocumento ='$tipodoc',
     apellidosadministrativosdocentes ='$apellidos',
     nombresadministrativosdocentes ='$nombres'     
        
    WHERE idadministrativosdocentes= '".$_REQUEST['idadministrativosdocentes']."';";
    $query_update= $db->Execute($query_update)or die(mysql_error());
    
    echo "<script language='JavaScript'>alert('usuario actualizado satisfactoriamente');
            
            </script>";
}//and da.codigoestado=100

if($_REQUEST['accion'] == "eliminar"){    
    $idadministrativosdocentes=$_REQUEST['idadministrativosdocentes'];
    $query_update = "UPDATE administrativosdocentes  SET  codigoestado = 200
    WHERE idadministrativosdocentes= '".$_REQUEST['idadministrativosdocentes']."' and codigoestado=100;";
    $query_update= $db->Execute($query_update)or die(mysql_error());
    echo "<script language='JavaScript'>alert('Usuario Eliminado Satisfactoriamente');
            window.location.href='menudocenteadmin.php';
            </script>";
}

if($_REQUEST['accion'] == "crear"){    
    $apellidos = $_REQUEST['apellidos'];
    $nombres =$_REQUEST['nombres'];
    $tipodoc=$_REQUEST['tipodoc'];
    $numerodocumento=$_REQUEST['numerodocumento'];
    $expedidodocumento=$_REQUEST['expedidodocumento'];
    $tipogruposanguineo=$_REQUEST['tipogruposanguineo'];
    $genero=$_REQUEST['genero'];
    $tipousuarioadmdocen=$_REQUEST['tipousuarioadmdocen'];
    $celular=$_REQUEST['celular'];
    $email=$_REQUEST['email'];
    $direccion=$_REQUEST['direccion'];
    $telefono=$_REQUEST['telefono'];
    $cargo=$_REQUEST['cargo'];
    
    
    $idadministrativosdocentes=$_REQUEST['idadministrativosdocentes'];
    $query_insert = "    
    INSERT INTO `sala`.`administrativosdocentes`
(`idadministrativosdocentes`,
`nombresadministrativosdocentes`,
`apellidosadministrativosdocentes`,
`tipodocumento`,
`numerodocumento`,
`expedidodocumento`,
`idtipogruposanguineo`,
`codigogenero`,
`celularadministrativosdocentes`,
`emailadministrativosdocentes`,
`direccionadministrativosdocentes`,
`telefonoadministrativosdocentes`,
`fechaterminancioncontratoadministrativosdocentes`,
`cargoadministrativosdocentes`,
`codigoestado`,
`idtipousuarioadmdocen`)
VALUES
(
null,
'$nombres',
'$apellidos',
'$tipodoc',
'$numerodocumento',
'$expedidodocumento',
'$tipogruposanguineo',
'$genero',
'$celular',
'$email',
'$direccion',
'$telefono',
now(),
'$cargo',
'100',
'$tipousuarioadmdocen'
); ";
    $query_update= $db->Execute($query_insert)or die(mysql_error());    
    
    echo "<script language='JavaScript'>alert('usuario creado satisfactoriamente');
            window.location.href='menudocenteadmin.php';
            </script>";
}

?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="creaeditadocenteadmin.php">
            <table  border="0"  cellpadding="3" cellspacing="3">
                <TR>
                    <TD><LABEL id="labelresaltadogrande"><?php if(isset ($_REQUEST['idadministrativosdocentes'])){
                        ?>EDICION ADMINISTRATIVOS Y DOCENTES
                        <?php
                        }
                        else{
                        ?>INGRESO NUEVO USUARIO
                        <?php }
                        ?></LABEL>
                    </TD>
                </TR>
            </table>
            <table  border="1"  cellpadding="3" cellspacing="3">
                <tr>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Apellidos
                    </td>
                    <td  colspan="2">
                        <input name="apellidos" type="text"  value="<?php
                            if($row_datosadmin['apellidosadministrativosdocentes'] != "")
                                echo $row_datosadmin['apellidosadministrativosdocentes'];
                            else
                                echo $_REQUEST["apellidos"]; ?>" >
                    </td>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Nombres
                    </td>
                    <td  colspan="2">
                        <input name="nombres" type="text"  value="<?php
                            if($row_datosadmin['nombresadministrativosdocentes'] != "")
                                echo $row_datosadmin['nombresadministrativosdocentes'];
                            else
                                echo $_REQUEST["nombres"]; ?>" >
                    </td>
                </tr>
                <?php
                $query_tipodoc = "select * from documento  where tipodocumento not in (07, 08, 09, 10)";
                $tipodoc = $db->Execute($query_tipodoc);
                $totalRows_tipodoc = $tipodoc->RecordCount();
                ?>
                <tr>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Tipo Documento
                    </td>
                    <td>
                       <select name="tipodoc" id="tipodoc" >
                            <?php while($row_tipodoc = $tipodoc->FetchRow()) { ?>
                                    <option value="<?php echo $row_tipodoc['tipodocumento']?>"
                                    <?php
                                    if($row_datosadmin['tipodocumento'] == $row_tipodoc['tipodocumento']){
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
                    </td>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Número
                    </td>
                    <td>
                        <input name="numerodocumento" type="text"  value="<?php
                            if($row_datosadmin['numerodocumento'] != "")
                                echo $row_datosadmin['numerodocumento'];
                            else
                                echo $_REQUEST["numerodocumento"]; ?>">
                    </td>
                    <td id="tdtitulogris">Expedido en
                    </td>
                    <td>
                        <input name="expedidodocumento" type="text"  value="<?php
                            if($row_datosadmin['expedidodocumento'] != "")
                                echo $row_datosadmin['expedidodocumento'];
                            else
                                echo $_REQUEST["expedidodocumento"]; ?>">
                    </td>
                </tr>
                <?php
                $query_sanguineo = "select * from tipogruposanguineo";
                $sanguineo= $db->Execute($query_sanguineo);
                $totalRows_sanguineo= $sanguineo->RecordCount();
                ?>
                <tr>
                     <td id="tdtitulogris"><label id="labelasterisco">*</label>Grupo Sanguineo
                    </td>
                    <td colspan="2">
                       <select name="tipogruposanguineo" id="tipodoc" >
                            <?php while($row_sanguineo= $sanguineo->FetchRow()) { ?>
                                    <option value="<?php echo $row_sanguineo['idtipogruposanguineo']?>"
                                    <?php
                                    if($row_datosadmin['idtipogruposanguineo'] == $row_sanguineo['idtipogruposanguineo']){
                                        echo "Selected";
                                    }
                                    else if ($row_sanguineo['idtipogruposanguineo']==$_REQUEST['tipogruposanguineo']) {
                                        echo "Selected";
                                    }?>>
                                    <?php echo $row_sanguineo['nombretipogruposanguineo']; ?>
                                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                    $query_genero= "select codigogenero, nombregenero from genero";
                    $genero= $db->Execute($query_genero);
                    $totalRows_genero= $genero->RecordCount();
                    $row_genero=$genero->FetchRow();
                    ?>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Genero
                    </td>
                    <td colspan="2">
                       <select name="genero" >
                           <option value="">
                               Seleccionar
                           </option>
                            <?php do { ?>
                                    <option value="<?php echo $row_genero['codigogenero']?>"
                                    <?php
                                    if($row_datosadmin['codigogenero'] == $row_genero['codigogenero']){
                                        echo "Selected";                                        
                                    }
                                    else if ($row_genero['codigogenero']==$_REQUEST['genero']) {
                                        echo "Selected";                                        
                                    }?>>
                                    <?php echo $row_genero['nombregenero']; ?>
                                            </option>
                            <?php
                            }while($row_genero= $genero->FetchRow())
                            ?>
                        </select>
                    </td>
                </tr>
                 <?php
                $query_tipousuario = "SELECT * FROM tipousuarioadmdocen";
                $tipousuario= $db->Execute($query_tipousuario);
                $totalRows_tipousuario= $tipousuario->RecordCount();
                ?>
                <tr>
                     <td id="tdtitulogris"><label id="labelasterisco">*</label>Tipo Usuario
                    </td>
                    <td colspan="2">
                       <select name="tipousuarioadmdocen" >
                           <option value="">
                               Seleccionar
                           </option>
                            <?php while($row_tipousuario= $tipousuario->FetchRow()) { ?>
                                    <option value="<?php echo $row_tipousuario['idtipousuarioadmdocen']?>"
                                    <?php
                                    if($row_datosadmin['idtipousuarioadmdocen'] == $row_tipousuario['idtipousuarioadmdocen']){
                                        echo "Selected";
                                    }
                                    else if ($row_tipousuario['idtipousuarioadmdocen']==$_REQUEST['tipousuarioadmdocen']) {
                                        echo "Selected";
                                    }?>>
                                    <?php echo $row_tipousuario['nombretipousuarioadmdocen']; ?>
                                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td id="tdtitulogris">Celular
                    </td>
                    <td  colspan="2">
                        <input name="celular" type="text"  value="<?php
                            if($row_datosadmin['celularadministrativosdocentes'] != "")
                                echo $row_datosadmin['celularadministrativosdocentes'];
                            else
                                echo $_REQUEST["celular"]; ?>" >
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Email</td>
                    <td colspan="2"><input name="email" type="text"  value="<?php
                            if($row_datosadmin['emailadministrativosdocentes'] != "")
                                echo $row_datosadmin['emailadministrativosdocentes'];
                            else
                                echo $_REQUEST["email"]; ?>" ></td>
                    <td id="tdtitulogris">Dirección</td>
                    <td colspan="2"><input name="direccion" type="text"  value="<?php
                            if($row_datosadmin['direccionadministrativosdocentes'] != "")
                                echo $row_datosadmin['direccionadministrativosdocentes'];
                            else
                                echo $_REQUEST["direccion"]; ?>" ></td>                    
                    </tr>
                    <tr>
                    <td id="tdtitulogris">Telefono</td>    
                    <td colspan="2"><input name="telefono" type="text"  value="<?php
                            if($row_datosadmin['telefonoadministrativosdocentes'] != "")
                                echo $row_datosadmin['telefonoadministrativosdocentes'];
                            else
                                echo $_REQUEST["telefono"]; ?>" ></td>
                    <td id="tdtitulogris">Cargo</td>    
                    <td colspan="2"><input name="cargo" type="text"  value="<?php
                            if($row_datosadmin['cargoadministrativosdocentes'] != "")
                                echo $row_datosadmin['cargoadministrativosdocentes'];
                            else
                                echo $_REQUEST["cargo"]; ?>" ></td>                                        
                </tr>
                <tr>
                    <td colspan="6" id="tdtitulogris" style="text-align: center;">
                        <input name="accion" type="hidden" value=""/>
                        <input name="idadministrativosdocentes" type="hidden" value="<?=$row_datosadmin['idadministrativosdocentes'] ;?>"/>
                        
                        <?if ($row_datosadmin['idadministrativosdocentes']<> ""){?>
                        <input id="enviar1" type="button" value="Guardar" onclick="guardar(this);"/>
                        <input id="enviar2" type="button" value="Eliminar" onclick="guardar(this);"/>
                        <?}else{?>                        
                        <input id="enviar3" type="button" value="Crear" onclick="guardar(this);"/>                    
                        <?}?>                        
                    </td> 
                </tr>                    
            </table>
        </form>
        <script>
            function guardar(obj){
                
                if(obj.id == "enviar1"){document.f1.accion.value = "actualizar";document.f1.submit();}
                if(obj.id == "enviar2"){
                    if(confirm('Esta seguro de Inactivar este registro?')){ document.f1.accion.value = "eliminar";document.f1.submit();}   
                }
                if(obj.id == "enviar3"){document.f1.accion.value = "crear";document.f1.submit();}
            }
        </script>
    </body>
</html> 
