<?php 
/*
  V4.90 8 June 2006  (c) 2000-2006 John Lim (jlim#natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
  
  Some pretty-printing by Chris Oxenreider <oxenreid@state.net>
*/ 
  
// specific code for tohtml
GLOBAL $gSQLMaxRows,$gSQLBlockRows,$ADODB_ROUND;

$ADODB_ROUND=4; // rounding
$gSQLMaxRows = 1000; // max no of rows to download
$gSQLBlockRows=20; // max no of rows per table block

// RecordSet to HTML Table
//------------------------------------------------------------
// Convert a recordset to a html table. Multiple tables are generated
// if the number of rows is > $gSQLBlockRows. This is because
// web browsers normally require the whole table to be downloaded
// before it can be rendered, so we break the output into several
// smaller faster rendering tables.
//
// $rs: the recordset
// $ztabhtml: the table tag attributes (optional)
// $zheaderarray: contains the replacement strings for the headers (optional)
//
//  USAGE:
//	include('adodb.inc.php');
//	$db = ADONewConnection('mysql');
//	$db->Connect('mysql','userid','password','database');
//	$rs = $db->Execute('select col1,col2,col3 from table');
//	rs2html($rs, 'BORDER=2', array('Title1', 'Title2', 'Title3'));
//	$rs->Close();
//
// RETURNS: number of rows displayed


