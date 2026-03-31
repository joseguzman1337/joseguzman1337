<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//cargue masivo de usuarios para cambio de estado a graduado.

include_once ('../../EspacioFisico/templates/template.php');
$db = getBD();

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('memory_limit', '256M');
//ini_set('max_execution_time','6400000');
require_once ("../../../sniespgsqlsadhapmn/Excel/reader.php");
$data = new Spreadsheet_Excel_Reader();

if($_POST['id']=='archivo')
{
    
    $data->read($_FILES['archivo']['tmp_name']);
    $i =1;
    
    echo '<table><tr><td>#</td><td>Nombre</td><td>Apellido</td><td>Documento</td><td>Estado Anterior</td><td>Estado Nuevo</td></tr>';
    $j=1;
    foreach ($data->sheets[0]['cells'] as $llave => $valor)
    {
        echo '<tr><td>'.$j.'</td>';
        echo '<td>'.$valor[1].'</td>';
        echo '<td>'.$valor[2].'</td>';
        echo '<td>'.$valor[3].'</td>';
        
        $sql = "SELECT e.codigosituacioncarreraestudiante, e.codigoestudiante, e.idestudiantegeneral FROM estudiantegeneral i join estudiante e on e.idestudiantegeneral = i.idestudiantegeneral WHERE i.numerodocumento = '".$valor[3]."' and e.codigocarrera = '10'";
$datos = $db->GetRow($sql);
        
        $sqlestado = "SELECT nombresituacioncarreraestudiante FROM situacioncarreraestudiante where codigosituacioncarreraestudiante = '".$datos['codigosituacioncarreraestudiante']."'";
        $datoestado = $db->GetRow($sqlestado);
        
        echo '<td>'.$datoestado['nombresituacioncarreraestudiante'].'</td>';
        
        
        if($datos['codigosituacioncarreraestudiante']!= $_POST['estado'])
        {
            $sql2 = "UPDATE estudiante SET codigosituacioncarreraestudiante='".$_POST['estado']."' WHERE (codigoestudiante='".$datos['codigoestudiante']."' and idestudiantegeneral='".$datos['idestudiantegeneral']."' and  codigocarrera='10' and codigosituacioncarreraestudiante='".$datos['codigosituacioncarreraestudiante']."')";
             $update = $db->execute($sql2);
             
             
            echo '<td>  Actualizado</td></tr>';    
        }else
        {
            echo '<td> No modificado</td></tr>';    
        }
        $j++;
    }
    echo '</table>';
}
function listaestados($db)
{
    $sqlestados = "SELECT codigosituacioncarreraestudiante, nombresituacioncarreraestudiante FROM situacioncarreraestudiante";
    $lista = $db->execute($sqlestados);
    echo "<select name='estado'>";
    foreach($lista as $nombres)
    {
        echo "<option value='".$nombres['codigosituacioncarreraestudiante']."'>".$nombres['codigosituacioncarreraestudiante']." -- ".$nombres['nombresituacioncarreraestudiante']."</option>";
    }
    echo "</select>";
}


   
?>
<html>
    <body>
        <div align='center'>
        
            <h3>Cambio de estado para estudiantes de medicina</h3>
        
            <form action="CambioEstadoGraduadoMedicina.php" method="post" enctype="multipart/form-data">
                 Nuveo estado:<br /><br />
                 <?php listaestados($db);?><br /><br />
                <input type="file" name="archivo" /><br /><br />
                <input type="submit" name="cargar" /><br />
                <input type="hidden" name="id" value="archivo" />
                
            </form>
        </div>
    </body>
</html>