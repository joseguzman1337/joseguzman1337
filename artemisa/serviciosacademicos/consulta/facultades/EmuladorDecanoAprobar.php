<?php
session_start();

if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }
 
include_once("../../EspacioFisico/templates/template.php");

//$_SESSION['MM_Username'] = 'Manejo Sistema';

$db = writeHeader('Emulador',true);


           $SQL='SELECT s.id
						,g.nombregrupo
						,c.numerocorte
						,m.nombremateria
						,ca.nombrecarrera
						,eg.numerodocumento
						,eg.apellidosestudiantegeneral
						,eg.nombresestudiantegeneral
						,s.notaanterior
						,s.notamodificada
						,s.numerofallasteoriaanterior
						,s.numerofallasteoriamodificada
						,s.numerofallaspracticaanterior
						,s.numerofallaspracticamodificada
						,s.fechasolicitud
						,u.usuario
						,concat(apellidos," ",nombres) as solicitante
					from solicitudaprobacionmodificacionnotas s
					left join grupo g on s.idgrupo=g.idgrupo
					left join corte c on s.idcorte=c.idcorte
					join materia m on s.codigomateria=m.codigomateria
					join carrera ca on m.codigocarrera=ca.codigocarrera
					join estudiante e on s.codigoestudiante=e.codigoestudiante
					join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
					join usuario u on s.idsolicitante=u.idusuario
					where codigoestadosolicitud=10
					AND ca.codigocarrera IN (
						SELECT codigocarrera FROM carrera where codigomodalidadacademica=300 /*and codigofacultad=112*/ and fechavencimientocarrera>NOW() ORDER BY nombrecarrera
					)  	
					order by id ASC';
                    
           if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de La data Principal...<br><br>'.$SQL;
            die;
           } 
           
           $Op = 1;
           $accion = 'aprobar';
           
           if(!$Data->EOF){
            while(!$Data->EOF){
                
                $id = $Data->fields['id'];
                ?>
                <script>
                    $.ajax({//Ajax
                		   type: 'POST',
                		   url: 'aprobacionrechazogestionnotas.php',
                		   async: false,
                		   dataType: 'html',
                		   data:({accion:'aprobar',op:1,id:<?PHP echo $id?>}),
                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                		   success: function(data){
                				
                		   } 
                	}); //AJAX
                </script>
                <?PHP
                
                $Data->MoveNext();
            }
           }        

?>