<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include_once ('../../../../EspacioFisico/templates/template.php');
$db = getBD();

$fecha= date("d ,M, Y");  
$SQL = "SELECT NombreSubgrupo, MaximoCupo FROM Subgrupos WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
if($nombre=&$db->Execute($SQL)===false){
echo 'Error en el SQL Userid...<br />';
die;
}

$Sqlestudiantes = "SELECT eg.numerodocumento, concat(eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral) as nombre, r.codigoperiodo, r.FechaEgreso, r.FechaIngreso, r.JornadaId, m.nombremateria, r.RotacionEstudianteId, c.NombreConvenio, pm.semestreprematricula FROM RotacionEstudiantes r INNER JOIN estudiante e ON e.codigoestudiante = r.codigoestudiante INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e .idestudiantegeneral INNER JOIN materia m ON m.codigomateria = r.codigomateria INNER JOIN Convenios c ON c.ConvenioId = r.idsiq_convenio INNER JOIN prematricula pm ON pm.codigoestudiante = r.codigoestudiante INNER JOIN detalleprematricula dp ON dp.idprematricula = pm.idprematricula WHERE r.SubgrupoId = '".$_REQUEST['SubgrupoId']."' and dp.codigomateria = r.codigomateria";
$resultadoestudiantes = $db->GetAll($Sqlestudiantes);

$sqldias = "SELECT d.nombredia, NombreDocenteCargo FROM DetalleRotaciones dr INNER JOIN dia d ON d.codigodia = dr.codigodia WHERE dr.RotacionEstudianteid = '".$resultadoestudiantes[0]['RotacionEstudianteId']."'";
$resultadodias = $db->GetAll($sqldias);
$numerodias="";

foreach($resultadodias as $dias)
{
    $numerodias.= $dias['nombredia'];
    $docente =  $dias['NombreDocenteCargo'];
}
  
$materia = $resultadoestudiantes[0]['nombremateria'];
$jornada = $resultadoestudiantes[0]['Jornada'];
$periodo = $resultadoestudiantes[0]['codigoperiodo'];

switch($jornada)
{
    case '1':
    {
        $horariojorndad = "7:00 a.m a 5:00 p.m";        
    }break;
    case '2':
    {
        $horariojorndad = "7:00 a.m a 12:00 m";
    }break;
    case '3':
    {
        $horariojorndad = "2:00 p.m a 5:00 p.m";
    }break;
    case '4':
    {
        $horariojorndad = "5:00 p.m a 10:00 p.m";
    }break;
    case '5':
    {
        $horariojorndad = "5:00 p.m a 7:00 a.m";
    }break;
}
$fechainicio = $resultadoestudiantes[0]['FechaIngreso'];
$fechafin = $resultadoestudiantes[0]['FechaEgreso'];
$semestre = $resultadoestudiantes[0]['semestreprematricula'];

$html ="
<page backtop='8%' backbottom='2%' backleft='5%' backright='10%'>
    <page_header>
        <table id='encabezado'>
            <tr class='fila'>
                <td id='col_1' >
                    <img src='../subgrupos/images/encabezado.png' width='790' heigth='200'>
                </td>
            </tr>
        </table>
    </page_header>
        <h3>Bogotá, ".$fecha."</h3>        
        <p>Doctor <br />
            RICARDO DE LA ESPRIELLA<br />
            Jefe de Educación Médica<br />
            Clínica Nuestra Señora de la Paz<br />
            Cra. 13 No. 68 F-25<br />
            Bogotá
        </p>
        <br />
        <p>Respetado Doctor de la Espriella:</p>
        <br />
        <p>Reciba un cordial saludo, para dar continuidad al CONVENIO DOCENTE ASISTENCIAL me permito relacionar a continuación el primer grupo de ".$semestre." semestre de la asignatura  <strong>".$materia."</strong> que harán su práctica en la <strong>".$convenio."</strong> durante el periodo académico ".$periodo." y quienes estarán a cargo de <strong>Dra. ".$docente."</strong> esta rotación se hará los días <strong>".$numerodias."</strong> de ".$horariojorndad." cada 8 días a partir del <strong>".$fechainicio."</strong> al  <strong>".$fechafin."</strong>.</p>
        <br />
        <table border='1' align='center'><thead><tr><td>Documento</td><td>Nombre</td></tr></thead><tbody>";
            foreach($resultadoestudiantes as $datosestudiantes)
            {
               $html.= "<tr><td>".$datosestudiantes['numerodocumento']."</td><td>".$datosestudiantes['nombre']."</td></tr>";
            }
            $html.="</tbody>
        </table>
        <br />
        <p>Agradezco su atención y amable colaboración </p>
        <br />
        <p>Cordialmente,</p>
        <br />
        <p>
            ALFONSO RODRIGUEZ GONZALEZ<br />
            Director<br />
            AREA PSICOSOCIAL DE MEDICINA<br /> 
        </p>
        <br />
        <p>Adjunto: Listado Estudiantes<br> 
        Copia: Dr.   Pedro Vargas Navarro Coordinador<br>
                Dra. Claudia Vanegas<br>
                  Consecutivo  <br>    
        </p>
<page_footer>
   <table id='footer'>
            <tr class='fila'>
                <td>                
                    <img src='../subgrupos/images/pie.png' width='750' heigth='100' >
                </td>
            </tr>
        </table>
    </page_footer>
</page>"; 

require_once('../../../../educacionContinuada/html2pdf/html2pdf.class.php');
    try
    {   
        $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
        //$html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->WriteHTML($html,'0');// 0 es pdf y 1 es html
        $html2pdf->Output('rotacion.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>