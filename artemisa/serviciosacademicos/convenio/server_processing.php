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
	
	/* Database connection information */
	/*$gaSql['user']       = "desarrollo";
	$gaSql['password']   = "desarrollosala";
	$gaSql['db']         = "sala";
	$gaSql['server']     = "172.16.3.227";*/
	
         require_once('../Connections/sala2.php');
        	
	/* Database connection information */
	$gaSql['user']       = $username_sala;
	$gaSql['password']   = $password_sala;
	$gaSql['db']         = $database_sala;
	$gaSql['server']     = $hostname_sala; 
         
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	#include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
	
	
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
        $sQl=$_REQUEST['sql'];
        $iCl=$_REQUEST['IndexColumn'];
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
        
        if (empty($sQl)){
            $sQuery = "select * from ".$sTable." where ".$inD."codigoestado='100' limit 1";
        }else{ 
            $sQuery = $sQl." ".$Swhere." ".$inD."codigoestado='100' limit 1 ";
        }
     //   echo $sQuery.'<br>';
        $tResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());  
        $consulta ="";
      
        if (empty($sQl)){
            $consulta = "SHOW FIELDS FROM ".$_REQUEST['table']." ";
            $resultado = mysql_query($consulta, $gaSql['link']) or die ( mysql_error() );
            while($datos = mysql_fetch_array($resultado)){
                $aColumns[]=$datos['Field'];        
            }    
        }else{
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
                while($datos = mysql_fetch_assoc($resultado)){
                    //print_r($datos);
                        foreach($datos as $key => $value) {
                        $aColumns[] = $key;
                    }
                }
            }
        }
  // echo $consulta;
        if(!is_array($aColumns)){
            $tRow = object_to_array(mysql_fetch_object( $tResult ));            
            if(is_array($tRow)){
                foreach ($tRow as $key => $value){                           
                    $aColumns[]=$key;
                }
            }
        }
        
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
        
       // print_r($aColumns);
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
				 	mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ') ';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= "  ";
			}
			$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	//echo $sWhere.'okok<br>';
	
	/*
	 * SQL queries
	 * Get data to display
	 */
        if (!empty($sWhere)){
             $sWhere.=" AND  ".$inD."codigoestado='100'";
        }else{
           $sWhereP=" ".$Swhere." ".$inD."codigoestado='100' ";
        }
        if (!empty($sW) and !empty($sV)){
               $sWhereP.=" AND ".$sW."=".$sV."  ";
        }
	 if (empty($sQl)){
                $sQuery = "
                        SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
                        FROM   $sTable 
                        $sWhere 
                        $sWhereP
                        $sOrder
                        $sLimit
                        ";
         }else{
             $sQuery = "
                        SELECT SQL_CALC_FOUND_ROWS ".str_replace("SELECT", " ",$sQl)."
                        $sWhere 
                        $sWhereP
                        $sOrder
                        $sLimit
                        ";
         }
        //echo $sQuery.'<br>';
        $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
        //print $sQuery.' ok <br> ';
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
         if (empty($sQl)){
                $sQuery = "
                        SELECT COUNT(`".$sIndexColumn."`)
                        FROM    $sTable 
                                $sWhereP
                                $sOrder
                                $sLimit
                ";
         }else{
             $dP=explode("FROM",$sQl);
             $dP=$dP[1];
             $sWhere=$dP;
              $sQuery = "
                        SELECT COUNT(*)
                        FROM $sWhere 
                        $sWhereP
                        $sOrder
                        $sLimit
                        ";
         }
       // print $sQuery.' ok okok <br> ';
        
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	//echo $iTotal.'ok';
	//echo $iTotal;
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		//print_r($row);
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "id".$_REQUEST['table'] ){
                            $row[DT_RowId]= 'row_'.$aRow[ $aColumns[$i] ];
				/* Special output formatting for 'version' column */
                                //$row[] = "<a href='javascript:edit();'>".$aRow[$aColumns[$i+1]]."<a>";
				//$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				//$row[] = utf8_encode($aRow[ $aColumns[$i] ]);
                                $row[] = $aRow[ $aColumns[$i] ];
			}
                        //$row[] = $aRow[ $aColumns[$i] ];
		}
		$output['aaData'][] = $row;
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