<?
ini_set( 'include_path' , '.:/services/web/httpd/public_html/prebi/');
$parser_version = phpversion();
if ($parser_version <= "4.1.0")
   	 $ArrayList = array("HTTP_GET_VARS","HTTP_POST_VARS","HTTP_ENV_VARS","HTTP_SERVER_VARS","HTTP_COOKIE_VARS","HTTP_POST_FILES","HTTP_SESSION_VARS");
else
	$ArrayList = array("_GET", "_POST", "_ENV","_SERVER","_COOKIE","_FILES","_SESSION");

  foreach($ArrayList as $gblArray)
   { 
	 if (isset($$gblArray)) {
     if (is_array($$gblArray))
		 {
		 $keys = array_keys($$gblArray);
			if (is_array($keys))
				foreach($keys as $key)
                  {
				   if (is_string(${$gblArray}[$key]))
    				   $$key = trim(${$gblArray}[$key]);
	              }

		 }
	  }
   }

?>