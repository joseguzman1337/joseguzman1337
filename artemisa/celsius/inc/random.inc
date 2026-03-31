<?

/* if (__Random_inc == 1) return;
define ('__Random_inc', 1);
*/

$Randomized=false;

// init random generator
//
if (!function_exists("Randomize")) {
function Randomize()
{       
        global $Randomized;
	$Randomized=1;
	srand((double)microtime()*1000000);
}
}
// random val generation
//

if (!function_exists("Random")) {
function Random($min, $max)
{ global $Randomized;
  if ($min == $max)
    return $min;


	if (!$Randomized)
		Randomize();

  if ($min < $max)
    return rand() % ($max - $min) + $min;
  else
    return rand() % ($min - $max) + $max;
}
}

// random name generation
//
if (!function_exists("RandName")) {
function RandName($n)
{
  for ($i=0, $str = ""; $i<$n; $i++)
    $str .= chr(Random(ord('a'), ord('z')));
  return $str;
}
}

?>
