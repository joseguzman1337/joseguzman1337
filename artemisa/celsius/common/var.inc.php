<?
$parser_version = phpversion();
if ($parser_version <= "4.1.0")
	$ArrayList = array ("HTTP_GET_VARS","HTTP_POST_VARS");//,"HTTP_ENV_VARS","HTTP_SERVER_VARS","HTTP_COOKIE_VARS","HTTP_POST_FILES","HTTP_SESSION_VARS");
else
	$ArrayList = array ("_GET","_POST");//,"_ENV","_SERVER","_COOKIE","_FILES","_SESSION");

foreach ($ArrayList as $gblArray) {
	if (isset ($$gblArray)) {
		$array = $$gblArray;
		if (is_array($array)) {
			$keys = array_keys($array);
			if (is_array($keys))
				foreach ($keys as $key) {
					if (is_string(${ $gblArray }[$key])){
						$$key = trim(${$gblArray}[$key]);
						if (get_magic_quotes_gpc()==1)
							$$key = stripslashes($$key);
					}else
						$$key = (${$gblArray}[$key]);
				}
		}
	}
}
?>