<?
  include "instalacion.inc";
  $idiomaseleccionado=$HTTP_POST_VARS["idiomaseleccionado"];
  $root_mysql_s=$HTTP_POST_VARS["root_mysql"];
  $root_mysql_contrasena_s=$HTTP_POST_VARS["root_mysql_contrasena"];
  $celsius_login_s=$HTTP_POST_VARS["celsius_login"];
  $celsius_contrasena_s=$HTTP_POST_VARS["celsius_contrasena"];
  $dbbasegeral_s=$HTTP_POST_VARS["dbbasegeral"];

  $include_path_s=$HTTP_POST_VARS["include_path"];
  $ambiente=$HTTP_POST_VARS["ambiente"];
  $raiz_www=$HTTP_POST_VARS["raiz_www"];
  $email_sitio=$HTTP_POST_VARS["email_sitio"];
  $titulo_sitio=$HTTP_POST_VARS["titulo_sitio"];
  $directorio=$HTTP_POST_VARS["directorio"];
  switch($idiomaseleccionado){
  case 1:$filename="archivos/instalaciones5.txt";break;
  case 2:$filename="archivos/instalacionen5.txt";break;
  case 3:$filename="archivos/instalacionpt5.txt";break;
  }
  $fp = fopen($filename, "r");
  $linea=file($filename);
global $fase_g;
  $fase_g=5;

  $sock=ConectarDB($dbbasegeral_s,$celsius_login_s,$celsius_contrasena_s);
   if ($sock==-1)
    Voltar($linea[1]);
//EspalharArquivoAuth($ambiente);
  $sistemaOperativo=PHP_OS;
  $string=strstr($sistemaOperativo,"WIN");
  $last = $directorio[strlen($directorio)-1];

  $archivo = '';
  if ($string != "") //es algun SO Windows
  {  
     if (($last != '\\') && ($last != '/'))
        $archivo = $directorio."\\parametros.inc.php";
     else
		 $archivo = $directorio."parametros.inc.php";
  }
  else { //es UNIX 
     
     if (($last != '\\') && ($last != '/'))
        $archivo = $directorio."/parametros.inc.php";
     else
		 $archivo = $directorio."parametros.inc.php";
  
  }


  $nombre_de_maquina = $_SERVER['SERVER_NAME'];
  
  if ($nombre_de_maquina == "")
    $nombre_de_maquina = $_SERVER['SERVER_ADDR'];

$host="http://".$nombre_de_maquina.$raiz_www."/";

$parametros =  CreaCelsiusConf($archivo,$dbbasegeral_s,$celsius_login_s,$celsius_contrasena_s,$root_mysql_s,$root_mysql_contrasena_s,$root_mysql_s,$root_mysql_contrasena_s,$ambiente,$raiz_www,$email_sitio,$titulo_sitio,$host);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Instalacion de Celsius</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #e4e4e4;
	background-image: url(images/bg4.gif);
}
body,td,th {
	font-family: Tahoma;
	font-size: 9px;
}
.style1 {
	font-size: 12px;
	font-weight: bold;
	color: #006699;
	font-family: Tahoma;
}
.style3 {
	font-size: 11px;
	font-family: Tahoma;
}
.style5 {
	font-size: 9px;
	font-weight: bold;
	color: #006699;
	font-family: Tahoma;
}
.style6 {
	color: #666666;
	font-size: 9px;
	font-family: Tahoma;
}
a:link {
	color: #006699;
	text-decoration: none;
}
a:visited {
	color: #006699;
	text-decoration: none;
}
a:hover {
	color: #0099FF;
	text-decoration: underline;
}
a:active {
	color: #006699;
	text-decoration: none;
}
.style7 {
	color: #000000;
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
}
.style8 {
	color: #006699;
	font-family: Tahoma;
	font-size: 11px;
}
-->
</style></head>
 
 <script language="JavaScript">
tabla_Instituciones = new Array;

