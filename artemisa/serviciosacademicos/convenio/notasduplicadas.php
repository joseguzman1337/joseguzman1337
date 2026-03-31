<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');

    $db = getBD();
?>
<label><strong>detallenota</strong></label>
<table border="2" align="center">
<tr>
    <td>#</td>
    <td>idgrupo</td>
    <td>idcorte</td>
    <td>documento</td>
    <td>carrera</td>
    <td>codigomateria</td>
    <td>nota</td>
    <td>codigoestado</td>
    <td>count</td>
</tr>
<?php
    $i = 1;
$sqlcontador = "SELECT  idgrupo, idcorte, codigoestudiante, codigomateria, nota, codigoestado, count(*) FROM detallenota GROUP BY idgrupo, idcorte, codigoestudiante, codigomateria, nota, codigoestado DESC
HAVING count(*) > 1";
$valoresduplicados = $db->execute($sqlcontador);
foreach($valoresduplicados as $datosduplicados)
{
    if($datosduplicados['count(*)'] == 2 )
    {
        $sqldelete = "DELETE FROM detallenota WHERE idgrupo = '".$datosduplicados['idgrupo']."' 
        AND idcorte = '".$datosduplicados['idcorte']."' AND codigoestudiante = '".$datosduplicados['codigoestudiante']."' 
        AND codigomateria = '".$datosduplicados['codigomateria']."' AND nota = '".$datosduplicados['nota']."' AND codigoestado = '".$datosduplicados['codigoestado']."' LIMIT 1";
        $db->execute($sqldelete);
        
        $sqldocumento= "SELECT eg.numerodocumento, c.nombrecarrera FROM estudiante e join carrera c on c.codigocarrera = e.codigocarrera 
        JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE e.codigoestudiante = '".$datosduplicados['codigoestudiante']."'";
        $valordocumento = $db->execute($sqldocumento);
        foreach($valordocumento as $datosdocumento){
            $docuemento = $datosdocumento['numerodocumento'];
            $carrera = $datosdocumento['nombrecarrera'];
        }
      ?>
      <tr>
        <td><?php echo $i?></td>
        <td><?php echo $datosduplicados['idgrupo']?></td>
        <td><?php echo $datosduplicados['idcorte']?></td>
        <td><?php echo $sqldocumento?></td>
        <td><?php echo $carrera?></td>
        <td><?php echo $datosduplicados['codigomateria']?></td>
        <td><?php echo $datosduplicados['nota']?></td>
        <td><?php echo $datosduplicados['codigoestado']?></td>
        <td><?php echo $datosduplicados['count(*)']?></td>
      </tr>  
    <?php     
    }else{
        
        if($datosduplicados['count(*)'] == 3 )
    {
        $sqldelete = "DELETE FROM detallenota WHERE idgrupo = '".$datosduplicados['idgrupo']."' 
        AND idcorte = '".$datosduplicados['idcorte']."' AND codigoestudiante = '".$datosduplicados['codigoestudiante']."' 
        AND codigomateria = '".$datosduplicados['codigomateria']."' AND nota = '".$datosduplicados['nota']."' AND codigoestado = '".$datosduplicados['codigoestado']."' LIMIT 2";
        $db->execute($sqldelete);
        
         $sqldocumento= "SELECT eg.numerodocumento, c.nombrecarrera FROM estudiante e join carrera c on c.codigocarrera = e.codigocarrera 
        JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE e.codigoestudiante = '".$datosduplicados['codigoestudiante']."'";
        $valordocumento = $db->execute($sqldocumento);
        foreach($valordocumento as $datosdocumento){
            $docuemento = $datosdocumento['numerodocumento'];
            $carrera = $datosdocumento['nombrecarrera'];
        }
        ?>
      <tr>
        <td><?php echo $i?></td>
        <td><?php echo $datosduplicados['idgrupo']?></td>
        <td><?php echo $datosduplicados['idcorte']?></td>
        <td><?php echo $sqldocumento?></td>
        <td><?php echo $carrera?></td>
        <td><?php echo $datosduplicados['codigomateria']?></td>
        <td><?php echo $datosduplicados['nota']?></td>
        <td><?php echo $datosduplicados['codigoestado']?></td>
        <td><?php echo $datosduplicados['count(*)']?></td>
      </tr> 
    <?php 
    }
    }
    $i++;
}
?>
</table>
<br />
<label><strong>notahistorico</strong></label>
<table border="2" align="center">
<tr>
<td>#</td>
<td>codigoperiodo</td>
<td>documento</td>
<td>carrera</td>
<td>codigoestadonotahistorico</td>
<td>codigomateria</td>
<td>notadefinitiva</td>
<td>count(*)</td>

