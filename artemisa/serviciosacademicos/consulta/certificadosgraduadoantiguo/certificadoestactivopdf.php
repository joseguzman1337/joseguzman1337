<?php
require('../../funciones/clases/fpdf/fpdf.php');
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

class PDF extends FPDF {
    var $B;
    var $I;
    var $U;
    var $HREF;

    function PDF($orientation='P', $unit='mm', $format='A4') {

        $this->FPDF($orientation, $unit, $format);
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
    }

    function celda($w, $h, $string, $x, $align='C', $linea=2, $marco=1, $fill=0) {
        $this->SetXY($this->x + $x, $this->y - ($linea * $h));
        $this->MultiCell($w, $h, $string, $marco, $align, $fill);
    }
}

function pasarMayusculas($cadena) {
    $cadena = strtoupper($cadena);
    $cadena = str_replace("á", "Á", $cadena);
    $cadena = str_replace("é", "É", $cadena);
    $cadena = str_replace("í", "Í", $cadena);
    $cadena = str_replace("ó", "Ó", $cadena);
    $cadena = str_replace("ú", "Ú", $cadena);
    $cadena = str_replace("ñ", "Ñ", $cadena);
    return ($cadena);
}


if (isset($_REQUEST['token'])){

$SQL = "SELECT c.idConsultaTitulos, eg.numerodocumento, c.tipoCertificado ".
" FROM ConsultaTitulos c ".
" INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = c.idestudiantegeneral ".
" WHERE token = '".$_REQUEST['token']."'".
" AND fechaVencimientoToken >= CURDATE() ".
" ORDER BY fechaVencimientoToken ASC LIMIT 1";
$datos = $db->Execute($SQL);
$row_datos = $datos->FetchRow();
$documento = $row_datos['numerodocumento'];

}else{
    $documento = $_REQUEST['documento'];
}

$fechahoy = date("Y-m-d");
$hora = date(" H:i:s");
$mes = date(n) - 1;
$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$_SERVER["REMOTE_ADDR"];

 $query_datos = "SELECT g.nombregenero,eg.idestudiantegeneral, e.semestre, concat(eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral)as nombre, eg.numerodocumento, c.nombrecarrera, d.tipodocumento,d.nombredocumento
                FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg ,documento d, periodo p,genero g
                where eg.numerodocumento = '$documento'
                and eg.idestudiantegeneral=e.idestudiantegeneral
                and e.codigocarrera=c.codigocarrera and g.codigogenero=eg.codigogenero
                and ee.codigoestudiante=e.codigoestudiante
                and eg.tipodocumento= d.tipodocumento
                and ee.codigoperiodo=p.codigoperiodo
                and p.codigoestadoperiodo in (1,3,4)
                and ee.codigoprocesovidaestudiante in(400, 401)
                and ee.codigoestado like '1%'
                order by 1";
