<?php
function cargaarchivoitemps($_FILES,$_POST,$db) {    

    $fechahoy=date("Y-m-d H:i:s");
    $nombre_archivo = $_FILES['resultados']['name'];
    $tipo_archivo = $_FILES['resultados']['type'];
    $tamano_archivo = $_FILES['resultados']['size'];

    $codigoperiodo=$_SESSION['codigoperiodosesion'];    
     $extension = explode(".",$nombre_archivo);
	 $log ="";
     //echo $extension[0]." ".$extension[1];
    if("xls"!=$extension[1]) {
        echo "<script language='javascript'>
            alert('El archivo debe ser de Excel y la extensión XLS');
            </script>";
    }
    else if($tamano_archivo > 2000000) {
        echo "<script language='javascript'>
            alert('El archivo sobrepasa el tamaño adecuado para ser subido, máximo de 2Mb');
            </script>";
    }
    else {
	
		$dataexcel = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$dataexcel->setOutputEncoding('CP1251');

		$dataexcel->read($_FILES["resultados"]["tmp_name"]);
		$filas = $dataexcel->sheets[0]['numRows'];

       // if(copy($_FILES['resultados']['tmp_name'], "/tmp/cargaitem.xls")) {
	   if($filas>0){
            $archivo_cargado_ok=true;

             $query_maxid="SELECT max(idlog_registroitem) as maxid FROM log_registroitem ";
             $maxid= $db->Execute($query_maxid);
             $totalRows_maxid= $maxid->RecordCount();
             $row_maxid= $maxid->FetchRow();

             if($row_maxid['maxid']==NULL || $row_maxid['maxid']==''){
                $idproximo=1;
             }
             else{
                 $idproximo=$row_maxid['maxid'] + 1;
             }            

            /*$archivo= fopen("logitem.txt","w");
            fwrite($archivo,"<b>Log Item</b> \n\n");
             fclose($archivo);   */        
            $log.= "<b>Log Item</b> <br/>";

			$carrera = "";
			if($_POST["codigocarrera"]!=null && $_POST["codigocarrera"]!=""){
				$carrera = " AND c.codigocarrera =".$_POST["codigocarrera"];
			}
            for($i=1; $i<=$filas && $dataexcel->sheets[0]['cells'][$i][4]!="" && $dataexcel->sheets[0]['cells'][$i][4]!=null; $i++) {
                $operacionprincipal=trim($dataexcel->sheets[0]['cells'][$i][1]);
                $operacionparcial=trim($dataexcel->sheets[0]['cells'][$i][2]);
                $codigocentrobeneficio=trim($dataexcel->sheets[0]['cells'][$i][3]);
                $item=trim($dataexcel->sheets[0]['cells'][$i][4]);
                $tipocuenta=trim($dataexcel->sheets[0]['cells'][$i][5]);
                $descripcion=trim($dataexcel->sheets[0]['cells'][$i][6]);

                //echo $materia." ".$numerodocumento." ".$corte." ".$nota." ".$modificacion."<br>";
                if($operacionprincipal=="" || $operacionparcial=="" || $codigocentrobeneficio=="" || $item=="" || $tipocuenta=="" || $descripcion==""){
                    /*$archivo= fopen("logitem.txt","a");
                    fwrite($archivo,"<span style='background:red'> Campos vacíos en la Fila No ".$i."</span> \n\n");
                    fclose($archivo);*/
					 $log.= "<span> Campos vacíos en la Fila No ".$i."</span><br/>";
                }
                else{
                    $query_centrobeneficio="select * from carrera c where c.codigocentrobeneficio='$codigocentrobeneficio' $carrera";
                    $centrobeneficio= $db->Execute($query_centrobeneficio);
                    $totalRows_centrobeneficio= $centrobeneficio->RecordCount();

                    if($totalRows_centrobeneficio !='' && $totalRows_centrobeneficio !=0){
                        /*$query_insertaitem="insert into tmp_item
                        values('$operacionprincipal','$operacionparcial','$codigocentrobeneficio','$item','$tipocuenta','$descripcion')";
                        $insertaitem=$db->Execute($query_insertaitem) or die(mysql_error());*/

                        $query_verificacion="select *
							FROM carrera c
                            join concepto cp on cp.cuentaoperacionprincipal= '$operacionprincipal' 
                            and cp.cuentaoperacionparcial='$operacionparcial' 
                            where 
								c.codigocentrobeneficio='$codigocentrobeneficio' 
								$carrera 
							and not EXISTS
                                (SELECT   1
                                  FROM carreraconceptopeople p
                                  WHERE c.codigocarrera= p.codigocarrera and cp.codigoconcepto=p.codigoconcepto
                                );";
								//echo $query_verificacion; die;
                        $verificacion= $db->Execute($query_verificacion);
                        $totalRows_verificacion= $verificacion->RecordCount();
                        if($totalRows_verificacion !=0 && $totalRows_verificacion !=''){
                            $query_insertaitemcarrera="
                                insert into carreraconceptopeople
                                select 0, c.codigocarrera, cp.codigoconcepto, '$item', '$descripcion',now(),'$tipocuenta',100,1
                                FROM carrera c 
                                join concepto cp on cp.cuentaoperacionprincipal= '$operacionprincipal'  and cp.cuentaoperacionparcial='$operacionparcial' 
                                where c.codigocentrobeneficio='$codigocentrobeneficio' 
									$carrera 
								and codigoconcepto NOT IN 
                                (SELECT   codigoconcepto 
                                  FROM carreraconceptopeople p
                                  WHERE c.codigocarrera= p.codigocarrera and cp.codigoconcepto=p.codigoconcepto
                                );";
									
                            $insertaitemcarrera=$db->Execute($query_insertaitemcarrera) or die(mysql_error());

                            /*$archivo= fopen("logitem.txt","a");
                            fwrite($archivo,"<span style='background:green'>Se han creado correctamente los Conceptos correspondientes a la Fila No ".$i."</span> \n\n");
                            fclose($archivo);*/
                             $log.= "<span>Se han creado correctamente los Conceptos correspondientes a la Fila No ".$i."</span> <br/>";
                            
                            
                        }
                        else{
						
							 $query_insertaitemcarrera="
                                UPDATE carreraconceptopeople  ccp 
								inner join carrera c on ccp.codigocarrera=c.codigocarrera
									join concepto cp on cp.cuentaoperacionprincipal= '$operacionprincipal' 
									and cp.cuentaoperacionparcial='$operacionparcial' 
								SET
								itemcarreraconceptopeople='$item',
								nombrecarreraconceptopeople='$descripcion',
								fechacarreraconceptopeople=now(),
								tipocuenta='$tipocuenta',
								ccp.codigoestado=100								
									WHERE 
										c.codigocentrobeneficio='$codigocentrobeneficio' 
										$carrera 										
										and ccp.codigoconcepto=cp.codigoconcepto ";
									
								//echo $query_insertaitemcarrera; die;

							$log.= "<span>Se han actualizado correctamente los Conceptos correspondientes a la Fila No ".$i."</span><br/>";

                            $insertaitemcarrera=$db->Execute($query_insertaitemcarrera) or die(mysql_error());
						
                           /* $archivo= fopen("logitem.txt","a");
                            fwrite($archivo,"<span style='background:red'>Ya existen ítems asociados a la cuenta operacion principal y parcial correspondiente a la Fila No ".$i.", si desea modificar el ítem asociado comuníquese con el área de tecnología.</span>\n\n");
                            fclose($archivo);*/
                            /*$query_eliminaitemtemporal="truncate table tmp_item";
                            $eliminaitemtemporal=$db->Execute($query_eliminaitemtemporal) or die(mysql_error());*/
                        }

                    }
                    else{
                        /*$archivo= fopen("logitem.txt","a");
                        fwrite($archivo,"<span style='background:red'>El código centro de beneficio en la Fila No ".$i." NO existe en SALA verifique o comuníquese con Tecnología.</span>\n\n");
                        fclose($archivo);*/
						$log.= "<span>El código centro de beneficio en la Fila No ".$i." NO es el que tiene asociado la carrera en SALA verifique o comuníquese con Tecnología.</span><br/>";
                    }
					
                }
            }            
            
			require_once('../../funciones/funcionip.php' );
			$ip = "SIN DEFINIR";
								$usuario=$_SESSION['MM_Username'];
			$ip = tomarip();
			$query_insertalog="insert into log_registroitem
                                values(0,'$usuario',now(),null,'$ip','$log')";
            $insertalog=$db->Execute($query_insertalog) or die(mysql_error());		
			$id=$db->Insert_ID();
			
			
           echo "<script language='javascript'>
            window.location.href = 'logitemps.php?id=".$id."' 
            </script>";

        }
        else {
            $archivo_cargado_ok=false;
            echo "<script language='javascript'>
            alert('Ocurrió algún error al subir el fichero. ');
            </script>";
        }
     }
}
?>
