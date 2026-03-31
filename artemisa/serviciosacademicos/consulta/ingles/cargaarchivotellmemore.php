<?php
function cargaarchivotellmemore($_FILES,$_POST,$db) {
    $fechahoy=date("Y-m-d H:i:s");
    $nombre_archivo = $_FILES['resultados']['name'];
    $tipo_archivo = $_FILES['resultados']['type'];
    $tamano_archivo = $_FILES['resultados']['size'];

    $codigoperiodo=$_SESSION['codigoperiodosesion'];

    require_once('../../funciones/funcionip.php' );
	$ip = "SIN DEFINIR";
	$ip = tomarip();
    if(isset($_SESSION['codigodocente'])){
        $docusuario=$_SESSION['codigodocente'];
    }
    elseif(isset($_SESSION['codigofacultad'])){
        $docusuario=$_SESSION['codigofacultad'];
    }

     $extension = explode(".",$nombre_archivo);
     //echo $extension[0]." ".$extension[1];
    if("xls"!=$extension[1]) {
        echo "<script language='javascript'>
            alert('El archivo debe ser de excel');
            </script>";
    }
    else if($tamano_archivo > 2000000) {
        echo "<script language='javascript'>
            alert('El archivo sobrepasa el tamaño adecuado para ser subido, maximo de 2Mb');
            </script>";
    }
    else {

        if(copy($_FILES['resultados']['tmp_name'], "/tmp/resultados.xls")) {
            $archivo_cargado_ok=true;            
            $archivo= fopen("tellmemore.txt","w");
            fwrite($archivo,"Log de Errores Notas Tell Me More.\n\n");
             fclose($archivo);


            $dataexcel = new Spreadsheet_Excel_Reader();
            $dataexcel->setOutputEncoding('CP1251');
            $dataexcel->read('/tmp/resultados.xls');
            for($i=1; $i<=$dataexcel->sheets[0]['numRows']; $i++) {
                $materia=trim($dataexcel->sheets[0]['cells'][$i][1]);
                $numerodocumento=trim($dataexcel->sheets[0]['cells'][$i][2]);
                $corte=trim($dataexcel->sheets[0]['cells'][$i][3]);
                $nota=trim($dataexcel->sheets[0]['cells'][$i][4]);                
                //echo $materia." ".$numerodocumento." ".$corte." ".$nota." ".$modificacion."<br>";
                if($materia=="" || $numerodocumento=="" || $corte=="" || $nota==""){
                    $archivo= fopen("tellmemore.txt","a");
                    fwrite($archivo,"Fila= ".$i.", datos Vacios.\n");
                    fclose($archivo);
                }
                else{
                    /*
                     * Query para verificar que el chino tenga la materia matriculada en el periodo correspondiente
                     */
                    $query_consulta="SELECT  eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,
                    est.codigoperiodo,est.codigocarrera, m.nombremateria,m.codigomateria,d.codigomateriaelectiva,m.numerocreditos,g.idgrupo,p.codigoestudiante
                    FROM estudiante est,estudiantegeneral eg, prematricula p,detalleprematricula d,materia m,grupo g
                    WHERE est.idestudiantegeneral = eg.idestudiantegeneral
                    AND eg.numerodocumento='$numerodocumento'
                    and p.codigoestudiante = est.codigoestudiante
                    AND p.idprematricula = d.idprematricula
                    AND d.codigomateria = m.codigomateria
                    AND d.idgrupo = g.idgrupo
                    AND m.codigoestadomateria = '01'
                    AND g.codigoperiodo = '$codigoperiodo'
                    AND p.codigoestadoprematricula LIKE '4%'
                    AND d.codigoestadodetalleprematricula LIKE '3%'
                    and m.codigomateria='$materia'";
                    $consulta= $db->Execute($query_consulta);
                    $totalRows_consulta = $consulta->RecordCount();
                    $row_consulta = $consulta->FetchRow();

                    if($totalRows_consulta > 0 && isset($numerodocumento)){

                        /*
                         * Consulta que determina si existe el corte y si la nota que se va a ingresar esta en la fechas
                         * del corte correspondiente
                         */
                        $query_cortes="SELECT * FROM materia m, corte c where m.codigomateria = '$materia'
                        and c.codigocarrera=m.codigocarrera
                        and c.codigoperiodo = '$codigoperiodo'
                        and '$corte' between numerocorte and numerocorte
                        and '$fechahoy' between fechainicialcorte and fechafinalcorte";
                        $cortes= $db->Execute($query_cortes);
                        $totalRows_cortes = $cortes->RecordCount();
                        $row_cortes = $cortes->FetchRow();

                        if($totalRows_cortes != 0){

                            /*
                             * Query para determinar si existe registro en la tabla nota
                             */
                            $query_tablanota="SELECT * FROM nota
                                where
                                idcorte='".$row_cortes['idcorte'] ."'
                                and idgrupo='".$row_consulta['idgrupo']."'";
                            $tablanota= $db->Execute($query_tablanota);
                            $totalRows_tablanota = $tablanota->RecordCount();
                            $row_tablanota = $tablanota->FetchRow();

                            if($totalRows_tablanota !=0){                                
                                /*
                                 * Query para verificar con los datos que se suben si el chino ya tiene
                                 * registro de nota en la tabla detallenota o no.
                                 */
                                $query_consultanota="SELECT * FROM detallenota d,nota n
                                    WHERE d.idcorte=n.idcorte
                                    and d.idcorte = '".$row_cortes['idcorte'] ."'
                                    AND d.codigomateria = '$materia'
                                    and d.codigoestudiante ='".$row_consulta['codigoestudiante']."'
                                    and d.idgrupo=n.idgrupo";
                                $consultanota= $db->Execute($query_consultanota);
                                $totalRows_consultanota = $consultanota->RecordCount();
                                $row_consultanota= $consultanota->FetchRow();
                                if($totalRows_consultanota ==0){
                                    /*
                                     * Validación de la nota
                                     */
                                    if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $nota))){
                                        $archivo= fopen("tellmemore.txt","a");
                                        fwrite($archivo,"Documento= ".$numerodocumento.", Nota con formato o rango de calificación No valido.\n");
                                        fclose($archivo);                                        
                                    }
                                    else{
                                        /*
                                         * Insercion en auditoria y detallenota
                                         */                                        
                                        $query_auditoria="INSERT INTO auditoria(numerodocumento,usuario,
                                        fechaauditoria, codigomateria, grupo,codigoestudiante,notaanterior,
                                        notamodificada, corte,tipoauditoria,ip)
                                        VALUES( '$docusuario', '".$_SESSION['MM_Username']."', '$fechahoy',
                                        '$materia', '".$row_consulta['idgrupo']."', '".$row_consulta['codigoestudiante']."',
                                         '0.0', '$nota','".$row_cortes['idcorte'] ."',10,'$ip')";
                                        $auditoria = $db->Execute($query_auditoria) or die(mysql_error());

                                        $query_insertdetallenota="INSERT INTO detallenota (idgrupo,idcorte,
                                        codigoestudiante,codigomateria,nota,numerofallasteoria,numerofallaspractica,
                                        codigotiponota)
                                        VALUES('".$row_consulta['idgrupo']."', '".$row_cortes['idcorte'] ."',
                                        '".$row_consulta['codigoestudiante']."','$materia', '$nota', 0, 0,10)";
                                        $insertdetallenota = $db->Execute($query_insertdetallenota) or die(mysql_error());

                                    }
                                }
                                else{
                                    $archivo= fopen("tellmemore.txt","a");
                                    fwrite($archivo,"Documento= ".$numerodocumento.", El estudiante ya tiene una nota para este corte no se puede modificar la nota.\n");
                                    fclose($archivo);
                                }

                            }
                            else{
                                /*
                                 * Inserta el registro de Nota
                                 */
                                $query_insertnota = "INSERT INTO nota (idgrupo,idcorte,fechaorigennota,actividadesacademicasteoricanota,
                                    actividadesacademicaspracticanota,fechaultimoregistronota,codigotipoequivalencianota)
                                    values ('".$row_consulta['idgrupo']."', '".$row_cortes['idcorte']."', '$fechahoy', 0,
                                    0, '$fechahoy', 10)";
                                $insertnota = $db->Execute($query_insertnota) or die(mysql_error());                                

                                /*
                                 * Query para verificar con los datos que se suben si el chino ya tiene
                                 * registro de nota en la tabla detallenota o no.
                                 */
                                $query_consultanota="SELECT * FROM detallenota d,nota n
                                    WHERE d.idcorte=n.idcorte
                                    and d.idcorte = '".$row_cortes['idcorte'] ."'
                                    AND d.codigomateria = '$materia'
                                    and d.codigoestudiante ='".$row_consulta['codigoestudiante']."'
                                    and d.idgrupo=n.idgrupo";
                                $consultanota= $db->Execute($query_consultanota);
                                $totalRows_consultanota = $consultanota->RecordCount();
                                $row_consultanota= $consultanota->FetchRow();
                                if($totalRows_consultanota ==0){
                                    /*
                                     * Validación de la nota
                                     */
                                    if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $nota))){
                                        $archivo= fopen("tellmemore.txt","a");
                                        fwrite($archivo,"Documento= ".$numerodocumento.", Nota con formato o rango de calificación No valido.\n");
                                        fclose($archivo);                                        
                                    }
                                    else{
                                        /*
                                         * Insercion en auditoria y detallenota
                                         */                                        
                                        $query_auditoria="INSERT INTO auditoria(numerodocumento,usuario,
                                        fechaauditoria, codigomateria, grupo,codigoestudiante,notaanterior,
                                        notamodificada, corte,tipoauditoria,ip)
                                        VALUES( '$docusuario', '".$_SESSION['MM_Username']."', '$fechahoy',
                                        '$materia', '".$row_consulta['idgrupo']."', '".$row_consulta['codigoestudiante']."',
                                         '0.0', '$nota','".$row_cortes['idcorte'] ."',10,'$ip')";
                                        $auditoria = $db->Execute($query_auditoria) or die(mysql_error());

                                        $query_insertdetallenota="INSERT INTO detallenota (idgrupo,idcorte,
                                        codigoestudiante,codigomateria,nota,numerofallasteoria,numerofallaspractica,
                                        codigotiponota)
                                        VALUES('".$row_consulta['idgrupo']."', '".$row_cortes['idcorte'] ."',
                                        '".$row_consulta['codigoestudiante']."','$materia', '$nota', 0, 0,10)";
                                        $insertdetallenota = $db->Execute($query_insertdetallenota) or die(mysql_error());

                                    }
                                }
                                else{
                                    $archivo= fopen("tellmemore.txt","a");
                                    fwrite($archivo,"Documento= ".$numerodocumento.", El estudiante ya tiene una nota para este corte no se puede modificar la nota.\n");
                                    fclose($archivo);
                                }
                            }
                        }
                        else{
                            $archivo= fopen("tellmemore.txt","a");
                            fwrite($archivo,"Documento= ".$numerodocumento.", Corte no existe o el corte no esta dentro de las fechas, revise el número de corte para el cual esta ingresando notas.\n");
                            fclose($archivo);
                        }
                    }
                    elseif($totalRows_consulta == 0 && $i!=0) {
                        $archivo= fopen("tellmemore.txt","a");
                        fwrite($archivo,"Documento= ".$numerodocumento.", la Materia no existe en la matricula del estudiante.\n");
                        fclose($archivo);
                    }                   
                }
            }            
            /*
             * Envio de e-mail a Mauricio Maya con el txt adjunto con el log de errores.
             */
            require_once("../../funciones/phpmailer/class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->From = "helpdesk@unbosque.edu.co";
            $mail->FromName = "helpdesk";
            $mail->Subject = "Log de errores carga Notas Tell Me More";
            $mail->AddAddress("mayamauricio@unbosque.edu.co","Mauricio Maya");
            $body  = "Este E-mail contiene el log de errores producido por el cargue masivo de notas de Tell Me More hacia SALA.";
            $mail->Body = $body;
            $mail->AddAttachment("tellmemore.txt", "logerrorestellmemore.txt");
            $mail->Send();
            /*
             * Fin del e-mail
             */

            echo "<script language='javascript'>
            window.location.href = 'archivoplano.php'
            </script>";

        }
        else {
            $archivo_cargado_ok=false;
            echo "<script language='javascript'>
            alert('Ocurrió algún error al subir el fichero. No pudo guardarse.');
            </script>";
        }
     }
}
?>
