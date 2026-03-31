<?php

require_once(dirname(__FILE__). "/../../../../../sala/includes/adaptador.php");       
require_once(dirname(__FILE__).'/../../../../consulta/prematricula/descuentos/descuento.php');

class datos_ordenpago {
    var $esMatricula = false;
    var $longFechaValor = 10;
    var $longReferenciaValor = 8;
    var $numeroCuenta = "7709998039933";
    
    function datos_ordenpago($conexion,$codigoestudiante,$numeroordenpago) {
        $this->conexion=$conexion;
        $this->codigoestudiante=$codigoestudiante;
        $this->numeroordenpago=$numeroordenpago;
    }

    public $codigomodalidadacademica;
    function obtener_datos_estudiante() {
        $query_datosestudiante= "select e.semestre,e.idestudiantegeneral, d.tipodocumento, eg.numerodocumento, o.numeroordenpago, d.nombrecortodocumento,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoestudiante, p.semestreprematricula, 
		o.codigoperiodo, c.codigosucursal, c.centrocosto, c.nombrecarrera, e.codigotipoestudiante, c.codigocarrera, c.codigomodalidadacademica,
		o.codigoimprimeordenpago, i.nombreimprimeordenpago, co.nombrecopiaordenpago,o.fechaentregaordenpago
		from estudiante e, ordenpago o, prematricula p, carrera c, documento d, imprimeordenpago i, copiaordenpago co, estudiantegeneral eg
		where e.codigoestudiante = o.codigoestudiante
		and o.numeroordenpago = '$this->numeroordenpago'
		and e.codigoestudiante='$this->codigoestudiante'
		and p.idprematricula = o.idprematricula
		and e.codigocarrera = c.codigocarrera
		and d.tipodocumento = eg.tipodocumento
		and o.codigoimprimeordenpago = i.codigoimprimeordenpago
		and o.codigocopiaordenpago = co.codigocopiaordenpago
		and e.idestudiantegeneral = eg.idestudiantegeneral";
        $operacion=$this->conexion->query($query_datosestudiante);
        $this->estudiante=$operacion->fetchRow();
        $this->semestreprematricula=$this->estudiante['semestreprematricula'];
        $this->codigotipoestudiante=$this->estudiante['codigotipoestudiante'];
        $this->codigosucursal=$this->estudiante['codigosucursal'];
        $this->idestudiantegeneral=$this->estudiante['idestudiantegeneral'];
        $this->codigocarrera=$this->estudiante['codigocarrera'];
        $this->codigomodalidadacademica=$this->estudiante['codigomodalidadacademica'];
        
    } // Fin obtener_datos_estudiante
    public $codigoconcepto;
    function obtener_conceptos() {
     
       //LA SIGUIENTE CONSULTA TRAE CADA UNO DE LOS CONCEPTOS CREADOS PARA LA MISMA ORDEN DE PAGO. 
        $query_datosdetalles= "SELECT
            d.codigoconcepto,
            c.codigotipoconcepto,
            c.nombreconcepto,            
            d.valorconcepto
        FROM
            detalleordenpago d
            INNER JOIN concepto c ON c.codigoconcepto = d.codigoconcepto
            LEFT JOIN AportesBecas ab ON ab.numeroordenpago = d.numeroordenpago
        WHERE
            d.numeroordenpago = '$this->numeroordenpago'
        UNION ALL
        SELECT
        c.codigoconcepto,
        c.codigotipoconcepto,
        c.nombreconcepto,
        vp.valorpecuniario
        FROM AportesBecas ab
        INNER JOIN valorpecuniario vp ON vp.idvalorpecuniario = ab.idvalorpecuniario
        INNER JOIN concepto c ON c.codigoconcepto = vp.codigoconcepto
        WHERE ab.numeroordenpago = '$this->numeroordenpago'
        AND ab.codigoestado = 400";
        $operacion=$this->conexion->query($query_datosdetalles);
        $row_detalles=$operacion->fetchRow();
        $this->codigoconcepto = $row_detalles['codigoconcepto'];
        do {
            if($row_detalles['codigoconcepto'] == '151') {
                $this->esMatricula = true;
            }

                $this->conceptos[]=$row_detalles;
        }
        while($row_detalles=$operacion->fetchRow());
    
    } //Fin obtener_conceptos
    
    function obtener_nuevo_formato(){
        //consulta si la orden tiene aporte becas
        $query_nuevo_formato = "SELECT o.numeroordenpago FROM ordenpago o ".
        " INNER JOIN AportesBecas a ON a.numeroordenpago = o.numeroordenpago ".
        " WHERE o.numeroordenpago = '$this->numeroordenpago' AND a.codigoestado = 400";
        $operacion=$this->conexion->query($query_nuevo_formato);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion['numeroordenpago'];
    }
    
