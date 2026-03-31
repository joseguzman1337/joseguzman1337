<?
/*
if (__fgentrad_inc == 1)
		return;
	define ('__fgentrad_inc', 1);
*/
if (isset($_COOKIE['IdiomaSitio'])) {
   global $IdiomaSitio;
   $IdiomaSitio = $_COOKIE['IdiomaSitio'];
    }
function IdiomaPorDefecto()
{
    $resu = mysql_query("SELECT Id FROM Idiomas WHERE Predeterminado=1");
    $row = mysql_fetch_row($resu);
    if ($row)
      return $row[0];
    else
      return 0;
}
function Comienzo($Pantalla,$Idioma)
{   $Mensaje="";
	if ($Idioma=='')
       {
       $Idioma = IdiomaPorDefecto();
       }
       
   $Instruccion = "SELECT Codigo_Elemento,Texto,Nombre_Archivo FROM Traducciones WHERE Codigo_Pantalla='$Pantalla'";
	$Instruccion = $Instruccion. " AND Codigo_Idioma=".$Idioma;
   // echo $Instruccion;
	$result=mysql_query($Instruccion);
	echo mysql_error();

	while ($row=mysql_fetch_row($result))
	{
	  $Mensaje["$row[0]"] = $row[1];
	}
	
	mysql_free_result ($result);
	return $Mensaje;
}	

function ObtenerVectorIdioma($Idioma)
{
	

	if ($Idioma=='')
       {
       $Idioma = IdiomaPorDefecto();
       }
   $Instruccion = "SELECT * FROM Idiomas WHERE Id=".$Idioma;
	$result=mysql_query($Instruccion);
	$Id_Vect = mysql_fetch_array($result);
	echo mysql_error();
	mysql_free_result ($result);
	return $Id_Vect;
}	

function ObtenerVectorCampos($Idioma,$TipoMaterial)
{
    
	global $Arr;
	$Instruccion = "	SELECT Numero_Campo,Heading,Heading_Abrev,ER_Validacion,Mensaje_Error FROM Campos WHERE Codigo_Idioma=$Idioma AND Tipo_Material=$TipoMaterial";
	
	$result=mysql_query($Instruccion);
    while ($row=mysql_fetch_row($result))
	{
	  $Arr[$row[0]][0] = $row[1];
  	  $Arr[$row[0]][1] = $row[2];
	  $Arr[$row[0]][2] = $row[3];
      $Arr[$row[0]][3] = $row[4];
     
	}
	
	mysql_free_result ($result);
	return $Arr;	
}

?>
