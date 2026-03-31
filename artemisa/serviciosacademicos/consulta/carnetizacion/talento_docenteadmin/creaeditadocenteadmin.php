<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
session_start();
$fechahoy=date("Y-m-d H:i:s");
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require('../../../Connections/salaado.php');
$varguardar=0;
if(!isset ($_SESSION['MM_Username'])){
echo "No tiene permiso para acceder a esta opción";
exit();
}
if($_REQUEST['accion'] == "actualizar"){
	
    $apellidos = $_REQUEST['apellidos'];
    $nombres =$_REQUEST['nombres'];
    $tipodocumento=$_REQUEST['tipodocumento'];
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
    $fechavigencia=$_REQUEST['fechavigencia'];
    $idadministrativosdocentes=$_REQUEST['idadministrativosdocentes'];
	$emailInstitucional = $_REQUEST['emailInstitucional'];
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
     tipodocumento ='$tipodocumento',
     apellidosadministrativosdocentes ='$apellidos',
     nombresadministrativosdocentes ='$nombres'  ,
    fechaterminancioncontratoadministrativosdocentes = '$fechavigencia'
    WHERE idadministrativosdocentes= '".$_REQUEST['idadministrativosdocentes']."';";
    $query_update= $db->Execute($query_update)or die(mysql_error());
	if(empty($emailInstitucional)){
		if($tipousuarioadmdocen==42 || $tipousuarioadmdocen==43 || $tipousuarioadmdocen==46) {
					echo "<br>Creando docente en las diferentes plataformas ...<br>";
					$_REQUEST['accion']="Crear";
					$_REQUEST['tipo_creacion']=1;
					$_REQUEST['espracticante']=99;
					$_REQUEST['administrativodocente']=true;
					$creaciondesdetalentohumano=true;
					include_once dirname(__FILE__)."/../../creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php";
				}	
	}
	

	echo "<script language='JavaScript'>alert('usuario actualizado satisfactoriamente');

            </script>";
}//and da.codigoestado=100
//echo "hola<br/>";
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
//print_r($row_datosadmin);
}

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
    $tipodocumento=$_REQUEST['tipodocumento'];
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
    $fechavigencia=$_REQUEST['fechavigencia'];
    
    $idadministrativosdocentes=$_REQUEST['idadministrativosdocentes'];
	
	$sqlDuplicado = "SELECT  idadministrativosdocentes from administrativosdocentes where numerodocumento = '".$numerodocumento."' and tipodocumento = '".$tipodocumento."' ";
	$idadmin = $db->GetRow($sqlDuplicado);
	
	if($idadmin['idadministrativosdocentes'])
	{
		  echo "<script language='JavaScript'>alert('El usuario ya se encuentra registrado en el sistema');document.location = 'creaeditadocenteadmin.php';</script>";		  
	}else
	{
		 $query_insert = "INSERT INTO `administrativosdocentes`
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
				'$tipodocumento',
				'$numerodocumento',
				'$expedidodocumento',
				'$tipogruposanguineo',
				'$genero',
				'$celular',
				'$email',
				'$direccion',
				'$telefono',
				'$fechavigencia',
				'$cargo',
				'100',
				'$tipousuarioadmdocen'
				); ";
					$query_update= $db->Execute($query_insert)or die(mysql_error());    
				//42 = docente --- 43= prestacion de servicio --- 46= Docente Ad-Honorem
				if($tipousuarioadmdocen==42 || $tipousuarioadmdocen==43 || $tipousuarioadmdocen==46) {
					echo "<br>Creando docente en las diferentes plataformas ...<br>";
					$_REQUEST['accion']="Crear";
					$_REQUEST['tipo_creacion']=1;
					$_REQUEST['espracticante']=99;
					$_REQUEST['administrativodocente']=true;
					$creaciondesdetalentohumano=true;
					include_once dirname(__FILE__)."/../../creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php";
				}
			echo "<script language='JavaScript'>alert('usuario creado satisfactoriamente');document.location = 'menudocenteadmin.php';</script>";				
	}	
