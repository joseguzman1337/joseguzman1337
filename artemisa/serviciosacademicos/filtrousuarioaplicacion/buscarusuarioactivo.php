<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    /*if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }*/
$db = getBD();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <title>Busqueda Usuarios activos</title>
        
        <link rel="stylesheet" href="../mgi/css/normalize.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.fastLiveFilter.js"></script>
        <style>
			#opcion{
				border-color: #ccc;
				border-style: solid;
				border-width: 1px;
				box-sizing: border-box;
				display: block;
				width: 80%;
				font-size: 0.9em;
				line-height: 1.1em;
				margin-bottom: 20px;
				margin-left: 15px;
				padding: 3px;
				vertical-align: middle;
			}
			table{
				border:1px solid #003333;
			}
			table tr.Estilo2{
				border:1px solid #003333;
			}
		
			input[type="submit"] {
				margin-bottom:5px;
			}
		</style>
    </head>
    <script   language="javascript">
    function cambia_tipo()
    {
        //tomo el valor del select del tipo elegido
        var tipo;
        tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value;
        //miro a ver si el tipo estï¿½ definido
        if (tipo>0 && tipo<5)
        {
            window.location.href="../filtrousuarioaplicacion/buscarusuarioactivo.php?busqueda="+tipo;
        }
    }
    function buscar()
    {
        
        //tomo el valor del select del tipo elegido
        var busca;
        busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value;
        //miro a ver si el tipo estï¿½ definido
        if (busca != 0)
        {
            window.location.href="../filtrousuarioaplicacion/listausuariosactivos.php?"+busca;
        }
    }
    </script>
    
    <body>
        <div align="center">
            <form name="f1" id="form_test" action="../filtrousuarioaplicacion/listausuariosactivos.php" method="get">
                <p class="Estilo3"></p>
                <table width="707"  cellpadding="2" cellspacing="1">
                    <tr class="Estilo2">
                        <td width="199" bgcolor="#C5D5D6" class="Estilo2" align="center">
                            B&uacute;squeda por: 
                            <select name="tipo" onChange="cambia_tipo()">
                                <option value="0">Seleccionar</option>
                                <option value="1">Usuario</option>
                                <option value="2">Docente</option>
                                <option value="3">Administrador</option>
                                <option value="4">Permiso</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="Estilo2">&nbsp;
                         <?php
                            if(isset($_GET['busqueda']))
                            {
                               if($_GET['busqueda']=="3")
                                {
                                    $sqladmin='select DISTINCT ur.idrol from rol r, usuariorol ur where r.idrol = 3';
                                    $valoresadmin = &$db->execute($sqladmin);
                                    $datosadmin = $valoresadmin->getarray();
                                    ?>
                                    <center><strong>Seleccione el rol del codigo administrativo</strong><br /></center>
                                    <br />
                                    <?php
                                    foreach($valoresadmin as $rol)
                                    {
                                    ?>
                                        <input type="checkbox" name="busqueda[]" value="<?php echo $rol['idrol']?>"><?php echo $rol['idrol']?> &nbsp;
                                    <?php
                                    }
                                                                 
                                   // $sqladmin2 ="SELECT count(ur.idrol) FROM rol r, usuariorol ur, usuario u WHERE r.idrol = 3 and u.usuario = ur.usuario and fechavencimientousuario > NOW()"; 
                                   
                                   $sqladmin2 ="SELECT count(ur.idrol) FROM rol r, usuariorol ur, UsuarioTipo ut, usuario u WHERE r.idrol = 3 AND ur.idrol = r.idrol AND ur.idusuariotipo = ut.UsuarioTipoId AND ut.UsuarioId = u.idusuario AND u.fechavencimientousuario > NOW()";
                                    $valoresadmin2 = &$db->execute($sqladmin2);
                                    $datosadmin2 = $valoresadmin2->getarray(); 
             
                                    ?>
                            <div align="center"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          <strong>Preconsulta: Cantidad total de usuarios <?php echo $datosadmin2[0][0]?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1">
                            <input type="submit" value="Buscar">&nbsp;
                        </td>
                    </tr>
                    <?php
                            }else if($_GET['busqueda']=="1")
                              {
                           ?>
                    <tr>        
                        <td colspan="4" align="center" class="Estilo1"> 
                        
                        <form name="f2" action="../filtrousuarioaplicacion/listausuariosactivos.php" method="get">
                            <p><strong>Usuario</strong></p>
                            <input type="text" name="usuario" id="usuario" />
                        <br />
                        <br />
                        <input type="hidden" name="idrol" value="1" />
                        <input type="submit" value="Buscar">&nbsp;
                        </form>
                        </td>
                      </tr>                                            
                             <?php
                              }else if($_GET['busqueda']=="2")
                                {
                                    $sql_docentes = "SELECT COUNT(u.usuario) FROM usuario u WHERE u.codigorol = '2'	AND u.codigoestadousuario = 100 AND u.fechavencimientousuario > NOW() ";
                                    $valores = &$db->execute($sql_docentes);
                                    $datos_docentes = $valores->getarray();
                                    
                                    ?>
                    <tr>
                        <td>
                            <strong>Preconsulta: Cantidad total de usuarios docente <?php echo $datos_docentes[0][0]?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1">
                            <form name="f" action="../filtrousuarioaplicacion/listausuariosactivos.php" method="get">
                                <input type="hidden" name="idrol" value="2" />
                                <input type="submit" value="Buscar">&nbsp;
                            </form>
                        </td>
                    </tr>
                    <?php        
                                } else if($_GET['busqueda']=="4")
                              {
                           ?>
                    <tr>        
                        <td colspan="4" align="center" class="Estilo1"> 
                        
                        <form name="f2" action="../filtrousuarioaplicacion/listausuariosactivos.php" method="get">
                            <p><strong>Menú opción</strong></p>
                            <input type="text" name="opcion" id="opcion" />
                        <input type="hidden" name="idmenuopcion" id="idmenuopcion" value="" />
                        <input type="submit" value="Buscar">&nbsp;
                        </form>
                        </td>
                      </tr>                                            
                             <?php
                              }
                         }    // busqueda     
                ?>
                </table>
            </form>
        </div>
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				$('#opcion').autocomplete({
					source: function( request, response ) {
						$.ajax({
							url: "../utilidades/searches/lookForOpcionesMenu.php",
							dataType: "json",
							data: {
								term: request.term
							},
							success: function( data ) {
								response( $.map( data, function( item ) {
									return {
										label: item.label,
										value: item.value,
										id: item.id
									}
								}));
							}
						});
					},
					minLength: 2,
					selectFirst: false,
					open: function(event, ui) {
						var maxWidth = $('#form_test').width()-200;  
						var width = $(this).autocomplete("widget").width();
						if(width>maxWidth){
							$(".ui-autocomplete.ui-menu").width(maxWidth);                                 
						}
						
					},
					select: function( event, ui ) {
						//alert(ui.item.id);
						$('#idmenuopcion').val(ui.item.id);
						
					}                
				});
			});
			
			$('#opcion').change(function(){
				if(document.getElementById('opcion').value==''){
					document.getElementById('idmenuopcion').value='';
					
				}
			});
		</script>
    </body>
</html>