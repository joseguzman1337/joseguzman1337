<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php' );
require_once(realpath(dirname(__FILE__)).'/../../../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/errores_plandeestudio.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/funciontiempo.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/funcionip.php');
$rutaado=('../../../funciones/adodb/');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/DatosGenerales.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');
require_once(realpath(dirname(__FILE__)).'/clasearboldesicionhorario.php');


function encuentracrucehorario($codigoestudiante,$codigoperiodo,$objetobase)
{

//$objetobase=new BaseDeDatosGeneral($sala);

$query_horarioinicial = "SELECT g.idgrupo, d.codigomateria 
FROM grupo g, detalleprematricula d, estudiante e, prematricula p 
where e.codigoestudiante = p.codigoestudiante 
and p.idprematricula = d.idprematricula 
and p.codigoperiodo = '$codigoperiodo' 
and g.codigoperiodo = p.codigoperiodo 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and e.codigoestudiante = '$codigoestudiante' 
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '2%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=$objetobase->conexion->query($query_horarioinicial);
$totalRows_premainicial1 = $horarioinicial->RecordCount();
$tienehorario = false;
while($row_horarioinicial = $horarioinicial->FetchRow())
{
	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	$tiene_prema = true;
	
	//$rama[1][$row_horarioinicial['codigomateria']]=$row_horarioinicial['idgrupo'];

	//echo $row_horarioinicial['idgrupo']."<br>";
	//$tienehorario = true;
}

$query_horarioinicial = "SELECT h.idgrupo, d.codigomateria, g.* 
FROM horario h, grupo g, detalleprematricula d, estudiante e, prematricula p 
where h.idgrupo = d.idgrupo 
and e.codigoestudiante = p.codigoestudiante 
and p.idprematricula = d.idprematricula 
and p.codigoperiodo = '$codigoperiodo' 
and g.codigoperiodo = p.codigoperiodo 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and e.codigoestudiante = '$codigoestudiante' 
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '1%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=$objetobase->conexion->query($query_horarioinicial);
$totalRows_premainicial1 = $horarioinicial->RecordCount();
$tienehorario = false;
$tiene_prema = false;
while($row_horarioinicial = $horarioinicial->FetchRow())
{


	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	//echo $row_horarioinicial['idgrupo']."<br>";

	$tienehorario = true;
	$tiene_prema = true;
	
}



				
for($i=0;$i<count($grupo_inicial);$i++)
{

				$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, 
				g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, 
				g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo 
				from grupo g, docente d
				where g.numerodocumento = d.numerodocumento
				and g.codigomateria = '".$materia_inicial[$i]."'
				and g.idgrupo = '".$grupo_inicial[$i]."'
				and g.codigoperiodo = '$codigoperiodo'
				and g.codigoestadogrupo = '10'";				
				$datosgrupos=$objetobase->conexion->query($query_datosgrupos);
				$totalRows_datosgrupos = $datosgrupos->RecordCount();
			if($totalRows_datosgrupos != "")
			{

				while ($row_datosgrupo = $datosgrupos->FetchRow()){
					/*echo "<br>&nbsp;---->";
					print_r($row_datosgrupo);
					echo "<br>";*/					
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['maximogrupo']=$row_datosgrupo['maximogrupo'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['matriculadosgrupoelectiva']=$row_datosgrupo['matriculadosgrupoelectiva'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['matriculadosgrupo']=$row_datosgrupo['matriculadosgrupo'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['nombredocente']=$row_datosgrupo['nombre'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['nombregrupo']=$row_datosgrupo['nombregrupo'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['fechainiciogrupo']=$row_datosgrupo['fechainiciogrupo'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['fechafinalgrupo']=$row_datosgrupo['fechafinalgrupo'];
					$estructuramateriashorarios[$materia_inicial[$i]][$row_datosgrupo['idgrupo']]['codigoindicadorhorario']=$row_datosgrupo['codigoindicadorhorario'];
				}
			}



	$query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, d.nombredia,d.codigodia,h.idhorario
						from horario h, dia d, salon s
						where h.codigodia = d.codigodia
						and h.codigosalon = s.codigosalon
						and h.idgrupo = '".$grupo_inicial[$i]."'
						order by 1,2,3";
	$datoshorarios=$objetobase->conexion->query($query_datoshorarios);
		//echo "$query_datoshorarios<br>";
	$totalRows_datoshorarios = $datoshorarios->RecordCount();
	$conhorario=0;
	while ($row_datoshorarios = $datoshorarios->FetchRow()){


		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['horainicial']=$row_datoshorarios['codigodia']*10000+horaaminutos($row_datoshorarios['horainicial']);
		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['horafinal']=$row_datoshorarios['codigodia']*10000+horaaminutos($row_datoshorarios['horafinal']);
		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['dia']=$row_datoshorarios['codigodia'];
		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['salon']=$row_datoshorarios['codigosalon'];
		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['nombredia']=$row_datoshorarios['nombredia'];
		$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['idhorario']=$row_datoshorarios['idhorario'];

										$query_detallehorarios = "select dh.idhorariodetallefecha,dh.fechadesdehorariodetallefecha,dh.fechahastahorariodetallefecha
										from horariodetallefecha dh
										where dh.codigoestado=100
										and dh.idhorario =".$row_datoshorarios['idhorario'];
											$datosdetallehorarios=$objetobase->conexion->query($query_detallehorarios);
											//echo "$query_datoshorarios<br>";
											$totalRows_detallehorarios = $datosdetallehorarios->RecordCount();
											while ($row_detallehorarios = $datosdetallehorarios->FetchRow()){
											//print_r($row_detallehorarios);
												$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['detallehorario'][$row_detallehorarios['idhorariodetallefecha']]['fechadesde']=$row_detallehorarios['fechadesdehorariodetallefecha'];
												$estructuramateriashorarios[$materia_inicial[$i]][$grupo_inicial[$i]][$conhorario]['detallehorario'][$row_detallehorarios['idhorariodetallefecha']]['fechahasta']=$row_detallehorarios['fechahastahorariodetallefecha'];
											}
										$conhorario++;		
	}
}


//echo  "ESTRUCTURA HORARIOS<pre>";
//echo print_r($estructuramateriashorarios);
//echo "</pre>";

$objetohorarios=new arbolDesicionHorario($estructuramateriashorarios,"","","","",$objetobase);
$contadorcruce=0;
foreach ($estructuramateriashorarios as $materiai => $grupos){
			foreach ($grupos as $grupoi => $obj){

				if(!$cruce=$objetohorarios->cruceHorario($grupoi,$materiai,$rama)){
				
					$rama[1][$materiai]=$grupoi;				
	
					for($rh=0;$rh<count($estructuramateriashorarios[$materiai][$grupoi]);$rh++)
						if(!empty($estructuramateriashorarios[$materiai][$grupoi][$rh]['horainicial']))
						{
							$rama['horarios'][$estructuramateriashorarios[$materiai][$grupoi][$rh]['horainicial']]['horafinal']=$estructuramateriashorarios[$materiai][$grupoi][$rh]['horafinal'];
							$rama['horarios'][$estructuramateriashorarios[$materiai][$grupoi][$rh]['horainicial']]['ramamateria']=$materiai;
							$rama['horarios'][$estructuramateriashorarios[$materiai][$grupoi][$rh]['horainicial']]['ramagrupo']=$grupoi;
						}				

				}
				else
				{
				$contadorcruce++;
					$rama[2][$contadorcruce]=array($materiai=>$grupoi,$cruce[0] => $cruce[1]);
					
				}					


}
}
			
//echo  "RAMA<pre>";
//echo print_r($rama);
//echo "</pre>";



return $rama[2];
}

$objetobase=new BaseDeDatosGeneral($sala);
$query="select distinct e.codigoestudiante,eg.numerodocumento,eg.apellidosestudiantegeneral,
		eg.nombresestudiantegeneral from
		prematricula p,horario h,estudiante e ,detalleprematricula dp, grupo g,
		estudiantegeneral eg
		where 
		e.codigoestudiante=p.codigoestudiante and
		dp.codigoestadodetalleprematricula in (30,10)and
		dp.idprematricula=p.idprematricula and
		dp.idgrupo=g.idgrupo and 
		g.idgrupo=h.idgrupo and 
		e.codigocarrera=".$_GET['codigocarrera']." and
		p.codigoperiodo=".$_GET['codigoperiodo']." and 
		eg.idestudiantegeneral=e.idestudiantegeneral 
		order by e.codigoestudiante";
$resultado=$objetobase->conexion->query($query);
echo "<table>";
echo "<tr><td><B>No</B></td><td><B>DOCUMENTO</B></td><td><B>APELLIDOS</B></td><td><B>NOMBRES</B></td>
    <td><B>MATERIA 1</B></td><td><B>GRUPO 1</B></td><td><B>MATERIA 2</B></td><td><B>GRUPO 2</B></td></tr>";
$i=1;
while($row=$resultado->fetchRow()){

$arraycruces=encuentracrucehorario($row['codigoestudiante'],$_GET['codigoperiodo'],$objetobase);
if(is_array($arraycruces)){
//	echo $row['numerodocumento']."<br>";

	echo  "<tr><td>".$i++."</td><td>".$row['numerodocumento']."</td><td>".$row['apellidosestudiantegeneral'].
    "</td><td>".$row['nombresestudiantegeneral']."</td>";

	foreach ($arraycruces[1] as $clave=>$grupo ){
            $tabla="materia m,grupo g";
            $nombreidtabla="idgrupo";
            $idtabla=$grupo;
            $condicion=" and g.codigomateria=m.codigomateria";
           $datoscrucemateria= $objetobase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion);

	echo  "<td>".$datoscrucemateria["nombremateria"]."</td><td>".$grupo."</td>";
	
        }
        echo "</tr>";
	/*"<pre>";
	echo print_r($arraycruces);
	echo "</pre>";*/
}
unset($arraycruces);
}



?>