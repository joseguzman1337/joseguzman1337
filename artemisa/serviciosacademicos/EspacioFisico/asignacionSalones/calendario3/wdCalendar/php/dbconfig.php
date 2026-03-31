<?php
class DBConnection{
	function getConnection(){
	  //change to your database server/user name/password
		mysql_connect("localhost","root","N4c10n4l") or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db("wdCalendar") or 
		     die("Could not select database: " . mysql_error());
	}
}
?>