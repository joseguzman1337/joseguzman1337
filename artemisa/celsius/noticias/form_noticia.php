<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();	
  include_once "../inc/"."identif.php"; 
  Administracion();
   
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
.style35 {color: #CCCCCC}
.style36 {color: #666666}
.style37 {font-size: 11px; font-family: verdana;}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
	function enviar_campos()
	{
		document.forms.form1.NombreIdioma.value=document.forms.form1.Codigo_Idioma.options[document.forms.form1.Codigo_Idioma.selectedIndex].text;
		return null;
	}
</script>

<body topmargin="0">
<?
  	include_once "../inc/"."fgenped.php";
	include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fno-001",$IdiomaSitio);
   if ($operacion==1)
  {
  	$Instruccion = "SELECT Fecha,Titulo,Texto_Noticia,Codigo_Idioma FROM Noticias WHERE Id=".$Id;
  	$result = mysql_query($Instruccion);
  	$row = mysql_fetch_row($result);
  }
?>  	

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
            <form method="POST" name="form1" action="upd_noticia.php"  onSubmit="enviar_campos()">
	  <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                              <div align="left">
                                <select size="1" class="style22" name="Dia">
     		<option selected value="
     		<? 
     		  if ($operacion==1)
     		  {     	  	  
     		  	  echo substr($row[0],8,2);
     		  }
     		  else
     		  {     		       		  	
 	     		  echo date("d");
 	     	  }       		  
     		 ?> ">
     		 <?
     		   if ($operacion==1)
     		   {     		        		  	 
     		    echo substr($row[0],8,2);
     		   }
     		   else
     		   { 
     		    echo date("d");
     		   }
     		  ?>
     		 </option>        
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
          <option>6</option>
          <option>7</option>
          <option>8</option>
          <option>9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option>13</option>
          <option>14</option>
          <option>15</option>
          <option>16</option>
          <option>17</option>
          <option>18</option>
          <option>19</option>
          <option>20</option>
          <option>21</option>
          <option>22</option>
          <option>23</option>
          <option>24</option>
          <option>25</option>
          <option>26</option>
          <option>27</option>
          <option>28</option>
          <option>29</option>
          <option>30</option>
          <option>31</option>
        </select> / <select  class="style22" size="1" name="Mes">
          <option selected value="<?
          if ($operacion==1)
          {
  		  	  echo substr($row[0],5,2);
          }
          else
          {          
           echo date("m");
           }
           ?>">
           <? 
           if ($operacion==1)
           {
   		  	  echo substr($row[0],5,2);
           }
           else
           {	
           	echo date("m");
           }	
           ?>
           </option>        
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
          <option>6</option>
          <option>7</option>
          <option>8</option>
          <option>9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
        </select> / 
        <input  class="style22" type="text" name="Anio" size="9" value="<?
        if ($operacion==1)
        {
        	echo substr($row[0],0,4);
        }
        else
        {
         echo date("Y");
        } 
         ?>">
                              </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                             <input type="text" name="Titulo" class="style22" size="41" value="<? if (isset($row)) { echo $row[1];} ?>">
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["ec-4"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                              <select size="1" name="Codigo_Idioma" class="style22">
       <?
          $Instruccion = "SELECT Id,Nombre,Predeterminado FROM Idiomas ORDER BY Nombre";	
          $result = mysql_query($Instruccion); 
          
          while ($rowx =mysql_fetch_row($result))
          { 
          	   $cadena="<option value=";
				$cadena2=" selected";
				$signo=">";
				$cadena3="</option>";
				
				 if ($rowx[0]==$row[3] || ($operacion!=1 && $rowx[2]==1)) 
				 { 
				    echo $cadena.$rowx[0].$cadena2.$signo.$rowx[1].$cadena3; 
				    
      			 } else {	
             
          		    echo $cadena.$rowx[0].$signo.$rowx[1].$cadena3; 

                }  
              } ?> 	       
       </SELECT>
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["ec-3"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                              <textarea rows="7" name="Texto" cols="35" class="style22"><? if (isset($row)) {echo $row[2];} ?> </textarea>
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20"><div align="right"></div></td>
                          <td height="20"><div align="left">
                              <input  class="style22" type="submit" value="<? if ($operacion==1) { echo $Mensajes["bot-1"]; } else { echo $Mensajes["bot-2"]; } ?>" name="B1">
                              <b><input class="style22" type="reset" value="<? echo $Mensajes["bot-3"]; ?>" name="B2">
                          </div></td>
                        </tr>
                      </table>
                    </div>                      </td>
                    </tr>
                </table>
                </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-3"];?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
		<? 
		if (!isset($operacion)) {$operacion = 0;}
		if (!isset($Id)) {$Id = 0;}
		?>
  <input type="hidden" name="operacion" value=<? echo $operacion; ?>>
  	  <input type="hidden" name="Id" value=<? echo $Id; ?>>
  	  <input type="hidden" name="NombreIdioma">	  	  
      </form>
	</table>    </center>
      </div>    </td>
  </tr>
  
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">fno-001</div>
          </div></td>
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