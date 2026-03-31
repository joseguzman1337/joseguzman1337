<?php
class CalendarioSalones
{

	var $DiaSemana; //Day of week
	var $Dia; //day
	var $Mes; //month
	var $MesEdt;
	var $Ano; //Year
	var $MesAnterior; //Last Month
	var $MesPosterior; //NextMonth
	var $AnoAnterior; //Last year
	var $AnoPosterior; //Next Year
	var $NumeroDiasdoMes; //Number of days in a month
	var $PrimeiroDiaMes; //First day of month
	var $Off;
	var $PaginaRaiz; //Root page
	var $LinkMes;
	var $target;
	var $tabela; //table
	var $campostatus; //Status

	var $conexion;
	var $codigoperiodo;
	var $fechahoy;
	var $DiaSiguiente;
	var $DiaAnterior;
	var $timeStamp;
	var $semana;
	var $semanaAnterior;
	var $semanaSiguiente;
	var $array_verificacion_horarios;
	var $array_rango_horas;
	var $depurar;
	var $fechaini;
	var $fechafin;
	var $codigosede;

	/*function asignarDatosBusquedaCabeceraHorario($idasesor,$idasesoria,$codigosede)
	{
	$this->idasesor=$idasesor;
	$this->idasesoria=$idasesoria;
	$this->codigosede=$codigosede;
	}
	*/

	function asignarCodigoperiodo($codigoperiodo)
	{
		$this->codigoperiodo=$codigoperiodo;
	}

	function asignarDepurar($depurar)
	{
		$this->depurar=true;
	}

	function asignarCodigoSalon($codigosalon)
	{

	}

	function HKAnoAtual(){
		if ($this->Mes == 12) {
			$this->AnoPosterior = $this->Ano + 1;
			$this->AnoAnterior  = $this->Ano;
		}

		if ($this->Mes == 01) {
			$this->AnoPosterior = $this->Ano;
			$this->AnoAnterior  = $this->Ano -1;
		}
	}


	function HKMesAnterior($mes){
		if ($mes <= 1) {
			$this->MesAnterior = "12";
			$this->MesPosterior = "02";
			$this->AnoAnterior = $this->Ano - 1;
			$this->AnoPosterior = $this->Ano + 1;
		} else if ($mes >= 12) {
			$this->MesAnterior = "11";
			$this->MesPosterior = "01";
			$this->AnoAnterior = $this->Ano;
			$this->AnoPosterior = $this->Ano + 1;
		} else {
			$this->MesAnterior = $this->Mes -1;
			if (strlen($this->MesAnterior) == 1) {
				$this->MesAnterior = "0" .$this->MesAnterior;
			}
			$this->MesPosterior = $this->Mes +1;
			if (strlen($this->MesPosterior) == 1) {
				$this->MesPosterior = "0" .$this->MesPosterior;
			}
			$this->AnoAnterior = $this->Ano;
			$this->AnoPosterior = $this->Ano;
		}
	}


