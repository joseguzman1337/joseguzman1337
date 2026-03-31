<?php 
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $datosusuario = $db->GetRow($sqlS);
    $user = $datosusuario['idusuario'];
    $id = $_POST['convenio'];
    if(!isset ($id))
    {
        if(!isset($_POST['idconvenio']))
        {
            echo "<script>alert('Error de ingreso detalles anexos'); location.href='ConveniosActivos.php'; </script>";    
        }   
    }
    $sql1="SELECT a.IdAnexoConvenio, a.idsiq_tipoanexo, a.TotalCupos, a.ConvenioId, a.codigoestado, a.Consecutivo, a.FechaInicio, a.FechaFinal, a.prorroga, a.Observacion, a.RutaArchivo, a.idsiq_tipoValorPeriodicidad FROM AnexoConvenios a WHERE IdAnexoConvenio = '".$id."'";  
    $detalles = $db->GetRow($sql1);

    $IdAnexoConvenio             = $detalles['IdAnexoConvenio'];
    $idsiq_tipoanexo             = $detalles['idsiq_tipoanexo']; 
    $idsiq_convenio              = $detalles['ConvenioId'];
    $estado                      = $detalles['codigoestado'];
    $Consecutivo                 = $detalles['Consecutivo'];
    $RutaArchivoAnexo            = $detalles['RutaArchivo'];
    $Observacion                 = $detalles['Observacion'];
    $prorroga                    = $detalles['prorroga'];  
    $FechaInicio                 = $detalles['FechaInicio'];  
    $FechaFinal                  = $detalles['FechaFinal'];
    $idsiq_tipoValorPeriosidad   = $detalles['idsiq_tipoValorPeriodicidad'];
    $TotalCupos                  = $detalles['TotalCupos'];

if($idsiq_tipoanexo =='13')
{
    $sqlnombre = "select s.nombre from siq_tipoValorPeriodicidad s where s.idsiq_tipoValorPeriodicidad = '".$idsiq_tipoValorPeriosidad."'";
    $nombrevalor = $db->GetRow($sqlnombre);
    $nombre = $nombrevalor;    
}

$sqlubicacionescupos = "SELECT c.IdUbicacionInstitucionCupos, c.NumeroCupos, c.NumeroCuposAsignados, c.codigocarrera, cc.nombrecarrera, c.codigoestado FROM UbicacionInstitucionCupos c INNER JOIN carrera cc ON cc.codigocarrera = c.codigocarrera WHERE IdAnexoConvenio = '".$id."';";
$cuposubicaciones = $db->GetAll($sqlubicacionescupos);
 
    
$SQL='SELECT ca.CarreraAnexoConvenioId, c.nombrecarrera, c.codigocarrera, m.codigomodalidadacademica, m.nombremodalidadacademica FROM CarreraAnexoConvenio ca INNER JOIN carrera c ON c.codigocarrera = ca.CodigoCarrera INNER JOIN modalidadacademica m ON m.codigomodalidadacademica = c.codigomodalidadacademica WHERE ca.IdAnexoConvenio ="'.$id.'" AND ca.CodigoEstado = 100';
$CarreraData= $db->GetAll($SQL);

$ModalidadName = $CarreraData[0]['nombremodalidadacademica']; 
$codigocarrera = $CarreraData[0]['codigocarrera'];
$CarreraName='<ul>';

for($i=0;$i<count($CarreraData);$i++){
    $CarreraName=$CarreraName.'<li>'.$CarreraData[$i]['nombrecarrera'].'</li>';
}//for 
$CarreraName=$CarreraName.'</ul>';
         