function rs2html(&$rs,$ztabhtml=false,$zheaderarray=false,$htmlspecialchars=true,$echo = true,$filter=false,$linkfilter="",$totalsColumns=false, $order=false, $edit=false, $delete=false, $select=false, $queryheaderarray=false, $linkrowarray=false, $helparray=false, $db=false)
{
	$s ='';$rows=0;$docnt = false;
	GLOBAL $gSQLMaxRows,$gSQLBlockRows,$ADODB_ROUND;
	if (!$rs) 
	{
		printf(ADODB_BAD_RS,'rs2html');
		return false;
	}
	
	if (! $ztabhtml) $ztabhtml = "BORDER='1' WIDTH='98%'";
	//else $docnt = true;
	$typearr = array();
	$ncols = $rs->FieldCount();
	$hdr = "<TABLE COLS=$ncols $ztabhtml><tr>\n\n";
	
	// Si se quieren las columnas con totales entra
	if($totalsColumns)
	{
		$hdr .= "</tr><tr><td colspan='$ncols'><label id='labelresaltado'>Seleccione las columnas de la cual desea sacar totales y de click en el botón Enviar</label>
		</td></tr><tr>";
		for ($i=0; $i < $ncols; $i++) 
		{
			$field = $rs->FetchField($i);
			if ($field) 
			{
				$fname = htmlspecialchars($field->name);	
				//print " $field->name $field->type $typearr[$i] ";
			} 
			else 
			{
				$fname = 'Field '.($i+1);
			}
			$check = "";
			$totalsarr[$i] = false;
			if($_REQUEST['totals_'.$fname] != "")
			{
				$check = "checked";
				$totalsarr[$i] = true;
				//$total = "&totals_$fname=$fname";
			}
			if (strlen($fname)==0) $fname = '&nbsp;';
			//echo "<h1>totals_$fname</h1>";
			$hdr .= "<td><input type='checkbox' name='totals_$fname' value='$fname]' $check></td>";
		}
		$hdr .= "</tr><tr>";
	}
	// Si quiere con filtro entra
	if($filter)
	{
		for ($i=0; $i < $ncols; $i++) 
		{
			$field = $rs->FetchField($i);
			if ($field) 
			{
				$fname = htmlspecialchars($field->name);	
				//print " $field->name $field->type $typearr[$i] ";
			} 
			else 
			{
				$fname = 'Field '.($i+1);
			}
			if (strlen($fname)==0) $fname = '&nbsp;';
			$hdr .= "<td><input type='text' name='filter_$fname' value='".$_REQUEST['filter_'.$fname]."' width='100%'></td>";
		}
		$hdr .= "</tr><tr>";
	}
	// Coloca los titulos de las columnas
	for ($i=0; $i < $ncols; $i++) 
	{	
		$field = $rs->FetchField($i);
		if ($field) 
		{
			if ($zheaderarray) $fname = $zheaderarray[$i];
			else $fname = htmlspecialchars($field->name);	
			$typearr[$i] = $rs->MetaType($field->type,$field->max_length);
			if($field->type == "time")
			{
				$typearr[$i] = "D";
			}
			//echo "$field->type"."$field->max_length<br>";
 			//print " $field->name $field->type $typearr[$i] ";
		} 
		else 
		{
			$fname = 'Field '.($i+1);
			$typearr[$i] = 'C';
		}
		if (strlen($fname)==0)
		{
			$fname = '&nbsp;';
		}
		
		//getLink($order, $linkfilter);
		if($fname != '&nbsp;')
		{
			$quitColumn[$i] = true;
			if($helparray[$i])
			{
				$help = ' <a href="javascript:void(0);" onmouseover="return overlib('.$helparray[$i].');" onmouseout="return nd();"><img src="'.RUTAZ_ADO.'imagenes/pregunta.gif" style="border-color:#FFFFFF"></a>';
			}
			else
			{
				$help = "";
			}
			if($order)
			{
				$hdr .= "<TD id='tdtitulogris'><a href='".$_SERVER['PHP_SELF']."?".getLink($i, $order, $linkfilter)."'>$fname</a>$help</TD>";
			}
			else
			{
				$hdr .= "<TD id='tdtitulogris'>$fname</TD>";
			}
		}
	}
	if($edit || $delete || $select)
	{
		if($helparray[$i])
		{
			$help = ' <a href="javascript:void(0);" onmouseover="return overlib('.$helparray[$i].');" onmouseout="return nd();"><img src="'.RUTAZ_ADO.'imagenes/pregunta.gif" style="border-color:#FFFFFF"></a>';
		}
		else
		{
			$help = "";
		}
		$hdr .= "<TD id='tdtitulogris'>Acción$help</TD>";
	}
	$hdr .= "\n</tr>";
	if ($echo) print $hdr."\n\n";
	else $html = $hdr;
	
	// smart algorithm - handles ADODB_FETCH_MODE's correctly by probing...
	$numoffset = isset($rs->fields[0]) ||isset($rs->fields[1]) || isset($rs->fields[2]);
	
	// Coloca los campos necesarios para crear un nuevo registro
	if(isset($_REQUEST['nanew']))
	{
		for ($i=0; $i < $ncols; $i++) 
		{
			//echo "$i=0; $i < $ncols; $i++";
			
			$type = $typearr[$i];
			if($quitColumn[$i])
			{
				$field = $rs->FetchField($i);
				$fname = htmlspecialchars($field->name);
					
				// Escribe los datos de la consulta
				
				//echo "<h1>PRIMERO: $type, $v, $id, ".$queryheaderarray[$i].", $fname, $rs, $db</h1>";
				getNew($type, $v, $queryheaderarray[$i], $fname, $s, $rs, $db);
			}
		}
		unset($_REQUEST['nanew']);
		$s .= "<TD><input type=submit value=Guardar name=nasavenew></TD>\n";
		//exit();
	}
	while (!$rs->EOF) 
	{
		$s .= "<TR valign=top>\n";
		
		for ($i=0; $i < $ncols; $i++) 
		{
			if ($i===0) $v=($numoffset) ? $rs->fields[0] : reset($rs->fields);
			else $v = ($numoffset) ? $rs->fields[$i] : next($rs->fields);
			
			// Se supone que la primera columna tiene el id que va a ser editado
			if($i==0)
			{
				$id = $v;
			}
			
			// En este arrreglo guardo los totales de cada columna
			if($totalsarr[$i])
			{
				// Se usa para crear un espacio para colocar los campos necesarios para crear un nuevo campo
				$totalsarr[$i] = $totalsarr[$i]+$v;
			}
						
			$type = $typearr[$i];
			if($quitColumn[$i])
			{
				$field = $rs->FetchField($i);
				$fname = htmlspecialchars($field->name);
				
				// Escribe los datos de la consulta
				//echo "<h1>PRIMERO: $type, $v, $id, ".$queryheaderarray[$i].", $fname, $rs, $db</h1>";
				getData($type, $v, $id, $queryheaderarray[$i], $fname, $s, $linkrowarray[$i], $rs, $db);
			}
		} // for
		if($edit || $delete || $select)
		{
			if($_REQUEST['naedit'] != $id)
			{
				if($edit)
				{
					$edit = "<a href=".$PHP_SELF."?naedit=$id".getGet().">Editar</a>";
				}
				if($delete)
				{
					$delete = "<a href=".$PHP_SELF."?nadelete=$id".getGet().">Eliminar</a>";
				}
				if($select)
				{
					$select = "<input type=checkbox name=naselect$id value=$id checked>";
				}
				$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF']);
				$s .= "<TD>$edit $delete $select</TD>\n";
			}
			else
			{
				$s .= "<TD><input type=hidden name=naid value=$id><input type=submit name=nasaveedit value=Guardar></TD>\n";
			}
		}
		$s .= "</TR>\n\n";
		  
		$rows += 1;
		if ($rows >= $gSQLMaxRows) 
		{
			$rows = "<p>Truncated at $gSQLMaxRows</p>";
			break;
		} 
		$rs->MoveNext();

		// additional EOF check to prevent a widow header
		if (!$rs->EOF && $rows % $gSQLBlockRows == 0) 
		{
			if($totalsColumns)
			{
				$s .= "<TR valign=top>\n";
				foreach($totalsarr as $key => $value)
				{
					$s .= "	<TD>".stripslashes($value)."</TD>\n";
				}
				$s .= "</TR>\n\n";
			}
	
			//if (connection_aborted()) break;// not needed as PHP aborts script, unlike ASP
			if ($echo) print $s . "</TABLE>\n\n";
			else $html .= $s ."</TABLE>\n\n";
			$s = $hdr;
		}
	} // while
	
	if($totalsColumns)
	{
		$s .= "<TR valign=top><td colspan='$ncols' id='tdtitulogris'>TOTALES</td>\n";
		$s .= "<TR valign=top>\n";
		foreach($totalsarr as $key => $value)
		{
			if($value)
			{
				$value--;
			}
			$s .= "	<TD align=right>".stripslashes($value)."&nbsp;</TD>\n";
		}
		$s .= "</TR>\n\n";
	}
	
	if ($echo) print $s."</TABLE>\n\n";
	else $html .= $s."</TABLE>\n\n";
	
	if ($docnt) if ($echo) print "<H2>".$rows." Rows</H2>";
	
	return ($echo) ? $rows : $html;
}
 
