<?php

//======================================================
// Copyright (C) 2004 John W. Holmes, All Rights Reserved
//
// This file is part of the Unit Command Climate
// Assessment and Survey System (UCCASS)
//
// UCCASS is free software; you can redistribute it and/or
// modify it under the terms of the Affero General Public License as
// published by Affero, Inc.; either version 1 of the License, or
// (at your option) any later version.
//
// http://www.affero.org/oagpl.html
//
// UCCASS is distributed in the hope that it will be
// useful, but WITHOUT ANY WARRANTY; without even the implied warranty
// of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// Affero General Public License for more details.
//======================================================

class UCCASS_PathDetect
{
    var $path;
    var $html;

    function UCCASS_PathDetect()
    {
        //Install path
        if(isset($_SERVER['PATH_TRANSLATED']) && !empty($_SERVER['PATH_TRANSLATED']))
        { $this->CONF['path'] = dirname($_SERVER['PATH_TRANSLATED']); }
        elseif(isset($_SERVER['SCRIPT_FILENAME']) && !empty($_SERVER['SCRIPT_FILENAME']))
        { $this->CONF['path'] = dirname($_SERVER['SCRIPT_FILENAME']); }
        else
        { $this->CONF['path'] = ''; }

        //Determine protocol of web pages
        if(isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'],'ON') == 0)
        { $protocol = 'https://'; }
        else
        { $protocol = 'http://'; }

        //HTML address of this program
        $dir_name = dirname($_SERVER['PHP_SELF']);
        if($dir_name == '\\')
        { $dir_name = ''; }

        $port = '';
        if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443')
        { $port = ':'.$_SERVER['SERVER_PORT']; }

        $this->CONF['html'] = $protocol . $_SERVER['SERVER_NAME'] . $port . $dir_name;
    }

    function path()
    { return $this->CONF['path']; }

    function html()
    { return $this->CONF['html']; }
}
?>