<?php
session_start();

if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi?n en el sistema</strong></blink>';
	exit();
}
  
require_once('../../../Connections/sala2.php');


mysql_select_db($database_sala, $sala);

switch($_POST['actionID']){
    case 'Eliminar':{
        EjecutarCambio($_POST['corte'],$_POST['grupo'],$_POST['materia'],$_POST['estudiante'],$sala);
    }exit;
    case 'Programa':{
        Programas($_POST['id'],$sala);
    }exit;
    case 'Reporte':{
        Reporte($sala,$_POST['Carrera'],$_POST['periodo']);
    }exit;
    default:{
        Principal($sala);
    }exit;
}

function Principal($sala){
    /*
$query_periodo = "SELECT * 
FROM periodo p,carreraperiodo cp 
WHERE codigoestadoperiodo = '3'
AND cp.codigoperiodo = p.codigoperiodo
AND cp.codigocarrera = '$carrera'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  } 
else
  {
    mysql_select_db($database_sala, $sala);
    $query_periodo = "SELECT * 
	FROM periodo p,carreraperiodo cp 
	WHERE codigoestadoperiodo = '1'
	AND cp.codigoperiodo = p.codigoperiodo
	AND cp.codigocarrera = '$carrera'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);
    $periodoactual = $row_periodo['codigoperiodo'];
  }  */
  
  
 

//require('cierresemestreporcentajes.php');

?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {
	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
.Estilo5 {font-family: tahoma; font-size: xx-small; }

</style>
<script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
<script type="text/javascript" language="javascript">
    function OpenTr(i){
        $('.ViewTr').css('visibility','collapse');
        $('#Tr_View_'+i).css('visibility','visible');
    }//function OpenTr
    function DeleteRow(materia,corte,grupo,estudiante){
      if(confirm('¿ Seguro Desea Eliminar El Registro...?')){
        var Carrera = $('#Carrera').val();
        var periodo = $('#periodo').val();
         $.ajax({//Ajax
		   type: 'POST',
		   url: 'ReporteCortesSobrePasados.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'Eliminar',materia:materia,corte:corte,grupo:grupo,estudiante:estudiante}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val===false){
				    alert(data.msj);
                    return false;
				}else{
				    alert(data.msj);
                    $('#ReproteCarga').html('<img src="../../../mgi/images/engranaje-09.gif" width="40" /><strong>En Proceso de Busqueda</strong>');
                    $.ajax({//Ajax
            		   type: 'POST',
            		   url: 'ReporteCortesSobrePasados.php',
            		   async: false,
            		   dataType: 'html',
            		   data:({actionID: 'Reporte',Carrera:Carrera,periodo:periodo}),
            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
            		   success: function(data){
            				$('#ReproteCarga').html(data);		
            		   } 
            	    }); //AJAX
				}			
		   } 
	   }); //AJAX
     }  
    }//function DeleteRow
    function BuscarPrograma(value){
         $.ajax({//Ajax
		   type: 'POST',
		   url: 'ReporteCortesSobrePasados.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Programa',id:value}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
		   success: function(data){
				$('#Td_Programa').html(data);		
		   } 
	    }); //AJAX
    }//function BuscarPrograma
    function BuscarData(){
        var Carrera = $('#programa').val();
        var periodo = $('#periodo').val();
        $('#ReproteCarga').html('<img src="../../../mgi/images/engranaje-09.gif" width="40" /><strong>En Proceso de Busqueda</strong>');
        $.ajax({//Ajax
		   type: 'POST',
		   url: 'ReporteCortesSobrePasados.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Reporte',Carrera:Carrera,periodo:periodo}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
		   success: function(data){
				$('#ReproteCarga').html(data);		
		   } 
	    }); //AJAX
        
    }//function BuscarData
</script>

