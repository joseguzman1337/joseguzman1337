<?php
session_start();

include('templates/execute.php');

?>
<script>
    function executeSondaEcollet()
    {
        Pace.track(function() {
            $.ajax({
                type: 'POST',
                url: '../../libsoap/launchPSE.php',
                success: function (data) {
                    $('#divDataSonda').html(data);
                    $('#divDataSonda').show();
                },
                error: function (data, error, errorThrown) {
                    alert(error + errorThrown);
                }
            });
        });
    }
</script>
