<?php 
/*
* Ivan dario quinterio rios
* Modificado 20 octubre 2017
* Modificacion de conexion de base de datos y adicion de estilos
* limpieza de codigo basura
*/
    error_reporting(E_ALL);
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php'); 
    $rutaado = "../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');

    $periodo = $_SESSION['codigoperiodosesion'];
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">  
        <link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/bootstrap.js"></script>
        <?php

        $colname_cortes = "1";
        if (isset($_SESSION['codigofacultad'])) 
        {
          $colname_cortes = (get_magic_quotes_gpc()) ? $_SESSION['codigofacultad'] : addslashes($_SESSION['codigofacultad']);
        }
        $query_cortes = "SELECT c.*,m.nombremateria 
                        FROM corte c,materia m 
                        WHERE c.usuario = '".$colname_cortes."'
                        AND c.codigomateria = m.codigomateria
                        and m.codigoestadomateria = '01'
                        and c.codigoperiodo = '$periodo'
                        order by m.codigomateria asc";
        $cortes = $db->GetAll($query_cortes);

        ?>
    </head>
    <body>
        <div class="container">   
            <div class="pad-bottom-20">
                <center><h2>Fechas y Porcentajes para digitacion de notas</h2></center>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th><div align="center" class="Estilo4">Editar</div></th>
                        <th><div align="center" class="Estilo4">Carrera</div></th>      
                        <th><div align="center" class="Estilo4">Materia</div></th>
                        <th><div align="center" class="Estilo4">Nombre Materia</div></th>
                        <th><div align="center" class="Estilo4">Corte</div></th>
                        <th><div align="center" class="Estilo4">Fecha Inicial</div></th>
                        <th><div align="center" class="Estilo4">Fecha Final</div></th>
                        <th><div align="center" class="Estilo4">Porcentaje</div></th>
                    </tr>
                    <?php 
                    foreach($cortes as $row_cortes)
                    { 
                    ?>
                    <tr>
                        <td>
                            <div align="center">
                              <a href="modificacortesala.php?idcortes=<?php echo $row_cortes['idcorte'];?>">
                                  <p style="font-size: 22px;"><span class="glyphicon glyphicon-edit"></span></p>
                              </a>        
                          </div>                    
                        </td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['codigocarrera']; ?></span></div></td>                        
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['codigomateria']; ?></span></div></td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['nombremateria']; ?></span></div></td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['numerocorte']; ?></span></div></td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['fechainicialcorte']; ?></span></div></td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['fechafinalcorte']; ?></span></div></td>
                        <td><div align="center"><span class="style6"><?php echo $row_cortes['porcentajecorte']; ?></span></div></td>
                    </tr>
                    <?php 
                    }//foreach 
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>