    function fechas_pago() {
        $query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
		from fechaordenpago f
		where f.numeroordenpago = '$this->numeroordenpago'
		order by fechaordenpago";
       $operacion=$this->conexion->query($query_datosfechas);
        $row_operacion=$operacion->fetchRow();
        
       $contador=0;
       $cuentafechas=1;
               
        do {
            $fechas[$contador][]=$row_operacion;
            if(!$this->esMatricula) {
                switch($cuentafechas) {
                    case "1":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "PRIMER PLAZO";
                        break;
                    case "2":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "SEGUNGO PLAZO";
                        break;
                    case "3":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "TERCER PLAZO";
                        break;
                }
            }
            else {
                switch($cuentafechas) {
                    case "1":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "PRIMER PLAZO";
                        $nombreplazo_3= "PRIMER PLAZO CON APORTE";
                        break;
                    case "2":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "SEGUNGO PLAZO";
                        $nombreplazo_3= "SEGUNDO PLAZO CON APORTE";
                        break;
                    case "3":
                        $nombreplazo = $this->headerDescuento($cuentafechas);
                        $nombreplazo_2= "TERCER PLAZO";
                        $nombreplazo_3= "TERCER PLAZO CON APORTE";
                        break;
                }
                
            }
            $fechas[$contador]['nombreplazo']=$nombreplazo;
            $fechas[$contador]['valorapagar']=$row_operacion['valorfechaordenpago'];
            $fechas[$contador]['valorfechaordenpago']=$row_operacion['valorfechaordenpago'];
            $fechas[$contador]['fechaordenpago']=$row_operacion['fechaordenpago'];
            $fechas[$contador]['nombreplazo_2']=$nombreplazo_2;
            if(isset($nombreplazo_3)) {
                $fechas[$contador]['nombreplazo_3'] = $nombreplazo_3;
            }
            
            $contador++;
            $cuentafechas++;
        }
        while($row_operacion=$operacion->fetchRow());
        $this->fechas=$fechas;

        
        return $this->fechas;
        
    }
    
    function obtener_materias() {
        $contador=0;
        $query_datosmaterias= "select d.codigomateria, m.nombremateria
		from detalleprematricula d, materia m
		where d.numeroordenpago = '$this->numeroordenpago'
		and (d.codigoestadodetalleprematricula like '1%')
		and m.codigomateria = d.codigomateria";
        
        $operacion=$this->conexion->query($query_datosmaterias);
        $row_operacion=$operacion->fetchRow();
        do {
            $materias[$contador]['codigomateria']=$row_operacion['codigomateria'];
            $materias[$contador]['nombremateria']=$row_operacion['nombremateria'];
            $contador++;
        }
        while($row_operacion=$operacion->fetchRow());
        $this->materias=$materias;
    
    }

    function armar_referencia() {
        if(preg_match("/^1[0-9]*$/",$this->codigotipoestudiante)) {
            $tipoestudiante = 0;
        }
        else {
            $tipoestudiante = 1;
        }
        $tamanocodigo = strlen($this->idestudiantegeneral);
        if($tamanocodigo < $this->longReferenciaValor) {
            $codigoreferencia = "";
            for($i=$tamanocodigo; $i < $this->longReferenciaValor; $i++) {
                $codigoreferencia = $codigoreferencia."0";
            }
        }
        if($this->semestreprematricula < 10) {
            $semestrereferencia = "0".$this->semestreprematricula;
        }
        else {
            $semestrereferencia = $this->semestreprematricula;
        }
        $codigoreferencia=$codigoreferencia.$this->idestudiantegeneral;
        $this->referencia="0".$codigoreferencia.$this->numeroordenpago;
    }

    function generar_codigobarras_base_credicorp() {
        $contador=0;
        $codigocuenta = "025215";
        foreach($this->fechas as $llave => $valor) {
            $tamanovalor = strlen($valor[$contador]['valorfechaordenpago']);
            if($tamanovalor < $this->longFechaValor) {
                $valorfechareferencia = "";
                for($i=$tamanovalor; $i < $this->longFechaValor; $i++) {
                    $valorfechareferencia = $valorfechareferencia."0";
                }
            }
            else {
                $valorfechareferencia = "";
            }

            $valorfechareferencia = $valorfechareferencia.$valor[$contador]['valorfechaordenpago'];
            $codigobarra = "415".$this->numeroCuenta."8020". $codigocuenta.chr(202)."8020"."2299".
                $this->referencia.chr(202)."3900".$valorfechareferencia.chr(202).
                "96".ereg_replace("-","",$valor[$contador]['fechaordenpago']);
            $array_codigobarra[]=$codigobarra;
        }
        return $array_codigobarra;

    }

