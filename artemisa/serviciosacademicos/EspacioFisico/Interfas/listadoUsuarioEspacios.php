<?php

    include("template.php");
	$db=writeHeader("Listado Usuarios",true);
	
	  $SQL='SELECT
            	p.PermisoEspacioFisicoId,
            	p.ModulosEspacioFisicoId,
            	p.RolEspacioFisicoId,
            	p.Usuarioid,
            	r.Nombre AS ROL,
            	m.Nombre AS MODULO,
            	u.nombres AS NOMBRE,
            	u.apellidos AS APELLIDOS,
            	u.usuario AS USUARIO,
                u.numerodocumento  AS DOCUMENTO,
                IF (sf.emailusuariofacultad = "", f.emailusuariofacultad,sf.emailusuariofacultad) AS EMAIL,
                x.codigofacultad,
                IF (x.codigofacultad = 10,c.nombrecarrera,x.nombrefacultad) AS nameFacultadCarrera
                
            FROM
            	PermisoEspacioFisico p
            INNER JOIN RolEspacioFisico r ON r.RolEspacioFisicoId = p.RolEspacioFisicoId
            INNER JOIN ModulosEspacioFisico m ON m.ModulosEspacioFisicoId = p.ModulosEspacioFisicoId
            INNER JOIN usuario u ON u.idusuario = p.Usuarioid
            INNER JOIN usuariofacultad sf ON sf.usuario = u.usuario
            INNER JOIN carrera c ON c.codigocarrera = sf.codigofacultad
            INNER JOIN facultad x ON x.codigofacultad = c.codigofacultad
            LEFT JOIN usuariofacultad f ON f.usuario = u.usuario
            AND f.emailusuariofacultad <> " "
            AND f.emailusuariofacultad IS NOT NULL
            
            WHERE
                    	p.CodigoEstado = 100
                    AND r.CodigoEstado = 100
                    AND m.CodigoEstado = 100
            GROUP BY
            	p.PermisoEspacioFisicoId'; 
                    
              if($Data=&$db->Execute($SQL)===false){
                echo 'Error en el SQL Data Solicitudes....<br><br>'.$SQL;
                die;
              }
			  $Resultado = $Data->GetArray(); 

			  
		?>
		
      
<link type="text/css" rel="stylesheet" href="jquery.dataTables.css" />
<script type="text/javascript" language="javascript" src="jquery-3.6.0.min.js"></script>
<script type="text/javascript" language="javascript" src="jquery.dataTables.min.js"></script>  
<div id="container" style="width:100%">
            <h2>Listado Usuarios</h2>
            <div class="demo_jui">                
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
							<th>#</th>						
                            <th>Documento</th> 
							<th>Nombre</th>                                
							<th>Apellido</th>
                            <th>Usuario</th>     
                            <th>Rol</th>       
                            <th>Modulo</th>                                   
							<th>Correo</th>
                            <th>Facultad ó Programa</th>  
							<!--<th>Estado</th>--> 
                        </tr>
                    </thead>
                     <tbody> 
                        <?PHP 
                        $num = count($Resultado);                     
                        for($i=0;$i<count($Resultado);$i++){ 
                            $id = $Resultado[$i]['SolicitudAsignacionEspacioId']
                          //  print_r ($Resultado[$i]['SolicitudAsignacionEspacioId']);
                            ?>
                            <tr >       
                                <td><?PHP echo $i+1?></td>                                
								<td><?PHP echo $Resultado[$i]['DOCUMENTO']?></td>
                                <td><?PHP echo $Resultado[$i]['NOMBRE']?></td>                              
								<td><?PHP echo $Resultado[$i]['APELLIDOS']?></td>
                                <td><?PHP echo $Resultado[$i]['USUARIO']?></td>
                                 <td><?PHP echo $Resultado[$i]['ROL']?></td>
                                <td><?PHP echo $Resultado[$i]['MODULO']?></td>
								<td><?PHP echo $Resultado[$i]['EMAIL']?></td>
                                <td><?PHP echo $Resultado[$i]['nameFacultadCarrera']?></td>
								<!--<td><?PHP //echo $Resultado[$i]['ESTADO']?></td>-->
                            </tr>
                            <?PHP
                            /*****************************************************/
                        }//for
                        ?>                      
                        </tbody>
                </table>
            </div>
        </div>
<div>
                        <table>
                            <tr>
                                <td>
                                    <!--<img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" onclick="ExportarExcel();" title="Exportar a Excel" />-->
									<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
									<p>Exportar a Excel  <img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" class="botonExcel" /></p>
									<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
									</form>
                                </td>
                            </tr>
                        </table>
                    </div>		
<script type="text/javascript">
      $(function() {
	    oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
					"sLengthMenu": "Mostrando _MENU_ registros por P&aacute;gina",
					"sInfo": "Mostrando _PAGE_ of _PAGES_ P&aacute;ginas",
					"sLoadingRecords": "Espere un momento, cargando...",
					"sSearch": "Buscar:",
					"sZeroRecords": "No hay datos con esa busqueda",
                },
               
            });
			   $(".botonExcel").click(function(event) {
     $("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
     $("#FormularioExportacion").submit();
});
});
 

</script>
    
  
<?php    writeFooter();
        ?>       


