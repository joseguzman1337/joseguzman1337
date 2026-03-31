<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$codigocarrera = $_REQUEST['codigocarrera'];
$codigoperiodo = $_REQUEST['codigoperiodo'];
$idplanestudio = $_REQUEST['idplanestudio'];

$query_nomcarrera="select nombrecarrera from carrera where codigocarrera='$codigocarrera'";
$nomcarrera= $db->Execute($query_nomcarrera);
$totalRows_nomcarrera= $nomcarrera->RecordCount();
$row_nomcarrera= $nomcarrera->FetchRow();

$query_selsemestre2 = "SELECT semestredetallelineaenfasisplanestudio
    FROM detallelineaenfasisplanestudio
    where
    idplanestudio='$idplanestudio'
    and codigoestadodetallelineaenfasisplanestudio LIKE '1%'
    group by semestredetallelineaenfasisplanestudio
    order by semestredetallelineaenfasisplanestudio";
$selsemestre2 = $db->Execute($query_selsemestre2 );
$totalRows_selsemestre2 = $selsemestre2->RecordCount();
$row_selsemestre2 = $selsemestre2->FetchRow();

if($totalRows_selsemestre2 >0){
?>

<html>
    <head>
        <?php
                if(!isset($_REQUEST['exportar'])){
            ?>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <?php } ?>
    </head>
    <body>
        <form action=""  name="form1" method="POST">

            <br><br>
            <table  border="1" cellpadding="3" cellspacing="3" align="center">
                <TR>
                    <TD  align="center" colspan="2" id="tdtitulogris">
                        <label id="labelresaltadogrande" >LINEA DE ENFASIS <br><?php echo $row_nomcarrera['nombrecarrera'] ?> </label>
                    </TD>
                </TR>
                <?php
                do
                {
                    
                ?>
                    <tr>
                        <td colspan="2" align="center" id="tdtitulogris"><label id="labelresaltadogrande">Semestre <?php echo $row_selsemestre2['semestredetallelineaenfasisplanestudio']; ?></label></td>
                    </tr>
                    <tr>
                        <td  colspan="2" align="left" bgcolor="#C5D5D6"><b>Asignatura</b></td>

                    </tr>
                    
                <?php
                    $query_materiasplanestudio = "SELECT d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, l.nombrelineaenfasisplanestudio,
                    d.semestredetallelineaenfasisplanestudio*1 AS semestredetalleplanestudio, 
                    t.nombretipomateria, d.numerocreditosdetallelineaenfasisplanestudio, m.numerocreditos, m.numerohorassemanales
                    FROM detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisplanestudio l
                    WHERE d.codigoestadodetallelineaenfasisplanestudio LIKE '1%'
                    AND d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
                    AND d.codigotipomateria = t.codigotipomateria
                    and d.idlineaenfasisplanestudio= l.idlineaenfasisplanestudio
                    AND d.idplanestudio = '$idplanestudio'
                    and d.semestredetallelineaenfasisplanestudio='".$row_selsemestre2['semestredetallelineaenfasisplanestudio']."'
                    ORDER BY 4,2";

                    $materiasplanestudio= $db->Execute($query_materiasplanestudio);
                    $totalRows_materiasplanestudio= $materiasplanestudio->RecordCount();
                    $row_materiasplanestudio= $materiasplanestudio->FetchRow();

                    do{ ?>
                    <tr>
                        <td id="tdtitulogris"><?php echo $row_materiasplanestudio['nombremateria'].$row_materiasplanestudio['codigomateria']; ?></td>

                    <?php
                        $query_detalleest="
                        select
                            cm.codigocarrera
                            ,cm.nombrecarrera Carrera_Materia
                            ,m.codigomateria
                            ,m.nombremateria Materia
                            , g.idgrupo
                            , g.nombregrupo Grupo
                            ,d.numerodocumento Documento_Docente
                            , d.apellidodocente Apellido_Docente
                            ,d.nombredocente Nombre_Docente
                            ,count(distinct e.codigoestudiante) Total_Alumnos
                            , count(distinct d1.codigoestudiante) Perdieron_Corte1
                            , (ROUND((count(distinct d1.codigoestudiante)/count(distinct e.codigoestudiante))*100)) as '%Perdieron_corte1'
                            , count(distinct d2.codigoestudiante) Perdieron_Corte2
                            , CONCAT((ROUND((count(distinct d2.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte2'
                            , count(distinct d3.codigoestudiante) Perdieron_Corte3
                            , CONCAT((ROUND((count(distinct d3.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte3'
                            , count(distinct d4.codigoestudiante) Perdieron_Corte4
                            , CONCAT((ROUND((count(distinct d4.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte4'
                            , count(distinct h.codigoestudiante) Perdieron_Definitiva
                            , CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_definitiva'
                            ,ea1.estrategiaasignatura as estrategiac1
                            ,ea2.estrategiaasignatura as estrategiac2
                            ,ea3.estrategiaasignatura as estrategiac3
                            ,ea4.estrategiaasignatura as estrategiac4
                            ,ea5.estrategiaasignatura as estrategiaDF
                        from estudiante e
                            , estudiantegeneral eg
                            , materia m
                            ,grupo g
                            left join estrategiaasignatura ea1 on  ea1.idgrupo=g.idgrupo and ea1.numerocorte=1
                            left join estrategiaasignatura ea2 on  ea2.idgrupo=g.idgrupo and ea2.numerocorte=2
                            left join estrategiaasignatura ea3 on  ea3.idgrupo=g.idgrupo and ea3.numerocorte=3
                            left join estrategiaasignatura ea4 on  ea4.idgrupo=g.idgrupo and ea4.numerocorte=4
                            left join estrategiaasignatura ea5 on  ea5.idgrupo=g.idgrupo and ea5.numerocorte=5
                            , docente d
                            , carrera cm
                            ,corte co
                            ,detallenota dn
                            left join detallenota d1 on d1.codigoestudiante=dn.codigoestudiante and d1.idgrupo=dn.idgrupo and d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and c1.idcorte=co.idcorte) and ROUND(d1.nota,1) < (select notaminimaaprobatoria from materia m1 where m1.codigomateria=d1.codigomateria)
                            left join detallenota d2 on d2.codigoestudiante=dn.codigoestudiante and d2.idgrupo=dn.idgrupo and d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and c2.idcorte=co.idcorte) and ROUND(d2.nota,1) < (select notaminimaaprobatoria from materia m2 where m2.codigomateria=d2.codigomateria)
                            left join detallenota d3 on d3.codigoestudiante=dn.codigoestudiante and d3.idgrupo=dn.idgrupo and d3.idcorte = (select idcorte from corte c3 where numerocorte=3 and c3.idcorte=co.idcorte) and ROUND(d3.nota,1) < (select notaminimaaprobatoria from materia m3 where m3.codigomateria=d3.codigomateria)
                            left join detallenota d4 on d4.codigoestudiante=dn.codigoestudiante and d4.idgrupo=dn.idgrupo and d4.idcorte = (select idcorte from corte c3 where numerocorte=4 and c3.idcorte=co.idcorte) and ROUND(d4.nota,1) < (select notaminimaaprobatoria from materia m4 where m4.codigomateria=d4.codigomateria)
                            left join notahistorico h on h.codigoestudiante=dn.codigoestudiante and h.idgrupo=dn.idgrupo and ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)
                        where  eg.idestudiantegeneral=e.idestudiantegeneral
                            AND g.codigomateria=m.codigomateria
                            AND g.codigoperiodo='$codigoperiodo'
                            AND g.codigoestadogrupo like '1%'
                            and d.numerodocumento=g.numerodocumento
                            and dn.idgrupo=g.idgrupo
                            and dn.codigoestudiante=e.codigoestudiante
                            and co.idcorte=dn.idcorte
                            and cm.codigocarrera=m.codigocarrera
                            AND m.codigomateria='".$row_materiasplanestudio['codigomateria']."'
                            GROUP by m.codigomateria,g.idgrupo
                            order by cm.nombrecarrera,m.nombremateria";
                        $detalleest= $db->Execute($query_detalleest);
                        $totalRows_detalleest= $detalleest->RecordCount();
                        $row_detalleest= $detalleest->FetchRow();  //m.codigocarrera='$codigocarrera'                            and
                        ?>

                        <td id="tdtitulogris">
                            <table  border="1" cellpadding="3" cellspacing="3">
                                <tr>
                                    <td bgcolor="#C5D5D6" align="center"><b>Grupo</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Estudiantes</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Perdieron C1</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>%Perdieron C1</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia C1</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Perdieron C2</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>%Perdieron C2</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia C2</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Perdieron C3</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>%Perdieron C3</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia C3</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Perdieron C4</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>%Perdieron C4</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia C4</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>#Perdieron Definitiva</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>%Perdieron Definitiva</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Definitiva</b></td>
                                </tr>


                        <?php
                        if($totalRows_detalleest > 0){
                            $totalestudiantes=0;
                            $totalPC1=0;
                            $totalPC2=0;
                            $totalPC3=0;
                            $totalPC4=0;
                            $totalPCD=0;

                            do{
                                $totalestudiantes=$totalestudiantes+$row_detalleest['Total_Alumnos'];
                                $totalPC1=$totalPC1+$row_detalleest['Perdieron_Corte1'];
                                $totalPC2=$totalPC2+$row_detalleest['Perdieron_Corte2'];
                                $totalPC3=$totalPC3+$row_detalleest['Perdieron_Corte3'];
                                $totalPC4=$totalPC4+$row_detalleest['Perdieron_Corte4'];
                                $totalPCD=$totalPCD+$row_detalleest['Perdieron_Definitiva'];
                                ?>

                                    <tr>
                                        <td><?php echo $row_detalleest['Grupo']; ?></td>
                                        <td><?php echo $row_detalleest['Total_Alumnos']; ?></td>
                                        <td><?php echo $row_detalleest['Perdieron_Corte1']; ?></td>
                                        <td bgcolor="<?php if($row_detalleest['%Perdieron_corte1'] >65){ ?>#FC1251<?php }
                                        else if($row_detalleest['%Perdieron_corte1'] >40 && $row_detalleest['%Perdieron_corte1'] <=65){ ?>#FFFD5F<?php }
                                        else if($row_detalleest['%Perdieron_corte1'] <=40){ ?>#00D100<?php }?>">
                                        <?php echo $row_detalleest['%Perdieron_corte1']."%"; ?>
                                        </td>
                                        <td><?php echo $row_detalleest['estrategiac1']."&nbsp;"; ?></td>
                                        <td><?php echo $row_detalleest['Perdieron_Corte2']; ?></td>
                                        <td bgcolor="<?php if($row_detalleest['%Perdieron_corte2'] >65){ ?>#FC1251<?php }
                                        else if($row_detalleest['%Perdieron_corte2'] >40 && $row_detalleest['%Perdieron_corte2'] <=65){ ?>#FFFD5F<?php }
                                        else if($row_detalleest['%Perdieron_corte2'] <=40){ ?>#00D100<?php }?>">
                                        <?php echo $row_detalleest['%Perdieron_corte2']; ?>
                                        </td>
                                        <td><?php echo $row_detalleest['estrategiac2']."&nbsp;"; ?></td>
                                        <td><?php echo $row_detalleest['Perdieron_Corte3']; ?></td>
                                        <td bgcolor="<?php if($row_detalleest['%Perdieron_corte3'] >65){ ?>#FC1251<?php }
                                        else if($row_detalleest['%Perdieron_corte3'] >40 && $row_detalleest['%Perdieron_corte3'] <=65){ ?>#FFFD5F<?php }
                                        else if($row_detalleest['%Perdieron_corte3'] <=40){ ?>#00D100<?php }?>">
                                        <?php echo $row_detalleest['%Perdieron_corte3']; ?>
                                        </td>
                                        <td><?php echo $row_detalleest['estrategiac3']."&nbsp;"; ?></td>
                                        <td><?php echo $row_detalleest['Perdieron_Corte4']; ?></td>
                                        <td bgcolor="<?php if($row_detalleest['%Perdieron_corte4'] >65){ ?>#FC1251<?php }
                                        else if($row_detalleest['%Perdieron_corte4'] >40 && $row_detalleest['%Perdieron_corte4'] <=65){ ?>#FFFD5F<?php }
                                        else if($row_detalleest['%Perdieron_corte4'] <=40){ ?>#00D100<?php }?>">
                                        <?php echo $row_detalleest['%Perdieron_corte4']; ?>
                                        </td>
                                        <td><?php echo $row_detalleest['estrategiac4']."&nbsp;"; ?></td>
                                        <td><?php echo $row_detalleest['Perdieron_Definitiva']; ?></td>
                                        <td bgcolor="<?php if($row_detalleest['%Perdieron_definitiva'] >65){ ?>#FC1251<?php }
                                        else if($row_detalleest['%Perdieron_definitiva'] >40 && $row_detalleest['%Perdieron_definitiva'] <=65){ ?>#FFFD5F<?php }
                                        else if($row_detalleest['%Perdieron_definitiva'] <=40){ ?>#00D100<?php }?>">
                                        <?php echo $row_detalleest['%Perdieron_definitiva']; ?>
                                        </td> 
                                        <td><?php echo $row_detalleest['estrategiaDF']."&nbsp;"; ?></td>

                                    </tr>


                    <?php
                            }while($row_detalleest= $detalleest->FetchRow());
                        }
                        else{
                    ?>
                                 <tr>
                                     <td id="tdtitulogris" colspan="17" align="center">La Asignatura no tiene grupos.</td>
                                 </tr>
                    <?php } ?>
                                 <tr>
                                    <td bgcolor="#C5D5D6" align="center"><b>Total Grupos</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.Estudiantes</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.#Perdieron C1</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>T.%Perdieron C1</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Materia C1</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.#Perdieron C2</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>T.%Perdieron C2</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Materia C2</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.#Perdieron C3</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>T.%Perdieron C3</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Materia C3</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.#Perdieron C4</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>T.%Perdieron C4</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Materia C4</b></td>
                                    <td bgcolor="#c5d5d6" align="center"><b>T.#Perdieron Definitiva</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>T.%Perdieron Definitiva</b></td>
                                    <td bgcolor="#C5D5D6" align="center"><b>Estrategia Definitva Materia </b></td>
                                </tr>
                                <?php if($totalRows_detalleest > 0){ ?>
                                <tr>
                                    <?php
                                    $total_porc1=round($totalPC1/$totalestudiantes*100);
                                    $total_porc2=round($totalPC2/$totalestudiantes*100);
                                    $total_porc3=round($totalPC3/$totalestudiantes*100);
                                    $total_porc4=round($totalPC4/$totalestudiantes*100);
                                    $total_porcD=round($totalPCD/$totalestudiantes*100);
                                    ?>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalRows_detalleest; ?></b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalestudiantes; ?></b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalPC1; ?></b></td>
                                    <td bgcolor="<?php if($total_porc1 >90){ ?>#FC1251<?php }
                                        else if($total_porc1 >50 && $total_porc1 <=90){ ?>#FFFD5F<?php }
                                        else if($total_porc1 <=50){ ?>#00D100<?php }?>">
                                        <b><?php echo $total_porc1."%"; ?></b>
                                    </td>
                                    <td bgcolor="#DCDCDC" align="center"><b>&nbsp;</b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalPC2; ?></b></td>
                                    <td bgcolor="<?php if($total_porc2 >90){ ?>#FC1251<?php }
                                        else if($total_porc2 >50 && $total_porc2 <=90){ ?>#FFFD5F<?php }
                                        else if($total_porc2 <=50){ ?>#00D100<?php }?>">
                                        <b><?php echo $total_porc2."%"; ?></b>
                                    </td>
                                    <td bgcolor="#DCDCDC" align="center"><b>&nbsp;</b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalPC3; ?></b></td>
                                    <td bgcolor="<?php if($total_porc3 >90){ ?>#FC1251<?php }
                                        else if($total_porc3 >50 && $total_porc3 <=90){ ?>#FFFD5F<?php }
                                        else if($total_porc3 <=50){ ?>#00D100<?php }?>">
                                        <b><?php echo $total_porc3."%"; ?></b>
                                    </td>
                                    <td bgcolor="#DCDCDC" align="center"><b>&nbsp;</b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalPC4; ?></b></td>
                                    <td bgcolor="<?php if($total_porc4 >90){ ?>#FC1251<?php }
                                        else if($total_porc4 >50 && $total_porc4 <=90){ ?>#FFFD5F<?php }
                                        else if($total_porc4 <=50){ ?>#00D100<?php }?>">
                                        <b><?php echo $total_porc4."%"; ?></b>
                                    </td>
                                    <td bgcolor="#DCDCDC" align="center"><b>&nbsp;</b></td>
                                    <td bgcolor="#DCDCDC" align="center"><b><?php echo $totalPCD; ?></b></td>
                                    <td bgcolor="<?php if($total_porcD >90){ ?>#FC1251<?php }
                                        else if($total_porcD >50 && $total_porcD <=90){ ?>#FFFD5F<?php }
                                        else if($total_porcD <=50){ ?>#00D100<?php }?>">
                                        <b><?php echo $total_porcD."%"; ?></b>
                                    </td>
                                    <td bgcolor="#DCDCDC" align="center"><b>&nbsp;</b></td>
                                </tr>
                                <?php } else { ?>
                                        <tr>
                                            <td id="tdtitulogris" colspan="17" align="center">&nbsp;</td>
                                        </tr>
                                        <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <?php
                    }while($row_materiasplanestudio = $materiasplanestudio->FetchRow());
                }while($row_selsemestre2 = $selsemestre2->FetchRow());
                ?>
            </table>    

        </form>
    </body>
</html>
<?php 
}
?>