$datos = $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();
if ($totalRows_datos == 0) {
?>
    <script type="text/javascript">
        alert('La busqueda asociada a este documento no arroja resultados, por favor verifique el documento o comuniquese con Secretaría General');
        /*
         * Caso 93513
         * @modified Luis Dario Gualteros C
         * <castroluisd@unbosque.edu.co>
         * Se modificó la pagina para el redireccionamiento cuando no hay resultados en la busqueda.
         * @since Agosto 29 de 2017
        */
        <?php
        if(isset($_REQUEST['token'])){

        ?>

        window.location.href='../certificados/certificadosGraduadosEstudiantes/';
        <?php
            }
            else
            {
        ?>
        window.location.href='certificadoestactivo2.php';
        <?php
        }
        ?>
        // End Caso 93513.
    </script>
<?php
} else {
    $row_datos = $datos->FetchRow();
    
        if ($row_datos['nombregenero']=="Masculino") {

               $trato="el señor";
              }
              else if ($row_datos['nombregenero']=="Femenino") {
                $trato="la señora";
              }
/*IDENTIFICADO*/
               if ($row_datos['nombregenero']=="Masculino") {

              $identificado="identificado";

              }
              else if ($row_datos['nombregenero']=="Femenino") {

               $identificado="identificada";

              }
    $orientacion = "P";
    $unidad = "mm";
    $formato = "Letter";
    $pdf = new PDF($orientacion, $unidad, $formato);
    $pdf->AddPage();
    $pdf->AddFont('Hum521Bd', 'B', 'Hum521Bd.php');
    $pdf->AddFont('Hum521It', 'B', 'Hum521It.php');
    $pdf->AddFont('Hum521Rm', 'B', 'Hum521Rm.php');
    $pdf->AddFont('Hum521bi', 'B', 'Hum521bi.php');
    $pdf->SetFont('Hum521Rm', 'B', 11);
    $pdf->SetTextColor(0, 0, 0);
    $nombresEstudiante = pasarMayusculas($row_datos['nombre']);
    /*
     * codigo para encabezado y pie de pagina del documento
     */
    $pdf->Image('encabezado.jpg', 0.2, 10.5, 230.5, 25);
    $pdf->Image('pie.jpg', 10, 250, 220, 28);

    /*
     * Codigo Para el cuerpo del documento
     */
    $pdf->SetFontSize(16);
    $pdf->SetY(45);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, 'SECRETARIA GENERAL', 0, 2, 'C');
    $pdf->SetY(52);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, utf8_decode('Oficina de Registro y Control Académico '), 0, 2, 'C');
    $pdf->Ln(10);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, utf8_decode('VERIFICACIÓN DE INFORMACIÓN ESTUDIANTE ACTIVO '), 0, 2, 'C');
    $pdf->Ln(15);
    $pdf->SetX(20);
    $pdf->SetFontSize(12);
    $pdf->MultiCell(0, 5.5, utf8_decode('La Secretaría General certifica que verificado el sistema académico de la universidad, se encuentra el registro de  '.$trato.' ' . $nombresEstudiante . ' '.$identificado.' con ' . $row_datos['nombredocumento'] . ' Nº ' . $row_datos['numerodocumento'] . ', quien adelanta estudios en esta institución, conforme a la siguiente información:'), 0, 'J');
    $pdf->Ln(10);
    $pdf->SetX(55);
    $pdf->SetFontSize(10);
    $pdf->celda(60, 5.5, 'PROGRAMA', 0, 'C', 1, 0);
    $pdf->SetX(55);
    $pdf->celda(40, 5.5, 'SEMESTRE ', 60, 'C', 1, 0);
    $pdf->SetFontSize(9);
    $datosestudiante = $row_datos;
  
    do {
        $pdf->Ln(6);
        $pdf->SetX(55);
        $pdf->celda(60, 5.5, utf8_decode($row_datos['nombrecarrera']), 0, 'C', 1, 0);

        if ($pdf->GetStringWidth($row_datos['nombrecarrera']) > 60) {
            $pdf->SetX(55);
            $pdf->celda(40, 5.5, $row_datos['semestre'], 60, 'C', 2, 0);
        } else {
            $pdf->SetX(55);
            $pdf->celda(40, 5.5, $row_datos['semestre'], 60, 'C', 1, 0);
        }
    } while ($row_datos = $datos->FetchRow());

    $pdf->Ln(10);
    $pdf->SetX(20);
    $pdf->SetFontSize(12);
    $pdf->MultiCell(0, 5.5, utf8_decode('Bogotá, D.C., ') . $dias[date('w')] . " " . date("d") . " de " . $meses[$mes] . " de " . date("Y,") . " hora " . $hora, 0, 'J');
    $pdf->Ln(15);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, 'SECRETARIA GENERAL ', 0, 2, 'L');
    $pdf->Ln(5);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, 'UNIVERSIDAD EL BOSQUE ', 0, 2, 'L');

    /* Query para insertar */
    $query_insert = "INSERT  INTO logdocumentacioncertificado
    (iddocumentacion, idestudiantegeneral, fechalogdocumentacioncertificado,
    codigologdocumentacioncertificado, iplogdocumentacioncertificado,codigoestado,
    observacionlogdocumentacioncertificado) VALUES(68,
    '{$datosestudiante['idestudiantegeneral']}','".$fechahoy.$hora."',' ',
    '{$_SERVER["REMOTE_ADDR"]}','100',' ')";
    $insert = $db->Execute($query_insert);
    /* Query para buscar el maximo */
    $query_consecutivo = "SELECT max(idlogdocumentacioncertificado) as consecutivo FROM logdocumentacioncertificado";
    $consecutivo = $db->Execute($query_consecutivo);
    $totalRows_consecutivo = $consecutivo->RecordCount();

    $row_consecutivo = $consecutivo->FetchRow();
    $consecutivo = $row_consecutivo['consecutivo'];
    $pdf->SetTextColor(250, 150, 100);
    $pdf->SetY(70);
    $pdf->SetX(20);
    $pdf->Cell(0, 0, utf8_decode('Nº: ') . $consecutivo, 0, 2, 'C');
    $pdf->Output();
}
?>
