<?php

  require(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));
  
  include("../../../class/class.phpmailer.php");

    switch($_POST['actionID']){
        case 'buscarDocumento':{
            /*Modelo*/
            //consulta de la tabla de consultatitulos los datos del usuario
            $SQL = "SELECT idConsultaTitulos, nombreSolicitante, ".
            " apellidoSolicitante, identificacionSolicitante, empresaSolicitante, ".
            " correoSolicitante ".
            " FROM ConsultaTitulos ".
            " WHERE identificacionSolicitante = '".$_POST['identificacionSolicitante']."' ".
            " ORDER BY  idConsultaTitulos DESC LIMIT 1";
            /*Fin Modelo*/
            $Resultado = $db->GetRow($SQL);
            if(count($Resultado) == 0){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
                $a_vectt['idConsultaTitulos'] = 0;
            }else{
                $a_vectt['idConsultaTitulos'] = $Resultado['idConsultaTitulos'];
                $a_vectt['nombreSolicitante'] = $Resultado['nombreSolicitante'];
                $a_vectt['apellidoSolicitante'] = $Resultado['apellidoSolicitante'];
                $a_vectt['identificacionSolicitante'] = $Resultado['identificacionSolicitante'];
                $a_vectt['empresaSolicitante'] = $Resultado['empresaSolicitante'];
                $a_vectt['correoSolicitante'] = $Resultado['correoSolicitante'];                
            }
            echo json_encode($a_vectt);
        }break;
        case 'save':{
            $formulario = array();
            $formulario['identificacionSolicitante'] = $_POST['identificacionSolicitante'];
            $formulario['nombreSolicitante'] = $_POST['nombreSolicitante'];
            $formulario['apellidoSolicitante'] = $_POST['apellidoSolicitante'];
            $formulario['empresaSolicitante'] = $_POST['empresaSolicitante'];
            $formulario['correoSolicitante'] = $_POST['correoSolicitante'];
            $formulario['nombreEgresado'] = $_POST['nombreEgresado'];
            $formulario['apellidoEgresado'] = $_POST['apellidoEgresado'];
            $formulario['identificacionEgresado'] = $_POST['identificacionEgresado']; 
            $formulario['tipoCertificado'] = $_POST['tipoCertificado']; 
            $diasAdicionales = strtotime("+7 day");
            $fecha = date("Y-m-d", $diasAdicionales);
            $token = sha1($formulario['identificacionSolicitante'] . $formulario['identificacionEgresado'] . $fecha);

            $nombres = preg_replace('/\s\s+/', ' ', trim($_POST['nombreEgresado']));
            $apellidos = preg_replace('/\s\s+/', ' ', trim($_POST['apellidoEgresado']));
            
            if($_POST['captcha'] == ''){
             $a_vectt['mensaje'] = 'Revise el captcha antes de continuar';
            }else{
                /*Modelo*/
                //si esl certificado es para usuario ya graduado
                if($formulario['tipoCertificado'] == 0){
                    $SQL =  "SELECT g.nombregenero,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ', ".
                    " eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo,  ".
                    " r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo, r.numerodiplomaregistrograduadoantiguo, ".
                    " d.tipodocumento,d.nombredocumento ".
                    " FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r, documento d, genero g ".
                    " where eg.numerodocumento = '".$formulario['identificacionEgresado']."' ".
                    " and e.codigoestudiante=r.codigoestudiante  and g.codigogenero=eg.codigogenero ".
                    " and eg.idestudiantegeneral=e.idestudiantegeneral ".
                    " and eg.tipodocumento= d.tipodocumento ".
                    " union ".
                    " SELECT  g.nombregenero,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, ".
                    " eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado, r.fechagradoregistrograduado, ".
                    " r.numerodiplomaregistrograduado,d.tipodocumento,d.nombredocumento ".
                    " FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t, documento d, genero g ".
                    " where eg.numerodocumento =  '".$formulario['identificacionEgresado']."' ".
                    " and eg.idestudiantegeneral=e.idestudiantegeneral  and g.codigogenero=eg.codigogenero ".
                    " and e.codigocarrera=c.codigocarrera ".
                    " and e.codigoestudiante=r.codigoestudiante ".
                    " and c.codigotitulo=t.codigotitulo ".
                    " and eg.tipodocumento= d.tipodocumento ".
                    " UNION ".
                    " SELECT G.nombregenero, EG.idestudiantegeneral, ".
                    " CONCAT( EG.nombresestudiantegeneral, ' ', EG.apellidosestudiantegeneral ) AS nombre,".
                    " EG.numerodocumento, T.nombretitulo, A.NumeroActaAcuerdo, DATE_FORMAT(A.FechaAcuerdo,'%Y-%m-%d'), ".
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
                    " WHERE EG.numerodocumento = '".$formulario['identificacionEgresado']."' ".
                    " AND D.CodigoEstado = 100 AND R.CodigoEstado = 100 AND EG.nombresestudiantegeneral like '%".$nombres."%' AND EG.apellidosestudiantegeneral like '%".$apellidos."%'";
                }else{
                    //si el certificado es para usurio egresado
                    $SQL = "SELECT g.nombregenero, eg.idestudiantegeneral, e.semestre, ".
                    " concat( eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral ) AS nombre, ".
                    " eg.numerodocumento, c.nombrecarrera, d.tipodocumento, d.nombredocumento ".
                    " from estudiantegeneral eg ".
                    " INNER JOIN estudiante e on (e.idestudiantegeneral = eg.idestudiantegeneral) ".
                    " INNER JOIN estudianteestadistica ee on (ee.codigoestudiante = e.codigoestudiante) ".
                    " INNER JOIN carrera c on (e.codigocarrera = c.codigocarrera) ".
                    " INNER JOIN documento d on (d.tipodocumento = eg.tipodocumento) ".
                    " INNER JOIN genero g on (g.codigogenero = eg.codigogenero) ".
                    " WHERE ".
                    " eg.numerodocumento = '".$formulario['identificacionEgresado']."'  ".
                    " AND ee.codigoprocesovidaestudiante IN (400, 401) ".
                    " and ee.codigoestado = 100 AND EG.nombresestudiantegeneral like '%".$nombres."%' AND EG.apellidosestudiantegeneral like '%".$apellidos."%'".
                    " GROUP by ee.codigoestudiante ";
                }//else
                $Resultado = $db->GetAll($SQL);
                $ResultadoConteo= count($Resultado);
                if(count($Resultado)== 0){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                    $a_vectt['mensaje'] = 'No existe información del estudiante solicitado';
                    $a_vectt['bandera'] = '0';

                }else{
                    if ($ResultadoConteo ==0){
                        $a_vectt['mensaje'] = 'El documento a consultar digitado no existe, favor revisarlo antes de continuar';
                        
                    }else{
                        //crea el registro en la tabla de consulta de titulos
                        $SQL = "INSERT INTO ConsultaTitulos ( idestudiantegeneral, nombreSolicitante, ".
                        " apellidoSolicitante, identificacionSolicitante, empresaSolicitante, correoSolicitante, ".
                        " token, fechaVencimientoToken, estadoToken, tipoCertificado ) ".
                        " VALUES ( ".
                        " ( ".
                        " SELECT idestudiantegeneral ".
                        " FROM estudiantegeneral ".
                        " WHERE numerodocumento = '".$formulario['identificacionEgresado']."' ".
                        " ), ".
                        " '".$formulario['nombreSolicitante']." ', ".
                        " '".$formulario['apellidoSolicitante']."', ".
                        " '".$formulario['identificacionSolicitante']."', ".
                        " '".$formulario['empresaSolicitante']."', ".
                        " '".$formulario['correoSolicitante']."', ".
                        " '".$token."', ".
                        " '".$fecha."', ".
                        " '0', '".$formulario['tipoCertificado']."' ".
                        " )";
                        /*Fin Modelo*/
                        if ($Resultado = ($db->Execute($SQL)) == false) {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'ERROR ' . $SQL;
                        }

                        if($formulario['tipoCertificado']==1){
                           $tipoEstudiante = 'estudiante';     
                        }else{
                            $tipoEstudiante = 'egresado';   
                        }
                        /*Envío de Email*/
                        $mail = new PHPMailer();

                        $fechaCaducaToken=date_create($fecha);
                        $caducaToken = date_format($fechaCaducaToken,"d-m-Y");

                        $body = '

                <table cellpadding="30" cellspacing="0" align="center" border="0" width="600" height="auto" bgcolor="#ffffff">
                   <tr>
                      <td>
                         <img src="http://www.uelbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/head.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/>
                      </td>
                   </tr>
                   <tr>
                      <td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif;">Bogot&aacute;, ' . strftime("%d de %B de %Y") . '</td>
                   </tr>
                   <tr>
                      <td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif; text-align:justify;">
                         <b>Apreciado(a) ' . utf8_decode($formulario['nombreSolicitante']) . ' ' . utf8_decode($formulario['apellidoSolicitante'])  . ':</b> <br/><br/><br/><br/><br/><br/>
                         Se ha generado el siguiente link para consultar los datos del '.$tipoEstudiante.' '. $formulario['nombreEgresado']." ".$formulario['apellidoEgresado'].'
                         <a href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/certificados/certificadosGraduadosEstudiantes/index.php?token='.$token.'">Haga click aqui</a>, el acceso al link caduca el dia ' .$caducaToken. '
                         <br/><br/><br/><br/><br/>
                      </td>
                   </tr>
                   <tr>
                      <td align="center" style="color: #3F4826;font: 12px/17px Helvetica, sans-serif;">
                         Por una cultura de la vida, su calidad y su sentido <br/>
                         Transversal 9A Bis No. 132 - 55  |  Bogot&aacute; - Colombia <br/>
                         PBX (571) 648 90 00 Fax 6252030 <br/>
                         www.unbosque.edu.co
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <img src="http://www.uelbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/footer.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/>
                      </td>
                   </tr>
                </table>';

                        $mail->From='atencionalusuario@unbosque.edu.co';
                        $mail->FromName = "Universidad el Bosque";
                        $mail->isHTML(true);
                        $mail->AddReplyTo("atencionalusuario@unbosque.edu.co ", "Universidad El Bosque");
                        $mail->Subject = "Link para consulta de egresados - estudiantes";
                        $mail->Body = $body;
                        $address = $formulario['correoSolicitante'];
                        $mail->AddAddress($address, $formulario['empresaSolicitante']);
                        if (!$mail->Send()) {
                            $a_vectt['mensaje'] = "Error al enviar el correo , Favor Vuelva a Intentar";
                        }else{
                            $a_vectt['mensaje'] = 'Se ha enviado un correo a '.$formulario['correoSolicitante'].' con las instrucciones a seguir';
                            $a_vectt['bandera'] ='1';
                        }            
                        /*Fin envio de email*/
                    }//else
                }//else
            }//else
            echo json_encode($a_vectt);
        }break;
        case 'consultaEgresado':{
            $token = $_REQUEST['token'];
            /*Modelo*/
            $SQL = "SELECT c.idConsultaTitulos, eg.numerodocumento, c.tipoCertificado ".
            " FROM ConsultaTitulos c ".
            " INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = c.idestudiantegeneral ".
            " WHERE token = '".$token."' AND fechaVencimientoToken >= CURDATE()";
            /*Fin modelo*/

            if ($Resultado = $db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            $Resultado=$db->GetRow($SQL);
            $ResultadoConteo =count($Resultado);
            if ($ResultadoConteo != 0) {
                $a_vectt['numeroDocumento'] = $token;
                $a_vectt['tipoCertificado'] = $Resultado['tipoCertificado'];
                $SQL = 'UPDATE ConsultaTitulos SET estadoToken = 1 WHERE idConsultaTitulos = '.$Resultado['idConsultaTitulos'];
                /*Fin modelo*/
                if ($ResultadoUpd = $db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }
                if($Resultado['tipoCertificado'] == 0){
                    $a_vectt['redirect'] = 'certificadoegresadopdf.php';
                }else{
                    $a_vectt['redirect'] = 'certificadoestactivopdf.php';
                }
            }else{
                $a_vectt['numeroDocumento'] = 0;
            }
            echo json_encode($a_vectt);
        }break;
    }//switch