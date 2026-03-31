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
//Start Session
//session_start();
//Set Error Reporting Level to not
//show notices or warnings
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//error_reporting(0);
//Turn off runtime escaping of quotes
set_magic_quotes_runtime(0);
//Define CONSTANTS
define('BY_AID',1);
define('BY_QID',2);
//Privileges
define('ADMIN_PRIV',0);
define('CREATE_PRIV',1);
define('TAKE_PRIV',2);
define('RESULTS_PRIV',3);
define('EDIT_PRIV',4);
//Message types
define('MSGTYPE_NOTICE',1);
define('MSGTYPE_ERROR',2);
//Access control options
define('AC_NONE',0);
define('AC_COOKIE',1);
define('AC_IP',2);
define('AC_USERNAMEPASSWORD',3);
define('AC_INVITATION',4);
//Message for already completed survey
define('ALREADY_COMPLETED',1);
//Answer types
define('ANSWER_TYPE_T','T');    //Textarea
define('ANSWER_TYPE_S','S');    //Textbox (sentence)
define('ANSWER_TYPE_N','N');    //None
define('ANSWER_TYPE_MS','MS');  //Multiple choice, single answer
define('ANSWER_TYPE_MM','MM');  //Multiple choice, multiple answer
//Orientation Types
define('ANSWER_ORIENTATION_H','H'); //Horizontal
define('ANSWER_ORIENTATION_V','V'); //Vertical
define('ANSWER_ORIENTATION_D','D'); //Dropdown
define('ANSWER_ORIENTATION_M','M'); //Matrix
//Form Elements
define('FORM_CHECKED',' checked');
define('FORM_SELECTED',' selected');
//Lookback Settings
define('LOOKBACK_TEXT','$lookback');
define('LOOKBACK_START_DELIMITER','{');
define('LOOKBACK_END_DELIMITER','}');
//Export CSV Settings
define('EXPORT_CSV_TEXT',1);
define('EXPORT_CSV_NUMERIC',2);
define('MULTI_ANSWER_SEPERATOR',', ');
class UCCASS_Main
{
    function UCCASS_Main()
    { $this->load_configuration(); }

