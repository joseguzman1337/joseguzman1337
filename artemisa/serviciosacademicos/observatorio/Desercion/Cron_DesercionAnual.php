<?php
	/*
	* Ivan dario Quintero Rios
	* Actualizacion de conexion de base de datos y limpieza de codigo
	* septiembre 1 del 2017
	*/

	require_once('../../Connections/sala2.php'); 
	require("../../funciones/funcionpassword.php");
	$rutaado = "../../funciones/adodb/";
	require_once('../../Connections/salaado.php');

	
	include ('../templates/mainjson.php');
    include ('Desercion_class.php');  
	$C_Desercion = new Desercion();
    
	$SQL='select codigoperiodo, nombreperiodo, codigoestadoperiodo 
	from periodo
	where codigoperiodo >= (select max(codigoperiodo) from periodo where codigoestadoperiodo=2 and 
	codigoperiodo < (select codigoperiodo from periodo where codigoestadoperiodo=1)) and codigoperiodo <= (select codigoperiodo from periodo where codigoestadoperiodo = 1 ) limit 1';
	$Periodos = $db->GetRow($SQL);
	
    for($O=1;$O<=2;$O++)
	{  
    	$CodigoPeriodo	= substr($Periodos['codigoperiodo'],0, -1).$O;
    	$PeriodoAnual   = $C_Desercion->PeriodosAnuales($CodigoPeriodo);
    	$D_Anual    = $C_Desercion->DesercionAnual($CodigoPeriodo); 
    	$cont_D_Anual = (int) count($D_Anual);	 
		
    	echo "Contador: ".$cont_D_Anual."<br>";
		
		for($j=0;$j<$cont_D_Anual;$j++)
		{	
			if(strlen($D_Anual[$j]['t+2'])=='5')
			{
				echo "#: ".$j." carrera actualizadas: ".$D_Anual[$j]['codigocarrera']."<br>";
				
				$SQL='SELECT d.id_desercion as id FROM 
					desercion d 
					WHERE
					d.codigocarrera="'.$D_Anual[$j]['codigocarrera'].'"
					AND
					d.codigoestado=100
					AND
					d.tipodesercion=1';

				$Consulta=$db->GetRow($SQL);		

				if($Consulta['id']== 0)
				{	
					//Si no exite un registro de la deserccion para la carrera se debe crear
					$SQL_Insert='INSERT INTO desercion(codigocarrera,tipodesercion,entrydate)VALUES("'.$D_Anual[$j]['codigocarrera'].'","1",NOW())';  			
					$db->Execute($SQL_Insert);
					$Last_id=$db->Insert_ID();            				
				}
				else
				{
					//Si ya exite un registro para la deserccion se actualiza la fecha de cargue
					$Up_Sql='UPDATE desercion
							 SET    changedate=NOW()
							 WHERE  codigocarrera="'.$D_Anual[$j]['codigocarrera'].'"  AND  tipodesercion=1  AND  codigoestado=100 AND id_desercion="'.$Consulta['id'].'"';		
					$db->Execute($Up_Sql);
					$Last_id=$Consulta['id'];

				}//if 					
			
				$SQLDetalle='SELECT 
							 id_detalledesercion
							 FROM deserciondetalle 
							 WHERE  
							 id_desercion="'.$Last_id.'"
							 AND
							 codigoestado=100
							 AND
							 desercionperiodo="'.$D_Anual[$j]['t+2'].'"'; 				
				$Detalle=$db->GetRow($SQLDetalle);


				if(empty($Detalle['id_detalledesercion']))
				{
					//crea el registro de la informacion 
					$SQL_InsertDetalle='INSERT INTO deserciondetalle
					(id_desercion,matriculados,desercion,entrydate,periodos,desercionperiodo)
					VALUES
					("'.$Last_id.'","'.$D_Anual[$j]['Total_Matriculados'].'","'.$D_Anual[$j]['Desercion_Anual'].'",NOW(),"'.$D_Anual[$j]['periodos'].'","'.$D_Anual[$j]['t+2'].'")';
					$db->Execute($SQL_InsertDetalle);           
					$Last_Detalle=$db->Insert_ID();				
				}
				else
				{
					//Actualiza el registro de desercciondetalle con los nuevos valores 
					$Up_Detalle='UPDATE  deserciondetalle
								 SET     matriculados="'.$D_Anual[$j]['Total_Matriculados'].'",
										 desercion="'.$D_Anual[$j]['Desercion_Anual'].'",
										 changedate=NOW(),
										 periodos="'.$D_Anual[$j]['periodos'].'",
										 desercionperiodo="'.$D_Anual[$j]['t+2'].'"
								 WHERE
										 id_desercion="'.$Last_id.'"
										 AND
										 codigoestado=100
										 AND
										 desercionperiodo="'.$D_Anual[$j]['t+2'].'"
										 AND
										 id_detalledesercion="'.$Detalle['id_detalledesercion'].'"';        				
					$db->Execute($Up_Detalle);
					$Last_Detalle=$Detalle['id_detalledesercion'];
				}//else
				
				
				//inicia proceso de los estudiantes en deserccion
				$C_CodigoEstudiante  = $D_Anual[$j]['Estudiante'];

				$cont_C_CodigoEstudiante = (int) count($C_CodigoEstudiante);			

				for($l=0;$l<$cont_C_CodigoEstudiante;$l++)
				{            
					$CodigoEstudiante   = $C_CodigoEstudiante[$l];

					$SQL_3='SELECT id_desercionestudiante FROM   
							desercionEstudiante WHERE
							id_detalledesercion="'.$Last_Detalle.'"
							AND
							codigoestudiante="'.$CodigoEstudiante.'"';

					$Existe=$db->GetRow($SQL_3);

					if($Existe['id_desercionestudiante']=="")
					{    
						//Crea el registro del estudiante en desercion
						$InsertEstudiante='INSERT INTO desercionEstudiante(id_detalledesercion,codigoestudiante,entrydate)VALUES("'.$Last_Detalle.'","'.$CodigoEstudiante.'",NOW())';
						$DetalleEstudiante=$db->Execute($InsertEstudiante);   
					}else
					{
						//actualiza los datos del estudiante en deserccion
						$UPDATE='UPDATE  desercionEstudiante SET     changedate=NOW()        
								WHERE  id_detalledesercion="'.$Last_Detalle.'"
								AND codigoestudiante="'.$CodigoEstudiante.'"';                                					
						$db->Execute($UPDATE);            
					}//else
				}//for	
				
				//consulta el estrao del estudiante 
				$Estratos = $C_Desercion->EstratoEstudiantes($D_Anual[$j],1);

				if(array_search('No_Aplica', $Estratos)){
					$No_Aplica_Num  = count($Estratos['No_Aplica']['id_estrato']);
				}
				if(array_search('Uno', $Estratos)){
					$Uno_Num        = count($Estratos['Uno']['id_estrato']);
				}
				if(array_search('Dos', $Estratos)){
					$Dos_Num        = count($Estratos['Dos']['id_estrato']);
				}
				if(array_search('Tres', $Estratos)){
					$Tres_Num       = count($Estratos['Tres']['id_estrato']);
				}
				if(array_search('Cuatro', $Estratos)){
					$Cuatro_Num     = count($Estratos['Cuatro']['id_estrato']);
				}
				if(array_search('Cinco', $Estratos)){
					$Cinco_Num      = count($Estratos['Cinco']['id_estrato']);
				}
				if(array_search('Seis', $Estratos)){
					$Seis_Num  = count($Estratos['Seis']['id_estrato']);
				}
                    
				$SQL_Estrato='SELECT iddesercionestrato FROM desercionestrato WHERE iddetalledesercion="'.$Last_Detalle.'"';   			
				$EstratoDesercion=$db->GetAll($SQL_Estrato);
				
				if(count($EstratoDesercion) > 0)
				{
					if(array_search('No_Aplica', $Estratos))
					{
						$SQL_NoAplica='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$No_Aplica_Num.'","0","4186",NOW())';            
						$db->Execute($SQL_NoAplica);
					}
					
					if(array_search('Uno', $Estratos))
					{
						$SQL_Uno='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Uno_Num.'","1","4186",NOW())';
						$db->Execute($SQL_Uno);
					}
					
					if(array_search('Dos', $Estratos))
					{
						$SQL_Dos='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Dos_Num.'","2","4186",NOW())';
						$db->Execute($SQL_Dos);
					}
					
					if(array_search('Tres', $Estratos))
					{
						$SQL_Tres='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Tres_Num.'","3","4186",NOW())';       
						$db->Execute($SQL_Tres);
					}
					
					if(array_search('Cuatro', $Estratos))
					{
						$SQL_Cuatro='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Cuatro_Num.'","4","4186",NOW())';   $db->Execute($SQL_Cuatro);
					}
					
					if(array_search('Cinco', $Estratos))
					{
						$SQL_Cinco='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Cinco_Num.'","5","4186",NOW())';     
						$db->Execute($SQL_Cinco);
					}
					
					if(array_search('Seis', $Estratos))
					{
						$SQL_Seis='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Seis_Num.'","6","4186",NOW())';
						$db->Execute($SQL_Seis);
					}
					
				}
				else
				{
					$Update_NoAplica='UPDATE desercionestrato SET cantidad="'.$No_Aplica_Num.'", changedate=NOW()
									 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="0" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_NoAplica);

					$Update_Uno='UPDATE desercionestrato SET cantidad="'.$Uno_Num.'", changedate=NOW()
								WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="1" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
				    //$db->Execute($Update_Uno);
					
					$Update_Dos='UPDATE desercionestrato SET cantidad="'.$Dos_Num.'", changedate=NOW()
								 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="2" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_Dos);
					
					$Update_Tres='UPDATE desercionestrato SET cantidad="'.$Tres_Num.'",changedate=NOW()
								 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="3" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_Tres);
					
					$Update_Cuatro='UPDATE desercionestrato SET  cantidad="'.$Cuatro_Num.'", changedate=NOW()
									 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="4" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_Cuatro);

					$Update_Cinco='UPDATE desercionestrato SET cantidad="'.$Cinco_Num.'", changedate=NOW() 
								 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="5" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_Cinco);					 

					$Update_Seis='UPDATE desercionestrato SET cantidad="'.$Seis_Num.'", changedate=NOW()
								 WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="6" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
					//$db->Execute($Update_Seis);					 
				}//if   
			}//if strlen
    	}//for
 	}//for   
?>
             