	function CalendarioSalones($dia, $mes, $ano,&$conexion)
	{

		$this->Dia = $dia;
		$this->Mes = $mes;
		$this->Ano = $ano;
		$this->asignatimeStamp();
		$this->target = "self";
		$this->conexion=$conexion;
		$this->fechahoy=date("Y-m-d H:i:s");

		$arrDiasdaSemana = array("Domingo","Lunes","Martes","Miércoles","Jueves","Vieres","Sábado");
		$arrDiasdaSemanaAbr = array("Dom","Lun","Mar","Mie","Jue","Vie","Sab");
		$arrMes = array(1 => "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$arrMesAbr = array(1 => "Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");


		$this->DiaSemana =  date("w",mktime(0,0,0,$this->Mes,$this->Dia,$this->Ano));

		$this->NumeroDiasdoMes = date("t",mktime(0,0,0,$this->Mes,$this->Dia,$this->Ano));

		$this->PrimeiroDiaMes = date("w",mktime(0,0,0,$this->Mes,1,$this->Ano));

		for ($i=1 ; $i<=$this->NumeroDiasdoMes ; $i++){
			$final[$i-1 + $this->PrimeiroDiaMes] = date("d",mktime(0,0,0,$this->Mes,$i,$this->Ano));
			//echo $i -1 + $this->PrimeiroDiaMes ." -- " ."Dia : " .date("d",mktime(0,0,0,$this->Mes,$i,$this->Ano)) ."<br>";
		}
		$this->Off = $final;

		$this->HKEdtMes($this->Mes);
		$this->NomeMes = $arrMes[$this->MesEdt];
		$this->HKMesAnterior($this->Mes);
		$this->HKAnoAtual($this->Mes);

	}

	function asignaSemana($semana)
	{
		$this->semana=$semana;
	}

	function HKSetDia($dia){
		$this->Dia = $dia;
	}

	function HKSetMes($mes){
		$this->Mes = $mes;
	}

	function HKSetAno($ano){
		$this->Ano = $ano;
	}

	function asignatimeStamp()
	{
		$this->timeStamp = mktime(0, 0, 0, $this->Mes, $this->Dia, $this->Ano);
	}

	function HKEdtMes($mes){

		if (substr($mes,0,1) == 0) {
			$this->MesEdt = substr($mes,1,1);
		} else {
			$this->MesEdt = $mes;
		}


	}

	function HKSetaPaginaRaiz($pagina)
	{
		$this->PaginaRaiz = $pagina;
	}

	function devuelveUltimoDiadelMes($mes,$ano)
	{
		$ultimo_dia=28;
		while (checkdate($mes,$ultimo_dia + 1,$ano))
		{
			$ultimo_dia++;
		}
		return $ultimo_dia;
	}
	function DevuelveMes($mes)
	{
		switch ($mes)
		{
			case 1:
				return "Enero";
				break;
			case 2:
				return "Febrero";
				break;
			case 3:
				return "Marzo";
				break;
			case 4:
				return "Abril";
				break;
			case 5:
				return "Mayo";
				break;
			case 6:
				return "Junio";
				break;
			case 7:
				return "Julio";
				break;
			case 8:
				return "Agosto";
				break;
			case 9:
				return "Septiembre";
				break;
			case 10:
				return "Octubre";
				break;
			case 11:
				return "Noviembre";
				break;
			case 12:
				return "Diciembre";
				break;
			default:
				return false;
				break;
		}
	}

	function devuelveNumeroDiasMes()
	{
		return date('t', $this->timeStamp);
	}

	function devuelveDiadelAno()
	{
		return date('z', $this->timeStamp) + 1;
	}

	function devuelveDiadelaSemana($numeric = false)
	{
		if ($numeric) {
			return date('w', $this->timeStamp);
		} else {
			return date('l', $this->timeStamp);
		}
	}

	function devuelvePrimerDiadelMes($numeric = false)
	{
		$firstDay = mktime(0, 0, 0, date('m', $this->timeStamp), 1,
		date('Y', $this->timeStamp));
		if ($numeric) {
			return date('w', $firstDay);
		} else {
			return date('l', $firstDay);
		}
	}

	function devuelveDia($dia)
	{
		$cadenaDia=jddayofweek($dia,1);
		switch ($cadenaDia)
		{
			case "Monday":
				return "Lunes";
				break;
			case "Tuesday":
				return "Martes";
				break;
			case "Wednesday":
				return "Miércoles";
				break;
			case "Thursday":
				return "Jueves";
				break;
			case "Friday":
				return "Viernes";
				break;
			case "Saturday":
				return "Sábado";
				break;
			case "Sunday":
				return "Domingo";
				break;
		}
	}

	function devuelveNumeroDiadelaSemana($dia,$mes,$ano)
	{
		$numerodiasemana = @date('w', mktime(0,0,0,$mes,$dia,$ano));
		if ($numerodiasemana == 0)
		$numerodiasemana = 6;
		else
		$numerodiasemana--;
		return $numerodiasemana;
	}

	function iteradorMeses()
	{
		echo "<table border=0 cellpadding=2 cellspacing=1>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesAnterior."&ano=".$this->AnoAnterior."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'><<</a></td>\n";
		echo "    <td colspan='5' class='TituloMes'><p align='center'>".$this->NomeMes ." " .$this->Ano ."</p></td>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesPosterior."&ano=".$this->AnoPosterior."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'>>></a></td>\n";
		echo "  </tr>\n";
		echo "</table>\n";
	}

	function iteradorDias()
	{
		$ultimodia=$this->devuelveUltimoDiadelMes($this->Mes,$this->Ano);
		$numerodia=$this->devuelveNumeroDiadelaSemana($this->Dia,$this->Mes,$this->Ano);
		if($this->Dia < $ultimodia)
		{
			$DiaSiguiente=$this->Dia+1;
		}
		if($this->Dia > 1)
		{
			$DiaAnterior=$this->Dia-1;
		}

		$this->DiaSiguiente=date("d",mktime(0,0,0,$this->Mes,$DiaSiguiente,$this->Ano));
		$this->DiaAnterior=date("d",mktime(0,0,0,$this->Mes,$DiaAnterior,$this->Ano));

		echo "<table border=0 cellpadding=2 cellspacing=1>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td><a href='?dia=".$this->DiaAnterior."&mes=".$this->Mes."&ano=".$this->Ano."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'><<</a></td>\n";
		echo "    <td colspan='5' class='TituloMes'><p align='center'>".$this->devuelveDia($numerodia)." ".$this->Dia." ".$this->NomeMes ." " .$this->Ano ."</p></td>\n";
		echo "    <td><a href='?dia=".$this->DiaSiguiente."&mes=".$this->Mes."&ano=".$this->Ano."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'>>></a></td>\n";
		echo "  </tr>\n";
		echo "</table>\n";
	}

	function generaArrayAnualSemanalS()
	{
		for($mes = 1; $mes<=12; $mes++)
		{
			$ultimodiames=$this->devuelveUltimoDiadelMes($mes,$this->Ano);
			for ($dia=1;$dia<=$ultimodiames;$dia++)
			{
				$numerodia=$this->devuelveNumeroDiadelaSemana($dia,$mes,$this->Ano);
				if($numerodia==0)
				{
					$array[]=array('numerodia'=>$numerodia,'ano'=>$this->Ano,'mes'=>$mes,'dia'=>$dia,'semana'=>$this->devuelveNumeroSemanaFecha($this->Ano,$mes,$dia));
				}
				if($numerodia==6)
				{
					$array[]=array('numerodia'=>$numerodia,'ano'=>$this->Ano,'mes'=>$mes,'dia'=>$dia,'semana'=>$this->devuelveNumeroSemanaFecha($this->Ano,$mes,$dia));
				}
			}
		}
		return $array;
	}

	function creaArrayAnualSemanal()
	{
		$contador=0;
		for($mes = 1; $mes<=12; $mes++)
		{
			$ultimodiames=$this->devuelveUltimoDiadelMes($mes,$this->Ano);
			for ($dia=1;$dia<=$ultimodiames;$dia++)
			{
				$numerodia=$this->devuelveNumeroDiadelaSemana($dia,$mes,$this->Ano);
				if($numerodia==0)
				{
					$fecha_ini=$this->Ano."-".$mes."-".$dia;
					$array[$contador]['fechaini']=$fecha_ini;
					$contador++;
				}
			}
		}
		return $array;
	}

	function iteradorSemanas()
	{
		$array_semanal=$this->creaArrayAnualSemanal();
		$fechaini=$array_semanal[$this->semana-1]['fechaini'];
		$fechafin=$this->sumarDiasaFecha($array_semanal[$this->semana-1]['fechaini'],6);
		
		$this->asignaFechaIniFin($fechaini,$fechafin);

		$fecha=$fechaini;
		for ($i=0;$i<=6;$i++)
		{
			list($ano,$mes,$dia)=explode("-",$fecha);
			$numerodia=$this->devuelveNumeroDiadelaSemana($dia,$mes,$ano);
			$diaTextual=$this->devuelveDia($numerodia);
			$array_fechas_semana[]=array('fecha'=>$fecha,'dia'=>$diaTextual);
			$fecha=$this->sumarDiasaFecha($fecha,1);
		}

		if($this->semana<52)
		{
			$this->semanaSiguiente=$this->semana+1;
		}
		if($this->semana>1)
		{
			$this->semanaAnterior=$this->semana-1;
		}
		echo "<table border=0 cellpadding=2 cellspacing=1>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td><a href='?semana=".$this->semanaAnterior."&dia=".$this->Dia."&mes=".$this->Mes."&ano=".$this->Ano."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'><<</a></td>\n";
		echo "    <td colspan='5' class='TituloMes'><p align='center'>Semana ".$this->semana." desde ".$fechaini." hasta ".$fechafin."</p></td>\n";
		echo "    <td><a href='?semana=".$this->semanaSiguiente."&dia=".$this->Dia."&mes=".$this->Mes."&ano=".$this->Ano."&codigosede=".$_GET['codigosede']."&codigosalon=".$_GET['codigosalon']."&Enviar'>>></a></td>\n";
		echo "  </tr>\n";
		echo "</table>\n";
		return $array_fechas_semana;
	}
	
	function asignaFechaIniFin($fechaini,$fechafin)
	{
		$this->fechaini=$fechaini;
		$this->fechafin=$fechafin;
	}

	function infoSemanas()
	{
		$array_semanal=$this->creaArrayAnualSemanal();
		$fechaini=$array_semanal[$this->semana-1]['fechaini'];
		$fechafin=$this->sumarDiasaFecha($array_semanal[$this->semana-1]['fechaini'],6);
		$fecha=$fechaini;
		for ($i=0;$i<=6;$i++)
		{
			list($ano,$mes,$dia)=explode("-",$fecha);
			$numerodia=$this->devuelveNumeroDiadelaSemana($dia,$mes,$ano);
			$diaTextual=$this->devuelveDia($numerodia);
			$array_fechas_semana[]=array('fecha'=>$fecha,'dia'=>$diaTextual);
			$fecha=$this->sumarDiasaFecha($fecha,1);
		}
		return $array_fechas_semana;
	}

	function sumarDiasaFecha($fecha,$dias)
	{
		$fechasuma=strtotime("+$dias day",strtotime($fecha));
		return date("Y-m-j",$fechasuma);
	}

	function devuelveNumeroSemana()
	{
		return date('W', $this->timeStamp);
	}

	function devuelveNumeroSemanaFecha($ano,$mes,$dia)
	{
		$fecha=mktime(0,0,0,$mes,$dia,$ano);
		return date('W', $fecha);
	}



	function mostrarHorario()
	{
		?>
		<script language="Javascript">
		function abrir()
		{
			window.open('programacionasesoriasdetalle.php','asesorias','width=400,height=250,top=160,left=160,scrollbars=yes,resizable=yes');
		}
		</script>
		<?php
		$final = $this->Off;

		echo "<table border=0 cellpadding=2 cellspacing=1>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesAnterior."&ano=".$this->AnoAnterior."&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'><<</a></td>\n";
		echo "    <td colspan='5' class='TituloMes'><p align='center'>".$this->NomeMes ." " .$this->Ano ."</p></td>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesPosterior."&ano=".$this->AnoPosterior."&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'>>></a></td>\n";
		echo "  </tr>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td>Domingo</td>\n";
		echo "    <td>Lunes</td>\n";
		echo "    <td>Martes</td>\n";
		echo "    <td>Miércoles</td>\n";
		echo "    <td>Jueves</td>\n";
		echo "    <td>Viernes</td>\n";
		echo "    <td>Sábado</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td ".$this->verificaHorario($final[0]);
		echo "    <td ".$this->verificaHorario($final[1]);
		echo "    <td ".$this->verificaHorario($final[2]);
		echo "    <td ".$this->verificaHorario($final[3]);
		echo "    <td ".$this->verificaHorario($final[4]);
		echo "    <td ".$this->verificaHorario($final[5]);
		echo "    <td ".$this->verificaHorario($final[6]);
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";;
		echo "    <td ".$this->verificaHorario($final[7]);
		echo "    <td ".$this->verificaHorario($final[8]);
		echo "    <td ".$this->verificaHorario($final[9]);
		echo "    <td ".$this->verificaHorario($final[10]);
		echo "    <td ".$this->verificaHorario($final[11]);
		echo "    <td ".$this->verificaHorario($final[12]);
		echo "    <td ".$this->verificaHorario($final[13]);
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td ".$this->verificaHorario($final[14]);
		echo "    <td ".$this->verificaHorario($final[15]);
		echo "    <td ".$this->verificaHorario($final[16]);
		echo "    <td ".$this->verificaHorario($final[17]);
		echo "    <td ".$this->verificaHorario($final[18]);
		echo "    <td ".$this->verificaHorario($final[19]);
		echo "    <td ".$this->verificaHorario($final[20]);
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td ".$this->verificaHorario($final[21]);
		echo "    <td ".$this->verificaHorario($final[22]);
		echo "    <td ".$this->verificaHorario($final[23]);
		echo "    <td ".$this->verificaHorario($final[24]);
		echo "    <td ".$this->verificaHorario($final[25]);
		echo "    <td ".$this->verificaHorario($final[26]);
		echo "    <td ".$this->verificaHorario($final[27]);
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td ".$this->verificaHorario($final[28]);
		echo "    <td ".$this->verificaHorario($final[29]);
		echo "    <td ".$this->verificaHorario($final[30]);
		echo "    <td ".$this->verificaHorario($final[31]);
		echo "    <td ".$this->verificaHorario($final[32]);
		echo "    <td ".$this->verificaHorario($final[33]);
		echo "    <td ".$this->verificaHorario($final[34]);
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td ".$this->verificaHorario($final[35]);
		echo "    <td ".$this->verificaHorario($final[36]);
		echo "    <td ".$this->verificaHorario($final[37]);
		echo "    <td ".$this->verificaHorario($final[38]);
		echo "    <td ".$this->verificaHorario($final[39]);
		echo "    <td ".$this->verificaHorario($final[40]);
		echo "    <td ".$this->verificaHorario($final[41]);
		echo "  </tr>\n";
		echo "</table>\n";
	}

	function mostrarHorarioInscripciones()
	{
		$final = $this->Off;

		echo "<table width=100% border=0 cellpadding=2 cellspacing=1>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesAnterior."&ano=".$this->AnoAnterior."&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'><<</a></td>\n";
		echo "    <td colspan='5' class='TituloMes'><p align='center'>".$this->NomeMes ." " .$this->Ano ."</p></td>\n";
		echo "    <td><a href='?dia=01&mes=".$this->MesPosterior."&ano=".$this->AnoPosterior."&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'>>></a></td>\n";
		echo "  </tr>\n";
		echo "  <tr class='TituloSemana'>\n";
		echo "    <td></td>\n";
		echo "    <td>Lunes</td>\n";
		echo "    <td>Martes</td>\n";
		echo "    <td>Miércoles</td>\n";
		echo "    <td>Jueves</td>\n";
		echo "    <td>Viernes</td>\n";
		echo "    <td>Sábado</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[0])."</td>\n";
		echo "    <td valign='top' width='150' height='150' ".$this->verificaHorarioInscripciones($final[1])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[2])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[3])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[4])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[5])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[6])."</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";;
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[7])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[8])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[9])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[10])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[11])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[12])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[13])."</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[14])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[15])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[16])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[17])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[18])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[19])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[20])."</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[21])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[22])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[23])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[24])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[25])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[26])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[27])."</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[28])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[29])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[30])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[31])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[32])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[33])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[34])."</td>\n";
		echo "  </tr>\n";
		echo "  <tr class='CorCelula'>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[35])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[36])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[37])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[38])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[39])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[40])."</td>\n";
		echo "    <td valign='top' width='150' height='150'".$this->verificaHorarioInscripciones($final[41])."</td>\n";
		echo "  </tr>\n";
		echo "</table>\n";
	}

	function subTablaAsesoriasProgramadas($array,$dia,$wrap="nowrap")
	{
		$encabezado=
		"<table width=100%  border=1 cellpadding=0 cellspacing=0>
		<tr>
			<td $wrap align='center' id='tdtitulogris'>Ini</td>
			<td $wrap align='center' id='tdtitulogris'>Fin</td>
			<td $wrap align='center' id='tdtitulogris'>Asesoría</td>
			<td $wrap align='center' id='tdtitulogris'>Cupo</td>
			<td $wrap align='center' id='tdtitulogris'>Disp</td>
			<td $wrap align='center' id='tdtitulogris'>Lst</td>
		</tr>
		";
		foreach ($array as $llave => $valor)
		{
			$cantidad_inscritos=$this->creaArrayInscripcionesHorario($valor['idhorariosesion'],"conteo");
			$cupo_disponible=$valor['cupomaximoasesoria'] - $cantidad_inscritos;
			$asesoria=$valor['asesoria'];
			$idasesoria=$valor['idasesoria'];
			$bgcolor=$valor['colormostrarasesoria'];
			$idhorariosesion=$valor['idhorariosesion'];
			if(isset($_GET['idusuario']) and $_GET['idusuario']<>"")
			{
				$idusuario=$_GET['idusuario'];
				$redireccionamiento="inscribir.php?idhorariosesion=$idhorariosesion&idusuario=$idusuario";
			}
			else
			{
				$redireccionamiento="inscripcion_busqueda_usuario.php?idhorariosesion=$idhorariosesion";
			}
			$cadena=$cadena.
			"<tr>
			<td $wrap>".substr($valor['horainicialhorariosesion'],0,5)."</td>
			<td $wrap>".substr($valor['horafinalhorariosesion'],0,5)."</td>
			<td $wrap bgcolor=$bgcolor><div align=center onclick=abrir('$redireccionamiento','inscripcion','width=850,height=600,top=50,left=50,scrollbars=yes,toolbar=no,resizable=yes,status=no,menu=no')>$asesoria</div></td>
			<td $wrap align=center>".$valor['cupomaximoasesoria']."</td>
			<td $wrap align=center>".$cupo_disponible."</td>
			<td $wrap align=center>"."<input name='radiobutton' type='radio' value='radiobutton' onclick=abrir('inscripcion_listado.php?idhorariosesion=$idhorariosesion','inscripcion','width=960,height=500,top=50,left=50,scrollbars=yes,toolbar=no,resizable=yes,status=no,menu=no');return false/>"."</td>
			</tr>
			";
		}
		$final="</table>";
		$links="
			<table width=100% border=1 cellpadding=0 cellspacing=0>
			<tr>
			<td align=center>Listado</td>
			<td align=center>Inscribir</td>
			</tr>
			</table>";
		$tabla_superior=$encabezado.$cadena.$final;
		return $tabla_superior;
	}

	function validaCupoDisponible($idhorariosesion,$idasesoria,$retorno="bool")
	{
		$parametros_asesoria=$this->leeParametrosAsesoria($idasesoria);
		$cupo_max_inscritos=$parametros_asesoria['cupomaximoasesoria'];
		$no_inscritos=$this->creaArrayInscripcionesHorario($idhorariosesion,"conteo");
		echo $cupo_max_inscritos,".",$no_inscritos;
	}

	function creaArrayInscripcionesHorario($idhorariosesion,$retorno="array")
	{
		$query="SELECT
		hs.idhorariosesion,
		hs.idasesoria,
		ihs.idinscripcionhorariosesion,
		ihs.fechainscripcionhorariosesion, 
		ihs.idusuario, 
		ihs.codigotipoasistencia, 
		ihs.codigoestado, 
		ihs.idhorariosesion, 
		ihs.idusuariosistema
		FROM 
		horariosesion hs,inscripcionhorariosesion ihs
		WHERE
		ihs.codigoestado='100'
		AND hs.idhorariosesion=ihs.idhorariosesion
		AND ihs.idhorariosesion='$idhorariosesion'
		";
		$operacion=$this->conexion->query($query);
		$numrows=$operacion->numRows();
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idasesoria']<>"")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		if($retorno=="conteo")
		{
			return count($array_interno);
		}
		elseif ($retorno=="array")
		{
			return $array_interno;
		}

	}



	function creaArrayHorarioDiarioAsesores()
	{
		$query_asesores="SELECT
		idasesor,concat(apellidosasesor,' ',nombresasesor) as nombre
		FROM asesor
		WHERE
		asesor.codigoestado=100
		ORDER BY nombre
		";
		$operacion=$this->conexion->query($query_asesores);
		$row_asesores=$operacion->fetchRow();
		do
		{
			$array_asesores[]=$row_asesores;
		}
		while($row_asesores=$operacion->fetchRow());
		$array_rango_horas=$this->creaArrayRangoHoras();
		$contador=0;
		foreach ($array_rango_horas as $llave_h => $valor_h)
		{
			$array_interno[$contador]['horaini']=$valor_h['horariorangoinicial'];
			$array_interno[$contador]['horafin']=$valor_h['horariorangofinal'];
			foreach ($array_asesores as $llave_a => $valor_a)
			{
				$array_interno[$contador][$valor_a['nombre']]=$this->verificaAsignacionHorarioAsesor($this->Ano,$this->Mes,$this->Dia,$valor_h['idhorariorango'],$valor_a['idasesor']);
			}
			$contador++;
		}
		return $array_interno;
	}

	function verificaHorarioInscripciones($var)
	{
		if (!empty($var))
		{

			$sql = "SELECT
			hs.*, 
			a.idasesoria,
			a.asesoria,
			a.cupomaximoasesoria,
			hs.horainicialhorariosesion,
			hs.horafinalhorariosesion,
			a.colormostrarasesoria
			FROM 
			horariosesion hs, asesoria a
			WHERE 
			hs.fechahorariosesion LIKE '$this->Ano-$this->Mes-" .$var ."%' 
			AND hs.codigoestado='100'
			AND hs.codigosede='$this->codigosede'
			AND hs.idasesoria=a.idasesoria
			ORDER BY hs.horainicialhorariosesion
			";
			$resultado=$this->conexion->query($sql);
			$row_resultado=$resultado->fetchRow();
			do
			{
				$array_interno[]=$row_resultado;
			}
			while ($row_resultado=$resultado->fetchRow());
			$nrows = $resultado->numRows();
			if ($nrows > 0)
			{
				//Si hay algo, bota esto
				//return "bgcolor='#D7EFF1' style='border: 1px solid black;'><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1' onclick='abrir();return false' >$var</a></td>\n";
				return "bgcolor='#F8F8F8' style='border: 1px solid black;'>".$var.$this->SubTablaAsesoriasProgramadas($array_interno,$var);
			}
			else
			{
				//return "bgcolor='#F8F8F8' style='border: 1px solid black;'><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1' onclick='abrir();return false' >$var</a></td>\n";
				return "bgcolor='#F8F8F8' style='border: 1px solid black;'>".$var;
			}
		}
		else
		{
			//Se for em branco nao retorna nada !
			return ">&nbsp;</td>\n";
		}
	}


	function verificaHorario($var)
	{
		if (!empty($var))
		{

			$sql = "SELECT
			* 
			FROM 
			horariosesion hs 
			WHERE 
			hs.fechahorariosesion LIKE '$this->Ano-$this->Mes-" .$var ."%' 
			AND hs.idasesor = '$this->idasesor' 
			AND hs.codigoestado='100'
			AND hs.codigosede='$this->codigosede'
			";
			$resultado=$this->conexion->query($sql);
			$nrows = $resultado->numRows();
			if ($nrows > 0)
			{
				//Si hay algo, bota esto
				//return "bgcolor='#D7EFF1' style='border: 1px solid black;'><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1' onclick='abrir();return false' >$var</a></td>\n";
				return "bgcolor='#FFFF00' style='border: 1px solid black;'><div align=center><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'>$var</a></div></td>\n";
			}
			else
			{
				//return "bgcolor='#F8F8F8' style='border: 1px solid black;'><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1' onclick='abrir();return false' >$var</a></td>\n";
				return "bgcolor='#F8F8F8' style='border: 1px solid black;'><div align=center><a href='$this->PaginaRaiz&dia=$var&mes=$this->Mes&ano=$this->Ano&filtra=1&codigosede=".$_GET['codigosede']."&idasesor=".$_GET['idasesor']."&idasesoria=".$_GET['idasesoria']."&Enviar'>$var</a></div></td>\n";
			}
		}
		else
		{
			//Se for em branco nao retorna nada !
			return ">&nbsp;</td>\n";
		}
	}

	function leerHorarioEstandar()
	{
		$query_rangos="SELECT * FROM horariorango hr
		WHERE
		hr.codigoestado=100";
		$operacion=$this->conexion->query($query_rangos);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_rangos[]=$row_operacion;
		}
		while($row_operacion=$operacion->fetchRow());
	}

	function creaArrayVerificacionHorarios($ano,$mes,$dia)
	{
		$query_rangos="SELECT hr.* FROM horariorango hr
		WHERE
		hr.codigoestado=100";
		$operacion=$this->conexion->query($query_rangos);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idhorariorango']<>"")
			{
				$asignado=$this->verificaAsignacionHorariosinAsesoria($ano,$mes,$dia,$row_operacion['idhorariorango']);
				$array_verificacion_horarios[]=array('idhorariorango'=>$row_operacion['idhorariorango'],'horariorangoinicial'=>$row_operacion['horariorangoinicial'],'horariorangofinal'=>$row_operacion['horariorangofinal'],'asignado'=>$asignado);
			}
		}
		while($row_operacion=$operacion->fetchRow());
		return $array_verificacion_horarios;
	}

	function generaRangosEstandar()
	{
		$array_rangos[]=array('hora_ini'=>'07:00:00','hora_fin'=>'08:00:00');
		$array_rangos[]=array('hora_ini'=>'08:00:00','hora_fin'=>'09:00:00');
		$array_rangos[]=array('hora_ini'=>'09:00:00','hora_fin'=>'10:00:00');
		$array_rangos[]=array('hora_ini'=>'10:00:00','hora_fin'=>'11:00:00');
		$array_rangos[]=array('hora_ini'=>'11:00:00','hora_fin'=>'12:00:00');
		$array_rangos[]=array('hora_ini'=>'12:00:00','hora_fin'=>'13:00:00');
		$array_rangos[]=array('hora_ini'=>'13:00:00','hora_fin'=>'14:00:00');
		$array_rangos[]=array('hora_ini'=>'14:00:00','hora_fin'=>'15:00:00');
		$array_rangos[]=array('hora_ini'=>'15:00:00','hora_fin'=>'16:00:00');
		$array_rangos[]=array('hora_ini'=>'16:00:00','hora_fin'=>'17:00:00');
		$array_rangos[]=array('hora_ini'=>'17:00:00','hora_fin'=>'18:00:00');
		$array_rangos[]=array('hora_ini'=>'18:00:00','hora_fin'=>'19:00:00');
		$array_rangos[]=array('hora_ini'=>'19:00:00','hora_fin'=>'20:00:00');
		$array_rangos[]=array('hora_ini'=>'20:00:00','hora_fin'=>'21:00:00');
		$array_rangos[]=array('hora_ini'=>'21:00:00','hora_fin'=>'22:00:00');
		return $array_rangos;
	}

	function crea_array_verificacion_horarios()
	{
		foreach ($this->array_rango_horas as $llave => $valor)
		{
			$this->array_verificacion_horarios[$valor['idhorariorango']]=$this->verificaAsignacionHorario($this->Ano,$this->Mes,$this->Dia,$valor['idhorariorango'],$this->idasesor,"bool");

		}
	}

	function verificaAsignacionHorario($ano,$mes,$dia,$idhorariorango,$idasesor,$retorno="array")
	{
		$datos_horariorango=$this->leeHorarioRango($idhorariorango);
		$horainicial=$datos_horariorango['horariorangoinicial'];
		$horafinal=$datos_horariorango['horariorangofinal'];

		$query="SELECT
		hs.idhorariosesion,a.asesoria, hs.idasesoria, hs.fechahorariosesion, hs.horainicialhorariosesion, hs.horafinalhorariosesion
		FROM 
		horariosesion hs, asesoria a
		WHERE 
		hs.fechahorariosesion LIKE '$ano-$mes-".$dia."%' 
		AND hs.idasesor = '$idasesor' 
		AND hs.codigoestado='100'
		AND hs.codigosede='$this->codigosede'
		AND hs.idasesoria=a.idasesoria
		AND '$horainicial' >= hs.horainicialhorariosesion
		AND '$horafinal'  <= hs.horafinalhorariosesion
		";

		$operacion=$this->conexion->query($query);
		if($retorno=="array")
		{
			$row_operacion=$operacion->fetchRow();
			do
			{
				$array_verificacion[]=$row_operacion;
			}
			while ($row_operacion=$operacion->fetchRow());
			return $array_verificacion;
		}
		elseif ($retorno=="bool")
		{
			$numRows=$operacion->numRows();
			if($numRows>=1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function verificaAsignacionHorarioAsesor($ano,$mes,$dia,$idhorariorango,$idasesor,$retorno="asesoria")
	{
		$datos_horariorango=$this->leeHorarioRango($idhorariorango);
		$horainicial=$datos_horariorango['horariorangoinicial'];
		$horafinal=$datos_horariorango['horariorangofinal'];
		$query="SELECT
		hs.idhorariosesion,a.asesoria, hs.idasesoria, hs.fechahorariosesion, hs.horainicialhorariosesion, hs.horafinalhorariosesion, a.colormostrarasesoria
		FROM 
		horariosesion hs, asesoria a
		WHERE 
		hs.fechahorariosesion LIKE '$ano-$mes-".$dia."%' 
		AND hs.idasesor = '$idasesor' 
		AND hs.codigoestado='100'
		AND hs.codigosede='$this->codigosede'
		AND hs.idasesoria=a.idasesoria
		AND '$horainicial' >= hs.horainicialhorariosesion
		AND '$horafinal'  <= hs.horafinalhorariosesion
		";
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();

		if($row_operacion['idhorariosesion']<>"")
		{
			if($retorno=='asesoria')
			{
				return $row_operacion['asesoria'];
			}
			else
			{
				return $row_operacion;
			}
		}
		else
		{
			return false;
		}
	}

	function verificaExistenciaPlaneador($idhorariosesion,$idasesor)
	{
		$query="SELECT
		phs.idplaneadorhorariosesion
		FROM planeadorhorariosesion phs
		WHERE
		phs.idhorariosesion='$idhorariosesion'
		AND phs.idasesor='$idasesor'
		AND phs.codigoestado=100
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($row_operacion['idplaneadorhorariosesion']<>"")
		{
			return $row_operacion['idplaneadorhorariosesion'];
		}
		else
		{
			return false;
		}
	}

	function verificaRequerimientoPlaneador($idasesoria)
	{
		$query="SELECT a.codigorequiereplaneador
		FROM
		asesoria a
		WHERE
		a.idasesoria='$idasesoria'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($row_operacion['codigorequiereplaneador']==100)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function verificaAsignacionHorariosinAsesoria($ano,$mes,$dia,$idhorariorango,$retorno="array")
	{
		$datos_horariorango=$this->leeHorarioRango($idhorariorango);
		$horainicial=$datos_horariorango['horariorangoinicial'];
		$horafinal=$datos_horariorango['horariorangofinal'];

		$query="SELECT
		hs.idhorariosesion,a.asesoria, hs.idasesoria, hs.fechahorariosesion, hs.horainicialhorariosesion, hs.horafinalhorariosesion
		FROM 
		horariosesion hs, asesoria a
		WHERE 
		hs.fechahorariosesion LIKE '$ano-$mes-".$dia."%' 
		AND hs.idasesor = '$idasesor' 
		AND hs.codigoestado='100'
		AND hs.codigosede='$this->codigosede'
		AND hs.idasesoria=a.idasesoria
		AND '$horainicial' >= hs.horainicialhorariosesion
		AND '$horafinal'  <= hs.horafinalhorariosesion
		";

		$operacion=$this->conexion->query($query);
		if($retorno=="array")


		{
			$row_operacion=$operacion->fetchRow();
			do
			{
				$array_verificacion[]=$row_operacion;
			}
			while ($row_operacion=$operacion->fetchRow());
			return $array_verificacion;
		}
		elseif ($retorno=="bool")
		{
			$numRows=$operacion->numRows();
			if($numRows>=1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}


	function asignaDatosHorariosesion($ano,$mes,$dia,$idhorariorango,$idusuariosistema,$cerrar=false)
	{
		$huecolibre=true;

		$datos_rango=$this->leeHorarioRango($idhorariorango);
		$datos_asesoria=$this->leeParametrosAsesoria($this->idasesoria);
		$duracionminutosasesoria=$datos_asesoria['duracionminutosasesoria'];
		$horainicialhorariosesion=$datos_rango['horariorangoinicial'];
		$asignacion_rango_inferior=$this->array_verificacion_horarios[$idhorariorango-1];
		$asignacion_rango=$this->array_verificacion_horarios[$idhorariorango];
		$asignacion_rango_superior=$this->array_verificacion_horarios[$idhorariorango+1];

		//se le suman los minutos de duracion que vengan de la tabla asesoria, para poder calcular la hora final
		list($hora1, $minut) = split('[:]', $horainicialhorariosesion);
		$horafinalhorariosesion=date("H:i", mktime($hora1, $minut+$duracionminutosasesoria, 0));

		if(empty($ano) or empty($mes) or empty($dia))
		{
			echo "<script language='javascript'>alert('No ha seleccionado fecha para anular asesorías en la programación');submitir()</script>";
		}
		else
		{
			$fecha=$ano."-".$mes."-".$dia;
			//$verificacionExistenciaHorario=$this->verificaAsignacionHorario($ano,$mes,$dia,$idhorariorango,$this->idasesor,"bool");
			if($duracionminutosasesoria>50)
			{
				if($asignacion_rango_superior==true)
				{
					$huecolibre=false;
				}
			}

			//si no esta asignado, y los huecos adyacentes en caso de que la asesoria dure mas de un bloque esten libres, entonces efectua insert
			if($asignacion_rango==false and $huecolibre==true)
			{

				$query="INSERT INTO horariosesion (fecharegistrohorariosesion, fechahorariosesion, idasesor, idasesoria, codigosede, codigoestado, idusuariosistema, horainicialhorariosesion, horafinalhorariosesion)
				VALUES
				('$this->fechahoy','$fecha', '$this->idasesor', '$this->idasesoria','$this->codigosede','100','$idusuariosistema','$horainicialhorariosesion','$horafinalhorariosesion')";
				$operacion=$this->conexion->query($query);
				if($operacion)
				{
					echo "<script language='javascript'>alert('Asesoría programada');</script><script language='javascript'>window.close();</script><script language='javascript'>window.opener.submitir()</script>";
				}
			}
			else
			{
				if($huecolibre==false)
				{
					echo "<script language='javascript'>alert('Error, el horario en este bloque no está asignado, pero la asesoría requiere de más bloques que no se encuentran disponibles');</script>";

				}
				else
				{
					echo "<script language='javascript'>alert('Error, el horario en este bloque ya ha sido asignado previamente');</script>";
				}
				exit();
			}
		}
	}

	function retornaAsesoria($idasesoria)
	{
		$query="SELECT a.asesoria
		FROM asesoria a
		WHERE
		a.idasesoria='$idasesoria'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$asesoria=$row_operacion['asesoria'];
		if($asesoria<>"")
		{
			return $asesoria;
		}
	}

	function leeParametrosAsesoria($idasesoria)
	{

		$query="SELECT a.*
		FROM asesoria a
		WHERE
		a.idasesoria='$idasesoria'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function verificaAsignacionHorarioSalon($ano,$mes,$dia,$hora_ini,$hora_fin)
	{
		$fecha=$ano."-".$mes."-".$dia;
		return $fecha;
	}

	function DibujarTabla($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP><h1>$texto</h1></caption>";
			$this->EscribirCabeceras($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				$MostrarConteo=$i+1;
				echo "<tr>\n";
				echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}

	}

	function EscribirCabeceras($matriz)
	{
		echo "<tr>\n";
		echo "<td>Conteo</a></td>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}


	function obtenerHorarioSalonconHorariodetallefecha($codigosalon,$fecha,$hora_ini,$hora_fin)
	{
		list($ano,$mes,$dia)=explode("-",$fecha);
		$codigodia_calendario=$this->devuelveNumeroDiadelaSemana($dia,$mes,$ano);
		
		$codigodia_bd=$codigodia_calendario+1;
		
		$query="SELECT
		h.idhorario,
		hdf.idhorariodetallefecha,
		h.idgrupo,
		h.codigodia,
		d.nombredia,
		DATE_FORMAT(hdf.fechadesdehorariodetallefecha,'%Y-%c-%e') AS fechadesdehorariodetallefecha,
		DATE_FORMAT(hdf.fechahastahorariodetallefecha,'%Y-%c-%e') AS fechahastahorariodetallefecha,
		h.horainicial,
		h.horafinal,
		h.codigosalon,
		ts.nombretiposalon,
		s.codigotiposalon,
		se.nombresede,
		se.codigosede,
		h.codigoestado,
		g.idgrupo,
		g.codigoperiodo,
		m.codigomateria,
		m.nombremateria,
		m.codigocarrera,
		c.nombrecarrera
		FROM
		horario h, dia d, grupo g, materia m, horariodetallefecha hdf, salon s, sede se, tiposalon ts, carrera c
		WHERE
		h.codigosalon='$codigosalon'
		AND g.codigoperiodo='$this->codigoperiodo'
		AND h.codigodia=d.codigodia
		AND h.codigoestado='100'
		AND h.idgrupo=g.idgrupo
		AND g.codigomateria=m.codigomateria
		AND hdf.idhorario=h.idhorario
		AND h.codigosalon=s.codigosalon
		AND s.codigosede=se.codigosede
		AND s.codigotiposalon=ts.codigotiposalon
		AND m.codigocarrera=c.codigocarrera
		AND hdf.codigoestado='100'
		AND '$fecha' >= hdf.fechadesdehorariodetallefecha  
		AND '$fecha' <= hdf.fechahastahorariodetallefecha
		AND '$hora_ini' >= h.horainicial
		AND '$hora_fin' <= h.horafinal
		AND h.codigodia='$codigodia_bd'
		";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($this->depurar==true)
		{
			echo $query,"<br><br>";
			print_r($row_operacion);
			echo "<br><br>";
		}
		return $row_operacion;
	}
	
	function obtenerColorHorario($codigocarrera)
	{
		$query="SELECT cch.nombrecarreracolorhorario FROM carreracolorhorario cch WHERE cch.codigocarrera='$codigocarrera'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion['nombrecarreracolorhorario'];
	} 

}
?>