    function generar_codigobarras_aportes_credicorp($aporte) {
        $codigocuenta = "025215";
        $contador=0;
        foreach($this->fechas as $llave => $valor) {
            $suma= $valor[$contador]['valorfechaordenpago']+$aporte;
            $tamanovalor = strlen($suma);

            if($tamanovalor < $this->longFechaValor) {
                $valorfechareferencia = "";
                for($i=$tamanovalor; $i < $this->longFechaValor; $i++) {
                    $valorfechareferencia = $valorfechareferencia."0";
                }
            }
            else {
                $valorfechareferencia = "";
            }
            $suma = $valor[$contador]['valorfechaordenpago']+$aporte;
            $suma = $valorfechareferencia.$suma;

            $this->referencia = substr_replace($this->referencia,"1",0,1);
            $codigobarra = "415".$this->numeroCuenta."8020".
                $codigocuenta.chr(202).
                "8020"."2299".
                $this->referencia.chr(202)."3900".
                $suma.chr(202)."96".
                ereg_replace("-","",$valor[$contador]['fechaordenpago']);
            $array_codigobarra[]=$codigobarra;
        }
        return $array_codigobarra;
    }
    
    function generar_titulobarras_base_credicorp() {
        $codigocuenta = "025215";
        $contador=0;
        foreach($this->fechas as $llave => $valor) {
            $tamanovalor = strlen($valor[$contador]['valorfechaordenpago']);

            if($tamanovalor < $this->longFechaValor) {
                $valorfechareferencia = "";
                for($i=$tamanovalor; $i < $this->longFechaValor; $i++) {
                    $valorfechareferencia = $valorfechareferencia."0";
                }
            }
            else {
                $valorfechareferencia= "";
            }
            $valorfechareferencia = $valorfechareferencia.$valor[$contador]['valorfechaordenpago'];

            $titulobarra = "(415)".$this->numeroCuenta."(8020)".$codigocuenta."(8020)2299".
            $this->referencia."(3900)".$valorfechareferencia."(96)".ereg_replace("-","",$valor[$contador]['fechaordenpago']);
            $array_titulobarra[]=$titulobarra;
        }
        return $array_titulobarra;
    }

    function generar_titulobarras_aportes_credicorp($aporte) {
        $codigocuenta = "025215";
        $contador=0;
        foreach($this->fechas as $llave => $valor) {
            $valorfechareferencia= "";
            $suma= $valor[$contador]['valorfechaordenpago']+$aporte;
            $tamanovalor = strlen($suma);

            if($tamanovalor < $this->longFechaValor) {
                for($i=$tamanovalor; $i < $this->longFechaValor; $i++) {
                    $valorfechareferencia = $valorfechareferencia."0";
                }

            }
            else {
                $valorfechareferencia = "";
            }
            $suma = $valor[$contador]['valorfechaordenpago']+$aporte;
            $suma = $valorfechareferencia.$suma;
            $titulobarra = "(415)".$this->numeroCuenta."(8020)".$codigocuenta."(8020)2299".
            $this->referencia."(3900)".$suma."(96)".ereg_replace("-","",$valor[$contador]['fechaordenpago']);
            $array_titulobarra[]=$titulobarra;
        }
        return $array_titulobarra;
    }
 //inicio funcion
    function fechas_pago_aporte($numeroordenpago,$conexion) {
       
       $query = "
            SELECT vp.valorpecuniario
            FROM  valorpecuniario vp  
            INNER JOIN concepto c ON (c.codigoconcepto = vp.codigoconcepto)
            INNER JOIN ordenpago op ON (vp.codigoperiodo = op.codigoperiodo)
            WHERE  vp.codigoestado = 100
                AND c.codigoestado = 100 
                AND c.codigoconcepto = 'C9106' 
                AND op.numeroordenpago = '".$numeroordenpago." '
            ORDER BY vp.idvalorpecuniario DESC 
            LIMIT 0,1";
       //echo $query_datosaporte;exit;

       $operacion=$this->conexion->query($query);
       $row_operacion=$operacion->fetchRow();

      return $row_operacion['valorpecuniario'];
        
    }//fin funcion fechas_pago_aporte
    
