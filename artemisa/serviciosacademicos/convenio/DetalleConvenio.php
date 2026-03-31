<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    $db = getBD();

    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=&$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];
    //validacion de persimos para acceder a las opciones de los detalles del convenio
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,1);
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    //detalle es el id del convenio para verificar su detalle
    $detalle = $_REQUEST['Detalle'];
    
    $sqldatos = "select idsiq_tipoconvenio, InstitucionConvenioId from Convenios where ConvenioId ='".$detalle."'";
    $datosglobales = $db->GetRow($sqldatos);
    $idsiq_tipoconvenio= $datosglobales['idsiq_tipoconvenio'];
    $idsiq_institucionconvenio= $datosglobales['InstitucionConvenioId']; 

   
    if(!empty($detalle))
    {
        $id = $detalle;
         $sql1 ="Select ConvenioId,Ambito,NombreConvenio, PaisId, CodigoConvenio, FechaInicio, FechaFin, idsiq_tipoconvenio, InstitucionConvenioId, idsiq_estadoconvenio, idsiq_duracionconvenio, FechaClausulaTerminacion, TipoRenovacionId, AfiliacionArl, RCE, AfiliacionSgsss, RutaArchivo FROM Convenios  where  ConvenioId ='".$id."'";  
        
            $detalles = $db->GetAll($sql1);        
            foreach($detalles as $datos1)
            {
                $nombreconvenio                = $datos1['NombreConvenio']; 
                $pais                          = $datos1['PaisId'];
                $codigoconvenio                = $datos1['CodigoConvenio'];
                $fechainicio                   = $datos1['FechaInicio'];
                $fechafin                      = $datos1['FechaFin'];
                $idsiq_tipoconvenio            = $datos1['idsiq_tipoconvenio'];
                $InstitucionConvenioId         = $datos1['InstitucionConvenioId'];
                $idsiq_estadoconvenio          = $datos1['idsiq_estadoconvenio'];
                $idsiq_duracionconvenio        = $datos1['idsiq_duracionconvenio'];
                $fechaClausula                 = $datos1['FechaClausulaTerminacion'];
                $renovacion                    = $datos1['TipoRenovacionId'];
                $afiliacionarl                 = $datos1['AfiliacionArl'];
                $RCE                           = $datos1['RCE'];
                $afiliacionsgss                = $datos1['AfiliacionSgsss'];
                $RutaArchivo                   = $datos1['RutaArchivo'];
    			$ambito						   = $datos1['Ambito'];
                $convenioid                    = $datos1['ConvenioId'];
            }
    }
    else
    {
        if($_POST['Action_id']=='SaveData')
        {
            $nombreconvenio                 = $_POST['nombreconvenio'];
            $pais                           = $_POST['pais'];
            $codigoconvenio                 = $_POST['codigo'];
            $fechainicio                    = $_POST['fechainicio'];
            $fechafin                       = $_POST['fechafin'];
            $idsiq_tipoconvenio             = $_POST['tipoconvenio'];        
            $InstitucionConvenioId          = $_POST['institucion'];
            $idsiq_estadoconvenio           = $_POST['estado'];
            $idsiq_duracionconvenio         = $_POST['duracion'];
            $fechaClausula                  = $_POST['fechaClausula'];
            $renovacion                     = $_POST['renovacion'];
            $afiliacionarl                  = $_POST['arl'];
            if(empty($afiliacionarl)){$afiliacionarl=0;}
            $RCE                            = $_POST['rce'];
            if(empty($RCE)){$RCE=0;}
            $afiliacionsgss                 = $_POST['sgsss'];
            if(empty($afiliacionsgss)){$afiliacionsgss=0;}
            $fechamodificacion              = date("Y-m-d H:i:s");
            $institucionconvenios           = $_POST['institucionconvenio1'];
            $tipoconvenio                   = $_POST['tipoconvenio1'];
            $id                             = $_POST['id'];
            $prb                            = $_POST['prb'];
            if(empty($prb)){$prb=0;}
    		$ambitos					    = $_POST['ambito'];
            /*$nombreconvenio = limpiarCadena(filter_var($nombreconvenio,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $pais = limpiarCadena(filter_var($pais,FILTER_SANITIZE_NUMBER_INT));        
            $codigoconvenio = limpiarCadena(filter_var($codigoconvenio,FILTER_SANITIZE_NUMBER_INT));
            $idsiq_tipoconvenio = limpiarCadena(filter_var($idsiq_tipoconvenio,FILTER_SANITIZE_NUMBER_INT));        
            $InstitucionConvenioId = limpiarCadena(filter_var($InstitucionConvenioId,FILTER_SANITIZE_NUMBER_INT));        
            $idsiq_estadoconvenio = limpiarCadena(filter_var($idsiq_estadoconvenio,FILTER_SANITIZE_NUMBER_INT));        
            $idsiq_duracionconvenio = limpiarCadena(filter_var($idsiq_duracionconvenio,FILTER_SANITIZE_NUMBER_INT));        
            $renovacion = limpiarCadena(filter_var($renovacion,FILTER_SANITIZE_NUMBER_INT));
            $afiliacionarl = limpiarCadena(filter_var($afiliacionarl,FILTER_SANITIZE_NUMBER_INT));        
            $RCE = limpiarCadena(filter_var($RCE,FILTER_SANITIZE_NUMBER_INT));
            $afiliacionsgss = limpiarCadena(filter_var($afiliacionsgss,FILTER_SANITIZE_NUMBER_INT));
            $institucionconvenios = limpiarCadena(filter_var($institucionconvenios,FILTER_SANITIZE_NUMBER_INT));
            $tipoconvenio = limpiarCadena(filter_var($tipoconvenio,FILTER_SANITIZE_NUMBER_INT));
            $id = limpiarCadena(filter_var($id,FILTER_SANITIZE_NUMBER_INT));
            $prb = limpiarCadena(filter_var($prb,FILTER_SANITIZE_NUMBER_INT));
            $ambitos = limpiarCadena(filter_var($ambitos,FILTER_SANITIZE_NUMBER_INT));*/
            $slq3 = "update Convenios set NombreConvenio = '".$nombreconvenio."', Ambito = '".$ambitos."', PaisId = '".$pais."', CodigoConvenio = '".$codigoconvenio."', FechaInicio = '".$fechainicio."', FechaFin = '".$fechafin."', idsiq_tipoconvenio = '".$idsiq_tipoconvenio."', InstitucionConvenioId = '".$InstitucionConvenioId."', idsiq_estadoconvenio = '".$idsiq_estadoconvenio."', idsiq_duracionconvenio = '".$idsiq_duracionconvenio."', FechaClausulaTerminacion = '".$fechaClausula."', TipoRenovacionId = '".$renovacion."', AfiliacionArl = '".$afiliacionarl."', RCE = '".$RCE."', AfiliacionSgsss = '".$afiliacionsgss."', UsuarioModificacion = '".$user."', FechaModificacion = '".$fechamodificacion."', PRB ='".$prb."' WHERE (ConvenioId='".$id."') AND (InstitucionConvenioId='".$institucionconvenios."') AND (idsiq_tipoconvenio='".$tipoconvenio."')";
            //echo '<pre>'; echo $slq3; die;
                
            if($Consulta=$db->Execute($slq3)===true)
            {
                $val = false;
                $descrip = "No se guardaron los datos";
            }else
            {
                $val = true;
                $descrip = "El convenio fue actualizado."; 
            }
           
            $a_vectt['val']			=$val;
            $a_vectt['descrip']		=$descrip;
            echo json_encode($a_vectt);
            exit;
        }//if($_POST['Action_id']=='SaveData')
        else
        {
            echo "<script>alert('Error de ingreso a los detalles de un convenio'); location.href='MenuConvenios.php'; </script>";    
        }
    }     
    $sqlCarrera = "SELECT cc.idconveniocarrera, c.nombrecarrera, m.nombremodalidadacademica, cc.codigoestado, c.codigocarrera FROM conveniocarrera cc, carrera c, modalidadacademica m WHERE cc.ConvenioId = '".$id."' AND cc.codigocarrera = c.codigocarrera AND m.codigomodalidadacademica = c.codigomodalidadacademica AND cc.codigoestado=100  ORDER BY c.nombrecarrera ASC";
    $datosvalidacarrera = $db->GetAll($sqlCarrera);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detalles Convenio</title>
        <link rel="stylesheet" href="../educacionContinuada/css/style.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionConvenioArchivo.js"></script>
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
                 $("#fechaClausula").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
           	
                    $("#nuevoAnexo").on( "click", function (e) {	
						e.preventDefault();
					<?php if($datosvalidacarrera[0][0]==''){
								echo 'alert("el convenio no tiene programas disponibles.");';
							} else { ?>
								$( "#formAnexo" ).submit();
							<?php }
						?>
								
					}); 
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
				var selectAmbito="<?php echo $ambito; ?>";
				var tipoconvenio=parseInt("<?php echo $idsiq_tipoconvenio; ?> ");
				
				$('#ambito > option[value="'+selectAmbito+'"]').attr('selected', 'selected');
				$('#tipoconvenio > option[value="'+tipoconvenio+'"]').attr('selected', 'selected');
        	} );
			

			
			
        	/**************************************************************/
        </script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8 || tecla ==0) return true;
            patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
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
                
    </head>
    <body> 
        <div id="container">
        <center>
            <h1><font face="sans-serif">DETALLES CONVENIOS</font></h1>
        </center>
        <form  id="detalleconvenio" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="institucionconvenio1" name="institucionconvenio1" value="<?php echo $InstitucionConvenioId?>" />
        <input type="hidden" id="tipoconvenio1" name="tipoconvenio1" value="<?php echo $idsiq_tipoconvenio?>" />
        <input type="hidden" id="id_" name="id" value="<?php echo $id?>" />
            <table cellpadding="3" width="65%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Convenio:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="nombreconvenio" id="nombreconvenio" value="<?php echo $nombreconvenio; ?>" class="required" onkeypress="return val_texto(event)" size="40" />
                    </td>
                    <td>Institución:<span style="color: red;">*</span></td>
                    <td>
                    <?php
                    $sqlcontraprestaciones = "select IdContraprestacion from Contraprestaciones c where c.ConvenioId = '".$detalle."'";
                    $consultacontra = $db->GetRow($sqlcontraprestaciones);
                    
                    if($consultacontra['IdContraprestacion'])
                    {
                        $sqlInstitucion = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where InstitucionConvenioId = '".$InstitucionConvenioId."'";
                        $valoresInstitucion = $db->GetRow($sqlInstitucion);
                        ?>
                        <input type="hidden" name="institucion" id="institucion" value="<?php echo $valoresInstitucion['InstitucionConvenioId'];?>" />
                        <input type="text" name="mostrarinstitucion" id="mostrarinstitucion"  value="<?php echo $valoresInstitucion['NombreInstitucion'];?>" readonly="true"  size="40" />
                        <?php
                           
                    }else
                    {
                        ?>
                       <select name="institucion" id="institucion">
                            <?php 
                            $sqlInstitucion = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where idsiq_estadoconvenio = '1'";
                            $valoresInstitucion = $db->GetAll($sqlInstitucion);
                            foreach($valoresInstitucion as $datosInstitucion)
                            {
                                if($InstitucionConvenioId == $datosInstitucion['InstitucionConvenioId'])
                                {
                                    ?>
                                    <option selected="selected" value="<?php echo $datosInstitucion['InstitucionConvenioId']?>"><?php echo $datosInstitucion['NombreInstitucion']?></option>
                                    <?php
                                    
                                }else
                                {
                                    ?>
                                    <option value="<?php echo $datosInstitucion['InstitucionConvenioId']?>"><?php echo $datosInstitucion['NombreInstitucion']?></option>
                                    <?php   
                                }
                            }
                            ?>
                            </select>    
                            <?php
                    }
                    ?>
                    </td>
                    <td>Código</td>
                    <td><input type="text" name="codigo" id="codigo" value="<?php echo $codigoconvenio; ?>" onkeypress="return val_numero(event)" /></td>
                </tr>
                <tr>
                    <td>País:</td>
                    <td>
                        <select name="pais" id="pais">
                        <?php
                         if($Acceso['Rol']==3){$buscar = " and idpais ='".$pais."'";}
                        $sqlPais = "select idpais, nombrepais from pais where codigoestado = '100'".$buscar;
                        $valorespais = $db->execute($sqlPais);
                        foreach($valorespais as $datospais)
                        {
                            if($pais == $datospais['idpais'])
                            {
                            ?>
                            <option value="<?php echo $datospais['idpais']?>" selected="selected"><?php echo $datospais['nombrepais']?></option>
                            <?php  
                            }else
                            {
                              ?>
                            <option value="<?php echo $datospais['idpais']?>"><?php echo $datospais['nombrepais']?></option>
                            <?php  
                            }
                        }
                        ?>
                        </select>
                    </td>
                    <td>Tipo convenio:</td>
                    <td>
                        <?php
                        if($Acceso['Rol']==3){$buscar = " where idsiq_tipoconvenio ='".$idsiq_tipoconvenio."'";}
                        $sqltipoconvenio = "select idsiq_tipoconvenio, nombretipoconvenio from siq_tipoconvenio".$buscar;
                        $valorestipoconvenio = $db->execute($sqltipoconvenio);
                        ?>
                        <select name="tipoconvenio" id="tipoconvenio">
                        <option value=""></option>
                            <?php
                            foreach($valorestipoconvenio as $datostipoconvenio)
                            {
                                if($datostipoconvenio['idsiq_tipoconvenios'] == $idsiq_tipoconvenio)
                                {
                                    ?>
                                    <option value="<?php echo $datostipoconvenio['idsiq_tipoconvenio']?>" selected="selected"><?php echo $datostipoconvenio['nombretipoconvenio']?></option>
                                    <?php        
                                }else
                                {
                                    ?>
                                    <option value="<?php echo $datostipoconvenio['idsiq_tipoconvenio']?>"><?php echo $datostipoconvenio['nombretipoconvenio']?></option>
                                    <?php
                                }
                            
                            }                                                 
                          ?>
                        </select> 
                    </td>
                    <td>Duración:</td>
                    <td>
                        <?PHP 
                          $SQL="SELECT a.prorroga, a.idsiq_tipoValorPeriodicidad, s.nombre, CONCAT(a.prorroga,' ',s.nombre) AS ViewYear FROM
                                AnexoConvenios a INNER JOIN siq_tipoValorPeriodicidad  s ON s.idsiq_tipoValorPeriodicidad=a.idsiq_tipoValorPeriodicidad
                                WHERE  a.ConvenioId='".$id."' AND a.idsiq_tipoanexo=13 ORDER BY  a.IdAnexoConvenio DESC LIMIT 1";
                          $VistaAlterna=$db->GetRow($SQL);      
                        ?>
                        <select name="duracion" id="duracion">
                        <?php
                            if(!$VistaAlterna['prorroga']==null){
                            ?>
                            <option value="<?php echo $idsiq_duracionconvenio?>" ><?php echo $VistaAlterna['ViewYear']?></option>
                            <?PHP
                        }else
                        {
                            if($Acceso['Rol']==3){$buscar = " where idsiq_duracionconvenio ='".$idsiq_duracionconvenio."'";}
                            $sqlDuracion = "select idsiq_duracionconvenio, nombreduracion from siq_duracionconvenio".$buscar;
                            $valoresduracion = $db->GetAll($sqlDuracion);
                            foreach($valoresduracion as $datosduracion)
                            {
                                if($datosduracion['idsiq_duracionconvenio'] == $idsiq_duracionconvenio)
                                {
                                  ?>
                                    <option selected="selected" value="<?php echo $datosduracion['idsiq_duracionconvenio']?>"><?php echo $datosduracion['nombreduracion']?></option>
                                    <?php
                                }                                
                                else
                                {
                                    ?>
                                    <option value="<?php echo $datosduracion['idsiq_duracionconvenio']?>"><?php echo $datosduracion['nombreduracion']?></option>
                                    <?php
                                }
                            } 
                        }                     
                        ?>
                        </select>
                    </td>
                </tr>  
                <tr>
                     <td>Fecha inicio:<span style="color: red;">*</span></td>
                      <td>
                        <input type="text" name="fechainicio" id="fechainicio" value="<?php echo $fechainicio?>" />
                      </td>
                      <td>Fecha final</td>
                      <td>
                        <input type="text" name="fechafin" id="fechafin" value="<?php echo $fechafin?>" onchange="Clausula()"  />
                      </td>
                      <td>Tipo de Renovación</td>
                      <td>
                       <select name="renovacion" id="renovacion">
                        <?php 
                            if($Acceso['Rol']==3){$buscar = " where TipoRenovacionId ='".$renovacion."'";}
                            $sqlrenovacion = "select NombreTipoRenovacion, TipoRenovacionId from TipoRenovaciones".$buscar;
                            $resultadorenovacion = $db->GetAll($sqlrenovacion);
                            foreach($resultadorenovacion as $renovaciones)
                            {
                                if($renovacion == $renovaciones['TipoRenovacionId'])
                                {
                                    ?>
                                    <option value="<?php echo $renovaciones['TipoRenovacionId']; ?>" selected="selected"><?php echo $renovaciones['NombreTipoRenovacion'] ?></option>
                                    <?php                                                                        
                                }
                                else
                                {
                                    ?>
                                    <option value="<?php echo $renovaciones['TipoRenovacionId']; ?>" ><?php echo $renovaciones['NombreTipoRenovacion'] ?></option>
                                    <?php
                                }
                            }
                        ?>
                      </select>
                      </td>                               
                </tr> 
                <tr>
                    <td>Arl:</td>
                    <td>
                        <input type="text" name="arl" id="arl" value="<?php echo $afiliacionarl?>" onkeypress="return val_numero(event)"/>
                    </td>
                    <td>RCE</td>
                    <td>
                        <input type="text" name="rce" id="rce" value="<?php echo $RCE?>" onkeypress="return val_numero(event)"/>
                    </td>    
                    <td>Afiliación SGSSS(EPS)</td>
                    <td>
                        <input type="text" name="sgsss" id="sgsss" value="<?php echo $afiliacionsgss?>" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td>
                         <select name="estado" id="estado">
                        <?php
                        if($Acceso['Rol']==3){$buscar = " and idsiq_estadoconvenio ='".$idsiq_estadoconvenio."'";}
                        $sqlestado = "select idsiq_estadoconvenio, nombreestado from siq_estadoconvenio where idsiq_estadoconvenio < '5'".$buscar;
                        $resultadoestado = $db->GetAll($sqlestado);
                        foreach($resultadoestado as $estados)
                        {    
                            if($idsiq_estadoconvenio == $estados['idsiq_estadoconvenio'])
                            {
                              ?>
                               <option value="<?php echo $estados['idsiq_estadoconvenio']; ?>" selected="selected"><?php echo $estados['nombreestado']; ?></option>
                               <?php 
                            }else
                            {
                              ?>
                               <option value="<?php echo $estados['idsiq_estadoconvenio']; ?>" ><?php echo $estados['nombreestado']; ?></option>
                               <?php  
                            }    
                        }
                        ?>                      
                        </select>
                    </td>
                    <td>Fecha Cláusula Terminación</td>
                    <td >
                    <div id="TD_clausula">
                        <input type="text" name="fechaClausula" id="fechaClausula" value="<?php echo $fechaClausula?>" readonly="readonly"/>
                    </div>
                    </td>
					<td>Ámbito:</td>
					 <td>
                        <select name="ambito" id="ambito" class="required">
                        <?php
                        if($ambito == '1'){$uno = "selected='selected'";}
                        if($ambito == '2'){$dos = "selected='selected'";}                        
                        ?>
                        <option value="1" <?php echo $uno;?>>Internacional</option>
                        <option value="2" <?php echo $dos;?>>Nacional</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <center>
            <table width="600" id="botones">
            <tr> <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
            <td><input type="button" value="Guardar" onclick="validarDatosDetalle('#detalleconvenio');" /></td><?php }?>
            <td align='right'><input type="button" value="Regresar" onclick="RegresarConvenio()" /></td>
            </tr>
            </table>
            </center>  
        </form>
        <table cellpadding="3" width="40%" border="0" align="center">        
        <tr>
            <td colspan="2">
                <hr />
            </td>
        </tr> 
        <tr>
        <?php
            if($RutaArchivo != Null)
            {
                ?>
                    <td>Archivo de Soporte</td>
                    <td><a href='<?php echo $RutaArchivo?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a></td>
                <?php
            }else
            {
                if($Acceso['Rol']!=3){                
                ?>
                    <td>
                    <form enctype="multipart/form-data" class="formulario" id="formulario">
                        <input type="hidden" id="id" name="id" value="<?php echo $id?>" />
                        <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                        <input type="hidden" id="usuario" name="usuario" value="<?php echo $user ?>" />                    
                        <label>Subir un archivo</label>
                        <input name="archivo" type="file" id="archivo" accept=".pdf" />
                        <input type="button" value="Subir Archivo" />
                    </form>
                    <!--div para visualizar mensajes-->
                    <div class="messages"></div><br /><br />
                    <!--div para visualizar en el caso de imagen-->
                    <div class="showImage"></div>
                    </td>
                <?php
                }                
            }
        ?>
        </tr>
        <tr>
            <td colspan="2">
            <hr />
            </td>
        </tr>
        </table>
        </form>
        <table cellpadding="3" width="60%" border="0" align="center">
            <input type="hidden" id="txtTipoConvenio" name="txtTipoConvenio" value="<?php if(isset($idsiq_tipoconvenio)) echo $idsiq_tipoconvenio; ?>" />
            <tr id="dvConvenio">
                <td colspan="6">
                    <div> <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                        <form id="nuevaContraprestacion" action="../convenio/NuevaContraprestacion.php" method="post" enctype="multipart/form-data" >
                            <input type="submit" name="nuevacontraprestacion" id="nuevacontraprestacion" value="Nueva Contraprestación" />
                            <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $id; ?>" />
                        </form>
                        <?php }?>
                    </div>                    
                    <fieldset>
                        <table cellpadding="3" border="0" width="920px">
                            <tr>
                                <td colspan="7"><center><strong><font face="sans-serif" color='#8AB200'>CONTRAPRESTACIONES</font></strong></center></td>
                            </tr>
                            <tr>
                                <td colspan="7"><hr /></td>
                            </tr>
                            <tr>
                                <!-- <td><strong>Ubicacion</strong></td>-->
                                <td><strong>Tipo Contraprestación</strong></td>
                                <td><strong>Tipo Practicante</strong></td>
                                <td><strong>Valor pago</strong></td>
                                <td><strong>Estado</strong></td>
                                <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                <td><strong>Detalles</strong></td>
                                <?php }?>
                            </tr>
                            <?php 
                            $sqlContraprestacion = "SELECT c.IdContraprestacion, u.NombreUbicacion, sc.nombretipocontraprestacion, tp.NombrePracticante, c.idTipoPagoContraprestacion,
                            	c.ValorContraprestacion, e.nombreestado 
                                FROM Contraprestaciones c, siq_contraprestacion sc, TipoPracticantes tp, UbicacionInstituciones u, estado e 
                                WHERE sc.idsiq_contraprestacion = c.idsiq_contraprestacion AND tp.IdTipoPracticante = c.IdTipoPracticante 
                                AND u.IdUbicacionInstitucion = c.IdUbicacionInstitucion AND c.ConvenioId = '".$id."' 
                                AND c.codigoestado = e.codigoestado ORDER BY c.codigoestado";    
                            $valoresContra = $db->GetAll($sqlContraprestacion);
                            foreach($valoresContra as $datosContra)
                            {
                            ?>
                            <tr>
                                <!-- <td>Sede <?php echo $datosContra['NombreUbicacion']?></td>-->
                                <td><?php echo $datosContra['nombretipocontraprestacion']?></td>
                                <td><?php echo $datosContra['NombrePracticante']?></td>
                                <?php
                                switch($datosContra['idTipoPagoContraprestacion'])
                                {
                                    case'1':{//porcentaje
                                        ?><td><?php echo (int)$datosContra['ValorContraprestacion']?> %</td><?php
                                    }break;
                                    case'2':{//Creditos
                                        ?><td><?php echo (int)$datosContra['ValorContraprestacion']?> Cr.</td><?php
                                    }break;
                                    case'3':{//porcentaje + seguridad social
                                        ?><td><?php echo (int)$datosContra['ValorContraprestacion']?> % + Ss.</td><?php
                                    }break;
                                    case'4':{//Valor acordado
                                        ?><td>$ <?php echo (int)$datosContra['ValorContraprestacion']?></td><?php
                                    }break;
                                    case'5':{//porcentaje + creditos
                                        ?><td><?php echo (int)$datosContra['ValorContraprestacion']?> % (T y Cr.)</td><?php
                                    }break;
                                    
                                }
                                ?>
                                <td><?php echo $datosContra['nombreestado']?></td>
                                <td valign="top">
                                    <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                    <form action="DetallesContraprestacion.php" method="post">
                                        <input type="hidden" name="Detalle" id="Detalle" value="<?php echo $datosContra['IdContraprestacion']?>" />
                                        <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $id?>" />
                                        <input type="image" src="../mgi/images/file_search.png" width="20">
                                    </form>
                                    <?php }?>
                                </td>
                            </tr>        
                            <?php
                            }
                            ?>
                        </table>
                    </fieldset>                        
                </td>
            </tr>             
            <tr>
                <td colspan="6">
                        <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                        <form action="NuevaCarreraConvenio.php" method="post">
                            <input type="submit" id="nuevacarrera" value="Nuevo Programa Académico" />
                            <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $id; ?>" />
                            <input type="hidden" id="txtTipoConvenio" name="txtTipoConvenio" value="<?php if(isset($idsiq_tipoconvenio)) echo $idsiq_tipoconvenio; ?>" />
                        </form>
                        <?php }?>
                        <fieldset>
                            <table cellpadding="3" border="0" width="920px">
                               <tr>
                                    <td colspan="7"><center><strong><font face="sans-serif" color='#8AB200'>Programas Académicos</font></strong></center></td>
                                </tr>
                                <tr>
                                    <td colspan="7"><hr /></td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre Programa Académico</strong></td>
                                    <td><strong>Modalidad Académica</strong></td>
                                    <td><strong>Estado</strong></td>
                                    <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                    <td><strong>Detalles</strong></td>
                                    <?php }?>
                                </tr>
                                <?php
                                $sqlcarrera = "SELECT c.nombrecarrera, ma.nombremodalidadacademica, cc.codigoestado, c.codigocarrera, cc.idconveniocarrera FROM conveniocarrera cc INNER JOIN carrera c ON c.codigocarrera = cc.codigocarrera INNER JOIN modalidadacademica ma ON ma.codigomodalidadacademica = c.codigomodalidadacademica WHERE cc.ConvenioId = '".$id."' and cc.codigoestado = '100'";
                                    $valoresCarrera = $db->GetAll($sqlcarrera); 
                                    foreach($valoresCarrera as $datosCarrera)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $datosCarrera['nombrecarrera']?></td>
                                            <td><?php echo $datosCarrera['nombremodalidadacademica']?></td>
                                            <td><?php
                                            switch ($datosCarrera['codigoestado']){
                                                case 100:
                                                echo  'Activo';
                                                break;
                                                case 200:
                                                echo  'Inactivo';
                                                break; 
                                            }
                                              ?></td>
                                            <td valign="top" align="center">
                                                <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                                <form action="DetallesCarrera.php" method="post" style="display:inline-block">
                                                    <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $id;?>" />
                                                    <input type="hidden" name="Detalle" id="Detalle" value="<?php echo $datosCarrera['codigocarrera']?>" />
                                                    <input type="hidden" name="idconveniocarrera" id="idconveniocarrera" value="<?php echo $datosCarrera['idconveniocarrera']?>" />
                                                    <input type="image" src="../mgi/images/file_search.png" width="20">
                                                </form>
												<button class="soft image eliminarCarrera" style="display:inline-block" type="button" id="idconveniocarrera_<?php echo $datosCarrera['idconveniocarrera']; ?>" title="Eliminar Programa Académico" ><img src="../mgi/images/delete.png" alt="Eliminar Programa Académico" width="20"/></button>
                                                 <?php }?>
                                            </td>
                                        </tr>        
                                        <?php
                                    }
                                ?>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                     <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                        <form action="NuevoAnexoConvenio.php" id="formAnexo" method="post">
                            <input type="button" id="nuevoAnexo" value="Anexos del Convenio" />
                            <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $id; ?>" /> 
							<input type="hidden" name="idtipoconvenio" id="idtipoconvenio" value="<?php echo $idsiq_tipoconvenio; ?>" />
							<input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $idsiq_institucionconvenio; ?>" />
                        </form>
                        <?php }?>
                        <fieldset>
                            <table cellpadding="3" border="0" width="920px">
                                <tr>
                                    <td colspan="9"><center><strong><font face="sans-serif" color='#8AB200'>ANEXOS</font></strong></center></td>
                                </tr>
                                <tr>
                                    <td colspan="9"><hr /></td>
                                </tr>
                                <tr>
                                    <td><strong>#</strong></td>
                                    <td><strong>Tipo</strong></td>
                                    <td><strong>Consecutivo</strong></td>
                                    <td><strong>Programa Académico</strong></td>
                                    <td><strong>Total Cupos</strong></td>
                                    <td><strong>Semestre</strong></td>
                                    <td><strong>Estado</strong></td>
                                    <td><strong>Ruta Archivo</strong></td>
                                    <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                    <td><strong>Detalles</strong></td>
                                    <?php }?>
                                </tr>
                                <tr><td colspan="9"><hr style="color: brown;" /></td></tr>
                                <?php 
                                    
                                         $sqlanexos = "SELECT
                                                        	a.IdAnexoConvenio,
                                                        	t.nombretipoanexo,
                                                        	a.TotalCupos,
                                                        	a.RutaArchivo,
                                                            a.Consecutivo
                                                        FROM
                                                        	AnexoConvenios a
                                                        INNER JOIN siq_tipoanexo t ON t.idsiq_tipoanexo = a.idsiq_tipoanexo
                                                        WHERE
                                                        	a.ConvenioId = '".$id."'
                                                        AND a.codigoestado = 100";
                                                        
                                    $valoresanexos = $db->GetAll($sqlanexos);
                                    $C_Anexos = array();
                                    for($i=0;$i<count($valoresanexos);$i++){
                                        $C_Anexos['id'][]              = $valoresanexos[$i]['IdAnexoConvenio'];
                                        $C_Anexos['nombretipoanexo'][] = $valoresanexos[$i]['nombretipoanexo'];
                                        $C_Anexos['TotalCupos'][]      = $valoresanexos[$i]['TotalCupos'];
                                        $C_Anexos['RutaArchivo'][]     = $valoresanexos[$i]['RutaArchivo'];
                                        $C_Anexos['Consecutivo'][]     = $valoresanexos[$i]['Consecutivo'];
                                        $C_Anexos['Semestre'][]        = $valoresanexos[$i]['Semestre'];
                                         $SQL='SELECT
                                                	ca.CarreraAnexoConvenioId,
                                                	c.nombrecarrera,
                                                	c.codigocarrera,
                                                	m.codigomodalidadacademica,
                                                	m.nombremodalidadacademica
                                                FROM
                                                	CarreraAnexoConvenio ca
                                                INNER JOIN carrera c ON c.codigocarrera = ca.CodigoCarrera
                                                INNER JOIN modalidadacademica m ON m.codigomodalidadacademica = c.codigomodalidadacademica
                                                WHERE
                                                	ca.IdAnexoConvenio ="'.$valoresanexos[$i]['IdAnexoConvenio'].'" 
                                                AND ca.CodigoEstado = 100';
                                            //echo $SQL."<br>";    
                                           $CarreraAnexo=$db->GetAll($SQL);
                                           
                                         $C_Anexos['Data'][] = $CarreraAnexo;       
                                    }//for
                                    //echo '<pre>';print_r($C_Anexos);
                                    for($j=0;$j<count($C_Anexos['id']);$j++){
                                    ?>
                                    <tr>
                                        <td><?PHP echo $j+1?></td>
                                        <td><?php echo $C_Anexos['nombretipoanexo'][$j];?></td>
                                        <td><center><?php echo $C_Anexos['Consecutivo'][$j];?></center></td>
                                        <td>
                                            <ul>
                                            <?PHP 
                                            for($x=0;$x<count($C_Anexos['Data'][$j]);$x++){
                                                ?>
                                                <li><?PHP echo $C_Anexos['Data'][$j][$x]['nombrecarrera']?></li>
                                                <?PHP
                                            }///for
                                            ?>  
                                            </ul>  
                                        </td>
                                        <td><?php echo $C_Anexos['TotalCupos'][$j]?></td>
                                        <td><?php echo $C_Anexos['Semestre'][$j]?></td>
                                        <td>Activo</td>
                                        <td><a href='<?php echo $C_Anexos['RutaArchivo'][$j]?>' target="_blank"> <img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a></td>
                                       <td align="center">
                                            <?php if($Acceso['Rol']!=3){//Administrador de facultad ?>
                                            <form action="DetalleAnexoConvenio.php" method="post">
												<input type="hidden" name="Detalle" id="Detalle" value="1" />
                                                <input type="hidden" name="convenio" id="convenio" value="<?php echo $C_Anexos['id'][$j]?>" />
												<input type="hidden" name="tipoAnexo" id="tipoAnexo" value="<?php echo $C_Anexos['nombretipoanexo'][$j]?>" />
                                                <input type="image" src="../mgi/images/file_search.png" width="20">
                                            </form>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr><td colspan="9"><hr style="color: brown;" /></td></tr>        
                                    <?php
                                    }
                                ?>

               </table>
               </fieldset>                 
      </div>     
	  <script type="text/javascript">
	  $(".eliminarCarrera").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("idconveniocarrera_",""); 
			
			$.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: 'id='+idgrupo+'&action=inactivateCarrera',
                    success:function(data){ 
                        if (data.success == true){
                            location.reload();
                        }
                },
                    error: function(data,error){}
            }); 
           
        });
	  </script>
  </body>
</html>
<?php
function validainstituciones($db, $id)
{
    //valida si existen contraprestaciones creadas
    $contraprestacion = "select IdContraprestacion from Contraprestaciones where ConvenioId ='".$id."'";
    $resultcontra = $db->GetRow($contraprestacion);
    
    //si no exiete inguna contrapresacion entra a validar si existen carreras o programas  creadas
    if($resultcontra['IdContraprestacion']== null)
    {
        //valida si el convenio tiene carreras asigandas actualmente.
        $carreras = "select idconveniocarrera from conveniocarrera where ConvenioId ='".$id."'";
        $resultcarrera = $db->GetRow($carreras);
        
        //si no existen carreras creadas para el convenio entra a mostrar la lista de instituciones para posibles cambios.
        if($resultcontra['IdContraprestacion']== null)
        {
            $valida = true;
            
        }else
        {
            $valida = false;
        }
    }else
    {
        $valida = false;
    }
    return $valida;
}

?>