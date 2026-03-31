<?php
session_start(); 
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$success = true;
$periodo=$_REQUEST['anio'].$_REQUEST['mes'];
		
$user=$utils->getUser();
$dateTime=date("Y-m-d h:m:s");

$query_periodoinf = "	select	 sbih.id
				,sbih.idclasificacionesinfhuerfana
				,sbih.periodicidad
				,bases_datos
				,busqueda_recuperacion_informacion
				,buzon_sugerencias
				,cantidad
				,cartas_presentacion
				,consulta_prestamo_libros
				,consulta_prestamo_material_especial
				,consulta_prestamo_revistas
				,consulta_prestamo_trabajos_grado
				,consulta_sala
				,formacion_usuarios
				,general
				,gestor_referencias
				,induccion_biblioteca
				,ingresos_biblioteca
				,numero_consultas
				,preguntele_bibliotecologo
				,prestamo_equipos
				,prestamo_externo 
				,prestamo_interbibliotecario
				,prestamo_salas_estudio
				,renovacion_prestamos
				,seguidores_facebook
				,seguidores_twitter
				,seminario_taller
				,solicitud_articulos
				,suscripciones
				,titulos
				,titulos_libros_electronicos
				,titulos_revistas_electronicas
				,usos_dentro_campus
				,usos_fuera_campus
				,volumenes
				,Verificado
			from siq_bibliotecainfhuerfana sbih 
			join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
			join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
			join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
			where sbih.periodicidad=".$periodo." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";
     //   echo $query_periodoinf;
        $periodoinf=$db->Execute($query_periodoinf);
        $row_mesinf=0; $int=0;
        foreach ($periodoinf as $ro){ $row_mesinf ++; }
            if($row_mesinf==0){ 
             //  echo $_REQUEST['action'].'-->>';
                if($_REQUEST['action']=='saveDynamic2' and $row_mesinf==0){	
                   // print_r($_REQUEST['idclasificacionesinfhuerfana']);
                    foreach ($_REQUEST['idclasificacionesinfhuerfana']as $row){
                              // if($_REQUEST['formulario']=='desarrollo'){
					$vlr1=($_REQUEST['bases_datos'][$int])?$_REQUEST['bases_datos'][$int]:'null';
					$vlr2=($_REQUEST['busqueda_recuperacion_informacion'][$int])?$_REQUEST['busqueda_recuperacion_informacion'][$int]:'null';
					$vlr3=($_REQUEST['buzon_sugerencias'][$int])?$_REQUEST['buzon_sugerencias'][$int]:'null';
					$vlr4=($_REQUEST['cantidad'][$int])?$_REQUEST['cantidad'][$int]:'null';
					$vlr5=($_REQUEST['cartas_presentacion'][$int])?$_REQUEST['cartas_presentacion'][$int]:'null';
					$vlr6=($_REQUEST['consulta_prestamo_libros'][$int])?$_REQUEST['consulta_prestamo_libros'][$int]:'null';
					$vlr7=($_REQUEST['consulta_prestamo_material_especial'][$int])?$_REQUEST['consulta_prestamo_material_especial'][$int]:'null';
					$vlr8=($_REQUEST['consulta_prestamo_revistas'][$int])?$_REQUEST['consulta_prestamo_revistas'][$int]:'null';
					$vlr9=($_REQUEST['consulta_prestamo_trabajos_grado'][$int])?$_REQUEST['consulta_prestamo_trabajos_grado'][$int]:'null';
					$vlr10=($_REQUEST['consulta_sala'][$int])?$_REQUEST['consulta_sala'][$int]:'null';
					$vlr11=($_REQUEST['formacion_usuarios'][$int])?$_REQUEST['formacion_usuarios'][$int]:'null';
					$vlr12=($_REQUEST['general'][$int])?$_REQUEST['general'][$int]:'null';
					$vlr13=($_REQUEST['gestor_referencias'][$int])?$_REQUEST['gestor_referencias'][$int]:'null';
					$vlr14=($_REQUEST['induccion_biblioteca'][$int])?$_REQUEST['induccion_biblioteca'][$int]:'null';
					$vlr15=($_REQUEST['ingresos_biblioteca'][$int])?$_REQUEST['ingresos_biblioteca'][$int]:'null';
					$vlr16=($_REQUEST['numero_consultas'][$int])?$_REQUEST['numero_consultas'][$int]:'null';
					$vlr17=($_REQUEST['preguntele_bibliotecologo'][$int])?$_REQUEST['preguntele_bibliotecologo'][$int]:'null';
					$vlr18=($_REQUEST['prestamo_equipos'][$int])?$_REQUEST['prestamo_equipos'][$int]:'null';
					$vlr19=($_REQUEST['prestamo_externo'][$int])?$_REQUEST['prestamo_externo'][$int]:'null';
					$vlr20=($_REQUEST['prestamo_interbibliotecario'][$int])?$_REQUEST['prestamo_interbibliotecario'][$int]:'null';
					$vlr21=($_REQUEST['prestamo_salas_estudio'][$int])?$_REQUEST['prestamo_salas_estudio'][$int]:'null';
					$vlr22=($_REQUEST['renovacion_prestamos'][$int])?$_REQUEST['renovacion_prestamos'][$int]:'null';
					$vlr23=($_REQUEST['seguidores_facebook'][$int])?$_REQUEST['seguidores_facebook'][$int]:'null';
					$vlr24=($_REQUEST['seguidores_twitter'][$int])?$_REQUEST['seguidores_twitter'][$int]:'null';
					$vlr25=($_REQUEST['seminario_taller'][$int])?$_REQUEST['seminario_taller'][$int]:'null';
					$vlr26=($_REQUEST['solicitud_articulos'][$int])?$_REQUEST['solicitud_articulos'][$int]:'null';
					$vlr27=($_REQUEST['suscripciones'][$int])?$_REQUEST['suscripciones'][$int]:'null';
					$vlr28=($_REQUEST['titulos'][$int])?$_REQUEST['titulos'][$int]:'null';
					$vlr29=($_REQUEST['titulos_libros_electronicos'][$int])?$_REQUEST['titulos_libros_electronicos'][$int]:'null';
					$vlr30=($_REQUEST['titulos_revistas_electronicas'][$int])?$_REQUEST['titulos_revistas_electronicas'][$int]:'null';
					$vlr31=($_REQUEST['usos_dentro_campus'][$int])?$_REQUEST['usos_dentro_campus'][$int]:'null';
					$vlr32=($_REQUEST['usos_fuera_campus'][$int])?$_REQUEST['usos_fuera_campus'][$int]:'null';
					$vlr33=($_REQUEST['volumenes'][$int])?$_REQUEST['volumenes'][$int]:'null';
					$vlr34=($_REQUEST['Verificado'][$int])?$_REQUEST['Verificado'][$int]:'0';
 
                                        $query_inserta="INSERT INTO siq_bibliotecainfhuerfana 
                                                        (periodicidad,idclasificacionesinfhuerfana,bases_datos,busqueda_recuperacion_informacion,buzon_sugerencias,cantidad,cartas_presentacion,consulta_prestamo_libros,consulta_prestamo_material_especial,consulta_prestamo_revistas,consulta_prestamo_trabajos_grado,consulta_sala,formacion_usuarios,general,gestor_referencias,induccion_biblioteca,ingresos_biblioteca,numero_consultas,preguntele_bibliotecologo,prestamo_equipos,prestamo_externo,prestamo_interbibliotecario,prestamo_salas_estudio,renovacion_prestamos,seguidores_facebook,seguidores_twitter,seminario_taller,solicitud_articulos,suscripciones,titulos,titulos_libros_electronicos,titulos_revistas_electronicas,usos_dentro_campus,usos_fuera_campus,volumenes,Verificado,fecha_creacion,usuario_creacion,fecha_modificacion,usuario_modificacion)
                                                VALUES (".$periodo.",".$row."
                                                        ,".$vlr1.",".$vlr2.",".$vlr3.",".$vlr4."
                                                        ,".$vlr5.",".$vlr6.",".$vlr7.",".$vlr8."
                                                        ,".$vlr9.",".$vlr10.",".$vlr11.",".$vlr12."
                                                        ,".$vlr13.",".$vlr14.",".$vlr15.",".$vlr16."
                                                        ,".$vlr17.",".$vlr18.",".$vlr19.",".$vlr20."
                                                        ,".$vlr21.",".$vlr22.",".$vlr23.",".$vlr24."
                                                        ,".$vlr25.",".$vlr26.",".$vlr27.",".$vlr28."
                                                        ,".$vlr29.",".$vlr30.",".$vlr31.",".$vlr32."
                                                        ,".$vlr33.",".$vlr34."
							,'".$dateTime."',".$user["idusuario"].",'".$dateTime."',".$user["idusuario"].")";
                                //}
                               // echo $query_inserta;
                                if($inserta= &$db->Execute($query_inserta)===false){
                                    $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                    echo json_encode($a_vectt);
                                    exit;
                            }//if_insert
                            $int++;
                    }//foreach
                    $a_vectt['success']=true; $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
                    echo json_encode($a_vectt);
                    exit;
                }else{
                    $a_vectt['success']=false; $a_vectt['descrip']='No hay datos';
                    echo json_encode($a_vectt);
                    exit;
                }
            }else{
                  //  echo $_REQUEST['action'].'-->';
                    if($_REQUEST['action']=='selectDynamic2' && $row_mesinf>0){
                       //  echo $_REQUEST['action'].'-->>';
                        $i=0;
                        foreach ($periodoinf as $row){
                          //  if($_REQUEST['formulario']=='desarrollo'){
                                $a_vectt[$i]['id']=$row['id'];
                                $a_vectt[$i]['idclasificacionesinfhuerfana']=$row['idclasificacionesinfhuerfana'];
				$a_vectt[$i]['bases_datos']=$row['bases_datos'];                         
				$a_vectt[$i]['busqueda_recuperacion_informacion']=$row['busqueda_recuperacion_informacion']; 
				$a_vectt[$i]['buzon_sugerencias']=$row['buzon_sugerencias'];
				$a_vectt[$i]['cantidad']=$row['cantidad'];
				$a_vectt[$i]['cartas_presentacion']=$row['cartas_presentacion'];
				$a_vectt[$i]['consulta_prestamo_libros']=$row['consulta_prestamo_libros'];
				$a_vectt[$i]['consulta_prestamo_material_especial']=$row['consulta_prestamo_material_especial'];
				$a_vectt[$i]['consulta_prestamo_revistas']=$row['consulta_prestamo_revistas'];
				$a_vectt[$i]['consulta_prestamo_trabajos_grado']=$row['consulta_prestamo_trabajos_grado'];
				$a_vectt[$i]['consulta_sala']=$row['consulta_sala'];
				$a_vectt[$i]['formacion_usuarios']=$row['formacion_usuarios'];
				$a_vectt[$i]['general']=$row['general'];
				$a_vectt[$i]['gestor_referencias']=$row['gestor_referencias'];
				$a_vectt[$i]['induccion_biblioteca']=$row['induccion_biblioteca'];
				$a_vectt[$i]['ingresos_biblioteca']=$row['ingresos_biblioteca'];
				$a_vectt[$i]['numero_consultas']=$row['numero_consultas'];
				$a_vectt[$i]['preguntele_bibliotecologo']=$row['preguntele_bibliotecologo'];
				$a_vectt[$i]['prestamo_equipos']=$row['prestamo_equipos'];
				$a_vectt[$i]['prestamo_externo']=$row['prestamo_externo'];
				$a_vectt[$i]['prestamo_interbibliotecario']=$row['prestamo_interbibliotecario'];
				$a_vectt[$i]['prestamo_salas_estudio']=$row['prestamo_salas_estudio'];
				$a_vectt[$i]['renovacion_prestamos']=$row['renovacion_prestamos'];
				$a_vectt[$i]['seguidores_facebook']=$row['seguidores_facebook'];
				$a_vectt[$i]['seguidores_twitter']=$row['seguidores_twitter'];
				$a_vectt[$i]['seminario_taller']=$row['seminario_taller'];
				$a_vectt[$i]['solicitud_articulos']=$row['solicitud_articulos'];
				$a_vectt[$i]['suscripciones']=$row['suscripciones'];
				$a_vectt[$i]['titulos']=$row['titulos'];
				$a_vectt[$i]['titulos_libros_electronicos']=$row['titulos_libros_electronicos'];
				$a_vectt[$i]['titulos_revistas_electronicas']=$row['titulos_revistas_electronicas'];
				$a_vectt[$i]['usos_dentro_campus']=$row['usos_dentro_campus'];
				$a_vectt[$i]['usos_fuera_campus']=$row['usos_fuera_campus'];
				$a_vectt[$i]['volumenes']=$row['volumenes'];
                                $a_vectt[$i]['Verificado']=$row['Verificado'];
                          //  }
                           $i++;
                        }
                        $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                        echo json_encode($a_vectt);
                        exit;
                    }else if($_REQUEST['action']=='updateDynamic2' || $row_mesinf>0 ){
                      //  echo "aca3..";
                       // print_r($_REQUEST['idclasificacionesinfhuerfana']);
                        $j=0; $int=0;
                        foreach ($_REQUEST['idclasificacionesinfhuerfana'] as $row){
				if (!empty($_REQUEST['bases_datos'][$int])) $vlr1="bases_datos='".$_REQUEST['bases_datos'][$int]."',";
				if (!empty($_REQUEST['busqueda_recuperacion_informacion'][$int])) $vlr2="busqueda_recuperacion_informacion='".$_REQUEST['busqueda_recuperacion_informacion'][$int]."',";
				if (!empty($_REQUEST['buzon_sugerencias'][$int])) $vlr3="buzon_sugerencias='".$_REQUEST['buzon_sugerencias'][$int]."',";
				if (!empty($_REQUEST['cantidad'][$int])) $vlr4="cantidad='".$_REQUEST['cantidad'][$int]."',";
				if (!empty($_REQUEST['cartas_presentacion'][$int])) $vlr5="cartas_presentacion='".$_REQUEST['cartas_presentacion'][$int]."',";
				if (!empty($_REQUEST['consulta_prestamo_libros'][$int])) $vlr6="consulta_prestamo_libros='".$_REQUEST['consulta_prestamo_libros'][$int]."',";
				if (!empty($_REQUEST['consulta_prestamo_material_especial'][$int])) $vlr7="consulta_prestamo_material_especial='".$_REQUEST['consulta_prestamo_material_especial'][$int]."',";
				if (!empty($_REQUEST['consulta_prestamo_revistas'][$int])) $vlr8="consulta_prestamo_revistas='".$_REQUEST['consulta_prestamo_revistas'][$int]."',";
				if (!empty($_REQUEST['consulta_prestamo_trabajos_grado'][$int])) $vlr9="consulta_prestamo_trabajos_grado='".$_REQUEST['consulta_prestamo_trabajos_grado'][$int]."',";
				if (!empty($_REQUEST['consulta_sala'][$int])) $vlr10="consulta_sala='".$_REQUEST['consulta_sala'][$int]."',";
				if (!empty($_REQUEST['formacion_usuarios'][$int])) $vlr11="formacion_usuarios='".$_REQUEST['formacion_usuarios'][$int]."',";
				if (!empty($_REQUEST['general'][$int])) $vlr12="general='".$_REQUEST['general'][$int]."',";
				if (!empty($_REQUEST['gestor_referencias'][$int])) $vlr13="gestor_referencias='".$_REQUEST['gestor_referencias'][$int]."',";
				if (!empty($_REQUEST['induccion_biblioteca'][$int])) $vlr14="induccion_biblioteca='".$_REQUEST['induccion_biblioteca'][$int]."',";
				if (!empty($_REQUEST['ingresos_biblioteca'][$int])) $vlr15="ingresos_biblioteca='".$_REQUEST['ingresos_biblioteca'][$int]."',";
				if (!empty($_REQUEST['numero_consultas'][$int])) $vlr16="numero_consultas='".$_REQUEST['numero_consultas'][$int]."',";
				if (!empty($_REQUEST['preguntele_bibliotecologo'][$int])) $vlr17="preguntele_bibliotecologo='".$_REQUEST['preguntele_bibliotecologo'][$int]."',";
				if (!empty($_REQUEST['prestamo_equipos'][$int])) $vlr18="prestamo_equipos='".$_REQUEST['prestamo_equipos'][$int]."',";
				if (!empty($_REQUEST['prestamo_externo'][$int])) $vlr19="prestamo_externo='".$_REQUEST['prestamo_externo'][$int]."',";
				if (!empty($_REQUEST['prestamo_interbibliotecario'][$int])) $vlr20="prestamo_interbibliotecario='".$_REQUEST['prestamo_interbibliotecario'][$int]."',";
				if (!empty($_REQUEST['prestamo_salas_estudio'][$int])) $vlr21="prestamo_salas_estudio='".$_REQUEST['prestamo_salas_estudio'][$int]."',";
				if (!empty($_REQUEST['renovacion_prestamos'][$int])) $vlr22="renovacion_prestamos='".$_REQUEST['renovacion_prestamos'][$int]."',";
				if (!empty($_REQUEST['seguidores_facebook'][$int])) $vlr23="seguidores_facebook='".$_REQUEST['seguidores_facebook'][$int]."',";
				if (!empty($_REQUEST['seguidores_twitter'][$int])) $vlr24="seguidores_twitter='".$_REQUEST['seguidores_twitter'][$int]."',";
				if (!empty($_REQUEST['seminario_taller'][$int])) $vlr25="seminario_taller='".$_REQUEST['seminario_taller'][$int]."',";
				if (!empty($_REQUEST['solicitud_articulos'][$int])) $vlr26="solicitud_articulos='".$_REQUEST['solicitud_articulos'][$int]."',";
				if (!empty($_REQUEST['suscripciones'][$int])) $vlr27="suscripciones='".$_REQUEST['suscripciones'][$int]."',";
				if (!empty($_REQUEST['titulos'][$int])) $vlr28="titulos='".$_REQUEST['titulos'][$int]."',";
				if (!empty($_REQUEST['titulos_libros_electronicos'][$int])) $vlr29="titulos_libros_electronicos='".$_REQUEST['titulos_libros_electronicos'][$int]."',";
				if (!empty($_REQUEST['titulos_revistas_electronicas'][$int])) $vlr30="titulos_revistas_electronicas='".$_REQUEST['titulos_revistas_electronicas'][$int]."',";
				if (!empty($_REQUEST['usos_dentro_campus'][$int])) $vlr31="usos_dentro_campus='".$_REQUEST['usos_dentro_campus'][$int]."',";
				if (!empty($_REQUEST['usos_fuera_campus'][$int])) $vlr32="usos_fuera_campus='".$_REQUEST['usos_fuera_campus'][$int]."',";
				if (!empty($_REQUEST['volumenes'][$int])) $vlr33="volumenes='".$_REQUEST['volumenes'][$int]."',";
                                if (!empty($_REQUEST['Verificado']) or $_REQUEST['Verificado']==0) $vlr34="Verificado='".$_REQUEST['Verificado']."',";
                                $vlr35="fecha_modificacion='".$dateTime."',";
                                $vlr36="usuario_modificacion=".$user["idusuario"];
                            //if($_REQUEST['formulario']=='desarrollo'){
                              // echo $_REQUEST['Verificado'].'-->'.$vlr39.'<----';
                               
                                $query_update="UPDATE siq_bibliotecainfhuerfana SET 
                                    ".$vlr1." ".$vlr2." ".$vlr3." ".$vlr4." ".$vlr5." ".$vlr6." ".$vlr7." ".$vlr8." ".$vlr9." ".$vlr10."
                                    ".$vlr11." ".$vlr12." ".$vlr13." ".$vlr14." ".$vlr15." ".$vlr16." ".$vlr17." ".$vlr18." ".$vlr19." ".$vlr20."
                                    ".$vlr21." ".$vlr22." ".$vlr23." ".$vlr24." ".$vlr25." ".$vlr26." ".$vlr27." ".$vlr28." ".$vlr29." ".$vlr30."
                                    ".$vlr31." ".$vlr32." ".$vlr33." ".$vlr34." ".$vlr35." ".$vlr36."
                                    WHERE id='".$_REQUEST['id'][$int]."' ";
                            
                            //}
                             // echo $query_update,'-->>';
                            if($inserta= &$db->Execute($query_update)===false){
                                    $a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
                                    echo json_encode($a_vectt);
                                    exit;
                            }else{
                                $j++;
                            }
                            $int++;
                        }
                        if($j>0){
                               $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta ';
                                echo json_encode($a_vectt);
                                exit;
                        }else{
                            $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                echo json_encode($a_vectt);
                                exit;
                        }
                    }else{ 
                        $a_vectt['success']=false;  $a_vectt['descrip']='No hay datosxxxx';
                        echo json_encode($a_vectt);
                        exit;
                    }
            }


