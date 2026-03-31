<?php

class festivos 
{

	private $hoy;
	private $festivos;
	private $ano;
	private $pascua_mes;
	private $pascua_dia;
	
	
	public function festivos($ano='')
	{
       
        if($ano==''){
			$ano=date('Y');
        }
        
        $this->hoy=date($ano.'/m/Y');
			
		$this->ano=$ano;
		
		$this->pascua_mes=date("m", easter_date($this->ano));
		$this->pascua_dia=date("d", easter_date($this->ano));
				
		$this->festivos[$ano][1][1]   = true;		// Primero de Enero
		$this->festivos[$ano][5][1]   = true;		// Dia del Trabajo 1 de Mayo
		$this->festivos[$ano][7][20]  = true;		// Independencia 20 de Julio
		$this->festivos[$ano][8][7]   = true;		// Batalla de Boyacá 7 de Agosto
		$this->festivos[$ano][12][8]  = true;		// Maria Inmaculada 8 diciembre (religiosa)
		$this->festivos[$ano][12][25] = true;		// Navidad 25 de diciembre
		
		$this->calcula_emiliani(1, 6);				// Reyes Magos Enero 6
		$this->calcula_emiliani(3, 19);				// San Jose Marzo 19
		$this->calcula_emiliani(6, 29);				// San Pedro y San Pablo Junio 29
		$this->calcula_emiliani(8, 15);				// Asunción Agosto 15
		$this->calcula_emiliani(10, 12);			// Descubrimiento de América Oct 12
		$this->calcula_emiliani(11, 1);				// Todos los santos Nov 1
		$this->calcula_emiliani(11, 11);			// Independencia de Cartagena Nov 11
		
		//otras fechas calculadas a partir de la pascua.
		
		$this->otrasFechasCalculadas(-3);			//jueves santo
		$this->otrasFechasCalculadas(-2);			//viernes santo
		
		$this->otrasFechasCalculadas(36,true);		//Ascención el Señor pascua
		$this->otrasFechasCalculadas(60,true);		//Corpus Cristi
		$this->otrasFechasCalculadas(68,true);		//Sagrado Corazón
		
		// otras fechas importantes que no son festivos

		// $this->otrasFechasCalculadas(-46);		// Miércoles de Ceniza
		// $this->otrasFechasCalculadas(-46);		// Miércoles de Ceniza
		// $this->otrasFechasCalculadas(-48);		// Lunes de Carnaval Barranquilla
		// $this->otrasFechasCalculadas(-47);		// Martes de Carnaval Barranquilla
	}
	protected function calcula_emiliani($mes_festivo,$dia_festivo) 
	{
		// funcion que mueve una fecha diferente a lunes al siguiente lunes en el
		// calendario y se aplica a fechas que estan bajo la ley emiliani
		//global  $y,$dia_festivo,$mes_festivo,$festivo;
		// Extrae el dia de la semana
		// 0 Domingo … 6 Sábado
		$dd = date("w",mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano));
		switch ($dd) {
		case 0:                                    // Domingo
		$dia_festivo = $dia_festivo + 1;
		break;
		case 2:                                    // Martes.
		$dia_festivo = $dia_festivo + 6;
		break;
		case 3:                                    // Miércoles
		$dia_festivo = $dia_festivo + 5;
		break;
		case 4:                                     // Jueves
		$dia_festivo = $dia_festivo + 4;
		break;
		case 5:                                     // Viernes
		$dia_festivo = $dia_festivo + 3;
		break;
		case 6:                                     // Sábado
		$dia_festivo = $dia_festivo + 2;
		break;
		}
		$mes = date("n", mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano))+0;
		$dia = date("d", mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano))+0;
		$this->festivos[$this->ano][$mes][$dia] = true;
	}	
	protected function otrasFechasCalculadas($cantidadDias=0,$siguienteLunes=false)
	{
		$mes_festivo = date("n", mktime(0,0,0,$this->pascua_mes,$this->pascua_dia+$cantidadDias,$this->ano));
		$dia_festivo = date("d", mktime(0,0,0,$this->pascua_mes,$this->pascua_dia+$cantidadDias,$this->ano));
		
		if ($siguienteLunes)
		{
			$this->calcula_emiliani($mes_festivo, $dia_festivo);
		}	
		else
		{	
			$this->festivos[$this->ano][$mes_festivo+0][$dia_festivo+0] = true;
		}
	}	
	public function esFestivoAutomatico($dia,$mes,$year){
		//echo (int)$mes;
        
		if($dia=='' or $mes=='')
		{
			return false;
		}
		
		if (isset($this->festivos[$year][(int)$mes][(int)$dia]))
		{
			return false;// true;
		}
		else 
		{
			return FALSE;
		}
	
	}//esFestivoAutomatico
    public function esFestivo($dia,$mes,$year,$tipo=false){
        /*
        **la funcion por defecto verifica contemplando los dos tipos de dias parametrizados festivos y días de receso 1 y 2 respectivamente,
        **de lo contrario se puede enviar el parametro que se desee verificar. 
        */
		include_once (realpath(dirname(__FILE__)).'/../templates/template.php');
    
        $db = getBD();
        
        $fechapregunta = $year.'-'.$mes.'-'.$dia;
		$variables     = array();
        
        $variables[]     = "100";     
        
        if($tipo==false){
            
            $variables[] = "1";     
            $variables[] = "2";
            
        }else{
            $variables[] = "$tipo";     
            $variables[] = "";
        }
        $variables[] = "$fechapregunta";    
        
        $SQL='SELECT
                idfestivo,
                tipodia,
                diafestivo
              FROM
                    festivo
              WHERE
                  codigoestado = ?
              AND tipodia IN (?,?)
              AND diafestivo=?';
        
        //$db->debug=true;
        
        if($Esfestivo = &$db->Execute($SQL,$variables)===false){
            echo 'Error en el Sistema.';
            die;
        }
        
        if(!$Esfestivo->EOF){
            return true;
        }else{
            return false;
        }
	}//esFestivo
}
?>
