<?php

   function cambiaf_a_people($fecha)
       {
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
		$lafecha=$mifecha[2].$mifecha[3].$mifecha[1];
		return $lafecha;
       }
	 function cambiaf_a_sala($fecha)
       {

		ereg( "([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
		$lafecha=$mifecha[1]."-".$mifecha[2]."-".$mifecha[3];
		return $lafecha;
       }


  	function cambiaf_a_people2($fecha)
       {
		preg_match("/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
		$lafecha=$mifecha[2].$mifecha[3].$mifecha[1];
		return $lafecha;
       }

	function cambiafechaapeople($date){
   		//formato de $date AAAA-MM-DD
		$fecha = explode('-', $date);
		//forematp de $fechapeople MMDDAAAA
		$fechapeople = $fecha['1'].substr($fecha['2'], 0, 2).$fecha['0'];
		return $fechapeople;
	}


    function cambiafechaapeoplePse($date){
        //formato de $date AAAA-MM-DD
        $fecha = explode('-', $date);
        //forematp de $fechapeople MMDDAAAA
        $fechapeople = $fecha['1']."/".substr($fecha['2'], 0, 2)."/".substr($fecha['0'], 2, 2);
        return $fechapeople;
    }