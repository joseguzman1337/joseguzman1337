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

class UCCASS_Special_Results extends UCCASS_Main
{
    function UCCASS_Special_Results()
    {
        $this->load_configuration();

        //Increase time limit of script to 2 minutes to ensure
        //very large results can be shown or exported
        set_time_limit(120);
    }

    function results_table($sid)
    {
        $sid = (int)$sid;

        if(!$this->_CheckAccess($sid,RESULTS_PRIV,"results_table.php?sid=$sid"))
        {
            switch($this->_getAccessControl($sid))
            {
                case AC_INVITATION:
                    return $this->showInvite('results_table.php',array('sid'=>$sid));
                break;
                case AC_USERNAMEPASSWORD:
                default:
                    return $this->showLogin('results_table.php',array('sid'=>$sid));
                break;
            }
        }

        $data = array();
        $qid = array();
        $survey = array();

        $survey['sid'] = $sid;

        $query = "SELECT q.qid, q.question, s.name, s.user_text_mode, s.survey_text_mode, s.date_format
                  FROM {$this->CONF['db_tbl_prefix']}questions q, {$this->CONF['db_tbl_prefix']}surveys s
                  WHERE q.sid = $sid and s.sid = q.sid ORDER BY q.page, q.oid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error in query: ' . $this->db->ErrorMsg()); return; }

        $questions = array();
        if($r = $rs->FetchRow($rs))
        {
            $survey_text_mode = $r['survey_text_mode'];
            $user_text_mode = $r['user_text_mode'];
            $date_format = $r['date_format'];
            $survey['name'] = $this->SfStr->getSafeString($r['name'],$survey_text_mode);

            do{
                $data['questions'][] = $this->SfStr->getSafeString($r['question'],$survey_text_mode);
                $qid[$r['qid']] = $r['qid'];
            }while($r = $rs->FetchRow($rs));
        }
        else
        { $this->error('No questions for this survey.'); return; }

        if(isset($_SESSION['filter_text'][$sid]) && isset($_SESSION['filter'][$sid]) && strlen($_SESSION['filter_text'][$sid])>0)
        { $this->smarty->assign_by_ref('filter_text',$_SESSION['filter_text'][$sid]); }
        else
        { $_SESSION['filter'][$sid] = ''; }

        $query = "SELECT GREATEST(rt.qid, r.qid) AS qid, GREATEST(rt.sequence, r.sequence) AS seq,
                  GREATEST(rt.entered,r.entered) AS entered,
                  q.question, av.value, rt.answer FROM {$this->CONF['db_tbl_prefix']}questions q LEFT JOIN {$this->CONF['db_tbl_prefix']}results
                  r ON q.qid = r.qid LEFT JOIN {$this->CONF['db_tbl_prefix']}results_text rt ON q.qid = rt.qid LEFT JOIN
                  {$this->CONF['db_tbl_prefix']}answer_values av ON r.avid = av.avid WHERE q.sid = $sid {$_SESSION['filter'][$sid]}
                  ORDER BY seq, q.page, q.oid";

        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error in query: ' . $this->db->ErrorMsg()); return; }

        $seq = '';
        $x = -1;
        while($r = $rs->FetchRow($rs))
        {
            if(!empty($r['qid']))
            {
                if($seq != $r['seq'])
                {
                    $x++;
                    $seq = $r['seq'];
                    $answers[$x]['date'] = date($date_format,$r['entered']);
                }
                if(isset($answers[$x][$r['qid']]))
                { $answers[$x][$r['qid']] .= MULTI_ANSWER_SEPERATOR . $this->SfStr->getSafeString($r['value'] . $r['answer'],$user_text_mode); }
                else
                { $answers[$x][$r['qid']] = $this->SfStr->getSafeString($r['value'] . $r['answer'],$user_text_mode); }
            }
            $last_date = date($date_format,$r['entered']);
        }
        $answers[$x]['date'] = $last_date;

        $xvals = array_keys($answers);

        foreach($xvals as $x)
        {
            foreach($qid as $qid_value)
            {
                if(isset($answers[$x][$qid_value]))
                { $data['answers'][$x][] = $answers[$x][$qid_value]; }
                else
                { $data['answers'][$x][] = '&nbsp;'; }
            }
            $data['answers'][$x][] = $answers[$x]['date'];
        }

        $this->smarty->assign_by_ref('data',$data);
        $this->smarty->assign_by_ref('survey',$survey);
        return $this->smarty->fetch($this->template.'/results_table.tpl');
    }

