<?php
  /*
   +-----------------------------------------------------------------------+
   | SkyApp, The PHP Application Framework.                                |
   | http://developer.berlios.de/projects/skyapp/                          |
   +-----------------------------------------------------------------------+
   | This source file is released under LGPL license, available through    |
   | the world wide web at http://www.gnu.org/copyleft/lesser.html.        |
   | This library is distributed WITHOUT ANY WARRANTY. Please see the LGPL |
   | for more details.                                                     |
   +-----------------------------------------------------------------------+
   | Authors: Andi Trînculescu <andi@skyweb.ro>                            |
   +-----------------------------------------------------------------------+
   
   $Id: SADebug.php,v 1.2 2004/03/16 23:04:55 trinculescu Exp $
  */

ob_start();

define('ENABLE_DEBUG', true);

class SADebug 
{    

    function trace($var, $file, $line, $exit = false) 
    {
        if (ENABLE_DEBUG) {
            $id = md5(microtime());            
            ?>
            <div class="sa_trace_start"><a href="javascript:;" class="sa_trace_start_link" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV'); " title="click here to view the output of var_dump(<?= gettype($var) ?>)">:: Trace <span style="color: #ff6600"><?= $file ?></span> on line <?= $line ?> ::</a></div>
             <div id="var_<?= $id ?>" title="click to close" class="sa_trace_dump" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV');">
             <pre><?= print_r($var) ?></pre>
             <div class="sa_trace_end">:: Trace end ::</div>
             </div>
<?php
            if ($exit) exit;
            }        
    }
}//end class SADebug


if (ENABLE_DEBUG) {    
?>
    <style>
    .sa_trace_start_link, .sa_trace_start_link:hover
    {
    color: lime;
        text-decoration: none;
    }    
    .sa_trace_start 
    {        
        padding: 2px;
        text-align: center;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
    .sa_trace_dump 
    {
        border: solid;
        border-color: lime;
        padding: 20px;
        position: absolute;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        visibility: hidden;
        color: lime;        
    }
    .sa_trace_end 
    {
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;        
    }    
    </style>    
      
      <script language="JavaScript" type="text/JavaScript">
      <!--
      
      function MM_toggleVisibility(objName) 
      {
          var obj = MM_findObj(objName);
          return (obj.style.visibility == 'visible') ? 'hidden' : 'visible';        
      }
    
    function MM_findObj(n, d) {
        var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
        if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
        for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
        if(!x && d.getElementById) x=d.getElementById(n); return x;
    }
    
    function MM_changeProp(objName,x,theProp,theValue) {
        var obj = MM_findObj(objName);
        if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
            if (theValue == true || theValue == false)
                eval("obj."+theProp+"="+theValue);
            else eval("obj."+theProp+"='"+theValue+"'");
        }
    }
    -->
    </script>      
<?php
}
