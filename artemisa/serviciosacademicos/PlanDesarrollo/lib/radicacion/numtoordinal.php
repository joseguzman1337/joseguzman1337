<?php 
/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 

*/ 


function num2toordinal($num, $fem = false, $dec = true) { 
   $matuni[2]  = "segunda"; 
   $matuni[3]  = "tercera"; 
   $matuni[4]  = "cuarta"; 
   $matuni[5]  = "quinta"; 
   $matuni[6]  = "sexta"; 
   $matuni[7]  = "séptima"; 
   $matuni[8]  = "octava"; 
   $matuni[9]  = "novena"; 
   $matuni[10] = "décima"; 
   $matuni[11] = "undécima"; 
   $matuni[12] = "duodécima"; 
   $matuni[13] = "décima tercera"; 
   $matuni[14] = "décima cuarta"; 
   $matuni[15] = "décima quinta"; 
   $matuni[16] = "décima sexta"; 
   $matuni[17] = "décima séptima"; 
   $matuni[18] = "décima octava"; 
   $matuni[19] = "décima novena"; 
   $matuni[20] = "vigésima"; 
   $matunisub[2] = "segunda"; 
   $matunisub[3] = "tercera"; 
   $matunisub[4] = "cuarta"; 
   $matunisub[5] = "quinta"; 
   $matunisub[6] = "sexta"; 
   $matunisub[7] = "séptima"; 
   $matunisub[8] = "octava"; 
   $matunisub[9] = "novena"; 

   $matdec[2] = "vigésima"; 
   $matdec[3] = "trigésima"; 
   $matdec[4] = "cuadragésima"; 
   $matdec[5] = "quincuagésima"; 
   $matdec[6] = "sexagésima"; 
   $matdec[7] = "septuagésima"; 
   $matdec[8] = "octogésima"; 
   $matdec[9] = "nonagésima"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millonésimo'; 
   $matmil[6]  = 'billonésimo'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillonésimo'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' primera' : ' primera'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'primera'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'primera' : 'primera'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' centésima' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'centésima' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'centésima' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'onésimo'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   $end_num=ucwords($tex);
   return $end_num; 
} 
?> 