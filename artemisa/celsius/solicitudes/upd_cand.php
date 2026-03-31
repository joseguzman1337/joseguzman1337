<?
include_once "../inc/var.inc.php";  
include_once "../inc/"."conexion.inc.php";
  include_once "../inc/"."parametros.inc.php";
  Conexion();  
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."identif.php"; 
  Administracion();
  global $IdiomaSitio;
  $Mensajes = Comienzo ("aus-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>
<html>
<head>
<title>PrEBi </title>
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
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style42 {color: #FFFFFF; font-family: verdana; font-size: 9px; }
-->
</style>

<base target="_self"> 

</head>
<body >
<?    
   $Dia = date ("d");
   $Mes = date ("m");
   $Anio = date ("Y");
   $FechaHoy =$Anio."-".$Mes."-".$Dia;
	if ($dedonde==0) {  
		 $Instruccion = "";
         $Instruccion = "INSERT INTO Candidatos (Apellido,Nombres,EMail,Codigo_Institucion,Otra_Institucion,";
         $Instruccion .= "Codigo_Dependencia,Otra_Dependencia,Codigo_Unidad,Otra_Unidad,Direccion,";
         $Instruccion .="Codigo_pais,Otro_pais,Codigo_Localidad,Otra_Localidad,Codigo_Categoria,Otra_Categoria,";
         $Instruccion .= "Telefonos,Fecha_Registro,Comentarios) VALUES ('".$Apellido."','".$Nombres;
         $Instruccion .= "','".$Mail."','".$Institucion."','".$OtraInstitucion."','".$Dependencias;
         $Instruccion .= "','".$OtraDependencia."','".$Unidades."','".$OtraUnidad."','".$Direccion;
         $Instruccion .= "','".$Pais."','".$OtroPais."','".$Localidad."','".$OtraLocalidad;
         $Instruccion .= "','".$Categoria."','".$OtraActividad."','".$Telefono."',NOW(),'".$Comentarios."')";
   	 } else {
 	     $Instruccion = "UPDATE Candidatos SET Apellido='".$Apellido."',Nombres='".$Nombres."',Email='".$Mail."'";
 	     $Instruccion = $Instruccion. ",Codigo_Institucion='".$Institucion."',Otra_Institucion='".$OtraInstitucion."'";
         $Instruccion = $Instruccion. ",Codigo_Dependencia='".$Dependencias."',Otra_Dependencia='".$OtraDependencia."'";
         $Instruccion = $Instruccion. ",Codigo_Unidad='".$Unidades."',Otra_Unidad='".$OtraUnidad."', Direccion='".$Direccion."'";
         $Instruccion = $Instruccion. ",Codigo_pais='".$Pais."',Otro_pais='".$OtroPais."',Codigo_Localidad='".$Localidad."',Otra_Localidad ='".$OtraLocalidad."'";
         $Instruccion = $Instruccion. ",Codigo_Categoria='".$Categoria."',Otra_Categoria='".$OtraActividad."'";
         $Instruccion = $Instruccion. ",Telefonos='".$Telefono."',Comentarios='".$Comentarios."'";
         $Instruccion = $Instruccion. " WHERE Id=".$Id;
        
    }  

   $result = mysql_query($Instruccion); 

   echo mysql_error();


   $Numero =mysql_affected_rows();	

   
 
   Desconectar();
  
  
  ?>
	
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5" bgcolor="#EFEFEF" >
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4"><table width="100%"  border="0">
                  <tr>
                    <td width="567" height="130" align="center" valign="middle" class="style23">                         <div align="center" class="style41">
					<?
					 if ($Numero>0) {
					echo $Mensajes["gra-1"].$Mensajes["gra-2"]." <a href='mailto:".Destino_Mail()."'>".Destino_Mail()."</a>";
					}
					else
					{
					echo $Mensajes["txt-2"];
					}
				?>
			</div></td>
                  </tr>
                </table>                  

                  </td>
              </tr>
            </table>
              </center>
            </div>            </td>
       
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
       
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="right" class="style33">aus-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
