$(document).ready(function(){
    $('#calendar').fullCalendar({
        header: {
            left: 'title',
            right: 'prev,next today'
        },
        eventLimit: true, // allow "more" link when too many events
        events: events,
        eventRender: function(event, element) {
            element.qtip({
                content: "<strong>"+event.title+"</strong><br /><br />"+event.description + '<br /><br /><strong>Lugar:</strong> ' + event.site,
                style: {
                    background: 'black',
                    color: '#FFFFFF'
                },
                position: {
                    corner: {
                        target: 'center',
                        tooltip: 'bottomMiddle'
                    }
                }
            });
        }
    });
});
