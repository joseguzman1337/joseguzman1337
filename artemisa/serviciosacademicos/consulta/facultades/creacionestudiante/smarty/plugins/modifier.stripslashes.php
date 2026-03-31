<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     stripslashes
 * Purpose:  strip escape characters in the string
 * -------------------------------------------------------------
 */
function smarty_modifier_stripslashes($string)
{
    return stripslashes($string);
}

?>
