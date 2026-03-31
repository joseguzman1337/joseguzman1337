<?
include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  include_once "../inc/"."parametros.inc.php";    
  Conexion();
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("dds",$IdiomaSitio);
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {font-family: Verdana; color: #FFFFFF;}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style47 {font-size: 11px}
.style48 {color: #006599}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style51 {font-family: verdana; color: #000000; }
.style52 {color: #000000}
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style56 {font-family: Verdana}
.style57 {font-size: 10px}
.style58 {color: #006699}
-->
</style>
<base target="_self">
</head>

<body top-margin=0>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <a name="top"></a>      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">

            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                
<a name="top">
                    <tr bgcolor="#cccccc">
                        <td width="14" height="20" class="style45"><div align="left"></div></td>
                           <td width="547" class="style45 style52"><div align="left">
                           <a name="link1"> </a>
                           Otros serivicios <br>
                           </div></td>
                           <td width="15" class="style45">&nbsp;</td>
                           </tr>
                           <tr>
                           <td colspan="3"> <div align="left">

	                          <blockquote class="style43">
   	                         PrEBi oferta diferentes servicios de orden tecnológico.<br><br>
                              <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46">
                               Preservación Digital del Patrimonio cultural
                              </span></strong><br>
                              PrEBi cuenta con personal y tecnología apropiada para implementar servicios de preservación tecnológica de obras documentales que representen parte del patrimonio cultural, social o académico local o nacional. El servicio consta de digitalización del material (con los cuidados que el mismo amerita para asegurar sus condiciones de preservación), catalogación bibliográfica de acuerdo a normativas internacionales que maximicen la difusión y el valor de la información descriptiva del documento, y diseño del software para habilitar el acceso al material de acuerdo a las condiciones de acceso público o restringido que la institución dueña del material proponga.<br><br>

                              Siendo que el procesamiento de material manuscrito para posibilitar su búsqueda a través de tecnologías informáticas es parte de las temáticas de <a href="investigacion.php">Investigación Académica</a> del personal de PrEBi-UNNOBA es que consideramos esta área como una de nuestras mayores especializaciones.<br><br>

                              Para mayor información acerca de este servicio, dirigir un correo a: <a href="mailto:spd@unnoba.prebi.unlp.edu.ar">spd@unnoba.prebi.unlp.edu.ar</a><br>

                              <a href="#top"><span class="style58">^</span></a>
                              <br><br>
                               <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46">Biblioteca Digital Especializada.</span></strong><br>
                              Gracias al enorme expertise logrado en dicha experiencia es que PrEBi-UNNOBA se halla en condiciones de brindar servicios relacionados con la construcción de Bibliotecas Digitales Especializadas en ámbitos gubernamentales o empresariales, dicho servicio consta de la entrega "llave en mano" de plataformas de software para el ingreso, catalogación, medios de acceso y búsqueda para grandes volúmenes de información ya residente en formato digital. 
							  <br><br>

							  Algunos de los casos de aplicación serían:
							  <ul> 
							    <li> Legislación. Administración y procesamiento de ordenanzas, acuerdos, disposiciones u otros objetos documentales simples o complejos a efectos de ser disponibilizados/consultados publicamente a través de la web
								<li> Archivos. Plataformas para la informatización de archivos de acuerdo a normativas internacionales de gestión y de almacenamiento de información. Reconocimiento óptico de caracteres, disponibilización de motores de búsqueda sobre texto completo del objeto documental
								<li> Knowledge Management. Administración de bases de conocimiento, en el caso empresarial aplicable por ejemplo a la documentación de atención al público, accesible por una matríz empleado / clasificación de la gestión. Formulación de Manuales de procedimiento automatizados de acuerdo a normas ISO.
							  </ul>	
							  <br>
							  Para mayor información acerca de este servicio, dirigir un correo a: 
							  <a href="mailto:bdigital@unnoba.prebi.unlp.edu.ar"> bdigital@unnoba.prebi.unlp.edu.ar</a>
							 <br><a href="#top"><span class="style58">^</span></a>
                             <br><br>
                              <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46">Consultoría y Capacitación.</span></strong><br>
                              PrEBi-UNNOBA se halla en condiciones de brindar cursos y consultorías en temáticas relacionadas con Referencia Electrónica de Documentos, Acceso a Recursos Digitales, Formatos Bibliográficos y software para Gestión de Bibliotecas y centros de documentación, construcción de Bibliotecas Digitales tanto como para la selección de plataformas y arquitecturas para gestión de grandes volúmenes de textos.
							  <br><br>

                              Para mayor información acerca de este servicio, dirigir un correo a: <a href="mailto:consul@unnoba.prebi.unlp.edu.ar">consul@unnoba.prebi.unlp.edu.ar</a>

                              <br><a href="#top"><span class="style58">^</span></a><br>
                          </blockquote>

                            </div>
                          </td>

                          </tr>
                      
                      
                      

          </table>
          </div>
          </td>
          

        </tr>
    </table>    </center>
      </div>    </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
            <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
            </tr>
          </table>
          </div>
          </td>

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
          <td width="50" class="style49"><div align="center" class="style11">dds</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>




</body>


</html>

 
