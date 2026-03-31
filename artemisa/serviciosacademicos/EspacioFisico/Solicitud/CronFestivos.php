<?PHP 
    include_once ('../templates/template.php');              $db = getBD();
    include_once('festivos.php');                            $C_festivos  = new festivos();
    include_once('SolicitudEspacio_class.php');              $C_Solicitud = new SolicitudEspacio();
    include_once('../Administradores/ConsolaFestivos/Class/ConsolaFestivos_class.php');  $C_ConsolaFestivos = new ConsolaFestivos($db,'4186');
    
    $Year = date('Y')+1;

    $fecha_1  = $Year.'-01-01';
    $fecha_2  = $Year.'-12-31';
    $C_dias   = array();
    $DiasFestivos  = array();

    for($i=1;$i<7;$i++){
        $C_dias[] = $i;
    }//for

    $FechasFuturas = $C_Solicitud->FechasFuturas('35',$fecha_1,$fecha_2,$C_dias);

    $num = count($FechasFuturas);
    for($i=0;$i<$num;$i++){
        $num2 = count($FechasFuturas[$i]);
        for($j=0;$j<$num2;$j++){
            $fechaVerificar = '';
            $fechaVerificar = $FechasFuturas[$i][$j];
            $C_fecha        = explode('-',$fechaVerificar);
            
            $dia            = $C_fecha[2];//dia
            $mes            = $C_fecha[1];//mes
            
            if($C_festivos->esFestivoAutomatico($dia,$mes,$Year)==true){//$dia,$mes,$year
                $DiasFestivos[]  = $fechaVerificar;
                
                $C_ConsolaFestivos->DatoNuevo(1,$fechaVerificar);
                
            }//if
        }//for
    }//for 
?>