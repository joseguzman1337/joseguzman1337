<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }

include_once ('../EspacioFisico/templates/template.php');
$db = getBD();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <title>Busqueda Items financieros</title>
    </head>
    <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>   
    <script   language="javascript">
        function cambia_tipo()
        {
            //tomo el valor del select del tipo elegido
            var tipo
            tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
            //miro a ver si el tipo estï¿½ definido
            if (tipo == 1)
            {
                window.location.href="../filtrousuarioaplicacion/consultaitemsfinacieroscarrera.php?busqueda=codigo_carrera";
            }
            if (tipo == 2)
            {
                window.location.href="../filtrousuarioaplicacion/consultaitemsfinacieroscarrera.php?busqueda=nombre_carrera";
            }
        }
        function buscar()
        {
            //tomo el valor del select del tipo elegido
            var busca
            busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
            //miro a ver si el tipo estï¿½ definido
            if (busca != 0)
            {
                window.location.href="../filtrousuarioaplicacion/consultaitemsfinacieroscarrera.php?buscar="+busca;
            }
        }
    </script>
    <script>
    $(function() {
        $( "#tabs" ).tabs();
    });
    </script>
    <body>
        <div align="center">
            <form name="f1" action="../filtrousuarioaplicacion/consultaitemsfinacieroscarrera.php" method="get">
                <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
                <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr>
                        <td width="199" bgcolor="#C5D5D6" class="Estilo2"align="center">
                            B&uacute;squeda por: 
                            <select name="tipo" onChange="cambia_tipo()">
                                <option value="0">Seleccionar</option>
                                <option value="1">Codigo carrera</option>
                                <option value="2">Nombre carrera</option>
                            </select>
                        </td>
                        <td class="Estilo2">&nbsp;
                        <?php
                            if(isset($_GET['busqueda']))
                            {
                                if($_GET['busqueda']=="codigo_carrera")
                                {
                                    echo "<strong>Digite Codigo de la carrera: </strong><input name='busqueda_codigo_carrera' type='text'>";
                                }
                                elseif($_GET['busqueda']=="nombre_carrera")
                                {
                                    echo "<strong>Digite nombre de la carrera: </strong><input name='busqueda_nombre_carrera' type='text'>";
                                }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1">
                            <input name="buscar" type="submit" value="Buscar">&nbsp;
                        </td>
                    </tr>
                    <?php
                    }
                        if(isset($_GET['buscar']))
                    {
                    ?>
                </table>
                <div id="tabs">
                    <ul>
                        <li><a href="#tab-1">Items finacieros</a></li>
                        <li><a href="#tab-2">Ordenes internas</a></li>
                    </ul>
                    <div id="tab-1" >
                        <table width="1100" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" >
                            <tr class="Estilo2">
                                <td align="center" bgcolor="#C5D5D6">Numero</td>
                                <td align="center" bgcolor="#C5D5D6">Codigo Carrera</td>
                                <td align="center" bgcolor="#C5D5D6">Nombre Carrera</td>
                                <td align="center" bgcolor="#C5D5D6">Codigo centro beneficio</td> 
                                <td align="center" bgcolor="#C5D5D6">item carrera concepto peolple</td>
                                <td align="center" bgcolor="#C5D5D6">Nombre carrera concepto people</td>
                                <td align="center" bgcolor="#C5D5D6">Tipo cuenta</td>
                                <td align="center" bgcolor="#C5D5D6">codigoconcepto</td>
                                <td align="center" bgcolor="#C5D5D6">Estado</td>
                            </tr>
                            <?php
                                $vacio = false;
                                if(isset($_GET['busqueda_codigo_carrera']))
                                {   
                                    $codigo = $_GET['busqueda_codigo_carrera'];
                                    $sql1= "SELECT 	c.codigocarrera, c.nombrecarrera, 	c.codigocentrobeneficio,	ccp.itemcarreraconceptopeople,	ccp.nombrecarreraconceptopeople,	ccp.tipocuenta,	ccp.codigoconcepto,	
                                    e.nombreestado FROM carrera c,	carreraconceptopeople ccp,	estado e WHERE ccp.codigocarrera = c.codigocarrera AND ccp.codigoestado = e.codigoestado AND c.codigocarrera = '$codigo' ";
                                    $valoresCarrera =&$db->Execute($sql1);
                                    $datos =  $valoresCarrera->getarray();
                                    if(empty($datos))
                                    {
                                        $sql11= "SELECT c.codigocarrera, c.nombrecarrera, c.codigocentrobeneficio FROM carrera c WHERE  c.codigocarrera = '$codigo'";
                                        $valores_carrera = &$db->execute($sql11);
                                        $datos = $valores_carrera->getarray();
                                        
                                        if(empty($datos)){
                                            $datos[] = array(codigocarrera=> $codigo, nombrecarrera => 'no existe'); 
                                        }
                                    }
                                }
                                if(isset($_GET['busqueda_nombre_carrera']))
                                {
                                    $nombre = $_GET['busqueda_nombre_carrera'];
                                    $sql2 = "SELECT	c.codigocarrera, c.nombrecarrera, 	c.codigocentrobeneficio, ccp.itemcarreraconceptopeople,	ccp.nombrecarreraconceptopeople,	ccp.tipocuenta,	ccp.codigoconcepto,	e.nombreestado
                                                FROM     carrera c,	carreraconceptopeople ccp,	estado e WHERE ccp.codigocarrera = c.codigocarrera AND ccp.codigoestado = e.codigoestado AND c.nombrecarrera like '%$nombre%' ";
                                    $valores =&$db->Execute($sql2);
                                    $datos =  $valores->getarray();
                                    if(empty($datos))
                                    {
                                        $sql21= "SELECT c.codigocarrera, c.nombrecarrera, c.codigocentrobeneficio, FROM carrera c WHERE  c.nombrecarrera like '%$nombre%'";
                                        $valores_carrera = &$db->execute($sql21);
                                        $datos = $valores_carrera->getarray();
                                        if(empty($datos)){
                                            $datos[] = array(codigocarrera => 'no existe', nombrecarrera=> $nombre); 
                                        }
                                    }
                                }
                                $i =1;
                                foreach($datos as $valor)
                                { 
                                    ?>
                                    <tr>
                                        <td class='Estilo1' align='center'><?php echo $i ?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["codigocarrera"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["nombrecarrera"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["codigocentrobeneficio"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["itemcarreraconceptopeople"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["nombrecarreraconceptopeople"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["tipocuenta"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["codigoconcepto"]?>&nbsp;</td>
                                        <td class='Estilo1' align='center'><?php echo $valor["nombreestado"]?>&nbsp;</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-2">
                        <table border=1 >
                        <tr class="Estilo2">
                                <td align="center" bgcolor="#C5D5D6">idgrupo</td>
                                <td align="center" bgcolor="#C5D5D6">Codigo grupo</td>
                                <td align="center" bgcolor="#C5D5D6">Numero orden interna</td>
                                <td align="center" bgcolor="#C5D5D6">Fecha orden interna</td>
                                <td align="center" bgcolor="#C5D5D6">Fecha vencimiento orden interna</td>
                                <td align="center" bgcolor="#C5D5D6">Codigo periodo</td>
                            </tr>
                            <?php
                                $fechaActual = $_SESSION['codigoperiodosesion'];
                                //$fechaActual = '20142';
                                $anio = substr($fechaActual, 0, -1); 
                                $periodo = substr($fechaActual, 4);
                                
                                if($periodo == 2)
                                {
                                    $periodo--;
                                    $FechaPeriodoAnterior = $anio.$periodo;
                                    $anio++;
                                    $FechaPeriodoSiguiente =$anio.$periodo; 
                                } 
                                else
                                {
                                    if($periodo == 1)
                                    {
                                        $anio = $anio-1;
                                        $periodo++;
                                        $FechaPeriodoAnterior = $anio.$periodo;
                                        $anio++;
                                        $FechaPeriodoSiguiente =$anio.$periodo;
                                    }
                                }
                                
                                $sqlOrden = "SELECT g.idgrupo, g.codigogrupo, noi.numeroordeninternasap, noi.fechainicionumeroordeninternasap, noi.fechavencimientonumeroordeninternasap, g.codigoperiodo FROM	grupo g, 
                                numeroordeninternasap noi WHERE g.idgrupo = noi.idgrupo AND (g.codigoperiodo = '$FechaPeriodoAnterior'	OR g.codigoperiodo = '$fechaActual'	OR g.codigoperiodo = '$FechaPeriodoSiguiente')ORDER BY 	g.codigoperiodo ASC";
                                $valoresOrden =&$db->Execute($sqlOrden);
                                $datosOrden =  $valoresOrden->getarray();
                              
                                foreach($datosOrden as $campo)
                                {
                                 ?>
                                 <tr>
                                 <td class='Estilo1' align='center'>1<?php echo $campo['idgrupo'] ?>&nbsp;</td>
                                 <td class='Estilo1' align='center'><?php echo $campo['codigogrupo'] ?>&nbsp;</td>
                                 <td class='Estilo1' align='center'><?php echo $campo['numeroordeninternasap'] ?>&nbsp;</td>
                                 <td class='Estilo1' align='center'><?php echo $campo['fechainicionumeroordeninternasap'] ?>&nbsp;</td>
                                 <td class='Estilo1' align='center'><?php echo $campo['fechavencimientonumeroordeninternasap'] ?>&nbsp;</td>
                                 <td class='Estilo1' align='center'><?php echo $campo['codigoperiodo'] ?>&nbsp;</td>
                               
                                 </tr>
                                 
                                 <?php   
                                }
                            ?>
                                                       
                        </table>
                    </div>
                </div>
              
                <?php
                    }
                ?>
            </form>
        </div>
    </body>
</html>