    function results_csv($sid, $export_type=EXPORT_CSV_TEXT)
    {
        $sid = (int)$sid;


        $retval = '';

        if(!$this->_CheckAccess($sid,RESULTS_PRIV,"results_csv.php?sid=$sid"))
        {
            switch($this->_getAccessControl($sid))
            {
                case AC_INVITATION:
                    return $this->showInvite('results_csv.php',array('sid'=>$sid));
                break;
                case AC_USERNAMEPASSWORD:
                default:
                    return $this->showLogin('results_csv.php',array('sid'=>$sid));
                break;
            }
        }

        header("Content-Type: text/plain; charset={$this->CONF['charset']}");
        header("Content-Disposition: attachment; filename=Export.csv");

        $query = "SELECT q.qid, q.question, s.date_format
                  FROM {$this->CONF['db_tbl_prefix']}questions q, {$this->CONF['db_tbl_prefix']}surveys s
                  WHERE q.sid = $sid and s.sid = q.sid ORDER BY q.page, q.oid";
        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error in query: ' . $this->db->ErrorMsg()); return; }

        $questions = array();
        if($r = $rs->FetchRow($rs))
        {
            $date_format = $r['date_format'];
            do{
                $questions[$r['qid']] = $r['question'];
            }while($r = $rs->FetchRow($rs));
        }
        else
        { $this->error('No questions for this survey'); return; }

        if(isset($_SESSION['filter_text'][$sid]) && isset($_SESSION['filter'][$sid]) && strlen($_SESSION['filter_text'][$sid])>0)
        { $this->smarty->assign_by_ref('filter_text',$_SESSION['filter_text'][$sid]); }
        else
        { $_SESSION['filter'][$sid] = ''; }


        $query = "SELECT GREATEST(rt.qid, r.qid) AS qid, GREATEST(rt.sequence, r.sequence) AS seq,
                  GREATEST(rt.entered, r.entered) AS entered,
                  q.question, av.value, av.numeric_value, rt.answer FROM {$this->CONF['db_tbl_prefix']}questions q LEFT JOIN {$this->CONF['db_tbl_prefix']}results
                  r ON q.qid = r.qid LEFT JOIN {$this->CONF['db_tbl_prefix']}results_text rt ON q.qid = rt.qid LEFT JOIN
                  {$this->CONF['db_tbl_prefix']}answer_values av ON r.avid = av.avid WHERE q.sid = $sid {$_SESSION['filter'][$sid]}
                  ORDER BY seq, q.page, q.oid";

        $rs = $this->db->Execute($query);
        if($rs === FALSE)
        { $this->error('Error in query: ' . $this->db->ErrorMsg()); return; }

        $seq = '';
        $x = 0;
        while($r = $rs->FetchRow($rs))
        {
            if(!empty($r['qid']))
            {
                if($seq != $r['seq'])
                {
                    $x++;
                    $seq = $r['seq'];
                    $answers[$x]['date'] = date($date_format,$r['entered']);
                }

                switch($export_type)
                {
                    case EXPORT_CSV_NUMERIC:
                        if(empty($r['answer']))
                        { $value = $r['numeric_value']; }
                        else
                        { $value = $r['answer']; }
                    break;

                    case EXPORT_CSV_TEXT:
                    default:
                        if(empty($r['answer']))
                        { $value = $r['value']; }
                        else
                        { $value = $r['answer']; }
                    break;
                }

                if(isset($answers[$x][$r['qid']]))
                { $answers[$x][$r['qid']] .= MULTI_ANSWER_SEPERATOR . $value; }
                else
                { $answers[$x][$r['qid']] = $value; }
            }
            $last_date = date($date_format,$r['entered']);
        }
        $answers[$x]['date'] = $last_date;

        $line = '';
        foreach($questions as $question)
        { $line .= "\"" . str_replace('"','""',$question) . "\","; }
        $retval .= $line . "Datetime\n";

        $xvals = array_keys($answers);

        foreach($xvals as $x)
        {
            $line = '';
            foreach($questions as $qid=>$question)
            {
                if(isset($answers[$x][$qid]))
                {
                    if(is_numeric($answers[$x][$qid]))
                    { $line .= "{$answers[$x][$qid]},"; }
                    else
                    { $line .= "\"" . str_replace('"','""',$answers[$x][$qid]) . "\","; }
                }
                else
                { $line .= ","; }
            }
            $retval .= $line . '"' . $answers[$x]['date'] . "\"\n";
        }

        return $retval;
    }
}

?>