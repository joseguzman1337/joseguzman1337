<?php
/*
 * Ivan Dario Quintero Rios
 * 26 de abril del 2018
 */
 
if(!isset($idMGI) && !isset($catMGI)){
    include("../../templates/templateAutoevaluacion.php");
    $db =writeHeader("Instrumento",true,"Autoevaluacion");
    $id_instrumento=str_replace('row_','',$_REQUEST['id']);
    $secc=$_REQUEST['secc'];
} else {
    $id_instrumento = $idMGI;
    $_GET["cat_ins"] = $catMGI;
}  

if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";    
    $data = $entity->getData();
    $data =$data[0];
    $tipo=$data['idsiq_discriminacionIndicador'];
    $tipoProg=$data['codigocarrera'];
}
if (!empty($id_instrumento)){
    $entity1 = new ManagerEntity("Ainstrumentoanalisis");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    $data1 = $entity1->getData();
} 
?>
<!--<script src="../../js/jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="../../js/jquery_ui/js/jquery-ui.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>-->


<?php if(!isset($idMGI) && !isset($catMGI)){ ?>	
	<script type="text/javascript" src="../../tablero_siq/Highcharts-2.3.3/js/highcharts.js"></script>
	<script type="text/javascript" src="../../tablero_siq/Highcharts-2.3.3/js/themes/grid.js"></script>
	<script type="text/javascript" src="../../tablero_siq/Highcharts-2.3.3/js/modules/exporting.js"></script>	
<?php }else{ ?>
	<script type="text/javascript" src="../../../js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../../../mgi/tablero_siq/Highcharts-2.3.3/js/highcharts.js"></script>
	<script type="text/javascript" src="../../../mgi/tablero_siq/Highcharts-2.3.3/js/themes/grid.js"></script>
	<script type="text/javascript" src="../../../mgi/tablero_siq/Highcharts-2.3.3/js/modules/exporting.js"></script>
<?php } ?>



<script type="text/javascript">
    bkLib.onDomLoaded(function(){
        if ($("#aprobada").val()==2){
            comentario1 = new nicEditor({fullPanel : true}).panelInstance('comentario');
        }          
    });
    
    $(function(){
        $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable"
        })
    });
</script>
<style>
.conte{
border-collapse:collapse;
border:1px solid green;
}
.contth
{
border:1px solid green;
}
.conthr
{
background-color:green;
color:white;
}

