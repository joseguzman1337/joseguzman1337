<?PHP
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

define('SessionActiva',true);
SessionActive();

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicaci?n */

require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */

if((!$_SERVER['QUERY_STRING'] || $_SERVER['QUERY_STRING']='') && $_SERVER['REQUEST_METHOD']=='GET'){
   $_POST['action_ID'] ='Administrador';
}

if($_POST['action_ID']=='Inicio'){
    $_POST['action_ID'] = 'Inicio';
}

 switch($_POST['action_ID']){
    case 'listar':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $C_CalendarioInstitucional->VisualizarEventosCalendario($_POST);
    }break;
    case 'Visualizar':{
        $Info['title']               = 'Visualizar Calendario Institucional';
        $Info['Label']             = 'Visualizar Calendario Institucional.';

        $template_index = $mustache->loadTemplate('CalendarioViewEvent'); /*carga la plantilla index*/

        echo $template_index->render($Info);
    }break;
    case 'DeleteEvento':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $C_CalendarioInstitucional->UpdateEstado($_POST['id'],false);
    }break;
    case 'CambioEstado':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $C_CalendarioInstitucional->UpdateEstado($_POST['id'],true);
    }break;
    case 'EditEvento':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $Datos['post']  = $_POST;
        $Datos['file']    = $_FILES;

        $C_CalendarioInstitucional->Validacion($Datos,2);

    }break;
    case 'SaveEvento':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $Datos['post']  = $_POST;
        $Datos['file']    = $_FILES;
        $C_CalendarioInstitucional->Validacion($Datos,1);

    }break;
    case 'Inicio':{
        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $Info['title']          = 'Calendario Institucional';
        $Info['Label']          = 'Calendario Institucional.';
        $Info['label_1']        = 'Nombre Del Evento';
        $Info['label_2']        = 'Lugar Del Evento';
        $Info['label_3']        = 'Facultad,';
        $Info['label_3_1']      = ' area administrativa';
        $Info['label_3_2']      = ' o intitucional';
        $Info['label_4']        = 'Fecha Del Evento';
        $Info['label_5']        = 'Desde';
        $Info['label_6']        = 'Hasta';
        $Info['label_7']        = 'Hora Del Evento';
        $Info['label_8']        = 'Imagen';
        $Info['label_9']        = 'Descripción';
        $Info['label_10']       = 'Estado';
        $Info['msn']            = 'Los Campos obligatorios ó requeridos.';
        $valor                  = false;
        $Info['Style']          = 'display:none';
        $Info['Estado']         = '';
        $Info['button']         = 'SaveInfo';
        $Info['Area']           = $C_CalendarioInstitucional->CargaAreas();
        $Info['areaSeleccionada'] = '';

        if($_POST['id']){
            $DatosEvento = $C_CalendarioInstitucional->ViewEventoCalendario($_POST['id']);

            $num = count($DatosEvento);

            for($i=0;$i<$num;$i++){
                $Info['CalenadrioInstitucionalId'] = $DatosEvento[$i]['CalenadrioInstitucionalId'];
                $Info['areaSeleccionada'] = $DatosEvento[$i]['codigocarrera'];
                $Info['Evento'] = $DatosEvento[$i]['Evento'];
                $Info['Lugar'] = $DatosEvento[$i]['Lugar'];
                $Info['Responsable'] = $DatosEvento[$i]['Responsable'];
                $Info['FechaInicial'] = $DatosEvento[$i]['FechaInicial'];
                $Info['FechaFin'] = $DatosEvento[$i]['FechaFin'];
                $Info['HoraInicial'] = $DatosEvento[$i]['HoraInicial'];
                $Info['HoraFin'] = $DatosEvento[$i]['HoraFin'];
                //$Valor_Url = explode('../imagen/',$DatosEvento[$i]['ImagenUrl']);
                if($DatosEvento[$i]['ImagenUrl'] != ''){
                    $Info['ImagenUrl'] = "../imagen/".$DatosEvento[$i]['ImagenUrl'];
                    $Info['HiddenUrl'] = $DatosEvento[$i]['ImagenUrl'];
                     $Info['Style'] = 'display:block';
                }else{
                    $Info['ImagenUrl'] = '../imagen/';
                    $Info['Style'] = 'display:none';
                    $Info['HiddenUrl'] = $DatosEvento[$i]['ImagenUrl'];
                }
                $Info['Descripcion'] = $DatosEvento[$i]['Descripcion'];
                $Info['Estado'] = $DatosEvento[$i]['Estado'];
                $valor = true;

                $Info['button'] = 'UpdateInfo';
            }//for
        }
        $Info['StyleButon'] = 'display:block';
        if($_POST['view']==1){
            $Info['StyleButon'] = 'display:none';
        }

        $Info['Tipo'] = $C_CalendarioInstitucional->EstadoEvento($valor,$Info['Estado']);

        $template_index = $mustache->loadTemplate('CalendarioInstitucionalRegistro'); /*carga la plantilla index*/

        echo $template_index->render($Info);
    }break;
    case 'Administrador':{

        global $db,$userid,$C_CalendarioInstitucional;
        MainGeneral();

        $Info['title']              = 'Calendario Institucional';
        $Info['Label']              = 'Administrador Calendario Institucional.';
        $Info['Nuevo']              = 'Nuevo';
        $Info['Editar']             = 'Editar';
        $Info['Eliminar']           = 'Eliminar';
        $Info['Visualizar']         = 'Visualizar Calendario';
        $Info['Cambia']             = 'Cambiar Estado';
        $Info['Nombre']             = 'Nombre del Evento';
        $Info['Lugar']              = 'Lugar del Evento';
        $Info['Fecha']              = 'Fecha del Evento';
        $Info['Hora']               = 'Hora del Evento';
        $Info['Usuario']            = 'Usuario de Creacion';
        $Info['Estado']             = 'Estado';

        $Datos = $C_CalendarioInstitucional->ConsutalAdministrador();

        $Info['Datos'] = $Datos;

        $template_index = $mustache->loadTemplate('AdministradorCalendarioInstitucional'); /*carga la plantilla index*/

        echo $template_index->render($Info);
    }break;
    default:{

        include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/Class/Error_class.php');  $C_Error = new ErrorAccesoAplicacion('../Controller/CalendarioInstitucional_html.php');


        $C_Error->ViewAccesoAplicacion(false,'../serviciosacademicos','../../EspacioFisico/templates/');
    }break;
}//switch
function SessionActive(){

    if(SessionActiva==true){
        session_start();
        include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
        $ValidarSesion = new ValidarSesion();
        $ValidarSesion->Validar($_SESSION);

    }
}//function SessionActive
function MainGeneral(){
    global $db,$C_CalendarioInstitucional,$userid;

   include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');

    include_once (realpath(dirname(__FILE__)).'/../Class/CalenadrioInstitucional_class.php');

    $userid  = '';
      if(SessionActiva==true){
            if(!isset ($_SESSION['MM_Username'])){
                echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
                exit();
            }

            $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

            $Usario_id=$db->Execute($SQL_User);

            if($Usario_id==false){
                    echo 'Error en el SQL Userid...<br>En el Sistema';
                    die;
                }
             $userid=$Usario_id->fields['id'];
            }
    $userid=4186;

        $C_CalendarioInstitucional = new CalendarioInstitucional($db,$userid,$_SESSION['codigofacultad']);
 }//function MainGeneral
?>