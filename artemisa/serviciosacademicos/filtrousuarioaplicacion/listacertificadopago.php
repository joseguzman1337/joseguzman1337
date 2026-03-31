<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../mgi/css/styleOrdenes.css" media="screen" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
        <title>Certificado Log Pagos</title>    
        <style>
            hr{color: #8AB200; border:2px groove;}
            table{border: 2px dotted #8AB200;}
            table, th, td {border: 1px solid #8AB200;} 
            th{background-color: #A7C942; color: #fff;}
            h2{font-family: Arial; font-size: 22px; color: #AFAFAE;}
        </style>
    </head>
    <body>
        <div id="container">    
        <div align="center">
        <h2>Certificado para la orden <?php echo $_POST['ordenpago'] ?></h2>
            <table cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Documento</th>          
                        <th>Nombre</th>
                        <th>Historial de estado</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
            <tbody>  
            <?php
				if(!empty($_POST['ordenpago'])){
					$ordenpago = (!empty($_POST['ordenpago'])) ? $_POST['ordenpago'] : false;
					
					$sQl = 'SELECT
                            	l.fechalogordenpago,
                            	l.observacionlogordenpago,
                            	g.numerodocumento,
                            	g.nombresestudiantegeneral,
                            	g.apellidosestudiantegeneral,
                            	u.usuario
                            FROM
                            	logordenpago l
                            JOIN usuario u ON l.idusuario = u.idusuario
                            JOIN ordenpago o ON l.numeroordenpago = o.numeroordenpago
                            JOIN estudiante e ON o.codigoestudiante = e.codigoestudiante
                            JOIN estudiantegeneral g ON e.idestudiantegeneral = g.idestudiantegeneral
                            WHERE
                            	l.numeroordenpago = '.$ordenpago;
							//echo $sQl;
					if($Consulta=&$db->Execute($sQl)===false){
					   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
					   die;
					}
					$datos =  $Consulta->getarray();
					$totaldatos=count($datos);
					if ($totaldatos>0){
						foreach($datos as $datos1){
						?>
							<tr>
								<td valign="top"><?php echo $datos1['numerodocumento']; ?></td>
								<td valign="top"><?php echo $datos1['nombresestudiantegeneral'].' '.$datos1['apellidosestudiantegeneral']; ?></td>
                                <td valign="top"><?php echo ($datos1['observacionlogordenpago'] == '') ? 'CREADA' : $datos1['observacionlogordenpago']; ?></td>
                                <td valign="top"><?php echo $datos1['fechalogordenpago']; ?></td>
                                <td valign="top"><?php echo $datos1['usuario']; ?></td>
							</tr>
							<?php
						}//foreach
					}//if
				}
				else{
					?>
					<script language="JavaScript" type="text/javascript">
                            alert("Sin datos para consulta, por favor complete los datos");
                    </script><meta http-equiv=refresh content=0;URL=buscarusuariospadre.php>
					<?php
				}
            ?>                     
            </tbody>
        </table>
        <hr />
        <div align="center">
            <h2>Consultar nueva orden</h2>
            <form id="f1" name="f1" action="listacertificadopago.php" method="post" style="padding-top: 20px;">
                <label>N&uacute;mero de Orden:</label>
                <input type="text" class="required number textbox" value="" name="ordenpago"/>
                
                <button type="button" class="myButton" onclick="$('#f1').submit();">Consultar</button>
                <img src="../educacionContinuada/images/ajax-loader2.gif" style="display:none;clear:both;margin-bottom:15px;margin-left: 16.4%;" id="loading"/>
            </form>
        </div>
    </div>
</div>  
<?php    
writeFooter();
?>       
    </body>
    </html>