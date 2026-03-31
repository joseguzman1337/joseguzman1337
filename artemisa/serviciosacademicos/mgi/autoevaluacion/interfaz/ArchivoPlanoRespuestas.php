<?php
include("../../templates/templateAutoevaluacion.php");
$db =writeHeaderBD();
$id_instrumento=$_REQUEST['id_ins'];







header("Content-type: application/x-msdownload");
header("Content-Disposition: filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");




$sql_pre="SELECT pr.titulo, pr.idsiq_Atipopregunta, pr.idsiq_Apregunta, con.nombre
FROM siq_Ainstrumento as ins 
inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)
inner join siq_Ainstrumentoconfiguracion as con on (ins.idsiq_Ainstrumentoconfiguracion=con.idsiq_Ainstrumentoconfiguracion)
where ins.codigoestado=100 
and pr.codigoestado=100 and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' order by pr.idsiq_Apregunta";//SQL de Pregutas o titulos



$data_pre= $db->Execute($sql_pre);

$C_Preg = $data_pre->GetArray();

$coun_Pre=count($C_Preg)+5; 
?>
<table border='1'>
<tr>
<td colspan='".$coun_Pre."' style='background-color:#3E4729; color: white '>
<b><center>Universidad el Bosque, Resultados encuesta <?PHP echo utf8_decode($C_Preg[0]['nombre'])?></center></b>
</td>
</tr>
<tr>
<td>Participante</td>
<td>Tipo de Participante</td>
<td>Unidad Academica</td>
<td>Edad</td>
<td>Genero</td>
<?PHP 
$cp=0; 
foreach($data_pre as $dt){//coloca las preguntas
     $titulo=$dt['titulo'];
     $titulo=str_replace('<br>', '', $titulo);
     ?>
     <td><?PHP echo utf8_decode($titulo)?></td>
     <?PHP
    $cp++;
}
?>
</tr>
<?PHP
/*echo "<tr>";
for ($i=0; $i<5; $i++){//espacio para los nombres de las variables
        echo "<td>&nbsp;</td>";
}
foreach($data_pre as $dt){//coloca el id de la pregunta
        $ind='';
        $id_preg=$dt['idsiq_Apregunta'];
        $preg[]=$id_preg;
        echo "<td>".$id_preg."</td>";
        $sql_ind="select pin.idsiq_Apreguntaindicador, pin.idsiq_Apregunta, pin.disiq_indicador, ige.codigo
                    from siq_Apreguntaindicador as pin
                    inner join siq_indicador as ind on (pin.disiq_indicador=ind.idsiq_indicador)
                    inner join siq_indicadorGenerico as ige on (ind.idIndicadorGenerico=ige.idsiq_indicadorGenerico)
                    where pin.idsiq_Apregunta='".$id_preg."'
                    and pin.codigoestado='100' order by pin.idsiq_Apregunta";
       $data_in= $db->Execute($sql_ind);
       foreach($data_in as $dt_in){//coloca los indicadores que tiene esa pregunta
           $ind.=$dt_in['codigo'].',';
       }
       $ind = trim($ind, ',');
       $preg_in[$id_preg]=$ind;
       
       
}
foreach($data_in as $dt_in){//coloca los indicadores que tiene esa pregunta
	$ind.=$dt_in['codigo'].',';
}
$ind = trim($ind, ',');
$preg_in[$id_preg]=$ind;
echo "</tr>";
echo "<tr>";
for ($i=0; $i<5; $i++){//espacio de las variables en blanco
        echo "<td>&nbsp;</td>";
}
for($i=0;$i<count($C_Preg);$i++){//pinta el codigo del indicador
    $id_preg=$C_Preg[$i]['idsiq_Apregunta'];
    if (empty($preg_in[$id_preg])){
        echo "<td>&nbsp;</td>";
    }else{
        echo "<td>".$preg_in[$id_preg]."</td>";
    }
    
}
echo "</tr>";*/

$sql_user="select cedula, usuariocreacion, codigorol, nombrerol 
           from siq_Arespuestainstrumento 
           inner join usuario on (usuariocreacion=idusuario)
           inner join rol on (codigorol=idrol)
           where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by usuariocreacion 
           union
           select cedula, usuariocreacion, '' as codigorol, '' nombrerol
           from siq_Arespuestainstrumento 
           where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by cedula  ";//SQL de usuarios tipos y id's


//echo $sql_user;
$data_res= $db->Execute($sql_user);