    /*********************
    * LOAD CONFIGURATION *
    *********************/
    function load_configuration()
    {
        //Ensure install.php file has be removed
        if(!isset($_REQUEST['config_submit']) && file_exists('install.php'))
        { $this->error("WARNING: install.php file still exists. Survey System will not run with this file present. Click <a href=\"install.php\">here</a> to run the installation program or move/rename the install.php file so that the installation program can not be re-run."); return; }

        $ini_file = 'survey.ini.php';
		//$ini_file = '../../encuesta2/survey.ini.php';
        //Load values from .ini. file
        if(file_exists($ini_file))
        {
            $this->CONF = @parse_ini_file($ini_file);
            if(count($this->CONF) == 0)
            { $this->error("Error parsing {$ini_file} file"); return; }
        }
        else
        { $this->error("Cannot find {$ini_file}"); return; }


        //Version of Survey System
        $this->CONF['version'] = 'v1.8.1';

        //Default path to Smarty
        if(!isset($this->CONF['smarty_path']) || $this->CONF['smarty_path'] == '')
        { $this->CONF['smarty_path'] = $this->CONF['path'] . '/smarty'; }

        //Default path to ADOdb
        if(!isset($this->CONF['adodb_path']) || $this->CONF['adodb_path'] == '')
        { $this->CONF['adodb_path'] = $this->CONF['path'] . '/ADOdb'; }

        //Load ADOdb files
        $adodb_file = $this->CONF['adodb_path'] . '/adodb.inc.php';
        if(file_exists($adodb_file))
        { require($this->CONF['adodb_path'] . '/adodb.inc.php'); }
        else
        { $this->error("Cannot find file: $adodb_file"); return; }

        //Load Smarty Files
        $smarty_file = $this->CONF['smarty_path'] . '/Smarty.class.php';
        if(file_exists($smarty_file))
        { require($this->CONF['smarty_path'] . '/Smarty.class.php'); }
        else
        { $this->error("Cannot find file: $smarty_file"); return; }

        //Create Smarty object and set
        //paths within object
        $this->smarty = new Smarty;
        $this->smarty->template_dir    =  $this->CONF['path'] . '/templates';                    // name of directory for templates
        $this->smarty->compile_dir     =  $this->CONF['smarty_path'] . '/templates_c';     // name of directory for compiled templates
        $this->smarty->config_dir      =  $this->CONF['smarty_path'] . '/configs';         // directory where config files are located
        $this->smarty->plugins_dir     =  array($this->CONF['smarty_path'] . '/plugins');  // plugin directories

        if(!$this->set_template_paths($this->CONF['default_template']))
        { $this->error("WARNING: Cannot find default template path. Expecting: {$this->CONF['template_path']}"); return; }

        //Ensure templates_c directory is writable
        if(!is_writable($this->smarty->compile_dir))
        { $this->error("WARNING: Compiled template directory is not writable ({$this->smarty->compile_dir}). Please refer to the installation document for instructions."); return; }

        //If SAFE_MODE is ON in PHP, turn off subdirectory use for Smarty
        if(ini_get('safe_mode'))
        { $this->smarty->use_sub_dirs = FALSE; }

        //Establish Connection to database
        $this->db = NewADOConnection($this->CONF['db_type']);
        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
        $conn = $this->db->Connect($this->CONF['db_host'],$this->CONF['db_user'],$this->CONF['db_password'],$this->CONF['db_database']);
        if(!$conn)
        { $this->error('Error connecting to database: '. $this->db->ErrorMsg()); return; }

        $this->CONF['orientation'] = array('Vertical','Horizontal','Dropdown','Matrix');
        $this->CONF['text_modes'] = array('Text Only','Limited HTML','Full HTML');
        $this->CONF['dependency_modes'] = array('Hide','Require','Show');

        //Validate and set default survey and user text modes
        $this->CONF['survey_text_mode'] = (int)$this->CONF['survey_text_mode'];
        if($this->CONF['survey_text_mode'] < 0 || $this->CONF['survey_text_mode'] > 2)
        { $this->CONF['survey_text_mode'] = 0; }

        $this->CONF['user_text_mode'] = (int)$this->CONF['user_text_mode'];
        if($this->CONF['user_text_mode'] < 0 || $this->CONF['user_text_mode'] > 2)
        { $this->CONF['user_text_mode'] = 0; }

        if(strcasecmp($this->CONF['create_access'],'public')==0)
        { $this->CONF['create_access'] = 0; }
        else
        { $this->CONF['create_access'] = 1; }

        if(isset($_SESSION['priv'][0][ADMIN_PRIV]))
        { $this->CONF['show_admin_link'] = 1; }

        //Create SafeString object for escaping user text
        require($this->CONF['path'] . '/classes/safestring.class.php');
        $this->SfStr = new SafeString($this->CONF['db_type'],$this->CONF['charset']);
        $this->SfStr->setHTML($this->CONF['html']);
        $this->SfStr->setImagesHTML($this->CONF['images_html']);

        //Assign configuration values to template
        $this->smarty->assign_by_ref('conf',$this->CONF);

        return;
    }

    /*********************
    * SET TEMPLATE PATHS *
    *********************/
    function set_template_paths($template)
    {
        $this->template = $template;

        $this->CONF['template_path'] = $this->CONF['path'] . '/templates/' . $template;
        if(!file_exists($this->CONF['template_path']))
        { return(FALSE); }

        $this->CONF['template_html'] = $this->CONF['html'] . '/templates/' . $template;

        if(file_exists($this->CONF['template_path'] . '/images'))
        {
            $this->CONF['images_html'] = $this->CONF['html'] . '/templates/' . $template . '/images';
            $this->CONF['images_path'] = $this->CONF['path'] . '/templates/' . $template . '/images';
        }
        else
        {
            $this->CONF['images_html'] = $this->CONF['html'] . '/templates/' . $template;
            $this->CONF['images_path'] = $this->CONF['path'] . '/templates/' . $template;
        }

        return(TRUE);
    }

