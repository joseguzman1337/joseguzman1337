<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";  
  Conexion();
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";

  global  $IdiomaSitio ; 
  
  $Mensajes = Comienzo ("bib-001",$IdiomaSitio);  
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

  if ( !isset($texto))  $texto="";


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {
	color: #FFFFFF;
	font-size: 9px;
	font-family: Verdana;
}
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style45 {font-family: Verdana; color: #FFFFFF;}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
-->
</style>

<base target="_self">
</head>

<SCRIPT>
function Seteo_Modo()
 {
    document.forms.form1.action="enlaces.php";   
    document.forms.form1.submit();
  
 }

 function Set_Value(new_value)
 { 
	 document.getElementById('texto').value = new_value;
     document.getElementById('texto').focus(); 
 }

 function ver_Todos()
 {
  document.getElementById('texto').value = '';
  document.forms.form1.action="enlaces.php";
  document.forms.form1.submit();
 }
</SCRIPT>
<body topmargin="0" onLoad="Set_Value(<?echo "'".$texto."'"; ?>);">

<?            
			  $expresion = "SELECT Paises.Nombre, Paises.id, Instituciones.Codigo,Instituciones.Nombre,Instituciones.Sitio_Web, Dependencias.Nombre, Dependencias.Hipervinculo1,Dependencias.Hipervinculo2,Dependencias.Hipervinculo3,Dependencias.Comentarios ";
			  $expresion .= "FROM Paises, Instituciones, Dependencias ";
			  $expresion .= "WHERE Paises.Id = Instituciones.Codigo_Pais and Instituciones.Codigo = Dependencias.Codigo_Institucion and Dependencias.Es_Liblink = 1";
			
			  if (isset ($texto) &&($texto != ''))
			    { $expresion .= " and (Paises.Nombre like '%".$texto."%' or Instituciones.Nombre like '%".$texto."%' or Dependencias.Nombre like '%".$texto."%' or Dependencias.Comentarios like '%".$texto."%')";
			    }
 
			  $expresion .= " ORDER BY Paises.Nombre,Instituciones.Nombre,Dependencias.Nombre";
			  //echo $expresion;
			  $result = mysql_query($expresion);
			  echo mysql_error();
?>
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45"><p align="left" class="style54">
                    <span class="style49"><img src="../images/square-lb.gif" width="8" height="8"> <? echo $Mensajes['et-2']; ?>
                   </p>
                      <hr></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" class="style45"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
					
				<?
				while ($row = mysql_fetch_array($result)) {
					

					//Primero muestro la dependencia, con su(s) websites
					/*if ($row[5]) {
						echo ' <tr> <td class="style49" >'.$row[5]." - "; 
		                if ($row[6])
						{
							$temp = ' <a target="_BLANK" href="'.$row[6].'"> '.$row[6].'</a>';
							if ($row[7])
								$temp.=';';	
							echo $temp;
						}

						if ($row[7])
							echo ' <a target="_BLANK" href="'.$row[7].'"> '.$row[7].';</a>';
			            if ($row[8])
							echo ' <a target="_BLANK" href="'.$row[8].'"> '.$row[8].';</a>';
						echo '</td></tr>';
					}
					echo '<tr><td bgcolor="#ECECEC" class="style49"><div align="left" class="style43">';
					//Luego muestro la institucion a la que pertenece
					if ($row[3]) {
						echo 'Instituci&oacute;n:&nbsp;'.$row[3];
						if ($row[4])
							echo ' <a target="_BLANK" href="'.$row[4].'"> - '.$row[4].'</a>';
					}
					//Ahora muestro el pais
					echo ' - '.$row[0];
					echo '</div></td> </tr>';

					
					//Luego muestro la institucion a la que pertenece
					if ($row[9]) {
						echo '<tr><td bgcolor="#ECECEC" class="style49"><div align="left" class="style43">';
						echo $row[9];
						echo '</div></td> </tr>';						
					}*/


					

					//Luego muestro la institucion a la que pertenece
					if ($row[3]) {
						echo '<tr> <td class="style49" >';
						echo 'Instituci&oacute;n: ';
						if ($row[4]) 
							echo '<a target="_BLANK" href="'.$row[4].'">'.$row[3].'</a>';
						else
							echo $row[3];
						echo '&nbsp;('.$row[0].')';
						echo '</td></tr>';

					}

					echo '<tr><td bgcolor="#ECECEC" class="style49"><div align="left" class="style43">';
				    if ($row[5]) {
		                if ($row[6])
						{
							$temp = ' <a target="_BLANK" href="'.$row[6].'"> '.$row[6].'</a>';
							if ($row[7])
								$temp.=';';	
							echo $temp;
						}

						if ($row[7])
							echo ' <a target="_BLANK" href="'.$row[7].'"> '.$row[7].';</a>';
			            if ($row[8])
							echo ' <a target="_BLANK" href="'.$row[8].'"> '.$row[8].';</a>';
					}
					echo '</div></td></tr>';

					if ($row[9]) {
						echo '<tr><td bgcolor="#ECECEC" class="style49"><div align="left" class="style43">';
						echo $row[9];
						echo '</div></td> </tr>';						
					}


				
					
				}
				//end del while row=...
				//echo '</table>';
				?>
					
                      </table>                      <p>&nbsp;</p></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
		<form name="form1" method="POST">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
            </tr>
            <tr>
              <td bgcolor="#006599" class="style28"><div align="center"><? echo $Mensajes['et-4']; ?>
              <?
                if (isset ($texto)  &&($texto != ''))
                  echo "<a href='javascript:ver_Todos()'><span class='style28'>(".$Mensajes['ec-1'].")</span></a>";
              ?>
              </div></td>
              
            </tr>
            <tr>
              <td align="center" class="style28"><p>
				 <input type="text" name="texto" id="texto" class="style43">
                <br>
                <input type="Button" onClick="Seteo_Modo()" class="style43" value="<? echo $Mensajes['bot-1']; ?>">
                </p>                
                <hr></td>
            </tr>
          </table>
		  </form>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
    <?php
    include_once "../inc/"."barrainferior.php";

    DibujarBarraInferior();

  ?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">bib-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>
<?
  Desconectar();

?>
