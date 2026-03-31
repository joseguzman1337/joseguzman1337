$(document).ready(function() {
   //$("#CiudadDiv").hide();
});
/*
function ValidarExtranjero() {
    var pais = document.getElementById("Pais").value;
    alert(pais);
    $.ajax({
        URL : '../listado.php',
        datatype: 'html',
        type: 'POST',
        data: {pais:pais, acction:'consultaCiudad'},
        sucess: function(data){
            console.log(data);
            $("#CiudadDiv").html(data);            
        }
    });
}