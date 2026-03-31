<?
    
    include_once "../inc/"."var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   
 ?>

<html>

<head>
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>

<title>PrEBi</title>
</head>
<script language="JavaScript">
function actualizar ()
{
   self.opener.form2.action='anulaped.php'
   self.opener.form2.submit(); 
	return true;
}
</script>
<body>
<? 
  include_once "../inc/fgenhist.php";
  include_once "../inc/fgentrad.php";
   global $IdiomaSitio; 
   $Mensajes = Comienzo ("gen-anu",$IdiomaSitio);
   

   Bajar_Anulados($Id_Pedido,$Fecha_Anulacion,$Causa_Anulacion,$Id_usuario);
    		

?>
<div align="center">
  <center>
<table border="0" width="85%" bgcolor="#006699" height="25">
  <tr>
    <td width="100%" align="center"><font face="MS Sans Serif" size="1" color="#FFFF00">
              <b><? echo $Mensajes["tf-3"]." ".$Usuario." ".$Mensajes["tf-4"]." ".$Id_Pedido; ?></b></font>
        
    </td>  
  </tr>
</table>
  </center>
</div>
<P ALIGN="center">
<input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B2" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="javascript:self.close()">

<? 
	Desconectar();
?>
<P ALIGN="center">
<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>gen-anu</FONT>

</body>

<script language="Javascript">
	actualizar()
</script>

</html>
















