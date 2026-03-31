<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $id = $_POST['id'];
    
    $SQl='SELECT sc.SolicitudConvenioId, sc.NumeroActa, sc.ConvenioProcesoId, si.InstitucionConvenioId FROM SolicitudConvenios sc INNER JOIN  SolicitudInstituciones si ON si .SolicitudConvenioId=sc.SolicitudConvenioId WHERE sc.SolicitudConvenioId = "'.$id.'" AND sc.CodigoEstado = 100';
    //echo $SQl;
    if($Info=&$db->Execute($SQl)===false){
     echo 'error del sistema.....';
     die;
    }       
    
    $institucion = $Info->fields['InstitucionConvenioId'];
    
    $SQl='SELECT ConvenioProcesoId, Nombre FROM ConvenioProceso WHERE CodigoEstado = 100 AND ConvenioProcesoId IN (6, 7)';         
    if($Firmas=&$db->GetAll($SQl)===false){
     echo 'error del sistema.....';
     die;
    }     
?>
<div id="DivCarga">
<style>
    th,td{
        border: white 1px solid;
    }
</style>
<link rel="stylesheet" href="../EspacioFisico/css/jquery.clockpick.1.2.9.css" type="text/css" /> 
<link rel="stylesheet" href="../EspacioFisico/css/Styleventana.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="../EspacioFisico/asignacionSalones/css/jquery.datetimepicker.css"/>

        <link rel="stylesheet" href="../mgi/../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" />

<script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script> 
<script type="text/javascript" language="javascript" src="../mgi/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
<script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>  
<script type="text/javascript" src="../EspacioFisico/asignacionSalones/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="../EspacioFisico/asignacionSalones/calendario3/wdCalendar/EventoSolicitud.js"></script>  
<script type="text/javascript" src="../mgi/js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
<script>
    function CambiarEstadoProceso(id,valor,institucion){
        if(valor==6 || valor == 7 || valor == 3 ){
            var texto = 'Desea Actualizar el Proceso de Solicitud.';
        }
        
        if(confirm(texto)){
            $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'procesofirmas_class.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'CambiarEstadoProceso',id:id,valor:valor,institucion:institucion}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    				if(data.val===false){
    				    alert(data.descrip);
                        return false;
    				}else{
    				    if(valor ==6){
                         alert('La Solicitud pasa a Firma de Rectoria.');
                         }
                         if(valor ==7){
                         alert('La Solicitud pasa a Firma de Contraparte.');
                         }
                         location.href="ConveniosEnTramite.php";
                       }else{
                         alert(data.descrip);
                         Recarga(id);
                       } 
    				}				
   		       } 
        	}); //AJAX
        }
    }//function CambiarEstadoProceso
    function Recarga(id){
        $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'procesofirmas.php',
    		   async: false,
    		   dataType: 'html',
    		   data:({actionID: '',id:id}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    			  $('#DivCarga').html(data);				
    		   } 
    	}); //AJAX
    }//function Recarga
    function descargarAnexos(id,url){
        window.open('descargaranexoprocesofirmas.php?id='+id,'descargar anexo');
    }//function descargarAnexos
    function descargarPdf(id){
        window.open('VistaPropuestaPdf.php?id='+id,'descargar anexo');
    }//function descargarAnexos
    function regresarmenu()
    {
        location.href="ConveniosEnTramite.php";
    }
</script>
<fieldset>
    <legend>Seguimiento Solicitud</legend>
    <div style="overflow-y: scroll; width: 900px; height: 200px;">
    <table>
        <tr>
            <th>Etapa</th>
            <th>Usuario</th>
            <th>Fecha Solicitud</th>
        </tr>
    <?php
        $sqletapas = "select c.Nombre, u.usuario, l.FechaCreacion from LogSolicitudConvenios l INNER JOIN ConvenioProceso c ON c.ConvenioProcesoId = l.ConvenioProcesoId INNER JOIN usuario u ON u.idusuario = l.UsuarioCreacion where l.SolicitudConvenioId = '".$id."' order by FechaCreacion DESC";
        //echo $sqletapas;
        $listaetapas = $db->Getall($sqletapas);
        foreach($listaetapas as $etapas)
        {
         ?>
            <tr>
                <td><?php echo $etapas['Nombre'];?></td>
                <td><?php echo $etapas['usuario'];?></td>
                <td><?php echo $etapas['FechaCreacion'];?></td>
            </tr>
         <?php   
        }
     ?>
    </table>
    </div>
