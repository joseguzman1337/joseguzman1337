<?PHP
class CalendarioInstitucional{
    var $db;
    var $userid;
    var $codigocarrera=1;
    function __construct($db,$userid,$codigocarrera){
		$this->db  = $db;
        $this->userid = $userid;
        $this->codigocarrera = $codigocarrera;
	}//__construct
    function ConsutalAdministrador(){
            $SQL='SELECT
                            c.CalenadrioInstitucionalId,
                            c.Evento,
                            c.Lugar,
                            c.Responsable,
                            c.FechaInicial,
                            c.FechaFin,
                            c.HoraInicial,
                            c.HoraFin,
                            c.ImagenUrl,
                            c.Descripcion,
                            IF(c.Estado=1,"Activo","Desactivado") AS NameEstado,
                            CONCAT(u.usuario," -- ",u.apellidos," ",u.nombres) AS NameUser,
                            c.codigocarrera
                        FROM
                            CalendarioInstitucional c  INNER JOIN usuario u ON u.idusuario=c.UsuarioCreacion
                        WHERE
                            c.CodigoEstado = 100
						AND c.Estado = 1
                        AND c.FechaFin >= CURDATE()
                        AND c.UsuarioCreacion = ?';

        $variable[] = $this->userid;

        $DatosEvento = $this->db->GetAll($SQL,$variable);

        if($DatosEvento===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        $num = count($DatosEvento);

        for($i=0;$i<$num;$i++){
            $DatosEvento[$i]['num'] = $i+1;
        }//for

        return $DatosEvento;
    }//function ConsutalAdministrador
    function CargaAreas(){
        $SQL = "SELECT
                    codigocarrera, nombrecarrera
                FROM
                    carrera
                WHERE
                    codigomodalidadacademica IN (200, 300)
                AND fechavencimientocarrera >= NOW()
                ";
        /*
         * Se hace la concatenacion y la union Select... para que solo traiga Bienestar Universitario.
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 9 de Marzo de 2018.
         */
        $SQL .= "UNION
                SELECT
                    codigocarrera, nombrecarrera
                FROM
                    carrera
                WHERE
                    codigocarrera ='146'
                ORDER BY
                    nombrecarrera";
        //end
        $DatosCarrera = $this->db->GetAll($SQL);
        return $DatosCarrera;
    }
    function CreateEventoCalendario($Datos){

        /*
         $name                 = $Datos['file']['imagenEvento']['name'];
        $type                  = $Datos['file']['imagenEvento']['type'];
        $size                   = $Datos['file']['imagenEvento']['size'];
        $tmp_name         = $Datos['file']['imagenEvento']['tmp_name'];
        $nameEvento       = $this->limpiarCadena(filter_var($Datos['post']['nameEvento'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $lugar                 = $this->limpiarCadena(filter_var($Datos['post']['lugar'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $area                   = $this->limpiarCadena(filter_var($Datos['post']['area'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $Observacion      = $this->limpiarCadena(filter_var($Datos['post']['Observacion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

        $fecha_1        = $Datos['post']['fecha_1'];
        $fecha_2        = $Datos['post']['fecha_2'];

        $hora_1        = $Datos['post']['hora_1'];
        $hora_2        = $Datos['post']['hora_2'];

        $EstadoEvento  = $Datos['post']['EstadoEvento'];
        */

        $variable[] = $Datos['post']['nameEvento'];
        $variable[] = $Datos['post']['lugar'];
        $variable[] = $Datos['post']['responsable'];
        $variable[] = $Datos['post']['fecha_1'];
        $variable[] = $Datos['post']['fecha_2'];
        $variable[] = $Datos['post']['hora_1'];
        $variable[] = $Datos['post']['hora_2'];
        $variable[] = 'imagen';
        $variable[] = $Datos['post']['Observacion'];
        $variable[] = $Datos['post']['EstadoEvento'];
        $variable[] = $Datos['post']['area'];
        $variable[] = $this->userid;
        $variable[] = $this->userid;


        $Insert='INSERT INTO CalendarioInstitucional(Evento, Lugar, Responsable, FechaInicial, FechaFin, HoraInicial, HoraFin, ImagenUrl, Descripcion, Estado,codigocarrera,UsuarioCreacion, FechaCreacion, UsuarioUltimaModificacion, FechaUltimaModificacion)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?,NOW())';
       /* echo $Insert.' <br />';
		echo '<pre>'; print_r($variable);
        //$this->db->debug=true;*/

        $InsertDatos = $this->db->Execute($Insert,$variable);

		//echo "<pre>";print_r( $InsertDatos ); //die;

        if($InsertDatos===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        $Last_id=$this->db->Insert_ID();

        $size                  = $Datos['file']['imagenEvento']['size'];
        $URL                   = '';
        if($size!=0){

                $Data = pathinfo( $Datos['file']['imagenEvento']['name']);
                $tmp_name         = $Datos['file']['imagenEvento']['tmp_name'];
                $type                  = $Datos['file']['imagenEvento']['type'];
                $URL="../imagen/".$Last_id.'.'.$Data['extension'];

                move_uploaded_file($tmp_name,$URL);
                $URL=$Last_id.'.'.$Data['extension'];
                $Update='UPDATE CalendarioInstitucional
                SET
                ImagenUrl=?
                WHERE
                CalenadrioInstitucionalId=?    AND  CodigoEstado=100';

                $variableUrl[] = $URL;
                $variableUrl[] = $Last_id;

              //  $this->db->debug=true;

                $UpdateDatos = $this->db->Execute($Update,$variableUrl);

                if($UpdateDatos===false){
                    $json["val"]   = false;
                    $json["msj"]   = "Error de Conexión del Sistema SALA";
                    echo json_encode($json);
                    exit;
                }
        }
        $json["val"]   =true;
        $json["img"]  = $URL;
        $json["type"] = $type;
        $json["msj"]         ="Se ha almacenado de forma Correcta...";
        echo json_encode($json);
        exit;
    }//function CreateEventoCalendario
    function EditEventoCalendario($Datos){
        $size                   = $Datos['file']['imagenEvento']['size'];

        if($size!=0){

        $Data = pathinfo( $Datos['file']['imagenEvento']['name']);
        $tmp_name         = $Datos['file']['imagenEvento']['tmp_name'];
        $URL="../imagen/".$Datos['post']['CalenadrioInstitucionalId'].'.'.$Data['extension'];

        move_uploaded_file($tmp_name,$URL);
        $URL = $Datos['post']['CalenadrioInstitucionalId'].'.'.$Data['extension'];
        }else{
             $URL=$Datos['post']['url'];
        }

        $variable[] = $Datos['post']['nameEvento'];
        $variable[] = $Datos['post']['lugar'];
        $variable[] = $Datos['post']['responsable'];
        $variable[] = $Datos['post']['fecha_1'];
        $variable[] = $Datos['post']['fecha_2'];
        $variable[] = $Datos['post']['hora_1'];
        $variable[] = $Datos['post']['hora_2'];
        $variable[] = $URL;
        $variable[] = $Datos['post']['Observacion'];
        $variable[] = $Datos['post']['EstadoEvento'];
        $variable[] = $Datos['post']['area'];
        $variable[] = $this->userid;
        $variable[] = $Datos['post']['CalenadrioInstitucionalId'];

        $Update='UPDATE CalendarioInstitucional
                        SET         Evento=?,
                                        Lugar=?,
                                        Responsable=?,
                                        FechaInicial=?,
                                        FechaFin=?,
                                        HoraInicial=?,
                                        HoraFin=?,
                                        ImagenUrl=?,
                                        Descripcion=?,
                                        Estado=?,
                                        codigocarrera=?,
                                        UsuarioUltimaModificacion=?,
                                        FechaUltimaModificacion=NOW()
                        WHERE
                                        CalenadrioInstitucionalId=?    AND  CodigoEstado=100';

        // $this->db->debug=true;

        $UpdateDatos = $this->db->Execute($Update,$variable);

        if($UpdateDatos===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        $json["val"]   =true;
        $json["img"]  = $URL;
        $json["msj"]         ="Se ha almacenado de forma Correcta...";
        echo json_encode($json);
        exit;

    }//function EditEventoCalendario
    function UpdateEstado($id,$tipo=false){
        if($tipo){

                $SQL='SELECT
                            Estado
                            FROM
                            CalendarioInstitucional
                            WHERE
                            CalenadrioInstitucionalId=?    AND  CodigoEstado=100';

                //  $this->db->debug=true;

                $variableSelect[] = $id;

                $SelectDato = $this->db->Execute($SQL,$variableSelect);

                if($SelectDato===false){
                    $json["val"]   =false;
                    $json["msj"]         ="Error de Conexión del Sistema SALA";
                    echo json_encode($json);
                    exit;
                }

                if($SelectDato->fields['Estado']==1){
                    $Estado = 0;
                }else{
                    $Estado = 1;
                }

                $variable[] = $Estado;
                $variable[] = $this->userid;
                $variable[] = $id;

                $Update='UPDATE CalendarioInstitucional
                                SET         Estado=?,
                                                UsuarioUltimaModificacion=?,
                                                FechaUltimaModificacion=NOW()
                                WHERE
                                                CalenadrioInstitucionalId=?    AND  CodigoEstado=100';

            $json["msj"]         ="Se a cambia el Estado...";

        }else{

                $variable[] = $this->userid;
                $variable[] = $id;

                $Update='UPDATE CalendarioInstitucional
                                SET         CodigoEstado=200,
                                                UsuarioUltimaModificacion=?,
                                                FechaUltimaModificacion=NOW()
                                WHERE
                                                CalenadrioInstitucionalId=?    AND  CodigoEstado=100';

            $json["msj"]         ="Se a Eliminado el Evento...";
        }


        //$this->db->debug=true;

        $UpdateEstado = $this->db->Execute($Update,$variable);

        if($UpdateEstado===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        $json["val"]   =true;

        echo json_encode($json);
        exit;
    }//function UpdateEstado
    function ViewEventoCalendario($id){
		
		/*
		 * @modified David Perez <perezdavid@unbosque.edu.co>
		 * @since  Octubre 5, 2017
		 * Se añade el nameCarrera para visualizar en la app al momento de ver el detalle de un evento
		*/
		
        $SQL='SELECT
                            c.CalenadrioInstitucionalId,
                            c.Evento,
                            c.Lugar,
                            c.Responsable,
                            c.FechaInicial,
                            c.FechaFin,
                            c.HoraInicial,
                            c.HoraFin,
                            c.ImagenUrl,
                            c.Descripcion,
                            IF(c.Estado=1,"Activo","Desactivado") AS NameEstado,
                            c.Estado,
                            c.codigocarrera,
							ca.nombrecarrera AS nameCarrera
                        FROM
                            CalendarioInstitucional c
							INNER JOIN carrera ca ON ca.codigocarrera = c.codigocarrera
                        WHERE
                            c.CodigoEstado = 100
							AND c.Estado = 1
                            AND
                            c.CalenadrioInstitucionalId = ?';

        $variable[] = $id;

        $DatosEvento = $this->db->GetAll($SQL,$variable);

        if($DatosEvento===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        return $DatosEvento;
    }//function ViewEventoCalendario
    function Validacion($Datos,$op){


        /**
         [post] => Array
        (
            [nameEvento] => prueba
            [lugar] => pruba
            [area] => prueba
            [fecha_1] => 2016-08-19
            [fecha_2] => 2016-08-30
            [hora_1] => 11:30
            [hora_2] => 09:30
            [Observacion] => preuba de descrip
            [EstadoEvento] => 1
            [action_ID] => SaveEvento
        )

    [file] => Array
        (
            [imagenEvento] => Array
                (
                    [name] => 200px-Vlcsnap-1361413.png
                    [type] => image/png
                    [tmp_name] => D:\wamp\tmp\php2B09.tmp
                    [error] => 0
                    [size] => 50031
                )

        )
        */
        $name                 = $Datos['file']['imagenEvento']['name'];
        $type                  = $Datos['file']['imagenEvento']['type'];
        $size                   = $Datos['file']['imagenEvento']['size'];
        $tmp_name         = $Datos['file']['imagenEvento']['tmp_name'];
        $nameEvento       = $this->limpiarCadena(filter_var($Datos['post']['nameEvento'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $lugar                 = $this->limpiarCadena(filter_var($Datos['post']['lugar'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $area                   = $this->limpiarCadena(filter_var($Datos['post']['area'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $Observacion      = $this->limpiarCadena(filter_var($Datos['post']['Observacion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

        $fecha_1        = $Datos['post']['fecha_1'];
        $fecha_2        = $Datos['post']['fecha_2'];

        $fechadb =$fecha_1;
        $tmp = explode('-',$fechadb);
        $Fecha_Envia = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
        $fecha = $fecha_2;
        $tmp = explode('-',$fecha);
        $Hoy = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
        // Compara ahora que las fechas son enteror
        if( $Hoy < $Fecha_Envia) {

            $a_vectt['val']			=false;
            $a_vectt['msj']     ='La fecha final es menor que la fecha inicial...!';
            echo json_encode($a_vectt);
            exit;

        }

        $hora_1        = $Datos['post']['hora_1'];
        $hora_2        = $Datos['post']['hora_2'];

        $EstadoEvento  = $Datos['post']['EstadoEvento'];

        if($size!=0){
            /***/

/*
     * @modified David Perez <perezdavid@unbosque.edu.co>
     * @since  Julio 17, 2017
     * Debido a problemas con el guardado de la imagen se quita la validación del peso
    */

            /*$Tam = $this->CalcularTamano($size);

            if(($Tam[1]!='KB') && ($Tam[1]!='B')){
                $info['val'] = false;
                $info['Op'] = 1;
                echo json_encode($info);
                exit;
            }

            if($Tam[1]=='KB'){
                if($Tam[0]>200){
                    $info['val'] = false;
                    $info['Op'] = 1;
                    echo json_encode($info);
                    exit;
                }
            }*/

            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type al mimetype extension

            $mime = finfo_file($finfo, $tmp_name);
            finfo_close($finfo);

            if(($type!='image/jpeg' && $type!='image/png' && $type!='image/jpg') || ($mime!='image/jpeg' && $mime!='image/png' && $mime!='image/jpg')){
                $info['val'] = false;
                $info['msj'] = "Error la Imgen no es tipo jpeg-png-jpg";
                echo json_encode($info);
                exit;
            }
            /***/

        }

        $C_Hora1 = explode(':',$hora_1);
        $C_Hora2 = explode(':',$hora_2);

        /*$C_Hora1[0];//hora
        $C_Hora1[1];//minutos*/

        if($C_Hora2[0] < $C_Hora1[0]){
            $info['val'] = false;
            $info['msj'] = "Error la hora final no puede ser menor que la inicial";
            echo json_encode($info);
            exit;
        }else{
            if($C_Hora2[0] == $C_Hora1[0]){
                if($C_Hora2[1] <= $C_Hora1[1]){
                    $info['val'] = false;
                    $info['msj'] = "Error la hora final no puede ser menor o igual que la inicial";
                    echo json_encode($info);
                    exit;
                }
            }
        }

        if(($EstadoEvento!=1) && ($EstadoEvento!=0)){
            $info['val'] = false;
            $info['msj'] = "Error en el sistema...";
            echo json_encode($info);
            exit;
        }

        if($op==1){
            $this->CreateEventoCalendario($Datos);
        }else{
            $this->EditEventoCalendario($Datos);
        }

    }//function Validacion
    function limpiarCadena($cadena){
     $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
     return $cadena;
    }//function limpiarCadena
    function CalcularTamano($bytes){
            $bytes = $bytes;
            $labels = array('B', 'KB', 'MB', 'GB', 'TB');
            foreach($labels AS $label)
            {
                if ($bytes > 1024)
                {
                   $bytes = $bytes / 1024;
                }
                else {
                  break;
                }
            }
            $datos[] =round($bytes, 2);
            $datos[] = $label;
            return $datos;
    }//function CalcularTamano
    function EstadoEvento($valor=false,$id=''){
        if($valor){
            if($id==1){
                $Info[0]['val'] = 1;
                $Info[1]['val'] = 0;
                $Info[0]['name'] = 'Activado';
                $Info[1]['name'] = 'Desactivado';
            }else{
                $Info[0]['val'] = 0;
                $Info[1]['val'] = 1;
                $Info[0]['name'] = 'Desactivado';
                $Info[1]['name'] = 'Activado';
            }
        }else{
            $Info[0]['val'] = 1;
            $Info[1]['val'] = 0;
            $Info[0]['name'] = 'Activado';
            $Info[1]['name'] = 'Desactivado';
        }

        return $Info;
    }//function EstadoEvento
    function VisualizarEventosCalendario($Datos){
        /**
        [showdate] => 8/23/2016
        [viewtype] => week
        [timezone] => -5
        [id] => 2
        */
        header('Content-type:text/javascript;charset=UTF-8');

        include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/asignacionSalones/calendario3/wdCalendar/php/functions.php');

        $phpTime = js2PhpTime($Datos['showdate']);

        switch($Datos['viewtype']){
            case "month":
                $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
            break;
            case "week":
                //suppose first day of a week is monday
                $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
                //echo date('N', $phpTime);
                $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
                $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
            break;
            case "day":
                $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
            break;
        }
        //echo $st . "--" . $et;
        $Result = $this->listCalendarByRange($st, $et,$Datos['viewtype']);

        echo json_encode($Result);

    }//function VisualizarEventosCalendario
    function listCalendarByRange($sd, $ed,$tipo,$id=false){
        $ret = array();
        $ret['events'] = array();
        $ret["issort"] =true;
        $ret["start"] = php2JsTime($sd);
        $ret["end"] = php2JsTime($ed);
        $ret['error'] = null;
        try{

       $sql ='SELECT
                        c.CalenadrioInstitucionalId,
                        c.Evento,
                        c.Lugar,
                        c.Responsable,
                        CONCAT(c.FechaInicial," ",c.HoraInicial) AS StartTime,
                        CONCAT(c.FechaFin," ",c.HoraFin) AS EndTime,
                        FechaFin,
                        FechaInicial,
                        HoraInicial,
                        HoraFin,
                        codigocarrera
                    FROM
                        CalendarioInstitucional c
                    WHERE
                    CONCAT(c.FechaInicial,	" ",	c.HoraInicial) >= ?
                    AND CONCAT(c.FechaInicial," ",c.HoraFin) <= ?
                    AND  Estado=1';

        $variable[] = php2MySqlTime($sd);
        $variable[] = php2MySqlTime($ed);

        //$this->db->debug=true;

        $DatosEvento = $this->db->GetAll($sql,$variable);

        if($DatosEvento===false){
            $json["val"]   =false;
            $json["msj"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        $Num = count($DatosEvento);

        for($i=0;$i<$Num;$i++){
            if($DatosEvento[$i]['FechaInicial']==$DatosEvento[$i]['FechaFin']){
                $ret['events'][]= array(
                                                       $DatosEvento[$i]['CalenadrioInstitucionalId'],
                                                       $DatosEvento[$i]['Evento'],
                                                        php2JsTime(mySql2PhpTime($DatosEvento[$i]['StartTime'])),
                                                        php2JsTime(mySql2PhpTime($DatosEvento[$i]['EndTime'])),
                                                        // $row->IsAllDayEvent,
                                                        0, //Coresponde al campo IsAllDayEvent,
                                                        0, //more than one day event
                                                        //$row->InstanceType,
                                                        0,//Recurring event,
                                                        // $row->Color,
                                                       $DatosEvento[$i]['codigocarrera'], // Corresponde al campo Color
                                                        1,//editable
                                                        // $row->Location,
                                                        $DatosEvento[$i]['Lugar'], //Corresponde al campo Location
                                                        ''//$attends
             );
            }else{
				$diaInicial = $DatosEvento[$i]['FechaInicial'];
				
				/*
				 * @modified David Perez <perezdavid@unbosque.edu.co>
				 * @since  Octubre 5, 2017
				 * Envio de varias veces cuando el evento dura mas de un día.
				*/
				
				while($diaInicial != $DatosEvento[$i]['FechaFin']){
												$ret['events'][]= array(
                                                       $DatosEvento[$i]['CalenadrioInstitucionalId'],
                                                       $DatosEvento[$i]['Evento'],
                                                        php2JsTime(mySql2PhpTime($DatosEvento[$i]['StartTime'])),
                                                        php2JsTime(mySql2PhpTime($DatosEvento[$i]['EndTime'])),
                                                        // $row->IsAllDayEvent,
                                                        0, //Coresponde al campo IsAllDayEvent,
                                                        0, //more than one day event
                                                        //$row->InstanceType,
                                                        0,//Recurring event,
                                                        // $row->Color,
                                                       $DatosEvento[$i]['codigocarrera'], // Corresponde al campo Color
                                                        1,//editable
                                                        // $row->Location,
                                                        $DatosEvento[$i]['Lugar'], //Corresponde al campo Location
                                                        ''//$attends
												);
												$DatosEvento[$i]['StartTime'] = date('Y-m-d H:i:s', strtotime($stop_date . ' +1 day'));
												$date1 = str_replace('-', '/', $diaInicial);
												$diaInicial = date('Y-m-d',strtotime($date1 . "+1 days"));
				}
                if($tipo!='month'){

                    $Dias_add = $this->DiasDigitales($DatosEvento[$i]['FechaInicial'],$DatosEvento[$i]['FechaFin']);

                    $num_x = count($Dias_add);

                    for($x=0;$x<$num_x;$x++){

                        $Dia_n = $Dias_add[$x].' '.$DatosEvento[$i]['HoraInicial'];
                        $Dia_x = $Dias_add[$x].' '.$DatosEvento[$i]['HoraFin'];

                        $ret['events'][]= array(
                                                           $DatosEvento[$i]['CalenadrioInstitucionalId'],
                                                           $DatosEvento[$i]['Evento'],
                                                            php2JsTime(mySql2PhpTime($Dia_n)),
                                                            php2JsTime(mySql2PhpTime($Dia_x)),
                                                            // $row->IsAllDayEvent,
                                                            0, //Coresponde al campo IsAllDayEvent,
                                                            0, //more than one day event
                                                            //$row->InstanceType,
                                                            0,//Recurring event,
                                                            // $row->Color,
                                                           $DatosEvento[$i]['codigocarrera'], // Corresponde al campo Color
                                                            1,//editable
                                                            // $row->Location,
                                                            $DatosEvento[$i]['Lugar'], //Corresponde al campo Location
                                                            ''//$attends
                        );
                    }//for
                }
            }//if

        }//for

          }catch(Exception $e){
             $ret['error'] = '';
          }
          return $ret;
    }//function listCalendarByRange
    function DiasDigitales($fecha_ini,$fecha_fin){
        $datetime1 = date_create($fecha_ini);
        $datetime2 = date_create($fecha_fin);
        $interval = date_diff($datetime1, $datetime2);
        $DiasDigital = $interval->format('%a');

        for($i=1;$i<=$DiasDigital;$i++){
            $modo = 'days';
            $fecha_base=strtotime($fecha_ini);
            $calculo = strtotime("$i $modo","$fecha_base");

           $Dia_Add[]= date("Y-m-d", $calculo);
        }//for

        return $Dia_Add;
    }//function name
    function filtroApp(){
        $SQL='SELECT
                        *
                        FROM
                        (
                        SELECT
                            k.codigocarrera,
                            if(k.codigocarrera=1,"Evento Institucional",if(k.codigocarrera=156,"Evento Institucional",k.nombrecarrera)) AS nameCarrera

                        FROM
                            CalendarioInstitucional c
                        INNER JOIN carrera k ON k.codigocarrera = c.codigocarrera
                        WHERE
                            c.CodigoEstado = 100
							AND c.Estado = 1
                        AND (c.FechaInicial >= CURDATE() OR c.FechaFin <=CURDATE())

                        GROUP BY k.codigocarrera) x

                        GROUP BY x.nameCarrera';

        //$this->db->debug=true;

        $DatosApp = $this->db->GetAll($SQL);

        if($DatosApp===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        return $DatosApp;
    }//function filtroApp
    function ConsumoAppCalendario($codigocarrera){
        /*
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se quita la condicional || ($codigocarrera==146) ya que en la agenda de eventos Modulo Bienestar (App Movil)
         * mostraba eventos que dicha area no ha programado. 
         * @since Octubre 30, 2018
         */ 
         if(($codigocarrera==1) || ($codigocarrera==156)){
            $variable_app[] = '1';
            $variable_app[] = '156';
            $variable_app[] = '146';
            $Condicion = 'codigocarrera IN (?,?,?)   AND  CodigoEstado = 100';
        }else if(($codigocarrera==0) || ($codigocarrera=='')){
            $variable_app[] ='100';
            $Condicion = ' CodigoEstado = ?';
        }else{
            $variable_app[] = $codigocarrera;
            $Condicion = 'codigocarrera =?   AND   CodigoEstado = 100';
        }

        $SQL_App ='SELECT
                                CalenadrioInstitucionalId,
                                Evento,
                                Lugar,
                                Responsable,
                                FechaInicial,
                                FechaFin,
                                SUBSTRING(HoraInicial, 1, 5) AS H_inicio,
                                SUBSTRING(HoraFin, 1, 5) AS H_fin,
                                ImagenUrl,
                                Descripcion
                            FROM
                                CalendarioInstitucional
                            WHERE
                                '.$Condicion.'

                            AND (
                                FechaInicial >= CURDATE()
                                OR FechaFin >= CURDATE()
                            )
							AND Estado = 1';


        //$this->db->debug=true;

        $Evento_app = $this->db->GetAll($SQL_App,$variable_app);

        if($Evento_app===false){
            $json["result"]             = "ERROR";
            $json["codigoresultado"]    = 1;
            $json["mensaje"]            = "Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }

        return $Evento_app;
    }//function ConsumoAppCalendario
}//class 
?>