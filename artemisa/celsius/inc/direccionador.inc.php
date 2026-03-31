<?
if (__Parametros_inc == 1)
	return;

define ('__Parametros_inc', 1);

function Obtener_Direccion($opcion = 1)
{
  if ($opcion ==0)
   return "/services/web/httpd/public_html/prebi2/inc/";
  else
    return "/services/web/httpd/public_html/unnoba/inc/";
}


?>
