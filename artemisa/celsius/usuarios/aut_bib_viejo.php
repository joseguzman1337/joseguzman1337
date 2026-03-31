<head>
<?

 include_once "../inc/conexion.inc.php";
 include_once "../inc/var.inc.php";
 Conexion();
 include_once "../inc/identif.php";
 Administracion();
 echo "<title> Autorizacion de bibliotecarios </title>";
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
 </head>
<body bgcolor='d8d8d8'>
  <a href='../admin/indexadm.php' style='color:000000;font-family:Verdana;font-size:10px;width:40%'> <b> Volver al menu de Administracion  </b> </a>
  <?
  $query = 'select Usuarios.Id as Id, Nombres,Apellido, bibliotecario_permite_download as puede, Paises.Nombre as Pais,Instituciones.Nombre as Institucion
            from Usuarios,Paises,Instituciones
            where bibliotecario > 0
                  and Usuarios.Codigo_Pais = Paises.Id
                  and Usuarios.Codigo_Institucion = Instituciones.Codigo';
                  
  $result = mysql_query($query);
  echo  mysql_error();
  while ($row = mysql_fetch_array($result))
  {   ?>
    <center>
    <div style='background-color:E4E4E4;color:000000;font-family:Verdana;font-size:10px;width:40%'>
          <p style='color:050505'> Usuario: <b> <? echo $row['Apellido'].", ".$row['Nombres']; ?> </b> </p>
          <p style='color:000000'> Pais: <b> <? echo $row['Pais']; ?> </b> -
                                   Institucion: <b> <? echo $row['Institucion']; ?> </b>
          </p>
          <form name='form1' action='aut_bib.php'>
          <input type='hidden' name='usuario' value="<? echo $row['Id']; ?>">
            <?
              if ($row['puede'])
              { ?>
                      <p style='color:red'> <b> Autorizado a bajarse archivos </b>  |
                      <input type='submit' style='background-color:e0e1e2;color:gray' value='Desautorizar'>
                      <input type='hidden' name='accion' value='desautorizar'>

                <?
               }
               else
                  { ?>
                       <p style='color:navy'> <b> No autorizado a bajarse archivos </b>  |
                       <input type='submit' style='background-color:e0e1e2;color:gray' value='Autorizar'>
                       <input type='hidden' name='accion' value='autorizar'>
                     <?
               }

            ?>

          </form>
    </div>
    </center>
    <br>
    <?
   }
  ?>
</body>