// pass in 2 dimensional array
function arr2html(&$arr,$ztabhtml='',$zheaderarray='')
{
	if (!$ztabhtml) $ztabhtml = 'BORDER=1';
	
	$s = "<TABLE $ztabhtml>";//';print_r($arr);

	if ($zheaderarray) 
	{
		$s .= '<TR>';
		for ($i=0; $i<sizeof($zheaderarray); $i++) 
		{
			$s .= "	<TH>{$zheaderarray[$i]}</TH>\n";
		}
		$s .= "\n</TR>";
	}
	
	for ($i=0; $i<sizeof($arr); $i++) 
	{
		$s .= '<TR>';
		$a = &$arr[$i];
		if (is_array($a)) 
		for ($j=0; $j<sizeof($a); $j++) 
		{
			$val = $a[$j];
			if (empty($val)) $val = '&nbsp;';
			$s .= "	<TD>$val</TD>\n";
		}
		else if ($a) 
		{
			$s .=  '	<TD>'.$a."</TD>\n";
		} 
		else $s .= "	<TD>&nbsp;</TD>\n";
		$s .= "\n</TR>\n";
	}
	$s .= '</TABLE>';
	print $s;
}

function rstomenu($queryheader, $fname, &$id, $db)
{
	//echo "<h1>NEW MENU: ".$_REQUEST['nanew']."</h1>";
	//exit();
	if(!isset($_REQUEST['nanew']))
	{
		$queryName = ereg_replace("end$","",$queryheader)."$id";
		$queryName = ereg_replace("beg","",$queryName);
		// $queryName = ereg_replace(" where .+$"," order by 1",$queryName);
		//echo "<h1>$queryName</h1>";*/
		//echo "<h1>$queryName</h1>";
		$rsName = $db->Execute($queryName);
		foreach($rsName->fields as $key => $value)
		{
			$id = $value;
			break;
		}
	}
	/*else
	{
		$id = $value;
	}*/
	if(!ereg("and",$queryheader))
	{
		$queryHeader = ereg_replace(" where .+end$"," order by 1",$queryheader);
	}
	else
	{
		$queryHeader = ereg_replace("begand.+end$"," order by 1",$queryheader);
	}
	//echo "<h1>$id aaa $queryHeader</h1>";

	$rsMenu = $db->Execute($queryHeader);
	return $rsMenu->GetMenu("naupdate$fname",$id,false);
}

