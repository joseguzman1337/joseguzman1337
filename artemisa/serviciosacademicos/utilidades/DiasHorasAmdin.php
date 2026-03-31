<?php  
require_once("NotificacionAdmin.php");
include_once(realpath(dirname(__FILE__)).'/../EspacioFisico/Solicitud/festivos.php');

class AdminDiasHorasssss{
    
    public function ingresoFecha($usuario, $ip, $modulo)
    {
        if(!empty($modulo))
        {
            $alerta = " al modulo de: <strong>".$modulo."</strong>";
            $c = 1;
        }
        $fecha = getdate();
        $Festivos = new festivos();
        $festivo = $Festivos->esFestivo($fecha['mday'], $fecha['mon'], $fecha['year'], 1);
        //print_r($fecha); die;
        //si el dia es domingo = 0 o sabado = 6 entra a las alertas
        if($fecha['wday']== '0')
        {           
            $destinatario = "oficialseguridad@unbosque.edu.co, it@unbosque.edu.co";
            $asunto = "Alerta de acceso a SALA en horario no autorizado";
            $mensaje = "Se ha identificado un acceso del usuario: <strong>".$usuario."</strong> a SALA ".$alerta." desde la dirección IP: <strong>".$ip."</strong>  el <strong>".$fecha['mday']."/".$fecha['mon']."/".$fecha['year']."</strong> hora: <strong>".$fecha['hours'].":".$fecha['minutes'].":00.</strong> <br><br>   Gracias";
            EnviarCorreo($destinatario,$asunto,$mensaje);
            $t = 1; 
        }else if($fecha['wday']== '6') // Evalua si es dia sabado
		{
			if($fecha['hours']< '7' || $fecha['hours']> '14'){ // si la hora de entrada del sabado es diferente al horario entre 7AM y 2PM
				$destinatario = "oficialseguridad@unbosque.edu.co, it@unbosque.edu.co";
				$asunto = "Alerta de acceso a SALA en horario no autorizado";
				$mensaje = "Se ha identificado un acceso del usuario: <strong>".$usuario."</strong> a SALA ".$alerta." desde la dirección IP: <strong>".$ip."</strong>  el <strong>".$fecha['mday']."/".$fecha['mon']."/".$fecha['year']."</strong> hora: <strong>".$fecha['hours'].":".$fecha['minutes'].":00.</strong> <br><br>   Gracias";
				EnviarCorreo($destinatario,$asunto,$mensaje);
				$t = 1;  
			}
			
		}else if ($fecha['hours']< '7' || $fecha['hours']> '21') //si la hora del dia es menor a las 7 am o mayor a las 9 pm entra a las alertas 
        {
            $destinatario = "oficialseguridad@unbosque.edu.co, it@unbosque.edu.co";
            $asunto = "Alerta de acceso a SALA en horario no autorizado";
            $mensaje = "Se ha identificado un acceso del usuario: <strong>".$usuario."</strong> a SALA ".$alerta." desde la dirección IP: <strong>".$ip."</strong>  el <strong>".$fecha['mday']."/".$fecha['mon']."/".$fecha['year']."</strong> hora: <strong>".$fecha['hours'].":".$fecha['minutes'].":00.</strong> <br><br>   Gracias";
            EnviarCorreo($destinatario,$asunto,$mensaje);
            $t = 1;  
        }
        //si el valor del dia es verdadero entra a las alertas
        if($festivo==true)
        {
            $destinatario = "oficialseguridad@unbosque.edu.co, it@unbosque.edu.co";
            $asunto = "Alerta de acceso a SALA en horario no autorizado";
            $mensaje = "Se ha identificado un acceso del usuario: <strong>".$usuario."</strong> a SALA ".$alerta." desde la dirección IP: <strong>".$ip."</strong>  el <strong>".$fecha['mday']."/".$fecha['mon']."/".$fecha['year']."</strong> hora: <strong>".$fecha['hours'].":".$fecha['minutes'].":00, en un día festivo.</strong> <br><br>   Gracias";
            EnviarCorreo($destinatario,$asunto,$mensaje);
            $t = 1;
        }
        if($t==1 && $c==1)
        {
            return $t;
        }
    }
}


?>