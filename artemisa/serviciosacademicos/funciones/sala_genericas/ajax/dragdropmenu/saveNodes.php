<?

/* Input to this file - $_GET['saveString']; */

if(!isset($_GET['saveString']))die("no input");
echo "Message from saveNodes.php\n";


$items = explode(",",$_GET['saveString']);
for($no=0;$no<count($items);$no++){
	$tokens = explode("-",$items[$no]);

	echo "ID: ".$tokens[0]. " is sub of ".$tokens[1]."\n";	// Just for testing
	
	// Example of sql
	
	// mysql_query("update nodes set parentID='".$tokens[1]."',position='$no' where ID='".$tokens[0]."'") or die(mysql_error());
	// for a table like this:
	
	/*
	
	nodes
	---------------------
	ID int
	title varchar(255)
	position int
	parentID int
	
	*/
	
}




?>