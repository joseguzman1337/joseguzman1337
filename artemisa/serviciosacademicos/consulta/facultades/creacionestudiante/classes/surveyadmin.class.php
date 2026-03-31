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

class UCCASS_SurveyAdmin extends UCCASS_Main
{
    function UCCASS_SurveyAdmin()
    { $this->load_configuration(); }

    /*************
    * ADMIN PAGE *
    *************/
    function admin()
    {
        $data = array();
        $template = 'admin.tpl';

        $admin_priv = $this->_CheckLogin(0,ADMIN_PRIV,'admin.php');

        if(!$admin_priv)
        {
            $template = 'login.tpl';
            if(isset($_REQUEST['password']))
            {
                $data['message'] = 'Incorrect Username and/or Password';
                $data['username'] = $this->SfStr->getSafeString($_REQUEST['username'],SAFE_STRING_TEXT,1);
            }
            $data['page'] = 'admin.php';
        }
        else
        {
            //Process list of users upon submit
            //Return value is list of bad uids
            if(isset($_REQUEST['update_admin_users']))
            { $this->update_admin_users(); }

            if(isset($_SESSION['update_admin_users']['erruid']))
            {
                $erruid = $_SESSION['update_admin_users']['erruid'];
                unset($_SESSION['update_admin_users']['erruid']);
            }

            $survey = array();

            $query = "SELECT sid, name FROM {$this->CONF['db_tbl_prefix']}surveys ORDER BY name ASC";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error("Error selecting surveys: " . $this->db->ErrorMsg()); }
            while($r = $rs->FetchRow())
            {
                $data['survey']['sid'][] = $r['sid'];
                $data['survey']['name'][] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
            }

            //Select users with Admin and Create privileges
            $query = "SELECT uid, name, email, username, password, admin_priv, create_priv FROM
                      {$this->CONF['db_tbl_prefix']}users WHERE sid=0 ORDER BY username ASC";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Unable to get user permissions: ' . $this->db->ErrorMsg()); return; }
            $x = 0;
            while($r = $rs->FetchRow($rs))
            {
                $data['users'][$x]['uid'] = $r['uid'];
                $data['users'][$x]['name'] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
                $data['users'][$x]['email'] = $this->SfStr->getSafeString($r['email'],SAFE_STRING_TEXT);
                $data['users'][$x]['username'] = $this->SfStr->getSafeString($r['username'],SAFE_STRING_TEXT);
                $data['users'][$x]['password'] = $this->SfStr->getSafeString($r['password'],SAFE_STRING_TEXT);
                if($r['admin_priv'])
                { $data['users'][$x]['admin_selected'] = ' checked'; }
                if($r['create_priv'])
                { $data['users'][$x]['create_selected'] = ' checked'; }
                if(isset($erruid[$r['uid']]))
                { $data['users'][$x]['erruid'] = 1; }

                $x++;
            }

            for($y=0;$y<5;$y++)
            { $data['users'][$x++]['uid'] ='x'.$y; }
        }

        $this->smarty->assign_by_ref('data',$data);
        $retval = $this->smarty->Fetch($this->template.'/'.$template);