    /****************
    * ERROR MESSAGE *
    ****************/
    function error($msg)
    {
        $this->error_occurred = 1;

        if(is_object($this->smarty))
        {
            $this->smarty->assign("error",$msg);
            echo $this->smarty->fetch($this->template.'/error.tpl');
        }
        else
        { echo "Error: $msg"; exit(); }
    }

    /**************
    * SET MESSAGE *
    **************/
    function setMessage($title,$text,$type=MSGTYPE_NOTICE)
    {
        if(!empty($title) && !empty($text))
        {
            $_SESSION['message']['title'] = $title;
            $_SESSION['message']['text'] = $text;
            $_SESSION['message']['type'] = $type;

            if(!empty($this->_messageredirect))
            {
                session_write_close();
                header("Location: {$this->_messageredirect}");
                exit();
            }
        }
    }

    /*******************************
    * SET MESSAGE REDIRECTION PAGE *
    *******************************/
    function setMessageRedirect($page)
    {
        if(strpos($page,$this->CONF['html'])===FALSE)
        {
            if($page{0} != '/')
            { $page = '/' . $page; }
            $page = $this->CONF['html'] . $page;
        }
        $this->_messageredirect = $page;
    }


    /***************
    * SHOW MESSAGE *
    ***************/
    function showMessage()
    {
        $retval = '';
        if(!empty($_SESSION['message']['title']) && !empty($_SESSION['message']['text']))
        {
            switch($_SESSION['message']['type'])
            {
                case MSGTYPE_ERROR:
                    $this->smarty->assign_by_ref('error',$_SESSION['message']['text']);
                    $retval = $this->smarty->fetch($this->template.'/error.tpl');
                break;
                default:
                    $this->smarty->assign_by_ref('message',$_SESSION['message']);
                    $retval = $this->smarty->fetch($this->template.'/message.tpl');
                break;
            }
            unset($_SESSION['message']);
        }
        return $retval;
    }

    /********************
    * SQL Query Wrapper *
    ********************/
    function query($sql,$label = '',$report_error=1)
    {
        //Execute query
        $rs = $this->db->Execute($sql);

        //If error occurs and "report_error"
        //is set, show error
        if($rs === FALSE && $report_error)
        { $this->error($label . ' -- ' . $this->db->ErrorMsg()); }

        return $rs;
    }



    /**************
    * PRINT ARRAY *
    **************/
    function print_array($ar)
    {
        echo '<pre>'.print_r($ar,TRUE).'</pre>';
    }

    /*********
    * HEADER *
    *********/
    function com_header($title='')
    {
        //Assign title of page to template
        //and return header template
        if(empty($title))
        { $values['title'] = $this->CONF['site_name']; }
        else
        { $values['title'] = $this->SfStr->getSafeString($title,SAFE_STRING_TEXT); }

        $this->smarty->assign_by_ref('values',$values);
        return $this->smarty->fetch($this->template.'/main_header.tpl') . $this->showMessage();
    }

    /*********
    * FOOTER *
    *********/
    function com_footer()
    {
        //Close connection to database
        $this->db->Close();

        //Return footer template
        return $this->smarty->fetch($this->template.'/main_footer.tpl');
    }

