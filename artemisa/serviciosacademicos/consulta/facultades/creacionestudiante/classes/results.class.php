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

class UCCASS_Results extends UCCASS_Main
{
    function UCCASS_Results()
    { $this->load_configuration(); }

    /*************************
    * VIEW RESULTS OF SURVEY *
    *************************/
    function survey_results($sid=0)
    {
        $sid = (int)$sid;

        if(!$this->_CheckAccess($sid,RESULTS_PRIV,"results.php?sid=$sid"))
        {
            switch($this->_getAccessControl($sid))
            {
                case AC_INVITATION:
                    return $this->showInvite('results.php',array('sid'=>$sid));
                break;
                case AC_USERNAMEPASSWORD:
                default:
                    return $this->showLogin('results.php',array('sid'=>$sid));
                break;
            }
        }

        if($sid <= 0)
        { $this->error("Invalid Survey ID"); return; }

        //defaults
        $q_num = 1;

        //Retrieve survey information
        $rs = $this->db->Execute("SELECT name, survey_text_mode
                                  FROM {$this->CONF['db_tbl_prefix']}surveys WHERE sid = $sid");
        if($rs === FALSE) { $this->error('Error retrieving survey information: ' . $this->db->ErrorMsg()); return; }
        if($r = $rs->FetchRow($rs))
        {
            $survey['name'] = $this->SfStr->getSafeString($r['name'],$r['survey_text_mode']);
            $survey['sid'] = $sid;
            $survey['survey_text_mode'] = $r['survey_text_mode'];

            //Set class variable of name to use outside of function
            $this->survey_name = $this->SfStr->getSafeString($r['name'],SAFE_STRING_TEXT);
        }
        else
        { $this->error("Survey $sid does not exist"); return; }


        //if viewing answers to single
        //question with text box
        if(isset($_REQUEST['qid']))
        { return $this->survey_results_text($sid,$_REQUEST['qid']); }
        elseif(isset($_SESSION['results']['page']))
        { unset($_SESSION['results']['page']); }

        //Set defaults for show/hide questions
        $hide_show_where = '';
        $survey['hide_show_questions'] = TRUE;
        $survey['show_all_questions'] = FALSE;

        //Retrieve hide/show question status
        //from session if it's present
        if(isset($_SESSION['hide-show'][$sid]))
        {
            $hide_show_where = $_SESSION['hide-show'][$sid];
            $survey['show_all_questions'] = TRUE;
            $survey['hide_show_questions'] = FALSE;
        }

        $survey['required'] = $this->smarty->fetch($this->template.'/question_required.tpl');

        if(isset($_REQUEST['results_action']))
        {
            $retval = $this->process_results_action($sid);
            if($_REQUEST['action'] == 'filter')
            { return $retval; }
        }

        if(isset($_REQUEST['filter_submit']))
        { $this->process_filter($sid); }
        elseif(!isset($_SESSION['filter'][$sid]))
        {
            $_SESSION['filter'][$sid] = '';
            $_SESSION['filter_total'][$sid] = '';
        }

        $x = 0;

        $survey['quittime']['minutes'] = 0;
        $survey['quittime']['seconds'] = 0;
        $survey['avgtime']['minutes']  = 0;
        $survey['avgtime']['seconds']  = 0;
        $survey['mintime']['minutes']  = 0;
        $survey['mintime']['seconds']  = 0;
        $survey['maxtime']['minutes']  = 0;
        $survey['maxtime']['seconds']  = 0;

        $sql = "SELECT r.quitflag, AVG(r.elapsed_time) AS avgtime, MIN(r.elapsed_time) AS mintime, MAX(r.elapsed_time) AS maxtime
                FROM {$this->CONF['db_tbl_prefix']}time_limit r WHERE r.sid = $sid {$_SESSION['filter'][$sid]}
                GROUP BY r.quitflag";
        $rs = $this->db->Execute($sql);
        if($rs === FALSE) {$this->error('Error getting average, min and max survey times: ' . $this->db->ErrorMsg()); return; }
        while($r = $rs->FetchRow($rs))
        {
            if($r['quitflag'])
            {
                $survey['quittime']['minutes'] = floor($r['avgtime'] / 60);
                $survey['quittime']['seconds'] = $r['avgtime'] % 60;
            }
            else
            {
                $survey['avgtime']['minutes'] = floor($r['avgtime'] / 60);
                $survey['avgtime']['seconds'] = $r['avgtime'] % 60;
                $survey['mintime']['minutes'] = floor($r['mintime'] / 60);
                $survey['mintime']['seconds'] = $r['mintime'] % 60;
                $survey['maxtime']['minutes'] = floor($r['maxtime'] / 60);
                $survey['maxtime']['seconds'] = $r['maxtime'] % 60;
            }
        }

        //retrieve questions
        $sql = "SELECT q.qid, q.question, q.num_required, q.aid, a.type, a.label, COUNT(r.qid) AS r_total, COUNT(rt.qid) AS rt_total
                FROM {$this->CONF['db_tbl_prefix']}questions q LEFT JOIN {$this->CONF['db_tbl_prefix']}results r
                  ON q.qid = r.qid LEFT JOIN {$this->CONF['db_tbl_prefix']}results_text rt ON q.qid = rt.qid,
                  {$this->CONF['db_tbl_prefix']}answer_types a
                WHERE q.sid = $sid and q.aid = a.aid
                  and ((q.qid = r.qid AND NOT ".$this->db->IfNull('rt.qid',0).") OR (q.qid = rt.qid AND NOT ".$this->db->IfNull('r.qid',0).")
                  OR (NOT ".$this->db->IfNull('r.qid',0)." AND NOT ".$this->db->IfNull('rt.qid',0)."))
                  $hide_show_where {$_SESSION['filter_total'][$sid]}
                GROUP BY q.qid
                ORDER BY q.page, q.oid";
        $rs = $this->db->Execute($sql);
        if($rs === FALSE) { $this->error("Error retrieving questions: " . $this->db->ErrorMsg()); return;}

        while($r = $rs->FetchRow($rs))
        {
            $qid[$x] = $r['qid'];
            $question[$x] = nl2br($this->SfStr->getSafeString($r['question'],$survey['survey_text_mode']));
            $num_answers[$x] = max($r['r_total'],$r['rt_total']);

            if($r['num_required']>0)
            { $num_required[$x] = $r['num_required']; }

            if($r['type'] != "N")
            { $question_num[$x] = $q_num++; }
            $type[$x] = $r['type'];
            switch($r['type'])
            {
                case "MM":
                case "MS":
                    $answer[$x] = $this->get_answer_values($r['aid'],BY_AID,$survey['survey_text_mode']);
                    $count[$x] = array_fill(0,count($answer[$x]['avid']),0);
                    $show['numanswers'][$x] = TRUE;
                break;

                case "T":
                case "S":
                    $text[$x] = $r['qid'];
                    $show['numanswers'][$x] = TRUE;
                break;

                case 'N':
                    $show['numanswers'][$x] = FALSE;
                break;
            }
            $x++;
        }

        //retrieve answers to questions
        $sql = "SELECT r.qid, r.avid, count(*) AS c FROM {$this->CONF['db_tbl_prefix']}results r,
                {$this->CONF['db_tbl_prefix']}answer_values av,
                {$this->CONF['db_tbl_prefix']}questions q
                WHERE r.qid = q.qid and r.sid = $sid and r.avid = av.avid $hide_show_where
                {$_SESSION['filter'][$sid]}
                GROUP BY r.qid, r.avid
                ORDER BY r.avid ASC";
        $rs = $this->db->Execute($sql);
        if($rs === FALSE) { $this->error("Error retrieving answers: " . $this->db->ErrorMsg()); return;}
        while($r = $rs->FetchRow($rs))
        {
            $key = array_search($r['qid'],$qid);
            if($key !== FALSE)
            {
                $k = array_search($r['avid'],$answer[$key]['avid']);
                if($k !== FALSE)
                { $count[$key][$k] = $r['c']; }
            }
        }

        //Filter text has already had safe_string() applied
        if(isset($_SESSION['filter_text'][$sid]) && strlen($_SESSION['filter_text'][$sid])>0)
        { $this->smarty->assign('filter_text',$_SESSION['filter_text'][$sid]); }
        if(strlen($_SESSION['filter'][$sid])>0)
        {
            $show['clear_filter'] = TRUE;
            $this->smarty->assign('show',$show);
        }

        if(isset($count) && count($count) > 0)
        {
            foreach($count as $key=>$value)
            {
                $total[$key] = array_sum($count[$key]);
                foreach($count[$key] as $k=>$v)
                {
                    if($total[$key] > 0)
                    { $p = 100 * $v / $total[$key]; }
                    else
                    { $p = 0; }
                    $percent[$key][$k] = sprintf('%2.2f',$p);
                    $width[$key][$k] = round($this->CONF['image_width'] * $p/100);

                    $img_size = getimagesize($this->CONF['images_path'] . '/' . $answer[$key]['image'][$k]);
                    $height[$key][$k] = $img_size[1];

                    //Check for _left image (beginning of bar)
                    $img = $answer[$key]['image'][$k];
                    $last_period = strrpos($img,'.');

                    $left_img = substr($img,0,$last_period) . '_left' . substr($img,$last_period);
                    $right_img = substr($img,0,$last_period) . '_right' . substr($img,$last_period);

                    if(file_exists($this->CONF['images_path'] . '/' . $left_img))
                    { $answer[$key]['left_image'][$k] = $left_img; }

                    if(file_exists($this->CONF['images_path'] . '/' . $right_img))
                    { $answer[$key]['right_image'][$k] = $right_img; }

                    $show[$key]['middle_image'][$k] = FALSE;
                    if(isset($answer[$key]['left_image'][$k]) && isset($answer[$key]['right_image'][$k]))
                    { $show[$key]['left_right_image'][$k] = TRUE; }
                    else
                    {
                        if(isset($answer[$key]['left_image'][$k]))
                        { $show[$key]['left_image'][$k] = TRUE; }
                        elseif(isset($answer[$key]['left_image'][$k]))
                        { $show[$key]['right_image'][$k] = TRUE; }
                        else
                        {
                            $show[$key]['left_right_image'][$k] = FALSE;
                            $show[$key]['left_image'][$k] = FALSE;
                            $show[$key]['right_image'][$k] = FALSE;
                            $show[$key]['middle_image'][$k] = TRUE;
                        }
                    }
                }
            }
        }

        $survey['export_csv_text'] = EXPORT_CSV_TEXT;
        $survey['export_csv_numeric'] = EXPORT_CSV_NUMERIC;

        $this->smarty->assign_by_ref('survey',$survey);
        $this->smarty->assign_by_ref('question',$question);
        $this->smarty->assign_by_ref('qid',$qid);
        $this->smarty->assign_by_ref('question_num',$question_num);

        if(isset($num_required))
        { $this->smarty->assign_by_ref('num_required',$num_required); }
        if(isset($answer))
        { $this->smarty->assign_by_ref('answer',$answer); }
        if(isset($num_answers))
        { $this->smarty->assign_by_ref('num_answers',$num_answers); }
        if(isset($count))
        { $this->smarty->assign_by_ref('count',$count); }
        if(isset($text))
        { $this->smarty->assign_by_ref('text',$text); }
        if(isset($total))
        { $this->smarty->assign_by_ref('total',$total);}
        if(isset($percent))
        { $this->smarty->assign_by_ref('percent',$percent); }
        if(isset($width))
        { $this->smarty->assign_by_ref('width',$width); }
        if(isset($height))
        { $this->smarty->assign_by_ref('height',$height); }
        if(isset($show))
        { $this->smarty->assign_by_ref('show',$show); }

        $retval = $this->smarty->fetch($this->template.'/results.tpl');

        if(empty($_SESSION['filter'][$sid]) && isset($_SESSION['filter_text'][$sid]))
        { unset($_SESSION['filter_text'][$sid]); }

        return $retval;
    }

    /********************
    * VIEW TEXT RESULTS *
    ********************/
    function survey_results_text($sid,$qid)
    {
        $sid = (int)$sid;
        $qid = (int)$qid;

        $answer['delete_access'] = $this->_hasPriv(EDIT_PRIV,$sid) | $this->_hasPriv(ADMIN_PRIV);

        if(!empty($_REQUEST['delete_rid']) && $answer['delete_access'])
        {
            $rid_list = '';
            foreach($_REQUEST['delete_rid'] as $rid)
            { $rid_list .= (int)$rid . ','; }
            $rid_list = substr($rid_list,0,-1);
            $query = "DELETE FROM {$this->CONF['db_tbl_prefix']}results_text WHERE rid IN ($rid_list) AND sid = $sid AND qid = $qid";
            $rs = $this->db->Execute($query);
            if($rs === FALSE)
            { $this->error('Error deleting checked answers: ' . $this->db->ErrorMsg()); return; }
        }

        $rs = $this->db->Execute("SELECT q.question, a.type, s.survey_text_mode, s.user_text_mode
                                  FROM {$this->CONF['db_tbl_prefix']}questions q, {$this->CONF['db_tbl_prefix']}answer_types a,
                                  {$this->CONF['db_tbl_prefix']}surveys s
                                  WHERE q.sid = $sid AND q.qid = $qid AND q.sid = s.sid
                                  AND q.aid = a.aid AND a.type IN ('T','S')");
        if($rs === FALSE) { return $this->error("Unable to select question: " . $this->db->ErrorMsg()); }
        if($r = $rs->FetchRow($rs))
        { $question = nl2br($this->SfStr->getSafeString($r['question'],$r['survey_text_mode'])); }
        else
        { return $this->error("Question $qid does not exist for survey $sid or is not the correct type (Text or Sentence)"); }

        $survey_text_mode = $r['survey_text_mode'];
        $user_text_mode = $r['user_text_mode'];

        if(!isset($_SESSION['results']['page']))
        { $_SESSION['results']['page'] = 0; }

        if(isset($_REQUEST['clear']))
        {
            unset($_REQUEST['search']);
            unset($_SESSION['results']['search']);
            $_SESSION['results']['page'] = 0;
        }

        if(isset($_REQUEST['search']) && strlen($_REQUEST['search']) > 0)
        {
            $answer['search_text'] = $this->SfStr->getSafeString($_REQUEST['search'],SAFE_STRING_TEXT);

            $search = " AND answer LIKE '%{$answer['search_text']}%' ";
            $button['clear'] = TRUE;

            if(!isset($_SESSION['results']['search']) || $_REQUEST['search'] != $_SESSION['results']['search'])
            {
                $_SESSION['results']['page'] = 0;
                $_SESSION['results']['search'] = $_REQUEST['search'];
            }
        }
        else
        { $search = ''; }

        if(isset($_REQUEST['next']))
        { $_SESSION['results']['page']++; }
        elseif(isset($_REQUEST['prev']) && $_SESSION['results']['page'] > 0)
        { $_SESSION['results']['page']--; }

        if(isset($_REQUEST['per_page']))
        {
            $per_page = (int)$_REQUEST['per_page'];
            $selected[$per_page] = " selected";
        }
        else
        { $per_page = $this->CONF['text_results_per_page']; }

        $start = $per_page * $_SESSION['results']['page'];

        $rs = $this->db->Execute("SELECT COUNT(*) AS c FROM {$this->CONF['db_tbl_prefix']}results_text r WHERE qid = $qid
                                  $search {$_SESSION['filter'][$sid]}");
        if($rs === FALSE)
        { return $this->error("Error getting count of answers: " . $this->db->ErrorMsg()); }
        $r = $rs->FetchRow($rs);
        $answer['num_answers'] = $r['c'];

        $rs = $this->db->SelectLimit("SELECT rid, answer FROM {$this->CONF['db_tbl_prefix']}results_text r WHERE qid = $qid
                                  $search {$_SESSION['filter'][$sid]} ORDER BY entered DESC",$per_page,$start);
        if($rs === FALSE)
        { return $this->error("Error selecting answers: " . $this->db->ErrorMsg()); }

        $answer['text'] = array();
        $answer['rid'] = array();
        $answer['num'] = array();
        $answer['delete_access'] = $answer['num_answers'] && $answer['delete_access'];
        $cnt = 0;

        while($r = $rs->FetchRow($rs))
        {
            $answer['num'][] = $answer['num_answers'] - $start - $cnt++;
            $answer['text'][] = $this->SfStr->getSafeString($r['answer'],$user_text_mode);
            $answer['rid'][] = $r['rid'];
        }

        if(($start + $per_page) >= $answer['num_answers'])
        { $button['next'] = FALSE; }
        else
        { $button['next'] = TRUE; }

        if($_SESSION['results']['page'] == 0)
        { $button['previous'] = FALSE; }
        else
        { $button['previous'] = TRUE; }


        $qnum = (int)$_REQUEST['qnum'];

        $this->smarty->assign('question',$question);
        $this->smarty->assign('qnum',$qnum);

        if(isset($answer))
        { $this->smarty->assign_by_ref('answer',$answer); }

        $this->smarty->assign('sid',$sid);
        $this->smarty->assign('qid',$qid);
        $this->smarty->assign('button',$button);

        $retval = $this->smarty->fetch($this->template.'/results_text.tpl');
        return $retval;
    }

    /**********************
    * DISPLAY FILTER FORM *
    **********************/
    function filter($sid)
    {
        $x = 0;
        $qid_list = '';

        foreach($_REQUEST['select_qid'] as $qid)
        { $qid_list .= (int)$qid . ','; }
        $qid_list = substr($qid_list,0,-1);

        $query = "SELECT at.aid, q.qid, q.question, s.survey_text_mode
                  FROM {$this->CONF['db_tbl_prefix']}answer_types at,
                  {$this->CONF['db_tbl_prefix']}questions q, {$this->CONF['db_tbl_prefix']}surveys s
                  WHERE q.aid = at.aid AND q.sid = $sid AND q.qid IN ($qid_list) AND at.type IN ('MM','MS')
                  AND q.sid = s.sid
                  ORDER BY q.page, q.oid";
        $rs = $this->db->Execute($query);

        $old_aid = '';
        if($rs === FALSE) { $this->error("Error selecting filter questions: " . $this->db->ErrorMsg()); }
        if($r = $rs->FetchRow())
        {
            do
            {
                $question['question'][] = nl2br($this->SfStr->getSafeString($r['question'],$r['survey_text_mode']));
                $question['encquestion'][] = $this->SfStr->getSafeString($r['question'],SAFE_STRING_TEXT);
                $question['aid'][] = $r['aid'];
                $question['qid'][] = $r['qid'];
                $temp = $this->get_answer_values($r['aid'],BY_AID,$r['survey_text_mode']);
                $question['value'][] = $temp['value'];
                $question['avid'][] = $temp['avid'];
                $x++;
            }while($r = $rs->FetchRow());
            $this->smarty->assign("question",$question);
        }
        $rs = $this->db->Execute("SELECT MIN(entered) AS mindate,
                                  MAX(entered) AS maxdate FROM
                                  {$this->CONF['db_tbl_prefix']}results WHERE sid = $sid");
        if($rs === FALSE) { $this->error("Error selecting min/max survey dates: " . $this->db->ErrorMsg()); }
        $r = $rs->FetchRow();
        $date['min'] = date('Y-m-d',$r['mindate']);
        $date['max'] = date('Y-m-d',$r['maxdate']);

        $this->smarty->assign('date',$date);


        $this->smarty->assign('sid',$sid);

        $retval = $this->smarty->fetch($this->template.'/filter.tpl');

        return $retval;
    }

    /**********************
    * PROCESS FILTER FORM *
    **********************/
    function process_filter($sid)
    {
        $sid = (int)$sid;

        //Determine sequence filter for results queries
        $_SESSION['filter'][$sid] = '';
        $_SESSION['filter_total'][$sid] = '';
        $_SESSION['filter_text'][$sid] = '';

        $where = '';
        $having = '';
        $criteria = array();
        $num_criteria = 0;
        $num_dates = 0;

        if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter']))
        {
            $_SESSION['filter_text'][$sid] = '';
            $_SESSION['filter_total'][$sid] = '';
            foreach($_REQUEST['filter'] as $filter_qid=>$value)
            {
                if(is_array($value))
                {
                    $answer_values = $this->get_answer_values($filter_qid,BY_QID,$survey['survey_text_mode']);
                    $selected_answers = '';
                    $avid_list = '';
                    foreach($value as $avid)
                    {
                        if(isset($answer_values[$avid]))
                        {
                            $selected_answers .= $answer_values[$avid] . ', ';
                            $avid_list .= $avid . ',';
                        }
                    }
                    $selected_answers = $this->SfStr->getSafeString(substr($selected_answers,0,-2),$survey['survey_text_mode']);
                    $avid_list = substr($avid_list,0,-1);
                    $criteria[] = "(q.qid = $filter_qid AND r.avid IN ({$avid_list}))";

                    $question_text = $this->SfStr->getSafeString($_REQUEST['name'][$filter_qid],$survey['survey_text_mode'],1);

                    $_SESSION['filter_text'][$sid] .= "{$question_text} => $selected_answers<br>";
                }
            }

            if($num_criteria = count($criteria))
            {
                $where .= ' AND (' . implode(' OR ',$criteria) . ')';
                $having = " having c = {$num_criteria}";
            }
        }

        if(isset($_REQUEST['date_filter']))
        {
            if(!empty($_REQUEST['start_date']))
            {
                if($start_date = strtotime($_REQUEST['start_date'] . ' 00:00:01'))
                {
                    $where .= " AND r.entered > $start_date ";
                    $start_date = $this->SfStr->getSafeString($_REQUEST['start_date'],SAFE_STRING_TEXT);
                    $_SESSION['filter_text'][$sid] .= "Start Date: {$start_date}<br />";
                    $num_dates++;
                }
            }
            if(!empty($_REQUEST['end_date']))
            {
                if($end_date = strtotime($_REQUEST['end_date'] . ' 23:59:59'))
                {
                    $where .= " AND r.entered < $end_date ";
                    $end_date = $this->SfStr->getSafeString($_REQUEST['end_date'],SAFE_STRING_TEXT);
                    $_SESSION['filter_text'][$sid] .= "End Date: {$end_date}<br />";
                    $num_dates++;
                }
            }
        }

        if($num_criteria || $num_dates)
        {
            $sql = "SELECT r.sequence, count(*) as c from {$this->CONF['db_tbl_prefix']}results r,
                {$this->CONF['db_tbl_prefix']}questions q where
                r.qid = q.qid {$where} group by sequence {$having}";

            $rs = $this->db->Execute($sql);
            if($rs === FALSE) { return $this->error("Error selecting sequences: " . $this->db->ErrorMsg()); }

            $sequence = array();
            while($r = $rs->FetchRow($rs))
            { $sequence[] = $r['sequence']; }

            if($num = count($sequence))
            {
                if($num > $this->CONF['filter_limit'])
                {
                    $seq_list = implode(',',$sequence);

                    $_SESSION['filter'][$sid] = " AND r.sequence IN ($seq_list) ";
                    $_SESSION['filter_total'][$sid] = " AND (r.sequence IN ($seq_list) OR rt.sequence IN ($seq_list) OR (NOT ".$this->db->IfNull('r.sequence',0)." AND NOT ".$this->db->IfNull('rt.sequence',0).")) ";
                }
                else
                { $_SESSION['filter_text'][$sid] = "<span class=\"error\">Number of completed surveys matching filter is below the Filter Limit set in the configuration. Showing all results.</span><br>\n"; }
            }
            else
            { $_SESSION['filter_text'][$sid] = "<span class=\"error\">Filter criteria did not match any records. Showing all results.</span><br>"; }
        }
        else
        {
            $_SESSION['filter'][$sid] = '';
            $_SESSION['filter_total'][$sid] = '';
        }

        //Redirect back to results page with proper filter set
        header("Location: {$this->CONF['html']}/results.php?sid=$sid");
        exit();
    }

    function process_results_action($sid)
    {
        $sid = (int)$sid;
        $redirect = TRUE;
        $retval = '';

        switch($_REQUEST['action'])
        {
            case "hide_questions":
            case "show_questions":
                if(isset($_REQUEST['select_qid']) && !empty($_REQUEST['select_qid']))
                {
                    $list = '';
                    foreach($_REQUEST['select_qid'] as $select_qid)
                    { $list .= (int)$select_qid . ','; }

                    $not = '';
                    if($_REQUEST['action'] == 'hide_questions')
                    { $not = 'NOT'; }

                    $hide_show_where = " AND q.qid $not IN (" . substr($list,0,-1) . ') ';
                    $_SESSION['hide-show'][$sid] = $hide_show_where;
                }
            break;

            case "show_all_questions":
                $hide_show_where = '';
                unset($_SESSION['hide-show'][$sid]);
            break;

            case "filter":
                if(isset($_REQUEST['select_qid']) && !empty($_REQUEST['select_qid']))
                {
                    $retval = $this->filter($sid);
                    $redirect = FALSE;
                }
            break;

            case "clear_filter":
                $_SESSION['filter'][$sid] = '';
                $_SESSION['filter_total'][$sid] = '';
                $_SESSION['filter_text'][$sid] = '';
            break;
        }

        if($redirect)
        {
            header("Location: {$this->CONF['html']}/results.php?sid=$sid");
            exit();
        }
        else
        { return $retval; }
    }

}
?>