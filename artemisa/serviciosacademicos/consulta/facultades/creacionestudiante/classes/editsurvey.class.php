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

//Constants for different edit survey sections
define('MODE_PROPERTIES','properties');
define('MODE_EDITQUESTION','edit_question');
define('MODE_QUESTIONS','questions');
define('MODE_NEWQUESTION','new_question');
define('MODE_ACCESSCONTROL','access_control');

//Constant for moving questions up or down
//in question list
define('MOVE_UP',1);
define('MOVE_DOWN',2);

//Survey Limits
define('SL_MINUTES',0);
define('SL_HOURS',1);
define('SL_DAYS',2);
define('SL_EVER',3);

//User Status
define('USERSTATUS_NONE',0);
define('USERSTATUS_INVITEE',1);
define('USERSTATUS_INVITED',2);
define('USERSTATUS_SENTLOGIN',3);

//String to seperate headers from
//body in email templates
define('HEADER_SEPERATOR','<!-- HEADER SEPERATOR - DO NOT REMOVE -->');

//Invitation code types
define('INVITECODE_ALPHANUMERIC','alphanumeric');
define('INVITECODE_WORDS','words');
define('ALPHANUMERIC_MAXLENGTH',20);
define('ALPHANUMERIC_DEFAULTLENGTH',10);
define('WORDCODE_SEPERATOR','-');
define('WORDCODE_NUMWORDS',2);

class UCCASS_EditSurvey extends UCCASS_Main
{
    //Load configuration and initialize data variable
    function UCCASS_EditSurvey()
    {
        $this->load_configuration();
        $this->data = array();
    }

    //Show edit survey page based upon request variables
    function show($sid)
    {
        $sid = (int)$sid;
        $retval = '';

        //Ensure user is logged in with valid privileges
        //for the requested survey or is an administrator
        if(!$this->_CheckLogin($sid,EDIT_PRIV,"edit_survey.php?sid=$sid"))
        { return $this->showLogin('edit_survey.php',array('sid'=>$sid)); }

        //Show links at top of page
        $this->data['show']['links'] = TRUE;
        $this->data['content'] = MODE_PROPERTIES;
        $this->data['mode'] = MODE_PROPERTIES;
        $this->data['sid'] = $sid;

        //Set default mode if not present
        if(!isset($_REQUEST['mode']))
        { $_REQUEST['mode'] = MODE_PROPERTIES; }

        $qid = (int)@$_REQUEST['qid'];

        switch($_REQUEST['mode'])
        {
            //Methods that handle the display and processing
            //of the question list
            // - Add new question
            // - Processing editing of question
            // - Showing question list
            case MODE_QUESTIONS:
                if(isset($_REQUEST['add_new_question']))
                { $this->_processAddQuestion($sid); }
                elseif(isset($_REQUEST['edit_question_submit']))
                { $this->_processEditQuestion($sid,$qid); }
                else
                {
                    $this->data['content'] = MODE_QUESTIONS;
                    $this->_loadQuestions($sid);
                }
            break;

            //Methods for handling editing questions
            // - Deleting questions
            // - Deleting page breaks
            // - Moving questions up or down
            // - Loading edit single question form
            case MODE_EDITQUESTION:

                if(isset($_REQUEST['delete_question']))
                {
                    if(isset($_REQUEST['page_break']))
                    { $this->_processDeletePageBreak($sid,$qid); }
                    elseif(isset($_REQUEST['del_qid']))
                    { $this->_processDeleteQuestion($sid, $qid); }
                }
                elseif(isset($_REQUEST['move_up']))
                { $this->_processMoveQuestion($sid,$qid,MOVE_UP); }
                elseif(isset($_REQUEST['move_down']))
                { $this->_processMoveQuestion($sid,$qid,MOVE_DOWN); }
                elseif(isset($_REQUEST['edit_question']))
                {
                    $this->data['content'] = MODE_EDITQUESTION;
                    $this->data['mode'] = MODE_QUESTIONS;
                    $this->_loadEditQuestion($sid,$qid);
                }
            break;

            //Displays and processes the access control functions
            // - Process access control options
            // - Process updating the user list
            // - Process performing an action on a group of users
            // - Process updating the invitee list
            // - Process performing an action on a group of invitees
            // - Showing access control page/form
            case MODE_ACCESSCONTROL:
                if(isset($_REQUEST['update_access_control']))
                { $this->_processUpdateAccessControl($sid); }
                //elseif(isset($_REQUEST['update_users']))
                //{ $this->_processUpdateUsers($sid); }
                elseif(isset($_REQUEST['users_go']))
                { $this->_processUsersAction($sid); }
                //elseif(isset($_REQUEST['invite_update']))
                //{ $this->_processUpdateInvite($sid); }
                elseif(isset($_REQUEST['invite_go']))
                { $this->_processInviteAction($sid); }
                else
                {
                    $this->data['content'] = MODE_ACCESSCONTROL;
                    $this->_loadAccessControl($sid);
                }
            break;

            //Default mode for displaying and processing survey properties
            // - Processing delete survey request
            // - Process removing all answers from survey request
            // - Process update of properties
            // - Showing properties page/form
            case MODE_PROPERTIES:
            default:
                if(isset($_REQUEST['edit_survey_submit']))
                {
                    //Process data and redirect back to page
                    if(isset($_REQUEST['delete_survey']))
                    { $this->_processDeleteSurvey($sid); }
                    elseif(isset($_REQUEST['clear_answers']))
                    { $this->_processDeleteAnswers($sid); }
                    else
                    { $this->_processProperties($sid); }
                }
                else
                {
                    $this->data['content'] = MODE_PROPERTIES;
                    $this->_loadProperties($sid);
                }
            break;
        }

        $this->smarty->assign_by_ref('data',$this->data);

        //Retrieve template that shows links for edit survey page
        $this->data['links'] = ($this->data['show']['links']) ? $this->smarty->Fetch($this->template.'/edit_survey_links.tpl') : '';

        if(isset($this->data['content']))
        { $this->data['content'] = $this->smarty->Fetch($this->template.'/edit_survey_' . $this->data['content'] . '.tpl'); }

        //Retrieve entire edit surey page based upon the content set above
        return $this->smarty->Fetch($this->template.'/edit_survey.tpl');

    }

