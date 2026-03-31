<?php

    //Para correr 1 vez al día tipo 1am en /serviciosacademicos/mgi/datos/crons/actualizarUnidadesAcademicas.php
    session_start(); 
    $_SESSION['MM_Username'] = 'estudiante';

    include("../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $currentdate  = date("Y-m-d H:i:s");
    
    //busco el periodo actual
    $sql = "SELECT * FROM periodo WHERE fechainicioperiodo<='".$currentdate."' AND 
                fechavencimientoperiodo>='".$currentdate."' ";
    $periodoActual = $db->GetRow($sql); 
    $periodo = $periodoActual["codigoperiodo"];
    
    //obtener todas las carreras activas de pregrado y posgrado
    $sql = "SELECT * FROM carrera WHERE codigomodalidadacademica IN ('200','300') AND 
        fechavencimientocarrera>'".$currentdate."' ORDER BY nombrecarrera ASC";
    
    $carreras = $db->Execute($sql);
    
    while ($row = $carreras->FetchRow()) { 
        //obteniendo los planes de estudios activos para cada carrera
        $sql = "SELECT * FROM planestudio WHERE codigocarrera='".$row["codigocarrera"]."' AND 
            fechavencimientoplanestudio>'".$currentdate."' AND codigoestadoplanestudio=100";
        
        $planes = $db->Execute($sql);
        while ($rowPlanes = $planes->FetchRow()) { 
            //calcular los datos del plan de estudio
            
            //obtengo todas las materias que sean fundamentales
            $sqlCalculo = "select Count(DISTINCT codigomateria) as total, SUM(numerocreditosdetalleplanestudio) as totalCreditos from detalleplanestudio 
                WHERE codigoformacionacademica=100 and idplanestudio='".$rowPlanes["idplanestudio"]."' ";
            
            $result = $db->GetRow($sqlCalculo);
            $numFundamental = "".$result["total"];
            if($result["totalCreditos"]!==NULL){
                $numCreditosFundamental = "".$result["totalCreditos"];
            } else {
                $numCreditosFundamental = "0";
            }
            
            //obtengo todas las materias que sean diversificados
            $sqlCalculo = "select Count(DISTINCT codigomateria) as total, SUM(numerocreditosdetalleplanestudio) as totalCreditos from detalleplanestudio 
                WHERE codigoformacionacademica=200 and idplanestudio='".$rowPlanes["idplanestudio"]."' ";
            $result = $db->GetRow($sqlCalculo);
            $numD = "".$result["total"];
            if($result["totalCreditos"]!==NULL){
                $numCreditosD = "".$result["totalCreditos"];
            } else {
                $numCreditosD = "0";
            }
            //echo $sqlCalculo."<br/><br/>";
            
            //obtengo todas las materias que sean complementarios
            $sqlCalculo = "select Count(DISTINCT codigomateria) as total, SUM(numerocreditosdetalleplanestudio) as totalCreditos from detalleplanestudio 
                WHERE codigoformacionacademica=300 and idplanestudio='".$rowPlanes["idplanestudio"]."' ";
            $result = $db->GetRow($sqlCalculo);
            $numC = "".$result["total"];
            if($result["totalCreditos"]!==NULL){
                $numCreditosC = "".$result["totalCreditos"];
            } else {
                $numCreditosC = "0";
            }
            
            //por cada plan verifico si ya existe el dato y solo toca actualizarla
            $result = $utils->getDataEntityByQuery("verificarformUnidadesAcademicasPlanEstudio","codigoperiodo",$periodo,
                    "siq_",$row["codigocarrera"],$rowPlanes["idplanestudio"]);
            
            $fields = array();
            if(count($result)>0){
                $result2 = $utils->getDataEntityByQuery("formUnidadesAcademicasPlanEstudio","codigoperiodo",$periodo,
                    "siq_",$row["codigocarrera"],$rowPlanes["idplanestudio"]);
                if($result["vnumAsignaturasFundamental"]==0){
                    $fields["numAsignaturasFundamental"] = $numFundamental;
                    $fields["numCreditosFundamental"] = $numCreditosFundamental;
                }
                if($result["vnumAsignaturasDiversificada"]==0){
                    $fields["numAsignaturasDiversificada"] = $numD;
                    $fields["numCreditosDiversificada"] = $numCreditosD;
                }
                if($result["vnumAsignaturasElectivas"]==0){
                    $fields["numAsignaturasElectivas"] = $numC;
                    $fields["numCreditosElectivas"] = $numCreditosC;
                }
                $fields["idsiq_formUnidadesAcademicasPlanEstudio"] = $result2["idsiq_formUnidadesAcademicasPlanEstudio"];
                $result = $utils->processData("update","formUnidadesAcademicasPlanEstudio",$fields,false);
            } else {
                $fields["codigoperiodo"] = $periodo;
                $fields["codigocarrera"] = $row["codigocarrera"];
                $fields["planEstudio"] = $rowPlanes["idplanestudio"];
                $fields["numAsignaturasFundamental"] = $numFundamental;
                $fields["numCreditosFundamental"] = $numCreditosFundamental;
                    $fields["numAsignaturasDiversificada"] = $numD;
                    $fields["numCreditosDiversificada"] = $numCreditosD;
                    $fields["numAsignaturasElectivas"] = $numC;
                    $fields["numCreditosElectivas"] = $numCreditosC;
                $result = $utils->processData("save","formUnidadesAcademicasPlanEstudio",$fields,false);
                
                $fields = array();
                $fields["vnumAsignaturasFundamental"] = 0;
                $fields["vnumAsignaturasDiversificada"] = 0;
                $fields["vnumAsignaturasElectivas"] = 0;
                $fields["codigoperiodo"] = $periodo;
                $fields["codigocarrera"] = $row["codigocarrera"];
                $fields["planEstudio"] = $rowPlanes["idplanestudio"];
                $result = $utils->processData("save","verificarformUnidadesAcademicasPlanEstudio",$fields,false);
            }
        }
    }
    
    
?>
