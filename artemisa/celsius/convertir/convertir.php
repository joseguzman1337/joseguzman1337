<?
#*************************************************************
# this function converts an amount into alpha words
# with the words $curr and decimal/100.  Pass it a float.
# Example:  $3.77 = tres $curr 77/100
# works up to 999,999,999.99
#*************************************************************

function makewords($numval,$curr)
{
 
 $moneystr = "";
  #Millions
  $milval = int($numval / 1000000);
  if($milval == 1) {
    $moneystr .= "un millon";
  }
  if($milval > 1) {
    $moneystr .= getwords($milval) . " millones";
  }  
  #thousands
  $workval = $numval - ($milval * 1000000); # get rid of millions
  $thouval = int($workval / 1000);
  if($thouval > 0) {
    $workword = getwords($thouval);
    if ($moneystr == "") {
      $moneystr = $workword . " mil";
    } else {
      $moneystr .= " " . $workword . " mil";
    }
  }
  #handle all the rest of the money
  $workval = $workval - ($thouval * 1000); # get rid of thousands
  $tensval = int($workval);
  if ($moneystr == 0) {
    if ($tensval > 0) {
      $moneystr .= getwords($tensval);
    } else {
      $moneystr .= "cero";
    }
  } else {
  # non zero values in hundreds and up
    $workword = getwords($tensval);
    $moneystr .= " " . $workword;
  }
  # plural or singular
  $workval = int($numval);
  if ($workval == 1) {
    $moneystr .= " " . lc($curr) . " ";
  } else {
    $moneystr .= " " . lc($curr) . "s ";
  }
  # do the pennies - use printf so that we get the
  # same rounding as printf
  $workstr = sprintf("%3.2f",$numval); #// convert to a string
  $intstr = substr($workstr,length($workstr) - 2, 2);
  $workint = int($intstr);
  if ($workint == 0) {
    $moneystr .= "00/100";
  } else {
    $moneystr .= $workint."/100";
  }

  # done - let's get out of here!
  return $moneystr;
}

#*************************************************************
# this function creates word phrases in the range of 1 to 999.
# pass it an integer value
#*************************************************************

function getwords($workval)
{
  
  $numwords = (
	'1' => "un",
	'2' => "dos",
	'3' => "tres",
	'4' => "cuatro",
	'5' => "cinco",
	'6' => "seis",
	'7' => "siete",
	'8' => "ocho",
	'9' => "nueve",
	'10' => "diez",
	'11' => "once",
	'12' => "doce",
	'13' => "trece",
	'14' => "catorce",
	'15' => "quince",
	'16' => "dieciseis",
	'17' => "diecisiete",
	'18' => "dieciocho",
	'19' => "diecinueve",
	'20' => "veinte",
	'30' => "treinta",
	'40' => "cuarenta",
	'50' => "cincuenta",
	'60' => "sesenta",
	'70' => "setenta",
	'80' => "ochenta",
	'90' => "noventa");

  $numpal = (
	  '1' => "ciento",
	  '2' => "doscientos",
	  '3' => "trescientos",
	  '4' => "cuatrocientos",
	  '5' => "quinientos",
	  '6' => "seiscientos",
	  '7' => "setecientos",
	  '8' => "ochocientos",
	  '9' => "novecientos");

  # handle the 100's
  $retstr = " ";
  $hundval = int($workval / 100);
  if ($hundval == 1) {
    $retstr = " ciento";
  }
  if ($hundval > 1) {
    $retstr .= $numpal{$hundval};
  }

  #handle units and teens
  $workstr = "";
  $tensval = $workval - ($hundval * 100); # dump the 100's
  $tempval = (int($tensval / 10)) * 10;
  $unitval = $tensval - $tempval;
  if (($tensval < 20) && ($tensval > 0)) {# do the teens
    $workstr = $numwords{$tensval};
  } else {# got to break out the units and tens
  if ($tensval > 20 && $tensval < 30) {# do the teens
    $workstr .= " veinti".$numwords{$unitval};
  } else {
    $workstr = $numwords{$tempval}; # get the tens
  if ($unitval > 0) {
    $workstr .= " y " . $numwords{$unitval};
    }
  }
  }  
  # join all the parts together and leave
  if ($workstr ne "") {
    if ($retstr ne "") {
      $retstr .= " " . $workstr;
    } else {
      $retstr = $workstr;
    }
  } return $retstr;
} 

?>