<?PHP 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
/*session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
//include("../../../../EspacioFisico/templates/template.php"); 	
    include("../../../../observatorio/templates/templateObservatorio.php");     
    $db =writeHeader("Perdida de<br/>Asignatura<br/>por Semestre",true,"Reporte de Perdida de Asignatura Por Semestre",1,null,'','../../../../observatorio/');
//$db = writeHeader('Consola Plan Estudio',true,'../../../../mgi/','body','../../../../EspacioFisico/css/');

?>
<style>
 .button{
    background: transparent -moz-linear-gradient(center top , #7db72f, #4e7d0e) repeat scroll 0 0;
    border: 1px solid #538312;
    border-radius: 10px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    color: #e8f0de;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    padding: 8px 19px 9px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);   
	margin: 10px 0 0 200px;
}    

input[type="checkbox"] {
    box-sizing: border-box;
    margin-right: 10px;
    margin-top: 5px;
    padding: 0;
    position: relative;
    top: 2px;
}

select{
    margin: 10px 0;
}
</style>
<script type="text/javascript">
    function Deshabilitar(value){
        if($('#CodigoCarrera_'+value).is(':checked')){
            $('.Carrera').attr('disabled',true);
            $('.Carrera').attr('checked',false);
        }else{
            $('.Carrera').attr('disabled',false);
            $('.Carrera').attr('checked',false);
        }
    }//function Deshabilitar
    function BuscarList(){
        if(!$('.Carrera').is(':checked') && !$('.AllCarrera').is(':checked')){
            alert('Por Favor selecione uno o mas Programas');
            return false;
        }
        if($('#Periodo_1').val()=='-1' || $('#Periodo_1').val()==-1){
            alert('Por Favor Indique el Periodo Inicial');
            return false;
        }
        if($('#Periodo_2').val()=='-1' || $('#Periodo_2').val()==-1){
            alert('Por Favor Indique el Periodo Final');
            return false;
        }
        
        if($('#Periodo_1').val() > $('#Periodo_2').val()){
            alert('Por Favor Periodo Inicial NO debe ser mayor Periodo Final');
            return false;
        }
        /****************************************************/
        $('#CargarData').html('<img src="../../../../EspacioFisico/imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
        $('#Buscar').attr('disabled',true); 
        $.ajax({//Ajax
              type: 'POST',
              url: 'listadoMateriasPlanEstudioObservatorio.php',
              async: false,
              dataType: 'html',
              data:$('#ListadoPlanEstudio').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#CargarData').html('');
                    $('#Buscar').attr('disabled',false); 
                    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));  
              }//Data              
        });//AJAX
    }//function BuscarList
</script>  
<div id="container">
    
    <div class="demo_jui">
    <fieldset>
        <legend>
            <h2>Listado de Materias por Plan de Estudio</h2>
        </legend>
        <form id="ListadoPlanEstudio">
        <!--<input type="hidden" id="action_ID" name="action_ID" value="Buscar" />-->
        <table>
            <thead>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <?PHP CarrerasMultiple($db);?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>Periodo Inical</td>
                    <td><?PHP Periodo($db,'Periodo_1');?></td>
                </tr>
                <tr>
                    <td>Periodo Final</td>
                    <td><?PHP Periodo($db,'Periodo_2');?></td>
                </tr>
                <tr>
					<td colspan="1">&nbsp;</td>
                    <td colspan="2">
                        <input type="button"  class="button" id="Buscar" name="Buscar" onclick="BuscarList()" value="Exportar" />
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div id="CargarData"></div>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
    </fieldset>    
    </div>
</div>
	
<?PHP 
function CarrerasMultiple($db){
      $SQL='SELECT

            codigocarrera,
            nombrecarrera 
            
            FROM
            
            carrera
            
            WHERE
            
            codigomodalidadacademica=200
            AND
            (fechavencimientocarrera >=CURDATE() OR codigocarrera=1)
            
            ORDER BY nombrecarrera ASC';
            
      if($SQLCarrera=&$db->Execute($SQL)===false){
        echo 'Error en el SQL de Carrera ...<br><br>'.$SQL;
        die;
      }     
      
      ?>
      <tr>
        <td colspan="2">Programas Acad&eacute;micos</td>
      </tr>
      <tr>  
        <td colspan="2">
            <fieldset>
            <div style="overflow:scroll;width:100%;height:140px;overflow-x:hidden;">
                <ul>
                <?PHP 
                $Funcion = '';
                $Class   = 'Carrera';
                while(!$SQLCarrera->EOF){
                    if($SQLCarrera->fields['codigocarrera']==1){
                        $Funcion = 'Deshabilitar';
                        $Class   = 'AllCarrera';
                    }
                    ?>
                    <li><input type="checkbox" class="<?PHP echo $Class?>" id="CodigoCarrera_<?PHP echo  $SQLCarrera->fields['codigocarrera']?>" name="CodigoCarrera[]" value="<?PHP echo  $SQLCarrera->fields['codigocarrera']?>" onclick="<?PHP echo $Funcion;?>(this.value)" /><?PHP echo $SQLCarrera->fields['nombrecarrera']?></li>
                    <?PHP
                    $SQLCarrera->MoveNext();
                }
                ?>
                </ul>
            </div>
            </fieldset>
        </td>
      </tr>
      <?PHP 
}//function CarrerasMultiple
function Periodo($db,$name){
      $SQL='SELECT
            	codigoperiodo AS id,
            	codigoperiodo
            FROM
            	periodo
            ORDER BY
            	codigoperiodo DESC';
                
      if($Periodos=&$db->Execute($SQL)===false){
        echo 'Error en el SQL de Periodo...<br><br>'.$SQL;
        die;
      }      
     ?>
     <select id="<?PHP echo $name?>" name="<?PHP echo $name?>">
        <option value="-1"></option>
        <?PHP 
        while(!$Periodos->EOF){
            ?>
            <option value="<?PHP echo $Periodos->fields['id']?>"><?PHP echo $Periodos->fields['codigoperiodo']?></option>
            <?PHP
            $Periodos->MoveNext();
        }//while
        ?>
     </select>
     <?PHP     
}//function Periodo
?>