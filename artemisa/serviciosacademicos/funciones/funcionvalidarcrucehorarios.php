<?php
// Esta funcion recibe:
// Un arreglo con los grupos, el codigo del peridodo y la conexion a la base de datos
function horariovalido($grupos, $codigoperiodo, $sala,$codigomateriaini) {
    /*echo "grupos<pre>";
    print_r($grupos);
    echo "</pre>";*/
    foreach($grupos as $key => $identgrupo) {
        $query_horarioselegidos = "select g.idgrupo,d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, g.codigomateria,fechainiciogrupo,fechafinalgrupo, m.nombremateria
		from horario h, dia d, salon s, grupo g, materia m
		where h.codigodia = d.codigodia
		and h.codigosalon = s.codigosalon
		and h.idgrupo = '$identgrupo'
		and g.idgrupo = h.idgrupo
		and g.codigoindicadorhorario like '1%'
		and g.codigoperiodo = '$codigoperiodo'
        and g.codigomateria = m.codigomateria
		order by 1,3,4";
        //echo $query_horarioselegidos."<br>";
        $horarioselegidos=mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
        $totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);

        while($row_horarioselegidos = mysql_fetch_array($horarioselegidos)) {
            $iniciogrupo[] = $row_horarioselegidos['fechainiciogrupo'];
            $fingrupo[] =  $row_horarioselegidos['fechafinalgrupo'];

            $codigomateriahorarios[] = $row_horarioselegidos['codigomateria'];
            $nombremateriahorarios[] = $row_horarioselegidos['nombremateria'];
            $diahorarios[] = $row_horarioselegidos['codigodia'];
            $horainicialhorarios[] = $row_horarioselegidos['horainicial'];
            $horafinalhorarios[] = $row_horarioselegidos['horafinal'];
            $gruposarray[]=$row_horarioselegidos['idgrupo'];
        }
    }
    $maximohorarios = count($codigomateriahorarios)-1;
    //echo "<br><br>$maximohorarios = count($codigomateriahorarios)-1;<br>";
    unset($materiacruzada);
    for($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++) {
        for($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++) {
           // echo "if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)<br>";
            if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2) {

//exit();

                //return false;
                /*echo "<script language='javascript'>
						window.location.reload('matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial');
					</script>";*/
//echo "<font color=\"#003333\">FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE&nbsp;<strong><pre>".." </pre></strong></br>";	
                //exit();
                //echo 'FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE '.$codigomateriahorarios[$llavehorario1].' Y  '.$codigomateriahorarios[$llavehorario2].'"<br>';
                //echo $codigomateriahorarios[$llavehorario1],"------->",$codigomateriahorarios[$llavehorario2];


                /*
				if((date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s",strtotime($horainicialhorarios[$llavehorario2])))and(date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s",strtotime($horafinalhorarios[$llavehorario2]))))
		      	{
                 				         */
                if($codigomateriahorarios[$llavehorario1]<>$codigomateriahorarios[$llavehorario2]){
                   // echo "<br>if(horascruzadas (".$horainicialhorarios[$llavehorario1].",".$horafinalhorarios[$llavehorario1].",".$horainicialhorarios[$llavehorario2].",".$horafinalhorarios[$llavehorario2].")) {";
                    if(horascruzadas ($horainicialhorarios[$llavehorario1],$horafinalhorarios[$llavehorario1],$horainicialhorarios[$llavehorario2],$horafinalhorarios[$llavehorario2])) {

                        if(($iniciogrupo[$llavehorario1] >= $iniciogrupo[$llavehorario2])and($iniciogrupo[$llavehorario1] < $fingrupo[$llavehorario2])) {
                            //echo "<br>if (".$codigomateriahorarios[$llavehorario1]." == ".$codigomateriaini." or ".$codigomateriahorarios[$llavehorario2]." == ".$codigomateriaini.") {";
                            if ($codigomateriahorarios[$llavehorario1] == $codigomateriaini or $codigomateriahorarios[$llavehorario2] == $codigomateriaini) {

                                /*echo "<pre>";
					print_r($codigomateriahorarios);
					echo "</pre>";*/
                                $materiacruzada= 'FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE LA MATERIA '.$nombremateriahorarios[$llavehorario1]." grupo ".$codigomateriahorarios[$llavehorario1].' Y  '.$nombremateriahorarios[$llavehorario2]." grupo ".$codigomateriahorarios[$llavehorario2];
                                //echo $materiacruzada;
                              //  exit();
                                //$materiacruzada[$codigomateriahorarios[$llavehorario1]] = $codigomateriahorarios[$llavehorario2];
                                return $materiacruzada;
                                //return 0;

                            }
                        }
                        // $llavehorario1 = $maximohorarios+1;
                        //  $llavehorario2 = $maximohorarios+1;

                    }
                }
            }
        }
    }
//exit();
    return 1;
}
function  horascruzadas ($horainicial1,$horafinal1,$horainicial2,$horafinal2) {

    if($horainicial1>=$horainicial2&&$horainicial1<$horafinal2)
        return 1;

    if($horafinal1>$horainicial2&&$horafinal1<=$horafinal2)
        return 1;

    if($horainicial2>=$horainicial1&&$horainicial2<$horafinal1)
        return 1;

    if($horafinal2>$horainicial1&&$horafinal2<=$horafinal1)
        return 1;

    return 0;
}
function recorrearbol($materiaraiz, $gruposelegidos, $codigoperiodo, $sala) {
    foreach($materiaraiz as $grupoeleg => $steLlave) {
        //echo "<br> CUENTA HERMANOS de M0 : ".count($steMateria)."<br>";;
        foreach($steLlave as $llavegrupo => $steMateria) {
            $gruposelegidos[] = $grupoeleg;
            if($steMateria == 0) {
                if(horariovalido($gruposelegidos, $codigoperiodo, $sala)) {
                    return 1;
                }
                else {
                    // Quiar ultimo elemento del arreglo de grupos
                    array_pop($gruposelegidos);
                }
            }
            else {
                //echo "gruposelegidos = $grupoeleg  Tamaño ::: ".count($gruposelegidos)."<br>";
                // Selecciona la siguiente materia
                //echo "recorrearbol($steMateria, $gruposelegidos, $codigoperiodo, $raiz, $sala)";
                if(!recorrearbol($steMateria, $gruposelegidos, $codigoperiodo, $sala)) {
                    // Quita ultimo elemento del arreglo de grupos
                    array_pop($gruposelegidos);
                }
                else {
                    return 1;
                }
            }
        }
    }
}
?>