    // DELETE SURVEY //
    function _processDeleteSurvey($sid)
    {
        $error = array();

        //Delete all references to this survey in database
        $tables = array('questions','results','results_text','ip_track','surveys','dependencies','time_limit','users','completed_surveys');
        foreach($tables as $tbl)
        {
            $rs = $this->db->Execute("DELETE FROM {$this->CONF['db_tbl_prefix']}$tbl WHERE sid = $sid");
            if($rs === FALSE)
            { $error[] = "Error deleting data from '{$this->CONF['db_tbl_prefix']}{$tbl}' table"; }
        }

        //Loop through answer types assigned to survey and delete answer_values
        //assigned to each answer type. Then delete all answer types assigned to survey
        $query1 = "SELECT aid FROM {$this->CONF['db_tbl_prefix']}answer_types at WHERE at.sid = $sid";
        $rs = $this->db->Execute($query1);
        if($rs === FALSE)
        { $error[] = 'Error getting aid values from answer_types table: ' . $this->db->ErrorMsg(); }
        else
        {
            $aid_list = '';
            while($r = $rs->FetchRow($rs))
            { $aid_list .= $r['aid'] . ','; }
            if(!empty($aid_list))
            {
                $aid_list = substr($aid_list,0,-1);
                $query2 = "DELETE FROM {$this->CONF['db_tbl_prefix']}answer_values WHERE aid IN ($aid_list)";
                $rs = $this->db->Execute($query2);
                if($rs === FALSE)
                { $error[] = 'Error deleting answer values: ' . $this->db->ErrorMsg(); }
            }
        }

        $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}answer_types WHERE sid = $sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $error[] = 'Error deleting answer types: ' . $this->db->ErrorMsg(); }

        //If no errors, redirect back to index or admin page
        //based upon whether the user is logged in as an admin or not
        if(empty($error))
        {
            //Set notice and redirect to main page
            if($this->_hasPriv(ADMIN_PRIV))
            { $this->setMessageRedirect('admin.php'); }
            else
            { $this->setMessageRedirect('index.php'); }

            $this->setMessage('Notice','Survey has been deleted.',MSGTYPE_NOTICE);
        }
        //otherwise...
        else
        {
            //Set error message and redirect back
            //to edit survey properties page
            $this->setMessageRedirect("edit_survey.php?sid=$sid");
            $this->setMessage('Delete Survey Error',implode('<br />',$error),MSGTYPE_ERROR);
        }
    }

    // DELETE PAGE BREAK //
    function _processDeletePageBreak($sid,$qid)
    {
        $sid = (int)$sid;
        $page = (int)$qid;
        $prev_page = $page - 1;

        //Set page to redirect to upon success or fail of deleting pagebreak
        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");

        //Ensure no questions on page after break have dependencies based upon questions
        //on page before break. If dependencies exist, do not delete the question.
        $query = "SELECT COUNT(*) AS c FROM {$this->CONF['db_tbl_prefix']}dependencies d, {$this->CONF['db_tbl_prefix']}questions q1,
                  {$this->CONF['db_tbl_prefix']}questions q2 WHERE q1.page = $prev_page AND d.dep_qid = q1.qid AND q2.page = $page
                  AND d.qid = q2.qid AND d.sid = $sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        {
            //Set message and redirect back to questions page
            $this->setMessage('Error','Error getting dependant count: ' . $this->db->ErrorMsg(),MSGTYPE_ERROR);
        }
        $r = $rs->FetchRow($rs);

        if($r['c'] == 0)
        {
            //Find the max oid for the questions on page before break and start assigning oid values
            //from there for questions on next page and set page values equal to each other.
            $query = "SELECT MAX(oid) as max_oid FROM {$this->CONF['db_tbl_prefix']}questions WHERE sid=$sid and page = " . ($page-1);
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            {
                //Set message and redirect back to questions page
                $this->setMessage('Error','Error getting max oid: ' . $this->db->ErrorMsg(),MSGTYPE_ERROR);
            }
            $r = $rs->FetchRow($rs);

            if($r['max_oid'] > 0)
            {
                $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET oid = oid + {$r['max_oid']} WHERE sid=$sid and page=$page";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                {
                    //set message and redirect
                    $this->setMessage('Error','Error updating oid: ' . $this->db->ErrorMsg(),MSGTYPE_ERROR);
                }
            }

            $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = page - 1 WHERE page >= $page and sid = $sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            {
                //set message and redirect
                $this->setMessage('Error','Error updating page: ' . $this->db->ErrorMsg(),MSGTYPE_ERROR);
            }
            else
            {
                //set success message and redirect
                $this->setMessage('Notice','Page break successfully deleted.',MSGTYPE_NOTICE);
            }
        }
        else
        {
            //set message and redirect
            $this->setMessage('Error','Cannot delete page break because of questions on next page having dependencies on questions from previous page.',MSGTYPE_ERROR);
        }
    }

    // DELETE QUESTION //
    function _processDeleteQuestion($sid,$qid)
    {
        $error = array();
        $tables = array('questions','results','results_text','dependencies');
        $error='';
        $sid = (int)$sid;
        $qid = (int)$qid;
        //Delete all references to this question in tables listed above
        foreach($tables as $tbl)
        {
            $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}$tbl WHERE qid = $qid and sid=$sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $error[] = "Error deleting question from $tbl: " . $this->db->ErrorMsg(); }
        }

        //Delete any dependencies that rely upon an answer to this question
        $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}dependencies WHERE dep_qid = $qid AND sid=$sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $error[] = 'Error removing existing depedencies upon question being deleted: ' . $this->db->ErrorMsg(); }

        if(!empty($error))
        {
            //Set error message and redirect back to questions page
            $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");
            $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR);
        }
        else
        {
            $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");
            $this->setMessage('Notice','Question and answers successfully deleted.',MSGTYPE_NOTICE);
        }
    }

    // DELETE ANSWERS/RESULTS FROM SURVEY //
    function _processDeleteAnswers($sid)
    {
        $sid = (int)$sid;
        $error = array();

        //set tables to delete any results from to clear all answers from this survey
        $tables = array('results','results_text','ip_track','time_limit');
        foreach($tables as $tbl)
        {
            $rs = $this->db->Execute("DELETE FROM {$this->CONF['db_tbl_prefix']}$tbl WHERE sid = $sid");
            if($rs === FALSE)
            { $error[] = 'Unable to delete results from ' . $tbl . ': ' . $this->db->ErrorMsg(); }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=properties");

        if(empty($error))
        {
            //Set error message and redirect back to properties page
            $this->setMessage('Clear Answers Error',implode('<br />',$error),MSGTYPE_ERROR);
        }
        else
        {
            //Set success message and redirect back to properties page
            $this->setMessage('Success','All answers cleared from survey',MSGTYPE_NOTICE);
        }
    }

    // PROCESS SUBMISSION OF NEW PROPERTIES //
    function _processProperties($sid)
    {
        //validate submitted data
        $pr = $this->_validateProperties($sid);

        //if the validation did not
        //set an error, proceed with update
        if(empty($pr['error']))
        {
            $query = "UPDATE {$this->CONF['db_tbl_prefix']}surveys SET name={$pr['input']['name']}, start_date={$pr['input']['start']},
                      end_date={$pr['input']['end']}, active={$pr['input']['active']},
                      template = {$pr['input']['template']}, redirect_page = {$pr['input']['redirect_page']},
                      survey_text_mode = {$pr['input']['survey_text_mode']}, user_text_mode = {$pr['input']['user_text_mode']},
                      date_format = {$pr['input']['date_format']}, time_limit = {$pr['input']['time_limit']}
                      WHERE sid = $sid";

            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $pr['error'][] = 'Error updating survey properties: ' . $this->db->ErrorMsg(); }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=properties");

        //Show success or failure message and redirect back to properties page.
        if(empty($pr['error']))
        { $this->setMessage('Update Success','Survey properties updated',MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Update Error',implode('<br />',$pr['error']),MSGTYPE_ERROR); }
    }

    // VALIDATE NEW PROPERTY DATA SUBMITTED BY USER //
    function _validateProperties($sid)
    {
        $input = array();
        $error = array();

        //Ensure survey name is supplied
        if(strlen($_REQUEST['name']) > 0)
        { $input['name'] = $this->SfStr->getSafeString($_REQUEST['name'],SAFE_STRING_DB); }
        else
        { $error[] = 'Survey name is required.'; }

        //Ensure valid template was chosen
        if(!empty($_REQUEST['template']))
        { $input['template'] = $this->SfStr->getSafeString(str_replace(array('\\','/'),'',$_REQUEST['template']),SAFE_STRING_DB); }
        else
        { $error[] = 'Invalid template selection.'; }

        $today = mktime(0,0,0,date('m'),date('d'),date('Y'));

        //Ensure start and end dates are valid
        if(!empty($_REQUEST['start']))
        {
            $s = strtotime($_REQUEST['start'] . ' 00:00:01');
            if($s >= 0)
            { $input['start'] = $s; }
            else
            { $error[] = 'Invalid start date. Please ensure the date is in the correct format shown.'; }
        }
        else {$input['start'] = 0; }

        if(!empty($_REQUEST['end']))
        {
            $e = strtotime($_REQUEST['end'] . ' 23:59:59');
            if($e >= 0)
            { $input['end'] = $e; }
            else
            { $error[] = 'Invalid end date. Please ensure the date is in the correct format shown.'; }
        }
        else
        {$input['end'] = 0; }

        if($input['end'] < $input['start'])
        { $error[] = 'End date can not be before start date.'; }

        //Activate survey only if the survey has any questions. You can
        //no longer activate empty surveys.
        if($_REQUEST['active'] == 1)
        {
            $query = "SELECT COUNT(qid) AS c FROM {$this->CONF['db_tbl_prefix']}questions WHERE sid = $sid GROUP BY sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $error[] = 'Error getting count of questions in survey: ' . $this->db->ErrorMsg(); }
            elseif($r = $rs->FetchRow($rs))
            { $input['active'] = 1; }
            else
            {
                $error[] = 'Cannot activate a survey with no questions.';
                $input['active'] = 0;
            }
        }
        else
        { $input['active'] = 0; }

        //Validate survey and user text modes
        $input['survey_text_mode'] = (int)$_REQUEST['survey_text_mode'];
        if($input['survey_text_mode'] < 0 || $input['survey_text_mode'] > 2)
        { $error[] = 'Invalid survey text mode selected. '; }

        $input['user_text_mode'] = (int)$_REQUEST['user_text_mode'];
        if($input['user_text_mode'] < 0 || $input['user_text_mode'] > 2)
        { $error[] = 'Invalid user text mode selected. '; }

        //Validate date format
        if(!empty($_REQUEST['date_format']))
        { $input['date_format'] = $this->SfStr->getSafeString($_REQUEST['date_format'],SAFE_STRING_DB); }
        else
        { $input['date_format'] = $this->SfStr->getSafeString($this->CONF['date_format'],SAFE_STRING_ESC); }

        //Validate time limit for survey
        if(!empty($_REQUEST['time_limit']))
        { $input['time_limit'] = (int)$_REQUEST['time_limit']; }
        else
        { $input['time_limit'] = 0; }

        //validate redirection page to use after survey is completed
        if(!isset($_REQUEST['redirect_page']))
        { $error[] = 'Invalid completion redirect page. '; }
        else
        {
            switch($_REQUEST['redirect_page'])
            {
                case 'index':
                case 'results':
                    $input['redirect_page'] = $this->SfStr->getSafeString($_REQUEST['redirect_page'],SAFE_STRING_DB);
                break;

                case 'custom':
                    if(empty($_REQUEST['redirect_page_text']))
                    { $error[] = 'You must supply a redirect page when choosing "Custom" for completion redirect page'; }
                    else
                    { $input['redirect_page'] = $this->SfStr->getSafeString($_REQUEST['redirect_page_text'],SAFE_STRING_DB); }
                break;

                default:
                    $error[] = 'Invalid completion redirect page. ';
                break;
            }
        }

        $retval = array('input'=>$input, 'error' => $error);

        return $retval;
    }

    // PROCESS EDIT QUESTION DATA //
    function _processEditQuestion($sid,$qid)
    {
        $sid = (int)$sid;
        $qid = (int)$qid;
        $error = array();

        //Validate new question data
        $this->data = $this->_validateEditQuestion();

        if(empty($this->data['error']))
        {
            //update question with new values
            $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET question = {$this->data['input']['question']}, aid = {$this->data['input']['aid']},
                      num_answers = {$this->data['input']['num_answers']}, num_required = {$this->data['input']['num_required']},
                      orientation = {$this->data['input']['orientation']} WHERE sid = $sid and qid = $qid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->data['error'][] = 'Error updating question: ' . $this->db->ErrorMsg(); }
        }

        //Delete any checked dependencies
        if(isset($_REQUEST['edep_id']))
        {
            $er = $this->_processDeleteDependency($sid,$_REQUEST['edep_id']);
            if(!empty($er))
            { $this->data['error'] = array_merge($this->data['error'],$er); }
        }

        //check for and add new dependencies
        if(isset($_REQUEST['option']))
        {
            $er = $this->_processAddDependency($sid,$qid);
            if(!empty($er))
            { $this->data['error'] = array_merge($this->data['error'],$er); }
        }

        //Set success or failure message and redirect to appropriate page
        if(empty($this->data['error']))
        {
            $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");
            $this->SetMessage('Notice','Question successfully edited.',MSGTYPE_NOTICE);
        }
        else
        {
            $this->setMessageRedirect("edit_survey.php?sid=$sid&qid=$qid&mode=edit_question&edit_question=1");
            $this->setMessage('Error',implode('<br />',$this->data['error']),MSGTYPE_ERROR);
        }
    }

    // VALIDATE DATA SUPPLIED TO EDITING QUESTION //
    function _validateEditQuestion()
    {
        $input = array();
        $error = array();

        //Validate text of question
        if(!empty($_REQUEST['question']))
        { $input['question'] = $this->SfStr->getSafeString($_REQUEST['question'],SAFE_STRING_DB); }
        else
        { $error[] = 'Please provide the text for the question.'; }

        //Ensure valid question ID was passed with form data
        if(empty($_REQUEST['qid']))
        { $error[] = 'No question was chosen to edit.'; }
        else
        { $input['qid'] = (int)$_REQUEST['qid']; }

        //Validate selected answer type
        if(empty($_REQUEST['answer']))
        { $error[] = 'Please choose an answer type for the question.'; }
        else
        { $input['aid'] = (int)$_REQUEST['answer']; }

        //Validate number of answers and number of answers required
        $input['num_answers'] = max(1,(int)@$_REQUEST['num_answers']);
        $input['num_required'] = max(0,(int)@$_REQUEST['num_required']);

        if($input['num_required'] > $input['num_answers'])
        { $error[] = 'Number of required answers cannot exceed the number of answers'; }

        //Validate orientation of question
        if(in_array($_REQUEST['orientation'],$this->CONF['orientation']))
        { $input['orientation'] = $this->SfStr->getSafeString($_REQUEST['orientation'],SAFE_STRING_DB); }
        else
        { $input['orientation'] = 'Vertical'; }

        return(array('input'=>$input, 'error'=>$error));
    }

    // REMOVE DEPENDENCIES //
    function _processDeleteDependency($sid,$dep_id)
    {
        $error = array();

        //Loop through and delete any dependency IDs that are passed
        if(is_array($dep_id) && !empty($dep_id))
        {
            $id_list = '';
            foreach($dep_id as $id)
            { $id_list .= 'dep_id = ' . (int)$id . ' OR '; }
            $id_list = substr($id_list,0,-3);

            $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}dependencies WHERE sid = $sid AND ($id_list)";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $rror[] = 'Error deleting dependencies: ' . $this->db->ErrorMsg(); }
        }

        return $error;
    }

    // ADD DEPENDENCY TO QUESTION //
    function _processAddDependency($sid,$qid)
    {
        $error = array();
        $dep = $this->_validateDependency($sid,$qid);

        //Loop through any new dependencies passed from form. If dependency is based upon
        //a question on the same page, force the creation of a page break.
        if(empty($dep['error']) && !empty($dep['input']))
        {
            foreach($dep['input']['dep_aid'] as $num=>$dep_aid_array)
            {
                foreach($dep_aid_array as $dep_aid)
                {
                    $dep_insert = '';
                    $dep_id = $this->db->GenID($this->CONF['db_tbl_prefix'].'dependencies_sequence');
                    $dep_insert = "($dep_id,$sid,$qid,{$dep['input']['dep_qid'][$num]},{$dep_aid},{$dep['input']['option'][$num]})";

                    $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}dependencies (dep_id, sid, qid, dep_qid, dep_aid, dep_option)
                            VALUES " . $dep_insert;
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $error[] = 'Error inserting dependencies: ' . $this->db->ErrorMsg(); }
                }
            }

            if(isset($dep['input']['dep_require_pagebreak']))
            {
                $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = page + 1 WHERE sid = $sid AND
                        (page > {$dep['input']['page']} OR (page = {$dep['input']['page']} AND oid > {$dep['input']['oid']}) OR qid = $qid)";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $error[] = 'Cannot insert dependency page break: ' . $this->db->ErrorMsg(); }
            }
        }
        return array_merge($error,$dep['error']);
    }

    // VALIDATE NEW DEPENDENCIES //
    function _validateDependency($sid,$qid)
    {
        $input = array();
        $error = array();

        if(isset($_REQUEST['option']) && is_array($_REQUEST['option']) && !empty($_REQUEST['option']))
        {
            foreach($_REQUEST['option'] as $num=>$option)
            {
                if(!empty($option))
                {
                    //Valide dependency option chosen (hide, require or show)
                    if(empty($option) || !in_array($option,$this->CONF['dependency_modes']))
                    { $error[] = 'Please choose a valid option (hide, show, etc)'; }
                    else
                    { $input['option'][$num] = $this->SfStr->getSafeString($option,SAFE_STRING_DB); }

                    //Validate question ID to add depenency to
                    if(empty($_REQUEST['dep_qid'][$num]))
                    { $error[] = 'Please choose a question to add dependency to.'; }
                    else
                    { $input['dep_qid'][$num] = (int)$_REQUEST['dep_qid'][$num]; }

                    //Validate question ID to base dependency on
                    if(empty($_REQUEST['dep_aid'][$num]))
                    { $error[] = 'Please choose a question to base the new dependency on.'; }
                    else
                    {
                        foreach($_REQUEST['dep_aid'][$num] as $dep_aid)
                        { $input['dep_aid'][$num][] = (int)$dep_aid; }
                    }

                    $input['dep_qid'][$num] = (int)$_REQUEST['dep_qid'][$num];

                    //Ensure question chosen to base new dependency on is before the question the dependency
                    //is being added to. If both are on the same page, set a flag to require a page break
                    //be added before the selected question.
                    $check_query = "SELECT q1.page, q1.oid, q2.page AS dep_page, q2.oid AS dep_oid
                                    FROM {$this->CONF['db_tbl_prefix']}questions q1, {$this->CONF['db_tbl_prefix']}questions q2
                                    WHERE q1.qid = $qid AND q2.qid = {$input['dep_qid'][$num]}";

                    $rs = $this->db->Execute($check_query);
                    if($rs === FALSE)
                    { $error[] = 'Error checking page break requirement for dependency: ' . $this->db->ErrorMsg(); }

                    while($r = $rs->FetchRow($rs))
                    {
                        if($r['dep_page'] > $r['page'] || ($r['dep_page'] == $r['page'] && $r['dep_oid'] > $r['oid']))
                        { $error[] = 'Error: Dependencies can only be based on questions displayed BEFORE the question being added'; }
                        elseif($r['page'] == $r['dep_page'])
                        {
                            $input['dep_require_pagebreak'] = 1;
                            $input['page'] = $r['page'];
                            $input['oid'] = $r['oid'];
                        }
                    }
                }
            }
        }
        return(array('input'=>$input, 'error'=>$error));
    }

    // LOAD EXISTING PROPERTIES FOR A SURVEY //
    function _loadProperties($sid)
    {
        $sid = (int)$sid;

        //load survey properties and set default values
        $query = "SELECT sid, name, start_date, end_date, active,
                  template, redirect_page, survey_text_mode, user_text_mode, created, date_format, time_limit FROM
                  {$this->CONF['db_tbl_prefix']}surveys WHERE sid = $sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error("Error loading Survey #$sid: " . $this->db->ErrorMsg()); return; }
        elseif($r = $rs->FetchRow($rs))
        {
            $this->data['name'] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);

            $this->data['date_format'] = $this->SfStr->getSafeString($r['date_format'],SAFE_STRING_TEXT);
            $this->data['created'] = $this->SfStr->getSafeString(date($this->CONF['date_format'],$r['created']),SAFE_STRING_TEXT);
            $this->data['time_limit'] = $this->SfStr->getSafeString($r['time_limit'],SAFE_STRING_TEXT);

            if($r['active'] == 1)
            { $this->data['active_selected'] = ' checked'; }
            else
            { $this->data['inactive_selected'] = ' checked'; }

            if($r['start_date'] == 0)
            { $this->data['start_date'] = ''; }
            else
            { $this->data['start_date'] = strtoupper(date('Y-m-d',$r['start_date'])); }

            if($r['end_date'] == 0)
            { $this->data['end_date'] = ''; }
            else
            { $this->data['end_date'] = strtoupper(date('Y-m-d',$r['end_date'])); }

            switch($r['redirect_page'])
            {
                case 'index':
                case '':
                    $this->data['redirect_index'] = ' checked';
                break;
                case 'results':
                    $this->data['redirect_results'] = ' checked';
                break;
                default:
                    $this->data['redirect_custom'] = ' checked';
                    $this->data['redirect_page_text'] = $this->SfStr->getSafeString($r['redirect_page'],SAFE_STRING_TEXT);
                break;
            }

            //Set arrays for holding text mode values, options, and selected element to
            //create drop down boxes
            $survey_text_mode = array_slice($this->CONF['text_modes'],0,$this->CONF['survey_text_mode']+1);
            $this->data['survey_text_mode_values'] = array_values($survey_text_mode);
            $this->data['survey_text_mode_options'] = array_keys($survey_text_mode);
            $this->data['survey_text_mode_selected'][$r['survey_text_mode']] = ' selected';

            $user_text_mode = array_slice($this->CONF['text_modes'],0,$this->CONF['user_text_mode']+1);
            $this->data['user_text_mode_values'] = array_values($user_text_mode);
            $this->data['user_text_mode_options'] = array_keys($user_text_mode);
            $this->data['user_text_mode_selected'][$r['user_text_mode']] = ' selected';

            if(in_array(2,$this->data['survey_text_mode_options']) || in_array(2,$this->data['user_text_mode_options']))
            { $this->data['show']['fullhtmlwarning'] = TRUE; }

            $dh = opendir($this->CONF['path'] . '/templates');
            while($file = readdir($dh))
            {
                if($file != '.' && $file != '..')
                {
                    $this->data['templates'][] = $this->SfStr->getSafeString($file,SAFE_STRING_TEXT);
                    if($r['template'] == $file)
                    { $this->data['selected_template'][] = ' selected'; }
                    else
                    { $this->data['selected_template'][] = ''; }
                }
            }

            sort($this->data['templates']);
        }
        else
        { $this->error("Survey #$sid does not exist."); return; }
    }

    // LOAD EXISTING QUESTIONS FOR SURVEY //
    function _loadQuestions($sid)
    {
        $sid = (int)$sid;
        $this->data['mode_edit_question'] = MODE_EDITQUESTION;
        $this->data['mode_new_question'] = MODE_QUESTIONS;

        $this->data['sid'] = $sid;

        //load all questions for this survey
        $query = "SELECT q.qid, q.aid, q.question, q.page, a.type, q.oid, s.survey_text_mode
                  FROM {$this->CONF['db_tbl_prefix']}questions q,
                  {$this->CONF['db_tbl_prefix']}answer_types a, {$this->CONF['db_tbl_prefix']}surveys s
                  WHERE q.aid = a.aid and q.sid = $sid AND q.sid = s.sid order by q.page, q.oid, a.aid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error("Error selecting questions: " . $this->db->ErrorMsg()); return; }

        $page = 1;
        $x = 0;
        $q_num = 1;
        $label_num = 1;
        $num_demographics = 0;
        $this->data['answer'] = array();
        $this->data['show']['dep'] = TRUE;

        if($r = $rs->FetchRow($rs))
        {
            $survey_text_mode = $r['survey_text_mode'];
            do
            {
                //Load data for each question into the $data array
                while($page != $r['page'])
                {
                    $this->data['qid'][$x] = $r['page'];
                    $this->data['question'][$x] = $this->CONF['page_break'];
                    $this->data['qnum'][$x] = '&nbsp;';
                    $this->data['page_break'][$x] = TRUE;
                    $this->data['show_dep'][$x] = FALSE;
                    $x++;
                    $page += 1;
                }
                $this->data['qid'][$x] = $r['qid'];
                $this->data['question'][$x] = nl2br($this->SfStr->getSafeString($r['question'],$survey_text_mode));

                if($r['type'] == 'MS' || $r['type'] == 'MM')
                {
                    //Retrieve answer value in safe_text mode
                    //so they can be shown in dependency <select>
                    $temp = $this->get_answer_values($r['aid'],BY_AID,SAFE_STRING_TEXT);
                    $this->data['dep_avid'][$r['qid']] = $temp['avid'];
                    $this->data['dep_value'][$r['qid']] = $temp['value'];
                }

                if($r['type'] != 'N')
                {
                    $this->data['qnum'][$x] = $q_num++;
                    $this->data['page_oid'][] = $r['page'] . '-' . $r['oid'];
                    $this->data['qnum2'][] = $this->data['qnum'][$x];
                    $this->data['qnum2_selected'][] = '';

                    if($r['type'] != 'S' && $r['type'] != 'T')
                    {
                        $this->data['dep_qid'][] = $r['qid'];
                        $this->data['dep_qnum'][] = $this->data['qnum'][$x];
                    }

                }
                else
                {
                    $this->data['qnum'][$x] = 'L'.$label_num++;
                    $this->data['page_oid'][] = $r['page'] . '-' . $r['oid'];
                    $this->data['qnum2'][] = $this->data['qnum'][$x];
                    $this->data['qnum2_selected'][] = '';
                }

                $this->data['show_edep'][$x] = FALSE;

                $x++;

            }while($r = $rs->FetchRow($rs));

            //load dependencies for current survey
            $query = "SELECT d.qid, d.dep_qid, av.value, d.dep_option FROM {$this->CONF['db_tbl_prefix']}dependencies d,
                      {$this->CONF['db_tbl_prefix']}answer_values av WHERE d.dep_aid = av.avid AND d.sid = $sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error selecting dependencies for survey: ' . $this->db->ErrorMsg()); return; }

            while($r = $rs->FetchRow($rs))
            {
                // __hide__ if question __xx__ is __a,b,c__
                $x = array_search($r['qid'],$this->data['qid']);
                $key = array_search($r['dep_qid'],$this->data['qid']);
                $qnum = $this->data['qnum'][$key];

                $this->data['show_edep'][$x] = TRUE;
                if(isset($this->data['edep_value'][$x]) && in_array($qnum,$this->data['edep_qnum'][$x]))
                {
                    $key2 = array_search($qnum,$this->data['edep_qnum'][$x]);

                    if($this->data['edep_option'][$x][$key2] == $r['dep_option'])
                    { $this->data['edep_value'][$x][$key2] .= ', ' . $this->SfStr->getSafeString($r['value'],$survey_text_mode); }
                    else
                    {
                        $this->data['edep_option'][$x][] = $this->SfStr->getSafeString($r['dep_option'],$survey_text_mode);
                        $this->data['edep_value'][$x][] = $this->SfStr->getSafeString($r['value'],$survey_text_mode);
                        $this->data['edep_qnum'][$x][] = $qnum;
                    }
                }
                else
                {
                    $this->data['edep_option'][$x][] = $this->SfStr->getSafeString($r['dep_option'],$survey_text_mode);
                    $this->data['edep_value'][$x][] = $this->SfStr->getSafeString($r['value'],$survey_text_mode);
                    $this->data['edep_qnum'][$x][] = $qnum;
                }
            }
        }
        else
        { $this->data['show']['dep'] = FALSE; }

        //Create javascript to fill <select> boxes when creating dependencies
        if(isset($this->data['dep_avid']) && count($this->data['dep_avid']))
        {
            $this->data['js'] = '';

            foreach($this->data['dep_avid'] as $qid=>$avid_array)
            {
                foreach($avid_array as $key=>$avid)
                {
                    $this->data['js'] .= "Answers['$qid,$key'] = '$avid';\n";
                    $value = addslashes($this->data['dep_value'][$qid][$key]);
                    $this->data['js'] .= "Values['$qid,$key'] = '$value';\n";
                }
                $c = count($avid_array);
                $this->data['js'] .= "Num_Answers['$qid'] = '$c';\n";
            }
        }

        //Set "insert question after..." select box to last element
        if(isset($this->data['qnum2_selected']))
        { $this->data['qnum2_selected'][count($this->data['qnum2_selected'])-1] = ' selected'; }

        $this->data['num_answers'] = array("1","2","3","4","5");
        $this->data['num_answers_selected'] = array_fill(0,5,"");
        if(isset($_REQUEST['num_answers']))
        { $this->data['num_answers_selected'][(int)$_REQUEST['num_answers']-1] = ' selected'; }

        $this->data['num_required'] = array("0","1","2","3","4","5");
        $this->data['num_required_selected'] = array_fill(0,6,"");
        if(isset($_REQUEST['num_required']))
        { $this->data['num_required_selected'][(int)$_REQUEST['num_required']] = ' selected'; }

        //retrieve answer types from database
        $rs = $this->db->Execute("SELECT aid, name FROM {$this->CONF['db_tbl_prefix']}answer_types
                                  WHERE sid = $sid ORDER BY name ASC");
        if($rs === FALSE)
        { $this->error('Unable to retrieve answer types: ' . $this->db->ErrorMsg()); return; }
        while ($r = $rs->FetchRow($rs))
        {
            $r['name'] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
            $this->data['answer'][] = $r;
        }

        if(isset($_SESSION['answer_orientation']))
        {
            $key = array_search($_SESSION['answer_orientation'],$this->CONF['orientation']);
            $this->data['orientation']['selected'][$key] = ' selected';
        }
    }

    // PROCESS MOVING A QUESTION  UP OR DOWN IN THE LIST //
    function _processMoveQuestion($sid,$qid,$move)
    {
        $sid = (int)$sid;
        $qid = (int)$qid;
        $error = array();

        //Get page and oid for requested question
        $query = "SELECT page, oid FROM {$this->CONF['db_tbl_prefix']}questions WHERE qid = $qid AND sid = $sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $error[] = 'Error getting data to move question: ' . $this->db->ErrorMsg(); }
        elseif($r = $rs->FetchRow($rs))
        {
            switch($move)
            {
                //Move question and redirect back to questions page
                case MOVE_UP:
                    $error = $this->_processMoveQuestionUp($sid,$qid,$r['page'],$r['oid']);
                break;
                case MOVE_DOWN:
                    $error = $this->_processMoveQuestionDown($sid,$qid,$r['page'],$r['oid']);
                break;
            }
        }
        else
        { $error[] = 'Invalid question chosen to move.'; }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");

        if(empty($error))
        { $this->setMessage('Notice','Question successfully moved',MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // MOVE QUESTION UP IN LIST //
    function _processMoveQuestionUp($sid,$qid,$page,$oid)
    {
        $error = array();

        //Get question, page, and oid of question directly "above"
        //the question being moved up.
        $query = "SELECT qid, page, oid FROM {$this->CONF['db_tbl_prefix']}questions WHERE sid = $sid AND
                  ((page = {$page} AND oid < {$oid}) OR page < {$page}) AND page > 0
                  ORDER BY page DESC, oid DESC";
        $rs2 = $this->db->SelectLimit($query,1);
        if($rs2 === FALSE)
        { $error[] = 'Error retrieving swap data to move question up: ' . $this->db->ErrorMsg(); }
        elseif($row2 = $rs2->FetchRow($rs2))
        {
            //If question being moved up is passing page boundary, just
            //reduce the page number by one and set oid to one more than
            //oid of previous question retrieved
            if($page != $row2['page'])
            {
                //Check to see if there are any questions on the previous
                //page that the question being moved is dependant upon
                $query = "SELECT COUNT(*) AS c FROM {$this->CONF['db_tbl_prefix']}dependencies d, {$this->CONF['db_tbl_prefix']}questions q
                          WHERE q.page = {$row2['page']} AND d.qid = $qid AND d.dep_qid = q.qid";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $error[] = 'Error counting dependencies: ' . $this->db->ErrorMsg(); }
                $r = $rs->FetchRow($rs);

                if($r['c'] == 0)
                {

                    $oid2 = $row2['oid'] + 1;
                    $swap_query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = page - 1, oid = $oid2 WHERE qid = $qid";
                    $swap_result = $this->db->Execute($swap_query);
                    if($swap_result === FALSE)
                    { $error[] = 'Error moving question across page boundary: ' . $this->db->ErrorMsg(); }
                }
                else
                { $error[] = "Cannot move question up because of dependencies on questions on previous page."; }
            }
            else
            {
                //Otherwise just swap page and oids of the two questions
                $swap_query1 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = {$row2['page']}, oid = {$row2['oid']} WHERE qid = $qid";
                $swap_query2 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = {$row2['page']}, oid = {$oid} WHERE qid = {$row2['qid']}";
                $swap_result1 = $this->db->Execute($swap_query1);
                $swap_result2 = $this->db->Execute($swap_query2);
                if($swap_result1 === FALSE || $swap_result2 === FALSE)
                { $error[] = 'Error swapping "oid" of questions to move up: ' . $this->db->ErrorMsg(); }
            }
        }
        else
        { $error[] = 'Cannot move question; question already at beginning of survey'; }

        return $error;
    }

    // MOVE QUESTION DOWN IN LIST //
    function _processMoveQuestionDown($sid,$qid,$page,$oid)
    {
        $error = array();

        //Get data for question "below" question being moved
        $query = "SELECT qid, page, oid FROM {$this->CONF['db_tbl_prefix']}questions WHERE sid = $sid AND
                  ((page = {$page} AND oid > {$oid}) OR page > {$page})
                  ORDER BY page ASC, oid ASC";
        $rs2 = $this->db->SelectLimit($query,1);
        if($rs2 === FALSE)
        { $error[] = 'Error retrieving swap data to move question down: ' . $this->db->ErrorMsg(); }
        elseif($row2 = $rs2->FetchRow($rs2))
        {
            if($page != $row2['page'])
            {
                //Check to see if there are questions on the next page
                //that have dependencies based upon the question being moved
                $query = "SELECT COUNT(*) AS c FROM {$this->CONF['db_tbl_prefix']}dependencies d, {$this->CONF['db_tbl_prefix']}questions q
                          WHERE q.page = {$row2['page']} AND q.qid = d.qid AND d.dep_qid = $qid";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $error[] = 'Error checking depedencies for next page: ' . $this->db->ErrorMsg(); }
                $r = $rs->FetchRow($rs);

                if($r['c'] == 0)
                {
                    $page2 = $page + 1;
                    $swap_query1 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET oid = oid + 1 WHERE page = $page2 AND sid = $sid";
                    $swap_query2 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = $page2, oid = 1 WHERE qid = $qid";
                    $swap_result1 = $this->db->Execute($swap_query1);
                    $swap_result2 = $this->db->Execute($swap_query2);
                    if($swap_result1 === FALSE || $swap_result2 === FALSE)
                    { $error[] = 'Error moving question across page boundary: ' . $this->db->ErrorMsg(); }
                }
                else
                { $error[] = 'Cannot move requested question down because questions on next page have dependencies on requested question. '; }
            }
            else
            {
                $swap_query1 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = {$row2['page']}, oid = {$row2['oid']} WHERE qid = $qid";
                $swap_query2 = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = {$row2['page']}, oid = {$oid} WHERE qid = {$row2['qid']}";
                $swap_result1 = $this->db->Execute($swap_query1);
                $swap_result2 = $this->db->Execute($swap_query2);
                if($swap_result1 === FALSE || $swap_result2 === FALSE)
                { $error[] = 'Error swapping "oid" of questions to move down: ' . $this->db->ErrorMsg(); }
            }
        }
        else
        { $error[] = 'Cannot move question; question already at end of survey'; }

        return $error;
    }

    // PROCESSING ADDITION OF NEW QUESTION //
    function _processAddQuestion($sid)
    {
        $sid = (int)$sid;
        $error = array();
        $notice = '';

        //Ensure new question is not blank
        if(strlen($_REQUEST['question']) == 0)
        { $error[] = 'Question text can not be blank.'; }
        else
        {
            //Determine what question to insert new question after
            $x = explode('-',$_REQUEST['insert_after']);
            $page = (int)$x[0];
            $oid = (int)$x[1];

            if(strcasecmp($_REQUEST['question'],$this->CONF['page_break'])==0)
            {
                //Set error if there is an attempt to make a page break the first question in the survey
                if($page == 0 && $oid == 0)
                { $error[] = 'Cannot insert PAGE BREAK as first question. Please use the drop down to select what question to insert the page break after.'; }
                else
                {
                    $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = page + 1 WHERE sid = $sid AND
                              (page > $page) OR (page = $page AND oid > $oid)";
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $error[] = 'Cannot insert page break: ' . $this->db->ErrorMsg(); }
                    elseif($this->db->Affected_Rows() > 0)
                    { $notice = 'PAGE BREAK inserted successfully.'; }
                    else
                    { $error[] = 'Cannot insert PAGE BREAK as last question.'; }
                }
            }
            else
            {
                //Make sure "first" question is page 1, oid 1,
                //not page 0, oid 0.
                if($page == 0) { $page=1; }

                $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET oid = oid + 1 WHERE sid = $sid AND page = $page AND
                          oid > $oid";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $error[] = 'Error updating OID to insert question: ' . $this->db->ErrorMsg(); }

                //Increment oid, since new question is
                //inserted "after" what was chosen
                //Validate number of answers, number required and orientation for new question
                $oid++;
                $question = $this->SfStr->getSafeString($_REQUEST['question'],SAFE_STRING_DB);
                $num_answers = (int)$_REQUEST['num_answers'];
                $num_required = (int)$_REQUEST['num_required'];
                $aid = (int)$_REQUEST['answer'];

                if($num_required > $num_answers)
                { $error[] = 'Number of required answers cannot exceed the number of answers'; }

                if(in_array($_REQUEST['orientation'],$this->CONF['orientation']))
                { $orientation = $this->SfStr->getSafeString($_REQUEST['orientation'],SAFE_STRING_DB); }
                else
                { $orientation = $thid->SfStr->getSafeString('Vertical',SAFE_STRING_DB); }

                $_SESSION['answer_orientation'] = $_REQUEST['orientation'];

                //If there is no error so far, attempt to process the requested dependencies
                if(empty($error))
                {

                    $dep_insert = '';
                    $dep_require_pagebreak = 0;

                    //check for dependencies
                    if(isset($_REQUEST['option']))
                    {
                        foreach($_REQUEST['option'] as $num=>$option)
                        {
                            if(!empty($option) && !empty($_REQUEST['dep_qid'][$num]) && !empty($_REQUEST['dep_aid'][$num])
                               && in_array($option,$this->CONF['dependency_modes']))
                            {
                                $dep_qid = (int)$_REQUEST['dep_qid'][$num];

                                //Ensure dependencies are based on questions before the question being added
                                $check_query = "SELECT page, oid FROM {$this->CONF['db_tbl_prefix']}questions WHERE qid = $dep_qid";

                                $rs = $this->db->Execute($check_query);
                                if($rs === FALSE)
                                { $error[] = 'Error checking dependencies: ' . $this->db->ErrorMsg(); }

                                while($r = $rs->FetchRow($rs))
                                {
                                    if($r['page'] > $page || ($r['page'] == $page && $r['oid'] > $oid))
                                    { $error[] = "Error: Dependencies can only be based on questions displayed BEFORE the question being added"; }
                                    elseif($r['page'] == $page)
                                    { $dep_require_pagebreak = 1; }
                                }

                                $option = $this->SfStr->getSafeString($option,SAFE_STRING_DB);

                                foreach($_REQUEST['dep_aid'][$num] as $dep_aid)
                                {
                                    $dep_id = $this->db->GenID($this->CONF['db_tbl_prefix'].'dependencies_sequence');
                                    $dep_insert .= "($dep_id,$sid,%%,$dep_qid," . (int)$dep_aid . ",$option), ";
                                }
                            }
                        }
                    }

                    //If no error has occurred, attempt to create new question in database
                    if(empty($error))
                    {
                        //Insert question data into database
                        $qid = $this->db->GenID($this->CONF['db_tbl_prefix'].'questions_sequence');
                        $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}questions (qid, sid, question, aid, num_answers, num_required, page, oid, orientation)
                                  VALUES ($qid, $sid, $question, $aid, $num_answers, $num_required, $page, $oid, $orientation)";
                        $rs = $this->db->Execute($query);
                        if($rs === FALSE)
                        { $error[] = 'Error inserting new question: ' . $this->db->ErrorMsg(); }
                        else
                        {
                            //Create dependencies in database and create page break, if required
                            if(!empty($dep_insert))
                            {
                                $dep_query = "INSERT INTO {$this->CONF['db_tbl_prefix']}dependencies (dep_id,sid,qid,dep_qid,dep_aid,dep_option) VALUES " . substr($dep_insert,0,-2);
                                $dep_query = str_replace('%%',$qid,$dep_query);

                                $rs = $this->db->Execute($dep_query);
                                if($rs === FALSE)
                                { $error[] = 'Error adding dependencies: ' . $this->db->ErrorMsg(); }

                                if($dep_require_pagebreak)
                                {
                                    $query = "UPDATE {$this->CONF['db_tbl_prefix']}questions SET page = page + 1 WHERE sid = $sid AND
                                              (page > $page OR (page = $page AND oid > $oid) OR qid = $qid)";
                                    $rs = $this->db->Execute($query);
                                    if($rs === FALSE)
                                    { $error[] = 'Cannot insert dependency page break: ' . $this->db->ErrorMsg(); }
                                }
                            }

                            $notice = 'Question successfully added to survey.';
                        }
                    }
                }
                else
                { $this->smarty->assign('question',$question); }
            }
        }

        //Set error or success message and redirect to appropriate page
        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=questions");

        if(empty($error))
        {
            if(empty($notice))
            { $notice = 'Question sucessfully added to survey.'; }
            $this->setMessage('Notice',$notice,MSGTYPE_NOTICE);
        }
        else
        { $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // LOAD EXISTING DATA FOR QUESTION BEING EDITED //
    function _loadEditQuestion($sid,$qid)
    {
        $sid = (int)$sid;
        $qid = (int)$qid;

        $error = array();

        $this->data['qid'] = $qid;
        $this->data['sid'] = $sid;

        //Retrieve Question data
        $query = "SELECT q.question, q.aid, q.num_answers, q.num_required, q.page, q.oid, q.orientation, s.survey_text_mode
                  FROM {$this->CONF['db_tbl_prefix']}questions q, {$this->CONF['db_tbl_prefix']}surveys s
                  WHERE q.sid = $sid AND q.sid = s.sid AND qid = $qid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error selecting data for question: ' . $this->db->ErrorMsg()); return; }

        $this->data['question_data'] = $rs->FetchRow($rs);
        $this->data['question_data']['question'] = $this->SfStr->getSafeString($this->data['question_data']['question'],SAFE_STRING_TEXT);

        $key = array_search($this->data['question_data']['orientation'],$this->CONF['orientation']);
        if($key !== FALSE)
        { $this->data['orientation']['selected'][$key] = ' selected'; }

        $this->data['num_answers'] = array("1","2","3","4","5");
        $this->data['num_answers_selected'] = array_fill(0,5,"");
        $this->data['num_answers_selected'][$this->data['question_data']['num_answers']-1] = " selected";

        $this->data['num_required'] = array("0","1","2","3","4","5");
        $this->data['num_required_selected'] = array_fill(0,6,"");
        $this->data['num_required_selected'][$this->data['question_data']['num_required']] = " selected";

        //Retrieve Answer Types from database
        $rs = $this->db->Execute("SELECT aid, name FROM {$this->CONF['db_tbl_prefix']}answer_types WHERE sid = $sid ORDER BY name ASC");
        if($rs === FALSE)
        { $this->error('Unable to retrieve answer types from database: ' . $this->db->ErrorMsg()); return; }

        while ($r = $rs->FetchRow($rs))
        {
            if($r['aid'] == $this->data['question_data']['aid'])
            { $r['selected'] = ' selected'; }
            $r['name'] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
            $this->data['answer'][] = $r;
        }

        //Retrieve existing question numbers
        //for questions BEFORE this one being edited
        //and create Javascript for dependency <select> boxes
        $query = "SELECT q.qid, at.type, av.avid, av.value FROM {$this->CONF['db_tbl_prefix']}questions q,
                  {$this->CONF['db_tbl_prefix']}answer_types at LEFT JOIN {$this->CONF['db_tbl_prefix']}answer_values av
                  ON at.aid = av.aid WHERE q.sid = $sid AND
                  (q.page < {$this->data['question_data']['page']} OR (q.page = {$this->data['question_data']['page']} AND q.oid < {$this->data['question_data']['oid']}))
                  AND q.aid = at.aid ORDER BY page ASC, oid ASC";

        $x = 1;
        $av_count = 0;
        $old_qid = '';
        $this->data['js'] = '';
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error retrieving existing question numbers: ' . $this->db->ErrorMsg()); return;}
        if($r = $rs->FetchRow($rs))
        {
            do
            {
                if($r['type'] != ANSWER_TYPE_N)
                {
                    if($r['type'] == ANSWER_TYPE_S || $r['type'] == ANSWER_TYPE_T)
                    { $x++; }
                    else
                    {
                        if($r['qid'] != $old_qid)
                        {
                            if($av_count)
                            { $this->data['js'] .= "Num_Answers['{$old_qid}'] = '{$av_count}';\n"; }

                            $av_count = 0;
                            $this->data['qnum'][$r['qid']] = $x++;
                            $old_qid = $r['qid'];

                        }

                        $this->data['js'] .= "Answers['{$r['qid']},{$av_count}'] = '{$r['avid']}';\n";
                        $this->data['js'] .= "Values['{$r['qid']},{$av_count}'] = '" . addslashes($r['value']) . "';\n";

                        $av_count++;

                    }
                }
            }while($r = $rs->FetchRow($rs));

            $this->data['js'] .= "Num_Answers['{$old_qid}'] = '{$av_count}';\n";

            if(!empty($this->data['qnum']))
            {
                $this->data['dep_qid'] = array_keys($this->data['qnum']);
                $this->data['dep_qnum'] = array_values($this->data['qnum']);
            }
        }

        //Retrieve existing dependencies for question
        $this->data['dependencies'] = array();
        $query = "SELECT d.dep_id, d.dep_qid, d.dep_option, av.value FROM {$this->CONF['db_tbl_prefix']}dependencies d,
                  {$this->CONF['db_tbl_prefix']}answer_values av WHERE d.dep_aid = av.avid AND d.qid = $qid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Unable to retrieve existing dependencies: ' . $this->db->ErrorMsg()); return; }

        while($r = $rs->FetchRow($rs))
        {
            $this->data['edep']['dep_id'][] = $r['dep_id'];
            $this->data['edep']['option'][] = $r['dep_option'];
            $this->data['edep']['qnum'][] = $this->data['qnum'][$r['dep_qid']];
            $this->data['edep']['value'][] = $this->SfStr->getSafeString($r['value'],$this->data['question_data']['survey_text_mode']);
        }
    }

    // LOAD ACCESS CONTROL SETTINGS FOR SURVEY //
    function _loadAccessControl($sid)
    {
        $sid = (int)$sid;

        //Set default values for access control page/form
        $this->data['mode'] = MODE_ACCESSCONTROL;
        $this->data['actioncolspan'] = 5;
        $this->data['inviteactioncolspan'] = 4;
        $this->data['show']['take_priv'] = FALSE;
        $this->data['show']['results_priv'] = FALSE;
        $this->data['show']['invite'] = FALSE;
        $this->data['show']['survey_limit'] = TRUE;
        $this->data['show']['sentlogininfo'] = FALSE;
        $this->data['show']['clear_completed'] = FALSE;

        $query = "SELECT access_control, hidden, public_results, date_format,
                  survey_limit_times, survey_limit_number, survey_limit_unit
                  FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Unable to retrieve survey access control information: ' . $this->db->ErrorMsg()); return; }
        elseif($r = $rs->FetchRow($rs))
        {
            $this->_loadUsers($sid,$r['access_control'],$r['date_format']);

            $this->data['access_control'] = $this->SfStr->getSafeString($r['access_control'],SAFE_STRING_TEXT);
            if($r['hidden'])
            { $this->data['hidden_checked'] = ' checked'; }
            if($r['public_results'])
            { $this->data['public_results_checked'] = ' checked'; }
            else
            {
                $this->data['show']['results_priv'] = TRUE;
                $this->data['actioncolspan']++;
                $this->data['inviteactioncolspan']++;
            }
            $this->data['survey_limit_times'] = (int)$r['survey_limit_times'];
            $this->data['survey_limit_number'] = (int)$r['survey_limit_number'];
            $this->data['survey_limit_unit'][(int)$r['survey_limit_unit']] = ' selected';

            switch($r['access_control'])
            {
                //set form values based upon what kind of access control is being used for survey
                case AC_COOKIE:
                    $this->data['acs']['cookie'] = ' selected';
                break;

                case AC_IP:
                    $this->data['acs']['ip'] = ' selected';
                    $this->data['show']['clear_completed'] = TRUE;
                break;

                case AC_USERNAMEPASSWORD:
                    $this->data['acs']['usernamepassword'] = ' selected';
                    $this->data['show']['take_priv'] = TRUE;
                    $this->data['actioncolspan']+=2;
                    $this->data['show']['clear_completed'] = TRUE;
                break;

                case AC_INVITATION:
                    $this->data['acs']['invitation'] = ' selected';
                    $this->data['show']['invite'] = TRUE;
                    $this->data['show']['clear_completed'] = TRUE;

                    if(isset($_SESSION['invite_code_type']) && $_SESSION['invite_code_type'] == INVITECODE_WORDS)
                    { $this->data['invite_code_type'][INVITECODE_WORDS] = ' checked'; }
                    else
                    { $this->data['invite_code_type'][INVITECODE_ALPHANUMERIC] = ' checked'; }

                    if(isset($_SESSION['invite_code_length']) && $_SESSION['invite_code_length'] > 0 && $_SESSION['invite_code_length'] <= ALPHANUMERIC_MAXLENGTH)
                    { $this->data['invite_code_length'] = (int)$_SESSION['invite_code_length']; }
                    else
                    { $this->data['invite_code_length'] = ALPHANUMERIC_DEFAULTLENGTH; }

                    $this->data['alphanumeric']['maxlength'] = ALPHANUMERIC_MAXLENGTH;
                    $this->data['alphanumeric']['defaultlength'] = ALPHANUMERIC_DEFAULTLENGTH;
                break;

                case AC_NONE:
                default:
                    $this->data['acs']['none'] = ' selected';
                    $this->data['show']['survey_limit'] = FALSE;
                break;
            }
        }
        else
        { $this->error('Invalid survey. Survey does not exist.'); exit(); }
    }

    function _loadUsers($sid,$access_control,$date_format)
    {
        $sid = (int)$sid;
        $access_control = (int)$access_control;

        $x = 0;
        $y = 0;

        //Load current users for survey from database and add to user list or invite list based
        //upon the access control setting.
        $query = "SELECT u.uid, u.name, u.email, u.username, u.password, u.take_priv, u.results_priv,
                  u.edit_priv, u.status, u.status_date, MAX(cs.completed) AS completed, COUNT(u.uid) AS num_completed, u.invite_code
                  FROM {$this->CONF['db_tbl_prefix']}users u LEFT JOIN {$this->CONF['db_tbl_prefix']}completed_surveys cs ON u.uid = cs.uid
                  WHERE u.sid = $sid GROUP BY u.uid ORDER BY u.name, u.username";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error retrieving users: ' . $this->db->ErrorMsg()); return; }
        elseif($r = $rs->FetchRow($rs))
        {
            do
            {
                //If access control is INVITATION ONLY, then add users with a status of INVITEE or INVITED
                //to the invitee list within $data
                if($access_control == AC_INVITATION && ($r['status'] == USERSTATUS_INVITEE || $r['status'] == USERSTATUS_INVITED))
                {
                    $key = 'invite';
                    $num = &$y;

                    if(!empty($r['invite_code']))
                    { $this->data[$key][$num]['invite_code'] = $this->SfStr->getSafeString($r['invite_code'],SAFE_STRING_TEXT); }
                    else
                    { $this->data[$key][$num]['invite_code'] = '&nbsp;'; }

                    if($r['status'] == USERSTATUS_INVITEE)
                    { $this->data[$key][$num]['status_date'] = 'N'; }
                    elseif($r['status'] == USERSTATUS_INVITED)
                    { $this->data[$key][$num]['status_date'] = date($date_format,$r['status_date']); }

                    if($r['results_priv'])
                    { $this->data[$key][$num]['results_priv'] = ' checked'; }
                }
                else
                {
                //Otherwise add the users to the normal users list
                    $key = 'users';
                    $num = &$x;
                    $this->data[$key][$num]['username'] = $this->SfStr->getSafeString($r['username'],SAFE_STRING_TEXT);
                    $this->data[$key][$num]['password'] = $this->SfStr->getSafeString($r['password'],SAFE_STRING_TEXT);

                    if($access_control == AC_USERNAMEPASSWORD && $r['status'] == USERSTATUS_SENTLOGIN)
                    { $this->data[$key][$num]['status_date'] = date($date_format,$r['status_date']); }
                    else
                    { $this->data[$key][$num]['status_date'] = 'N'; }

                    if($r['take_priv'])
                    { $this->data[$key][$num]['take_priv'] = ' checked'; }
                    if($r['results_priv'])
                    { $this->data[$key][$num]['results_priv'] = ' checked'; }
                    if($r['edit_priv'])
                    { $this->data[$key][$num]['edit_priv'] = ' checked'; }

                }

                //If user has completed a survey, create date and time stamp of
                //last completed time
                if(!empty($r['completed']))
                {
                    $this->data[$key][$num]['completed'] = date($date_format,$r['completed']);
                    $this->data[$key][$num]['num_completed'] = $r['num_completed'];
                }
                else
                {
                    $this->data[$key][$num]['completed'] = '';
                    $this->data[$key][$num]['num_completed'] = '0';
                }

                $this->data[$key][$num]['uid'] = $r['uid'];
                $this->data[$key][$num]['name'] = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
                $this->data[$key][$num]['email'] = $this->SfStr->getSafeString($r['email'],SAFE_STRING_TEXT);

                //Check if previous errors were set for the current User ID. If so, set a flag to the
                //user or invitee row can be highlighted in the template
                if(isset($_SESSION['update_users']['erruid'][$r['uid']]) || isset($_SESSION['invite']['erruid'][$r['uid']]))
                { $this->data[$key][$num]['erruid'] = 1; }

                $num++;
            }while($r = $rs->FetchRow($rs));
        }

        //Create data for five empty rows after existing
        //users and invitees that can be used to create new users or invitees.
        for($z=0;$z<5;$z++)
        {
            $this->data['invite'][$y]['uid'] = 'x'.$z;
            $this->data['invite'][$y]['status_date'] = '&nbsp;';
            $this->data['invite'][$y]['invite_code'] = '&nbsp;';
            $this->data['invite'][$y++]['num_completed'] = '-';
            $this->data['users'][$x]['num_completed'] = '-';
            $this->data['users'][$x]['status_date'] = '&nbsp;';
            $this->data['users'][$x++]['uid'] = 'x'.$z;
        }

        //Remove any error messages that were set for users and invitees
        if(isset($_SESSION['update_users']['erruid']))
        { unset($_SESSION['update_users']['erruid']); }
        if(isset($_SESSION['invite']['erruid']))
        { unset($_SESSION['invite']['erruid']); }
    }

    // PROCESS UPDATING ACCESS CONTROL OPTIONS //
    function _processUpdateAccessControl($sid)
    {
        $sid = (int)$sid;

        $error = array();

        //Validate access control setting.
        $input['access_control'] = (int)$_REQUEST['access_control'];
        if($input['access_control'] < AC_NONE || $input['access_control'] > AC_INVITATION)
        { $input['access_control'] = 0; }

        //Validate whether survey is hidden or note
        if(isset($_REQUEST['hidden']))
        { $input['hidden'] = 1; }
        else
        { $input['hidden'] = 0; }

        //Validate whether results are public or not.
        if(isset($_REQUEST['public_results']))
        { $input['public_results'] = 1; }
        else
        { $input['public_results'] = 0; }

        if($input['access_control'] != AC_NONE && isset($_REQUEST['survey_limit_unit']))
        {
            //Validate any limit placed on the number of times users
            //can complete surveys
            $input['survey_limit_times'] = (int)$_REQUEST['survey_limit_times'];
            $input['survey_limit_number'] = (int)$_REQUEST['survey_limit_number'];
            $input['survey_limit_unit'] = min(3,abs((int)$_REQUEST['survey_limit_unit']));

            switch($_REQUEST['survey_limit_unit'])
            {
                case SL_MINUTES:
                    $input['survey_limit_seconds'] = 60 * $input['survey_limit_number'];
                break;
                case SL_HOURS:
                    $input['survey_limit_seconds'] = 60 * 60 * $input['survey_limit_number'];
                break;
                case SL_DAYS:
                    $input['survey_limit_seconds'] = 60 * 60 * 24 * $input['survey_limit_number'];
                break;
                case SL_EVER:
                default:
                    $input['survey_limit_seconds'] = 0;
                break;
            }

            if(empty($_REQUEST['survey_limit_times']) && !empty($_REQUEST['survey_limit_number']))
            { $error[] = 'Number of times for survey limit is required if number of units is supplied'; }
            elseif(empty($_REQUEST['survey_limit_number']) && !empty($_REQUEST['survey_limit_times']) && $_REQUEST['survey_limit_unit'] != SL_EVER)
            { $error[] = 'Number of units for survey limit is required if number of times is supplied'; }
        }
        else
        {
            //If survey limits cannot be created for this survey because of the
            //access control settings, just set the column equal to themselves so
            //there are no changes to existing values.
            $input['survey_limit_times'] = 'survey_limit_times';
            $input['survey_limit_number'] = 'survey_limit_number';
            $input['survey_limit_unit'] = 'survey_limit_unit';
            $input['survey_limit_seconds'] = 'survey_limit_seconds';
        }

        //Update survey with new access control settings
        if(empty($error))
        {
            $query = "UPDATE {$this->CONF['db_tbl_prefix']}surveys SET access_control = {$input['access_control']},
                    hidden = {$input['hidden']}, public_results = {$input['public_results']},
                    survey_limit_times = {$input['survey_limit_times']}, survey_limit_number = {$input['survey_limit_number']},
                    survey_limit_unit = {$input['survey_limit_unit']}, survey_limit_seconds = {$input['survey_limit_seconds']}
                    WHERE sid = {$sid}";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $error[] = 'Error updating access control: ' . $this->db->ErrorMsg(); }
        }

        //If user choses to reset the completed surveys tracking, then delete any references to
        //the surve in the ip_track and completed_surveys table. Answers provided by users will
        //not be removed, but the system will think the user has completed the survey zero times.
        if(isset($_REQUEST['clear_completed']))
        {
            $tables = array('ip_track','completed_surveys');
            foreach($tables as $tbl)
            {
                $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}{$tbl} WHERE sid = $sid";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $error[] = "Error resetting completed surveys within table $tbl: " . $this->db->ErrorMsg(); }
            }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");

        if(empty($error))
        { $this->setMessage('Notice','Access controls sucessfully updated.',MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // PROCESS UPDATING USER LIST //
    function _processUpdateUsers($sid)
    {
        $sid = (int)$sid;
        $error = array();
        $erruid = array();

        //Retrieve current access control and public results setting for survey
        //to determine what fields are required for users.
        $query = "SELECT access_control, public_results FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $error[2] = 'Unable to retrieve survey access control information: ' . $this->db->ErrorMsg(); }
        else
        {
            $r = $rs->FetchRow($rs);
            $access_control = $r['access_control'];
            $public_results = $r['public_results'];

            //Loop through each user and validate data entered. If the UID passed
            //begins with an 'x', then the data is for a new user
            foreach($_REQUEST['name'] as $uid=>$name)
            {
                if($uid{0} != 'x' || ($uid{0}=='x' && (!empty($_REQUEST['name'][$uid]) || !empty($_REQUEST['email'][$uid]) || !empty($_REQUEST['username'][$uid]) || !empty($_REQUEST['password'][$uid]))))
                {
                    $input = array();
                    //Validate name, email, username and password.
                    $input['name'] = $this->SfStr->getSafeString($_REQUEST['name'][$uid],SAFE_STRING_DB);
                    $input['email'] = $this->SfStr->getSafeString($_REQUEST['email'][$uid],SAFE_STRING_DB);
                    if(empty($_REQUEST['username'][$uid]))
                    {
                        $error[0] = 'Username can not be empty.';
                        $erruid[$uid] = 1;
                    }
                    else
                    { $input['username'] = $this->SfStr->getSafeString($_REQUEST['username'][$uid],SAFE_STRING_DB); }
                    if(empty($_REQUEST['password'][$uid]))
                    {
                        $error[1] = 'Password can not be empty.';
                        $erruid[$uid] = 1;
                    }
                    else
                    { $input['password'] = $this->SfStr->getSafeString($_REQUEST['password'][$uid],SAFE_STRING_DB); }

                    //Validate privileges based upon the access control setting for the survey
                    if($access_control == AC_USERNAMEPASSWORD)
                    {
                        if(isset($_REQUEST['take_priv'][$uid]))
                        { $input['take_priv'] = 1; }
                        else
                        { $input['take_priv'] = 0; }
                    }
                    else
                    { $input['take_priv'] = 'take_priv'; }

                    if($public_results)
                    { $input['results_priv'] = 'results_priv'; }
                    else
                    {
                        if(isset($_REQUEST['results_priv'][$uid]))
                        { $input['results_priv'] = 1; }
                        else
                        { $input['results_priv'] = 0; }
                    }

                    if(isset($_REQUEST['edit_priv'][$uid]))
                    { $input['edit_priv'] = 1; }
                    else
                    { $input['edit_priv'] = 0; }

                    //Insert or Update new user data
                    if(!isset($erruid[$uid]))
                    {
                        if($uid{0} == 'x')
                        {
                            $keyword = 'inserting';
                            $uid = $this->db->GenID($this->CONF['db_tbl_prefix'].'users_sequence');
                            $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}users
                                      (uid, sid, name, email, username, password, take_priv, results_priv, edit_priv) VALUES
                                      ($uid, $sid, {$input['name']}, {$input['email']}, {$input['username']}, {$input['password']},
                                      {$input['take_priv']}, {$input['results_priv']}, {$input['edit_priv']})";
                        }
                        else
                        {
                            $keyword = 'updating';
                            $uid = (int)$uid;
                            $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET name = {$input['name']}, email = {$input['email']},
                                      username = {$input['username']}, password = {$input['password']}, take_priv = {$input['take_priv']},
                                      results_priv = {$input['results_priv']}, edit_priv = {$input['edit_priv']}
                                      WHERE uid = $uid";
                        }

                        $rs = $this->db->Execute($query);
                        if($rs === FALSE)
                        {
                            $error[] = "Error $keyword user information: " . $this->db->ErrorMsg();
                            $erruid[$uid] = 1;
                        }
                    }
                }
            }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");

        if(empty($error))
        { $this->setMessage('Notice','User information updated sucessfully.',MSGTYPE_NOTICE); }
        else
        {
            $_SESSION['update_users']['erruid'] = $erruid;
            $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR);
        }
    }

    // PROCESS SELECTED ACTION ON SELECTED USERS //
    function _processUsersAction($sid)
    {
        switch($_REQUEST['users_selection'])
        {
            //Delete selected users
            case 'delete':
                $this->_processDeleteUsers($sid,@$_REQUEST['users_checkbox']);
            break;
            //Send username and password reminder to user's email address
            case 'remind':
                $this->_processSendLoginInfo($sid,@$_REQUEST['users_checkbox'],'mail_usernamepassword.tpl');
            break;
            //Move selected users to invite list (if access control if INVITATION ONLY)
            case 'movetoinvite':
                $this->_processMoveToList($sid,$_REQUEST['users_checkbox'],USERSTATUS_INVITEE);
            break;
            //Save All Users
            case 'saveall':
            default:
                $this->_processUpdateUsers($sid);
                //$this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");
                //$this->setMessage('Notice','Please choose an action from the dropdown to perform.',MSGTYPE_NOTICE);
            break;
        }
    }

    // DELETE USERS //
    function _processDeleteUsers($sid,$users)
    {
        $sid = (int)$sid;
        $error = array();
        $numdeleted = 0;
        $numtodelete = 0;

        if(!empty($users))
        {
            //Loop through user array and delete users, keeping
            //track of how many were successfully deleted.
            $numtodelete = count($users);

            foreach($users as $uid=>$val)
            {
                if($uid{0} != 'x')
                {
                    $uid = (int)$uid;
                    $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}users WHERE uid=$uid AND sid=$sid";
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $error[] = "Unable to delete user (uid:$uid): " . $this->db->ErrorMsg(); }
                    else
                    { $numdeleted++; }
                }
                else
                { $numtodelete--; }
            }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");

        if(empty($error))
        { $this->setMessage('Notice',"{$numdeleted} of {$numtodelete} users deleted.",MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',"{$numdeleted} of {$numtodelete} users deleted. <br />" . implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // SEND USERNAME AND PASSWORD INFORMATION TO USER //
    function _processSendLoginInfo($sid,$users,$template)
    {
        set_time_limit(120);

        $sid = (int)$sid;
        $error = array();
        $numtoemail = 0;
        $numemailed = 0;

        if(!empty($users))
        {
            //Retrieve settings for survey
            $query = "SELECT * FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $error[] = 'Unable to retrieve survey information: ' . $this->db->ErrorMsg(); }
            elseif($survey = $rs->FetchRow($rs))
            {
                //Set variables to be used in mail templates
                $survey['main_url'] = $this->CONF['html'];
                $survey['take_url'] = $this->CONF['html'] . "/survey.php?sid=$sid";
                $survey['results_url'] = $this->CONF['html'] . "/results.php?sid=$sid";
                $survey['edit_url'] = $this->CONF['html'] . "/edit_survey.php?sid=$sid";

                $this->smarty->assign_by_ref('survey',$survey);
                $user = array();
                $this->smarty->assign_by_ref('user',$user);

                $numtoemail = count($users);

                //Loop through each user and create reminder email.
                foreach($users as $uid=>$val)
                {
                    if($uid{0} != 'x')
                    {
                        $uid = (int)$uid;

                        //Retrieve user information
                        $query = "SELECT * FROM {$this->CONF['db_tbl_prefix']}users WHERE sid=$sid AND uid=$uid";
                        $rs = $this->db->Execute($query);
                        if($rs === FALSE)
                        { $error[] = "Unable to get user information (uid:$uid): " . $this->db->ErrorMsg(); }
                        elseif($user = $rs->FetchRow($rs))
                        {
                            //Ensure user has an email set
                            if(!empty($user['email']))
                            {
                                //If user has permission to view results, set flag
                                //to show results URL in email
                                if($survey['public_results'])
                                { $user['results_priv'] = 1; }

                                //Retrieve email text
                                $mail = $this->_parseEmailTemplate($survey,$user,$template);

                                //Send email and update status of user to show they were
                                //sent a login reminder
                                if(!empty($mail))
                                {
                                    $send = @mail($mail['to'],$mail['subject'],$mail['message'],$mail['headers']);
                                    if($send)
                                    {
                                        $numemailed++;
                                        $now = time();
                                        $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET status = ".USERSTATUS_SENTLOGIN.", status_date = {$now} WHERE uid=$uid AND sid=$sid";
                                        $rs = $this->db->Execute($query);
                                        if($rs === FALSE)
                                        { $error[] = "Unable to update user status (uid:$uid): " . $this->db->ErrorMsg(); }
                                    }
                                    else
                                    { $error[] = "Unable to send email to &quot;{$user['name']}&quot; at &quot;{$user['email']}&quot; for unknown reason."; }
                                }
                            }
                            else
                            { $error[] = "Username &quot;{$user['username']}&quot; does not have an email address."; }
                        }
                    }
                    else
                    { $numtoemail--; }
                }
            }
            else
            { $error[] = 'Invalid survey.'; }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");
        $msg = "{$numemailed} of {$numtoemail} users emailed. ";

        if(empty($error))
        { $this->setMessage('Notice',$msg,MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',$msg.'<br />'.implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // PARSE EMAIL TEMPLATE //
    function _parseEmailTemplate(&$survey, &$user, $template)
    {
        $retval = array();

        //Fetch selected email template
        if($template{0} != '/')
        { $template = '/' . $template; }
        $template = $survey['template'] . $template;

        $emailtext = $this->smarty->Fetch($template);

        //Split email on HEADER_SEPERATOR. Lines before seperator are used as
        //headers for the email and text after the seperator is the body of the email.
        //This allows you to create customized headers for the emails from
        //within the template
        if(preg_match('/(.*)('.preg_quote(HEADER_SEPERATOR).')(.*)/s',$emailtext,$match))
        {
            $retval['headers'] = $match[1];
            $retval['message'] = $match[3];

            //Extract To: and Subject: headers from mail template.
            //If headers do not exist, set a default
            if(preg_match('/^To:(.*)$/im',$retval['headers'],$to))
            {
                $retval['to'] = trim($to[1]);
                $retval['headers'] = preg_replace("/^To:.*\r?\n/im",'',$retval['headers']);
            }
            else
            { $retval['to'] = $user['email']; }

            if(preg_match('/^Subject:(.*)$/im',$retval['headers'],$subject))
            {
                $retval['subject'] = trim($subject[1]);
                $retval['headers'] = preg_replace("/^Subject:.*\r?\n/im",'',$retval['headers']);
            }
            else
            { $retval['subject'] = 'Survey Information'; }
        }

        return $retval;
    }

    // MOVE USERS TO/FROM USER/INVITEE LIST //
    function _processMoveToList($sid,$users,$status)
    {
        $sid = (int)$sid;
        $error = array();
        $numtomove = 0;
        $nummoved = 0;

        //Loop through users and update status to match what was passed.
        //Setting status to USERSTATUS_INVITEE or USERTATUS_INVITED will place
        //the user on the Invitee list, while setting to USERSTATUS_NONE will
        //put the user on the User list.
        if(!empty($users))
        {
            $numtomove = count($users);

            foreach($users as $uid=>$val)
            {
                if($uid{0} != 'x')
                {
                    $uid = (int)$uid;
                    $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET status=$status WHERE uid=$uid AND sid=$sid";
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $error[] = "Unable to move user (uid:$uid): " . $this->db->ErrorMsg(); }
                    else
                    { $nummoved++; }
                }
                else
                { $numtomove--; }
            }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");
        $msg = "{$nummoved} of {$numtomove} users moved. ";

        if(empty($error))
        { $this->setMessage('Notice',$msg,MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',$msg.'<br />'.implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // PROCESS CHANGES TO INVITEE LIST //
    function _processUpdateInvite($sid)
    {
        $error = array();
        $erruid = array();

        $_SESSION['invite_code_type'] = $_REQUEST['invite_code_type'];
        $_SESSION['invite_code_length'] = $_REQUEST['invite_code_length'];

        //Loop through invitees and validate data. If the first character
        //of UID is 'x', then the information is for a new invitee
        if(!empty($_REQUEST['invite_name']))
        {
            foreach($_REQUEST['invite_name'] as $uid=>$name)
            {
                if($uid{0} != 'x' || ($uid{0} == 'x' && (!empty($_REQUEST['invite_name'][$uid]) || !empty($_REQUEST['invite_email'][$uid]))))
                {
                    //Validate email address (required)
                    if(empty($_REQUEST['invite_email'][$uid]))
                    {
                        $error[1] = 'Email address is required for invitee.';
                        $erruid[$uid] = 1;
                    }
                    elseif(strlen($_REQUEST['invite_email'][$uid])<5 || strpos($_REQUEST['invite_email'][$uid],'@')===FALSE)
                    {
                        $error[2] = 'Incorrect email address format.';
                        $erruid[$uid] = 1;
                    }
                    else
                    { $input['email'] = $this->SfStr->getSafeString($_REQUEST['invite_email'][$uid],SAFE_STRING_DB); }

                    //Validate name and set status to INVITEE
                    $input['name'] = $this->SfStr->getSafeString($_REQUEST['invite_name'][$uid],SAFE_STRING_DB);
                    $input['status'] = USERSTATUS_INVITEE;

                    if(isset($_REQUEST['invite_results_priv'][$uid]))
                    { $input['results_priv'] = 1; }
                    else
                    { $input['results_priv'] = 0; }

                    //If there were no errors, INSERT or UPDATE invitee information
                    if(!isset($erruid[$uid]))
                    {
                        if($uid{0}=='x')
                        {
                            $uid = $this->db->GenID($this->CONF['db_tbl_prefix'].'users_sequence');
                            $query = "INSERT INTO {$this->CONF['db_tbl_prefix']}users (uid, sid, name, email, status, results_priv)
                                      VALUES ($uid, $sid, {$input['name']}, {$input['email']}, {$input['status']},{$input['results_priv']})";
                        }
                        else
                        {
                            $uid = (int)$uid;
                            $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET name = {$input['name']},
                                      email = {$input['email']}, results_priv = {$input['results_priv']}
                                      WHERE uid=$uid AND sid=$sid";
                        }

                        $rs = $this->db->Execute($query);
                        if($rs === FALSE)
                        { $error[] = 'Error updating/inserting invitee: ' . $this->db->ErrorMsg(); }
                    }
                }
            }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");

        if(empty($error))
        { $this->setMessage('Notice','Invitees added/updated',MSGTYPE_NOTICE); }
        else
        {
            $_SESSION['invite']['erruid'] = $erruid;
            $this->setMessage('Error',implode('<br />',$error),MSGTYPE_ERROR);
        }
    }

    // PROCESS SELECTED ACTION ON SELECTED INVITEES //
    function _processInviteAction($sid)
    {
        $sid = (int)$sid;

        $_SESSION['invite_code_type'] = $_REQUEST['invite_code_type'];
        $_SESSION['invite_code_length'] = $_REQUEST['invite_code_length'];


        switch($_REQUEST['invite_selection'])
        {
            //Delete selected invitees
            case 'delete':
                $this->_processDeleteUsers($sid,@$_REQUEST['invite_checkbox']);
            break;
            //Send invitation code to selected invitees
            case 'invite':
                $this->_processSendInvitation($sid,@$_REQUEST['invite_checkbox'],'mail_invitation.tpl');
            break;
            //Move invitees to User list
            case 'movetousers':
                $this->_processMoveToList($sid,@$_REQUEST['invite_checkbox'],USERSTATUS_NONE);
            break;
            //Save all invitees
            case 'saveall':
            default:
                $this->_processUpdateInvite($sid);
                //$this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");
                //$this->setMessage('Notice','Please choose an invite action from the dropdown.',MSGTYPE_NOTICE);
            break;
        }
    }

    // SEND EMAIL INVITATION CODE TO INVITEES //
    function _processSendInvitation($sid,$users,$template)
    {
        @set_time_limit(120);

        $sid = (int)$sid;
        $error = array();
        $numtoemail = 0;
        $numemailed = 0;

        //Loop through invitees
        if(!empty($users))
        {
            $query = "SELECT * FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid=$sid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $error[] = 'Unable to retrieve survey information: ' . $this->db->ErrorMsg(); }
            elseif($survey = $rs->FetchRow($rs))
            {
                //Create variables to be used in email template
                $survey['main_url'] = $this->CONF['html'];
                $survey['take_url'] = $this->CONF['html'] . "/survey.php?sid=$sid";
                $survey['results_url'] = $this->CONF['html'] . "/results.php?sid=$sid";

                $this->smarty->assign_by_ref('survey',$survey);
                $user = array();
                $this->smarty->assign_by_ref('user',$user);

                $numtoemail = count($users);

                $uid_list = '';
                foreach($users as $uid=>$val)
                {
                    if($uid{0} != 'x')
                    { $uid_list .= (int)$uid . ','; }
                    else
                    { $numtoemail--; }
                }

                if(!empty($uid_list))
                {
                    $uid_list = substr($uid_list,0,-1);

                    //Retrieve information for selected invitee
                    $query = "SELECT * FROM {$this->CONF['db_tbl_prefix']}users WHERE sid=$sid AND uid IN ($uid_list) AND (status = " . USERSTATUS_INVITEE . ' OR status = ' . USERSTATUS_INVITED . ')';
                    $rs = $this->db->Execute($query);
                    if($rs === FALSE)
                    { $error[] = 'Unable to get invitee information: ' . $this->db->ErrorMsg(); }
                    else
                    {
                        $now = time();
                        while($user = $rs->FetchRow($rs))
                        {
                            if(!empty($user['email']))
                            {
                                //Set flag for whether user has privileges to view results
                                if($survey['public_results'])
                                { $user['results_priv'] = 1; }

                                //Retreive random code for user to access survey
                                //and set URL to take survey to be used in email
                                $user['code'] = $this->_getInviteCode($sid,$user['uid'],$_REQUEST['invite_code_type'],$_REQUEST['invite_code_length']);
                                $user['take_url'] = $survey['take_url'] . '&invite_code=' . urlencode($user['code']);

                                //Retrieve email template
                                $mail = $this->_parseEmailTemplate($survey,$user,$template);

                                if(!empty($mail) && $user['code'])
                                {
                                    //Send email and update invitee status to INVITED
                                    $send = @mail($mail['to'],$mail['subject'],$mail['message'],$mail['headers']);
                                    if($send)
                                    {
                                        $numemailed++;
                                        $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET take_priv = 1, status = ".USERSTATUS_INVITED.", status_date = {$now} WHERE uid={$user['uid']} AND sid=$sid";
                                        $rs2 = $this->db->Execute($query);
                                        if($rs2 === FALSE)
                                        { $error[] = "Unable to update invitee status (uid:{$user['uid']}): " . $this->db->ErrorMsg(); }
                                    }
                                    else
                                    { $error[] = "Unable to send invitation to &quot;{$user['name']}&quot; at &quot;{$user['email']}&quot; for unknown reason."; }
                                }
                                else
                                { $error[] = "Unable to get invitation template and/or code for inviteee (uid:{$user['uid']})."; }
                            }
                            else
                            { $error[] = "Username &quot;{$user['username']}&quot; does not have an email address."; }
                        }
                    }
                }
            }
            else
            { $error[] = 'Invalid survey.'; }
        }

        $this->setMessageRedirect("edit_survey.php?sid=$sid&mode=access_control");
        $msg = "{$numemailed} of {$numtoemail} users sent invitations.";

        if(empty($error))
        { $this->setMessage('Notice',$msg,MSGTYPE_NOTICE); }
        else
        { $this->setMessage('Error',$msg.'<br />'.implode('<br />',$error),MSGTYPE_ERROR); }
    }

    // GENERATE RANDOM INVITATION CODE FOR INVITEES //
    function _getInviteCode($sid,$uid,$type,$length)
    {
        static $recursion_level = 0;
        $recursion_limit = 10;
        $code = FALSE;

        //Try at least 10 times to create a random invitation code
        //that's not already being used for this survey
        while(!$code && $recursion_level <= $recursion_limit)
        {
            //Retrieve either a english word code or
            //alphanumeric code.
            switch($type)
            {
                case INVITECODE_WORDS:
                    $code = $this->_getWordCode();
                break;
                case INVITECODE_ALPHANUMERIC:
                default:
                    $code = $this->_getAlphanumericCode($length);
                break;
            }

            //Ensure code is not already being used in this survey.
            if($code)
            {
                $dbcode = $this->SfStr->getSafeString($code,SAFE_STRING_DB);
                $query = "SELECT invite_code FROM {$this->CONF['db_tbl_prefix']}users WHERE sid=$sid AND invite_code={$dbcode}";
                $rs = $this->db->Execute($query);
                if($rs === FALSE)
                { $this->error('Error checking for duplicate code: ' . $this->db->ErrorMsg()); return FALSE; }
                elseif($r = $rs->FetchRow($rs))
                {
                    fwrite($this->fp,"Code {$code} already in use ($sid:$uid)\r\n");
                    $code = FALSE;
                    $recursion_level++;
                }
            }
        }

        $recursion_level = 0;

        //Update user information to include the code that was chosen
        if($code)
        {
            $query = "UPDATE {$this->CONF['db_tbl_prefix']}users SET invite_code = {$dbcode} WHERE sid=$sid AND uid=$uid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error("Error updating invitation code for invitee (uid:$uid): " . $this->db->ErrorMsg()); return FALSE; }
        }

        return $code;
    }

    // GENERATE ALPHANUMERIC RANDOM INVITATION CODE //
    function _getAlphanumericCode($length)
    {
        $retval = '';
        static $values = '';
        static $numvalues = 0;

        $length = (int)$length;
        if($length <= 0 || $length > ALPHANUMERIC_MAXLENGTH)
        { $length = ALPHANUMERIC_DEFAULTLENGTH; }

        //Create code from the values in $str for the requested length
        if(empty($values))
        {
            $str = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";
            $values = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
            $numvalues = count($values);
        }

        for($x=0;$x<$length;$x++)
        { $retval .= $values[mt_rand(0,$numvalues)]; }

        return $retval;
    }

    // GENERATE ENGLISH WORD CODE //
    function _getWordCode()
    {
        $retval = '';
        $chosenwords = array();

        //Select a number of words from the following file
        //to create an invitation code
        $file = $this->CONF['path'].'/utils/words.txt';
        $fp = fopen($file,'r');
        $fsize = filesize($file);

        for($x=0;$x<WORDCODE_NUMWORDS;$x++)
        {
            //Select random position in file and seek backwards until
            //a newline or beginning of file is hit. In either case, grab
            //the current line as the random word
            $pos = mt_rand(0,$fsize);
            fseek($fp,$pos);
            while(fgetc($fp) != "\n" && $pos != 0)
            { fseek($fp,--$pos); }
            $chosenwords[] = trim(fgets($fp));
        }

        return implode(WORDCODE_SEPERATOR,$chosenwords);
    }

}

?>