<?

/**
*	The purpose of this file is to rename a node in the database 
*	
*	Input : $_GET['renameId']
*			$_GET['newName']
*
*		OR
*
*			$_GET['deleteIds'] 
*
*		If a delete request is sent
*
***/

/*  The TWO line below is only for the demo as we aren't connected to the database */
echo "OK";
exit;


if(isset($_GET['renameId']) && isset($_GET['newName']))	{	// variables are set

	// Typical code
	
	$res = mysql_query("select * from category where ID='".$_GET['renameId']."'");
	if($inf = mysql_fetch_array($res)){
		mysql_query("update category set categoryName='".$_GET['newName']."' where ID='".$inf["ID"]."'") or die("NOT OK");
		echo "OK";	// OK when everything is ok
	}
	echo "NOT OK";	// Node didn't exist -> Message not ok


	
	exit;
}

if(isset($_GET['deleteIds'])){	// Format of $_GET['deleteIds'] : A comma separated list of ids to delete, example: 1,2,3,4,5,6,7
	
	// Typical code
	
	mysql_query("delete from category where ID IN(".$_GET['deleteIds']."')") or die("NOT OK");
	echo "OK";
}

echo "NOT OK";