</fieldset>
<fieldset>
    <legend>Proceso de Firmas</legend>
    <table>
        <thead>
            <tr>
                <th>Acta N&deg;</th>
                <th><?PHP echo $Info->fields['NumeroActa']?></th>
                <th style="text-align: left;">
                <img width="50" border="0" height="37" alt="" src="../mgi/images/file_document.png" style="cursor: pointer;" title="Descargar Documento" onclick="descargarPdf('<?PHP echo $id?>')" />
                </th>
            </tr>
            <tr>
                <th colspan="3">Anexos</th>
            </tr>
            <?PHP 
              $SQL='SELECT
                    	s.SolicitudAnexoId,
                    	s.Nombre,
                    	s.Url,
                    	s.TipoAnexoId,
                    	t.Nombre As tipo
                    FROM
                    	SolicitudAnexos s
                    INNER JOIN TipoAnexo t ON t.TipoAnexoId = s.TipoAnexoId
                    WHERE
                    	s.SolicitudConvenioId ="'.$id.'"
                    AND s.CodigoEstado = 100';
                    
              if($Anexos=&$db->GetAll($SQL)===false){  
                echo 'Error en el Sistema....';
                die;
              } 
            
            for($x=0;$x<count($Anexos);$x++){
                ?>
                <tr>
                    <td colspan="2"><?PHP echo $Anexos[$x]['tipo']?></td>
                    <td style="text-align: center;">
                        <img width="25" border="0"  alt="" src="../mgi/images/folder_apollon.png" style="cursor: pointer;" title="Descargar <?PHP echo $Anexos[$x]['tipo']?>" onclick="descargarAnexos('<?PHP echo $Anexos[$x]['SolicitudAnexoId']?>','<?PHP echo $Anexos[$x]['Url']?>')" />
                    </td>
                </tr>
                <?PHP
            }//for
            ?>
            <tr>
                <th colspan="3">Proceso</th>
            </tr>
        </thead>
        <tbody>
            <?PHP
            $Print = false; 
            $Check = '';
            $Disable = '';
            $viewButton = false;
            
            for($i=0;$i<count($Firmas);$i++)
            {
                $Check = '';
                $Disable = '';
                
                if($Info->fields['ConvenioProcesoId']==13)
                {
                    $Print = true;
                    if($Firmas[$i]['ConvenioProcesoId']==7)
                    {
                        $Disable = 'disabled="disabled"';                           
                    }
                }else if($Info->fields['ConvenioProcesoId']==6)
                {
                    $Print = true;
                    if($Firmas[$i]['ConvenioProcesoId']==6)
                    {
                        $Disable = 'disabled="disabled"';
                        $Check = 'checked="checked"';
                    }
                }else if($Info->fields['ConvenioProcesoId']==7)
                {
                    $Print = true;
                    $Disable = 'disabled="disabled"';
                    $Check = 'checked="checked"';
                    $viewButton = true;                        
                }
                if($Firmas[$i]['ConvenioProcesoId']!=3)
                {
                    if($Print===true)
                    {                        
                    ?>
                    <tr>
                        <td colspan="3">
                            <input type="checkbox" <?PHP echo $Check?>  <?PHP echo $Disable?>  id="processo" name="processo" value="<?PHP echo $Firmas[$i]['ConvenioProcesoId'];?>" onchange="CambiarEstadoProceso('<?PHP echo $id?>','<?PHP echo $Firmas[$i]['ConvenioProcesoId'];?>','<?PHP echo $institucion?>')" />&nbsp;<?PHP echo $Firmas[$i]['Nombre'];?>
                        </td>        
                    </tr>
                    <?PHP   
                    }
                }
                if($Info->fields['ConvenioProcesoId']==7){
                    $valueButton = 'Paso firma Contraparte';
                }
            }//for
            ?>
        </tbody>
        <tbody>
        <tr>
        <td colspan="3">
        <form>
         <?PHP 
        if($viewButton===true)
        {
        ?>
            <input type="button" id="Finalizarproceso" value="<?PHP echo $valueButton?>" onclick="CambiarEstadoProceso('<?PHP echo $id?>','3','<?PHP echo $institucion?>')" />  
        <?PHP
        }
        ?>
        <input type="button" id="Regresar" name="Regresar" value="Regresar" onclick="regresarmenu()" />
        </form>
        </td></tr>
        </tbody>
        </table>
</fieldset>
</div>