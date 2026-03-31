<? 
  
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Usuario();
 	
?> 

<html>
<head>
<title>Ventana de Registro de Pedidos</title>
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
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.style42 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
-->
</style>

</head>
<script language="JavaScript">
 function rutear_vuelta(donde)
 {
  switch (donde)
  {
   case 1:
     document.form1.action = "verped_col.php";
     break;
   case 2:
     document.form1.action = "verped_cap.php";
     break;
   case 3:
     document.form1.action = "verped_pat.php";
     break; 
   case 4:
     document.form1.action = "verped_tes.php";
     break;    
	case 5:
     document.form1.action = "verped_con.php";
     break;    
  }
  document.form1.submit();   
 }
</script>

<body>
<?   if (!isset($Indice))
              $Indice = '';
    if ($Indice=="ON")
   {
   		$Indice=1;
   }
   else
   {
   		$Indice=0;
   }

	$Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
    
  include_once "../inc/"."fgenhist.php";
  include_once "../inc/"."fgentrad.php";

   $Mensajes = Comienzo ("upp-001",$IdiomaSitio);
  
        
       
     $Instruccion = "UPDATE Pedidos SET ";
     
      if ($TipoMaterial==1)
     { 
       $Instruccion = $Instruccion."Titulo_Revista='".AddSlashes($Titulo_Revista)."',";
       $Instruccion = $Instruccion."Titulo_Articulo='".AddSlashes($NombreArticulo)."',";
       $Instruccion = $Instruccion."Volumen_Revista='".AddSlashes($Volumen)."',";
       $Instruccion = $Instruccion."Numero_Revista='".$Numero."',";
       $Instruccion = $Instruccion."Anio_Revista='".$AnioRevista."',";
       $Instruccion = $Instruccion."Pagina_Desde='".$PagDesde."',";
       $Instruccion = $Instruccion."Pagina_Hasta='".$PagHasta."',";
       $Instruccion = $Instruccion."Autor_Detalle1='".AddSlashes($Autor1)."',";
       $Instruccion = $Instruccion."Autor_Detalle2='".AddSlashes($Autor2)."',";
       $Instruccion = $Instruccion."Autor_Detalle3='".AddSlashes($Autor3)."',";
       $Instruccion = $Instruccion."Codigo_Titulo_Revista=".$Id_Col;
     }
     if ($TipoMaterial==2)
     {
       $Instruccion = $Instruccion."Titulo_Libro='".AddSlashes($Titulo)."',";
       $Instruccion = $Instruccion."Anio_Libro='".$AnioLibro."',";
       $Instruccion = $Instruccion."Autor_Libro='".AddSlashes($AutorTitulo)."',";
       $Instruccion = $Instruccion."Editor_Libro='".AddSlashes($Editorial)."',";
       $Instruccion = $Instruccion."Capitulo_Libro='".$AnioLibro."',";
       $Instruccion = $Instruccion."Desea_Indice=".$Indice.",";
       $Instruccion = $Instruccion."Capitulo_Libro='".AddSlashes($Capitulo_Libro)."',";
       $Instruccion = $Instruccion."Autor_Detalle1='".AddSlashes($Autor1)."',";
       $Instruccion = $Instruccion."Autor_Detalle2='".AddSlashes($Autor2)."',";
       $Instruccion = $Instruccion."Autor_Detalle3='".AddSlashes($Autor3)."',";
       $Instruccion = $Instruccion."Pagina_Desde='".$PagDesde."',";
       $Instruccion = $Instruccion."Pagina_Hasta='".$PagHasta."'";
     }
     if ($TipoMaterial==3)
     {
       $Instruccion = $Instruccion."Codigo_Pais_Patente=".$Pais.",";
       $Instruccion = $Instruccion."Pais_Patente='".$OtroPais."',";
       $Instruccion = $Instruccion."Anio_Patente='".$AnioPatente."',";
       $Instruccion = $Instruccion."Numero_Patente='".AddSlashes($NumeroPatente)."'";
     }
     
     if ($TipoMaterial==4)
     {
    	
       $Instruccion = $Instruccion."TituloTesis='".AddSlashes($TituloTesis)."',";
       $Instruccion = $Instruccion."AutorTesis='".AddSlashes($AutorTesis)."',";
       $Instruccion = $Instruccion."DirectorTesis='".AddSlashes($DirectorTesis)."',";
       $Instruccion = $Instruccion."GradoAccede='".AddSlashes($GradoAccede)."',";
       $Instruccion = $Instruccion."Anio_Tesis='".$AnioTesis."',";
       $Instruccion = $Instruccion."PagCapitulo='".$PagCapitulo."',";
       $Instruccion = $Instruccion."Codigo_Pais_Tesis=".$PaisTesis.",";
       $Instruccion = $Instruccion."Otro_Pais_Tesis='".$OtroPaisTesis."',";
       $Instruccion = $Instruccion."Codigo_Institucion_Tesis=".$InstitucionTesis.",";
       $Instruccion = $Instruccion."Otra_Institucion_Tesis='".AddSlashes($OtraInstitucionTesis)."',";
       $Instruccion = $Instruccion."Codigo_Dependencia_Tesis=".$DependenciaTesis.",";
       $Instruccion = $Instruccion."Otra_Dependencia_Tesis='".AddSlashes($OtraDependenciaTesis)."'";
     }

	 if ($TipoMaterial==5)
     {
       $Instruccion = $Instruccion."TituloCongreso='".AddSlashes($TituloCongreso)."',";
       $Instruccion = $Instruccion."Organizador='".AddSlashes($Organizador)."',";
       $Instruccion = $Instruccion."NumeroLugar='".AddSlashes($NumeroLugar)."',";
       $Instruccion = $Instruccion."Anio_Congreso='".AddSlashes($AnioCongreso)."',";
       $Instruccion = $Instruccion."PaginaCapitulo='".$PaginaCapitulo."',";
       $Instruccion = $Instruccion."PonenciaActa='".AddSlashes($PonenciaActa)."',";
       $Instruccion = $Instruccion."Codigo_Pais_Congreso=".$PaisCongreso.",";
       $Instruccion = $Instruccion."Otro_Pais_Congreso='".$OtroPaisCongreso."'";     
     }
     
	  If ($TardanzaAtencion=="")	     
	  {
	  	$TardanzaAtencion=0;
	  }
	  
	  If ($TardanzaBusqueda=="")
	  {
	  	$TardanzaBusqueda=0;
	  }
	  
	  If ($TardanzaRecepcion=="")
	  {
	  	$TardanzaRecepcion=0;
	  }
	  
     $Instruccion .=",Tardanza_Atencion=".$TardanzaAtencion;
     $Instruccion .= ",Tardanza_Busqueda=".$TardanzaBusqueda;
     $Instruccion .= ",Tardanza_Recepcion=".$TardanzaRecepcion;
	 $Instruccion .= ",Observaciones='".AddSlashes($Observaciones)."'";
	 $Instruccion .= ",Tipo_Pedido='".$Tipo_Pedido."'";
	 
     $Instruccion = $Instruccion." WHERE Id='".$Id."'";
     //echo $Instruccion;
     $result = mysql_query($Instruccion);                  
	 if (!mysql_error())       
     {
    
?>
<script>


//alert(window.opener.document.forms[0]);
//window.close();
window.opener.document.forms[0].submit();    
</script>
<p>

<div align="center">
  <center>
<br>
<br>
<br>
<br>
<br>
<br>
<table border="0" width="89%" height="1" cellspacing="0">
  <tr>
    <td width="136%" valign="top" bgcolor="#006699">
    <font face="MS Sans Serif" size="2" color="#FFFFCC"><b>&nbsp;</b></font>
    <form method="POST" name="form1">
      <p align="center">

	   <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B3"  OnClick="rutear_vuelta(<? echo $TipoMaterial; ?>)">
       <input type="hidden" name="Id" value="<? echo $Id; ?>">
       <input type="hidden" name="dedonde" value=2>
	   <input type="hidden" name="Tabla" value="<? echo $Tabla; ?>">
       </p>
    </form>
    </td>
  </tr>
  
  <tr>
    <td width="187%" height="15" valign="top">
    <P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>upp-001</FONT>
    </td>
  </tr>
</table>
  </center>

<p>&nbsp;</p>

<? 
   
   
 } 
 else
 {
  echo $Instruccion;
  echo "Se ha producido un error grave en la carga del Pedido: ". mysql_error()."\n";
  echo "Informe al Soporte Técnico";
 }
  Desconectar();

?>

</body>

</html>






















