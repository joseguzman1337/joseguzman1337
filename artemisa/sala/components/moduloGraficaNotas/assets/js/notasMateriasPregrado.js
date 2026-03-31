function hellohook(plot, canvascontext) {
    $( ".legend" ).draggable({
        /* containment: '.flot-text'*/
    });
}
var plot = $.plot("#notasMaterias", labels,{
    series: {
        lines: {
            show: true
        },
        points: {
            show: true
        },
        shadowSize: 0	// Drawing is faster without shadows
    },
    colors: colors,
    legend: {
        show: false,
        position: 'se',
        margin: [15, 0]
    },
    grid: {
        borderWidth: 1,
        hoverable: true,
        clickable: true
    },
    yaxis: {
        ticks: 14, tickColor: '#eeeeee'
    },
    xaxis: {
        ticks: ticksXaxis,
        tickColor: '#ffffff'
    },
    hooks: { draw: [hellohook] }
});


// Flot tooltip
// =================================================================
$("<div id='flot-tooltip'></div>").css({
    position: "absolute",
    display: "none",
    padding: "10px",
    color: "#fff",
    "text-align":"right",
    "background-color": "#1c1e21"
}).appendTo("body");


$("#notasMaterias").bind("plothover", function (event, pos, item) {

    if (item) {
        var x = item.datapoint[0].toFixed(2),  y = item.datapoint[1];
        $("#flot-tooltip").html("<p class='h5'>" + item.series.label + "</p>"+cortes[x-1] +" corte: " + y)
            .css({top: item.pageY+5, left: item.pageX+5})
            .fadeIn(200);
    }else{
        $("#flot-tooltip").hide();
    }

});

$(function(){
    $(".cabiarPeriodo").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        cambiarPeriodo(this);
    });
});

function cambiarPeriodo(obj){
    var codigoPeriodo = $(obj).attr("data-codigoPeriodo");
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json',
            layout : "notasMateriasPregrado",
            option : "moduloGraficaNotas",
            codigoPeriodo : codigoPeriodo
        },
        success: function( data ){
            $("#contenido-estudiante").html(data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}