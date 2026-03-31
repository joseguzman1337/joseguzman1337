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

}//casll fpdf

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
" WHERE token = '".$_REQUEST['token']."' ".
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

$query_datos = "SELECT g.nombregenero,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ', ".
" eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo, ".
" r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo, r.numerodiplomaregistrograduadoantiguo, ".
" d.tipodocumento,d.nombredocumento ".
" FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r, documento d, genero g ".
" where eg.numerodocumento = '".$documento."' ".
" and e.codigoestudiante=r.codigoestudiante  and g.codigogenero=eg.codigogenero ".
" and eg.idestudiantegeneral=e.idestudiantegeneral ".
" and eg.tipodocumento= d.tipodocumento ".
" union ".
" SELECT  g.nombregenero,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ', ".
" eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado,".
" r.fechagradoregistrograduado, r.numerodiplomaregistrograduado,d.tipodocumento,d.nombredocumento ".
" FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t, documento d, genero g ".
" where eg.numerodocumento =  '".$documento."' ".
" and eg.idestudiantegeneral=e.idestudiantegeneral  and g.codigogenero=eg.codigogenero ".
" and e.codigocarrera=c.codigocarrera ".
" and e.codigoestudiante=r.codigoestudiante ".
" and c.codigotitulo=t.codigotitulo ".
" and eg.tipodocumento= d.tipodocumento ".
" UNION ".
" SELECT G.nombregenero, EG.idestudiantegeneral, CONCAT( EG.nombresestudiantegeneral, ' ', ".
" EG.apellidosestudiantegeneral ) AS nombre, EG.numerodocumento, T.nombretitulo, ".
" A.NumeroActaAcuerdo, DATE_FORMAT(A.FechaAcuerdo,'%Y-%m-%d'), ".
" R.NumeroDiploma, DT.tipodocumento, DT.nombredocumento ".
" FROM estudiantegeneral EG ".
" INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral ) ".
" INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera ) ".
" INNER JOIN FechaGrado F ON ( F.CarreraId = C.codigocarrera ) ".
" INNER JOIN AcuerdoActa A ON ( A.FechaGradoId = F.FechaGradoId ) ".
" INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId AND D.EstudianteId = E.codigoestudiante ) ".
" INNER JOIN RegistroGrado R ON ( R.AcuerdoActaId = A.AcuerdoActaId AND R.EstudianteId = E.codigoestudiante ) ".
" INNER JOIN titulo T ON ( T.codigotitulo = C.codigotitulo ) ".
" INNER JOIN documento DT ON ( DT.tipodocumento = EG.tipodocumento ) ".
" INNER JOIN genero G ON ( G.codigogenero = EG.codigogenero ) ".
" WHERE EG.numerodocumento = '".$documento."' AND D.CodigoEstado = 100 AND R.CodigoEstado = 100";
$datos = $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();

if ($totalRows_datos == 0) {
    ?>
    <script type="text/javascript">
        alert('La busqueda asociada a este documento no arroja resultados, por favor verifique el documento o comuniquese con Secretaria General al correo verificaciontitulos@unbosque.edu.co');

        <?php
        if(isset($_REQUEST['token'])){
        ?>
            window.location.href='../certificados/certificadosGraduadosEstudiantes/';
        <?php
        }else{
        ?>
        window.location.href='certificadoegresado2.php';
        <?php
        }
        ?>
       
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
    $pdf->Cell(0, 0, utf8_decode('VERIFICACIÓN DE TÍTULO '), 0, 2, 'C');
    $pdf->SetY(75);
    $pdf->SetX(20);
    $pdf->SetFontSize(12);
    $pdf->MultiCell(0, 5.5, utf8_decode('La Secretaría General certifica que verificado el sistema académico de la universidad, se encuentra el registro de '.$trato.' '  . $nombresEstudiante . ' '.$identificado.' con '. $row_datos['nombredocumento'] . ' Nº ' . $row_datos['numerodocumento'] . ', quien cursó y aprobó los estudios y obtuvo el título respectivo en esta institución conforme a la siguiente información:'), 0, 'J');
    $pdf->Ln(10.5);
    $pdf->SetX(25);
    $pdf->SetFontSize(10);
    $pdf->celda(80, 5.5, 'TITULO OBTENIDO', 0, 'C', 1, 1);
    $pdf->SetX(25);
    $pdf->celda(70, 5.5, 'ACTA Y FECHA DE GRADO ', 80, 'C', 1, 1);
    $pdf->SetX(25);
    $pdf->celda(25, 5.5, utf8_decode('DIPLOMA Nº'), 150, 'J', 1, 1);
    $pdf->SetY(107.5);
    $pdf->SetFontSize(9);
   $datosestudiante=$row_datos;
          
          
    
    do {

        $pdf->Ln(5.5);
        $pdf->SetX(25);
        $pdf->celda(80, 5.5, utf8_decode($row_datos['tituloregistrograduadoantiguo']), 0, 'C', 1, 1);

        if ($pdf->GetStringWidth($row_datos['tituloregistrograduadoantiguo']) > 83) {

            $pdf->SetX(25);
            $pdf->celda(70, 5.5, $row_datos['numeroactaregistrograduadoantiguo'] . "  -  " . $row_datos['fechagradoregistrograduadoantiguo'] . "\n ", 80, 'C', 2, 1);
            $pdf->SetX(25);
            $pdf->celda(25, 5.5, $row_datos['numerodiplomaregistrograduadoantiguo'] . " \n ", 150, 'C', 2, 1);
       } else { 
            $pdf->SetX(25);
            $pdf->celda(70, 5.5, $row_datos['numeroactaregistrograduadoantiguo'] . "  -  " . $row_datos['fechagradoregistrograduadoantiguo'], 80, 'C', 1, 1);
            $pdf->SetX(25);
            $pdf->celda(25, 5.5, $row_datos['numerodiplomaregistrograduadoantiguo'], 150, '', 1, 1);
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
    $query_insert = "INSERT  INTO logdocumentacioncertificado ".
    " (iddocumentacion, idestudiantegeneral, fechalogdocumentacioncertificado, ".
    " codigologdocumentacioncertificado, iplogdocumentacioncertificado,codigoestado, ".
    " observacionlogdocumentacioncertificado) VALUES(67, ".
    " '{$datosestudiante['idestudiantegeneral']}','".$fechahoy.$hora."',' ', ".
    " '{$_SERVER["REMOTE_ADDR"]}','100',' ')";
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