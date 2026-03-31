<?php

    include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Ver Detalle Indicador",TRUE,$proyectoNumericos); 
    
     include ('../../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();

     $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$_REQUEST["id"]);

     
     
      $result3 = mysql_query('SELECT a.idIndicador FROM sala.siq_funcionIndicadores as a
                                                inner join sala.siq_funcionTipo2 as b on a.idsiq_funcionIndicadores =  b.funcionIndicadores
                                                where b.idsiq_funciontipo2 = '.$id);
         
                  while($row3 = mysql_fetch_array($result3))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $indicador = $row3['idIndicador'];
                    echo "<br />";
                         }
                         
                         
          $result2 = mysql_query(' select resultado, porcentaje from siq_funcionTipo2 where idsiq_funcionTipo2 = '.$id);
         
                  while($row2 = mysql_fetch_array($result2))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $resultado = $row2['resultado'];
                     $porcentaje = $row2['porcentaje'];
                    echo "<br />";
                         }
                         
                         
                         $result1 = mysql_query('select a.idsiq_funcionTipo1,id.nombre as nom ,c.nombrecarrera as carr, a.valor as val  from siq_funcionTipo1 a 
                                                inner join siq_funcionTipo2 d on a.idsiq_funcionTipo1  = d.idtipo1valor1 
                                                inner join siq_funcionIndicadores b on a.funcionIndicadores = b.idsiq_funcionIndicadores 
                                                inner join siq_indicador g  on b.idIndicador = g.idsiq_indicador 
                                                inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                                                left join carrera c on c.codigocarrera = g.idCarrera 
                                                where d.idsiq_funcionTipo2 = '.$id);
         
                  while($row1 = mysql_fetch_array($result1))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $indTipo1 = $row1['nom']." ". $row1['carr'];
                     $indtipo1valor = $row1['val'];
                    echo "<br />";
                         }
                         
                         
                          $result = mysql_query('select a.idsiq_funcionTipo1,id.nombre as nom ,c.nombrecarrera as carr, a.valor as val  from siq_funcionTipo1 a 
                                                inner join siq_funcionTipo2 d on a.idsiq_funcionTipo1  = d.idtipo1valor2
                                                inner join siq_funcionIndicadores b on a.funcionIndicadores = b.idsiq_funcionIndicadores 
                                                inner join siq_indicador g  on b.idIndicador = g.idsiq_indicador 
                                                inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                                                left join carrera c on c.codigocarrera = g.idCarrera 
                                                where d.idsiq_funcionTipo2 = '.$id);
         
                  while($row = mysql_fetch_array($result))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $indTipo2 = $row['nom']." ". $row['carr'];
                     $indtipo2valor = $row['val'];
                    echo "<br />";
                         }
                         
$_REQUEST["id"] = $indicador ;


$id = $_REQUEST["id"];
//var_dump($id);


$ver = $_REQUEST["ver"];
//var_dump($ver);

    if($ver == 0){ 
     // echo ("Entre");
    include("./menu.php");
    writeMenu(0);
    } else{
       //  echo ("no Entre");
     // writeMenu(0);
    }

    $data = array();
    $entity = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_numericos();
       $data = $utils->getDataEntity("indicador", $id);  
       $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);  
       $aspecto = $utils->getDataEntity("aspecto", $indicadorGenerico["idAspecto"]); 
       $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
       $estado = $utils->getDataEntity("estadoIndicador", $data["idEstado"]); 
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $entity["label"] = "Tipo";
           $entity["nombre"] = $discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
           $entity["label"] = $discriminacion["nombre"];
           $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
           $entity["nombre"] = $facultad["nombrefacultad"];           
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $entity["label"] = $discriminacion["nombre"];
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $entity["nombre"] = $carrera["nombrecarrera"];  
       }       
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>ver Detalle Valores</h2>
            <table class="detalle">
                <tr>
                    <th>Indicador:</th>
                    <td colspan="3"><?php echo $indicadorGenerico['nombre']." ". $carrera["nombrecarrera"] ;?></td>
                </tr>
                 <tr>
                    <th>Fecha de vencimiento:</th>
                    <td><?php echo $data['fecha_proximo_vencimiento']; ?></td>
                    <th>Fecha de la última actualización:</th>
                    <td><?php echo $data['fecha_ultima_actualizacion']; ?></td>
                </tr>  
                <tr>
                    <th>Estado de actualización:</th>
                    <td><?php echo $estado['nombre']; ?></td>
                    <th>Estado del registro:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr>         
            </table>
            
            
            <table class="detalle">
                <tr>
                    <th>Valor Indicador:</th>
                    <td><?php echo $resultado; ?></td>
                    <th>Porcentaje:</th>
                    <td><?php echo $porcentaje; ?></td>
                </tr>        
            </table>
             <h3>Descripcion de Valores</h3>
              <table class="detalle">
                 <tr>
                    <th> Indicador Valor 1:</th>
                    <td><?php echo $indTipo1; ?></td>
                    <th>Valor:</th>
                    <td><?php echo $indtipo1valor; ?></td>
                </tr>  
                <tr>
                    <th>Indicador Valor 2:</th>
                    <td><?php echo $indTipo2; ?></td>
                    <th>valor:</th>
                    <td><?php echo $indtipo2valor; ?></td>
                </tr>         
            </table>
            
            
        </div>

<?php

 writeFooter(); ?>