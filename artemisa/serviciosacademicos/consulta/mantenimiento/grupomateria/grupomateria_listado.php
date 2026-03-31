<?php
/*
 * Ajustes de limpieza cdigo
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
    /*
     * Ivan Dario quintero 
     * 10 de octubre
     * Cambio de base de datos, ajustes de lineas, limpieza de codigo.
     */

    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

    $sqlperiodo = "select codigoperiodo from periodo ORDER BY codigoperiodo DESC";
    $periodos = $db->GetAll($sqlperiodo);

    if($_GET['codigoperiodo']!='')
    {
        $periodo= "where codigoperiodo=".$_GET['codigoperiodo']."";
/*
 * modificar las validaciones para que sean mostradas las listas completas en el perfil de 'adminhumanidades' caso 95624
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 16 de Noviembre de 2017.
 */
//        if($_SESSION['MM_Username']=="adminhumanidades")
//        {
//            $humanidades = " and gm.codigotipogrupomateria=100";
//        }
//        end
        $sqlgrupomateria = "SELECT
        gm.idgrupomateria,
        gm.nombregrupomateria,
        gm.codigoperiodo,
        gm.codigotipogrupomateria,
        tgm.nombretipogrupomateria,
        gm.codigomodalidadacademica,	
        ma.nombremodalidadacademica,
        gm.CodigoEstado,
        e.nombreestado
        FROM
            grupomateria gm
        INNER JOIN tipogrupomateria tgm on gm.codigotipogrupomateria = tgm.codigotipogrupomateria
        INNER JOIN modalidadacademica ma on ma.codigomodalidadacademica = gm.codigomodalidadacademica
        INNER JOIN estado e on gm.CodigoEstado = e.codigoestado
        ".$periodo." ".$humanidades." 
        AND gm.CodigoEstado <> 300 
        ORDER BY tgm.nombretipogrupomateria,
	gm.nombregrupomateria ASC";
        $grupomateria = $db->GetAll($sqlgrupomateria);
    }
?>
<meta charset="utf-8">
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
<script language="Javascript">
    function abrir(pagina,ventana,parametros) 
    {
      window.open(pagina,ventana,parametros);
    }
    function enviar()
    {
      document.form1.submit();
    }
    //para que se recargue desde el popup grupomateria_detalle.php
    function recargar() 
    { 
      window.location.reload("grupomateria_listado.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>");
    }
</script>
<body>
    <div class="container">
        <form name="form1" method="get" action="">
            <center><h2>GRUPO MATERIA - LISTADO</h2></center>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th width="45%" bgcolor="#CCDADD">
                            <div align="center">Seleccione Periodo</div>
                        </th>
                        <td width="55%" bgcolor="#FEF7ED">
                            <select id="codigoperiodo" name="codigoperiodo" onchange="enviar()">
                                <option value="">Seleccionar</option>
                                <?php 
                                foreach($periodos as $lista)
                                {
                                    if($_GET['codigoperiodo'] == $lista['codigoperiodo'])
                                    {
                                        echo "<option value='".$lista['codigoperiodo']."' selected>".$lista['codigoperiodo']."</option>";   
                                    }else
                                    {
                                        echo "<option value='".$lista['codigoperiodo']."'>".$lista['codigoperiodo']."</option>";      
                                    }
                                }
                                ?>
                            </select>
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="materia.php">Generar Copia de Grupo Materia</a></label> 
                        </td>
                    </tr>
                </table>
            </div>
            <br>              
            <div class="table-responsive">
                <table class="table">
                    <tr bgcolor="#CCDADD">
                        <th><div align="center">Id</div></th>
                        <th><div align="center">Nombre Grupo</div></th>
                        <th><div align="center">Periodo</div></th>
                        <th><div align="center">Tipo De Grupo </div></th>
                        <th><div align="center">Grupo Materia Linea</div></th>
                        <th><div align="center">Detalle Grupo Materia</div></th>
                        <th><div align="center">Modalidad</div></th>
                        <th><div align="center">Estado</div></th>
                    </tr>
                    <?php 
                        foreach($grupomateria as $materia)
                        {
                            ?>
                            <tr>
                                <td>
                                    <div align='center'>
                                    <a href="grupomateria_form.php" onclick="abrir('grupomateria_detalle.php?idgrupomateria=<?php echo $materia['idgrupomateria'];?>&amp;codigoperiodo=<?php echo $_GET['codigoperiodo'];?>','Formgrupomateria','width=600,height=310,top=50,left=50,scrollbars=yes');return false"><strong><?php echo $materia['idgrupomateria'];?></strong></a>
                                    </div>
                                </td>
                                <td><div align="center"><?php echo $materia['nombregrupomateria']; ?></div></td>
                                <td><div align="center"><?php echo $materia['codigoperiodo']; ?></div></td>
                                <td><div align="center"><?php echo $materia['nombretipogrupomateria']; ?></div></td>
                                <td>
                                    <div align="center">
                                    <a href="grupomaterialinea_listado.php?idgrupomateria=<?php echo $materia['idgrupomateria']?>&amp;codigoperiodo=<?php echo $_GET['codigoperiodo'];?>&codigomodalidadacademica=<?php echo $materia['codigomodalidadacademica'];?>"><span style="font-size:22px;" class="glyphicon glyphicon-folder-close"></span></a>
                                    </div>
                                </td>
                                <td>
                                    <div><center>
                                    <a href="detallegrupomateria_actual.php?idgrupomateria=<?php echo $materia['idgrupomateria']?>&amp;nombregrupomateria=<?php echo $materia['nombregrupomateria']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo'];?>"><span style="font-size:22px;" class="glyphicon glyphicon-list"></span></a>
                                    </center></div>
                                </td>
                                <td><div align="center"><?php echo $materia['nombremodalidadacademica']; ?></div></td>
                                <td><div align="center"><?php echo $materia['nombreestado']; ?></div></td>
                            </tr>
                            <?php
                        }
                    ?>

                     <tr>
                        <td colspan="8">
                            <div align="center">
                            <input class="btn btn-fill-green-XL" name="Crear" type="submit" id="Crear" value="Crear Grupo Materia" onclick="abrir('grupomateria_nuevo.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&usuario=<?php echo $_SESSION['MM_Username']?>','nuevogrupomateria','width=1000,height=300,top=200,left=150,scrollbars=yes');return false">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</body>
<!--end-->