    /*************************
    * RETRIEVE ANSWER VALUES *
    *************************/
    function get_answer_values($id,$by=BY_AID,$mode=SAFE_STRING_TEXT)
    {
        $retval = FALSE;
        static $answer_values;

        $id = (int)$id;
        $sid = (int)$_REQUEST['sid'];

        if(isset($answer_values[$id]))
        { $retval = $answer_values[$id]; }
        else
        {
            if($by==BY_QID)
            {
                $query = "SELECT av.avid, av.value, av.numeric_value, av.image FROM {$this->CONF['db_tbl_prefix']}answer_values av,
                          {$this->CONF['db_tbl_prefix']}questions q WHERE q.aid = av.aid AND q.qid = $id AND q.sid = $sid
                          ORDER BY av.avid ASC";
            }
            else
            {
                $query = "SELECT av.avid, av.value, av.numeric_value, av.image FROM {$this->CONF['db_tbl_prefix']}answer_values av
                          WHERE aid = $id ORDER BY avid ASC";
            }

            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { return $this->error("Error getting answer values: " . $this->db->ErrorMsg()); }

            while($r = $rs->FetchRow($rs))
            {
                $retval['avid'][] = $r['avid'];
                $retval['value'][] = $this->SfStr->getSafeString($r['value'],$mode);
                $retval['numeric_value'][] = $r['numeric_value'];
                $retval['image'][] = $r['image'];
                $retval[$r['avid']] = $r['value'];
            }

            $answer_values[$id] = $retval;
        }

        return $retval;
    }

