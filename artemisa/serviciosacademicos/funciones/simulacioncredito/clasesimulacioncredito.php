<?
include($rutaado.'adodb.inc.php'); 

class clasesimulaciocredito
{ 
        // Variables 
		var $db;
        var $nombreestudiante ;
        var $idsimulacioncredito;
		var $codigoestudiante ;
   		var $fechasimulacioncredito ;
        var $valorsimulacioncredito ;
        var $fechahastasimulacioncredito ;
        var $numerocuotassimulacioncredito ;
        var $observacionsimulacioncredito ;
        var $codigoestado ;
        var $idcondicioncredito;
		
		// Estas variables son para la tabla condicioncredito
		var $fechacondicioncredito ;
        var $fechadesdecondicioncredito ;
        var $fechahastacondicioncredito ;
        var $maximocoutascondicioncredito ;
        var $porcentajefinancierocondicioncredito ;
        var $valorminimocondicioncredito ;
        var $valormaximocondicioncredito ;
        var $codigotipoaplicacioncuotacondicioncredito ;
        var $porcentajeminimoinicialcondicioncredito ;
        var $observacioncondicioncredito;
		var $codigoreferenciacuotainicialcondicioncredito;

		// Estas variables son para uso del programa
		var $cuotas;
		var $valorapagar;
		var $primerpago;
		var $valorafinanciar;
		var $fechascreditos;
		var $capitales;
		var $intereses;
		var $valoresagirar;
		var $numerocuotas;
		var $numeroordenpago;
		var $codigoperiodo;
		var $pecuniarios;
		
        /**
        * @return returns value of variable $db 
        * @desc getDb  : Getting value for variable $db 
        */
        function getDb ()
        {
        	return $this->db ;
        }

        /**
        * @param param : value to be saved in variable $db 
        * @desc setDb  : Setting value for $db 
        */
        function setDb ($value)
        {
            $this->db  = $value;
        }
		
		/**
        * @return returns value of variable $nombreestudiante 
        * @desc getNombreestudiante  : Getting value for variable $nombreestudiante 
        */
        function getNombreestudiante ()
        {
        	return $this->nombreestudiante ;
        }

        /**
        * @param param : value to be saved in variable $nombreestudiante 
        * @desc setNombreestudiante  : Setting value for $nombreestudiante 
        */
        function setNombreestudiante ($value)
        {
            $this->nombreestudiante  = $value;
        }
		
