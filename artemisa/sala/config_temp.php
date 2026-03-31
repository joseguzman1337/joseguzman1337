<?php
        exec('find /usr/local/apache2/htdocs/html/sala -type f -mtime -1 -printf "%T@\n" | sort -nr | head -1',$last1);
	var_dump($last1);
        $t = explode(".",$last1[0]);
	var_dump($t);
        if(is_array($t)){
            $t = $t[0];
        }else{
            $t = $last1[0];
        }
	echo $t;
?>