<div align='center'>
    <table align="center"  bordercolor="#FF9900" border="1" width="50%">
        <tr bgcolor='#C5D5D6'>
            <td align='center' class='Estilo1 Estilo4'><strong>Modalidad Acad&eacute;mica</strong></td>
            <td align='center' class='Estilo1 Estilo4'><?PHP modalidad($sala);?></td>
        </tr>
        <tr bgcolor='#C5D5D6'>
            <td align='center' class='Estilo1 Estilo4'><strong>Programa Acad&eacute;mico</strong></td>
            <td id="Td_Programa" align='center' class='Estilo1 Estilo4'>
                <select id="programa" name="programa">
                    <option value="-1"></option>
                </select>
            </td>
        </tr>
        <tr bgcolor='#C5D5D6'>
            <td align='center' class='Estilo1 Estilo4'><strong>Periodo</strong></td>
            <td align='center' class='Estilo1 Estilo4'>
            <?PHP Periodo($sala);?></td>
        </tr>
    </table>
    <br />
    <div align='center'>
        <input type="button" id="Buscar" name="nuscar" onclick="BuscarData();" value="Buscar" />
    </div>    
    <br />
</div>
<div align='center'>
    <span align='center' class='Estilo2 Estilo23 Estilo27 Estilo1 Estilo3'>LISTA DE ESTUDIANTES QUE EXEDEN CORTE POR NOTA</span>