</tr>
<?php
$sqlduplicadoshistorico = "SELECT codigoperiodo, codigoestudiante, codigoestadonotahistorico, codigomateria, notadefinitiva, fechaprocesonotahistorico, count(*)
FROM notahistorico where codigoestadonotahistorico = '100' GROUP BY codigoperiodo, codigoestudiante, codigoestadonotahistorico, codigomateria, notadefinitiva, fechaprocesonotahistorico DESC
HAVING count(*) > 1 ORDER BY codigoperiodo ASC ";
$i=1;
$valoresduplicadoshistorico = $db->execute($sqlduplicadoshistorico);
foreach($valoresduplicadoshistorico as $datosduplicadoshistorico)
{
     if($datosduplicadoshistorico['count(*)'] == 2 )
    {
        $sqlupdate = "update notahistorico set codigoestadonotahistorico = '200' where codigoperiodo = '".$datosduplicadoshistorico['codigoperiodo']."'
         and codigoestudiante = '".$datosduplicadoshistorico['codigoestudiante']."' and codigoestadonotahistorico = '".$datosduplicadoshistorico['codigoestadonotahistorico']."'
          and codigomateria= '".$datosduplicadoshistorico['codigomateria']."' and notadefinitiva = '". $datosduplicadoshistorico['notadefinitiva']."' limit 1";
        $db->execute($sqlupdate);
        
        $sqldocumento2= "SELECT eg.numerodocumento, c.nombrecarrera FROM estudiante e join carrera c on c.codigocarrera = e.codigocarrera 
        JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE e.codigoestudiante = '".$datosduplicadoshistorico['codigoestudiante']."'";
        $valordocumento2 = $db->execute($sqldocumento2);
        foreach($valordocumento2 as $datosdocumento2)
        {
            $docuemento2 = $datosdocumento2['numerodocumento'];
            $carrera2 = $datosdocumento2['nombrecarrera'];
        }
        ?>
        <tr>
        <td><?php echo $i?></td>
        <td><?php echo $datosduplicadoshistorico['codigoperiodo']?> </td>
        <td><?php echo $docuemento2?></td>
        <td><?php echo $carrera2?></td>
        <td><?php echo $datosduplicadoshistorico['codigoestadonotahistorico']?></td>
        <td><?php echo $datosduplicadoshistorico['codigomateria']?></td>
        <td><?php echo $datosduplicadoshistorico['notadefinitiva']?></td>
        <td><?php echo $datosduplicadoshistorico['count(*)']?></td>
        </tr>
    
        <?php
    }else{
        
        if($datosduplicadoshistorico['count(*)'] == 3 )
    {
         $sqlupdate = "update notahistorico set codigoestadonotahistorico = '200' where codigoperiodo = '".$datosduplicadoshistorico['codigoperiodo']."'
         and codigoestudiante = '".$datosduplicadoshistorico['codigoestudiante']."' and codigoestadonotahistorico = '".$datosduplicadoshistorico['codigoestadonotahistorico']."'
          and codigomateria= '".$datosduplicadoshistorico['codigomateria']."' and notadefinitiva = '". $datosduplicadoshistorico['notadefinitiva']."' limit 2";
        $db->execute($sqlupdate);
        
        
         $sqldocumento2= "SELECT eg.numerodocumento, c.nombrecarrera FROM estudiante e join carrera c on c.codigocarrera = e.codigocarrera 
        JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE e.codigoestudiante = '".$datosduplicadoshistorico['codigoestudiante']."'";
        $valordocumento2 = $db->execute($sqldocumento2);
        foreach($valordocumento2 as $datosdocumento2)
        {
            $docuemento2 = $datosdocumento2['numerodocumento'];
            $carrera2 = $datosdocumento2['nombrecarrera'];
        }
        ?>
        <tr>
        <td><?php echo $i?></td>
        <td><?php echo $datosduplicadoshistorico['codigoperiodo']?> </td>
        <td><?php echo $docuemento2?></td>
        <td><?php echo $carrera2?></td>
        <td><?php echo $datosduplicadoshistorico['codigoestadonotahistorico']?></td>
        <td><?php echo $datosduplicadoshistorico['codigomateria']?></td>
        <td><?php echo $datosduplicadoshistorico['notadefinitiva']?></td>
        <td><?php echo $datosduplicadoshistorico['count(*)']?></td>
        </tr>
    
        <?php
        }    
    }
    $i++;
}
?>

</table>