tabla_valores = new Array;
tabla_Longitud = new Array;
    <?
         $Instruccion = "SELECT Codigo_Pais,Nombre,Codigo FROM Instituciones ORDER BY Codigo_Pais,Nombre";
         $result = mysql_query($Instruccion);
		
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
     	    if (!isset($Indice[$row[0]]))
	    	   $Indice[$row[0]] = 0;

           	 If (!($Indice[$row[0]]>0))
           	 {
                $Indice[$row[0]]=0;
                echo "\n";
            	  echo "tabla_Instituciones[".$row[0]."]=new Array;\n";
            	  echo "tabla_valores[".$row[0]."]=new Array;\n";
        	     }
           	 echo "tabla_Instituciones[".$row[0]."][".$Indice[$row[0]]."]='".$row[1]."';\n";
               echo "tabla_valores[".$row[0]."][".$Indice[$row[0]]."]=".$row[2].";\n";

               $Indice[$row[0]]+=1;
            }

            echo "//Reflejo las longitudes de los vectores\n";
            while (list($key,$valor)=each($Indice))
            {
          		echo "tabla_Longitud[".$key."]=".$valor.";\n";
            }
         }
    ?>

function Generar_Instituciones (valorpredet){


              Codigo_Pais=document.forms.inst.Pais.options[document.forms.inst.Pais.selectedIndex].value;

                document.forms.inst.Institucion.length =tabla_Longitud[Codigo_Pais];
     			indice = 0;

    			if (document.forms.inst.Institucion.length==0)
    			 {
    			 	document.forms.inst.Institucion.length=1;
    			 	i=0;
    			 }
    			else
    			{
     			 for (i=0;i<tabla_Longitud[Codigo_Pais];i++)
                {
                 document.forms.inst.Institucion.options[i].text=tabla_Instituciones [Codigo_Pais][i];
                 document.forms.inst.Institucion.options[i].value=tabla_valores [Codigo_Pais][i];
                 if (document.forms.inst.Institucion.options[i].value == valorpredet)
                  { indice =i; }
         }

}
// Si el valor predet < 1
// implica que la seleccion en un Change es Otra

			  document.forms.inst.Institucion.selectedIndex=indice;
  		    return null;
}


            function Valida()
      {

        var contrasena_admin=document.forms.inst.contrasena_admin.value;
       // while (contrasena_admin.search(\" \") != -1)
        //  contrasena_admin = contrasena_admin.replace(/ /, \"\");

        var contrasena_conf=document.forms.inst.contrasena_conf.value;
        //while (contrasena_conf.search(\" \") != -1)
          //contrasena_conf =contrasena_conf.replace(/ /, \"\");


      //  while (host.search(\" \") != -1)
        //  host = host.replace(/ /, \"\");

        var apellido_admin=document.forms.inst.apellido_admin.value;
        //while (apellido_admin.search(\" \") != -1)
          //apellido_admin = apellido_admin.replace(/ /, \"\");

        var nombre_admin=document.forms.inst.nombre_admin.value;
        //while (nombre_admin.search(\" \") != -1)
          //nombre_admin = nombre_admin.replace(/ /, \"\");
        var mail_admin=document.forms.inst.mail_admin.value;
        var regras1 = /(@.*@)|(\.{2,})|(@\.)|(\.@)|(^\.)|(\.$)/;
        var regras2 = /^[a-zA-Z0-9\_\-\.]+\@[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})$/;
        if (regras1.test(mail_admin) || !regras2.test(mail_admin))
        {
          alert('email inválido!');
          return(false);
        }
        if (contrasena_admin=='' || contrasena_conf=='' || host=='' || apellido_admin=='' || nombre_admin=='' || mail_admin=='')
        {
          alert('Debe llenar los campos para poder continuar.');
          return false;
        }

        if (document.forms.inst.contrasena_admin.value != document.forms.inst.contrasena_conf.value)
        {
          alert('La contraseñas ingresadas son diferentes.');
          return false;
        }

		

		document.forms.inst.submit();
        return true;
        }

    </script>
 
  
 
 <body>
<? AbrirFormulario();?>
<table width="640" height="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="130"><img src="imagenes/head-celsius.jpg" width="640" height="130"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="90%" height="90%"  border="0" align="center" cellpadding="1" cellspacing="0">
      <tr>
        <td><div align="left">
          <p>&nbsp;</p>
          <blockquote>
            <p><span class="style3"><span class="style5">Instalaci&oacute;n | Fase 4 de 5</span></span></p>
          </blockquote>
        </div>          <div align="center" class="style1">
	  <blockquote>
          <p align="left" class="style7"><? echo "1 -".$linea[2];?></p>
      </blockquote>
     </div>
        
		         <div align="center" class="style1">
	  <blockquote>
          <p align="left" class="style7"><? echo $linea[3];?></p>
      </blockquote>
     </div>
	

		         <div align="center" class="style1">
	  <blockquote>
          <p align="left" class="style7"><? echo $linea[4]." admin ".$linea[5];?></p>
      </blockquote>
     </div>
	

