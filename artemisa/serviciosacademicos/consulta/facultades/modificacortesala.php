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

    $idUsuario=$_SESSION['usuario'];
	
     $query_usuario = "select ur.idrol from usuario u 
    INNER JOIN UsuarioTipo ut on u.idusuario = ut.UsuarioId
    INNER JOIN usuariorol ur on ut.UsuarioTipoId = ur.idusuariotipo
    where u.usuario = '".$idUsuario."'";    
    $row_usuario = $db->GetRow($query_usuario);
  
    $colname_Recordset1 = "1";

    if (isset($_GET['idcortes'])) 
    {
        $colname_Recordset1 = $_GET['idcortes'];
    }

    $query_Recordset1 = "SELECT c.*,m.nombremateria,ca.nombrecarrera
                            FROM corte c,materia m,carrera ca 
                            WHERE idcorte = '".$colname_Recordset1."'										
                            AND c.codigomateria = m.codigomateria
                            and c.usuario = ca.codigocarrera
                            and m.codigoestadomateria = '01'";										    
    $row_Recordset1 = $db->GetRow($query_Recordset1);    

    if(empty($row_Recordset1['codigocarrera']))
    {
        $row_Recordset1['codigocarrera'] = $_REQUEST['idCarrera'];
    }
    if(empty($row_Recordset1['codigoperiodo']))
    {
	   $row_Recordset1['codigoperiodo'] = $_SESSION['codigoperiodosesion'];
    }
    
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
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap-datetimepicker.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap-datetimepicker.min.css">        
        <script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/moment.js"></script>        
        <script type="text/javascript" src="../../../assets/js/moment-with-locales.js"></script>        
        <script type="text/javascript" src="../../../assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../../assets/js/bootstrap-datetimepicker.js"></script>
        
        <script type="text/javascript"> 
            $( document ).ready(function() {
                $(".form_datetime").datetimepicker({
                    format: 'YYYY-MM-DD',
                    locale: 'es'
                });              
            });
        </script>
        <script>
            function eliminarcorte(indice)
            {            
                $.ajax({
                    type: 'post',
                    async: false,
                    url: 'funciones/funciones.php',
                    dataType: 'json',
                    data: { action:'deleteCorteRol',indice:indice }, 
                    success: function (data) {                    
                        alert(data.mensaje);
                    }
                });                   
            }//function eliminarcorte

            function guardar()
            {               
                var data = $("form").serialize();   
                $.ajax({                    
                    async: false,
                    url: 'funciones/funciones.php',
                    type: 'POST',
                    dataType: 'json',
                    data: data,                
                    success: function(data){
                        alert(data.mensaje);   
                    }
                });                
            }//funcion guardar       
        </script>
    </head>
    <body>
        <div class="container">    
            <form method="post" name="form1" id="form1" enctype="multipart/form-data">       
                <input type="hidden" name="action" id="action" value="Modificar">
                <?php 
                if ($row_Recordset1['codigocarrera'] <> 1)
                {        
                    $query_carrera = "SELECT * FROM corte 
                    WHERE codigocarrera = '".$row_Recordset1['codigocarrera']."'										
                    AND codigoperiodo = '".$row_Recordset1['codigoperiodo']."'";										        
                    $row_carrera = $db->GetAll($query_carrera);                     

                }
                else if ($row_Recordset1['codigomateria'] <> 1)
                {            
                    $query_carrera = "SELECT * FROM corte 
                    WHERE codigomateria = '".$row_Recordset1['codigomateria']."'										
                    AND codigoperiodo = '".$row_Recordset1['codigoperiodo']."' order by 1";
                    $row_carrera = $db->GetAll($query_carrera);                 
                }            

                if($_REQUEST['idMateria'] !== null)
                {
                    if($_REQUEST['idMateria']<>$row_Recordset1['codigomateria'])
                    {
                        header('Location: cortesala.php');
                    }	
                }
                ?>  
                <div align="left">
                    <br>
                </div>
                <table class="table">
                    <tr>
                        <th height="11%" colspan="5" align="right" nowrap>
                            <center>
                                <h2>
                                <?php                             
                                    echo $row_Recordset1['nombremateria'];                            
                                ?>
                                <span class="style2">
                                    <?php 
                                    if ($row_Recordset1['codigomateria'] <> 1) 
                                        echo $idCarrera=$row_Recordset1['codigomateria']; 
                                    ?>
                                </span>
                                </h2>
                            </center>
                        </th>
                    </tr>
                    <tr>
                        <td height="11%" align="right" nowrap colspan="2">
                            <center><strong>Carrera</strong></center>
                        </td>
                        <td align="right" nowrap colspan="2">
                            <div align="center">
                                <strong><?php echo $row_Recordset1['nombrecarrera']; ?></strong>
                            </div>
                        </td>               
                    </tr>
                    <tr valign="baseline">
                        <th height="11%" align="right" nowrap>
                            <div align="center">Número corte</div>
                        </th>
                        <th height="11%" align="right" nowrap>
                            <div align="center">Fecha inicial corte</div>
                        </th>
                        <th>
                            <div align="center" >Fecha final corte</div>
                        </th>
                        <th>      
                            <div align="center">Porcentaje corte</div>
                        </th>  
                        <?php 
                        if ($row_usuario['idrol'] == '13')
                        {
                            echo "<th><div align='center'>Eliminar</div></th>";
                        }
                        ?>
                    </tr>
                    <?php
                    $contadorcortes = 0;
                    foreach($row_carrera as $datoscortes)
                    {
                        $contadorcortes++;
                        ?>
                        <tr>
                            <td>
                                <center>
                                    <strong><?php echo $datoscortes['numerocorte']; ?></strong>
                                    <input type="hidden" name="idcorte<?php echo $contadorcortes; ?>" value="<?php echo $datoscortes['idcorte'];?>">
                                </center>
                            </td>
                            <td>
                                <center>   
                                    <div class='input-group date'>
                                        <input class="form_datetime" name="fechainicialcorte<?php echo $contadorcortes;?>" type="text" value="<?php echo $datoscortes['fechainicialcorte']; ?>" size="8">     
                                    </div>
                                </center>
                            </td>
                            <td>
                                <center>          
                                    <div class='input-group date'>
                                    <input class="form_datetime" name="fechafinalcorte<?php echo $contadorcortes;?>" type="text" value="<?php echo $datoscortes['fechafinalcorte']; ?>" size="8">
                                    </div>
                                </center>
                            </td>
                            <td>
                                <center>
                                <input name="porcentajecorte<?php echo $contadorcortes; ?>" type="text" value="<?php echo $datoscortes['porcentajecorte'];?>" size="1" maxlength="3">
                                <strong>      %</strong>
                                </center>
                            </td>
                            <?php
                            if ($row_usuario['idrol'] == '13')
                            {
                                ?>
                                <td>
                                <div align="center">
                                    <button class="btn btn-fill-green-XL" onclick="eliminarcorte('<?php echo $datoscortes['idcorte'] ;?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </div>	
                                </td>
                                <?php
                            }//if	                                                       
                            ?>
                        </tr>
                        <?php
                    }//foreach
                    ?>  
                    <tr>
                        <td height="17%" colspan="5" align="right" nowrap>
                            <div align="center" class="Estilo1">
                                <?php
                                $query_procesoperiodo = "SELECT	*
                                FROM procesoperiodo
                                WHERE codigoperiodo = '".$row_Recordset1['codigoperiodo']."'							
                                and codigocarrera = '".$row_Recordset1['codigocarrera']."'
                                and idproceso = '1'
                                and codigoestadoprocesoperiodo = '200'";
                                $row_procesoperiodo = $db->GetRow($query_procesoperiodo);                        

                                $query_procescant = "SELECT max(idcorte) as total
                                FROM corte 
                                WHERE codigomateria = '".$row_Recordset1['codigomateria']."'										
                                AND codigoperiodo = '".$row_Recordset1['codigoperiodo']."'";
                                $row_procesocorte = $db->GetRow($query_procescant);
                                $cantTotal=$row_procesocorte['total'];
                                $idCorteS=$_GET['idcortes'];    
                                $diferencia=$cantTotal-$idCorteS;
                                $idCorteS=$idCorteS + $diferencia;

                                if($row_Recordset1['codigomateria'] == '1')
                                {
                                    $row_Recordset1['codigomateria']=1;
                                }
                                if ($_SESSION['codigoestadoperiodosesion'] <> 2 and !$row_procesoperiodo)
                                {
                                ?>
                                    <button class="btn btn-fill-green-XL" onclick="guardar()">
                                        Guardar Cambios
                                    </button>
                                    <a href="listacortessala.php" class="btn btn-fill-green-XL" >Regresar</a>
                                <?php 
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="contador" value="<?php echo $contadorcortes; ?>"/> 
                <input type="hidden" name="idcortes" value="<?php echo $row_Recordset1['idcorte']; ?>"/> 
            </form>
        </div>
    </body>
</html>