//include_once $_SESSION["path_live"]."consulta/creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php";
} 
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="../../../estilos/jquery-ui.css" type="text/css">
        <script src="../../js/jquery.js"></script>
        <script src="../../js/jquery-ui.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="creaeditadocenteadmin.php">
            <table  border="0"  cellpadding="3" cellspacing="3">
                <TR>
                    <TD><LABEL id="labelresaltadogrande"><?php if(isset($_REQUEST['idadministrativosdocentes'])){
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
                            if($row_datosadmin['apellidosadministrativosdocentes'] != ""){
                                echo $row_datosadmin['apellidosadministrativosdocentes'];
                            }else{
                                echo $_REQUEST["apellidos"]; 
							} ?>" >
                    </td>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Nombres
                    </td>
                    <td  colspan="2">
                        <input name="nombres" type="text"  value="<?php
                            if($row_datosadmin['nombresadministrativosdocentes'] != ""){
                                echo $row_datosadmin['nombresadministrativosdocentes'];
                            }else{
                                echo $_REQUEST["nombres"]; 
							} ?>" >
                    </td>
                </tr>
                <?php
                $query_tipodoc = "select * from documento  where tipodocumento not in (07, 08, 09, 10)";
                $tipodocumento = $db->Execute($query_tipodoc);
                $totalRows_tipodoc = $tipodocumento->RecordCount();
				
                ?>
                <tr>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Tipo Documento
                    </td>
                    <td>
                       <select name="tipodocumento" id="tipodocumento" >
                            <?php while($row_tipodoc = $tipodocumento->FetchRow()) { ?>
                                    <option value="<?php echo $row_tipodoc['tipodocumento']?>"
                                    <?php
                                    if($row_datosadmin['tipodocumento'] == $row_tipodoc['tipodocumento']){
                                        echo "Selected";
                                    }
                                    else if ($row_tipodoc['tipodocumento']==$_REQUEST['tipodocumento']) {
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
                            if($row_datosadmin['numerodocumento'] != ""){
                                echo $row_datosadmin['numerodocumento'];
                            }else{
                                echo $_REQUEST["numerodocumento"]; 
							} ?>">
                    </td>
                    <td id="tdtitulogris">Expedido en
                    </td>
                    <td>
                        <input name="expedidodocumento" type="text"  value="<?php
                            if($row_datosadmin['expedidodocumento'] != ""){
                                echo $row_datosadmin['expedidodocumento'];
                            }else{
                                echo $_REQUEST["expedidodocumento"]; 
							} ?>">
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
                       <select name="tipogruposanguineo" id="tipogruposanguineo" >
                           <option value="">
                               Seleccionar
                           </option>
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
                    //$row_genero=$genero->FetchRow(); 
                    ?>
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Genero
                    </td>
                    <td colspan="2">
                       <select name="genero" >
                           <option value="">
                               Seleccionar
                           </option>
                            <?php while($row_genero= $genero->FetchRow()) { ?>
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
                            }
							
                            ?>
                        </select>
                    </td>
                </tr>
                 <?php
                $query_tipousuario = "SELECT * FROM tipousuarioadmdocen where codigoestado='100'";
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
                    <td id="tdtitulogris"><label id="labelasterisco">*</label>Email</td>
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
                    <td id="tdtitulogris">Vigente hasta :</td>
                    <td colspan="2"><input type="text" id="datepicker" name="fechavigencia"  value="<?php
                            if($row_datosadmin['fechaterminancioncontratoadministrativosdocentes'] != "")
                                echo $row_datosadmin['fechaterminancioncontratoadministrativosdocentes'];
                            else
                                if(isset($_REQUEST["fechavigencia"])){echo $_REQUEST["fechavigencia"];} else { echo "2099-12-12";} ?>" maxlength="10" size="10" ></td>
                    <td id="tdtitulogris">Usuario :</td>
                    <td colspan="2"><input type="text" name="emailInstitucional"  value="<?php 
								if($row_datosadmin['EmailInstitucional'] != "")
                                echo $row_datosadmin['EmailInstitucional']; ?>" readonly></td>                              
                </tr>
                <tr>
                    <td colspan="6" id="tdtitulogris" style="text-align: center;">
                        <input name="accion" type="hidden" value=""/>
                        <input name="idadministrativosdocentes" type="hidden" value="<?php echo $row_datosadmin['idadministrativosdocentes']; ?>"/>
                        <?php						
						if($row_datosadmin['idadministrativosdocentes']!=""){ ?>
                        <input id="enviar1" type="button" value="Guardar" onclick="guardar(this);"/>
                        <input id="enviar2" type="button" value="Inactivar" onclick="guardar(this);"/>
                        <input id="enviar4" type="button" value="Regresar" onclick="guardar(this);"/>
                        <?php }else{ ?>                        
                        <input id="enviar3" type="button" value="Crear" onclick="guardar(this);"/>                    
                        <?php } ?>                        
                    </td> 
                </tr>                    
            </table>
        </form>
        <script>

    jQuery(function($){
            $.datepicker.regional['es'] = {
                    closeText: 'Cerrar',
                    prevText: '&#x3c;Ant',
                    nextText: 'Sig&#x3e;',
                    currentText: 'Hoy',
                    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                    'Jul','Ago','Sep','Oct','Nov','Dic'],
                    dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                    weekHeader: 'Sm',
                    dateFormat: 'yy-mm-dd',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['es']);
    });

        
	$(function() {
		$( "#datepicker" ).datepicker();
	});

    function guardar(obj){
                
                if(obj.id == "enviar1"){document.f1.accion.value = "actualizar";document.f1.submit();}
                if(obj.id == "enviar2"){
                    if(confirm('Esta seguro de Inactivar este registro?')){ document.f1.accion.value = "eliminar";document.f1.submit();}   
                }
                if(obj.id == "enviar3"){
			var msj="";
			var vape=document.f1.apellidos.value;
			if (vape.length == 0 || /^\s+$/.test(vape))
				msj+="El campo Apellidos es requerido.\n";
			var vnom=document.f1.nombres.value;
			if (vnom.length == 0 || /^\s+$/.test(vnom))
				msj+="El campo Nombres es requerido.\n";
			if (document.f1.tipodocumento.value==0)
				msj+="El campo Tipo Documento es requerido.\n";
			var vnro=document.f1.numerodocumento.value;
			if (vnro.length == 0 || /^\s+$/.test(vnro) || !/^([0-9])*$/.test(vnro))
				msj+="El campo Documento es requerido y debe ser numerico.\n";
			if (document.f1.tipogruposanguineo.value=="")
				msj+="El campo Grupo Sanguineo es requerido.\n";
			if (document.f1.genero.value=="")
				msj+="El campo Genero es requerido.\n";
			if (document.f1.tipousuarioadmdocen.value=="")
				msj+="El campo Tipo Usuario es requerido.\n";
			 var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!expr.test(document.f1.email.value) )
				msj+="El campo Email es requerido y debe ser una dirección de correo correcta.\n";
			if(msj)
				alert(msj);
			else {
				document.f1.accion.value = "crear";
				document.f1.submit();
			}
		}
                if(obj.id == "enviar4"){window.location.href='menudocenteadmin.php';}

            }
        </script>
    </body>
</html> 
