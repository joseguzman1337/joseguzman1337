<?php

//Para correr 1 vez al día tipo 1am en /serviciosacademicos/mgi/datos/crons/modalidadesAulasVirtuales.php
    session_start(); 
    die;
    $_SESSION['MM_Username'] = 'admintecnologia';

    include("../templates/template.php");
    $db = getBD();
    
    //actualizar las que no estan en curso y supuestamente no se han acabado
    $sql = "UPDATE `nivelacademicodocente` SET `encursonivelacademicodocente`=1 WHERE `idnivelacademicodocente` IN 
       ( 
            SELECT idnivelacademicodocente FROM 
            (
                SELECT n.idnivelacademicodocente FROM sala.nivelacademicodocente n
                inner join sala.tiponivelacademico t ON t.codigotiponivelacademico=n.codigotiponivelacademico AND t.codigoestado=100 
                WHERE n.encursonivelacademicodocente = 0 AND n.fechafinalnivelacademicodocente>NOW()
            ) AS tmptable
        )  ";
    
    $result = $db->Execute($sql);
    //var_dump($result);
    
    //actualizar todos los cursos que tienen disque en curso y resulta que ya se acabaron
    $sql = "UPDATE `nivelacademicodocente` SET `encursonivelacademicodocente`=0 WHERE `idnivelacademicodocente` IN 
       ( 
            SELECT idnivelacademicodocente FROM 
            (
                SELECT n.idnivelacademicodocente FROM sala.nivelacademicodocente n
                inner join sala.tiponivelacademico t ON t.codigotiponivelacademico=n.codigotiponivelacademico AND t.codigoestado=100 
                WHERE n.encursonivelacademicodocente = 1 AND n.fechafinalnivelacademicodocente<NOW()
            ) AS tmptable
        ) ";
    
    $result = $db->Execute($sql);
    //var_dump($result);
    
$sql = "SELECT *
FROM (
SELECT n.iddocente, d.numerodocumento, n.idnivelacademicodocente, n.codigotiponivelacademico, n.fechafinalnivelacademicodocente,
n.encursonivelacademicodocente, t.nombretiponivelacademico, t.codigosniestiponivelacademico FROM nivelacademicodocente n
inner join tiponivelacademico t ON t.codigotiponivelacademico=n.codigotiponivelacademico AND t.codigoestado=100 
inner join docente d ON d.iddocente=n.iddocente 
WHERE n.encursonivelacademicodocente = 0 
order by t.codigosniestiponivelacademico ASC, n.fechafinalnivelacademicodocente DESC ) as my_table_tmp
GROUP BY iddocente
order by codigosniestiponivelacademico ASC, fechafinalnivelacademicodocente DESC";

$docentesFormacion = $db->GetAll($sql);
$total = count($docentesFormacion);

//echo "<pre>";print_r($docentesFormacion);

$contadorDoctorado = 0;
$contadorMaestria = 0;
$contadorEspecializacion = 0;
$contadorProfesional = 0;
$contadorTecnico = 0;
$contadorLicenciado = 0;
$contadorOtros = 0;

foreach ($docentesFormacion as $row) {
    //buscar el docente como personal de la universidad
    $sqlPersonal = "SELECT * FROM personalUniversidadPeopleSoft WHERE numeroDocumento='".$row["numerodocumento"]."'";
    $result = $db->GetAll($sqlPersonal);
    
    //si lo encuentra es que todavia trabaja para la u
    if(count($result)>0 && $result!==false){
        $sqlExecute = "UPDATE `sala`.`personalUniversidadPeopleSoft` SET `tipoEmpleado`='Académico' 
            WHERE `idpersonalUniversidadPeopleSoft`='".$result['idpersonalUniversidadPeopleSoft']."' ";
        $db->Execute($sqlExecute);
        
        if($row["codigosniestiponivelacademico"]==="01" || $row["codigosniestiponivelacademico"]==="02"){
            $contadorDoctorado = $contadorDoctorado + 1;
        } else if($row["codigosniestiponivelacademico"]==="03"){
            $contadorMaestria = $contadorMaestria + 1;
        } else if($row["codigosniestiponivelacademico"]==="04"){
            $contadorEspecializacion = $contadorEspecializacion + 1;
        } else if($row["codigosniestiponivelacademico"]==="05"){
            $contadorProfesional = $contadorProfesional + 1;
        } else if($row["codigosniestiponivelacademico"]==="06"){
            $contadorLicenciado = $contadorLicenciado + 1;
        } else if($row["codigosniestiponivelacademico"]==="07" || $row["codigosniestiponivelacademico"]==="08"){
            $contadorTecnico = $contadorTecnico + 1;
        } else {
            $contadorOtros = $contadorOtros + 1;
        }
        
    }
}
echo "<pre>";print_r($contadorDoctorado);
echo "<pre>";print_r($contadorMaestria);
echo "<pre>";print_r($contadorEspecializacion);
echo "<pre>";print_r($contadorProfesional);
echo "<pre>";print_r($contadorLicenciado);
echo "<pre>";print_r($contadorTecnico);
echo "<pre>";print_r($contadorOtros);
echo "<pre>";print_r($total);
echo "<pre>";print_r($contadorOtros+$contadorTecnico+$contadorLicenciado+$contadorProfesional+$contadorEspecializacion+$contadorMaestria+$contadorDoctorado);

//DOCENTES EN FORMACION
$sql = "SELECT *
FROM (
SELECT n.iddocente, d.numerodocumento, n.idnivelacademicodocente, n.codigotiponivelacademico, n.fechafinalnivelacademicodocente,
n.encursonivelacademicodocente, t.nombretiponivelacademico, t.codigosniestiponivelacademico FROM nivelacademicodocente n
inner join tiponivelacademico t ON t.codigotiponivelacademico=n.codigotiponivelacademico AND t.codigoestado=100 
inner join docente d ON d.iddocente=n.iddocente 
WHERE n.encursonivelacademicodocente = 1 
order by t.codigosniestiponivelacademico ASC, n.fechafinalnivelacademicodocente DESC ) as my_table_tmp
GROUP BY iddocente
order by codigosniestiponivelacademico ASC, fechafinalnivelacademicodocente DESC";

$docentesEnFormacion = $db->GetAll($sql);

echo "<pre>";print_r($docentesEnFormacion);
?>