    /***************************
    * DISPLAY POSSIBLE ANSWERS *
    ***************************/
    function display_answers($sid)
    {
        $old_name = '';
        $x = 0;
        $sid = (int)$sid;

        $rs = $this->db->Execute("SELECT at.name, at.type, at.label, av.value, s.survey_text_mode
                                  FROM {$this->CONF['db_tbl_prefix']}answer_types at
                                  LEFT JOIN {$this->CONF['db_tbl_prefix']}answer_values av ON at.aid = av.aid,
                                  {$this->CONF['db_tbl_prefix']}surveys s
                                  WHERE s.sid = $sid AND s.sid = at.sid
                                  ORDER BY name, av.avid ASC");

        if($rs === FALSE) { die($this->db->ErrorMsg()); }
        while($r = $rs->FetchRow())
        {
            if($old_name != $r['name'])
            {
                if(!empty($old_name))
                { $x++; }

                $answers[$x]['name'] = $this->SfStr->getSafeString($r['name'],$r['survey_text_mode']);
                $answers[$x]['type'] = $r['type'];
                $answers[$x]['value'][] = $this->SfStr->getSafeString($r['value'],$r['survey_text_mode']);

                if(empty($r['label']))
                { $answers[$x]['label'] = '&nbsp;'; }
                else
                { $answers[$x]['label'] = $this->SfStr->getSafeString($r['label'],$r['survey_text_mode']); }


                $old_name = $r['name'];
            }
            else
            { $answers[$x]['value'][] = $this->SfStr->getSafeString($r['value'],$r['survey_text_mode']); }
        }

        $this->smarty->assign_by_ref("answers",$answers);

        $retval = $this->smarty->fetch($this->template.'/display_answers.tpl');

        return $retval;
    }

    /*****************
    * VALIDATE LOGIN *
    *****************/
    function _CheckLogin($sid=0, $priv=EDIT_PRIV,$redirect_page='')
    {
        $retval = FALSE;

        $sid = (int)$sid;
        $priv = (int)$priv;

        //Checks to see if user is already logged in with required
        //privledge for specific survey (or zero for no survey)
        if((isset($_SESSION['priv'][0][ADMIN_PRIV]) && $_SESSION['priv'][0][ADMIN_PRIV]==1)
            || (isset($_SESSION['priv'][$sid][$priv]) && $_SESSION['priv'][$sid][$priv]==1))
        { $retval = TRUE; }
        else
        {
            $retval = $this->_checkUsernamePassword($sid,$priv);

            if($retval)
            {
                if(!empty($redirect_page))
                {
                    session_write_close();
                    header("Location: {$this->CONF['html']}/{$redirect_page}");
                    exit();
                }
            }
        }

        return $retval;
    }

    function _CheckAccess($sid=0,$priv=TAKE_PRIV,$redirect_page='')
    {
        $retval = FALSE;

        $sid = (int)$sid;
        $priv = (int)$priv;

        //Checks to see if user is already logged in with required
        //privledge for specific survey (or zero for no survey)
        if((isset($_SESSION['priv'][0][ADMIN_PRIV]) && $_SESSION['priv'][0][ADMIN_PRIV]==1)
            || (isset($_SESSION['priv'][$sid][$priv]) && $_SESSION['priv'][$sid][$priv]==1))
        {
            if($sid != 0 && isset($_SESSION['priv'][0]['uid']))
            { $_SESSION['priv'][$sid]['uid'] = $_SESSION['priv'][0]['uid']; }
            $retval = TRUE;
        }
        else
        {
            $query = "SELECT access_control, public_results, survey_limit_times, survey_limit_seconds FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error getting access control setting: ' . $this->db->ErrorMsg()); }
            elseif($r = $rs->FetchRow($rs))
            {
                $_SESSION['access_control'][$sid] = $r['access_control'];

                if($priv == RESULTS_PRIV && $r['public_results'])
                {
                    $retval = TRUE;
                    $redirect_page = '';
                }
                elseif($priv == RESULTS_PRIV && ($r['access_control'] == AC_IP || $r['access_control'] == AC_COOKIE || $r['access_control'] == AC_NONE))
                { $retval = $this->_checkUsernamePassword($sid,$priv); }
                else
                {
                    switch($r['access_control'])
                    {
                        case AC_USERNAMEPASSWORD:
                            $retval = $this->_checkUsernamePassword($sid,$priv,$r['survey_limit_times'],$r['survey_limit_seconds']);
                        break;
                        case AC_INVITATION:
                            $retval = $this->_checkInvitation($sid,$priv,$r['survey_limit_times'],$r['survey_limit_seconds']);
                        break;
                        case AC_IP:
                            $retval = $this->_checkIP($sid,$priv,$r['survey_limit_times'],$r['survey_limit_seconds']);
                            $redirect_page = '';
                        break;
                        case AC_COOKIE:
                            $retval = $this->_checkCookie($sid,$priv,$r['survey_limit_times'],$r['survey_limit_seconds']);
                            $redirect_page = '';
                        break;
                        case AC_NONE:
                        default:
                            $retval = TRUE;
                            $redirect_page = '';
                        break;
                    }
                }
            }

            if($retval === TRUE)
            {
                if(!empty($redirect_page))
                {
                    session_write_close();
                    header("Location: {$this->CONF['html']}/{$redirect_page}");
                    exit();
                }
            }
        }

        return $retval;
    }

    function _checkUsernamePassword($sid,$priv,$numallowed=0,$numseconds=0)
    {
        $retval = FALSE;

        if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
        {
            if($sid != 0)
            { $sid_check = " (sid = $sid OR sid = 0) "; }
            else
            { $sid_check = " sid = $sid "; }

            $input['username'] = $this->SfStr->getSafeString($_REQUEST['username'],SAFE_STRING_DB);
            $input['password'] = $this->SfStr->getSafeString($_REQUEST['password'],SAFE_STRING_DB);
            $query = "SELECT password, uid, name, email, admin_priv, create_priv, take_priv, results_priv, edit_priv FROM
                      {$this->CONF['db_tbl_prefix']}users WHERE {$sid_check} AND username = {$input['username']}
                      and password={$input['password']}";

            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error retrieving user permissions: ' . $this->db->ErrorMsg()); return FALSE; }

            if($r = $rs->FetchRow($rs))
            {
                //Case sensitive compare done in PHP
                //to be compatible across different databases
                if(!strcmp($_REQUEST['password'],$r['password']))
                {
                    if($r['admin_priv'])
                    {
                        $_SESSION['priv'][0] = array(ADMIN_PRIV => 1, CREATE_PRIV => 1);
                        if($sid != 0)
                        { $_SESSION['priv'][$sid] = array(TAKE_PRIV => 1, EDIT_PRIV => 1, RESULTS_PRIV => 1); }
                        $retval = TRUE;
                    }
                    elseif($priv == TAKE_PRIV && $numallowed)
                    {
                        if($numallowed && $numseconds==0)
                        { $lim = 0; }
                        else
                        { $lim = time() - $numseconds; }

                        $query = "SELECT COUNT(uid) AS count_uid FROM {$this->CONF['db_tbl_prefix']}completed_surveys WHERE uid={$r['uid']} AND completed > $lim GROUP BY uid";
                        $rs = $this->db->Execute($query);
                        if($rs === FALSE)
                        { $this->error('Error getting count of completed surveys: ' . $this->db->ErrorMsg()); return FALSE; }
                        elseif($r2 = $rs->FetchRow($rs))
                        {
                            if($r2['count_uid'] < $numallowed)
                            { $retval = TRUE; }
                            else
                            { $retval = ALREADY_COMPLETED; }
                        }
                        else
                        { $retval = TRUE; }

                        if($retval === TRUE)
                        {
                            $_SESSION['priv'][$sid] = array(TAKE_PRIV => $r['take_priv'], EDIT_PRIV => $r['edit_priv'],
                                                            RESULTS_PRIV => $r['results_priv']);
                        }
                    }
                    else
                    {
                        $_SESSION['priv'][$sid] = array(TAKE_PRIV => $r['take_priv'], EDIT_PRIV => $r['edit_priv'],
                                                        RESULTS_PRIV => $r['results_priv'], CREATE_PRIV => $r['create_priv']);

                        if(isset($_SESSION['priv'][$sid][$priv]) && $_SESSION['priv'][$sid][$priv] == 1)
                        { $retval = TRUE; }
                    }

                    $_SESSION['priv'][$sid]['name'] = $r['name'];
                    $_SESSION['priv'][$sid]['email'] = $r['email'];
                    $_SESSION['priv'][$sid]['uid'] = $r['uid'];
                }
            }
        }

        return $retval;
    }

    function _checkInvitation($sid,$priv,$numallowed=0,$numseconds=0)
    {
        $sid = (int)$sid;
        $retval = FALSE;

        if(isset($_REQUEST['invite_code']))
        {
            $input['invite_code'] = $this->SfStr->getSafeString($_REQUEST['invite_code'],SAFE_STRING_DB);
            $query = "SELECT uid, name, email, take_priv, results_priv FROM {$this->CONF['db_tbl_prefix']}users WHERE sid=$sid AND invite_code = {$input['invite_code']}";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error getting permissions while checking invitation code: ' . $this->db->ErrorMsg()); return FALSE; }
            elseif($r = $rs->FetchRow($rs))
            {
                if($priv == TAKE_PRIV && $numallowed)
                {
                    if($numallowed && $numseconds==0)
                    { $lim = 0; }
                    else
                    { $lim = time() - $numseconds; }

                    $query = "SELECT COUNT(uid) AS count_uid FROM {$this->CONF['db_tbl_prefix']}completed_surveys WHERE uid={$r['uid']} AND completed > $lim GROUP BY uid";
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $this->error('Error getting count of completed surveys: ' . $this->db->ErrorMsg()); return FALSE; }
                    elseif($r2 = $rs->FetchRow($rs))
                    {
                        if($r2['count_uid'] < $numallowed)
                        { $retval = TRUE; }
                        else
                        { $retval = ALREADY_COMPLETED; }
                    }
                    else
                    { $retval = TRUE; }
                }
                else
                {
                    $_SESSION['priv'][$sid][TAKE_PRIV] = $r['take_priv'];
                    $_SESSION['priv'][$sid][RESULTS_PRIV] = $r['results_priv'];

                    if($_SESSION['priv'][$sid][$priv] == 1)
                    { $retval = TRUE; }
                }

                $_SESSION['priv'][$sid]['name'] = $r['name'];
                $_SESSION['priv'][$sid]['email'] = $r['email'];
                $_SESSION['priv'][$sid]['uid'] = $r['uid'];

                if($retval === TRUE)
                { $_SESSION['priv'][$sid][TAKE_PRIV] = 1; }
            }
        }

        return $retval;
    }

