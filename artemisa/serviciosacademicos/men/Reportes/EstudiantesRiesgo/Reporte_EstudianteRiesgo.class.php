<?PHP 
class Estudiante_Riesgo{
	
	public function Principal(){#public function Principal()
		
		global $userid,$db;
		
		?>
        <fieldset style="width:98%;">
            	<legend>Listado De Estudiantes En Riesgo Por Semestre</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP $this->Periodo()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera()" /><input type="hidden" id="id_carrera"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar()" title="Todas las Carreras" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Semestre</strong></td>
                        <td><?PHP $this->Semestre()?></td>
                    </tr>
                 	<tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Riesgo</strong></td>
                        <td><?PHP $this->Riesgo()?></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="5" align="center"><input type="button" id="Buscar" onclick="Buscar()" value="Buscar" style="cursor:pointer" /></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div id="DivReporte" align="center" style="width:100%; height:500;" ></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
		<?PHP
		}#public function Principal()
	public function Periodo(){
		
		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodo" name="Periodo" style="width:100%; text-align:center">
            	<option value="-1">Selecionar</option>
                <?PHP 
					while(!$Periodo->EOF){
						?>
                        <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                        <?PHP	
						$Periodo->MoveNext();
					}
				?>    
            </select>
            <?PHP	
		}
	public function Semestre(){
		
		global $userid,$db;
		
		?>
        <select id="Semestre" name="Semestre" style="text-align:center">
        	<option value="-1">Seleccionar</option>
            <?PHP
		for($i=1;$i<13;$i++){
			/**********************************/
			?>
            <option value="<?PHP echo $i?>"><?PHP echo $i?></option>
            <?PHP
			/**********************************/
			}
			?>
        </select>
		<?PHP
		}
	public function Riesgo(){
		
		global $userid,$db;
		
		?>
        <select id="Riesgo" name="Riesgo" style="text-align:center">
        	<option value="-1">Seleccionar</option>
            <option value="1">Alto</option>
            <option value="2">Medio</option>
            <option value="3">Bajo</option>
            <option value="0">Sin Riesgo</option>
        </select>
		<?PHP
		}	
	public function Buscar($id_carrera,$Periodo,$Semestre,$Riesgo){
		
		global $userid,$db;
		
		
		
		
		 $SQL_Consulta="select distinct 
						e.codigoestudiante, 
						concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, 
						eg.numerodocumento, 
						e.codigoperiodo 
						
						from 
						
						prematricula p, 
						estudiante e, 
						estudiantegeneral eg, 
						detalleprematricula dp 
						
						where 
						
						e.codigoestudiante = p.codigoestudiante 
						and 
						eg.idestudiantegeneral = e.idestudiantegeneral 
						and 
						p.codigoestadoprematricula like '4%' 
						and 
						p.codigoperiodo = '".$Periodo."' 
						and 
						p.semestreprematricula = '".$Semestre."' 
						and 
						e.codigocarrera = '".$id_carrera."'
						and 
						dp.idprematricula = p.idprematricula 
						and 
						dp.codigoestadodetalleprematricula like '3%'
						
						order by 2 ";
						
				if($Consulta=&$db->Execute($SQL_Consulta)===false){
						echo 'Error en el SQL Consulta....<br><br><span style="color:red">'.$SQL_Consulta.'</span>';
						die;
					}		
		
		switch($Riesgo){
			case '1':{$this->Riesgo_Alto();}break;#Alto
			case '2':{$this->Riesgo_Medio();}break;#Medio
			case '3':{$this->Riesgo_Bajo();}break;#Bajo
			case '0':{$this->SinRiesgo($Consulta,$Periodo);}break;#Sin Riesgo
			}
		
		?>
    	
        <?PHP
		}
	public function Riesgo_Alto(){
		
		global $userid,$db;
		
		}
	public function Riesgo_Medio(){
		
		global $userid,$db;
		
		}
	public function Riesgo_Bajo(){
		
		global $userid,$db;
		
		}
	public function SinRiesgo($Consulta,$Periodo){
		
		global $userid,$db,$sala;
		
		require_once('../../../Connections/sala2.php');
		$rutaado = ("../../../funciones/adodb/");
		require_once('../../../Connections/salaado.php');  
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

$objetobase = new BaseDeDatosGeneral($sala);

		$rutaado = "../../../funciones/adodb/";
		#require_once('../../../funciones/sala/nota/nota.php');
		require_once('../../../funciones/sala/estudiante/estudiante.php');
		//$rutazado = "../../../funciones/zadodb/";
		
		require_once('../../../funciones/sala/nota/nota.php');
		require ('../../../funciones/notas/redondeo.php');
		require('../../../funciones/notas/funcionequivalenciapromedio.php');

		?>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Periodo Ingreso</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
        <tbody>
          		<?PHP 
				
					if(!$Consulta->EOF){
						$i=1;
						while(!$Consulta->EOF){
							/*********************************/
							
							unset($detallenota);
							$codigoestudiante = $Consulta->fields['codigoestudiante'];
							$detallenota = new detallenota($codigoestudiante, $Periodo);
							$detallenota->setAcumuladoCertificado("1");
							
							/*********************************/
							
							
							 if (!$detallenota->esAltoRiesgo($sala) && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
								?>
								<tr class="odd_gradeX">
									<td align="center"><?PHP echo $i?></td>
									<td><?PHP echo $Consulta->fields['numerodocumento']?></td>
									<td><?PHP echo $Consulta->fields['nombre']?></td>
									<td><?PHP echo $Consulta->fields['codigoperiodo']?></td>
								</tr>
								<?PHP
								$i++;
							 }
							$Consulta->MoveNext();
							}   
						}else{
							?>
                            <tr class="odd_gradeX">
                            	<td align="center" colspan="4"><strong>No Hay Informacion...</strong></td>
                            </tr>
                            <?PHP
							}
				?>   
            </tbody>
        </table>
		<?PHP
		}	
	public function FormatFecha($fecha){
		
		global $userid,$db;
		
		
			$D_Fecha = explode('-',$fecha);
			
			
			$D_Fecha[0];#Año
			$D_Fecha[1];#Mes
			$D_Fecha[2];#Dia
			
			$New_Fecha = $D_Fecha[2].'/'.$D_Fecha[1].'/'.$D_Fecha[0];
			
			echo $New_Fecha;
			
		}	
}#Class
	
