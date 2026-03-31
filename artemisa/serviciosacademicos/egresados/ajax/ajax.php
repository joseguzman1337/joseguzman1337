<?php
require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
if ($_REQUEST['editar']){
    if($_POST['option_dropdown']){
        $_POST['default'] = $_POST['option_dropdown'];
    }
     if ($_POST['id'] && $_POST['type']!=13 && isset($_POST['type'])){
       echo $query_label = "UPDATE label
        SET
        field = '".$_POST['field']."',
        label_field = '".$_POST['label_field']."',
        status = '".$_POST['status']."',        
        idlabel_type = '".$_POST['type']."',
        help = '".$_POST['help']."',
        len = '".$_POST['len']."',
        comments = '".$_POST['comments']."',
        default_value = '".$_POST['default']."',
        required = '".$_POST['required']."'
        WHERE  idlabel = '".$_REQUEST['id']."';";        
        $query_label = mysql_query($query_label, $sala) or die(mysql_error());
     } else if($_POST['id']){
		$query_label = "UPDATE label
		SET
        status = '".$_POST['status']."'
		WHERE  idlabel = '".$_REQUEST['id']."';";
        $query_label = mysql_query($query_label, $sala) or die(mysql_error());
	} else{
        $query_label = "insert into label (idlabel,table_name,field,label_field,status,idlabel_type,len,help,comments,required,default_value)
        values(null,'egresado','".$_POST['field']."','".$_POST['label_field']."','".$_POST['status']."','".$_POST['type']."',
        '".$_POST['len']."', '".$_POST['help']."', '".$_POST['comments']."','".$_POST['required']."','".$_POST['default']."')
        ;";
        $query_label = mysql_query($query_label, $sala) or die(mysql_error());
        echo $id=mysql_insert_id();
        //echo 6;
     }     
}

if ($_REQUEST['crear']){
    if($_POST['option_dropdown']){
        $_POST['default'] = $_POST['option_dropdown'];
    }
     if ($_POST['table'] && $_POST['type']!=13){
         $query_label = "ALTER TABLE ".$_POST['table']." ADD COLUMN ".$_POST['field']." VARCHAR(45) NULL ;";
         $query_label = mysql_query($query_label, $sala) or die(mysql_error());
         $query_label = "insert into label (idlabel,table_name,field,label_field,status,idlabel_type,len,help,comments,required,default_value)
        values(null,'".$_POST['table']."','".$_POST['field']."','".$_POST['label_field']."','".$_POST['status']."','".$_POST['type']."',
        '".$_POST['len']."', '".$_POST['help']."', '".$_POST['comments']."','".$_POST['required']."','".$_POST['default']."');";
        $query_label = mysql_query($query_label, $sala) or die(mysql_error());
        echo $id=mysql_insert_id();
    } else if($_POST['type']==13){
		$query_label = "insert into label (status,idlabel_type,cat_ins,idPregunta)
        values('".$_POST['status2']."','".$_POST['type']."','".$_POST['categoriaEncuesta']."', '".$_POST['preguntasEncuestas']."');";
        $query_label = mysql_query($query_label, $sala) or die(mysql_error());
        echo $id=mysql_insert_id();
	}
}


?>
