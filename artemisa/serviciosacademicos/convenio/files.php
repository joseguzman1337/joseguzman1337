<?php                 
$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; 
if (!$xhr)  
    echo '<textarea>'; 
?> 
 
// main content of response here 
                 
<?php 
if (!$xhr)   
    echo '</textarea>'; 
?> 