<div align="center" class="style1">
         		  <blockquote>
            <p align="left" class="style7"><? echo $linea[5];?></p>
          </blockquote>

        </div>

            <p align="left" class="style3"> <span class="style8"><? echo $linea[6]."'<font color=red>admin</font>'):";?></span>
            </p>
            <p align="left" class="style3">
              <input name="contrasena_admin" type="password" class="style3">
            </p>
            <p align="left" class="style3"> <span class="style8"><? echo $linea[7];?></span>
            </p>
            <p align="left" class="style3">
              <input name="contrasena_conf" type="password" class="style3">
            </p>
            <p align="left" class="style3"> <span class="style8"><? echo $linea[9].":";?></span>
            </p>
            <p align="left" class="style3">
            <input name="apellido_admin" type="text" class="style3">
            </p>
            <p align="left" class="style3"> <span class="style8"><? echo $linea[10].":";?></span>
            </p>
            <p align="left" class="style3">
              <input name="nombre_admin" type="text" class="style3">
            </p>
			<p align="left" class="style3"> <span class="style8"><? echo $linea[11].":";?></span>                
             </p>
             <p align="left" class="style3">
                <input name="mail_admin" type="text" class="style3">
            </p>
            <p align="left" class="style3"> <span class="style8">Pais Administrador</span>
            </p>
            <p align="left" class="style3">
            <select size="1" name="Pais" onChange="Generar_Instituciones(<? echo $row[1]; ?>)" class="style3">
       <?
           $Instruccion = "SELECT Nombre, Id FROM Paises ORDER BY Paises.Nombre ";
           $result = mysql_query($Instruccion);
           while ($row =mysql_fetch_row($result))
          {

 		 ?>
    	       <option value="<?echo $row[1];?>"><?echo $row[0];?></option>
        <?

 			}
 		?>
       </select>

</p>

     <p align="left" class="style3"> <span class="style8">Institucion del Administrador</span>
      </p>
      <p align="left" class="style3">
        <select size="1" name="Institucion" class="style3" >
       </select>
     </p>


            <p align="center" class="style5">
			<?
   echo "<INPUT TYPE='hidden' name='idiomaseleccionado' value='$idiomaseleccionado'>";
   echo "<INPUT TYPE='hidden' name='celsius_login' value='$celsius_login_s'>";
   echo "<INPUT TYPE='hidden' name='celsius_contrasena' value='$celsius_contrasena_s'>";
   echo "<INPUT TYPE='hidden' name='dbbasegeral' value='$dbbasegeral_s'>";
   echo "<INPUT TYPE='hidden' name='ambiente' value='$ambiente'>";      
   echo "<INPUT TYPE='hidden' name='raiz_www' value='$raiz_www'>";   
   echo "<INPUT TYPE='hidden' name='host' value='$host'>";   
        
  EncerrarPagina($linea[12]);
			?>
			</p> <?
			
			if ($parametros != 0) //no se pudo crear el archivo parametros.inc
			{  echo "<p>";
               switch($idiomaseleccionado){
					case 1:echo "No se ha podido crear el archivo parametros.inc.php (posiblemente por un problema de derechos de usuario). Deberá crearlo usted mismo y colocarlo en el directorio <b>inc</b> dentro de <b>Prebi</b>. El archivo deberá contener el siguiente código:";break;
				    case 2:echo "The file parametros.inc.php could not be created (possibly due to user rights problem). You must create it by yourself y put ir into <b> inc </b> directory, inside <b>prebi</b> directory. This file must have this code:";break;
				    case 3:"No se ha podido crear el archivo parametros.inc.php (posiblemente por un problema de derechos de usuario). Deberá crearlo usted mismo y colocarlo en el directorio <b>inc</b> dentro de <b>Prebi</b>. El archivo deberá contener el siguiente código:";break;
	               }
               echo "<br><textarea>".$parametros."</textarea></p>";
			   }
			?>
          </blockquote>          <p align="center" class="style3"><span class="style6">un producto dise&ntilde;ado integramente por el <a href="http://www.unlp.istec.org/prebi/">PrEBi</a></span></p>
          <p align="center" class="style3"></p></td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td height="15"><img src="imagenes/barra02.jpg" width="640" height="15"></td>
  </tr>
</table>
<p align="center"><img src="imagenes/banner-istec.jpg" width="88" height="31">  <img src="imagenes/banner-prebi.jpg" width="88" height="31"></p>
<script language="JavaScript">
  Generar_Instituciones(0);
</script>
</body>
</html>
