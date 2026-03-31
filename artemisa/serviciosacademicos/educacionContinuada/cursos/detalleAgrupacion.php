<?php 
    /*
    * Ivan Dario Quintero Rios
    * Febrero 8 del 2018
    */
    session_start();

    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = getBD();
    
    $data = array();
	$dataDetalle = array();
	$modalidad = array();
    $tipo = array();
    $materia = array();
	$id = "";

    if(isset($_REQUEST["id"]))
    {  
        $id = $_REQUEST["id"];
        $utils = Utils::getInstance();
        $data = $utils->getDataEntity("carrera", $id, "codigocarrera");  
        $dataDetalle = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera");
        $dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $data["codigocarrera"],"codigocarrera");
        $carreraAgrupaciones = "select AgrupacionCarreraEducacionContinuadaId from CarrerasEducacionContinuada where codigocarrera = '".$data["codigocarrera"]."' and CodigoEstado= '100'";
        $carreraagrupacion = $db->GetRow($carreraAgrupaciones);
        
        $Agrupacion = $utils->getDataEntity("AgrupacionCarreraEducacionContinuada",$carreraagrupacion['AgrupacionCarreraEducacionContinuadaId'], "AgrupacionCarreraEducacionContinuadaId"); 
        
        $sqlagrupacion = "select NombreAgrupacion, AgrupacionCarreraEducacionContinuadaId from AgrupacionCarreraEducacionContinuada where CodigoEstado = 100";
        $listaAgrupaciones = $db->GetAll($sqlagrupacion);
                        
        $datos="";
        foreach($listaAgrupaciones as $lista)
        {
            $datos.="<option value='".$lista['AgrupacionCarreraEducacionContinuadaId']."'>".$lista['NombreAgrupacion']."</option>";
        }        
    }
?>
<div id="tabs-3">
    <h4>Ver Detalle Agrupacion </h4>
    <table class="detalle">
        <tr>
            <th>Código:</th>
            <td><?php echo $data['codigocarrera']; ?>
                <input type="hidden" id="codigocarrera" name="codigocarrera" value="<?php echo $data['codigocarrera']; ?>">
            </td>
            <th>Nombre:</th>
            <td><?php echo $data['nombrecarrera']; ?></td>
        </tr>
        <tr>
            <th>Codigo agrupacion</th>
            <td><?php echo $Agrupacion['AgrupacionCarreraEducacionContinuadaId'];?></td>
            <th>Nombre Agrupacion</th>
            <td><?php echo $Agrupacion['NombreAgrupacion'];?></td>
        </tr>
    </table>
</div>
<div>
    <h4>Asignar Agrupacion</h4>    
    <table class="detalle">
        <tr>
            <th>Listas disponibles</th>
            <td>
                <select name="lista" id="lista">
                    <option value="">SELECCIONE...</option>
                    <option value="0">NINGUNA</option>
                    <?php echo $datos;?>
                </select>
            </td>
            <td>
                <input type="button" value="Asignar" onclick="asignar()" >
            </td>            
        </tr>
    </table>    
</div>
<div>
    <h4>Crear Agrupacion</h4>
    <table class="detalle">
        <tr>
            <th>Nombre Agrupacion</th>
            <td>
                <input type="text" id="nuevonombre" name="nuevonombre">
            </td>
            <td>
                <input type="button" value="Registrar" onclick="RegistrarAgrupacion()"  >
            </td>            
        </tr>
    </table>
</div>
<script type="text/javascript">	
    function asignar()
    {
        var x = $('#lista').val();
        var y = $('#codigocarrera').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: {action:'asignar', agrupacion:x, codigocarrera:y},                
            success:function(data){
                if (data.success == true)
                {
                    alert(data.message);
                    window.location.href="detalle.php?id="+y;
                }else
                {
                    alert(data.message);
                }  
            },
            error: function(data,error,errorThrown)
            {
                alert(error + errorThrown);
            }
        });            
    }
    
    function RegistrarAgrupacion()
    {
        var x = $('#nuevonombre').val();
        var y = $('#codigocarrera').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: {action:'nuevaagrupacion', nombre:x, codigocarrera:y},                
            success:function(data)
            {
               if (data.success == true)
               {
                    alert(data.message);
                    window.location.href="detalle.php?id="+y;
                }else
                {
                    alert(data.message);
                }
            },
            error: function(data,error,errorThrown)
            {
                alert(error + errorThrown);
            }
        });            
    }
</script>
 
