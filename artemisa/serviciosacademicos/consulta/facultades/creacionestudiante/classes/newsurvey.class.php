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

class UCCASS_NewSurvey extends UCCASS_Main
{
    function UCCASS_NewSurvey()
    { $this->load_configuration(); }

    /*************
    * NEW SURVEY *
    *************/
    function new_survey()
    {
        if($this->CONF['create_access'] && !$this->_CheckLogin(0,CREATE_PRIV,'new_survey.php'))
        {
            if(isset($_REQUEST['username']))
            {
                $data['message'] = 'Nombre de Usuario y/o Clave incorrecto';
                $data['username'] = $this->SfStr->getSafeString($_REQUEST['username'],1);
            }
            $data['page'] = 'new_survey.php';
            $this->smarty->assign_by_ref('data',$data);
            return $this->smarty->Fetch($this->template.'/login.tpl');
        }

        //If Clear button is pressed, reset
        //step to zero
        if(isset($_REQUEST['clear']))
        {
            unset($_REQUEST);
            unset($_SESSION['new_survey']);
        }

        ////////////////////
        // PROCESS SURVEY //
        ////////////////////
        $error = "";

        if(isset($_REQUEST['next']))
        {
            // PROCESS NAME OF FORM
            if(strlen($_REQUEST['survey_name']) > 0)
            {
                $name = $this->SfStr->getSafeString($_REQUEST['survey_name'],SAFE_STRING_DB);
                $query = "SELECT 1 FROM {$this->CONF['db_tbl_prefix']}surveys WHERE name = $name";
                $rs = $this->Query($query,'Unable to see if survey name matches another');

                if($rs->FetchRow($rs))
                { $error = "Ya existe un encuesta con ese nombre."; }
                else
                {
                    $_SESSION['new_survey']['survey_name'] = $name;
                    @$_SESSION['new_survey']['step']++;
                }
            }
            else
            { $error = "Por favor entre un nombre. "; }

            if($copy_sid = (int)$_REQUEST['copy_survey'])
            {
                $query = "SELECT sid FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid = $copy_sid AND hidden = 0";
                $rs = $this->Query($query,'Error getting copy survey info');

                if($r = $rs->FetchRow($rs))
                {
                    $_SESSION['new_survey']['copy_sid'] = $copy_sid;

                    $query = "SELECT qid, question, aid, num_answers, num_required, page, orientation FROM {$this->CONF['db_tbl_prefix']}questions
                              WHERE sid = $copy_sid ORDER BY page, oid";
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $this->error("Error getting questions to copy survey: " . $this->db->ErrorMsg()); return; }

                    $old_page = 1;
                    $x = 0;
                    while($r = $rs->FetchRow($rs))
                    {
                        if($r['page'] != $old_page)
                        {
                            $_SESSION['new_survey']['question'][$x] = $this->CONF['page_break'];
                            $_SESSION['new_survey']['answer'][$x] = 0;
                            $_SESSION['new_survey']['num_answers'][$x] = 0;
                            $_SESSION['new_survey']['num_required'][$x] = 0;
                            $old_page = $r['page'];
                            $x++;
                        }

                        $_SESSION['new_survey']['qid'][$x] = $r['qid'];
                        $_SESSION['new_survey']['question'][$x] = $this->SfStr->getSafeString($r['question'],SAFE_STRING_ESC);
                        $_SESSION['new_survey']['answer'][$x] = $r['aid'];
                        $_SESSION['new_survey']['num_answers'][$x] = $r['num_answers'];
                        $_SESSION['new_survey']['num_required'][$x] = $r['num_required'];
                        $_SESSION['new_survey']['orientation'][$x] = $this->SfStr->getSafeString($r['orientation'],SAFE_STRING_ESC);

                        $x++;
                    }
                }
                else
                { $error = "Invalid survey passed to copy"; }
            }

            if(empty($_REQUEST['username']) || strlen($_REQUEST['username']) > 25)
            { $error .= "Username is not set or exceeds 25 characters. "; }
            else
            { $_SESSION['new_survey']['username'] = $this->SfStr->getSafeString($_REQUEST['username'],SAFE_STRING_DB); }

            if(empty($_REQUEST['password']) || strlen($_REQUEST['password']) > 25)
            { $error .= "Password is not set or exceeds 20 characters. "; }
            else
            { $_SESSION['new_survey']['password'] = $this->SfStr->getSafeString($_REQUEST['password'],SAFE_STRING_DB); }

            if(strlen($error) == 0)
            {
                $r = $this->process_survey($_SESSION['new_survey']);
                if(is_int($r))
                {
                    $_SESSION['new_survey']['sid'] = $r;
                    unset($_SESSION['new_survey']);
                    $_SESSION['edit_survey'][$r] = 1;
                    header("Location: {$this->CONF['html']}/edit_survey.php?sid=$r");
                    exit();
                }
                else
                { $error = $r; }
            }
        }

