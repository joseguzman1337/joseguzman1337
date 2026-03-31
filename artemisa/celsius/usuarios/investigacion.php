<?

  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."conexion.inc.php";  
  include_once "../inc/var.inc.php";
  Conexion();
  global $IdiomaSitio;
  $Mensajes = Comienzo ("bib-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
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

<body topmargin="0">
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
                <td valign="top" bgcolor="#E4E4E4">
                <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45"><p align="left" class="style54">
                    <span class="style49"><img src="images/square-lb.gif" width="8" height="8">Proyecto de Investigacion </span>
                    <br><br>En PrEBi se ha conformado recientemente un pequeño grupo de investigación que estará dedicado al estudio de diferentes métodos formales para la digitalización de documentos: Topología Digital, técnica basada en el estudio de las propiedades topológicas de las imágenes y que proporciona las bases teóricas para realizar las operaciones para su procesamiento; y la Morfología Matemática, técnica de procesamiento de imágenes (binarias y numéricas) caracterizada por su eficiencia y fácil implementación.
                    <br><br>Se investigarán asimismo técnicas de recuperación de la información contenida en las imágenes procesadas, incluyendo documentos manuscritos, y con altos niveles de ruido. Se aplicarán dos técnicas: Word Spotting, que se basa en la comparación entre imágenes y la agrupación de imágenes de palabras con la misma anotación, construyendo un índice parcial de la colección; y Cross-Media Relevance Modeling, que consiste básicamente en la adición de rótulos a cada imagen, generando un vocabulario de imágenes discreto, y permitiendo búsquedas en un lenguaje natural.
                    <br><br>El marco temático expuesto pretende servir a la digitalización de material bibliográfico y registros manuscritos históricos, el procesamiento de las imágenes en este último caso adquiere especial relevancia a fin de obtener una calidad de las mismas que permita incorporarlas a una base de datos y a un Portal disponible en web para acceso al público. Con nuestro trabajo pretendemos ayudar a la preservación del patrimonio cultural, de muy diversa especie, que se encuentra esparcido en la Provincia de Buenos Aires.
                   </p>
                   </td>
                  </tr>
                 </table>
               <p>&nbsp;</p></td>
              </tr>
              </table>
                </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">

          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
            </tr>
          </table>
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