        return $retval;
    }

    /*********************
    * UPDATE ADMIN USERS *
    *********************/
    function update_admin_users()
    {
        $retval = FALSE;
        $errmsg = array();
        $erruid = array();

        if(!isset($_REQUEST['admin_priv']))
        { $this->error('Must have at least one administrator.'); return; }
        elseif(isset($_REQUEST['delete']))
        {
            $numadmins = array_diff(array_keys($_REQUEST['admin_priv']),array_keys($_REQUEST['delete']));
            if(is_array($numadmins) && count($numadmins) == 0)
            { $this->error('Cannot delete all admin users'); return; }

            foreach($_REQUEST['delete'] as $uid => $val)
            {
                if($uid{0}!='x')
                {
                    $rs = $this->delete_user($uid);
                    if($rs === FALSE)
                    {
                        $username = $this->SfStr->getSafeString($_REQUEST['username'][$uid],SAFE_STRING_TEXT);
                        $errmsg[0] = "Cannot delete $username: " . $this->db->ErrorMsg();
                        $erruid[] = $uid;
                    }
                }
                else
                { unset($_REQUEST['name'][$uid]); }
            }
        }

        foreach($_REQUEST['name'] as $uid => $name)
        {
            if(empty($name) && empty($_REQUEST['email'][$uid]) && empty($_REQUEST['username'][$uid]) && empty($_REQUEST['password'][$uid]))
            {
                if($uid{0}!='x')
                {
                    $rs = $this->delete_user($uid);
                    if($rs === FALSE)
                    {
                        $errmsg[0] = "Cannot delete user with uid: $uid. Reason: " . $this->db->ErrorMsg();
                        $erruid[$uid] = 1;
                    }
                }
            }
            else
            {
                $input = array();

                $input['uid'] = (int)$uid;
                $input['name'] = $this->SfStr->getSafeString($name,SAFE_STRING_DB);
                $input['email'] = $this->SfStr->getSafeString($_REQUEST['email'][$uid],SAFE_STRING_DB);

                if(!empty($_REQUEST['username'][$uid]))
                {
                    $chkuid = $this->check_username(0, $_REQUEST['username'][$uid]);
                    if($chkuid && $chkuid != $input['uid'])
                    {
                        $username = $this->SfStr->getSafeString($_REQUEST['username'][$uid],SAFE_STRING_TEXT);
                        $errmsg[$uid] = "Username '{$username}' already in use.";
                        $erruid[$uid] = 1;
                    }
                    else
                    { $input['username'] = $this->SfStr->getSafeString($_REQUEST['username'][$uid],SAFE_STRING_DB); }
                }
                else
                {
                    $errmsg[1] = 'Username cannot be blank.';
                    $erruid[$uid] = 1;
                }

                if(!empty($_REQUEST['password'][$uid]))
                { $input['password'] = $this->SfStr->getSafeString($_REQUEST['password'][$uid],SAFE_STRING_DB); }
                else
                {
                    $errmsg[2] = 'Password cannot be blank.';
                    $erruid[$uid] = 1;
                }

                if(isset($_REQUEST['admin_priv'][$uid]))
                { $input['admin_priv'] = 1; }
                else
                { $input['admin_priv'] = 0; }

                if($this->CONF['create_access'])
                {
                    $input['create_col'] = 'create_priv,';
                    if(isset($_REQUEST['create_priv'][$uid]))
                    {
                        $input['create_priv'] = '1,';
                        $input['create_update'] = 'create_priv=1,';
                    }
                    else
                    {
                        $input['create_priv'] = '0,';
                        $input['create_update'] = 'create_priv=0,';
                    }
                }
                else
                {
                    $input['create_col'] = '';
                    $input['create_update'] = '';
                }

                if(!isset($erruid[$uid]))
                {
                    if($uid{0} == 'x')
                    {
                        $uid = $this->db->GenID($this->CONF['db_tbl_prefix'].'users_sequence');
                        $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}users
                                  ({$input['create_col']} admin_priv, uid, sid, name, email, username, password)
                                  VALUES ({$input['create_priv']} {$input['admin_priv']}, $uid, 0, {$input['name']},
                                  {$input['email']},{$input['username']},{$input['password']})";
                    }
                    else
                    {
                        $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET {$input['create_update']}
                                  admin_priv = {$input['admin_priv']}, name = {$input['name']}, email = {$input['email']}, username = {$input['username']},
                                  password = {$input['password']} WHERE uid = {$input['uid']} AND sid=0";
                    }

                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $errmsg[$uid] = 'Error updating/inserting user data: ' . $this->db->ErrorMsg(); }
                }
            }
        }

        if(!empty($errmsg))
        {
            $this->setMessage('Error',implode('<br />',$errmsg),MSGTYPE_ERROR);
            $_SESSION['update_admin_users']['erruid'] = $erruid;
        }

        header("Location: {$this->CONF['html']}/admin.php");
        exit();

        //return $erruid;
    }

    //Delete user matching $uid from
    //"users" table and return result
    function delete_user($uid)
    {
        $uid = (int)$uid;
        $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}users WHERE uid = $uid AND sid = 0";
        $rs = $this->db->Execute($query);
        return $rs;
    }

    //Determine if a username is already in
    //user for a given survey.
    //Returns uid of match or false if username
    //is not being used.
    //$username is assumed to be passed unescaped for
    //the database. Use third parameter to
    //turn off database escaping within the function
    function check_username($sid,$username,$escape=1)
    {
        $sid = (int)$sid;

        if($escape)
        { $username = $this->SfStr->getSafeString($username,SAFE_STRING_DB); }
        else
        { $username = $this->SfStr->getSafeString($username,SAFE_STRING_ESC); }

        $query = "SELECT uid FROM {$this->CONF['db_tbl_prefix']}users WHERE sid=$sid AND username = {$username}";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error checking for existing username: ' . $this->db->ErrorMsg()); }

        if($r = $rs->FetchRow($rs))
        { $retval = $r['uid']; }
        else
        { $retval = FALSE; }

        return $retval;
    }

}

?>