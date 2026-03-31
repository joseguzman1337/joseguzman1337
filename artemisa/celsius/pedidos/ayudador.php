<script type="text/javascript" src="help_window.js"></script>
<?
   $expresion = "SELECT Tipo_Material,Numero_Campo,Heading,Texto_Ayuda FROM Campos ";
   $expresion =  $expresion."WHERE Codigo_Idioma=".$IdiomaSitio;

   $result = mysql_query($expresion);
   echo mysql_error();
 ?>
 <script>
     var titulos = new Array(6);
     var i;
     var textos = new Array(6);
     for(i=0;i<=5;i++)
     {
       titulos[i] = new Array(200);
       textos[i] = new Array(200);
      }
     titulos[0][1] = 'hola';



 <?
   while ($row = mysql_fetch_array($result))
   {
      echo "
            titulos[".$row['Tipo_Material']."][".$row['Numero_Campo']."] = '".$row['Heading']."';
            textos[".$row['Tipo_Material']."][".$row['Numero_Campo']."] = '".$row['Texto_Ayuda']."'; \n ";

    }
   
?>



 </script>
