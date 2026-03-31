<?
include("../inc/convertir.php");

if  (isset($numero))
{
 echo "Numero a convertir:".num2letras($numero,true,true);
}  

?>
<html>
<body>
<FORM METHOD=POST ACTION="pruebaconvertir.php">
Numero a convertir: <INPUT TYPE="text" NAME="numero">
<INPUT TYPE="submit" value="Enviar">
</FORM>
</body>
</html>