    function consulta_aporte($numeroordenpago){
       $sql_aporte = "SELECT COUNT(*) AS 'valor' FROM AportesBecas ab WHERE ab.numeroordenpago = $numeroordenpago AND ab.codigoestado = 400";
       $operacion=$this->conexion->query($sql_aporte);
       $row_operacion=$operacion->fetchRow();

        return $row_operacion['valor'];
    }// function consulta_aporte
    
    function headerDescuento($numeral){       
                      
        $db = Factory::createDbo();
        $descuento = new Descuento($this->numeroordenpago,$this->estudiante['codigoperiodo'],$db);
        return $descuento->visualizarHeaderDescuento($numeral, 'pdf');
    }

    function obtenerSemestre(){
        $numeroordenpago = $this->numeroordenpago;
        $semestreEstudiante = $this->estudiante['semestreprematricula'];
        if ($semestreEstudiante == 0){
            $semestreEstudiante = $this->estudiante['semestre'];
        }
        
        if($this->codigomodalidadacademica == 800)
        {
            //==================
            //Verificar si existe una observacion para la orden de pago

            $obsStr = "select observacionordenpago from ordenpago where numeroordenpago = $numeroordenpago";
            $queryObs = $this->conexion->query($obsStr);                               
            $obsResponse = $queryObs->fetchRow();
            $obsText = $obsResponse['observacionordenpago'];
                    

            if ($obsText) {                
                //Ahora se verifica si se puede convertir la observacion a formato json
                $obsJson = json_decode($obsText);                
               
                if ($obsJson) {
                    //ahora se verifica que exista el atributo periodoVirtual
                    if ($obsJson->periodovirtual) {
                        return $obsJson->periodovirtual;
                    }
                }
            }

            //===================

            //si es 1 o 2
            if($this->estudiante['semestreprematricula'] < 3)
            {
                $semestre = "1";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 3 o 4
            if($this->estudiante['semestreprematricula'] < 5 && $this->estudiante['semestreprematricula'] > 2)
            {
                $semestre = "2";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 5 o 6
            if($this->estudiante['semestreprematricula'] < 7 && $this->estudiante['semestreprematricula'] > 4 )
            {
                $semestre = "3";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 7 o 8
            if($this->estudiante['semestreprematricula'] < 8 && $this->estudiante['semestreprematricula'] > 5 )
            {
                $semestre = "4";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 9 o 10
            if($this->estudiante['semestreprematricula'] < 11 && $this->estudiante['semestreprematricula'] > 8)
            {
                $semestre = "5";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 11 o 12
            if($this->estudiante['semestreprematricula'] < 13 && $this->estudiante['semestreprematricula'] > 10)
            {
                $semestre = "6";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 13 o 14
            if($this->estudiante['semestreprematricula'] < 15 && $this->estudiante['semestreprematricula'] > 12 )
            {
                $semestre = "7";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            //si es 15 o 16
            if($this->estudiante['semestreprematricula'] > 14 )
            {
                $semestre = "8";
                $PeriodoVirtual = $this->estudiante['semestreprematricula'];
            }
            
            return "SEM. ".$semestre." PV.".$PeriodoVirtual;
        }
        else
        {

            return "SEM $semestreEstudiante";
        }
                
    }

    function obtenerPeriodo(){

        $numeroordenpago = $this->numeroordenpago;
        $periodo = $this->estudiante['codigoperiodo'];
        $periodoVirtual = "";

        if ($this->codigomodalidadacademica == 800) {
           
           //se obtiene la fecha de orden de pago 
           $strFechaOp = "select fechaordenpago from ordenpago where numeroordenpago = $numeroordenpago";
           $queryFechaOp = $this->conexion->query($strFechaOp);                               
           $fechaOrdenPago = $queryFechaOp->fetchRow();
           $fechaOrdenPago = $fechaOrdenPago['fechaordenpago'];
           
           //se obtiene el periodo en sala virtual
           $strPeriodoVirtual = "select PV.CodigoPeriodo from PeriodosVirtuales PV
           join PeriodoVirtualCarrera PVC on PV.IdPeriodoVirtual = PVC.idPeriodoVirtual
           where PVC.codigoModalidadAcademica = 800
           and PVC.fechaInicio < '". $fechaOrdenPago. "' order by PV.CodigoPeriodo desc
           limit 1";          
                      
            $queryPeriodoVirtual = $this->conexion->query($strPeriodoVirtual);

            $periodoVirtual = $queryPeriodoVirtual->fetchRow();

            $periodoVirtual = $periodoVirtual['CodigoPeriodo'];                 
           

           return "PERIODO $periodoVirtual";
        }else{
            
            return "PERIODO $periodo";
        }

    }
}// fin class datos_ordenpago