</div>
<br />
<div align='center' id="ReproteCarga">
<?PHP Reporte($sala)?>
</div>
<?PHP 
}
function Reporte($sala,$carrera='',$periodoactual=''){
    // mysql_select_db($database_sala, $sala);
	   $query_estudiantes = "SELECT DISTINCT e.codigoestudiante,p.semestreprematricula,eg.numerodocumento
	   FROM estudiante e,prematricula p,estudiantegeneral eg,detalleprematricula d
	   WHERE p.codigoestudiante = e.codigoestudiante
	   AND e.idestudiantegeneral = eg.idestudiantegeneral
	   AND p.idprematricula = d.idprematricula							   
	   AND p.codigoperiodo = '$periodoactual'
	   AND p.codigoestadoprematricula LIKE '4%'
	   AND d.codigoestadodetalleprematricula LIKE '3%'
       AND e.codigocarrera = '$carrera'
       ORDER BY 1";	   
	   $estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
	   $row_estudiantes = mysql_fetch_assoc($estudiantes);
	   $totalRows_estudiantes = mysql_num_rows($estudiantes);    
     
		$banderaporcentaje = 0;		    		
		$contadorfaltantes = 1;
		$contadorcierre = 1;
    ?>
    <input type="hidden" id="Carrera" name="carrera" value="<?PHP echo $carrera?>" />
    <input type="hidden" id="periodo" name="Periodo" value="<?PHP echo $periodoactual?>" />
    <table align="center"   bordercolor="#FF9900" border="1" width="50%">
    <tr>
        <td>
            <table align='center'>
                <tr  bgcolor='#C5D5D6'>
                <td align='center' class='Estilo1 Estilo4'><strong>Documento</strong></td>
                <td align='center' class='Estilo1 Estilo4'><strong>Estudiante</strong></td>
                <td align='center' class='Estilo1 Estilo4'><strong>Materia</strong></td>	
                <td align='center' class='Estilo1 Estilo4'><strong>Nombre Materia</strong></td>			
                <td align='center' class='Estilo1 Estilo4'><strong>Porcentaje Exedente</strong></td>
                <td align='center' class='Estilo1 Estilo4'><strong>&nbsp;&nbsp;</strong></td>			
                </tr>
                <?PHP
                do{		     
        			  //echo $row_estudiantes['codigoestudiante'],"<br>";
        			  $codigoestudiante = $row_estudiantes['codigoestudiante'];		      
        			  require('cierresemestreporcentajes.php');			
        		      $codigocierre[$contadorcierre]=$codigoestudiante;	
                      $semestre1[$contadorcierre] = $row_estudiantes['semestreprematricula'];
        			  $numerod[$contadorcierre] = $row_estudiantes['numerodocumento'];
        			  $contadorcierre++;
        		  }while($row_estudiantes = mysql_fetch_assoc($estudiantes));
                    for($i=1;$i<$contadorfaltantes;$i++)
                    {
                        if($faltante[$i]<0){
                    ?> 
                    <tr>  
                        <td align='center' class='Estilo1 Estilo4'><?PHP echo $numerodocumentototal[$i];?></td>	        
                        <td align='center' class='Estilo1 Estilo4'><?PHP echo $nombretotal[$i];?></td>
                        <td align='center' class='Estilo1 Estilo4'><?PHP echo $codigomateriatotal[$i];?></td>
                        <td align='center' class='Estilo1 Estilo4'><?PHP echo $nombremateriatotal[$i];?></td>
                        <td align='center' class='Estilo1 Estilo4'><?PHP echo $faltante[$i];?></td>  
                        <td align='center' class='Estilo1 Estilo4'>
                            <img src="../../../mgi/images/desktop.png" width="30" style="cursor: pointer;" title="Editar" onclick="OpenTr('<?PHP echo $i?>')" />
                        </td>  
                    </tr>
                    <tr id="Tr_View_<?PHP echo $i?>" style="visibility: collapse;" class="ViewTr">
                        <td colspan="6">
                            <div>
                            <?PHP verData($codigomateriatotal[$i],$codigoGrupototal[$i],$codigototal[$i],$periodoactual,$sala);?>
                            </div>
                        </td>
                    </tr>				  
                    <?PHP
                       }    
                    }
                    ?>  		 
            </table>
        </td>
    </tr>
</table>
    <?PHP
}
function verData($materia,$grupo,$codigoestudiante,$periodo,$sala){
    //require_once('../../../Connections/sala2.php');
    
    mysql_select_db($database_sala, $sala);
    
     $SQL='SELECT
            	d.idcorte,
            	d.idgrupo,
            	d.nota,
            	c.porcentajecorte,
            	c.codigocarrera,
            	c.codigomateria,
                g.nombregrupo,
                m.nombremateria,
                if(c.codigocarrera=1,"Corte Especifico","Corte Generico") AS Tittle,
                d.nota
            FROM
            	detallenota d
            INNER JOIN corte c ON c.idcorte = d.idcorte
            INNER JOIN grupo g ON g.idgrupo=d.idgrupo
            INNER JOIN materia m ON m.codigomateria=d.codigomateria
            WHERE
            	d.codigomateria = "'.$materia.'"
            AND d.codigoestudiante = "'.$codigoestudiante.'"
            AND d.idgrupo = "'.$grupo.'"
            AND c.codigoperiodo = "'.$periodo.'"
            AND d.codigoestado = 100';
            
       $Data = mysql_query($SQL, $sala) or die(mysql_error());
       //$row_Data = mysql_fetch_assoc($Data);
       //echo'<pre>';print_r($row_Data);   
    ?>
    
    <table style="width: 100%;">
        <tr bgcolor='#C5D5D6'>
            <td align='center' class='Estilo1 Estilo4'>#</td>
            <td align='center' class='Estilo1 Estilo4'>Grupo</td>
            <td align='center' class='Estilo1 Estilo4'>Codigo Grupo</td>
            <td align='center' class='Estilo1 Estilo4'>Codigo Corte</td>
            <td align='center' class='Estilo1 Estilo4'>Porcentaje %</td>
            <td align='center' class='Estilo1 Estilo4'>Nota</td>
            <td align='center' class='Estilo1 Estilo4'>Tipo Corte</td>
            <td align='center' class='Estilo1 Estilo4'>Acci&oacute;n</td>
        </tr>
        <?PHP 
        $i=0;
        while($row_Data = mysql_fetch_assoc($Data)){
            ?>
            <tr>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $i+1?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['nombregrupo']?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['idgrupo']?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['idcorte']?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['porcentajecorte']?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['nota']?></td>
                <td align='center' class='Estilo1 Estilo4'><?PHP echo $row_Data['Tittle']?></td>
                <td align='center' class='Estilo1 Estilo4'>
                    <img src="../../../mgi/images/delete.png" width="15" style="cursor: pointer;" title="Eliminar" onclick="DeleteRow('<?PHP echo $materia?>','<?PHP echo $row_Data['idcorte']?>','<?PHP echo $row_Data['idgrupo']?>','<?PHP echo $codigoestudiante?>')" />
                </td>
            </tr>
            <?PHP
            $i++;
        }
        ?>
    </table>
    <?PHP
}//function verData
function EjecutarCambio($idcorte,$idgrupo,$codigomateria,$codigoestudiante,$sala){
      $SQL='DELETE
            FROM
            	detallenota
            WHERE
            	(idgrupo = "'.$idgrupo.'")
            AND (idcorte = "'.$idcorte.'")
            AND (codigoestudiante = "'.$codigoestudiante.'")
            AND (codigomateria = "'.$codigomateria.'")
            LIMIT 1';
      if($Data = mysql_query($SQL, $sala)===false){
        $a_vectt['val']			  =false;
        $a_vectt['msj']		      ='Error en el Sistema';
        echo json_encode($a_vectt);
        exit;   
      }      
        $a_vectt['val']			  =true;
        $a_vectt['msj']		      ='Se Ha Eliminado Correctamente...';
        echo json_encode($a_vectt);
        exit;         
}
function modalidad($sala){
      $SQL='SELECT
            codigomodalidadacademica,
            nombremodalidadacademica
            FROM
            modalidadacademica
            WHERE
            codigoestado=100';
            
      $Data = mysql_query($SQL, $sala) or die(mysql_error());   
      
      ?>
        <select id="modalidad" name="modalidad" onchange="BuscarPrograma(this.value)">
        <option value="-1"></option>
        <?PHP 
        while($row_Data = mysql_fetch_assoc($Data)){
          ?>
          <option value="<?PHP echo $row_Data['codigomodalidadacademica']?>"><?PHP echo $row_Data['nombremodalidadacademica']?></option>
          <?PHP  
        } 
        ?>
        </select>
      <?PHP
          
}
function Programas($id,$sala){
      $SQL='SELECT
            codigocarrera,
            nombrecarrera
            FROM
            carrera
            WHERE
            codigomodalidadacademica="'.$id.'"
            AND
            (fechavencimientocarrera>=CURDATE() OR  EsAdministrativa=1)
            AND
            codigocarrera NOT IN (1,156)
            
            ORDER BY  nombrecarrera ASC';
            
      $Data = mysql_query($SQL, $sala) or die(mysql_error());   
      
      ?>
        <select id="programa" name="programa">
        <option value="-1"></option>
        <?PHP 
        while($row_Data = mysql_fetch_assoc($Data)){
          ?>
          <option value="<?PHP echo $row_Data['codigocarrera']?>"><?PHP echo $row_Data['nombrecarrera']?></option>
          <?PHP  
        } 
        ?>
        </select>
      <?PHP
          
}
function Periodo($sala){
      $SQL='SELECT
            codigoperiodo,
            codigoestadoperiodo
            FROM
            periodo
            
            ORDER BY  codigoperiodo DESC';
            
     $Data = mysql_query($SQL, $sala) or die(mysql_error());   
      
      ?>
        <select id="periodo" name="periodo">
        <option value="-1"></option>
        <?PHP 
        $selected = '';
        while($row_Data = mysql_fetch_assoc($Data)){
            if($row_Data['codigoestadoperiodo']==3 ||$row_Data['codigoestadoperiodo']==1){
                $selected = 'selected="selected"';
            }else{
               $selected = ''; 
            }
          ?>
          <option <?PHP echo $selected?> value="<?PHP echo $row_Data['codigoperiodo']?>"><?PHP echo $row_Data['codigoperiodo']?></option>
          <?PHP  
        } 
        ?>
        </select>
      <?PHP       
}
?>