    function _checkCookie($sid,$priv,$numallowed=0,$numseconds=0)
    {
        $retval = FALSE;
        $name = 'uccass'.md5($sid);

        if(isset($_COOKIE[$name]))
        {
            $now = time();
            $times = unserialize($_COOKIE[$name]);
            if(is_array($times))
            {
                if(count($times) < $numallowed)
                { $retval = TRUE; }
                elseif($numallowed && $numseconds)
                {
                    rsort($times);
                    $times = array_slice($times,0,$numallowed);

                    if($numseconds && ($times[$numallowed-1] < $now - $numseconds))
                    { $retval = TRUE; }
                    $times = serialize($times);
                    setcookie($name,$times,$now+31557600);
                }
            }
            else
            { $retval = FALSE; }
        }
        else
        { $retval = TRUE; }

        return $retval;
    }

    function _checkIP($sid,$priv,$numallowed=0,$numseconds=0)
    {
        $retval = FALSE;
        $ip = $this->SfStr->getSafeString($_SERVER['REMOTE_ADDR'],SAFE_STRING_DB);
        $criteria = '';

        if($priv == TAKE_PRIV && $numallowed)
        {
            if($numallowed && $numseconds == 0)
            { $lim = 0; }
            else
            { $lim = time() - $numseconds; }
            $criteria = " AND completed > $lim ";
        }

        $query = "SELECT COUNT(sid) as count_sid FROM {$this->CONF['db_tbl_prefix']}ip_track WHERE ip = $ip AND sid = $sid $criteria GROUP BY sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Unable to check for ip address: ' . $this->db->ErrorMsg()); }
        elseif($r = $rs->FetchRow($rs))
        {
            if($r['count_sid'] < $numallowed)
            { $retval = TRUE; }
            else
            { $retval = ALREADY_COMPLETED; }
        }
        else
        { $retval = TRUE; }

        return $retval;
    }

