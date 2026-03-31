<?php
function reemplazaCaractEsp($cadena) {
	$cadena=trim($cadena);
	$cadena=eregi_replace("[\n|\r|\n\r]"," ",$cadena);
	while (ereg("  ",$cadena)) {
		$cadena=str_replace("  "," ",$cadena);
	}	
	return $cadena;
}
function guardacontenidoprograma($FILES,$POST,$SESSION, $idcontenidoprogramatico , $query_pertenecemateria, $nombrepre, $nombreco, $sem, $db) {
    $fechahoy=date("Y-m-d H:i:s");

    /*
     * selecciona periodo para saber la fecha de inicio y fin
     */
    $query_fechaperiodo = "SELECT codigoperiodo, fechainicioperiodo, fechavencimientoperiodo FROM periodo where codigoperiodo = '".$SESSION['codigoperiodosesion']."' ";
    $fechaperiodo = $db->Execute ($query_fechaperiodo) or die("$query_fechaperiodo".mysql_error());
    $total_Rows_fechaperiodo = $fechaperiodo->RecordCount();
    $row_fechaperiodo = $fechaperiodo->FetchRow();
    /*
     * Inserta los datos basicos.
   */

    if(!isset($idcontenidoprogramatico) || $idcontenidoprogramatico==""){

        $query_guardar = "INSERT INTO contenidoprogramatico (idcontenidoprogramatico, codigomateria, codigoperiodo,
        fechainiciocontenidoprogramatico, fechafincontenidoprogramatico, usuario, codigoestado)
        values (0, '".$POST['codigomateria']."','".$SESSION['codigoperiodosesion']."',
        '".$row_fechaperiodo['fechainicioperiodo']."','".$row_fechaperiodo['fechavencimientoperiodo']."',
        '".$SESSION['MM_Username']."',100)";        
        $guardar = $db->execute ($query_guardar) or die("$query_guardar".mysql_error());
        $idcontenidoprogramatico = $db->Insert_ID();
 
    /*
     * Recorre y guarda la informacion de los tipos de contenidos.
     */
     

        foreach ($POST as $key => $valor){
            if(ereg ('observacion', $key)){
                $descrobser = ereg_replace('observacion',"",$key);
                //$contenido=eregi_replace("[\n|\r|\n\r]", ' ', $valor);
                $contenido=reemplazaCaractEsp($valor);
                 $query_guardadetalle = "INSERT INTO detallecontenidoprogramatico (iddetallecontenidoprogramatico,
                idcontenidoprogramatico,codigotipodetallecontenidoprogramatico, observaciondetallecontenidoprogramatico,
                 fechadetallecontenidoprogramatico, codigoestado)
                values (0, '$idcontenidoprogramatico','$descrobser','$contenido','$fechahoy',100)";
                $guardadetalle = $db->execute ($query_guardadetalle) or die("$query_guardadetalle".mysql_error());

            }//if
         }//foreach
    }//if
    elseif(isset($idcontenidoprogramatico) && $idcontenidoprogramatico!=""){

        foreach ($POST as $key => $valor){
            if(ereg ('observacion', $key)){
                $descrobser = ereg_replace('observacion',"",$key);
                //$contenido=eregi_replace("[\n|\r|\n\r]", ' ', $valor);
                $contenido=reemplazaCaractEsp($valor);

                $query_actualizadetalle="select iddetallecontenidoprogramatico
                from detallecontenidoprogramatico
                where idcontenidoprogramatico='$idcontenidoprogramatico'
                and codigotipodetallecontenidoprogramatico='$descrobser'
                and codigoestado like '1%'";
                $actualizadetalle= $db->Execute ($query_actualizadetalle) or die("$query_actualizadetalle".mysql_error());
                $total_Rows_actualizadetalle = $actualizadetalle->RecordCount();
                $row_actualizadetalle = $actualizadetalle->FetchRow();
                 
                $query_actualizarobservacion = "UPDATE detallecontenidoprogramatico SET observaciondetallecontenidoprogramatico='$contenido', 
                fechadetallecontenidoprogramatico='$fechahoy'
               where iddetallecontenidoprogramatico = '".$row_actualizadetalle['iddetallecontenidoprogramatico']."'";
               $actualizarobservacion= $db->Execute ($query_actualizarobservacion) or die("$query_actualizarobservacion".mysql_error());               

            }
         }//foreach       
    }//elseif
     
     




    /* verifica los archvios que se cargan y se actualiza la tabla con la url del archivo.
     *
     */
     
    if($FILES['contenidoprogramatico']['size']!=0){
        $nombre_archivo = $FILES['contenidoprogramatico']['name'];
        $tipo_archivo = $FILES['contenidoprogramatico']['type'];
        $tamano_archivo = $FILES['contenidoprogramatico']['size'];
        $nombrearchivocontenido="contenido/contenido_".$idcontenidoprogramatico.".pdf";


         $extension = explode(".",$nombre_archivo);
         //echo $extension[0]." ".$extension[1];
        if("pdf"!=$extension[1]) {
            echo "<script language='javascript'>
                alert('El archivo de contenido programatico debe ser de extensión PDF');
                </script>";
        }
        else if($tamano_archivo > 512000) {
            echo "<script language='javascript'>
                alert('El archivo de contenido programatico sobrepasa el tamaño adecuado para ser subido, maximo de 500Kb');
                </script>";
        }
         else {

            if(copy($FILES['contenidoprogramatico']['tmp_name'], "$nombrearchivocontenido")) {
                $archivo_cargado_ok=true;

               $query_actualizar = "UPDATE contenidoprogramatico SET urlcontenidoprogramatico='$nombrearchivocontenido'
               where idcontenidoprogramatico = '$idcontenidoprogramatico'";
               $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
               //echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";

               
            }
            else {
                $archivo_cargado_ok=false;
                echo "<script language='javascript'>
                alert('Ocurrió algún error al subir el fichero de contenido programatico. No pudo guardarse.');
                </script>";
            }
         }
    }

    
    if($FILES['actividadesmateria']['size']!=0){
        $nombre_actividad = $FILES['actividadesmateria']['name'];
        $tipo_actividad = $FILES['actividadesmateria']['type'];
        $tamano_actividad = $FILES['actividadesmateria']['size'];
        $nombrearchivoactividad="actividad/actividades_".$idcontenidoprogramatico.".pdf";


         $extension2 = explode(".",$nombre_actividad);
         //echo $extension[0]." ".$extension[1];
        if("pdf"!=$extension2[1]) {
            echo "<script language='javascript'>
                alert('El archivo de Actividades debe ser de extensión PDF');
                </script>";
        }
        else if($tamano_actividad > 512000) {
            echo "<script language='javascript'>
                alert('El archivo de Actividades sobrepasa el tamaño adecuado para ser subido, maximo de 500Kb');
                </script>";
        }
         else {

            if(copy($FILES['actividadesmateria']['tmp_name'], "$nombrearchivoactividad")) {
                $archivo_cargado_ok2=true;
               $query_actualizar2 = "UPDATE contenidoprogramatico SET urlactividadescontenidoprogramatico='$nombrearchivoactividad'
               where idcontenidoprogramatico = '$idcontenidoprogramatico'";
               $actualizar2= $db->Execute ($query_actualizar2) or die("$query_actualizar2".mysql_error());
               //echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
            }
            else {
                $archivo_cargado_ok2=false;
                echo "<script language='javascript'>
                alert('Ocurrió algún error al subir el fichero de actividades. No pudo guardarse.');
                </script>";
            }
         }
    }

 generapdf($query_pertenecemateria, $nombrepre, $nombreco, $sem, $idcontenidoprogramatico, $nombrearchivocontenido, $db);
 generasyllabus($query_pertenecemateria, $nombrepre, $nombreco, $sem, $idcontenidoprogramatico, $nombrearchivocontenido, $db);
 echo "<script language='javascript'>
            window.location.href = 'contenidoprograma.php?codigomateria=".$POST['codigomateria']."'
            </script>";
}


