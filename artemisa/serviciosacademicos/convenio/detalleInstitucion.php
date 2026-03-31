<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include(realpath(dirname(__FILE__)).'/../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    $db = getBD();
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$user,1,2);
        
    if($Acceso['val']===false)
    {
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }
   
       
    if(!empty($_POST['Detalle']))
    {
        $id = $_POST['Detalle'];
        //Consulta para obtener los datos de la institucion 
        $sql1 ="SELECT NombreInstitucion, Nit, Direccion, Telefono, TelefonoDos, Email, RepresentanteLegal, IdentificacionRepresentante, CiudadId, EmailRepresentante, 	idsiq_tipoinstitucion, idsiq_estadoconvenio, CargoRepresentanteLegal, NombreSupervisor, IdentificacionSupervisor, TelefonoSupervisor, CargoSupervisor, EmailSupervisor, NombreSolicitanteBosque, TelefonoSolicitanteBosque, CargoSolicitanteBosque, EmailSolicitanteBosque, CargoRepresentanteLegal, NombreSupervisorBosque, TelefonoSupervisorBosque, CargoSupervisorBosque, EmailSupervisorBosque, FechaInicio, FechaFin, Vigencia, CodigoInstitucion 
        FROM InstitucionConvenios WHERE InstitucionConvenioId ='".$id."'";
        $detalles = $db->GetAll($sql1);     
        
        foreach($detalles as $datos1)
        {
            $nombreInstitucion             = $datos1['NombreInstitucion']; 
            $nit                           = $datos1['Nit'];
            $direccion                     = $datos1['Direccion'];
            $telefono                      = $datos1['Telefono'];
            $telefonodos                   = $datos1['TelefonoDos'];
            $emailinstitucion              = $datos1['Email'];
            $corporacionquesuscribe        = $datos1['CorporacionQueSuscribe'];
            $representantelegal            = $datos1['RepresentanteLegal'];
            $identificacionrepresentante   = $datos1['IdentificacionRepresentante'];
            $ciudad                        = $datos1['CiudadId'];
            $emailrepresentante            = $datos1['EmailRepresentante'];
            $tipoinstitucion               = $datos1['idsiq_tipoinstitucion'];
            $idsiq_estadoconvenio          = $datos1['idsiq_estadoconvenio'];
            $cargorepresentantelegal       = $datos1['CargoRepresentanteLegal'];
            $nombresupervisor              = $datos1['NombreSupervisor'];
            $identificacionsupervisor      = $datos1['IdentificacionSupervisor'];
            $telefonosupervisor            = $datos1['TelefonoSupervisor'];
            $cargosupervisor               = $datos1['CargoSupervisor'];
            $emailsupervisor               = $datos1['EmailSupervisor'];
            $nombresolicitantebosque       = $datos1['NombreSolicitanteBosque'];
            $telefonosolicitantebosque     = $datos1['TelefonoSolicitanteBosque'];
            $cargosolicitantebosque        = $datos1['CargoSolicitanteBosque'];
            $emailsolicitantebosque        = $datos1['EmailSolicitanteBosque'];
            $nombresupervisorbosque        = $datos1['NombreSupervisorBosque'];
            $telefonosupervisorbosque      = $datos1['TelefonoSupervisorBosque'];
            $cargosupervisorbosque         = $datos1['CargoSupervisorBosque'];
            $emailsupervisorbosque         = $datos1['EmailSupervisorBosque'];
            $fechainicio                   = $datos1['FechaInicio'];
            $fechafinal                    = $datos1['FechaFin'];
            $vigencia                      = $datos1['Vigencia'];
            $codigoinstitucion             = $datos1['CodigoInstitucion']; 
            
        }
    }//if post[detalle]
    else
    {           
        if($_POST['Action_id']=='SaveData')
        {   
            $id                            = $_POST['id'];
            $nombreInstitucion             = $_POST['nombreinstitucion']; 
            $nit                           = $_POST['nit'];
            $direccion                     = $_POST['direccion'];
            $telefono                      = $_POST['telefono'];
            $telefonodos                   = $_POST['telefonodos'];
            $emailinstitucion              = $_POST['emailinstitucion'];
            $corporacionquesuscribe        = $_POST['corporacionquesuscribe'];
            $representantelegal            = $_POST['representantelegal'];
            $identificacionrepresentante   = $_POST['identificacionrepresentante'];
            $ciudad                        = $_POST['CiudadId'];
            $emailrepresentante            = $_POST['emailrepresentante'];
            $tipoinstitucion1              = $_POST['tipoinstitucion1'];
            $tipoinstitucion               = $_POST['tipoinstitucion'];
            $idsiq_estadoconvenio          = $_POST['idsiq_estadoconvenio'];
            $cargorepresentantelegal       = $_POST['cargorepresentantelegal'];
            $nombresupervisor              = $_POST['nombresupervisor'];
            $identificacionsupervisor      = $_POST['identificacionsupervisor'];
            $telefonosupervisor            = $_POST['telefonosupervisor'];
            $cargosupervisor               = $_POST['cargosupervisor'];
            $emailsupervisor               = $_POST['emailsupervisor'];
            $nombresolicitantebosque         = $_POST['nombresolicitantebosque'];
            $telefonosolicitantebosque        = $_POST['telefonosolicitantebosque'];
            $cargosolicitantebosque           = $_POST['cargosolicitantebosque'];
            $emailsolicitantebosque           = $_POST['emailsolicitantebosque'];
            $fechamodificacion             = date("Y-m-d H:i:s");
            $nombresupervisorbosque          = $_POST['nombresupervisorbosque'];
            $telefonosupervisorbosque        = $_POST['telefonosupervisorbosque'];
            $cargosupervisorbosque           = $_POST['cargosupervisorbosque'];
            $emailsupervisorbosque           = $_POST['emailsupervisorbosque'];
            $fechainicio                   = $_POST['fechainicio'];
            $fechafinal                    = $_POST['fechafin'];
            $vigencia                      = $_POST['vigencia'];
            $codigoinstitucion             = $_POST['codigoinstitucion'];
        
            $nombreInstitucion =  limpiarCadena(filter_var($nombreInstitucion,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $nit =  limpiarCadena(filter_var($nit,FILTER_SANITIZE_NUMBER_INT));
            $emailinstitucion =  filter_var($emailinstitucion,FILTER_SANITIZE_EMAIL);
            $representantelegal =  limpiarCadena(filter_var($representantelegal,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $identificacionrepresentante =  limpiarCadena(filter_var($identificacionrepresentante,FILTER_SANITIZE_NUMBER_INT));
            $emailrepresentante = filter_var($emailrepresentante,FILTER_SANITIZE_EMAIL);
            $tipoinstitucion1 =  limpiarCadena(filter_var($tipoinstitucion1,FILTER_SANITIZE_NUMBER_INT));
            $tipoinstitucion =  limpiarCadena(filter_var($tipoinstitucion,FILTER_SANITIZE_NUMBER_INT));
            $ciudad =  limpiarCadena(filter_var($ciudad,FILTER_SANITIZE_NUMBER_INT));
            $idsiq_estadoconvenio =  limpiarCadena(filter_var($idsiq_estadoconvenio,FILTER_SANITIZE_NUMBER_INT));
            $cargorepresentantelegal =  limpiarCadena(filter_var($cargorepresentantelegal,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $nombresupervisor =  limpiarCadena(filter_var($nombresupervisor,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $identificacionsupervisor =  limpiarCadena(filter_var($identificacionsupervisor,FILTER_SANITIZE_NUMBER_INT));
            $telefonosupervisor =  limpiarCadena(filter_var($telefonosupervisor,FILTER_SANITIZE_NUMBER_INT));
            $cargosupervisor =  limpiarCadena(filter_var($cargosupervisor,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $emailsupervisor = filter_var($emailsupervisor,FILTER_SANITIZE_EMAIL);
            $nombresolicitantebosque =  limpiarCadena(filter_var($nombresolicitantebosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $telefonosolicitantebosque =  limpiarCadena(filter_var($telefonosolicitantebosque,FILTER_SANITIZE_NUMBER_INT));
            $cargosolicitantebosque =  limpiarCadena(filter_var($cargosolicitantebosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $emailsolicitantebosque = filter_var($emailsolicitantebosque,FILTER_SANITIZE_EMAIL);
            $nombresupervisorbosque =  limpiarCadena(filter_var($nombresupervisorbosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $telefonosupervisorbosque =  limpiarCadena(filter_var($telefonosupervisorbosque,FILTER_SANITIZE_NUMBER_INT));
            $cargosupervisorbosque =  limpiarCadena(filter_var($cargosupervisorbosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $emailsupervisorbosque = filter_var($emailsupervisorbosque,FILTER_SANITIZE_EMAIL);
            $vigencia =  limpiarCadena(filter_var($vigencia,FILTER_SANITIZE_NUMBER_INT));
            $codigoinstitucion =  limpiarCadena(filter_var($codigoinstitucion,FILTER_SANITIZE_NUMBER_INT));
        
            //update de los campos de la institucion
            $slq3 = "update InstitucionConvenios set NombreInstitucion = '".$nombreInstitucion."', Nit = '".$nit."', Direccion = '".$direccion."', Telefono = '".$telefono."', TelefonoDos = '".$telefonodos."', Email = '".$emailinstitucion."', RepresentanteLegal = '".$representantelegal."',  IdentificacionRepresentante = '".$identificacionrepresentante."', CiudadId = '".$ciudad."', EmailRepresentante = '".$emailrepresentante."', idsiq_estadoconvenio = '".$idsiq_estadoconvenio."', FechaModificacion = '".$fechamodificacion."',  NombreSupervisor = '".$nombresupervisor."', TelefonoSupervisor = '".$telefonosupervisor."', idsiq_tipoinstitucion = '".$tipoinstitucion."', CargoSupervisor = '".$cargosupervisor."', EmailSupervisor = '".$emailsupervisor."', NombresolicitanteBosque = '".$nombresolicitantebosque."', TelefonosolicitanteBosque = '".$telefonosolicitantebosque."',  CargoSolicitanteBosque = '".$cargosolicitantebosque."', EmailSolicitanteBosque = '".$emailsolicitantebosque."', UsuarioModificacion = '".$user."', CargoRepresentanteLegal = '".$cargorepresentantelegal."', IdentificacionSupervisor = '".$identificacionsupervisor."', NombreSupervisorBosque = '".$nombresupervisorbosque."', TelefonoSupervisorBosque = '".$telefonosupervisorbosque."', CargoSupervisorBosque = '".$cargosupervisorbosque."', EmailSupervisorBosque = '".$emailsupervisorbosque."',FechaInicio ='".$fechainicio."', FechaFin='".$fechafinal."', Vigencia='".$vigencia."', CodigoInstitucion='".$codigoinstitucion."'  where (InstitucionConvenioId = '".$id."')AND(idsiq_tipoinstitucion = '".$tipoinstitucion1."')";
        
        
            if($Consulta=&$db->Execute($slq3)===true)
            {
                 $descrip = "No se guardaron los datos";
            }else
            {
               $descrip = "La institucion fue actualizada."; 
               //$descrip = $slq3;
            }
            $a_vectt['val']			=true;
            $a_vectt['descrip']		=$descrip;
            echo json_encode($a_vectt);
            exit;
        }//if($_POST['Action_id']=='SaveData')
    }//else post[detalle]   
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detalles Institución</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesInstituciones.js"></script>
        <script type="text/javascript">
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;            
            if (tecla==8 || tecla ==0) return true;
            patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ \s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
        function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8 || tecla ==0) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
        function val_dirrecion(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8 || tecla ==0) return true;
            patron =/[0-9a-zA-ZñÑ-\s]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
        
        <script>
        function val_email(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8 || tecla ==0) return true;
            patron = /[0-9a-zA-Z\-\.\@\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/        
        	$(document).ready( function () {        			
        		$("#fechainicio").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechafin").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
        	} );
        	/**************************************************************/
        </script>                
    </head>
    <body> 
        <div id="container">
        <center>
            <h1><font face="sans-serif">DETALLES INSTITUCIÓN</font></h1>
        </center>
        <form  id="detalleinstitucion" action="../convenio/detalleInstitucion.php" method="post" enctype="multipart/form-data" >
            <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
            <input type="hidden" id="tipoinstitucion1" name="tipoinstitucion1" value="<?php echo $tipoinstitucion?>" />
            <input type="hidden" id="id_" name="id" value="<?php echo $id?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td><font face="sans-serif">Nombre Institución:</font><span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="nombreinstitucion" id="nombreinstitucion" value="<?php echo $nombreInstitucion ?>" class="required" onkeypress="return val_texto(event)" size="55" />
                    </td>
                    <td>Dirreción Institución:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="direccion" id="direccion" value="<?php echo $direccion?>"  class="required" onkeypress="return val_dirrecion(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>NIT:</td>
                    <td>
                        <input type="text" name="nit" id="nit" value="<?php echo $nit?>" onkeypress="return val_numero(event)" />
                    </td>
                    <td>Email:</td>
                    <td>
                        <input type="text" name="emailinstitucion" id="emailinstitucion" value="<?php echo $emailinstitucion?>"  onkeypress="return val_email(event)"/> 
                    </td>
                </tr>  
                <tr>
                    <td>Teléfono:</td>
                    <td>
                        <input type="number" name="telefono" min="1000000" max="10000000000" id="telefono" value="<?php echo $telefono?>" class="required" onkeypress="return val_numero(event)"/>
                    </td>
                     <td>Tipo Institución:<span style="color: red;">*</span></td>
                    <td>
                        <select id="tipoinstitucion" name="tipoinstitucion">
                     <?php
                        $sqltipo = "select idsiq_tipoinstitucion, nombretipoinstitucion from siq_tipoinstitucion";
                        $tipos = $db->Execute($sqltipo);
                        foreach($tipos as $nombrestipos)
                        {
                            if($nombrestipos['idsiq_tipoinstitucion'] == $tipoinstitucion ){
                        ?>
                          <option value="<?php echo $nombrestipos['idsiq_tipoinstitucion']?>" selected="selected"><?php echo $nombrestipos['nombretipoinstitucion']?></option>
                        <?php
                            }else
                            {
                              ?>
                             <option value="<?php echo $nombrestipos['idsiq_tipoinstitucion']?>"><?php echo $nombrestipos['nombretipoinstitucion']?></option>
                         <?php  
                            }
                        }                        
                        ?>
                        </select>
                    </td>                                    
                </tr> 
                <tr>
                    <td>Ciudad:</td>
                    <td>
                        <select name="CiudadId" id="CiudadId" class="required">
                        <?php
                        $sqlcidudad = "select nombreciudad from ciudad where idciudad= '".$ciudad."'";
                         $valorciudad = $db->Execute($sqlcidudad);
                         $valorciudad->EOF;
                        ?>
                        <option value="<?php echo $ciudad?>" selected="selected"><?php echo $valorciudad->fields['nombreciudad']?></option>
                        <option value=""></option>
                        <?php
                        $sqlciudades = "select idciudad, nombreciudad from ciudad where codigoestado= '100' order by idciudad asc";
                        $ciudades = $db->Execute($sqlciudades);
                        foreach($ciudades as $nombresciudades)
                        {
                            ?>
                          <option value="<?php echo $nombresciudades['idciudad']?>"><?php echo $nombresciudades['nombreciudad']?></option>
                            <?php
                        }                        
                        ?>
                        </select>
                        </td>
                    <td>Estado:</td>
                    <?PHP
                        $sql_2 = "SELECT idsiq_estadoconvenio, nombreestado  FROM siq_estadoconvenio";
                        if($Consulta=&$db->Execute($sql_2)===false){
                            echo 'Error en el SQl ...<br><br>'.$sql_2;
                            die;
                        }
                    ?>
                    <td>
                        <select id="idsiq_estadoconvenio" name="idsiq_estadoconvenio">
                            <option value="-1"></option>
                        <?php 
                             while(!$Consulta->EOF)
                            {  
                                if($Consulta->fields['idsiq_estadoconvenio']== $idsiq_estadoconvenio)
                                {
                                  ?><option value="<?php echo $Consulta->fields['idsiq_estadoconvenio'];?>" selected="selected"><?php echo $Consulta->fields['nombreestado']?></option>";
                                   <?php
                                    $Consulta->MoveNext();  
                                }
                               ?><option value="<?php echo $Consulta->fields['idsiq_estadoconvenio'];?>"><?php echo $Consulta->fields['nombreestado']?></option>";
                               <?php
                               $Consulta->MoveNext();
                            }
                        ?>  
                                  
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fecha inicio:</td>
                    <td>
                        <input type="text" name="fechainicio" id="fechainicio" value="<?php echo $fechainicio;?>" />
                    </td>
                    <td>Fecha final</td>
                    <td>
                        <input type="text" name="fechafin" id="fechafin" value="<?php echo $fechafinal;?>" >
                    </td>
                </tr>
                <tr>
                    <td>Vigencia:</td>
                    <td>
                        <select id="vigencia" name="vigencia">
                        <?php
                            $sqlvigencia = "select nombreduracion, idsiq_duracionconvenio from siq_duracionconvenio";
                             $vigenciadatos = $db->Execute($sqlvigencia);
                            foreach($vigenciadatos as $numerosvigencia)
                            {
                                if($vigencia==$numerosvigencia['idsiq_duracionconvenio'])
                                { 
                                    ?>
                                    <option value="<?php echo $numerosvigencia['idsiq_duracionconvenio']?>" selected="selected"><?php echo $numerosvigencia['nombreduracion'];?></option>
                                    <?php
                                }else
                                {
                                    ?>
                                        <option value="<?php echo $numerosvigencia['idsiq_duracionconvenio']?>"><?php echo $numerosvigencia['nombreduracion'];?></option>
                                    <?php
                                }
                            }                        
                        ?>
                        </select>
                    </td>
                    <td>Codigo Institucion:</td>
                    <td>
                        <input type="text" name="codigoinstitucion" id="codigoinstitucion" value="<?php echo $codigoinstitucion;?>" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan='4'><center><h2><font face="sans-serif">INSTITUCIÓN</font></h2></center></td>
                    <td></td>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <th colspan='4'><font face="sans-serif" color="#6a7528">Representante</font></th>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre </td>
                    <td>
                        <input type="text" name="representantelegal" id="representantelegal" value="<?php echo $representantelegal ?>" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                     <td>Identificación</td>
                    <td>
                        <input type="text" name="identificacionrepresentante" id="identificacionrepresentante"  value="<?php echo $identificacionrepresentante?>" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Cargo</td>
                    <td>
                        <input type="text" name="cargorepresentantelegal" id="cargorepresentantelegal" value="<?php echo $cargorepresentantelegal?>" size="50"  onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono</td>
                    <td>
                        <input type="number" name="telefonodos"  min="1000000" max="10000000000"  id="telefonodos" value="<?php echo $telefonodos ?>" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <th colspan='4'><font face="sans-serif" color="#6a7528">Supervisor</font></th>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                   <td>Nombre</td>
                    <td>
                        <input type="text" name="nombresupervisor" id="nombresupervisor" value="<?php echo $nombresupervisor?>" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Identificación</td> 
                    <td>
                        <input type="text" name="identificacionsupervisor" id="identificacionsupervisor" value="<?php echo $identificacionsupervisor?>" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Email</td> 
                    <td>
                        <input type="text" name="emailsupervisor" id="emailsupervisor" value="<?php echo $emailsupervisor ?>" size="50" onkeypress="return val_email(event)"/>
                    </td>
                    <td>Cargo</td> 
                    <td>
                        <input type="text" name="cargosupervisor" id="cargosupervisor" value="<?php echo $cargosupervisor?>" size="50" onkeypress="return val_texto(event)" />
                    </td>
                </tr>
                <tr>
                    <td>Teléfono</td> 
                    <td>
                        <input type="number" name="telefonosupervisor"  min="1000000" max="10000000000"  id="telefonosupervisor" value="<?php echo $telefonosupervisor ?>" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan='4'><center><h2><font face="sans-serif">UNIVERSIDAD EL BOSQUE</font></h2></center></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                 <tr>
                     <th colspan="4"><font face="sans-serif" color="#6a7528">Solicitante</font></th>
                </tr>
                 <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre solitante</td>
                    <td>
                        <input type="text" name="nombresolicitantebosque" id="nombresolicitantebosque" value="<?php echo $nombresolicitantebosque?>" size="50"  onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono solitante</td>
                    <td>
                        <input type="number" name="telefonosolicitantebosque"  min="1000000" max="10000000000"  id="telefonosolicitantebosque" value="<?php echo $telefonosolicitantebosque?>" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>
                    <td>Cargo solitante</td>
                    <td>
                        <input type="text" name="cargosolicitantebosque" id="cargosolicitantebosque" value="<?php echo $cargosolicitantebosque?>" size="50"  onkeypress="return val_texto(event)"/>
                    </td>
                     <td>Email solitante</td>
                    <td>
                        <input type="text" name="emailsolicitantebosque" id="emailsolicitantebosque" value="<?php echo $emailsolicitantebosque?>" size="50" onkeypress="return val_email(event)" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                 <tr>
                     <th colspan="4"><font face="sans-serif" color="#6a7528">Supervisor</font></th>
                </tr>
                 <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Supervisor</td>
                    <td>
                        <input type="text" name="nombresupervisorbosque" id="nombresupervisorbosque" value="<?php echo $nombresupervisorbosque?>" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono Supervisor</td>
                    <td>
                        <input type="number" name="telefonosupervisorbosque"  min="1000000" max="10000000000"  id="telefonosupervisorbosque" value="<?php echo $telefonosupervisorbosque?>"  onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Cargo Supervisor</td>
                    <td>
                        <input type="text" name="cargosupervisorbosque" id="cargosupervisorbosque" value="<?php echo $cargosupervisorbosque?>" size="50" onkeypress="return val_texto(event)" />
                    </td>
                    <td>Email Supervisor</td>
                    <td>
                        <input type="text" name="emailsupervisorbosque" id="emailsupervisorbosque" value="<?php echo $emailsupervisorbosque?>" size="50" onkeypress="return val_email(event)" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
            </table>
            <center>
                <table width="600" id="botones">
                    <tr>
                        <td><?php 
                            if($Acceso['Rol']=='1' || $Acceso['Rol']=='2')
                            {
                                ?><input type="button" value="Guardar" onclick="validarDatosDetalle('#detalleinstitucion');" /><?php 
                            }?>                                
                        </td>
                        <td align='right'><input type="button" value="Regresar" onclick="Regresar()" /></td>                    
                    </tr>
                </table>
            </center>
        </form>
    </div>
  </body>
</html> 