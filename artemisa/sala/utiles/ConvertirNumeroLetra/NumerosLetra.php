<?php

namespace Sala\utiles\ConvertirNumeroLetra;

abstract class NumerosLetra {

    public static function numToOrdinal( $num, $fem = false, $dec = true) {
        $matuni[2] = "segundo";
        $matuni[3] = "tercer";
        $matuni[4] = "cuarto";
        $matuni[5] = "quinto";
        $matuni[6] = "sexto";
        $matuni[7] = "séptimo";
        $matuni[8] = "octavo";
        $matuni[9] = "noveno";
        $matuni[10] = "décimo";
        $matuni[11] = "undécimo";
        $matuni[12] = "duodécimo";
        $matuni[13] = "décimo tercer";
        $matuni[14] = "décimo cuarto";
        $matuni[15] = "décimo quinto";
        $matuni[16] = "décimo sexto";
        $matuni[17] = "décimo séptimo";
        $matuni[18] = "décimo octavo";
        $matuni[19] = "décimo noveno";
        $matuni[20] = "vigésimo";
        $matunisub[2] = "segundo";
        $matunisub[3] = "tercer";
        $matunisub[4] = "cuarto";
        $matunisub[5] = "quinto";
        $matunisub[6] = "sexto";
        $matunisub[7] = "séptimo";
        $matunisub[8] = "octavo";
        $matunisub[9] = "noveno";

        $matdec[2] = "vigésimo";
        $matdec[3] = "trigésimo";
        $matdec[4] = "cuadragésimo";
        $matdec[5] = "quincuagésimo";
        $matdec[6] = "sexagésimo";
        $matdec[7] = "septuagésimo";
        $matdec[8] = "octogésimo";
        $matdec[9] = "nonagésimo";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millonésimo';
        $matmil[6] = 'billonésimo';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillonésimo';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        //Zi hack
        $float = explode('.', $num);
        $num = $float[0];

        $num = trim((string) @$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                } else
                    $ent .= $n;
            } else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and ! $zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' primer' : ' primer';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int) $ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'primer';
                $subcent = 'os';
            } else {
                $matuni[1] = $neutro ? 'primer' : 'primer';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
                
            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int) $n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' centésimo' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'centésimo' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'centésimo' . $subcent . $t;
            }
            if ($sub == 1) {
                
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'onésimo';
            }
            if ($num == '000')
                $mils ++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        //Zi hack --> return ucfirst($tex);
        $end_num = ucwords($tex);
        return $end_num;
    }

}
