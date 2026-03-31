<?php
error_reporting(0);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */

	//$aColumns = array( 'codigoestudiante', 'codigoperiodo', 'codigocarrera', 'idestudiantegeneral', 'semestre' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	//$sIndexColumn = "codigoestudiante";
        
	/* DB table to use */
	//$sTable = "estudiante";
        
        require_once('../Connections/sala2.php');
        	
	/* Database connection information */
	$gaSql['user']       = $username_sala;
	$gaSql['password']   = $password_sala;
	$gaSql['db']         = $database_sala;
	$gaSql['server']     = $hostname_sala;
        
        //verifica la sesión del usuario
        $ruta = "";
        while (!is_file($ruta.'functionsUsersClass.php'))
        {
            $ruta = $ruta."../";
        }
        require_once ($ruta.'functionsUsersClass.php');
		require_once ($ruta.'queriesProcessing.php');
        
        /*produccion*/
        //$gaSql['server'] = "172.16.3.218";
        //$gaSql['user'] = "sala";
        //$gaSql['db'] = "UsuAppConSal";
        //$gaSql['password']  = "197DA72C7FEACUNB0$QU32016";
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	#include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
	function limpiarColumnas($fields,$sTableNickname=""){
		
                //para coger los nombres de las columnas como son cuando se manejan alias con as
                while (stripos($fields,' as ') !== false) {
                    //where it finds the as article
                    $init = stripos($fields, " as ");
                    $toReplace = substr($fields,$init);
                    //where it finds the fist comma after the as article
                    $fin = strpos($toReplace, ",");
                    //si no encontro una coma entonces está al final del string
                    if($fin=="0"){
                        $fin = strlen($toReplace);
                    }
                    //var_dump($fin);
                    $toReplace = substr($toReplace,0,$fin);
                    //var_dump($toReplace);
                    //var_dump($fields);
                    //$fields = str_replace($toReplace, "", $fields);
                    //porque solo quiero que me reemplaze el primero que encuentre
                    $fields = preg_replace("/".$toReplace."/", "", $fields,1);
                    //var_dump($fields);
                }
				/*var_dump(stripos($fields,'CASE '));
				var_dump(stripos($fields,' end'));
				var_dump($fields);*/
				//para coger CASE ... end
                if (stripos($fields,'CASE ') !== false && stripos($fields,' end') !== false) {
					//echo "hola";
                    //where it finds the as article
                    $init = stripos($fields, "CASE ");
                    $toReplace = substr($fields,$init);
					//echo $toReplace;
                    //hasta que encuentre el end
                    $fin = strpos($toReplace, " end ");
					//si no encontro una coma entonces está al final del string
                    if($fin=="0"){
                        $fin = strlen($toReplace);
                    }
                    //var_dump($fin);
                    $toReplace = substr($toReplace,0,$fin);
					//echo $toReplace;
                    $textoF = str_replace(",", ";", $toReplace);
					//echo $textoF;
                    $fields = str_replace($toReplace, $textoF, $fields);
                    //var_dump($fields);
                }
                    //$fields = str_replace($sTableNickname.".", "", $fields);
		return $fields;
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
        
	/* 
	 * Paging
	 */
	$sLimit = "";
        
        $sTable=$_REQUEST['table'];
        $sW=$_REQUEST['wh'];
        $sV=$_REQUEST['vwh'];
        $csW=$_REQUEST['cwh'];
        $sQl=$_REQUEST['sql'];
		$varFunction=$_REQUEST['action'];		
		if(!isset($_REQUEST['sql']) && is_callable($varFunction)){
			$sQl = call_user_func($varFunction);
		}
        $omitir = $_REQUEST['omi'];
        $sQl = str_replace('\"','"',$sQl);
        $sQl = str_replace("\'","'",$sQl);
        //echo $sQl."<br/>";
        $iCl=$_REQUEST['IndexColumn'];
        $sTableNickname=$_REQUEST['tableNickname'];
        $sComplexJoin=$_REQUEST['join'];
        $pun = strpos($sW, '.');
        $WsQl = strpos($sQl, 'where');
       
        if ($pun === false) { 
            $inD='';
        }else{ 
            $ind=explode('.',$sW); 
            $inD=$ind[0].'.';
        }
        
        if ($WsQl === false) {
            $Swhere=' where ';
        }else{
            $Swhere=' AND ';
        }
        
       // echo $sTable.'<br>';
        if(empty($iCl)){
            $sIndexColumn = "id".$_REQUEST['table']."";
        }else{
            $sIndexColumn = $iCl;
        }
        
        if(isset($_REQUEST["active"])&&strcmp($_REQUEST["active"],"true")==0){ 
            if (empty($sQl)){ 
                $sQuery = "select * from ".$sTable." where ".$inD."codigoestado='100' limit 1";
            }else{  
                if($omitir==1){
                    $sQuery = $sQl." ".$Swhere." ".$sW." limit 1 ";
                }else{
                    $sQuery = $sQl." ".$Swhere." ".$inD."codigoestado='100' limit 1 ";
                }
                
                
            }
        } else if(isset($_REQUEST["active"])){
            if (empty($sQl)){
                $sQuery = "select * from ".$sTable." where ".$inD."codigoestado='200' limit 1";
            }else{ 
                $sQuery = $sQl." ".$Swhere." ".$inD."codigoestado='200' limit 1 ";
            }
        } else { 
            if (!empty($sQl)){
                $sQuery = $sQl." limit 1 ";
            }
        }              
        
                
        //echo $sQuery.'<br>';
//        echo '<br>Consulta...';
//        print_r($sQuery);
//        die();
        if(!empty($sQuery)){
            $tResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error()); 
            //echo '<pre>';print_r($tResult); 
        }
        $consulta ="";
      
        if (empty($sQl)){
            $consulta = "SHOW FIELDS FROM ".$_REQUEST['table']." ";
            $resultado = mysql_query($consulta, $gaSql['link']) or die ( mysql_error() );
            while($datos = mysql_fetch_array($resultado)){
                $aColumns[]=$datos['Field'];        
            }    
        }else{
            if(empty($sComplexJoin)){
                $consulta =  $sQuery;
                //echo $consulta.'<br>';
                $resultado = mysql_query($consulta, $gaSql['link']) or die ( mysql_error() );
            // $i=count($resultado);
                if (mysql_num_rows($resultado) == 0) {
                        $consulta = "SHOW FIELDS FROM ".$_REQUEST['table']."";
                        $resultado = mysql_query($consulta, $gaSql['link']) or die ( mysql_error() );
                        while($datos = mysql_fetch_array($resultado)){
                            $aColumns[]=$datos['Field'];   
                        }
                }else{
					if(!isset($_REQUEST["complex"])){
						while($datos = mysql_fetch_assoc($resultado)){
							//print_r($datos);
								foreach($datos as $key => $value) {
								$aColumns[] = $key;
							}
						}
					} else {
						$fields = substr($sQl,stripos($sQl, "SELECT ")+7);
						//var_dump($fields);
						//var_dump(stripos($fields," FROM"));
						$fields = substr($fields,0,stripos($fields," FROM"));
						//var_dump($fields);
						$fields=limpiarColumnas($fields,$sTableNickname);
						//var_dump($fields);
						$aColumns = explode(",", $fields);
						$aColumns = str_replace(";", ",", $aColumns);
					}
                }
            } else {
                //stripos para que no sea sensible a mayusculas y minusculas
                $fields = substr($sQl,stripos($sQl, "SELECT ")+7);
                $fields = substr($fields,0,stripos($fields," FROM"));
                //var_dump($fields);
                $fields=limpiarColumnas($fields,$sTableNickname);
                
                $aColumns = explode(",", $fields);
				$aColumns = str_replace(";", ",", $aColumns);
                //var_dump($aColumns);
                $sTableNickname = "";
                
            }
        }
        //var_dump($aColumns);
        //var_dump($consulta);die();
        if(!is_array($aColumns)){
            $tRow = object_to_array(mysql_fetch_object( $tResult ));            
            if(is_array($tRow)){
                foreach ($tRow as $key => $value){                           
                    $aColumns[]=$key;
                }
            }
        }
        
	if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_REQUEST['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_REQUEST['iDisplayLength'] );
	}
        
        /*
	 * Grouping
	 */
        
        $sGroup = "";
	if ( isset( $_REQUEST['group'] ) )
	{
		$sGroup = " GROUP BY ". $_REQUEST['group'];
	}
	
	
	/*
	 * Ordering
	 */
        
       // print_r($aColumns);
	$sOrder = "";
	if ( isset( $_REQUEST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_REQUEST['iSortingCols'] ) ; $i++ )
		{
			if ( $_REQUEST[ 'bSortable_'.intval($_REQUEST['iSortCol_'.$i]) ] == "true" )
			{
                                if(empty($sTableNickname)){ //echo '--->'.$aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ];
                                    $sOrder .= "".$aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".
                                            mysql_real_escape_string( $_REQUEST['sSortDir_'.$i] ) .", ";
                                } else {                                    
                                   $sOrder .= "".$sTableNickname.".".$aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".
                                            mysql_real_escape_string( $_REQUEST['sSortDir_'.$i] ) .", ";
                                }
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
        
        //var_dump($_GET['iSortingCols']);
        //echo print_r($sOrder);
		//var_dump($sOrder);
	//var_dump($aColumns);
        
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	 
	 /*echo "<pre>";
	 print_r($aColumns);
	 echo "</pre>";*/
	 
	$sWhere = "";
	if ( isset($_REQUEST['sSearch']) && $_REQUEST['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=1 ; $i<count($aColumns) ; $i++ )
		{
                    //Por alguna razon el último campo que se envia tiene el coso en Null, entonces mejor solo que si es falso no busque y ya
                    $j = $i - 1;
                    if ( (isset($_REQUEST['bSearchable_'.$j]) && $_REQUEST['bSearchable_'.$j] == "true" ) && $_REQUEST['sSearch'] != '' )
                    {
                        //Para que cuando sea el ID lo busque exacto
                        //var_dump($aColumns[$i]);
                        //var_dump($aColumns[$i] == "id".$_REQUEST['table']);
                        //var_dump($_REQUEST['tableNickname'].".id".$_REQUEST['table']);
                        if(strcmp($aColumns[$i],$sIndexColumn)==0 || strcmp($aColumns[$i],$_REQUEST['tableNickname'].$sIndexColumn)==0){
                            $sWhere .= "".$aColumns[$i]." = '".mysql_real_escape_string( $_REQUEST['sSearch'] )."' OR ";
                        } else {
                            $sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string( $_REQUEST['sSearch'] )."%' OR ";
                        }
                    }
		}
		//echo $sWhere."<br>";
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ') ';
	}
	
	//echo $sWhere;
	
	/* Individual column filtering */
	for ( $i=1 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_REQUEST['bSearchable_'.$i]) && $_REQUEST['bSearchable_'.$i] == "true" && $_REQUEST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= "  ";
			}
                        //Para que cuando sea el ID lo busque exacto
                        //var_dump($aColumns[$i]);
                        //var_dump($aColumns[$i] == "id".$_REQUEST['table']);
                        //var_dump($_REQUEST['tableNickname'].".id".$_REQUEST['table']);
                        if(strcmp($aColumns[$i],$sIndexColumn)==0 || strcmp($aColumns[$i],$_REQUEST['tableNickname'].$sIndexColumn)==0){
                            $sWhere .= "".$aColumns[$i]." = '".mysql_real_escape_string($_REQUEST['sSearch_'.$i])."' ";                            
                        } else {
                            $sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_REQUEST['sSearch_'.$i])."%' ";
                        }
		}
	}
	//echo $sWhere.'okok<br>';die();
	
	/*
	 * SQL queries
	 * Get data to display
	 */
        if(isset($_REQUEST["indicadoresACargo"])&&strcmp($_REQUEST["indicadoresACargo"],"")!=0){
            include_once("./API_Monitoreo.php");
            $api = new API_Monitoreo();            
            if (!empty($sWhere)){
                $sWhere.=" AND  ".$inD.$_REQUEST["indicadoresACargo"]." IN (".$api->getQueryIndicadoresACargo().")";
            }else{
                //$sWhereP=" ".$Swhere." ".$inD.$_REQUEST["indicadoresACargo"]." IN (".$api->getQueryIndicadoresACargo().")";
                $sWhereP=" inner join (".$api->getQueryIndicadoresACargo().") rid ON ".$inD.$_REQUEST["indicadoresACargo"]."=rid.idsiq_indicador ";
            }
        }
        if(isset($_REQUEST["active"])&&strcmp($_REQUEST["active"],"true")==0){
            if (!empty($sWhere)){
                $sWhere.=" AND  ".$inD."codigoestado='100'";
            }else{
                if (!empty($sWhereP)){
                    $sWhereP .=" ".$Swhere." ".$inD."codigoestado='100' ";
                } else {
                    $sWhereP=" ".$Swhere." ".$inD."codigoestado='100' ";
                }
            }
        } else if(isset($_REQUEST["active"])) {            
            if (!empty($sWhere)){
                $sWhere.=" AND  ".$inD."codigoestado='200'";
            }else{
                 if (!empty($sWhereP)){
                    $sWhereP.=" ".$Swhere." ".$inD."codigoestado='200' ";
                 } else {
                    $sWhereP=" ".$Swhere." ".$inD."codigoestado='200' ";
                 }
            }
        }
        
        if (!empty($sW) and !empty($sV)){
               $sWhereP.=" AND ".$sW."=".$sV."  ";
        }
        if (!empty($csW)){
            //confirmo que sea un usuario logueado por lo que queda vulnerable a SQL Injection
            $functionsUsers = new functionsUsersClass();
            $functionsUsers->verifySession();
            $csW = str_replace("\'", "'", $csW);
               if(empty($sWhere) && empty($sWhereP)){
					$sWhereP.=" WHERE ".$csW." ";
				} else {
					$sWhereP.=" AND ".$csW." "; } 
        }
	 if (empty($sQl)){
                $sQuery = "
                        SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
                        FROM   $sTable 
                        $sWhere 
                        $sWhereP
                        $sGroup
                        $sOrder
                        $sLimit
                        ";
         }else{
             $sQuery = "
                        SELECT SQL_CALC_FOUND_ROWS ".str_replace("SELECT", " ",$sQl)."
                        $sWhere 
                        $sWhereP
                        $sGroup
                        $sOrder
                        $sLimit
                        ";
         }
        //echo $sQuery.'<br>';
        //var_dump($sWhereP);
        //var_dump($sQuery);
        //die();
        $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
        //print $sQuery.' ok <br> ';
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        //var_dump($sQuery);
        //var_dump($aResultFilterTotal);
        //die();
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
         if (empty($sQl)){
                $sQuery = "
                        SELECT COUNT(`".$sIndexColumn."`)
                        FROM    $sTable 
                                $sWhereP
                                $sGroup
                                $sOrder
                                $sLimit
                ";
         }else{
             $dP=explode("FROM",$sQl);
             $dP=$dP[1];
             $sWhere=$dP;
			 
			 $pos = strpos($sWhere,"WHERE");
                         $pos2 = strpos($sWhere,"where");
			
			if($pos === false && $pos2 === false) {
			 // no hay where
			 $pos = strpos($sWhereP,"WHERE");
			 $pos2 = strpos($sWhereP,"where");
			 if($pos === false && $pos2 === false) {
				$sWhereP = preg_replace("/AND /", "WHERE ", $sWhereP,1);
			 }
			}
			 
              $sQuery = "
                        SELECT COUNT(*)
                        FROM $sWhere 
                        $sWhereP
                        $sGroup
                        $sOrder
                        $sLimit
                        ";
         }
        //print $sQuery.' ok okok <br> ';die();
        
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
        if($iTotal==null){
            $iTotal = $iFilteredTotal;
        }
        
	//echo $iTotal.'ok';
	//echo $iTotal;
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_REQUEST['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		//print_r($aRow);
                //var_dump($aColumns);
                //die();
                $gotID = false;
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
                        $columna = $aColumns[$i];
                        if(!empty($sComplexJoin) ){                             
                            $init = strpos($aColumns[$i], ".")+1;
                            $columna = substr($aColumns[$i],$init);
                        }
                      //  echo $columna."-".$aRow[ $columna ]."<br/>";
			if ( (trim($columna) == $sIndexColumn || trim($columna) == $_REQUEST['tableNickname'].$sIndexColumn) && !$gotID){
                            $row["DT_RowId"]= 'row_'.$aRow[ trim($columna) ];
                             $gotID = true;
				/* Special output formatting for 'version' column */
                                //$row[] = "<a href='javascript:edit();'>".$aRow[$aColumns[$i+1]]."<a>";
				//$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				//$row[] = utf8_decode($aRow[ $aColumns[$i] ]);
                                if(strcmp($columna,"codigoestado")==0){
                                    if(strcmp($aRow[ $columna ],"100")==0){
                                        $row[] = "Activo";
                                    } else {
                                        $row[] = "Inactivo";
                                    }
                                } else if((strcmp($columna,"usuario_creacion")==0) || strcmp($columna,"usuario_modificacion")==0){
                                    $consulta = "SELECT nombres,apellidos FROM usuario WHERE idusuario = ".$aRow[ $columna ];
                                    $result = mysql_query( $consulta, $gaSql['link'] ) or die(mysql_error());
                                    $rowUser = mysql_fetch_array( $result );     
                                    
                                    $row[] = $rowUser["nombres"]." ".$rowUser["apellidos"];
                                } else {
                                    if(empty($sComplexJoin) && !isset($_REQUEST["complex"])){
                                        $row[] = $aRow[ $aColumns[$i] ];                                        
                                    } else {
                                        $row[] = $aRow[ $i ];    
                                    }
                                    //var_dump($aRow[$aColumns[$i]]);
                                }
			}
                        //$row[] = $aRow[ $aColumns[$i] ];
		}
		$output['aaData'][] = $row;
                //var_dump($output);
	}
	echo json_encode( $output );
        
        
        
    function object_to_array($mixed) {
        if(is_object($mixed)) $mixed = (array) $mixed;
        if(is_array($mixed)) {
            $new = array();
            foreach($mixed as $key => $val) {
                $key = preg_replace("/^\\0(.*)\\0/","",$key);
                $new[$key] = object_to_array($val);
            }
        }
        else $new = $mixed;
        return $new;
    }
        
        
        ?>
