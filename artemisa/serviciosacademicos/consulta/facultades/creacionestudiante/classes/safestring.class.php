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

/*======================================================
  Class Safe String

  This class prepares strings for display on a web page,
  display within form elements and insertion into a
  database based upon a chosen mode
======================================================
  Class Methods

  bool SafeString(string dbtype)
   - Constructor: Initializes variables
   - Created ADOdb object with database type matching dbtype
  string getSafeString(string str[, string mode])
   - Returns escaped str based upon mode
   - Default mode is SAFE_STRING_TEXT
  string _safe_string_callback(array matches)
   - Private method used by getSafeString
     to produce allowed HTML in SAFE_STRING_LIMHTML mode
  void setHTML(string path)
   - Sets full HTTP path to be used as a replacement
     for {$html} tags in SAFE_STRING_LIMHTML and
     SAFE_STRING_FULLHTML modes
  void setImagesHTML(string path)
   - Sets full HTTP path to be used as a replacement
     for {$images_html} tags in SAFE_STRING_LIMHTML
     and SAFE_STRING_FULLHTML modes
======================================================
  Mode Definitions:

  SAFE_STRING_TEXT: prepares text to be safely shown
  in HTML pages or within form elements. Escapes all
  HTML elements within text. This is the DEFAULT mode.

  SAFE_STRING_LIMHTML: prepares text to be shown
  safely in HTML pages only. Allows the following tag
  and attribute combinations
  -----
  <b> - No attributes
  <i> - No attributes
  <u> - No attributes
  <div> - class, style and id attributes
  <span> - class, style and id attributes
  <a> - class, style, id, href, target
  <img> - class, style, id, src, width, height, alt, border attributes
  -----
  Replaces {$html} and {$images_html} within strings
  if those values have been set

  SAFE_STRING_FULLHTML: only replaces {$html}
  and {$images_html} within the string. NO ESCAPING
  is done.
  WARNING: Strings escaped with this mode should
  only be shown on HTML pages IF they come from
  a trusted source otherwise security holes could
  be introduced

  SAFE_STRING_DB: prepares the string for insertion
  into a database. The string is unescaped using stripslashes()
  if magic_quotes_gpc is enabled. The string is escaped
  using the ADOdb Quote-> method

  SAFE_STRING_ESC: prepares the string for insertion
  into the database using the ADOdb Quote-> method. The
  string is escaped regardless of the magic_quotes_gpc
  setting
======================================================*/

define('SAFE_STRING_TEXT',0);
define('SAFE_STRING_LIMHTML',1);
define('SAFE_STRING_FULLHTML',2);
define('SAFE_STRING_DB',3);
define('SAFE_STRING_ESC',4);

class SafeString
{
    var $html;
    var $images_html;
    var $dbtype;
    var $charset;

    function SafeString($dbtype='mysql',$charset='UTF-8')
    {
        $this->html = '';
        $this->images_html = '';
        $this->charset = $charset;
        $this->db = NewADOConnection($dbtype);

        return TRUE;
    }

    /**************
    * Safe String *
    **************/
    //Converts all special characters, including single
    //and double quotes, to HTML entities. Returned string
    //is safe to insert into databases or display to user
    function getSafeString($str,$mode=SAFE_STRING_TEXT)
    {
        if(is_array($str))
        {
            foreach($str as $key => $value)
            { $str[$key] = $this->getSafeString($value,$mode); }
        }
        else
        {
            switch($mode)
            {
                case SAFE_STRING_DB:
                    if(get_magic_quotes_gpc())
                    { $str = stripslashes($str); }

                    $str = $this->db->Quote($str);
                break;

                case SAFE_STRING_ESC:
                    $str = $this->db->Quote($str);
                break;

                case SAFE_STRING_LIMHTML:
                    $str = str_replace(array('{$images_html}','{$html}'),array($this->images_html,$this->html),$str);
                    $str = htmlentities($str,ENT_QUOTES,'utf-8');
                    $str = preg_replace('#&lt;b&gt;(.*?)&lt;/b&gt;#i','<b>\1</b>',$str);
                    $str = preg_replace('#&lt;i&gt;(.*?)&lt;/i&gt;#i','<i>\1</i>',$str);
                    $str = preg_replace('#&lt;u&gt;(.*?)&lt;/u&gt;#i','<u>\1</u>',$str);
                    $str = preg_replace_callback('#&lt;(div)(.*?)&gt;(.*?)&lt;/div&gt;#i',array(&$this,'_safe_string_callback'),$str);
                    $str = preg_replace_callback('#&lt;(span)(.*?)&gt;(.*?)&lt;/span&gt;#i',array(&$this,'_safe_string_callback'),$str);
                    $str = preg_replace_callback('#&lt;(a)(.*?)&gt;(.*?)&lt;/a&gt;#i',array(&$this,'_safe_string_callback'),$str);
                    $str = preg_replace_callback('#&lt;(img)(.*?)&gt;#i',array(&$this,'_safe_string_callback'),$str);
                break;

                case SAFE_STRING_FULLHTML:
                    $str = str_replace(array('{$images_html}','{$html}'),array($this->images_html,$this->html),$str);
                break;

                case SAFE_STRING_TEXT:
                default:
                    $str = htmlentities($str,ENT_QUOTES,'utf-8');
                break;
            }
        }

        return $str;
    }

    //Function to validate/sanitize limited HTML strings
    function _safe_string_callback($matches)
    {
        $attrib = array('div' => 'class,style,id',
                   'span' => 'class,style,id',
                   'img' => 'border,id,class,style,src,height,width,alt',
                   'a' => 'id,class,style,href,target');

        if(isset($matches[2]) && !empty($matches[2]))
        {
            $allowed_attrib = str_replace(array(',',' '),array('|',''),$attrib[$matches[1]]);
            $matches[2] = str_replace('=','&#61;',$matches[2]);
            $pattern = "/({$allowed_attrib})&#61;(&quot;|&#039;)(.*)(&quot;|&#039;)/iU";
            $matches[2] = preg_replace($pattern,'\1="\3"',$matches[2]);
        }

        switch($matches[1])
        {
            case 'img':
                $retval = "<{$matches[1]}{$matches[2]}>";
            break;

            default:
                $retval = "<{$matches[1]}{$matches[2]}>{$matches[3]}</{$matches[1]}>";
            break;
        }

        return $retval;
    }

    function setHTML($str)
    { $this->html = $str; }

    function setImagesHTML($str)
    { $this->images_html = $str; }
}

?>