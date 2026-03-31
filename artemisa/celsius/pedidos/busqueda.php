<? 
 
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";
Conexion();
include_once "../inc/"."identif.php";
Usuario();


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<SCRIPT LANGUAGE="JavaScript">
<!--
 var valor="";
  function titulosNormalizados()
   { 
	var Letra = "A";
//    alert("Letra");
    if (document.forms.form2.expresion.value != '')
		  Letra = document.forms.form2.expresion.value;
	  var win = window.open("../admin/elige_col.php?dedonde=popup&Letra="+Letra,"titulos","toolbar=no, directories=no, location=no,status=yes, menubar=no, resizable=yes, scrollbars=yes, width=700, height=700, top=20, left=30");
   }

  function cambiar()
  {
	  if (document.getElementById('campo').value == 2)
	  {
		  document.getElementById('labelTitulos').style.visibility = 'visible';
		  document.getElementById('labelTitulos').style.position = 'relative';
	  }
	  else
	  {
		  document.getElementById('labelTitulos').style.visibility = 'hidden';
		  document.getElementById('labelTitulos').style.position = 'absolute';
	  }

	  if (document.getElementById('campo').value == 1)  {
				document.getElementById('expresion').value=valor;
				}
				else
				{
					document.getElementById('expresion').value='';
				}
  }

   function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=530, height=450");
   


 } 
  function busquedas(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("pres_busq.php?Id_Pedido="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "scrollbars=yes,dependent=yes,toolbar=no,width=700,height=500");
   
 }  
 function rutear_PedHist (TipoPed,Id){
	 rutear_pedidos (TipoPed,Id, '2');
 }
	

  function rutear_pedidos (TipoPed,Id, Tabla)
 {
    var dedonde='<?
     	if ($dedonde==1)
     	{
     		$cons = 1;
     	}
     	else
     	{
     		$cons = 2;
     	}
		echo $cons
     ?>';
	
     switch (TipoPed)
	  {
	    case 1:
		   ventana=open("verped_col.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Colecciones","scrollbars=yes,width=700,height=500,alwaysLowered"); 
		  
	      break;
	   case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Capitulos","scrollbars=yes,width=700,height=500,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Patentes","scrollbars=yes,width=700,height=500,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Tesis","scrollbars=yes,width=700,height=500,alwaysRaised");
          break;	
       case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Congresos","scrollbars=yes,width=700,height=500,alwaysRaised");
          break;	
                
	  }
	    
	 return null	;
	
 }

 function vent_anula(Id)
{
   ventana=window.open("../anula/genanu.php?Id="+Id+"&dedonde=2", "Eventos", "dependent=yes,toolbar=no,width=500,height=500");
   
 }
//-->
</SCRIPT>
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
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}
.style35 {color: #FFFFFF}
.style29 {color: #006599}
.style40 {color: #006699}
.style49 {font-size: 11px; font-family: verdana; }
.style50 {font-size: 11px}
.style52 {
	color: #006599;
	font-weight: bold;
	font-family: Verdana;
	font-size: 11px;

-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
    
  
     include_once "../inc/fgentrad.php";
	 
     include_once "../inc/"."tabla_ped_unnoba.inc";
     include_once "../inc/"."fgenped.php";
	 global $Rol;
	$Mensajes = Comienzo ("adm-002",$IdiomaSitio);
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
	$valor="";
	$valor= Devolver_Abreviatura_Pais_Predeterminada()."-".Devolver_Abreviatura_Institucion_Predeterminada()."-"; 

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
  valor = "<? echo $valor;?>";

//-->
</SCRIPT>
<div align="left">

  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse"><!-- tabla 1 -->
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center" bgcolor="#E4E4E4">
        <center>
      <table width="600" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5"><!-- tabla 2 -->
      <tr>
        <td valign="top"> <div align="center">
              <center>
			  <!-- las siguientes tablas son las que contiene el form de los datos -->
                <table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC"><!-- tabla 3 -->
                  <tr bgcolor="#006699">
                    <td height="20" class="style33" align="left"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"></span></td>
                  </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
						
					  <form name="form2" action="busqueda.php">
                      <table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22"><!-- tabla 4 -->

                        <tr>
                          
						  <td width="180" class="style22"><div align="right"><? echo $Mensajes["tt-01"]; ?></div></td>
						  <td  class="style22" colspan="2"><div align="left"><INPUT TYPE="text" class="style33" NAME="expresion" id="expresion" SIZE="27" value="<? 
						    
							 if (!isset($campo)){
									$campo=1;
									$ok=true;
									}
							 if (isset($expresion)) {
								   echo $expresion;
								 }
							 if (!isset($expresion)  && ($campo ==1) )
								 {
								 
								 echo $valor;
								 }
								?>"></div></td>
						</tr>
						<tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td width="360"><span align="left">
						  <SELECT NAME="campo" onChange="cambiar();" id=campo class="style22">
							<option value=1  <? if ($campo== '1') echo "selected"; ?>><? echo $Mensajes["tt-02"]; ?></option>
							<option value=2  <? if ($campo== '2') echo "selected"; ?>><? echo $Mensajes["tt-03"]; ?></option>
							<option value=3  <? if ($campo== '3') echo "selected"; ?>><? echo $Mensajes["tt-004"]; ?></option>
						  </select>
						  <span align="left" class="style47" id="labelTitulos" style="position:relative"> <a href="Javascript:titulosNormalizados();"><? echo $Mensajes["tt-05"]; ?></a></span>
							 </span></td>
						   <td class="style22">&nbsp;</td>
						</tr>
						<tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td width="160"><div align="left"><input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1"  class="style22" >
							 </div></td>
						   <td class="style22">&nbsp;</td>
						</tr>


					  </table>
					  </form>

						
									<?
						include_once "../inc/fgenped.php";
						if (($Rol==1))
			                  $esAdmin = 1;
					      else
            				  $esAdmin = 0;
						  $cantidad = 9;
						if (! isset($pg))
								{
									$inicial=0;
									$pg =1;
								}
								else
								{
									$inicial = ($pg-1) * $cantidad;
								}
						  
						if ($expresion != ""){
						
							switch($campo){
								
								case '1':  

											Busqueda_Pedido_Por_Codigo($expresion , $dedonde , $Id_Usuario ,$VectorIdioma , $Mensajes , $Bibliotecario ,$esAdmin);
											break;
								case '2': 
											Busqueda_Titulo_No_Normalizado($expresion , $dedonde , $Id_Usuario ,$VectorIdioma , $Mensajes,$Bibliotecario ,$esAdmin, $inicial , $pg, $cantidad);
											break;
								case '3':   
									        
											Busqueda_Autor($expresion , $dedonde , $Id_Usuario ,$VectorIdioma , $Mensajes, $Bibliotecario ,$esAdmin, $inicial , $pg, $cantidad);
											break;
							} //end del switch ($campo)
						}

						?>
						<br>
					 </td>

				  </tr>
				</table>
			</center>
		  </td>
		 

	    </tr>
     </table>
	 </center>
	 </div>
	  </td>
	   <td width="150" valign="top" bgcolor="#E4E4E4" align="center"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style50"><a href="../admin/indexadm.php"><? echo $Mensajes["cf-13"]; ?></a></span></span></p>
                  </div>                  </td>
    </tr>

	 <tr>
    <td height="44" bgcolor="#E4E4E4" colspan=2><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
  </table>

</body>
</html>
