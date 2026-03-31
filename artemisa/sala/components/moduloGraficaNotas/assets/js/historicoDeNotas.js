var plot = $.plot("#historicoDeNotas", [
        {
            label: 'Nota semestre',
            data: notas,
            lines: {
                show: true,
                lineWidth:2,
                fill: true,
                fillColor: {
                    colors: [{opacity: 0.5}, {opacity: 0.5}]
                }
            },
            points: {
                show: true,
                radius: 4
            }
        }
    ],{
    series: {
        lines: {
            show: false
        },
        shadowSize: 3	// Drawing is faster without shadows
    },
    colors: ['#87bd4b'],
    legend: {
        show: true,
        position: 'nw',
        margin: [15, 0]
    },
    grid: {
        borderWidth: 0,
        hoverable: true,
        clickable: true
    },
    yaxis: {
        ticks: 4, tickColor: '#eeeeee'
    },
    xaxis: {
        ticks: ticksXaxis,
        tickColor: '#ffffff'
    }
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

$("#historicoDeNotas").bind("plothover", function (event, pos, item) {
    if (item) {
        var x = item.datapoint[0],  y = item.datapoint[1];
        $("#flot-tooltip").html("<p class='h4'>Semestre "+x+": <br>" + y+"</p>Periodo: "+periodos[x-1])
            .css({top: item.pageY+5, left: item.pageX+5})
            .fadeIn(200);
    } else {
        $("#flot-tooltip").hide();
    }
});