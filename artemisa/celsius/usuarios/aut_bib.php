<?
include_once "../inc/var.inc.php";
include_once "../inc/conexion.inc.php";
Conexion();
 include_once "../inc/identif.php";
 Administracion();
  include_once "../inc/"."fgenped.php";
  include_once "../inc/fgentrad.php";
 global  $IdiomaSitio ; 
 $Mensajes = Comienzo ("abi-001",$IdiomaSitio);
 $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>

 <?
 
 if (isset($accion))
  {
      if ($accion == 'autorizar')
        { $query = 'UPDATE Usuarios
                    SET bibliotecario_permite_download = 1
                    WHERE Id = '.$usuario;
         }
       elseif ($accion == 'desautorizar')
        { $query = 'UPDATE Usuarios
                    SET bibliotecario_permite_download = 0
                    WHERE Id = '.$usuario;
         }
       $resu = mysql_query($query);
  }

 ?>

<html>
 <title><? echo $Mensajes['tt-01']; ?> </title>
<head>
<style type="text/css">
<!--
body {
	background-color: #0099CC;
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="../celsius.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style19 {font-size: 11px; color: #FFFFFF; font-family: Verdana;}
-->
</style>
</head>

<body>
<table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
      <center>
	    <?
  $query = 'select Usuarios.Id as Id, Nombres,Apellido, bibliotecario_permite_download as puede, Paises.Nombre as Pais,Instituciones.Nombre as Institucion
            from Usuarios,Paises,Instituciones
            where bibliotecario > 0
                  and Usuarios.Codigo_Pais = Paises.Id
                  and Usuarios.Codigo_Institucion = Instituciones.Codigo';
                  
  $result = mysql_query($query);
  echo  mysql_error();
?>

        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="2" cellspacing="3">
          <tr bgcolor="#E4E4E4">
            <td valign="top" class="style18"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="3" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
              <tr bgcolor="#E4E4E4">
                <td height="20" valign="top" bgcolor="#007CA6" class="style18"><span class="style1"><img src="../images/b1owhite.gif" width="8" height="8"></span> <? echo $Mensajes['tt-02']; ?> </td>
              </tr>
              <tr bgcolor="#E4E4E4">
                <td valign="top"> <span align="center">
                  <center>
                    <span align="center"> </span> <span align="center"> </span> <span align="center"><span align="center"> </span></span> <span align="center"><span align="center"> </span></span>
                   <?  while ($row = mysql_fetch_array($result))
                       {   ?> 
								
					<table width="500" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                      <tr>
                        <td height="20"><div align="center"><span class="style4"> <? echo $Mensajes['tt-10']; ?>:  </span><span class="style17"> <? echo $row['Apellido'].", ".$row['Nombres']; ?>  </span></div></td>
                      </tr>
                      <tr>
                        <td valign="middle" class="style8"><div align="center"><span class="style4"><? echo $Mensajes['tt-03']; ?> : </span> <? echo $row['Pais']; ?> | <span class="style4"><? echo $Mensajes['tt-04']; ?> :</span><? echo $row['Institucion']; ?>  </div></td>
                      </tr>
                       <form name='form1' action='aut_bib.php'>
                       <input type='hidden' name='usuario' value="<? echo $row['Id']; ?>">
                      <?
                      if ($row['puede'])
                       { ?>
                      
					  <tr>
                        <td valign="middle" class="style3"><div align="center" class="style15"><? echo $Mensajes['tt-05']; ?></div></td>
                      </tr>
                      <tr>
                        <td valign="middle" bgcolor="#FFFFFF" class="style8"><div align="center">
                            <input type='submit' style='background-color:e0e1e2;color:gray' value='<? echo $Mensajes['tt-09']; ?>'>
                      <input type='hidden' name='accion' value='<? echo $Mensajes['tt-09']; ?>'>
                        </div></td>
                      </tr>
					  
					 					 	  
					  
					 
                <?
               }
               else
                  { ?>

 <tr>
                        <td valign="middle" class="style3"><div align="center" class="style15"> <? echo $Mensajes['tt-06']; ?> </div></td>
                      </tr>
                      <tr>
                        <td valign="middle" bgcolor="#FFFFFF" class="style8"><div align="center">
                      <input type='submit' style='background-color:e0e1e2;color:gray' value='<? echo $Mensajes['tt-08']; ?>'>
                       <input type='hidden' name='accion' value='<? echo $Mensajes['tt-08']; ?>'>
                        </div></td>
                      </tr>
                     <?
                      }  
                     ?>

          </form>

                 
                    </table>
                    <hr width="500" size="1" class="style4">
    <?
   }
  ?>

                    <span align="center"><span align="center"> </span></span>
                  </center>
                </span> </td>
              </tr>
            </table>              <span align="center">
              <center><span align="center"><span align="center">
</span></span>
              </center>
            </span> </td>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center">
                <table width="150"  border="0" bgcolor="#ececec">
                  <tr>
                    <td height="20"><img src="../images/image001.jpg" width="150" height="118"></td>
                  </tr>
                  <tr>
                    <td height="20"><div align="center"><span class="style6">   <a href='../admin/indexadm.php' > <? echo $Mensajes['tt-07']; ?>   </a></span></div></td>
                  </tr>
                </table>
            </div></td>
          </tr>
        </table>
      </center>
    </span></td>
  </tr>
  <tr>
    <td height="44" bgcolor="#E4E4E4"> <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
                <div align="right" class="style18">
                  <div align="center" class="style7">abi_001</div>
                </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0> </a>
      </center>
    </font> </td>
  </tr>
</table>
</body>

</html>