/*$query="select sbih.id
	from siq_bibliotecainfhuerfana sbih 
	join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
	join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
	join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
	where sbih.periodicidad=".$periodo." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";
$exec= $db->Execute($query);
if($exec->RecordCount()==0) {
	foreach ($_REQUEST['aux'] as $int) {
		$vlr1=($_REQUEST['titulos'][$int])?$_REQUEST['titulos'][$int]:'null';
		$vlr2=($_REQUEST['volumenes'][$int])?$_REQUEST['volumenes'][$int]:'null';
		$vlr3=($_REQUEST['cantidad'][$int])?$_REQUEST['cantidad'][$int]:'null';
		$vlr4=($_REQUEST['cant_usuarios_ing_biblioteca'][$int])?$_REQUEST['cant_usuarios_ing_biblioteca'][$int]:'null';
		$vlr5=($_REQUEST['prestamo_equipos'][$int])?$_REQUEST['prestamo_equipos'][$int]:'null';
		$vlr6=($_REQUEST['prestamo_libros'][$int])?$_REQUEST['prestamo_libros'][$int]:'null';
		$vlr7=($_REQUEST['prestamo_revistas'][$int])?$_REQUEST['prestamo_revistas'][$int]:'null';
		$vlr8=($_REQUEST['prestamo_trabajos_grado'][$int])?$_REQUEST['prestamo_trabajos_grado'][$int]:'null';
		$vlr9=($_REQUEST['prestamo_material_especial'][$int])?$_REQUEST['prestamo_material_especial'][$int]:'null';
		$vlr10=($_REQUEST['dentro_campus'][$int])?$_REQUEST['dentro_campus'][$int]:'null';
		$vlr11=($_REQUEST['fuera_campus'][$int])?$_REQUEST['fuera_campus'][$int]:'null';
		$vlr12=($_REQUEST['prestamo_sala'][$int])?$_REQUEST['prestamo_sala'][$int]:'null';
		$vlr13=($_REQUEST['prestamo_externo'][$int])?$_REQUEST['prestamo_externo'][$int]:'null';
		$vlr14=($_REQUEST['prestamo_interbibliotecario'][$int])?$_REQUEST['prestamo_interbibliotecario'][$int]:'null';
		$vlr15=($_REQUEST['renovaciones_presenciales'][$int])?$_REQUEST['renovaciones_presenciales'][$int]:'null';
		$vlr16=($_REQUEST['sugerencias_recibidas'][$int])?$_REQUEST['sugerencias_recibidas'][$int]:'null';
		$vlr17=($_REQUEST['cartas_presentacion'][$int])?$_REQUEST['cartas_presentacion'][$int]:'null';
		$vlr18=($_REQUEST['formacion_usuarios'][$int])?$_REQUEST['formacion_usuarios'][$int]:'null';
		$vlr19=($_REQUEST['induccion_biblioteca'][$int])?$_REQUEST['induccion_biblioteca'][$int]:'null';
		$vlr20=($_REQUEST['busqueda_informacion'][$int])?$_REQUEST['busqueda_informacion'][$int]:'null';
		$vlr21=($_REQUEST['seminario_taller'][$int])?$_REQUEST['seminario_taller'][$int]:'null';
		$vlr22=($_REQUEST['referenciacion'][$int])?$_REQUEST['referenciacion'][$int]:'null';
		$vlr23=($_REQUEST['obtencion_articulos'][$int])?$_REQUEST['obtencion_articulos'][$int]:'null';
		$vlr24=($_REQUEST['buzon_sugerencias'][$int])?$_REQUEST['buzon_sugerencias'][$int]:'null';
		$vlr25=($_REQUEST['renovacion_linea'][$int])?$_REQUEST['renovacion_linea'][$int]:'null';
		$vlr26=($_REQUEST['preguntele_bibliotecologo'][$int])?$_REQUEST['preguntele_bibliotecologo'][$int]:'null';
		$vlr27=($_REQUEST['seguidores_facebook'][$int])?$_REQUEST['seguidores_facebook'][$int]:'null';
		$vlr28=($_REQUEST['canal_youtube'][$int])?$_REQUEST['canal_youtube'][$int]:'null';
		$vlr29=($_REQUEST['seguidores_twitter'][$int])?$_REQUEST['seguidores_twitter'][$int]:'null';
		$vlr30=($_REQUEST['nro_titulos_revista_imp'][$int])?$_REQUEST['nro_titulos_revista_imp'][$int]:'null';
		$vlr31=($_REQUEST['nro_titulos_revista_elec'][$int])?$_REQUEST['nro_titulos_revista_elec'][$int]:'null';
		$vlr32=($_REQUEST['nro_titulos_libros'][$int])?$_REQUEST['nro_titulos_libros'][$int]:'null';
		$vlr33=($_REQUEST['nro_consultas'][$int])?$_REQUEST['nro_consultas'][$int]:'null';
		$vlr34=($_REQUEST['material_especial'][$int])?$_REQUEST['material_especial'][$int]:'null';
		$vlr35=($_REQUEST['revistas_indexadas'][$int])?$_REQUEST['revistas_indexadas'][$int]:'null';
		$vlr36=($_REQUEST['nro_ctas_creadas'][$int])?$_REQUEST['nro_ctas_creadas'][$int]:'null';
		$vlr37=($_REQUEST['suscripcion'][$int])?$_REQUEST['suscripcion'][$int]:'null';
		$vlr38=($_REQUEST['open_access'][$int])?$_REQUEST['open_access'][$int]:'null';
                $vlr39=($_REQUEST['Verificado'][$int])?$_REQUEST['Verificado'][$int]:'0';
		$query="INSERT INTO siq_bibliotecainfhuerfana 
				(periodicidad,idclasificacionesinfhuerfana
				,titulos,volumenes,cantidad,cant_usuarios_ing_biblioteca
				,prestamo_equipos,prestamo_libros,prestamo_revistas,prestamo_trabajos_grado
				,prestamo_material_especial,dentro_campus,fuera_campus,prestamo_sala
				,prestamo_externo,prestamo_interbibliotecario,renovaciones_presenciales,sugerencias_recibidas
				,cartas_presentacion,formacion_usuarios,induccion_biblioteca,busqueda_informacion
				,seminario_taller,referenciacion,obtencion_articulos,buzon_sugerencias
				,renovacion_linea,preguntele_bibliotecologo,seguidores_facebook,canal_youtube
				,seguidores_twitter,nro_titulos_revista_imp,nro_titulos_revista_elec,nro_titulos_libros
				,nro_consultas,material_especial,revistas_indexadas,nro_ctas_creadas
				,suscripcion,open_access, Verificado)
			VALUES (".$periodo.",".$int."
				,".$vlr1.",".$vlr2.",".$vlr3.",".$vlr4."
				,".$vlr5.",".$vlr6.",".$vlr7.",".$vlr8."
				,".$vlr9.",".$vlr10.",".$vlr11.",".$vlr12."
				,".$vlr13.",".$vlr14.",".$vlr15.",".$vlr16."
				,".$vlr17.",".$vlr18.",".$vlr19.",".$vlr20."
				,".$vlr21.",".$vlr22.",".$vlr23.",".$vlr24."
				,".$vlr25.",".$vlr26.",".$vlr27.",".$vlr28."
				,".$vlr29.",".$vlr30.",".$vlr31.",".$vlr32."
				,".$vlr33.",".$vlr34.",".$vlr35.",".$vlr36."
				,".$vlr37.",".$vlr38.",".$vlr39.")";
		$db->Execute($query);
	}
	$mensaje='Información almacenada para el periodo '.$periodo;
} else {
	$mensaje='Ya existe información almacenada para el periodo '.$periodo;
        $success = false;
}*/

$data = array('success'=> $success,'message'=> $mensaje);
echo json_encode($data);
?>