switch($_REQUEST['Action_id']){
    case 'SaveData':
    {
        $TipoAnexo          = $_POST['TipoAnexo'];
        switch($TipoAnexo)
        {
            case '1':
            {
                $estado             = $_POST['estado'];
                $IdAnexoConvenio    = $_POST['IdAnexoConvenio'];                
                $semestre           = $_POST['semestre'];
                $fecha              = date("Y-m-d H:i:s");
                $Consecutivo        = $_POST['consecutivo'];
                $institucion        = $_POST['nombreinstitucion'];
                $cupoinstitucion    = $_POST['cupoinstitucion'];
                $estadoinstitucion  = $_POST['estadoinstitucion'];
                
                foreach($semestre as $numeros)
                {
                    $sqlconsulta = "select SemestreAnexoConvenioId, CodigoEstado from SemestreAnexoConvenios where Semestre = '".$numeros."' and AnexoConvenioId= '".$IdAnexoConvenio."';";
                    $consulta = $db->GetRow($sqlconsulta);
                    if($consulta['CodigoEstado'])
                    {
                        if($consulta['CodigoEstado']== '200')
                        {
                            $sqlupdate = "update SemestreAnexoConvenios set CodigoEstado='100' where (AnexoConvenioId= '".$IdAnexoConvenio."')";
                            $update = $db->execute($sqlupdate);    
                        }
                    }else
                    {
                        $sqlinsert = "INSERT INTO SemestreAnexoConvenios (AnexoConvenioId, Semestre, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion, CodigoEstado) VALUES ( '".$IdAnexoConvenio."', '".$numeros."', '".$user."', '".$fecha."', '".$user."', '".$fecha."', '100');";
                        $result = $db->execute($sqlinsert);
                    }
                }
                $t=0;  
                $totalcupos = 0;              
                foreach($cupoinstitucion as $datos)
                {
                    $updateubicacioncupos = "update UbicacionInstitucionCupos set NumeroCupos ='".$datos."' where IdAnexoConvenio = '".$IdAnexoConvenio."' and codigocarrera = '".$institucion[$t]."'";
                    $actualizar = $db->execute($updateubicacioncupos);
                    $t++;
                    $totalcupos = $totalcupos + $datos;
                }                
                
                $slq3="update AnexoConvenios set codigoestado = '".$estado."', FechaUltimaModificacion = '".$fecha."', UsuarioUltimaModificacion = '".$user."', Consecutivo ='".$Consecutivo."', TotalCupos = '".$totalcupos."' where IdAnexoConvenio = '".$IdAnexoConvenio."'";
                if($Consulta=$db->Execute($slq3)===true)
                {
                   $descrip = "No se guardaron los datos"; 
                }else
                {
                     $descrip = "El anexo-convenio fue actualizado.";
                }
                
              
                $numerodesactivar = "'".implode("', '", $semestre)."'";
                $sqlupdate = "select SemestreAnexoConvenioId from  SemestreAnexoConvenios where AnexoConvenioId= '".$IdAnexoConvenio."' and Semestre not in (".$numerodesactivar.")";
                $consultadesactivar = $db->GetAll($sqlupdate);
                foreach($consultadesactivar as $desactivar)
                {
                    $sqlupdate = "update SemestreAnexoConvenios set CodigoEstado='200' where (SemestreAnexoConvenioId= '".$desactivar['SemestreAnexoConvenioId']."')";            
                    $update = $db->execute($sqlupdate);
                } 
            }break;
            case '13'://prorroga
            
            {
                $observacion        = $_POST['Observacion'];
                $Consecutivo        = $_POST['consecutivo'];
                $IdAnexoConvenio    = $_POST['IdAnexoConvenio'];
                $fecha              = date("Y-m-d H:i:s");
                
                $slq3="update AnexoConvenios set Consecutivo='".$Consecutivo."', Observacion= '".$observacion."', FechaUltimaModificacion = '".$fecha."', UsuarioUltimaModificacion = '".$user."' where IdAnexoConvenio = '".$IdAnexoConvenio."'";
                $update = $db->execute($slq3);
                $descrip = "El anexo-convenio fue actualizado.";
                
            }break;
            case '14':
            {
               
                
            }break;
        }//switch
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		=$descrip;
        echo json_encode($a_vectt);
        exit;
    }break;//if($_POST['Action_id']=='SaveData')
}      
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detalle Anexo convenio</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script>
        function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
    </head>
    <body> 
        <div id="container">
            <center>
                <h1>DETALLE ANEXO CONVENIO</h1>
            </center>
            <form  id="detalleanexo" method="post" enctype="multipart/form-data" >
                <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
                <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $idsiq_convenio?>" />
                <input type="hidden" id="IdAnexoConvenio" name="IdAnexoConvenio" value="<?php echo $IdAnexoConvenio?>" />
                <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="<?php echo $idsiq_tipoanexo?>" />
                <table cellpadding="3" width="60%" border="0" align="center">
                    <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                    <?php 
                        $sql = "select NombreConvenio from Convenios where ConvenioId = '".$idsiq_convenio."'";
                        $Consulta=$db->GetRow($sql);
                    ?>
                    <center><strong><font color='#8AB200'><?php echo $Consulta['NombreConvenio']; ?></font></strong></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <?php
                switch($idsiq_tipoanexo)
                {
                    case '1':
                    {
                    ?>
                    <tr>
                        <td>Modalidad Academica<span style="color: red;">*</span></td>
                        <td><?PHP echo $ModalidadName;?></td>
                        <td>Carrera<span style="color: red;">*</span></td>
                        <td id="Td_Carreras">
                        <?PHP echo $CarreraName?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tipo de Anexo:
                        </td>
                        <?PHP 
                        $sqlTipoanexo ="select idsiq_tipoanexo, nombretipoanexo from siq_tipoanexo where idsiq_tipoanexo='".$idsiq_tipoanexo."'";
                        $valortipoanexo = $db->GetRow($sqlTipoanexo);
                        ?>
                        <td>
                        <?PHP echo $valortipoanexo['nombretipoanexo']?></td>
						<td>Consecutivo
                        </td>
                        <td><input type="text" id="consecutivo" name="consecutivo" value="<?php echo $Consecutivo; ?>" size="5" onkeypress="return val_numero(event)" /></td>
                    </tr>
                    <tr>
                        <td>Total cupos:</td><td><?php echo $TotalCupos;?></td>
                    </tr>
                    <tr>
                        <td colspan="4"> <center>
                            <table>
                                <tr>
                                    <td><strong><center>Institucion</center></strong></td><td><strong><center>Cupos</center></strong></td><td><strong>Estado</strong></td>
                                </tr>
                        <?php 
                        $c=0;
                        foreach($cuposubicaciones as $ubicacioncupos)
                        {
                           echo "<tr><td><input type='hidden' name='nombreinstitucion[".$c."]' id='".$c."' value='".$ubicacioncupos['codigocarrera']."'/>".$ubicacioncupos['nombrecarrera']."</td>                               <td><input type='text' id='".$c."' name='cupoinstitucion[".$c."]' value='".$ubicacioncupos['NumeroCupos']."' size='6' /></td><td>";
                            if($ubicacioncupos['codigoestado']== '100')
                            {
                                echo "Activo";
                            }else
                            {
                                echo "Inactivo";
                            }
                            echo "</td><tr>";
                           $c++;
                        }
                        ?>
                            </table></center>
                        </td>
                    </tr>
                    <tr>
                        <td>Semestres</td>
                        <td>
                        <?php
                        $sqlsemestre = "Select MAX(cantidadsemestresplanestudio) as maximo from planestudio where Codigocarrera='".$codigocarrera."'";
                        $maxsemestrecarrera = $db->GetRow($sqlsemestre);
                          
                        $Lsemestre = "SELECT semestre, CodigoEstado FROM SemestreAnexoConvenios where AnexoConvenioId = '".$id."';";
                        $semestreL = $db->GetAll($Lsemestre);
                        
                        foreach($semestreL as $numerosem)
                        {
                            if($numerosem['CodigoEstado']=='100')
                            {
                                $listas[] =  $numerosem['semestre'];    
                            }
                        }
                        
                        for($i=1; $i<=$maxsemestrecarrera['maximo'];$i++)
                        {
                            if(in_array($i,$listas))
                            {
                            ?>
                                <input type="checkbox" checked="true" id="semestre<?php echo $i;?>" name="semestre[]" value="<?php echo $i; ?>" /><?php echo $i ?>
                            <?php  
                            }
                            else
                            {
                            ?>
                            <input type="checkbox" id="semestre<?php echo $i;?>" name="semestre[]" value="<?php echo $i; ?>" /><?php echo $i; ?>
                            <?php   
                            }
                        }
                        ?>
                        </td>
                        <td align="right">Estado:</td>
                        <td>
                        <?php
                        if($estado == '100'){
                          ?>
                                <select name="estado" id="estado">
                                <option value="100" selected="selected">Activo</option>
                                <option value="200">Inactivo</option>
                                </select>
                            <?php  
                        }else{
                          ?>
                                <select name="estado" id="estado">
                                <option value="200" selected="selected">Inactivo</option>
                                <option value="100">Activo</option>
                                </select>
                                <?php   
                        }
                            ?>
                        </td>
                    </tr>               
                    <tr>
                        <td colspan="6">
                            <hr />
                        </td>
                    </tr>
                    <tr>
						<?php 
                        if (empty($cupos))
                        {
                            $cupos=0;
                        }
                        if($idsiq_tipoanexo == '1')
                        {
                          ?>
                          <td>Actualmente tiene   <?php echo $cupos; ?> cupos definidos 
                          <?php
                          if($cupos!=0)
                          {
                            ?>
                          , consulte detalle 
                          <?php echo "<a href='files/".$rutaArchivo."'><img src='../mgi/images/file_document.png' width='50' height='37' border='0'/></a>"?>
                          </td>
                          <?php  
                          }                           
                        } 
                        ?>  
					
					</tr>   
                    <?php 
                    }break;
                    //prorroga
                    case '13':
                    {
                     ?>
                     <tr>
                        <td>
                            Tipo de Anexo:
                        </td>
                        <?PHP 
                        $sqlTipoanexo ="select idsiq_tipoanexo, nombretipoanexo from siq_tipoanexo where idsiq_tipoanexo='".$idsiq_tipoanexo."'";
                        $valortipoanexo = $db->execute($sqlTipoanexo);
                        ?>
                        <td><?PHP echo $valortipoanexo->fields['nombretipoanexo']?></td>
						<td>Consecutivo
                        </td>
                        <td><input type="text" id="consecutivo" name="consecutivo" value="<?php echo $Consecutivo; ?>" size="5" onkeypress="return val_numero(event)" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final:</td><td><?php echo $FechaFinal;?></td>
                        <td>Prorroga</td><td><?php echo $prorroga.' '.$nombre;?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                        <fieldset>
                            <legend>Observación</legend>
                            <table style="width: 100%;">
                            <tbody>
                            <tr>
                            <td>
                            <textarea id="Observacion" onkeypress="return val_texto(event)" name="Observacion" cols="70" rows="50"><?php echo $Observacion;?></textarea>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                        </fieldset>
                        </td>
                    </tr>
                     <?php   
                    }break;
                    //adicion o midificacion
                    case '14':
                    {
                     ?>
                     <tr>
                        <td>
                            Tipo de Anexo:
                        </td>
                        <?PHP 
                        $sqlTipoanexo ="select idsiq_tipoanexo, nombretipoanexo from siq_tipoanexo where idsiq_tipoanexo='".$idsiq_tipoanexo."'";
                        $valortipoanexo = $db->execute($sqlTipoanexo);
                        ?>
                        <td><?PHP echo $valortipoanexo->fields['nombretipoanexo']?></td>
						<td>Consecutivo
                        </td>
                        <td><input type="text" id="consecutivo" name="consecutivo" value="<?php echo $Consecutivo; ?>" size="5" onkeypress="return val_numero(event)" /></td>
                    </tr>
                    <tr>
                        <td>Fecha incial:</td>
                        <td><?php echo $FechaInicio;?></td>
                    </tr>
                     <?php   
                    }break;
                } 
                ?>
                    <tr>
                        <td>Archivo:</td>
                        <td>
                            <a href='<?php echo $RutaArchivoAnexo?>'  target="_blank">
                            <img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt="" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                    <td>
                    <input type="button" value="Guardar" onclick="validarDetalleAnexo('#detalleanexo');" /></td>
                    </tr>
                </table>
            </form>    
                    <table cellpadding="3" width="60%" border="0" align="center">
                     <td><form action="DetalleConvenio.php" method="post" id="volver">
                     <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $idsiq_convenio; ?>" />
                     <input type="submit" value="Regresar"/></form></td>
                    </tr>
                    </table>
        </div>
    <?php
       
    ?>
  </body>
</html>
