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

class UCCASS_Config
{
    var $sequences;

    /**************
    * CONSTRUCTOR *
    **************/
    function UCCASS_Config($file = '')
    {
        // If $file was passed, load it
        if($file != '')
        { $this->load_file($file); }

        return;
    }

    /************
    * LOAD FILE *
    ************/
    function load_file($file)
    {
        // Check that file exists
        if(file_exists($file))
        {
            // Check that file can be
            // opened for reading
            if($fp = fopen($file,"r"))
            {
                // Read ini file and replace all
                // variable = value lines with
                // form elements
                $ini_file = fread($fp,filesize($file));
                $ini_file = str_replace("\\","\\\\",$ini_file);
                $ini_file = preg_replace('/^([a-z0-9_.-]+)\s?=\s?"?([^\r\n]+)?"?$/im',
                                         "</pre>$1: <input type=\"text\" name=\"$1\" value=\"$2\" size=\"40\"></td></tr><tr><td><pre>\n",
                                         $ini_file);

                //Strip semi-colons from the beginning
                //of comments and apply htmlentities()
                //to the rest of the data.
                $ini_file = preg_replace('/^;(.*)$/em','@htmlentities(stripslashes("$1"));',$ini_file);

                $this->form = "<html><head><title>UCCASS Configuration</title></head><body>
                               <form method=\"POST\" action=\"install.php\">
                               <table cellpadding=\"4\" border=\"1\"><tr><td>
                               Install Type:
                                 <select name=\"installation_type\" size=\"1\">
                                   <option value=\"\">Choose...</option>
                                   <option value=\"updateconfigonly\">Update Configuration Only</option>
                                   <option value=\"newinstallation\">New Installation</option>
                                   <option value=\"upgrade_104\">Upgrade From v1.04</option>
                                   <option value=\"upgrade_105\">Upgrade From v1.05</option>
                                   <option value=\"upgrade_106\">Upgrade From v1.06</option>
                                   <option value=\"upgrade_180\">Upgrade From v1.8.0</option>
                                 </select>
                               </td></tr><tr><td>
                               <pre>{$ini_file}</pre></td></tr>
                               <tr><td>
                               <input type=\"submit\" name=\"config_submit\" value=\"Save All Settings\">
                               </td></tr>
                               </form>";
            }
            else
            { $this->error("Cannot read configuration file: $file"); return; }
        }
        else
        { $this->error("Configuration file does not exist: $file"); return; }

        fclose($fp);

        return;
    }

    /************
    * SHOW FORM *
    ************/
    function show_form()
    { return $this->form; }

    /*****************************
    * PROCESS CONFIGURATION FORM *
    *****************************/
    function process_config($file)
    {
        if(file_exists($file))
        {
            $fp = fopen($file,"r");
            $ini_file = fread($fp,filesize($file));
            fclose($fp);

            if($fp = fopen($file,"w"))
            {
                foreach($_POST as $key=>$value)
                {
                    if(get_magic_quotes_gpc())
                    { $value = stripslashes($value); }

                    if(preg_match("/[^a-z0-9]/i",$value))
                    { $value = '"' . $value . '"'; }
                    $ini_file = preg_replace("/^".$key."\s?=.*$/m","$key = $value",$ini_file);
                }

                if(!fwrite($fp,$ini_file))
                { $this->error("Cannot write to file"); return; }

                fclose($fp);
            }
            else
            { $this->error("Cannot write to file: $file"); return; }
        }
        else
        { $this->error("Config file does not exist: $file"); return; }

        return TRUE;
    }

    /****************
    * LOAD SQL FILE *
    ****************/
    function load_sql_file($sql_file,$parse_sequence = 0)
    {
        global $survey;
        $error = FALSE;
        $query = '';

        $valid_charset = array('utf-8'=>'latin1',
                               'utf-8'=>'utf8',
                               'cp1251'=>'cp1251',
                               'koi8-R'=>'koi8_ru',
                               'big5'=>'big5',
                               'gb2312'=>'gb2312',
                               'shift_jis'=>'sjis');
        $char = strtolower($survey->CONF['charset']);
        $charset = (isset($valid_charset[$char])) ? $valid_charset[$char] : $valid_charset['utf-8'];

        if(!empty($sql_file) && file_exists($sql_file))
        {
            $file = file($sql_file);
            foreach($file as $line)
            {
                if(strlen($line) > 0 && $line{0} != '#' && substr($line,0,2) != '--')
                {
                    $query .= trim($line);
                    if(substr($query,-1) == ";")
                    {
                        $query = preg_replace('/^(ALTER|CREATE|UPDATE) (TEMPORARY )?(TABLE )?(`?)/','\\0' . $survey->CONF['db_tbl_prefix'],$query);
                        $query = preg_replace('/^INSERT INTO (`?)/','\\0' . $survey->CONF['db_tbl_prefix'],$query);
                        $query = preg_replace('/^DROP TABLE IF EXISTS (`?)/','\\0' . $survey->CONF['db_tbl_prefix'],$query);
                        $query = preg_replace('/FROM (`?)([a-z_]+)(`?);$/',"FROM \\1{$survey->CONF['db_tbl_prefix']}\\2\\3;",$query);
                        $query = str_replace('CHARACTER SET latin1',"CHARACTER SET {$charset}",$query);
                        $query = substr($query,0,-1);

                        if($parse_sequence)
                        { $query = $this->parse_sequence($query); }

                        $rs = $survey->db->Execute($query);
                        if($rs === FALSE)
                        {
                            $error = TRUE;
                            echo '<br><br>' . $query . $survey->db->ErrorMsg();
                        }
                        $query = '';
                    }
                    if(!empty($query))
                    { $query .= "\n"; }
                }
            }
        }

        return $error;
    }

    /******************
    * PARSE SEQUENCES *
    ******************/
    function parse_sequence($query)
    {
        global $survey;
        //Look for %tablename_sequence% tags to be replaced
        $query = preg_replace_callback('/%([a-z0-9_]+)_(sequence|lastgenid)%/',array(__CLASS__,'parse_sequence_callback'),$query);
        return $query;
    }

    function parse_sequence_callback($matches)
    {
        global $survey;

        switch($matches[2])
        {
            case 'sequence':
                $retval = $survey->db->GenID($survey->CONF['db_tbl_prefix'].$matches[1].'_sequence');
                $this->sequences[$matches[1]] = $retval;
            break;
            case 'lastgenid':
                if(!empty($this->sequences[$matches[1]]))
                { $retval = $this->sequences[$matches[1]]; }
                else
                { $retval = 0; }
            break;
        }

        return $retval;
    }

    /***************
    * SUCCESS PAGE *
    ***************/
    function success()
    {
        echo "Configuration values have been saved.<br><br>
              Click on the link below to access the Survey System:
              <a href=\"{$this->CONF['html']}/index.php\">"
              .htmlentities($_POST['site_name'])."</a>";
        return;
    }

    /****************
    * ERROR HANDLER *
    ****************/
    function error($msg)
    {
        echo '<table width="50%" align="center" border="1">
              <tr><td>Error</td></tr><tr><td>' . $msg . '</td></tr>
              </table>';

        return;
    }
}

?>