foreach($data_res as $dt_res){//pinta los resultados
    $cedula=$dt_res['cedula'];
    $usuario=$dt_res['usuariocreacion'];
    $nombrerol=$dt_res['nombrerol'];
    ?>
    <tr>
    <?PHP
    if (empty($usuario)){
        $tit=$cedula;
    }else{
        $sql_user="select numerodocumento from usuario where idusuario='".$usuario."' ";
        $data_user= $db->Execute($sql_user);
        $C_User = $data_user->GetArray();
        $tit=$C_User[0]['numerodocumento'];
    }
    ?>
    <td><?PHP echo $tit?></td><!--pinta el numero de documento-->
    <?PHP
    if (!empty($nombrerol)){//pinta el tipo de participante
    ?>
        <td><?PHP echo $nombrerol?></td>
    <?PHP     
    }else{
        ?>
        <td>&nbsp;</td>
        <?PHP
    }
    for ($i=0; $i<3; $i++){//las variables
        ?>
        <td>&nbsp;</td>
        <?PHP
    }
    if (empty($usuario)){//si busca por la cedula el el usuario de creacion
        $whe=" and res.cedula='".$cedula."' ";
    }else{
        $whe=" and res.usuariocreacion='".$usuario."' ";
    }
    for($i=0;$i<count($C_Preg);$i++){
        
       $id_preg=$C_Preg[$i]['idsiq_Apregunta'];
        
       $sql_res="SELECT res.idsiq_Arespuestainstrumento, res.idsiq_Apregunta, res.idsiq_Apreguntarespuesta,res.preg_abierta
                FROM siq_Arespuestainstrumento as res 
                 
                WHERE res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ".$whe." and res.idsiq_Apregunta='".$id_preg."' 
                and res.codigoestado='100'";
        
          
                
		//echo $sql_res;
        $data_resp= $db->Execute($sql_res);
      	$C_Resp = $data_resp->GetArray();
        
        
        
        $can=count($C_Resp);
        $respuesta=$C_Resp[0]['idsiq_Apreguntarespuesta'];
        $preg_abierta=$C_Resp[0]['preg_abierta'];
        
        $SQl_r='SELECT respuesta, valor FROM siq_Apreguntarespuesta WHERE idsiq_Apreguntarespuesta ="'.$respuesta.'"';
        
        if($Respuesta_Text=&$db->Execute($SQl_r)===false){
            echo 'Error en el SQL del texto de la respuesta...<br><br>'.$SQl_r;
            die;
        }
      
        $Respuesta_Texto = $Respuesta_Text->fields['respuesta'];
        $Valor           = $Respuesta_Text->fields['valor'];
        
        if ($can==0){
            echo "<td>&nbsp;</td>";
        }else if ($can==1){
            if (!empty($respuesta) and empty($preg_abierta)){
                
                //echo 'Texto->'.$Respuesta_Texto.'<br><br>Valor->'.$Valor;
                
                if($Respuesta_Texto){
                    $Texto_View = $Respuesta_Texto;
                }else{
                    $Texto_View = $Valor;
                }
              echo "<td>".$Texto_View."</td>";
            }
            if(empty($respuesta) and !empty($preg_abierta)){
                echo "<td>".$preg_abierta."</td>";
            }
            if(empty($respuesta) and empty($preg_abierta)){
                
                if($Respuesta_Texto){
                    $Texto_View = $Respuesta_Texto;
                }else{
                    $Texto_View = $Valor;
                }
                
            	echo "<td>".utf8_decode($Texto_View)."</td>";
            }
        }else{
            $res_mul='';
            for($j=0;$j<count($C_Resp);$j++){
                //echo $C_Resp[j]['respuesta'].'<br>';
                
                
                
                $SQl_r='SELECT respuesta, valor FROM siq_Apreguntarespuesta WHERE idsiq_Apreguntarespuesta ="'.$C_Resp[$j]['idsiq_Apreguntarespuesta'].'"';
        
                if($Respuesta_Text=&$db->Execute($SQl_r)===false){
                    echo 'Error en el SQL del texto de la respuesta...<br><br>'.$SQl_r;
                    die;
                }
        
                $Respuesta_Texto = $Respuesta_Text->fields['respuesta'];
                $Valor           = $Respuesta_Text->fields['valor'];
                
                if($Respuesta_Texto){
                    $Texto_View = $Respuesta_Texto;
                }else{
                    $Texto_View = $Valor;
                }
                
                if ($j==0) $res_mul=utf8_decode($Texto_View);
                if ($j>0) $res_mul.=','.utf8_decode($Texto_View);
           }
            
            echo "<td>".$res_mul."</td>";
        }//else
       
    }//for($i=0;$i<count($C_Preg);$i++)
   
}//foreach grande
  	
echo "</tr>";

echo "</table>";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

writeFooter();
?>