function getLink($i, $order, $linkfilter)
{
	if($order)
	{
		$order = "&$i=";
		if($_REQUEST[$i] == "")
		{
			$order = "&$i=desc";
		}
	}
	$linkfilter =ereg_replace("&[0-9]+=desc|&[0-9]+=","",$linkfilter);
	$get = "";
	foreach($_GET as $key => $value)
	{
		if(!is_numeric($key) && $key != "row_page" && !ereg("na",$key)) 
			$get .= "&$key=$value";
	}
	return "$linkfilter$get$order";
}
function getGet()
{
	$linkfilter = ereg_replace("&[0-9]+=desc|&[0-9]+=","",$linkfilter);
	$get = "";
	foreach($_GET as $key => $value)
	{
		if($key != "row_page" && !ereg("na",$key)) 
			$get .= "&$key=$value";
	}
	return "$linkfilter$get";
}

function getData($type, $field, $id, $queryheader, $fname, &$s, $linkrow, $rs, $db)
{
	//echo "<h1>$type, $field, $id, $queryheader, $fname, $rs, $db</h1>";
	switch($type) 
	{
		case 'D':
			if (empty($field)) 
			{
				if($_REQUEST['naedit'] == $id)
				{
					if($queryheader)
					{
						$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
					}
					else
					{
						$s .= "	<TD><input type=text name=naupdate$fname></TD>\n";
					}
				}
				else
				{
					if($queryheader)
					{
						rstomenu($queryheader, $fname, $field, $db);
					}
					$s .= "<TD>$field</TD>\n";
				}
			}
			else if (!strpos($field,':')) 
			{
				//$s .= "	<TD>".$rs->UserDate($field,"D d, M Y") ."&nbsp;</TD>\n";
				if($_REQUEST['naedit'] == $id)
				{
					if($queryheader)
					{
						$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
					}
					else
					{
						$s .= "	<TD><input type=text name=naupdate$fname value=".$rs->UserDate($field,"H:i:s")."></TD>\n";
					}
				}
				else
				{
					if($queryheader)
					{
						rstomenu($queryheader, $fname, $field, $db);
					}
					$s .= "	<TD>".$rs->UserDate($field,"Y-m-d")."&nbsp;</TD>\n";
				}
			}
			else
			{
				//$s .= "	<TD>".$rs->UserDate($field,"D d, M Y") ."&nbsp;</TD>\n";
				if($_REQUEST['naedit'] == $id)
				{
					if($queryheader)
					{
						$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
					}
					else
					{
						$s .= "	<TD><input type=text name=naupdate$fname value=".$rs->UserDate($field,"H:i:s")."></TD>\n";
						$s .= '<script type="text/javascript">Calendar.setup(	{ inputField : "naupdate'.$fname.'", ifFormat : "%H:%M:%S", showsTime: true, text : "naupdate'.$fname.'" }); </script>';
					}
				}
				else
				{
					if($queryheader)
					{
						rstomenu($queryheader, $fname, $field, $db);
					}
					$s .= "	<TD>".$rs->UserDate($field,"H:i:s")."&nbsp;</TD>\n";
				}
			}
			break;
		case 'T':
			if (empty($field)) 
			{
				if($_REQUEST['naedit'] == $id)
				{
					if($queryheader)
					{
						$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
					}
					else
					{
						$s .= "	<TD><input type=text name=naupdate$fname></TD>\n";
					}
				}
				else
				{
					if($queryheader)
					{
						rstomenu($queryheader, $fname, $field, $db);
					}
					$s .= "<TD> &nbsp; </TD>\n";
				}
			}
			else
			{
				//$s .= "	<TD>".$rs->UserTimeStamp($field,"D d, M Y, h:i:s") ."&nbsp;</TD>\n";
				if($_REQUEST['naedit'] == $id)
				{
					if($queryheader)
					{
						$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
					}
					else
					{
						//echo '<br>sdasd <br>Calendar.setup(	{ inputField : "naupdate'.$fname.'",<br> ifFormat : "%Y-%m-%d",<br> text : "naupdate'.$fname.'" });';
						$s .= "	<TD><input type=text name=naupdate$fname value='".$rs->UserTimeStamp($field,"Y-m-d h:i:s")."'></TD>\n";
						$s .= '<script type="text/javascript">Calendar.setup(	{ inputField : "naupdate'.$fname.'", ifFormat : "%Y-%m-%d %H:%M:%S", showsTime: true, text : "naupdate'.$fname.'" }); </script>';
					}
				}
				else
				{
					if($queryheader)
					{
						rstomenu($queryheader, $fname, $field, $db);
					}
					$s .= "	<TD>".$rs->UserTimeStamp($field,"Y-m-d h:i:s")."&nbsp;</TD>\n";
				}
			}
			break;
		case 'N':
			if (abs(abs($field) - round($field,0)) < 0.00000001)
				$field = round($field);
			else
				$field = round($field,$ADODB_ROUND);
			break;
		case 'I':
			if($_REQUEST['naedit'] == $id)
			{
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value=".stripslashes((trim($field))) ."></TD>\n";
				}
			}
			else
			{
				$align="align=right";
				if($queryheader)
				{
					rstomenu($queryheader, $fname, $field, $db);
					$align="";
				}
				$s .= "	<TD $align>".stripslashes((trim($field)))."</TD>\n";
			}
			break;
		/*
		case 'B':
			if (substr($field,8,2)=="BM" ) $field = substr($field,8);
			$mtime = substr(str_replace(' ','_',microtime()),2);
			$tmpname = "tmp/".uniqid($mtime).getmypid();
			$fd = @fopen($tmpname,'a');
			@ftruncate($fd,0);
			@fwrite($fd,$field);
			@fclose($fd);
			if (!function_exists ("mime_content_type")) 
			{
				function mime_content_type ($file) 
				{
					return exec("file -bi ".escapeshellarg($file));
				}	
			}
			$t = mime_content_type($tmpname);
			$s .= (substr($t,0,5)=="image") ? " <td><img src='$tmpname' alt='$t'></td>\\n" : " <td><a
			href='$tmpname'>$t</a></td>\\n";
			break;
		*/
		default:
			//echo "$type, $field, $id, $queryheader, $fname, $rs, $db<br>";
		
			if ($htmlspecialchars) $field = htmlspecialchars(trim($field));
			$field = trim($field);
			if (strlen($field) == 0) $field = '&nbsp;';
			if($_REQUEST['naedit'] == $id)
			{
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value='".str_replace("\n",'<br>',stripslashes($field))."'></TD>\n";
				}
			}
			else
			{
				if($queryheader)
				{
					rstomenu($queryheader, $fname, $field, $db);
				}
				if(!$linkrow)
				{
					$s .= "	<TD>".str_replace("\n",'<br>',stripslashes($field))."</TD>\n";
				}
				else
				{
					$s .= "	<TD><a href=$linkrow$id>".str_replace("\n",'<br>',stripslashes($field))."</a></TD>\n";
				}
			}
	}
}

