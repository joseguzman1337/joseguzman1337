<?php
function obtenerDatoItemSic($itemsic)
{
    return "Traer con AJAX $itemsic";
}
echo obtenerDatoItemSic($_REQUEST['iditemsic']);
?>