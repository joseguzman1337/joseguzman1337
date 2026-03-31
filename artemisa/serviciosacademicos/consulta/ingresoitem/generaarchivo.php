<?php

$file = $_GET['file'];

if(file_exists( "$file")) {

$data = fopen("$file", "r");

$size = filesize("$file");

$type= filetype("$file");

$file_content = fread($data,$size);

header("Content-type: $type");

header("Content-length: $size");

header("Content-Disposition: attachment; filename=$file");

header("Content-Description: PHP Generated Data");

echo $file_content;

} else {

echo "<script languaje='javascript'>

alert('El archivo no ha sido encontrado, comuníquese con el área de tecnología.');

</script>";

}

?>