        $show['start_over_button'] = TRUE;
        $show['next_button'] = TRUE;

        //////////////////////////////
        // DISPLAY COPY SURVEY LIST //
        //////////////////////////////
        $public_surveys = Array();

        $show['survey_name'] = TRUE;

        if(isset($_SESSION['new_survey']['survey_name']))
        { $this->smarty->assign('survey_name',$this->SfStr->getSafeString($_SESSION['new_survey']['survey_name'],SAFE_STRING_TEXT)); }

        $query = "SELECT sid, name FROM {$this->CONF['db_tbl_prefix']}surveys WHERE hidden = 0 order by name ASC";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error("Cannot select public surveys: " . $this->db->ErrorMsg()); return; }

        $public_surveys['sid'][] = '';
        $public_surveys['name'][] = 'None - Start with blank survey';

        while($r = $rs->FetchRow($rs))
        {
            $public_surveys['sid'][] = $r['sid'];
            $public_surveys['name'][] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
        }
        $this->smarty->assign('public_surveys',$public_surveys);

        //Assign Smarty variables
        $this->smarty->assign('show',$show);

        if(isset($button))
        { $this->smarty->assign('button',$button); }

        if(isset($error))
        { $this->smarty->assign('error',$error); }

        //Retrieve parsed smarty template
        $retval = $this->smarty->fetch($this->template.'/add_survey.tpl');

        return $retval;
    }

    /*********************
    * PROCESS NEW SURVEY *
    *********************/
    function process_survey($s)
    {
        //$s is all data to create new survey

        //Default variables
        $sid = FALSE;
        $page = 1;
        $oid = 1;

        //Default values for new survey
        $s['activate'] = 0;
        $s['template'] = $this->SfStr->getSafeString($this->CONF['default_template'],SAFE_STRING_ESC);
        $s['date_format'] = $this->SfStr->getSafeString($this->CONF['date_format'],SAFE_STRING_ESC);
        $s['created'] = time();

        //////////////////
        //CREATE SURVEY //
        //////////////////
        $sid = $this->db->GenID($this->CONF['db_tbl_prefix'].'surveys_sequence');

        $sql[1] = "INSERT INTO {$this->CONF['db_tbl_prefix']}surveys (sid, name, active, template, date_format, created) VALUES
                   ($sid,{$s['survey_name']},{$s['activate']},{$s['template']},{$s['date_format']},{$s['created']})";
        if($rs1 = $this->query($sql[1],'Error creating survey'))
        {
            //Make copy of "copy_sid". If "copy_sid" key is not
            //passed in $s array, then use Zero to copy a
            //predetermined set of answer types and values
            //to new servey.
            if(!isset($s['copy_sid']))
            { $copy_sid = 0; }
            else
            { $copy_sid = $s['copy_sid']; }

            //CREATE DEFAULT USER
            $uid = $this->db->GenID($this->CONF['db_tbl_prefix'].'users_sequence');
            $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}users (uid, sid, username, password, edit_priv) VALUES
                      ($uid, $sid, {$s['username']}, {$s['password']}, 1)";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error creating default user with edit privileges: ' . $this->db->ErrorMsg()); }
            $_SESSION['priv'][$sid][EDIT_PRIV] = 1;

            ///////////////////////////////////////////////
            // COPY ANSWERS AND VALUES FROM OTHER SURVEY //
            ///////////////////////////////////////////////
            $query = "SELECT aid, name, type, label FROM {$this->CONF['db_tbl_prefix']}answer_types WHERE sid = {$copy_sid}";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error retrieving answer types: ' . $this->db->ErrorMsg()); }
            while($r = $rs->FetchRow($rs))
            {
                $name = $this->SfStr->getSafeString($r['name'],SAFE_STRING_ESC);
                $type = $this->SfStr->getSafeString($r['type'],SAFE_STRING_ESC);
                $label = $this->SfStr->getSafeString($r['label'],SAFE_STRING_ESC);
                $aid = $this->db->GenID($this->CONF['db_tbl_prefix'].'answer_types_sequence');
                $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}answer_types (aid, name, type, label, sid) VALUES
                          ($aid, $name,$type,$label,$sid)";
                $rs2 = $this->db->Execute($query);
                if($rs2 === FALSE)
                { $this->error('Error copying answer type: ' . $this->db->ErrorMsg()); }

                $s['new_aid'][$r['aid']] = $aid;

                $query = "SELECT avid, value, numeric_value, image FROM {$this->CONF['db_tbl_prefix']}answer_values
                          WHERE aid = {$r['aid']}";
                $rs3 = $this->db->Execute($query);
                if($rs3 === FALSE)
                { $this->error('Error retrieving answer values: ' . $this->db->ErrorMsg()); }
                while($r3 = $rs3->FetchRow($rs3))
                {
                    $value = $this->SfStr->getSafeString($r3['value'],SAFE_STRING_ESC);
                    $image = $this->SfStr->getSafeString($r3['image'],SAFE_STRING_ESC);
                    $avid = $this->db->GenID($this->CONF['db_tbl_prefix'].'answer_values_sequence');

                    $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}answer_values (avid, aid, value, numeric_value, image)
                              VALUES ($avid, $aid,$value,{$r3['numeric_value']},$image)";
                    $rs4 = $this->db->Execute($query);
                    if($rs4 === FALSE)
                    { $this->error('Error copying answer value: ' . $this->db->ErrorMsg()); }

                    $s['new_avid'][$r3['avid']] = $avid;
                }
            }

            //////////////////////
            // INSERT QUESTIONS //
            //////////////////////
            if(isset($s['question']) && count($s['question'])>0)
            {
                //Loop through each question and create SQL
                //needed to insert them into table
                $numq = count($s['question']);
                for($x=0;$x<$numq;$x++)
                {
                    //If question matches "page break" text, increment
                    //the $page counter, and reset the order ID (oid) counter
                    if(strcasecmp($s['question'][$x],$this->CONF['page_break']) == 0)
                    { $page++; $oid = 1;}
                    else
                    {
                        $aid = $s['new_aid'][$s['answer'][$x]];
                        //Create SQL to insert question and increment order ID (oid)
                        $qid = $this->db->GenID($this->CONF['db_tbl_prefix'].'questions_sequence');
                        $q = "($qid,{$s['question'][$x]},$aid,{$s['num_answers'][$x]},$sid,$page,{$s['num_required'][$x]},$oid,{$s['orientation'][$x]})";
                        $sql[2] = "INSERT INTO {$this->CONF['db_tbl_prefix']}questions (qid,question,aid,num_answers,sid,page,num_required,oid,orientation) VALUES $q";
                        $rs2 = $this->query($sql[2],'Error inserting question');
                        $s['new_qid'][$s['qid'][$x]] = $qid;

                        $oid++;
                    }
                }

                ///////////////////////
                // COPY DEPENDENCIES //
                ///////////////////////
                if(isset($s['copy_sid']))
                {
                    $query = "SELECT dep_id, qid, dep_qid, dep_aid, dep_option FROM {$this->CONF['db_tbl_prefix']}dependencies
                              WHERE sid = {$s['copy_sid']}";
                    $rs = $this->db->query($query,'Error retrieving dependencies');

                    $dep_insert = '';
                    while($r = $rs->FetchRow($rs))
                    {
                        //Replace old question IDs with
                        //new question IDs of questions just inserted above
                        $qid = $s['new_qid'][$r['qid']];
                        $dep_qid = $s['new_qid'][$r['dep_qid']];
                        $dep_aid = $s['new_avid'][$r['dep_aid']];

                        $dep_id = $this->db->GenID($this->CONF['db_tbl_prefix'].'dependencies_sequence');
                        $dep_option = $this->SfStr->getSafeString($r['dep_option'],SAFE_STRING_DB);
                        $dep_insert .= "($dep_id, $sid, $qid, $dep_qid, $dep_aid, $dep_option),";
                    }

                    if(!empty($dep_insert))
                    {
                        $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}dependencies (dep_id, sid, qid, dep_qid, dep_aid, dep_option)
                                  VALUES " . substr($dep_insert,0,-1);
                        $rs = $this->db->Query($query,'Error inserting dependencies');
                    }
                }
            }
        }

        //Return the Survey ID (sid)
        //of newly created survey
        return $sid;
    }

}

?>