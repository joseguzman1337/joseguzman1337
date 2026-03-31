<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
include("../../../templates/templateAutoevaluacion.php");
include("../../pChart/class/pData.class.php");
include("../../pChart/class/pDraw.class.php");
include("../../pChart/class/pImage.class.php");
include_once("funcionesAcreditacion.php");

$db =writeHeader("Instrumento",true,"Autoevaluacion");
    
//$ind='90038';
//$dis='1';
$ind=$_REQUEST['indicador_id'];
$dis=$_REQUEST['Discriminacion'];

//echo $ind.'<br>';
//echo $dis.'ok';

?>
<style>
.conte{
    border-collapse:collapse;
    border:1px solid green;
}
.contth{
    border:1px solid green;
}
.conthr{
    background-color:green;
    color:white;
}
#contenido table.detalle{
    border-collapse: collapse;
}
#contenido table.detalle th {
    background-color: #EEEEEE;
    text-align: right;
    border: 1px solid #000000;
    padding: 0.5em;
    font-weight: bold;
}
#contenido table.detalle td {
    border: 1px solid #000000;
    padding: 0.5em;
}

</style>
<div id="contenido">
<form action="save.php" method="post" id="form_test">
    <div id="container" style="margin-top:0;">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoanalisis">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="indicador_id" id="indicador_id" value="<?php echo $ind ?>" />
        <input type="hidden" name="Descriminacion" id="Descriminacion" value="<?php echo $dis?>" />
        <?php    
            $sql_ind="SELECT i.idsiq_indicador, i.idEstado, i.discriminacion, i.idCarrera, 
                        g.idsiq_indicadorGenerico, g.codigo, g.nombre
                    FROM siq_indicador as i 
                    inner join siq_indicadorGenerico as g on (i.idIndicadorGenerico=g.idsiq_indicadorGenerico and g.codigoestado='100') 
                    where idsiq_indicador='".$ind."' and discriminacion='".$dis."' and i.codigoestado='100'";
        //echo $sql_ind;
        $cant=0;
        $data_cp1 = $db->Execute($sql_ind);
        
        $sql_indData="SELECT ig.codigo as codigo, ig.nombre as nombreIndicador, ig.descripcion as descripcionIndicador,
            a.nombre as nombreAspecto, c.nombre as nombreCaracteristica,
            c.descripcion as descripcionCaracteristica, f.nombre as nombreFactor, f.codigo as codigoFactor  
                    FROM siq_indicador as i 
                    inner join siq_indicadorGenerico as ig on (i.idIndicadorGenerico=ig.idsiq_indicadorGenerico and ig.codigoestado='100') 
                    INNER JOIN siq_aspecto a ON a.idsiq_aspecto=ig.idAspecto 
                    INNER JOIN siq_caracteristica c ON c.idsiq_caracteristica=a.idCaracteristica 
                    INNER JOIN siq_factor f ON f.idsiq_factor=c.idFactor 
                    where i.idsiq_indicador='".$ind."' and i.codigoestado='100'";
        //echo $sql_indData;
        $dataDesc = $db->GetRow($sql_indData);
        
        $C_data1 = $data_cp1->GetArray();
		//print_r($C_data1);
        $C_total1=count($C_data1);
        if ($C_total1>0){
            foreach($data_cp1 as $data1){
                $nombre1=$data1['nombre'];
                $codigo1=$data1['codigo'];
            }

        }
            ?>
           
            <div align="left" style="padding:10px;width:100%;">
                <h4 style="margin-top:10px;margin-bottom:0.8em;">Datos del indicador</h4>
                
                <table class="detalle" style="width:97%;">
                    <tr>
                        <th>Factor:</th>
                        <td><?php echo $dataDesc["nombreFactor"]; ?></td>
                    </tr>
                    <tr>
                        <th>Característica:</th>
                        <td><?php echo $dataDesc["nombreCaracteristica"]; ?></td>
                    </tr>
                    <tr>
                        <th>Descripción de la característica:</th>
                        <td><?php echo $dataDesc["descripcionCaracteristica"]; ?></td>
                    </tr>
                    <tr>
                        <th>Aspecto:</th>
                        <td><?php echo $dataDesc["nombreAspecto"]; ?></td>
                    </tr>
                    <tr>
                        <th>Indicador:</th>
                        <td><?php echo $dataDesc["codigo"]." - ".$dataDesc["nombreIndicador"]; ?></td>
                    </tr>
                    <tr>
                        <th>Descripción del indicador:</th>
                        <td><?php echo $dataDesc["descripcionIndicador"]; ?></td>
                    </tr>
                </table>
            </div>
        <br>
<?php

$codigoFactor = trim($dataDesc["codigoFactor"]);
getInformePercepcion($codigoFactor,"margin-left:20px;font-size:1.1em;");
	
	 $SQL_Doc='SELECT 

									idsiq_documento
									
									FROM 
									
									siq_documento d 
									INNER JOIN siq_archivo_documento sq on sq.siq_documento_id=d.idsiq_documento and sq.codigoestado=100
									
									WHERE
									
									siqindicador_id="'.$C_data1[0]['idsiq_indicador'].'"
									AND
									d.codigoestado=100';
									//echo $SQL_Doc;
								if($Documento=&$db->Execute($SQL_Doc)===false){
										echo 'Error en el SQl De Buscar el Documento....<br>'.$SQL_Doc;
										die;
									}
									
									$id_doc = $Documento->fields['idsiq_documento'];
									if($id_doc===null){
										$id_doc=="";
									}
							//print_r($_REQUEST);		
									$Fecha_ini = $_REQUEST['Fecha_ini'];
									if($Fecha_ini===null){
										$Fecha_ini=="";
									}
									$Fecha_fin = $_REQUEST['Fecha_fin'];
									if($Fecha_fin===null){
										$Fecha_fin=="";
									}
	
	?>
	<div style="text-align:center;margin-top:20px;width:97%;">
                 <?php if($id_doc==""){ ?>
                      <span style="font-size:12px">No tiene documentos vigentes asociados.</span>
                                                <?php } else { ?>                  
            <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px;cursor:pointer;" onClick="Open(<?PHP echo $id_doc?>,'0','0','<?PHP echo $Fecha_ini?>','<?PHP echo $Fecha_fin?>',true)" class="full_width big" title="Click para ver..." >
                                                   		 
            <div id="Contenedor_archivos" style="display:none;width:100%">
                                                        
            </div>	 
			<?php } ?>			
    </div>
	<?php if($id_doc!=""){ ?>
	<script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
	<script type="text/javascript" src="../../js/funcionesAcreditacion.js" ></script>
<?php } ?>

