<!DOCTYPE html>
<html>
<head>
	<title>My Uploadify Implementation</title>
<style>
    #upload_button {
    width:120px;
    height:35px;
    text-align:center;
    /*background-image:url(boton.png);*/
    color:#CCCCCC;
    font-weight:bold;
    padding-top:15px;
    margin:auto;
} 
</style>
        
<script type="text/javascript" src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://raw.github.com/gist/826bff2445c8533dd7fc/797734455959ef27796b6770c95a7b39049ae6e9/AjaxUpload.2.0.min.js"></script>

<script language="javascript">
$(document).ready(function(){
    var button = $('#upload_button'), interval;
    new AjaxUpload('#upload_button', {
        action: 'uploadify.php',
        onSubmit : function(file , ext){
        if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
            // extensiones permitidas
            alert('Error: Solo se permiten imagenes');
            // cancela upload
            return false;
        } else {                      
            button.text('Uploading');
            this.disable();
        }
        },
        onComplete: function(file, response){
            button.text('Upload');
            // habilito upload button                       
            this.enable();          
            // Agrega archivo a la lista
            $('#lista').appendTo('.files').text(file);
        }   
    });
});
</script>
</head>
<body>
<div id="upload_button">Upload</div>
<ul id="lista">
</ul>   
</body>
</html>