		/**
        * @return returns value of variable $idsimulacioncredito 
        * @desc getNombreestudiante  : Getting value for variable $idsimulacioncredito 
        */
        function getIdsimulacioncredito ()
        {
        	return $this->idsimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $idsimulacioncredito 
        * @desc setNombreestudiante  : Setting value for $idsimulacioncredito 
        */
        function setIdsimulacioncredito ($value)
        {
            $this->idsimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $codigoestudiante 
        * @desc getCodigoestudiante  : Getting value for variable $codigoestudiante 
        */
        function getCodigoestudiante ()
        {
            return $this->codigoestudiante ;
        }

        /**
        * @param param : value to be saved in variable $codigoestudiante 
        * @desc setCodigoestudiante  : Setting value for $codigoestudiante 
        */
        function setCodigoestudiante ($value)
        {
            $this->codigoestudiante  = $value;
        }

        /**
        * @return returns value of variable $fechasimulacioncredito 
        * @desc getFechasimulacioncredito  : Getting value for variable $fechasimulacioncredito 
        */
        function getFechasimulacioncredito ()
        {
            return $this->fechasimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $fechasimulacioncredito 
        * @desc setFechasimulacioncredito  : Setting value for $fechasimulacioncredito 
        */
        function setFechasimulacioncredito ($value)
        {
            $this->fechasimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $valorsimulacioncredito 
        * @desc getValorsimulacioncredito  : Getting value for variable $valorsimulacioncredito 
        */
        function getValorsimulacioncredito ()
        {
            return $this->valorsimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $valorsimulacioncredito 
        * @desc setValorsimulacioncredito  : Setting value for $valorsimulacioncredito 
        */
        function setValorsimulacioncredito ($value)
        {
            $this->valorsimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $fechahastasimulacioncredito 
        * @desc getFechahastasimulacioncredito  : Getting value for variable $fechahastasimulacioncredito 
        */
        function getFechahastasimulacioncredito ()
        {
            return $this->fechahastasimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $fechahastasimulacioncredito 
        * @desc setFechahastasimulacioncredito  : Setting value for $fechahastasimulacioncredito 
        */
        function setFechahastasimulacioncredito ($value)
        {
            $this->fechahastasimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $numerocuotassimulacioncredito 
        * @desc getNumerocuotassimulacioncredito  : Getting value for variable $numerocuotassimulacioncredito 
        */
        function getNumerocuotassimulacioncredito ()
        {
            return $this->numerocuotassimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $numerocuotassimulacioncredito 
        * @desc setNumerocuotassimulacioncredito  : Setting value for $numerocuotassimulacioncredito 
        */
        function setNumerocuotassimulacioncredito ($value)
        {
            $this->numerocuotassimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $observacionsimulacioncredito 
        * @desc getObservacionsimulacioncredito  : Getting value for variable $observacionsimulacioncredito 
        */
        function getObservacionsimulacioncredito ()
        {
            return $this->observacionsimulacioncredito ;
        }

        /**
        * @param param : value to be saved in variable $observacionsimulacioncredito 
        * @desc setObservacionsimulacioncredito  : Setting value for $observacionsimulacioncredito 
        */
        function setObservacionsimulacioncredito ($value)
        {
            $this->observacionsimulacioncredito  = $value;
        }

        /**
        * @return returns value of variable $codigoestado 
        * @desc getCodigoestado  : Getting value for variable $codigoestado 
        */
        function getCodigoestado ()
        {
            return $this->codigoestado ;
        }

        /**
        * @param param : value to be saved in variable $codigoestado 
        * @desc setCodigoestado  : Setting value for $codigoestado 
        */
        function setCodigoestado ($value)
        {
            $this->codigoestado  = $value;
        }

        /**
        * @return returns value of variable $idcondicioncredito
        * @desc getIdcondicioncredito : Getting value for variable $idcondicioncredito
        */
        function getIdcondicioncredito()
        {
            return $this->idcondicioncredito;
        }

        /**
        * @param param : value to be saved in variable $idcondicioncredito
        * @desc setIdcondicioncredito : Setting value for $idcondicioncredito
        */
        function setIdcondicioncredito($value)
        {
            $this->idcondicioncredito = $value;
        }

		/**
        * @return returns value of variable $idcondicioncredito
        * @desc getIdcondicioncredito : Getting value for variable $idcondicioncredito
        */
        function getNumeroordenpago()
        {
            return $this->numerorodenpago;
        }

        /**
        * @param param : value to be saved in variable $idcondicioncredito
        * @desc setIdcondicioncredito : Setting value for $idcondicioncredito
        */
        function setNumeroordenpago($value)
        {
            $this->numerorodenpago = $value;
        }

        // This is the constructor for this class
        // Initialize all your default variables hereclasesimulaciocredito
        function clasesimulaciocredito($db,$nombreestudiante,$codigoestudiante,$fechasimulacioncredito,$valorsimulacioncredito,$fechahastasimulacioncredito,$numerocuotassimulacioncredito,$observacionsimulacioncredito="",$codigoestado=100,$idcondicioncredito=0, $codigoreferenciacuotainicialcondicioncredito=100)
        {

                $this->setDb ($db);
                $this->setNombreestudiante ($nombreestudiante);
                $this->setCodigoestudiante ($codigoestudiante);
                $this->setFechasimulacioncredito ($fechasimulacioncredito);
                $this->setValorsimulacioncredito ($valorsimulacioncredito);
                $this->setFechahastasimulacioncredito ($fechahastasimulacioncredito);
                $this->setNumerocuotassimulacioncredito ($numerocuotassimulacioncredito);
				$this->setObservacionsimulacioncredito (observacionsimulacioncredito);
                $this->setCodigoestado ($codigoestado);
                $this->setIdcondicioncredito($idcondicioncredito);
				
				$this->setFechacondicioncredito ("");
                $this->setFechadesdecondicioncredito ("");
                $this->setFechahastacondicioncredito ("");
                $this->setMaximocoutascondicioncredito ("");
                $this->setPorcentajefinancierocondicioncredito ("");
                $this->setValorminimocondicioncredito ("");
                $this->setValormaximocondicioncredito ("");
                $this->setCodigotipoaplicacioncuotacondicioncredito ("");
                $this->setPorcentajeminimoinicialcondicioncredito ("");
                $this->setObservacioncondicioncredito("");
				$this->setCodigoreferenciacuotainicialcondicioncredito("");
        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setDb ("");
                $this->setNombreestudiante ("");
                $this->setCodigoestudiante ("");
                $this->setFechasimulacioncredito ("");
                $this->setValorsimulacioncredito ("");
                $this->setFechahastasimulacioncredito ("");
                $this->setNumerocuotassimulacioncredito ("");
                $this->setObservacionsimulacioncredito ("");
                $this->setCodigoestado ("");
                $this->setIdcondicioncredito("");
				
				$this->setFechacondicioncredito ("");
                $this->setFechadesdecondicioncredito ("");
                $this->setFechahastacondicioncredito ("");
                $this->setMaximocoutascondicioncredito ("");
                $this->setPorcentajefinancierocondicioncredito ("");
                $this->setValorminimocondicioncredito ("");
                $this->setValormaximocondicioncredito ("");
                $this->setCodigotipoaplicacioncuotacondicioncredito ("");
                $this->setPorcentajeminimoinicialcondicioncredito ("");
                $this->setObservacioncondicioncredito("");
				$this->setCodigoreferenciacuotainicialcondicioncredito("");
        }
		
		/**
        * @return put : No retorna nada
        * @param param :  No recibe nada
        * @desc  :  Esta funcion muestra la cabecera de la siumlación para este estudiante
        */
        function cabecerasimulacion()
		{
			require("cabecerasimulacion.php");
		}

		/**
        * @return put : No retorna nada
        * @param param :  No recibe nada
        * @desc  :  Esta funcion muestra el cuerpo de la siumlación para este estudiante
        */
        function cuerposimulacion()
		{
			require("cuerposimulacion.php");
		}
		
		/**
        * @return put : No retorna nada
        * @param param :  No recibe nada
        * @desc  :  Esta funcion muestra el pie de la simulación para este estudiante
        */
        function piesimulacion()
		{
			require("piesimulacion.php");
		}
		
		/**
        * @return put : Retorna el valor apagar por el estudiante
        * @param param :  Recibe el codigoperiodo
        * @desc  :  Trae el valor de la matricula del estudiante
        */
        function setValorapagar($codigoperiodo)
		{
			$query_datocohorte = "select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal
			from cohorte c, estudiante e
			where c.codigocarrera = e.codigocarrera
			and c.codigoperiodo = '$codigoperiodo'
			and e.codigoestudiante = '$this->codigoestudiante'
			and e.codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
			//echo "$query_datocohorte<br>";
			$datocohorte = $this->db->Execute($query_datocohorte);
			$totalRows_datocohorte = $datocohorte->RecordCount();
			$numerocohorte = $datocohorte->fields['numerocohorte'];
			//exit();
			if($totalRows_datocohorte == "")
			{
				$this->valorapagar = $codigoperiodo;
			}
			else
			{
				$query_iniciales= "select eg.codigogenero, c.codigocarrera, p.idprematricula, c.nombrecarrera, p.semestreprematricula,
				e.codigoestudiante, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.semestre,
				det.valordetallecohorte, e.codigotipoestudiante, eg.numerodocumento, e.codigosituacioncarreraestudiante, e.codigocarrera,
				eg.idestudiantegeneral
				from prematricula p, estudiante e, carrera c, detallecohorte det, cohorte coh, estudiantegeneral eg
				where p.codigoestudiante = e.codigoestudiante
				and p.codigoperiodo = '$codigoperiodo'
				and e.codigocarrera = c.codigocarrera
				and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
				and e.codigoestudiante = '$this->codigoestudiante'
				and coh.codigocarrera = c.codigocarrera
				and coh.codigoperiodo = p.codigoperiodo
				and coh.idcohorte = det.idcohorte
				and det.semestredetallecohorte = p.semestreprematricula
				and coh.numerocohorte = '$numerocohorte'
				and e.idestudiantegeneral = eg.idestudiantegeneral";
				//and dop.codigoconcepto = '151'
				//echo "<br>$query_iniciales<br>";
				$iniciales = $this->db->Execute($query_iniciales);
				$totalRows_oiniciales = $iniciales->RecordCount();
				$this->valorapagar = $iniciales->fields['valordetallecohorte'];
			}
		}
		
		/**
        * @return put : Retorna la observación
        * @param param :  No recibe nada
        * @desc  :  Esta funcion trae la observación hecha por crédito y cartera
        */
        function observacionsimulacioncreditobd()
		{
			$query_observacion = "select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal
			from cohorte c, estudiante e
			where c.codigocarrera = e.codigocarrera
			and c.codigoperiodo = '$codigoperiodo'
			and e.codigoestudiante = '$this->codigoestudiante'
			and e.codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
			//echo "$query_datocohorte<br>";
			$observacion = $this->db->Execute($query_observacion);
			$totalRows_observacion = $observacion->RecordCount();
			$observacioncondicioncredito = $observacion->fields['observacioncondicioncredito'];
		}
		
		/**
        * @return returns value of variable $fechacondicioncredito 
        * @desc getFechacondicioncredito  : Getting value for variable $fechacondicioncredito 
        */
        function getFechacondicioncredito ()
        {
                return $this->fechacondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $fechacondicioncredito 
        * @desc setFechacondicioncredito  : Setting value for $fechacondicioncredito 
        */
        function setFechacondicioncredito ($value)
        {
                $this->fechacondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $fechadesdecondicioncredito 
        * @desc getFechadesdecondicioncredito  : Getting value for variable $fechadesdecondicioncredito 
        */
        function getFechadesdecondicioncredito ()
        {
                return $this->fechadesdecondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $fechadesdecondicioncredito 
        * @desc setFechadesdecondicioncredito  : Setting value for $fechadesdecondicioncredito 
        */
        function setFechadesdecondicioncredito ($value)
        {
                $this->fechadesdecondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $fechahastacondicioncredito 
        * @desc getFechahastacondicioncredito  : Getting value for variable $fechahastacondicioncredito 
        */
        function getFechahastacondicioncredito ()
        {
                return $this->fechahastacondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $fechahastacondicioncredito 
        * @desc setFechahastacondicioncredito  : Setting value for $fechahastacondicioncredito 
        */
        function setFechahastacondicioncredito ($value)
        {
                $this->fechahastacondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $maximocoutascondicioncredito 
        * @desc getMaximocoutascondicioncredito  : Getting value for variable $maximocoutascondicioncredito 
        */
        function getMaximocoutascondicioncredito ()
        {
                return $this->maximocoutascondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $maximocoutascondicioncredito 
        * @desc setMaximocoutascondicioncredito  : Setting value for $maximocoutascondicioncredito 
        */
        function setMaximocoutascondicioncredito ($value)
        {
                $this->maximocoutascondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $porcentajefinancierocondicioncredito 
        * @desc getPorcentajefinancierocondicioncredito  : Getting value for variable $porcentajefinancierocondicioncredito 
        */
        function getPorcentajefinancierocondicioncredito ()
        {
                return $this->porcentajefinancierocondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $porcentajefinancierocondicioncredito 
        * @desc setPorcentajefinancierocondicioncredito  : Setting value for $porcentajefinancierocondicioncredito 
        */
        function setPorcentajefinancierocondicioncredito ($value)
        {
                $this->porcentajefinancierocondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $valorminimocondicioncredito 
        * @desc getValorminimocondicioncredito  : Getting value for variable $valorminimocondicioncredito 
        */
        function getValorminimocondicioncredito ()
        {
                return $this->valorminimocondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $valorminimocondicioncredito 
        * @desc setValorminimocondicioncredito  : Setting value for $valorminimocondicioncredito 
        */
        function setValorminimocondicioncredito ($value)
        {
                $this->valorminimocondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $valormaximocondicioncredito 
        * @desc getValormaximocondicioncredito  : Getting value for variable $valormaximocondicioncredito 
        */
        function getValormaximocondicioncredito ()
        {
                return $this->valormaximocondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $valormaximocondicioncredito 
        * @desc setValormaximocondicioncredito  : Setting value for $valormaximocondicioncredito 
        */
        function setValormaximocondicioncredito ($value)
        {
                $this->valormaximocondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $codigotipoaplicacioncuotacondicioncredito 
        * @desc getCodigotipoaplicacioncuotacondicioncredito  : Getting value for variable $codigotipoaplicacioncuotacondicioncredito 
        */
        function getCodigotipoaplicacioncuotacondicioncredito ()
        {
                return $this->codigotipoaplicacioncuotacondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $codigotipoaplicacioncuotacondicioncredito 
        * @desc setCodigotipoaplicacioncuotacondicioncredito  : Setting value for $codigotipoaplicacioncuotacondicioncredito 
        */
        function setCodigotipoaplicacioncuotacondicioncredito ($value)
        {
                $this->codigotipoaplicacioncuotacondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $porcentajeminimoinicialcondicioncredito 
        * @desc getPorcentajeminimoinicialcondicioncredito  : Getting value for variable $porcentajeminimoinicialcondicioncredito 
        */
        function getPorcentajeminimoinicialcondicioncredito ()
        {
                return $this->porcentajeminimoinicialcondicioncredito ;
        }

        /**
        * @param param : value to be saved in variable $porcentajeminimoinicialcondicioncredito 
        * @desc setPorcentajeminimoinicialcondicioncredito  : Setting value for $porcentajeminimoinicialcondicioncredito 
        */
        function setPorcentajeminimoinicialcondicioncredito ($value)
        {
                $this->porcentajeminimoinicialcondicioncredito  = $value;
        }

        /**
        * @return returns value of variable $observacioncondicioncredito
        * @desc getObservacioncondicioncredito : Getting value for variable $observacioncondicioncredito
        */
        function getObservacioncondicioncredito()
        {
                return $this->observacioncondicioncredito;
        }

        /**
        * @param param : value to be saved in variable $observacioncondicioncredito
        * @desc setObservacioncondicioncredito : Setting value for $observacioncondicioncredito
        */
        function setObservacioncondicioncredito($value)
        {
                $this->observacioncondicioncredito = $value;
        }
		
		/**
        * @return returns value of variable $codigoreferenciacuotainicialcondicioncredito
        * @desc getObservacioncondicioncredito : Getting value for variable $codigoreferenciacuotainicialcondicioncredito
        */
        function getCodigoreferenciacuotainicialcondicioncredito()
        {
                return $this->codigoreferenciacuotainicialcondicioncredito;
        }

        /**
        * @param param : value to be saved in variable $codigoreferenciacuotainicialcondicioncredito
        * @desc setObservacioncondicioncredito : Setting value for $codigoreferenciacuotainicialcondicioncredito
        */
        function setCodigoreferenciacuotainicialcondicioncredito($value)
        {
                $this->codigoreferenciacuotainicialcondicioncredito = $value;
        }
		
		/**
        * @param param : value to be saved in variable $observacioncondicioncredito
        * @desc setObservacioncondicioncredito : Setting value for $observacioncondicioncredito
        */
     	function inicializarcondicioncredito($codigoperiodo)
        {
                $query_condicioncredito = "select c.idcondicioncredito, c.fechacondicioncredito, c.fechadesdecondicioncredito, c.fechahastacondicioncredito, 
				c.maximocoutascondicioncredito, c.porcentajefinancierocondicioncredito, c.valorminimocondicioncredito, 
				c.valormaximocondicioncredito, c.codigotipoaplicacioncuotacondicioncredito, c.porcentajeminimoinicialcondicioncredito, 
				c.observacioncondicioncredito, c.codigoreferenciacuotainicialcodicioncredito
				from condicioncredito c
				where c.codigoestado like '1%'
				and c.codigoperiodo = '$codigoperiodo'";
				//echo "$query_condicioncredito<br>";
				$condicioncredito = $this->db->Execute($query_condicioncredito);
				$totalRows_condicioncredito = $condicioncredito->RecordCount();
				$condicioncredito->fields['observacioncondicioncredito'];
				
				$this->setIdcondicioncredito ($condicioncredito->fields['idcondicioncredito']);
                $this->setFechacondicioncredito ($condicioncredito->fields['fechacondicioncredito']);
                $this->setFechadesdecondicioncredito ($condicioncredito->fields['fechadesdecondicioncredito']);
                $this->setFechahastacondicioncredito ($condicioncredito->fields['fechahastacondicioncredito']);
                $this->setMaximocoutascondicioncredito ($condicioncredito->fields['maximocoutascondicioncredito']);
                $this->setPorcentajefinancierocondicioncredito ($condicioncredito->fields['porcentajefinancierocondicioncredito']);
                $this->setValorminimocondicioncredito ($condicioncredito->fields['valorminimocondicioncredito']);
                $this->setValormaximocondicioncredito ($condicioncredito->fields['valormaximocondicioncredito']);
                $this->setCodigotipoaplicacioncuotacondicioncredito ($condicioncredito->fields['codigotipoaplicacioncuotacondicioncredito']);
                $this->setPorcentajeminimoinicialcondicioncredito ($condicioncredito->fields['porcentajeminimoinicialcondicioncredito']);
                $this->setObservacioncondicioncredito($condicioncredito->fields['observacioncondicioncredito']);
				$this->setCodigoreferenciacuotainicialcondicioncredito($condicioncredito->fields['codigoreferenciacuotainicialcodicioncredito']);
		}
		
		/**
        * @param param : 
        * @desc calcularvalorapagar : Calcula el valor mínimo que debe pagar el estudiante
        */
        function calcularprimerpago($valorapagar)
        {
				
                $this->primerpago = $valorapagar*$this->porcentajeminimoinicialcondicioncredito/100;
				
        }
		
		function setPrimerpago($primerpago)
		{
			$this->primerpago = $primerpago;
		}
		
		function setFechascreditos($fecha)
		{
			$this->fechascreditos[] = $fecha;
		}
		
		function setCapitales($capital)
		{
			$this->capitales[] = $capital;
		}
		
		function setIntereses($intereses)
		{
			$this->intereses[] = $intereses;
		}
		
		function setValoresagirar($valoresagirar)
		{
			$this->valoresagirar[] = $valoresagirar;
		}
		
		function setValorafinanciar($valorafinanciar)
		{
			$this->valorafinanciar = $valorafinanciar;
		}
		
		/**
        * @param param : 
        * @desc calcularvalorapagar : Calcula el valor mínimo que debe pagar el estudiante
        */
        function numerocuotas()
        {
			$objfecha = new CalcDate();
			$Timestamp1 = $objfecha->CalculateTimestampFromCurrDatetime(date("Y-m-d"));
			$Timestamp2 = $objfecha->CalculateTimestampFromCurrDatetime($this->fechahastacondicioncredito);
	
			$DateDiff = $objfecha->CalculateDateDifference($Timestamp1,$Timestamp2);
			
			if($this->maximocoutascondicioncredito < $DateDiff['months'])
			{
				$cuotas = $this->maximocoutascondicioncredito;
			}
			else
			{
				$cuotas = $DateDiff['months'];
			}
			if(!isset($_POST['numerocuotas']))
			{
				$_POST['numerocuotas'] = $cuotas;
			}
?>
			<select name="numerocuotas" onChange="submit()">
<?php
			for($i = 1; $i <= $cuotas; $i++)
			{
					
?>
				<option value="<?php echo $i; ?>" <?php if($_POST['numerocuotas'] == $i) {echo "selected"; $this->cuotas = $i;} ?>><?php echo $i; ?></option>
<?php
			}
?>
			</select>
<?php
			$this->numerocuotas = $_POST['numerocuotas'];
			//echo $_POST['numerocuotas'];
        }
		
		function simularcuotas()
		{
			// Primero miro cuantos capitales van fijos y reparto el capital excedente en las otras
			$cuentacuotasrepartir = 0;
			echo "<h1>aca</h1>";
			foreach($_POST as $key => $value)
			{				
				if(ereg("mantenercapital",$key))
				{
					$llave = ereg_replace("mantenercapital","",$key);
					$capitalnuevo = $capitalnuevo + $_POST['capital'.$llave];
					$cuentacuotasrepartir++;					
				}
			}
			//echo $capitalnuevo;
				
			$objfecha = new CalcDate();
			$capital = $this->valorafinanciar/$this->cuotas;
			$capitalnuevo = $this->valorafinanciar - $capitalnuevo;
			if(ereg("^3.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interesultimacuota = true;
			}
			if(ereg("^2.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interestodascuotas = true;
			}
			if(ereg("^1.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interesprimeracuota = true;
			}
			
			$valorafinaciarini = $this->valorafinanciar;
			for($i = 1; $i <= $this->cuotas; $i++)
			{				
				$j = $i-1;
				if(!isset($_POST['fecha'.$i]))
				{
					echo "<h1>".$_POST['fecha0']."</h1>";
					$_POST['fecha'.$i] = $objfecha->calcularfechafuturaxmes($i,$this->fechascreditos[0]);
				}
				
				// Calculo de los intereses
				$dias0 = $objfecha->restarfechacomercial($_POST['fecha'.$i], $_POST['fecha'.$j]);
				$intereses0 = $valorafinaciarini*(($this->porcentajefinancierocondicioncredito/100/30)*$dias0);
				//echo "<h1>$dias0  = (".$_POST['fecha'.$i].",".$_POST['fecha'.$j]."$intereses0</h1>";
				if($intereses0 < 0)
				{
					//exit();
				
?>
<!-- <script language="javascript">
	alert("Tiene un error en la parametrización de la fecha, los intereses no deben ser negativos");
	window.location.reload("simulacioncredito.php");
</script> -->
<?php
					exit();
				}  
				
				if(isset($_POST['mantenercapital'.$i]))
				{
					$capital0 = $_POST['capital'.$i];
					//$valoragirar = $intereses+$capital;
					//$repartircapital = $repartircapital;
				}
				else
				{
					$capital0 = $capitalnuevo/($this->cuotas - $cuentacuotasrepartir);
					//$valoragirar = $intereses + $capital;
				}
							
				// Vatibale para guardar los totales
				$totalintereses0 = $totalintereses0+$intereses0;
				$totalvaloragirar0 = $totalvaloragirar0+$valoragirar0;
				$totalcapital0 = $totalcapital0 + $capital0;
				
				$valorafinaciarini = $valorafinaciarini - $capital0;
				echo $valorafinaciarini;
				//$capital = $capitalcambiar;
			}
			
			//echo "$totalintereses0";
			$valorafinaciarini = $this->valorafinanciar;
			for($i = 1; $i <= $this->cuotas; $i++)
			{
				$j = $i-1;
				if(!isset($_POST['fecha'.$i]))
				{
					 echo "<h1>".$_POST['fecha0']."</h1>";
					 $_POST['fecha'.$i] = $objfecha->calcularfechafuturaxmes($i,$this->fechascreditos[0]);
				}
				
				// Calculo de los intereses
				$dias = $objfecha->restarfechacomercial($_POST['fecha'.$i], $_POST['fecha'.$j]);
				$intereses = $valorafinaciarini*(($this->porcentajefinancierocondicioncredito/100/30)*$dias);
				
				if(isset($_POST['mantenercapital'.$i]))
				{
					$capital = $_POST['capital'.$i];
					//$valoragirar = $intereses+$capital;
					//$repartircapital = $repartircapital;
				}
				else
				{
					$capital = $capitalnuevo/($this->cuotas - $cuentacuotasrepartir);
					//$valoragirar = $intereses + $capital;
				}
				if($interestodascuotas)
				{
					$valoragirar = $intereses + $capital;
				}
				if($interesprimeracuota)
				{
					if($i == 1)
					{
						$valoragirar = $totalintereses0 + $capital;
						$intereses = $totalintereses0;
						//echo "$valoragirar = $totalintereses0 + $capital;";
					}
					else
					{
						$intereses = 0;
						$valoragirar = $intereses + $capital;
					}
				}
				if($interesultimacuota)
				{
					if($i == $this->cuotas)
					{
						$valoragirar = $totalintereses0 + $capital;
						$intereses = $totalintereses0;
					}
					else
					{
						$intereses = 0;
						$valoragirar = $intereses + $capital;
					}
				}
				$this->setFechascreditos($_POST['fecha'.$i]);
				$this->setCapitales($capital);
				$this->setIntereses($intereses);
				$this->setValoresagirar($valoragirar);							
		?>
	<tr> 
      <td><?php echo $i+1; ?></td>
	  <td><input type="text" name="fecha<?php echo $i;?>" value="<?php echo $_POST['fecha'.$i]; ?>" readonly="true" size="10"></td>
	  <td>$ <input type="text" name="capital<?php echo $i?>" size="10" value="<?php echo round($capital,0);?>"><input type="checkbox" name="mantenercapital<?php echo $i?>"
<?php
				if(isset($_POST['mantenercapital'.$i]))
				{
					echo " checked";
				}
?>
				value="
<?php
  				if(isset($_POST['mantenercapital'.$i]))
				{
					echo $_POST['capital'.$i];
				}
				else
				{
  					echo $capital; 
				}
				?>">
		</td>
	  <td>$ <?php echo number_format($intereses,2); ?></td>
	  <td>$ <?php echo number_format($valoragirar,2); ?></td>
    </tr>
<?php
				// Vatibale para guardar los totales
				$totalintereses = $totalintereses+$intereses;
				$totalvaloragirar = $totalvaloragirar+$valoragirar;
				$totalcapital = $totalcapital + $capital;
				
				$valorafinaciarini = $valorafinaciarini - $capital;
				//$capital = $capitalcambiar;
			}
?>
 <tr>
   <td colspan="2" id="tdtitulogris">Totales Cuotas</td>
	  <td bgcolor="#999999">$ <?php echo number_format($totalcapital,2);//number_format($this->valorafinanciar,2); ?></td>
	  <td bgcolor="#999999">$ <?php echo number_format(round($totalintereses,0),2); ?></td>
	  <td bgcolor="#999999">$ <?php echo number_format(round($totalvaloragirar,0),2); ?></td>
    </tr>
<?php
			if(($totalcapital != $this->valorafinanciar))
			{
?>
<script language="javascript">
	alert("El valor de las cuotas no puede ser diferente al valor que se debe financiar");
	history.go(-1);
	//window.location.reload("simulacioncredito.php");
</script>
<?php
				exit();
			}
		}
		
		function simularcuotasarreglo()
		{
			// Primero miro cuantos capitales van fijos y reparto el capital excedente en las otras
			$cuentacuotasrepartir = 0;
			foreach($_POST as $key => $value)
			{
				if(ereg("mantenercapital",$key))
				{
					$llave = ereg_replace("mantenercapital","",$key);
					$capitalnuevo = $capitalnuevo + $_POST['capital'.$llave];
					$cuentacuotasrepartir++;
				}
			}
			//echo $capitalnuevo;
			$objfecha = new CalcDate();
			$capital = $this->valorafinanciar/$this->cuotas;
			$capitalnuevo = $this->valorafinanciar - $capitalnuevo;
			if(ereg("^3.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interesultimacuota = true;
			}
			if(ereg("^2.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interestodascuotas = true;
			}
			if(ereg("^1.+$",$this->codigotipoaplicacioncuotacondicioncredito))
			{
				$interesprimeracuota = true;
			}
			
			$valorafinaciarini = $this->valorafinanciar;
			for($i = 1; $i <= $this->cuotas; $i++)
			{
				$j = $i-1;
				if(!isset($_POST['fecha'.$i]))
				{
					$_POST['fecha'.$i] = $objfecha->calcularfechafuturaxmes($i,$_POST['fecha0']);
				}
				
				// Calculo de los intereses
				$dias0 = $objfecha->restarfechacomercial($_POST['fecha'.$i], $_POST['fecha'.$j]);
				$intereses0 = $valorafinaciarini*(($this->porcentajefinancierocondicioncredito/100/30)*$dias0);
				//echo "<h1>$dias0  = (".$_POST['fecha'.$i].",".$_POST['fecha'.$j]."$intereses0</h1>";
				if($intereses0 < 0)
				{
					//exit();
				
?>
 <script language="javascript">
	alert("Tiene un error en la parametrización de la fecha, los intereses no deben ser negativos");
	window.location.reload("simulacioncredito.php");
</script> 
<?php
					exit();
				}  
				
				if(isset($_POST['mantenercapital'.$i]))
				{
					$capital0 = $_POST['capital'.$i];
					//$valoragirar = $intereses+$capital;
					//$repartircapital = $repartircapital;
				}
				else
				{
					$capital0 = $capitalnuevo/($this->cuotas - $cuentacuotasrepartir);
					//$valoragirar = $intereses + $capital;
				}
							
				// Vatibale para guardar los totales
				$totalintereses0 = $totalintereses0+$intereses0;
				$totalvaloragirar0 = $totalvaloragirar0+$valoragirar0;
				$totalcapital0 = $totalcapital0 + $capital0;
				
				$valorafinaciarini = $valorafinaciarini - $capital0;
				//$capital = $capitalcambiar;
			}
			
			//echo "$totalintereses0";
			$valorafinaciarini = $this->valorafinanciar;
			for($i = 1; $i <= $this->cuotas; $i++)
			{
				$j = $i-1;
				if(!isset($_POST['fecha'.$i]))
				{
					 $_POST['fecha'.$i] = $objfecha->calcularfechafuturaxmes($i,$_POST['fecha0']);
				}
				
				// Calculo de los intereses
				$dias = $objfecha->restarfechacomercial($_POST['fecha'.$i], $_POST['fecha'.$j]);
				$intereses = $valorafinaciarini*(($this->porcentajefinancierocondicioncredito/100/30)*$dias);
				
				if(isset($_POST['mantenercapital'.$i]))
				{
					$capital = $_POST['capital'.$i];
					//$valoragirar = $intereses+$capital;
					//$repartircapital = $repartircapital;
				}
				else
				{
					$capital = $capitalnuevo/($this->cuotas - $cuentacuotasrepartir);
					//$valoragirar = $intereses + $capital;
				}
				if($interestodascuotas)
				{
					$valoragirar = $intereses + $capital;
				}
				if($interesprimeracuota)
				{
					if($i == 1)
					{
						$valoragirar = $totalintereses0 + $capital;
						$intereses = $totalintereses0;
						//echo "$valoragirar = $totalintereses0 + $capital;";
					}
					else
					{
						$intereses = 0;
						$valoragirar = $intereses + $capital;
					}
				}
				if($interesultimacuota)
				{
					if($i == $this->cuotas)
					{
						$valoragirar = $totalintereses0 + $capital;
						$intereses = $totalintereses0;
					}
					else
					{
						$intereses = 0;
						$valoragirar = $intereses + $capital;
					}
				}
				$this->setFechascreditos($_POST['fecha'.$i]);
				$this->setCapitales($capital);
				$this->setIntereses($intereses);
				$this->setValoresagirar($valoragirar);
				
				$cuotasimulacion[] = $i+1;
				$cuotasimulacion[] = $_POST['fecha'.$i];
	  
				if(isset($_POST['mantenercapital'.$i]))
				{
					//echo " checked";
				}
  				if(isset($_POST['mantenercapital'.$i]))
				{
					//echo $_POST['capital'.$i];
					$cuotasimulacion[] = $_POST['capital'.$i];
				}
				else
				{
  					//echo $capital;
					$cuotasimulacion[] = $capital; 
				}

				$cuotasimulacion[] = $intereses;
				$cuotasimulacion[] = $valoragirar;
				
				// Vatibale para guardar los totales
				$totalintereses = $totalintereses+$intereses;
				$totalvaloragirar = $totalvaloragirar+$valoragirar;
				$totalcapital = $totalcapital + $capital;
				
				$valorafinaciarini = $valorafinaciarini - $capital;
				//$capital = $capitalcambiar;
				$arreglocuotas[] = $cuotasimulacion;
				unset($cuotasimulacion);
			}
			$arreglocuotas['totalcapital'] = $totalcapital;
			$arreglocuotas['totalintereses'] = $totalintereses;
			$arreglocuotas['totalvaloragirar'] = $totalvaloragirar;
			
			if(($totalcapital != $this->valorafinanciar))
			{
?>
<script language="javascript">
	alert("El valor de las cuotas no puede ser diferente al valor que se debe financiar");
	history.go(-1);
	//window.location.reload("simulacioncredito.php");
</script>
<?php
				exit();
			}
			return $arreglocuotas;
		}
		
		function pintarcuotas($arreglocuotas)
		{
			$totalintereses = $arreglocuotas['totalintereses'];
			$totalvaloragirar = $arreglocuotas['totalvaloragirar'];
			$totalcapital = $arreglocuotas['totalcapital'];
				
			//$capital = $capitalcambiar;
			$interesmacheteado = $totalintereses / $this->numerocuotas;
			foreach($arreglocuotas as $key => $value)
			{
				$i = $value[0] - 1;
				if(!isset($value[0]))
				{
					break;
				}
								
?>
	<tr> 
      <td><?php echo $value[0];  ?></td>
	  <td><input type="text" name="fecha<?php echo $i;?>" value="<?php echo $value[1]; ?>" readonly="true" size="10"></td>
	  <td>$ <!-- <input type="text" name="capital<?php echo $i?>" size="10" value="<?php echo round($value[2],0);?>"><input type="checkbox" name="mantenercapital<?php echo $i?>" Dra Graciela -->
<?php
				if(isset($_POST['mantenercapital'.$i]))
				{
					//echo " checked"; Dra Graciela
				}
?>
				<!-- value=" Dra Graciela-->
<?php
  				if(isset($_POST['mantenercapital'.$i]))
				{
					//echo $_POST['capital'.$i];Dra Graciela
				}
				else
				{
  					//echo $value[2]; Dra Graciela
				}
				?><!-- "> Dra Graciela -->
		</td>
	  <td>$ <?php // echo number_format($interesmacheteado,2);Dra Graciela ?></td>
	  <td>$ <?php // echo number_format($value[2]+$interesmacheteado,2); Dra Graciela ?></td>
    </tr>
<?php
			}
?>
 <tr>
   <td colspan="2" id="tdtitulogris">Totales Cuotas</td>
	  <td bgcolor="#999999">$ <?php echo number_format($totalcapital+$this->primerpago,2);//number_format($this->valorafinanciar,2); ?></td>
	  <td bgcolor="#999999">$ <?php echo number_format(round($totalintereses,0),2); ?></td>
	  <td bgcolor="#999999">$ <?php echo number_format(round($totalvaloragirar+$this->primerpago,0),2); ?></td>
    </tr>
<?php
		}
		
		function calendarios()
		{
			for($i = 1; $i <= $this->cuotas; $i++)
			{
?>
<script type="text/javascript">
	/*Calendar.setup(
	{ inputField : "fecha<?php echo $i; ?>", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha<?php echo $i; ?>" // ID of the button
	});*/
</script>
<?php
			}
		}
		
		function formulariosimulacion($ruta,$idsimulacioncredito)
		{
			require($ruta.'formulariosimulacion.php');
		}
		
		/*function dataordenpago()
		{
			$ordenesxestudiante = new Ordenesestudiante($this->db, $this->codigoestudiante, $this->codigoperiodo, 4);
			$ordenesxestudiante->mostrar_ordenespago("../../../funciones/ordenpago/","");
		}*/
}
?> 