function getNew($type, $field, $queryheader, $fname, &$s, $rs, $db)
{
	//echo "<h1>ENTRO ACA: $type, $field, $id, $queryheader, $fname, $rs, $db</h1>";
	switch($type) 
	{
		case 'D':
			if (empty($field)) 
			{
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value=".$_REQUEST['naupdate'.$fname]."></TD>\n";
					$s .= '<script type="text/javascript">Calendar.setup(	{ inputField : "naupdate'.$fname.'", ifFormat : "%H:%M:%S", showsTime: true, text : "naupdate'.$fname.'" }); </script>';
				}
			}
			else if (!strpos($field,':')) 
			{
				//$s .= "	<TD>".$rs->UserDate($field,"D d, M Y") ."&nbsp;</TD>\n";
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value=".$_REQUEST['naupdate'.$fname]."></TD>\n";
				}
			}
			break;
		case 'T':
			if (empty($field)) 
			{
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value=".$_REQUEST['naupdate'.$fname]."></TD>\n";
					$s .= '<script type="text/javascript">Calendar.setup(	{ inputField : "naupdate'.$fname.'", ifFormat : "%Y-%m-%d %H:%M:%S", showsTime: true, text : "naupdate'.$fname.'" }); </script>';
				}
			}
			else
			{
				if($queryheader)
				{
					$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
				}
				else
				{
					$s .= "	<TD><input type=text name=naupdate$fname value=".$_REQUEST['naupdate'.$fname]."></TD>\n";
				}
			}
			break;
		case 'N':
			if (abs(abs($field) - round($field,0)) < 0.00000001)
				$field = round($field);
			else
				$field = round($field,$ADODB_ROUND);
			break;
		case 'I':
			if($queryheader)
			{
				$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
			}
			else
			{
				$s .= "	<TD><input type=text name=naupdate$fname value=".$_REQUEST['naupdate'.$fname]."></TD>\n";
			}
			break;
		/*
		case 'B':
			if (substr($field,8,2)=="BM" ) $field = substr($field,8);
			$mtime = substr(str_replace(' ','_',microtime()),2);
			$tmpname = "tmp/".uniqid($mtime).getmypid();
			$fd = @fopen($tmpname,'a');
			@ftruncate($fd,0);
			@fwrite($fd,$field);
			@fclose($fd);
			if (!function_exists ("mime_content_type")) 
			{
				function mime_content_type ($file) 
				{
					return exec("file -bi ".escapeshellarg($file));
				}	
			}
			$t = mime_content_type($tmpname);
			$s .= (substr($t,0,5)=="image") ? " <td><img src='$tmpname' alt='$t'></td>\\n" : " <td><a
			href='$tmpname'>$t</a></td>\\n";
			break;
		*/
		default:
			//echo "$type, $field, $id, $queryheader, $fname, $rs, $db<br>";
		
			if ($htmlspecialchars) $field = htmlspecialchars(trim($field));
			$field = trim($field);
			if (strlen($field) == 0) $field = '&nbsp;';
			if($queryheader)
			{
				$s .= "	<TD>".rstomenu($queryheader, $fname, $field, $db)."</TD>\n";
			}
			else
			{
				$s .= "	<TD><input type=text name=naupdate$fname value=".str_replace("\n",'<br>',stripslashes($_REQUEST['naupdate'.$fname]))."></TD>\n";
			}
	}
}
?>