function generapdf($query_pertenecemateria, $nombrepre, $nombreco, $sem, $idcontenidoprogramatico, $nombrearchivocontenido, $db) {

require('../../../../funciones/clases/fpdf/fpdf.php');

$query_datospdf=$query_pertenecemateria;
$datospdf= $db->Execute ($query_datospdf) or die("$query_datospdf".mysql_error());
$total_Rows_datospdf = $datospdf->RecordCount();
$row_datospdf=$datospdf->FetchRow();
$horaspresencialessemestre=$row_datospdf['numerohorassemanales']*$row_datospdf['numerosemana'];
$horastotales= 48 * $row_datospdf['numerocreditosdetalleplanestudio'];
$horastrabajoindependiente=$row_datospdf['numerohorassemanales']*2;

$imagen= "../../../../../imagenes/formato_institucional.jpg";

$orientacion = "P";
$unidad = "mm";
$formato = "Letter";

$pdf=new FPDF($orientacion, $unidad, $formato);
//$pdf->Cabecera($imagen);
$pdf->AddPage();
$pdf->Image($imagen,25,10,180);
$pdf->SetFont('Arial','B',9);
$pdf->SetY(40);
$pdf->Setx(20);
$pdf->Cell(57,4,"Facultad",1,2,'L');

$pdf->SetY(44);
$pdf->Setx(20);
$pdf->Cell(57,4,"Programa",1,2,'L');

$pdf->SetY(48);
$pdf->Setx(20);
$pdf->Cell(57,4,"Nombre de la Asignatura",1,2,'L');

$pdf->SetY(52);
$pdf->Setx(20);
$pdf->Cell(57,4,"Código  de la Asignatura",1,2,'L');

$pdf->SetY(56);
$pdf->Setx(20);
$pdf->Cell(57,4,"Periodo de la Asignatura",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(20);
$pdf->Cell(57,4,"Tipo de Asignatura",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(20);
$pdf->Cell(57,4,"Modalidad Asignatura en %",1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(40);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombrefacultad'],1,2,'L');

$pdf->SetY(44);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombrecarrera'],1,2,'L');

$pdf->SetY(48);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombremateria'],1,2,'L');

$pdf->SetY(52);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['codigomateria'],1,2,'L');

$pdf->SetY(56);
$pdf->Setx(77);
$pdf->Cell(125,4,$_SESSION['codigoperiodosesion'],1,2,'L');

/*
 * tipo materias
 */
$pdf->SetY(60);
$pdf->Setx(77);
$pdf->Cell(125,4,"Obligatoria",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(95);
if($row_datospdf['codigotipomateria']==1){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(98);
$pdf->Cell(104,4,"Propuesta",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(115);
if($row_datospdf['codigotipomateria']==2){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(118);
$pdf->Cell(84,4,"Sugerida",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(133);
if($row_datospdf['codigotipomateria']==3){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(136);
$pdf->Cell(66,4,"Electivas Libres",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(160);
if($row_datospdf['codigotipomateria']==4){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(163);
$pdf->Cell(39,4,"Electivas Obligatorias",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(196);
if($row_datospdf['codigotipomateria']==4){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

/*
 * fin materias
 *
 * inicio porcentaje
 */
$pdf->SetY(64);
$pdf->Setx(77);
$pdf->Cell(125,4,"Teórica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(92);
$pdf->Cell(10,4,$row_datospdf['porcentajeteoricamateria'],1,2,'C');

$pdf->SetY(64);
$pdf->Setx(102);
$pdf->Cell(100,4,"Práctica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(117);
$pdf->Cell(10,4,$row_datospdf['porcentajepracticamateria'],1,2,'C');

$pdf->SetY(64);
$pdf->Setx(127);
$pdf->Cell(75,4,"Teórica-Práctica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(153);
$pdf->Cell(10,4,"0",1,2,'C');

$pdf->SetY(64);
$pdf->Setx(163);
$pdf->Cell(39,4,"Salidas de Campo",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(192);
$pdf->Cell(10,4,"0",1,2,'C');
/*
 Fin porcentajes
 */

$pdf->SetY(68);
$pdf->Setx(20);
$pdf->Cell(63,4,"Semestre al que corresponde la asignatura:",1,2,'R');

$pdf->SetY(68);
$pdf->Setx(83);
$pdf->Cell(119,4,$sem,1,2,'L');

$pdf->SetY(72);
$pdf->Setx(20);
$pdf->Cell(63,4,"Pre-requisitos:",1,2,'R');

$pdf->SetFont('Arial','',7);
$pdf->SetY(72);
$pdf->Setx(83);
$pdf->Cell(119,4,$nombrepre,1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(76);
$pdf->Setx(20);
$pdf->Cell(63,4,"Co-requisitos:",1,2,'R');

$pdf->SetFont('Arial','',7);
$pdf->SetY(76);
$pdf->Setx(83);
$pdf->Cell(119,4,$nombreco,1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(80);
$pdf->Setx(20);
$pdf->Cell(63,4,"Número de créditos:",1,2,'R');

$pdf->SetY(80);
$pdf->Setx(83);
$pdf->Cell(119,4,$row_datospdf['numerocreditosdetalleplanestudio'],1,2,'L');

$pdf->SetY(80);
$pdf->Setx(140);
$pdf->Cell(62,4,"Número horas semestrales:",1,2,'L');

$pdf->SetY(80);
$pdf->Setx(181);
$pdf->Cell(21,4,$horaspresencialessemestre,1,2,'L');

$pdf->SetY(84);
$pdf->Setx(20);
$pdf->Cell(63,4,"Horas presenciales / semana",1,2,'R');

$pdf->SetY(84);
$pdf->Setx(83);
$pdf->Cell(119,4,$row_datospdf['numerohorassemanales'],1,2,'L');

$pdf->SetY(84);
$pdf->Setx(120);
$pdf->Cell(82,4,"Horas de trabajo independiente / semana",1,2,'L');

$pdf->SetY(84);
$pdf->Setx(181);
$pdf->Cell(21,4,$horastrabajoindependiente,1,2,'L');

/*
 * tipos de contenidos y descripcion correspondiente
 */

$query_tipocontenido="SELECT codigotipodetallecontenidoprogramatico, nombretipodetallecontenidoprogramatico
FROM tipodetallecontenidoprogramatico
where codigoestado like '1%'";
$tipocontenido = $db->Execute ($query_tipocontenido) or die("$query_tipocontenido".mysql_error());
$total_Rows_tipocontenido = $tipocontenido->RecordCount();
$posicion=0;
$ytipo=100;
$ycontenido=104;
$pdf->SetFont('Arial','B',9);
$pdf->SetY($ytipo);
$pdf->Setx(30);
while ($row_tipocontenido = $tipocontenido->FetchRow()) {

    $query_contenido="SELECT d.iddetallecontenidoprogramatico, d.codigotipodetallecontenidoprogramatico,
    d.observaciondetallecontenidoprogramatico, t.nombretipodetallecontenidoprogramatico
    FROM detallecontenidoprogramatico d, tipodetallecontenidoprogramatico t
    where d.idcontenidoprogramatico='$idcontenidoprogramatico'
    and d.codigotipodetallecontenidoprogramatico='".$row_tipocontenido['codigotipodetallecontenidoprogramatico']."'
    and d.codigotipodetallecontenidoprogramatico=t.codigotipodetallecontenidoprogramatico
    and d.codigoestado like '1%'
    and t.codigoestado like '1%'";
    $contenido = $db->Execute ($query_contenido) or die("$query_contenido".mysql_error());
    $total_Rows_contenido = $contenido->RecordCount();
    $row_contenido = $contenido->FetchRow();

    if($posicion==0){
       $pdf->MultiCell(120,4,$row_tipocontenido['nombretipodetallecontenidoprogramatico'],0,'L');

       $pdf->SetFont('Arial','',8);
       $pdf->SetY($ycontenido);
       $pdf->Setx(20);
       $pdf->MultiCell(182,4,$row_contenido['observaciondetallecontenidoprogramatico'],1,'J');       

    }
    else{
        if($tamanoobs >=0 && $tamanoobs <=300){
        $ytipo=$ytipo+25;
        $ycontenido=$ycontenido+25;
        }
        else{
            $ytipo=$ytipo+40;
            $ycontenido=$ycontenido+40;
        }
        //if($tamanoobs >300 && $tamanoobs <=300)
        $pdf->SetFont('Arial','B',9);
        $pdf->SetY($ytipo);
        $pdf->Setx(30);
        $pdf->MultiCell(120,4,$row_tipocontenido['nombretipodetallecontenidoprogramatico'],0,'L');

        
        $pdf->SetFont('Arial','',8);
        $pdf->SetY($ycontenido);
        $pdf->Setx(20);
        $pdf->MultiCell(182,4,$row_contenido['observaciondetallecontenidoprogramatico'],1,'J');

    }
$tamanoobs=strlen($row_contenido['observaciondetallecontenidoprogramatico']);
$posicion++;
}
$formatoinstitucional="institucional/previo_".$idcontenidoprogramatico.".pdf";
$pdf->Output($formatoinstitucional, 'F');
/*
 * Fin del pdf cabezote
 */


$definitivo="institucional/institucional_".$idcontenidoprogramatico.".pdf";
if(isset($nombrearchivocontenido) && $nombrearchivocontenido !=""){
  
  $url="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/archivoejecucioncontenidoprograma.php?formatoinstitucional=".$formatoinstitucional."&nombrearchivocontenido=".$nombrearchivocontenido."&definitivo=".$definitivo;
  $ejecucionpdf = file_get_contents($url);

  touch($definitivo);
  $newfile = fopen($definitivo, "w");
  fputs ($newfile, $ejecucionpdf);
  fclose ($newfile);

  $ejecuta2=shell_exec('rm '.$formatoinstitucional);
  $query_actualizar = "UPDATE contenidoprogramatico SET urlaarchivofinalcontenidoprogramatico='$definitivo'
  where idcontenidoprogramatico = '$idcontenidoprogramatico'";
  $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
  
}
else{
    $query_url="SELECT c.idcontenidoprogramatico, c.urlcontenidoprogramatico
    FROM contenidoprogramatico c
    where c.idcontenidoprogramatico=$idcontenidoprogramatico
    and  c.codigoestado like '1%'";
    $url = $db->Execute ($query_url) or die("$query_url".mysql_error());
    $total_Rows_url = $url->RecordCount();
    $row_url = $url->FetchRow();
    if($row_url['urlcontenidoprogramatico']!=""){        

        $nombrearchivocontenido=$row_url['urlcontenidoprogramatico'];
        $url="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/archivoejecucioncontenidoprograma.php?formatoinstitucional=".$formatoinstitucional."&nombrearchivocontenido=".$nombrearchivocontenido."&definitivo=".$definitivo;
        $ejecucionpdf = file_get_contents($url);

        touch($definitivo);
        $newfile = fopen($definitivo, "w");
        fputs ($newfile, $ejecucionpdf);
        fclose ($newfile);
        $ejecuta2=shell_exec('rm '.$formatoinstitucional);

        
        $query_actualizar = "UPDATE contenidoprogramatico SET urlaarchivofinalcontenidoprogramatico='$definitivo'
        where idcontenidoprogramatico = '$idcontenidoprogramatico'";
        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
    }
}

}

function generasyllabus($query_pertenecemateria, $nombrepre, $nombreco, $sem, $idcontenidoprogramatico, $nombrearchivocontenido, $db) {

require('../../../../funciones/clases/fpdf/fpdf.php');

$query_datospdf=$query_pertenecemateria;
$datospdf= $db->Execute ($query_datospdf) or die("$query_datospdf".mysql_error());
$total_Rows_datospdf = $datospdf->RecordCount();
$row_datospdf=$datospdf->FetchRow();
$horaspresencialessemestre=$row_datospdf['numerohorassemanales']*$row_datospdf['numerosemana'];
$horastotales= 48 * $row_datospdf['numerocreditosdetalleplanestudio'];
$horastrabajoindependiente=$horastotales-$horaspresencialessemestre;

$imagen= "../../../../../imagenes/syllabus_institucional.jpg";

$orientacion = "P";
$unidad = "mm";
$formato = "Letter";

$pdf=new FPDF($orientacion, $unidad, $formato);
//$pdf->Cabecera($imagen);
$pdf->AddPage();
$pdf->Image($imagen,25,10,180);
$pdf->SetFont('Arial','B',9);
$pdf->SetY(40);
$pdf->Setx(20);
$pdf->Cell(57,4,"Facultad",1,2,'L');

$pdf->SetY(44);
$pdf->Setx(20);
$pdf->Cell(57,4,"Programa",1,2,'L');

$pdf->SetY(48);
$pdf->Setx(20);
$pdf->Cell(57,4,"Nombre de la Asignatura",1,2,'L');

$pdf->SetY(52);
$pdf->Setx(20);
$pdf->Cell(57,4,"Código  de la Asignatura",1,2,'L');

$pdf->SetY(56);
$pdf->Setx(20);
$pdf->Cell(57,4,"Periodo de la Asignatura",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(20);
$pdf->Cell(57,4,"Tipo de Asignatura",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(20);
$pdf->Cell(57,4,"Modalidad Asignatura en %",1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(40);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombrefacultad'],1,2,'L');

$pdf->SetY(44);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombrecarrera'],1,2,'L');

$pdf->SetY(48);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['nombremateria'],1,2,'L');

$pdf->SetY(52);
$pdf->Setx(77);
$pdf->Cell(125,4,$row_datospdf['codigomateria'],1,2,'L');

$pdf->SetY(56);
$pdf->Setx(77);
$pdf->Cell(125,4,$_SESSION['codigoperiodosesion'],1,2,'L');

/*
 * tipo materias
 */
$pdf->SetY(60);
$pdf->Setx(77);
$pdf->Cell(125,4,"Obligatoria",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(95);
if($row_datospdf['codigotipomateria']==1){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(98);
$pdf->Cell(104,4,"Propuesta",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(115);
if($row_datospdf['codigotipomateria']==2){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(118);
$pdf->Cell(84,4,"Sugerida",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(133);
if($row_datospdf['codigotipomateria']==3){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(136);
$pdf->Cell(66,4,"Electivas Libres",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(160);
if($row_datospdf['codigotipomateria']==4){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

$pdf->SetY(60);
$pdf->Setx(163);
$pdf->Cell(39,4,"Electivas Obligatorias",1,2,'L');

$pdf->SetY(60);
$pdf->Setx(196);
if($row_datospdf['codigotipomateria']==4){
$pdf->Cell(3,4,"x",1,2,'C');
}
else{
    $pdf->Cell(3,4,"",1,2,'C');
}

/*
 * fin materias
 *
 * inicio porcentaje
 */
$pdf->SetY(64);
$pdf->Setx(77);
$pdf->Cell(125,4,"Teórica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(92);
$pdf->Cell(10,4,$row_datospdf['porcentajeteoricamateria'],1,2,'C');

$pdf->SetY(64);
$pdf->Setx(102);
$pdf->Cell(100,4,"Práctica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(117);
$pdf->Cell(10,4,$row_datospdf['porcentajepracticamateria'],1,2,'C');

$pdf->SetY(64);
$pdf->Setx(127);
$pdf->Cell(75,4,"Teórica-Práctica",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(153);
$pdf->Cell(10,4,"0",1,2,'C');

$pdf->SetY(64);
$pdf->Setx(163);
$pdf->Cell(39,4,"Salidas de Campo",1,2,'L');

$pdf->SetY(64);
$pdf->Setx(192);
$pdf->Cell(10,4,"0",1,2,'C');
/*
 Fin porcentajes
 */

$pdf->SetY(68);
$pdf->Setx(20);
$pdf->Cell(63,4,"Semestre al que corresponde la asignatura:",1,2,'R');

$pdf->SetY(68);
$pdf->Setx(83);
$pdf->Cell(119,4,$sem,1,2,'L');

$pdf->SetY(72);
$pdf->Setx(20);
$pdf->Cell(63,4,"Pre-requisitos:",1,2,'R');

$pdf->SetFont('Arial','',7);
$pdf->SetY(72);
$pdf->Setx(83);
$pdf->Cell(119,4,$nombrepre,1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(76);
$pdf->Setx(20);
$pdf->Cell(63,4,"Co-requisitos:",1,2,'R');

$pdf->SetFont('Arial','',7);
$pdf->SetY(76);
$pdf->Setx(83);
$pdf->Cell(119,4,$nombreco,1,2,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetY(80);
$pdf->Setx(20);
$pdf->Cell(63,4,"Número de créditos:",1,2,'R');

$pdf->SetY(80);
$pdf->Setx(83);
$pdf->Cell(119,4,$row_datospdf['numerocreditosdetalleplanestudio'],1,2,'L');

$pdf->SetY(80);
$pdf->Setx(140);
$pdf->Cell(62,4,"Número horas semestrales:",1,2,'L');

$pdf->SetY(80);
$pdf->Setx(181);
$pdf->Cell(21,4,$horaspresencialessemestre,1,2,'L');

$pdf->SetY(84);
$pdf->Setx(20);
$pdf->Cell(63,4,"Horas presenciales / semana",1,2,'R');

$pdf->SetY(84);
$pdf->Setx(83);
$pdf->Cell(119,4,$row_datospdf['numerohorassemanales'],1,2,'L');

$pdf->SetY(84);
$pdf->Setx(120);
$pdf->Cell(82,4,"Horas de trabajo independiente / semana",1,2,'L');

$pdf->SetY(84);
$pdf->Setx(181);
$pdf->Cell(21,4,$horastrabajoindependiente,1,2,'L');

/*
 * tipos de contenidos y descripcion correspondiente
 */

$query_tipocontenido="SELECT codigotipodetallecontenidoprogramatico, nombretipodetallecontenidoprogramatico
FROM tipodetallecontenidoprogramatico
where codigoestado like '1%'";
$tipocontenido = $db->Execute ($query_tipocontenido) or die("$query_tipocontenido".mysql_error());
$total_Rows_tipocontenido = $tipocontenido->RecordCount();
$posicion=0;
$ytipo=100;
$ycontenido=104;
$pdf->SetFont('Arial','B',9);
$pdf->SetY($ytipo);
$pdf->Setx(30);
while ($row_tipocontenido = $tipocontenido->FetchRow()) {

    $query_contenido="SELECT d.iddetallecontenidoprogramatico, d.codigotipodetallecontenidoprogramatico,
    d.observaciondetallecontenidoprogramatico, t.nombretipodetallecontenidoprogramatico
    FROM detallecontenidoprogramatico d, tipodetallecontenidoprogramatico t
    where d.idcontenidoprogramatico='$idcontenidoprogramatico'
    and d.codigotipodetallecontenidoprogramatico='".$row_tipocontenido['codigotipodetallecontenidoprogramatico']."'
    and d.codigotipodetallecontenidoprogramatico=t.codigotipodetallecontenidoprogramatico
    and d.codigoestado like '1%'
    and t.codigoestado like '1%'";
    $contenido = $db->Execute ($query_contenido) or die("$query_contenido".mysql_error());
    $total_Rows_contenido = $contenido->RecordCount();
    $row_contenido = $contenido->FetchRow();

    if($posicion==0){
       $pdf->MultiCell(120,4,$row_tipocontenido['nombretipodetallecontenidoprogramatico'],0,'L');

       $pdf->SetFont('Arial','',8);
       $pdf->SetY($ycontenido);
       $pdf->Setx(20);
       $pdf->MultiCell(182,4,$row_contenido['observaciondetallecontenidoprogramatico'],1,'J');

    }
    else{
        if($tamanoobs >=0 && $tamanoobs <=300){
        $ytipo=$ytipo+25;
        $ycontenido=$ycontenido+25;
        }
        else{
            $ytipo=$ytipo+40;
            $ycontenido=$ycontenido+40;
        }
        //if($tamanoobs >300 && $tamanoobs <=300)
        $pdf->SetFont('Arial','B',9);
        $pdf->SetY($ytipo);
        $pdf->Setx(30);
        $pdf->MultiCell(120,4,$row_tipocontenido['nombretipodetallecontenidoprogramatico'],0,'L');


        $pdf->SetFont('Arial','',8);
        $pdf->SetY($ycontenido);
        $pdf->Setx(20);
        $pdf->MultiCell(182,4,$row_contenido['observaciondetallecontenidoprogramatico'],1,'J');

    }
$tamanoobs=strlen($row_contenido['observaciondetallecontenidoprogramatico']);
$posicion++;
}
$syllabusinstitucional="institucional/syllabus_".$idcontenidoprogramatico.".pdf";
$pdf->Output($syllabusinstitucional, 'F');

$query_syllabus = "UPDATE contenidoprogramatico SET urlasyllabuscontenidoprogramatico='$syllabusinstitucional'
        where idcontenidoprogramatico = '$idcontenidoprogramatico'";
        $syllabus= $db->Execute ($query_syllabus) or die("$query_syllabus".mysql_error());

/*
 * Fin del pdf cabezote
 */

}



?>