    function _hasPriv($priv,$sid=0)
    {
        if(isset($_SESSION['priv'][$sid][$priv]) && $_SESSION['priv'][$sid][$priv]==1)
        { return TRUE; }
        else
        { return FALSE; }
    }

    function _getAccessControl($sid)
    {
        $retval = FALSE;
        if(isset($_SESSION['access_control'][$sid]))
        { $retval = $_SESSION['access_control'][$sid]; }
        else
        {
            $query = "SELECT access_control FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Unable to get access control setting for survey: ' . $this->db->ErrorMsg()); }
            elseif($r = $rs->FetchRow($rs))
            { $retval = $r['access_control']; }
        }
        return $retval;
    }

    function showLogin($page, $hidden)
    {
        //If validation fails, but username data was present,
        //set an error message and show login form again.
        if(isset($_REQUEST['username']))
        {
            $data['message'] = 'Incorrect Username and/or Password';
            $data['username'] = $this->SfStr->getSafeString($_REQUEST['username'],SAFE_STRING_TEXT);
        }
        //Set required data for login page
        //and show login form
        $data['page'] = $page;
        if(is_array($hidden))
        {
            foreach($hidden as $key=>$val)
            {
                $data['hiddenkey'][] = $key;
                $data['hiddenval'][] = $val;
            }
        }
        $this->smarty->assign_by_ref('data',$data);
        return $this->smarty->Fetch($this->template.'/login.tpl');
    }

    function showInvite($page, $hidden)
    {
        if(isset($_REQUEST['invite_code']))
        {
            $data['message'] = 'Incorrect invitation code.';
            $data['invite_code'] = $this->SfStr->getSafeString($_REQUEST['invite_code'],SAFE_STRING_TEXT);
        }

        $data['page'] = $page;
        if(is_array($hidden))
        {
            foreach($hidden as $key=>$val)
            {
                $data['hiddenkey'][] = $key;
                $data['hiddenval'][] = $val;
            }
        }

        $this->smarty->assign_by_ref('data',$data);
        return $this->smarty->Fetch($this->template.'/invite_code.tpl');
    }

    function setError($error)
    {
        if(is_array($error))
        {
            foreach($error as $msg)
            { $this->setError($msg); }
        }
        $this->error[] = $error;
    }

    function clearError()
    { $this->error = array(); }

    function isError()
    { return count($this->error); }
}
?>