button{
    padding: 4px 14px 4px;
  font-size: 12px;
  cursor: pointer;
  text-align: center;
  display:inline-block;
  /*border:1px solid #D4D4D4; */ 
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  -khtml-border-radius: 10px;
   border-radius: 10px;
   -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  box-shadow: 0 1px 2px rgba(0,0,0,.2);
  background: #5D7D0E;
   text-shadow: 0 1px 1px rgba(0,0,0,.3);
    background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
  background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E));
   /*filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#7DB72F', endColorstr='#4E7D0E');*/
   border: 1px solid #538312;
   color: #E8F0DE;
   margin-left: 10px;
}
</style>

    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoanalisis">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Reporte del Instrumento</legend>
                <div class="demo_jui">
                    <?php if(!isset($idMGI) && !isset($catMGI)){ ?>
                    <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="nombre" name="nombre"><?php echo $data['nombre']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span style="color:red; font-size:9px">(*)</span>Fecha Inicio:</label></td>
                                <td>
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $data['fecha_inicio']; ?>" />
                                </td>
                                <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Fecha Fin:</label></td>
                                <td><input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $data['fecha_fin']; ?>" />
                                </td>
                                
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Estado:</label></td>
                                <td>
                                    <select id="estado" name="estado">
                                    <option value=""  >-Seleccione-</option>
                                        <option value="1" <?php if($data['estado']==1) echo "selected"; ?>>Activa</option>
                                        <option value="2" <?php if($data['estado']==2) echo "selected"; ?>>Inactiva</option>
                                    </select>
                                </td>
                                <td><label for="obligatoria"><span></span>Utiliza Secciones:</label></td>
                                <td>
                                    <input type="checkbox" name="secciones" id="secciones" tabindex="6" title="Secciones" value="1" <?php if($data['secciones']==1) echo "checked"; ?>  />
                                </td>
                                    
                            </tr>
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS nombre, ' ' AS idsiq_discriminacionIndicador union 
                                                      SELECT nombre, idsiq_discriminacionIndicador
                                                      FROM siq_discriminacionIndicador where codigoestado=100 order by idsiq_discriminacionIndicador";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_discriminacionIndicador',$data['idsiq_discriminacionIndicador'],false,false,1,' id="idsiq_discriminacionIndicador" tabindex="15"  ');
                                    ?>
                                </td>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <img src="Images/buscar.png" onclick="" >
                                    <?php
                                        $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                                        $reg_carrera = $db->Execute($query_carrera);
                                        echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="codigocarrera" tabindex="15" style="width:250px;" ');
                                    ?>
                                </td>
                                    
                            </tr>
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Periodicidad:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS periodicidad, ' ' AS idsiq_periodicidad union 
                                                      SELECT periodicidad, idsiq_periodicidad
                                                      FROM siq_periodicidad where codigoestado=100 order by idsiq_periodicidad";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_periodicidad',$data['idsiq_periodicidad'],false,false,1,' id="idsiq_periodicidad" tabindex="15"  ');
                                    ?>
                                </td>
                                <td></td>
                                <td>
                                 
                                </td>
                                    
                            </tr>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <p><label for="titulo">Nombre:</label><?PHP echo strip_tags($data['nombre']); ?></p>
                    <p><label for="titulo">Fecha de Inicio:</label><?PHP echo $data['fecha_inicio']; ?></p>
                    <p><label for="titulo">Fecha de Finalización:</label><?PHP echo $data['fecha_fin']; ?></p>
                    <?php }?>
            </fieldset>
        <br>
        <fieldset>
             <legend>Instrumento</legend>
             <?php       
               $sql_cp="select 
                        R.cedula, 
                        R.usuariocreacion 
                        from 
                        siq_Arespuestainstrumento R INNER JOIN actualizacionusuario a ON a.usuarioid=usuariocreacion AND R.idsiq_Ainstrumentoconfiguracion=a.id_instrumento
                        where 
                        R.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                        AND
                        a.estadoactualizacion=2
                        and
                        a.codigoestado=100
                        
                        group by usuariocreacion 
                        
                        union 
                        select 
                        cedula, 
                        usuariocreacion 
                        from 
                        siq_Arespuestainstrumento 
                        where 
                        idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                        AND
                        cedula<>''
                        group by cedula";
                //echo $sql_cp;  
                
                 $cant=0;
                 $data_cp = &$db->Execute($sql_cp);
                 $C_data = $data_cp->GetArray();
                 $C_total=count($C_data);
                 echo 'Cantidad de Personas que contestaron el instrumento:'.count($C_data);
        ?>
        <br>
        <hr>
        <table border="0" align="center" >
             <tr>
                <td colspan="2">
                    <br>
                    <?php if(!isset($idMGI) && !isset($catMGI)){ 
                        ?>
                        <a href="archivo_plano.php?id_ins=<?php echo $id_instrumento?>" class="submit" >
                        Descargar Archivo
                        </a>&nbsp;&nbsp;
                        <a href="ArchivoPlanoRespuestas.php?id_ins=<?php echo $id_instrumento?>" class="submit" >
                        Descargar Archivo Respuestas
                        <?php 
                    }else{ ?>
                        <a href="../../../mgi/autoevaluacion/interfaz/archivo_plano.php?id_ins=<?php echo $id_instrumento?>" class="submit" >
                        Descargar Archivo</a>
                        &nbsp;&nbsp;<a href="../../../mgi/autoevaluacion/interfaz/ArchivoPlanoRespuestas.php?id_ins=<?php echo $id_instrumento?>" class="submit" >
                        Descargar Archivo Respuestas
                        <?php 
                    }
                   // } 
                    ?>
                </td>
            </tr>    
            <tr>
                <td colspan="2">
                    <hr>
                    <!-- Titulo del reporte de resultados-->
                    A continuación se realiza un análisis de cada una de la preguntas:
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    $sql_cp="SELECT ins.idsiq_Aseccion,  sec.nombre as secce
                    FROM  siq_Ainstrumento as ins
                    inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                    where ins.codigoestado=100 
                    and sec.codigoestado=100 
                    and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                    group by idsiq_Aseccion    ";                 
                    $cant=0;
                    $data_cp = $db->Execute($sql_cp);                 
                    $z=0;                 
                    $k=0;
                    foreach($data_cp as $dt_cp){//lee las secciones
                        echo "<div id='secc_".$z."' >";
                        echo "<fieldset>";//abre un fieldset por seccion
                     
                        $id_secc=$dt_cp['idsiq_Aseccion'];
                        echo "<legend>".trim($dt_cp['secce'])."</legend>";//coloca el nombre de la seccion
                        ///Busca la pregunta por seccion/////////
                        $sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion, 
                        ins.idsiq_Apregunta, pr.titulo, pr.obligatoria, 
                        pr.idsiq_Atipopregunta
                        FROM siq_Ainstrumento as ins 
                        inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)
                        where ins.codigoestado=100 
                        and pr.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                       
                        $data_preg = $db->Execute($sql_preg);
                        $j=1;
                        
                        foreach($data_preg as $dt_preg){//lee las preguntas por seccion
                            $id_preg=$dt_preg['idsiq_Apregunta'];
                            $titulo=$dt_preg['titulo'];
                            $obl=$dt_preg['obligatoria'];
                            $t_preg=$dt_preg['idsiq_Atipopregunta'];
                            
                            if ($j>1) echo "<br>";
                                if (!empty($obl)){
                                    echo '<b><label style="color:red; font-size:9px">(*)</label>'.$j.'.'.$titulo.'</b>';
                                }else{
                                    echo '<b>'.$j.'.'.$titulo.'</b>';//pinta el titulo de la pregunta
                                }
                                ?>
                                <input type="hidden" id="id_Pregunta_<?PHP echo $z.'_'.$j?>" value="<?PHP echo $id_preg ?>">
                                <input type="hidden" id="idPregunta_<?PHP echo $k?>" name="idPregunta[<?php echo $k ?>]" value="<?PHP echo $id_preg ?>">
                                <input type="hidden" id="id_titulo_<?PHP echo $z.'_'.$j?>" value="<?PHP echo strip_tags($titulo); ?>">
                                <input type="hidden" id="Ainstrumentoanalisis_<?PHP echo $k?>" name="Ainstrumentoanalisis[<?PHP echo $k?>]"  value="<?php echo $data1[$k]['idsiq_Ainstrumentoanalisis'] ?>">
                                 
                                <?PHP
                                echo "<br>";
                                ///Busca las respuestas por preguntas//////
                                echo "<table border='0' >";
                                echo "<tr>";
                                echo "<td valign='top'>";
                                if ($t_preg=='1' or $t_preg=='3' or $t_preg=='8' or $t_preg=='6'  or $t_preg=='4'  or $t_preg=='2'){
                                    if ($t_preg=='2'){
                                        /*
                                        select pre.valor as respuesta, pre.texto_inicio, pre.texto_final, res.idsiq_Apreguntarespuesta, count(res.idsiq_Apreguntarespuesta) as total
                                        from siq_Apreguntarespuesta as pre
                                        left join siq_Arespuestainstrumento as res on (res.idsiq_Apreguntarespuesta=pre.idsiq_Apreguntarespuesta and res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                        where pre.idsiq_Apregunta='".$id_preg."' and pre.codigoestado='100' 
                                        group by pre.valor
                                        */
                                        /*
                                        select 
                                        pre.valor as respuesta, 
                                        pre.texto_inicio, 
                                        pre.texto_final, 
                                        res.idsiq_Apreguntarespuesta, 
                                        count(res.idsiq_Apreguntarespuesta) as total
                                        from 
                                        siq_Apreguntarespuesta as pre left join siq_Arespuestainstrumento as res on (res.idsiq_Apreguntarespuesta=pre.idsiq_Apreguntarespuesta and res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."') 
                                        INNER JOIN actualizacionusuario act ON act.usuarioid=res.usuariocreacion AND act.estadoactualizacion=2 AND act.codigoestado=100
                                        where 
                                        pre.idsiq_Apregunta='".$id_preg."' 
                                        and 
                                        pre.codigoestado='100' 
                                        group by pre.valor
                                        /***/                                        
                                        $sql_rep=" select
                                        sub.respuesta,
                                        sub.texto_inicio,
                                        sub.texto_final,
                                        sub.idsiq_Apreguntarespuesta, sum(total) as total FROM (select
                                        pre.valor as respuesta,
                                        pre.texto_inicio,
                                        pre.texto_final,
                                        res.idsiq_Apreguntarespuesta,
                                        IF(act.usuarioid IS NULL, 0, count(res.idsiq_Apreguntarespuesta)) as total
                                        from
                                        siq_Apreguntarespuesta as pre left join siq_Arespuestainstrumento as res on (res.idsiq_Apreguntarespuesta=pre.idsiq_Apreguntarespuesta and res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                        left JOIN actualizacionusuario act ON act.usuarioid=res.usuariocreacion AND act.estadoactualizacion=2 AND act.codigoestado=100
                                        AND res.idsiq_Ainstrumentoconfiguracion=act.id_instrumento 
                                        where
                                        pre.idsiq_Apregunta='".$id_preg."'
                                        and
                                        pre.codigoestado='100'
                                        AND
                                        res.codigoestado=100
                                        group by pre.valor,act.usuarioid) as sub GROUP BY sub.respuesta";
                                    }else{
                                        $sql_rep='SELECT
                                        x.idsiq_Apreguntarespuesta,
                                        COUNT(x.respuesta) AS total,
                                        x.respuesta
                                        FROM(
                                            SELECT         
                                            rr.idsiq_Apreguntarespuesta,
                                            ra.respuesta,
                                            ra.valor,
                                            ra.unica_respuesta,
                                            ra.multiple_respuesta,
                                            rr.idsiq_Ainstrumentoconfiguracion,
                                            rr.usuariocreacion
                                            FROM
                                            siq_Arespuestainstrumento AS rr
                                            INNER JOIN siq_Apreguntarespuesta AS ra ON ra.idsiq_Apreguntarespuesta = rr.idsiq_Apreguntarespuesta
                                            INNER JOIN actualizacionusuario act ON (rr.usuariocreacion = act.usuarioid OR rr.cedula=act.numerodocumento) 
                                            AND rr.idsiq_Ainstrumentoconfiguracion = act.id_instrumento                                                                
                                            WHERE
                                            rr.idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                                            AND
                                            rr.idsiq_Apregunta="'.$id_preg.'" 
                                            AND
                                            rr.codigoestado=100 
                                            AND 
                                            (rr.usuariocreacion!="" OR rr.cedula!="") GROUP BY act.usuarioid,act.numerodocumento
                                            ) x
                                            GROUP BY x.idsiq_Apreguntarespuesta';
                                    }
                                    $data_rep = $db->Execute($sql_rep);
                                    echo "<table border='1' class='conte' >";
                                    echo "<tr>";
                                    echo "<th class='conthr'>Criterios</th>";
                                    echo "<th class='conthr' style='text-align:center' >Frecuencia</th>";
                                    echo "<th class='conthr' style='text-align:center'>Porcentaje</th>";
                                    echo "<th class='conthr' style='text-align:center'>Porcentaje Acumulado</th>";
                                    echo "</tr>";
                                    $total=0; $tpor=0; $i=0;
                                    foreach($data_rep as $dt_rep){                                                            
                                        $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; 
                                        $res=$dt_rep['respuesta']; 
                                        $tot=$dt_rep['total'];
                                        if ($t_preg=='2') $ti=$dt_rep['texto_inicio'];
                                        if ($t_preg=='2') $tf=$dt_rep['texto_final'];
                                        $total=$total+$tot;
                                        //echo $total;
                                        $por=($tot*100)/$C_total;
                                        $tpor=$tpor+$por;
                                        $dat['resp'][$i]=$res;
                                        $dat['tot'][$i]=$tot;
                                        $dat['por'][$i]=$por;
                                        $dat['tpor'][$i]=$tpor;
                                        if ($t_preg=='2' and $i==0){
                                            echo "<tr>";
                                                echo "<td colspan='4' ><b>".$ti."</b></td>";
                                            echo "</tr>";
                                        }
                                        echo "<tr>";
                                            echo "<td >".$res."</td>";
                                            echo "<td style='text-align:center'>".$tot."</td>";
                                            echo "<td style='text-align:center'>".number_format($por, 2, '.', '')."%</td>";
                                            echo "<td style='text-align:center'>".number_format($tpor, 2,'.', '')."%</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    if ($t_preg=='2'){
                                        echo "<tr>";
                                            echo "<td colspan='4' ><b>".$tf."</b></td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr>";
                                    echo "<td ><b>Total</b></td>";
                                    echo "<td style='text-align:center'><b>".$total."<b/></td>";
                                    echo "<td style='text-align:center'><b>".$tpor."%<b/></td>";
                                    echo "<td></td>";
                                    echo "</tr>";
                                    echo "</table>";
                                    echo "<br>";
                                }else{                                                    
                                    $SQL_PreguntaAbierta='SELECT 
                                    preg_abierta                                        
                                    FROM siq_Arespuestainstrumento                                         
                                    WHERE 
                                    idsiq_Ainstrumentoconfiguracion = "'.$id_instrumento.'"  
                                    AND idsiq_Apregunta = "'.$id_preg.'" 
                                    AND codigoestado = 100 ';
                                                                            
                                    if($Respuest_Obs=&$db->Execute($SQL_PreguntaAbierta)===false){
                                        echo 'Error en el SQl....<br><br>'.$SQL_PreguntaAbierta;
                                        die;
                                    }    
                                    while(!$Respuest_Obs->EOF){
                                        ?>
                                        <br />* <?PHP echo $Respuest_Obs->fields['preg_abierta']?>
                                        <?PHP
                                        $Respuest_Obs->MoveNext();
                                    } 
                                }
                                echo "</td>";
                                echo "<td width='30px'>";
                                echo "</td>";
                                echo "<td>";                                           
                                if ($t_preg=='1' or $t_preg=='3' or $t_preg=='8' or $t_preg=='6' or $t_preg=='4' or $t_preg=='2'){
                                    echo '<div id="container_'.$id_preg.'" style="width:550px; height:300px; margin: 0 auto;">
                                    <button class="generarGrafica tipoPreg_'.$t_preg.'" type="button" id="buttonContainer_'.$id_preg.'">Generar gráfica</button>
                                    </div>';
                                }
                                echo "</td>";            
                                echo "</tr>";
                                echo "</table>";
                                ?>
                                <input type="hidden" id="Tipo_Pregunta_<?PHP echo $z.'_'.$j?>" value="<?PHP echo $t_preg?>">
                                <?PHP
                                $j++; $k++;
                            }//cierra las preguntas por seccion
                            ?>
                            <input type="hidden" id="Num_Preguntas_<?PHP echo $z?>" value="<?PHP echo $j?>">
                            <?PHP
                            echo "</fieldset>";//cierra el fieldset por seccion
                            echo "</div>";
                            $z++;
                    }//cierra leer las secciones
                    ?><input type="hidden" id="Num_seccion" value="<?PHP echo $z?>">
                    </td>
                </tr>                
                </table>
         </fieldset>
        <?php if(!isset($idMGI) && !isset($catMGI)){ 
            ?>
            </div>
            <div class="derecha">
                <button class="submit" id="guardar" type="submit">Guardar</button>
                &nbsp;&nbsp;
                <a href="configuracioninstrumentolistar4.php?cat_ins=<?php echo $_GET["cat_ins"]; ?>" class="submit" >Regreso al menú</a>
            </div><!-- End demo -->
            <?php 
        } ?>
  </form>
<script type="text/javascript">
     $("#nombre").attr("disabled",true);
     $("#mostrar_bienvenida").attr("disabled",true);
     $("#mostrar_despedida").attr("disabled",true);
     $("#fecha_inicio").attr("disabled",true);
     $("#fecha_fin").attr("disabled",true);
     $("#estado").attr("disabled",true);
     $("#secciones").attr("disabled",true);
     $("#idsiq_discriminacionIndicador").attr("disabled",true);
     $("#idsiq_periodicidad").attr("disabled",true);
     $("#codigocarrera").attr("disabled",true);
      $("#codigomodalidadacademica").attr("disabled",true);
     var chart;
     
     //on por ser dinamico, para generar las gráficas
        $(".generarGrafica").on('click',function(event){
            event.preventDefault();
            
            // get number of column
            var id = $(this).attr('id');
            var tipo = $(this).attr('class').split(" ");
            tipo = tipo[1].replace("tipoPreg_","");
            var id_preg = id.replace("buttonContainer_",""); 
            $('#container_'+id_preg).html('<img src="../../images/ajax-loader.gif" alt="Cargando..." />');
            
         //if ($("#id_Pregunta_"+l+'_'+i).val()=='93'){  
           var id_in=$("#idsiq_Ainstrumentoconfiguracion").val();
           //var Titulo = $("#id_titulo_"+l+'_'+i).val();
           var Titulo='';
           //alert(Titulo)
           //alert('ins->>'+id_in+'/npreg-->>'+id_preg);
           $.ajax({//Ajax
                type: 'GET',
				<?php if(!isset($idMGI) && !isset($catMGI)){ ?>
                url: 'graficos.php',
				<?php }else{ ?>
				url: '../../../mgi/autoevaluacion/interfaz/graficos.php',
				<?php } ?>
                async: false,
                dataType: 'json',
                data:({actionID: 'DatosGrafic',
                                id_instru:id_in,
                                tipo_preg:tipo,
                                id_preg:id_preg}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //console.log(data);
                         if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                         }else{
                            var Respuesta = data.Respuesta;
                            var Total=data.Total;
                    $(document).ready(function() { 
                        //alert(Total)
                        var colors = Highcharts.getOptions().colors,
                        categories = Respuesta,
                        name = '_',
                        data = datatotal();
                        function datatotal(){
                            //alert(Total);
                            var Num=[]
                            for(q=0;q<Total.length;q++){
                            // alert(Total[q])
                                Num.push({
                                    y: Total[q],
                                    color: colors[q]
                                });
                            }
                            return Num;

                        }                   

                        function setChart(categories, data, color, Titulo) {
                                                chart.xAxis[0].setCategories(categories, false);
                                                chart.series[0].remove(false);
                                                chart.addSeries({
                                                        name: name,
                                                        data: data,
                                                        color: color || 'white'
                                                }, false);
                                                chart.redraw();
                                }

                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container_'+id_preg,
                                        type: 'column'
                                    },
                                    title: {
                                        text: null
                                    },
                                    xAxis: {
                                        categories: categories
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Porcentaje total'
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: colors[0],
                                                style: {
                                                    fontWeight: 'bold'
                                                },
                                                formatter: function() {
                                                    return this.y +'%';
                                                }
                                            }
                                        }
                                    },
                                    tooltip: {
                                        formatter: function() {
                                            var point = this.point,
                                                s = this.x +':<b>'+ this.y +'% Participacion</b><br/>';
                                            return s;
                                        }
                                    },
                                    series: [{
                                        name: name,
                                        data: data,
                                        color: 'white'
                                    }],
                                    exporting: {
                                        enabled: false
                                    }
                                });
                            });
                        }//if ajax
                    } 
                });//Ajax 
        });
     

    
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                        if ( $("#aprobada").val()==2 ){
                            document.getElementById("comentario").innerHTML = $.trim(nicEditors.findEditor('comentario').getContent());
                        }
                        if($("#comentario").val()=='<br>') {
                                alert("El Comentario no debe estar vacio");
                                $("#comentario").focus();
                                return false;
                        }else{
                            sendForm()
                        } 

                });
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
                
                
</script>
<?php    
    writeFooter();
?> 