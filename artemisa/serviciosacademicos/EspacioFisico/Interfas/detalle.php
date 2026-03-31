<?php

    include("template.php");
    $db = writeHeader("Ver Detalle Noticia",TRUE);

    include("./menuNoticias.php");
    writeMenuNoticia(0);
    
    $data = array();
   
    if(isset($_REQUEST["id"])){  
       $id = str_replace('row_','',$_REQUEST["id"]);
	   $data =$db->GetRow("SELECT n.*,u.usuario,CONCAT(u.nombres,' ',u.apellidos) as nombre,e.NombreEstado FROM NoticiaEvento n 
	   LEFT JOIN usuario u on u.idusuario=n.UsuarioCreacionId 
	   INNER JOIN EstadoPublicacion e ON e.EstadoPublicacionId=n.AprobadoPublicacion 
	   WHERE n.NoticiaEventoId=".$id);
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Noticia</h2>
            <table class="detalle">
                <tr>
                    <th>Código:</th>
                    <td><?php echo $data['NoticiaEventoId']; ?></td>
                    <th>Titulo:</th>
                    <td><?php echo $data['TituloNoticia']; ?></td>
                </tr>
                <tr>
                    <th>Descripción:</th>
                    <td><?php echo $data['DescripcionNoticia']; ?></td>
                    <th>Estado:</th>
                    <td><?php echo $data['NombreEstado']; ?></td>
                </tr>
                <tr>
                    <th>Fecha de Inicio de Vigencia:</th>
                    <td><?php echo $data['FechaInicioVigencia']; ?></td>
                    <th>Fecha Final de Vigencia:</th>
                    <td><?php echo $data['FechaFinalVigencia']; ?></td>
                </tr>
                <tr>
                    <th>Usuario creación:</th>
                    <td><?php echo $data['usuario']; ?></td>
                    <th>Nombre usuario:</th>
                    <td><?php echo $data['nombre']; ?></td>
                </tr>
            </table>
        </div>

<?php  

 writeFooter(); ?>