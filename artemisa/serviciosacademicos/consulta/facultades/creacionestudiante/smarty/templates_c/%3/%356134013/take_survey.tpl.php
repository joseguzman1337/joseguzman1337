<?php /* Smarty version 2.3.0, created on 2008-04-16 12:26:00
         compiled from Default/take_survey.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'default', 'Default/take_survey.tpl', 43, false),)); ?><form method="POST" action="../../encuesta2/survey.php">
  <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['survey']['sid']; ?>
">

  <table width="70%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"></td>
      <td >Encuesta : <?php echo $this->_tpl_vars['survey']['name']; ?>
</td>
      <td width="14"></td>
    </tr>
  </table>

  <table width="70%" align="center" >
    <tr>
      <td>

        
        <?php if (isset($this->_sections["message"])) unset($this->_sections["message"]);
$this->_sections["message"]['name'] = "message";
$this->_sections["message"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["message"]['show'] = (bool)$this->_tpl_vars['message'];
$this->_sections["message"]['max'] = $this->_sections["message"]['loop'];
$this->_sections["message"]['step'] = 1;
$this->_sections["message"]['start'] = $this->_sections["message"]['step'] > 0 ? 0 : $this->_sections["message"]['loop']-1;
if ($this->_sections["message"]['show']) {
    $this->_sections["message"]['total'] = $this->_sections["message"]['loop'];
    if ($this->_sections["message"]['total'] == 0)
        $this->_sections["message"]['show'] = false;
} else
    $this->_sections["message"]['total'] = 0;
if ($this->_sections["message"]['show']):

            for ($this->_sections["message"]['index'] = $this->_sections["message"]['start'], $this->_sections["message"]['iteration'] = 1;
                 $this->_sections["message"]['iteration'] <= $this->_sections["message"]['total'];
                 $this->_sections["message"]['index'] += $this->_sections["message"]['step'], $this->_sections["message"]['iteration']++):
$this->_sections["message"]['rownum'] = $this->_sections["message"]['iteration'];
$this->_sections["message"]['index_prev'] = $this->_sections["message"]['index'] - $this->_sections["message"]['step'];
$this->_sections["message"]['index_next'] = $this->_sections["message"]['index'] + $this->_sections["message"]['step'];
$this->_sections["message"]['first']      = ($this->_sections["message"]['iteration'] == 1);
$this->_sections["message"]['last']       = ($this->_sections["message"]['iteration'] == $this->_sections["message"]['total']);
?>
          <div class="message"><?php echo $this->_tpl_vars['message']; ?>
</div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["error"])) unset($this->_sections["error"]);
$this->_sections["error"]['name'] = "error";
$this->_sections["error"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["error"]['show'] = (bool)$this->_tpl_vars['error'];
$this->_sections["error"]['max'] = $this->_sections["error"]['loop'];
$this->_sections["error"]['step'] = 1;
$this->_sections["error"]['start'] = $this->_sections["error"]['step'] > 0 ? 0 : $this->_sections["error"]['loop']-1;
if ($this->_sections["error"]['show']) {
    $this->_sections["error"]['total'] = $this->_sections["error"]['loop'];
    if ($this->_sections["error"]['total'] == 0)
        $this->_sections["error"]['show'] = false;
} else
    $this->_sections["error"]['total'] = 0;
if ($this->_sections["error"]['show']):

            for ($this->_sections["error"]['index'] = $this->_sections["error"]['start'], $this->_sections["error"]['iteration'] = 1;
                 $this->_sections["error"]['iteration'] <= $this->_sections["error"]['total'];
                 $this->_sections["error"]['index'] += $this->_sections["error"]['step'], $this->_sections["error"]['iteration']++):
$this->_sections["error"]['rownum'] = $this->_sections["error"]['iteration'];
$this->_sections["error"]['index_prev'] = $this->_sections["error"]['index'] - $this->_sections["error"]['step'];
$this->_sections["error"]['index_next'] = $this->_sections["error"]['index'] + $this->_sections["error"]['step'];
$this->_sections["error"]['first']      = ($this->_sections["error"]['iteration'] == 1);
$this->_sections["error"]['last']       = ($this->_sections["error"]['iteration'] == $this->_sections["error"]['total']);
?>
          <div class="error"><?php echo $this->_tpl_vars['error']; ?>
</div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["page"])) unset($this->_sections["page"]);
$this->_sections["page"]['name'] = "page";
$this->_sections["page"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["page"]['show'] = (bool)$this->_tpl_vars['show']['page_num'];
$this->_sections["page"]['max'] = $this->_sections["page"]['loop'];
$this->_sections["page"]['step'] = 1;
$this->_sections["page"]['start'] = $this->_sections["page"]['step'] > 0 ? 0 : $this->_sections["page"]['loop']-1;
if ($this->_sections["page"]['show']) {
    $this->_sections["page"]['total'] = $this->_sections["page"]['loop'];
    if ($this->_sections["page"]['total'] == 0)
        $this->_sections["page"]['show'] = false;
} else
    $this->_sections["page"]['total'] = 0;
if ($this->_sections["page"]['show']):

            for ($this->_sections["page"]['index'] = $this->_sections["page"]['start'], $this->_sections["page"]['iteration'] = 1;
                 $this->_sections["page"]['iteration'] <= $this->_sections["page"]['total'];
                 $this->_sections["page"]['index'] += $this->_sections["page"]['step'], $this->_sections["page"]['iteration']++):
$this->_sections["page"]['rownum'] = $this->_sections["page"]['iteration'];
$this->_sections["page"]['index_prev'] = $this->_sections["page"]['index'] - $this->_sections["page"]['step'];
$this->_sections["page"]['index_next'] = $this->_sections["page"]['index'] + $this->_sections["page"]['step'];
$this->_sections["page"]['first']      = ($this->_sections["page"]['iteration'] == 1);
$this->_sections["page"]['last']       = ($this->_sections["page"]['iteration'] == $this->_sections["page"]['total']);
?>
          <div>
            P&aacute;gina <?php echo $this->_tpl_vars['survey']['page']; ?>
 de <?php echo $this->_tpl_vars['survey']['total_pages']; ?>

          </div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["time_limit"])) unset($this->_sections["time_limit"]);
$this->_sections["time_limit"]['name'] = "time_limit";
$this->_sections["time_limit"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["time_limit"]['show'] = (bool)$this->_tpl_vars['survey']['time_limit'];
$this->_sections["time_limit"]['max'] = $this->_sections["time_limit"]['loop'];
$this->_sections["time_limit"]['step'] = 1;
$this->_sections["time_limit"]['start'] = $this->_sections["time_limit"]['step'] > 0 ? 0 : $this->_sections["time_limit"]['loop']-1;
if ($this->_sections["time_limit"]['show']) {
    $this->_sections["time_limit"]['total'] = $this->_sections["time_limit"]['loop'];
    if ($this->_sections["time_limit"]['total'] == 0)
        $this->_sections["time_limit"]['show'] = false;
} else
    $this->_sections["time_limit"]['total'] = 0;
if ($this->_sections["time_limit"]['show']):

            for ($this->_sections["time_limit"]['index'] = $this->_sections["time_limit"]['start'], $this->_sections["time_limit"]['iteration'] = 1;
                 $this->_sections["time_limit"]['iteration'] <= $this->_sections["time_limit"]['total'];
                 $this->_sections["time_limit"]['index'] += $this->_sections["time_limit"]['step'], $this->_sections["time_limit"]['iteration']++):
$this->_sections["time_limit"]['rownum'] = $this->_sections["time_limit"]['iteration'];
$this->_sections["time_limit"]['index_prev'] = $this->_sections["time_limit"]['index'] - $this->_sections["time_limit"]['step'];
$this->_sections["time_limit"]['index_next'] = $this->_sections["time_limit"]['index'] + $this->_sections["time_limit"]['step'];
$this->_sections["time_limit"]['first']      = ($this->_sections["time_limit"]['iteration'] == 1);
$this->_sections["time_limit"]['last']       = ($this->_sections["time_limit"]['iteration'] == $this->_sections["time_limit"]['total']);
?>
          <div>
            Tiempo Limite: <?php echo $this->_tpl_vars['survey']['time_limit']; ?>
 minutos. Approximate Elapsed Time: <?php echo $this->_tpl_vars['survey']['elapsed_minutes']; ?>
:<?php echo $this->_tpl_vars['survey']['elapsed_seconds']; ?>

          </div>
        <?php endfor; endif; ?>

        <br />

        
        <?php if (isset($this->_sections["welcome"])) unset($this->_sections["welcome"]);
$this->_sections["welcome"]['name'] = "welcome";
$this->_sections["welcome"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["welcome"]['show'] = (bool)$this->_run_mod_handler('default', true, $this->_tpl_vars['show']['welcome'], FALSE);
$this->_sections["welcome"]['max'] = $this->_sections["welcome"]['loop'];
$this->_sections["welcome"]['step'] = 1;
$this->_sections["welcome"]['start'] = $this->_sections["welcome"]['step'] > 0 ? 0 : $this->_sections["welcome"]['loop']-1;
if ($this->_sections["welcome"]['show']) {
    $this->_sections["welcome"]['total'] = $this->_sections["welcome"]['loop'];
    if ($this->_sections["welcome"]['total'] == 0)
        $this->_sections["welcome"]['show'] = false;
} else
    $this->_sections["welcome"]['total'] = 0;
if ($this->_sections["welcome"]['show']):

            for ($this->_sections["welcome"]['index'] = $this->_sections["welcome"]['start'], $this->_sections["welcome"]['iteration'] = 1;
                 $this->_sections["welcome"]['iteration'] <= $this->_sections["welcome"]['total'];
                 $this->_sections["welcome"]['index'] += $this->_sections["welcome"]['step'], $this->_sections["welcome"]['iteration']++):
$this->_sections["welcome"]['rownum'] = $this->_sections["welcome"]['iteration'];
$this->_sections["welcome"]['index_prev'] = $this->_sections["welcome"]['index'] - $this->_sections["welcome"]['step'];
$this->_sections["welcome"]['index_next'] = $this->_sections["welcome"]['index'] + $this->_sections["welcome"]['step'];
$this->_sections["welcome"]['first']      = ($this->_sections["welcome"]['iteration'] == 1);
$this->_sections["welcome"]['last']       = ($this->_sections["welcome"]['iteration'] == $this->_sections["welcome"]['total']);
?>
          <div><?php echo $this->_tpl_vars['survey']['welcome_text']; ?>
</div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["question"])) unset($this->_sections["question"]);
$this->_sections["question"]['name'] = "question";
$this->_sections["question"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["question"]['show'] = (bool)$this->_run_mod_handler('default', true, $this->_tpl_vars['show']['question'], FALSE);
$this->_sections["question"]['max'] = $this->_sections["question"]['loop'];
$this->_sections["question"]['step'] = 1;
$this->_sections["question"]['start'] = $this->_sections["question"]['step'] > 0 ? 0 : $this->_sections["question"]['loop']-1;
if ($this->_sections["question"]['show']) {
    $this->_sections["question"]['total'] = $this->_sections["question"]['loop'];
    if ($this->_sections["question"]['total'] == 0)
        $this->_sections["question"]['show'] = false;
} else
    $this->_sections["question"]['total'] = 0;
if ($this->_sections["question"]['show']):

            for ($this->_sections["question"]['index'] = $this->_sections["question"]['start'], $this->_sections["question"]['iteration'] = 1;
                 $this->_sections["question"]['iteration'] <= $this->_sections["question"]['total'];
                 $this->_sections["question"]['index'] += $this->_sections["question"]['step'], $this->_sections["question"]['iteration']++):
$this->_sections["question"]['rownum'] = $this->_sections["question"]['iteration'];
$this->_sections["question"]['index_prev'] = $this->_sections["question"]['index'] - $this->_sections["question"]['step'];
$this->_sections["question"]['index_next'] = $this->_sections["question"]['index'] + $this->_sections["question"]['step'];
$this->_sections["question"]['first']      = ($this->_sections["question"]['iteration'] == 1);
$this->_sections["question"]['last']       = ($this->_sections["question"]['iteration'] == $this->_sections["question"]['total']);
?>
          <div><?php echo $this->_tpl_vars['question_text']; ?>
</div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["thank_you"])) unset($this->_sections["thank_you"]);
$this->_sections["thank_you"]['name'] = "thank_you";
$this->_sections["thank_you"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["thank_you"]['show'] = (bool)$this->_run_mod_handler('default', true, $this->_tpl_vars['show']['thank_you'], FALSE);
$this->_sections["thank_you"]['max'] = $this->_sections["thank_you"]['loop'];
$this->_sections["thank_you"]['step'] = 1;
$this->_sections["thank_you"]['start'] = $this->_sections["thank_you"]['step'] > 0 ? 0 : $this->_sections["thank_you"]['loop']-1;
if ($this->_sections["thank_you"]['show']) {
    $this->_sections["thank_you"]['total'] = $this->_sections["thank_you"]['loop'];
    if ($this->_sections["thank_you"]['total'] == 0)
        $this->_sections["thank_you"]['show'] = false;
} else
    $this->_sections["thank_you"]['total'] = 0;
if ($this->_sections["thank_you"]['show']):

            for ($this->_sections["thank_you"]['index'] = $this->_sections["thank_you"]['start'], $this->_sections["thank_you"]['iteration'] = 1;
                 $this->_sections["thank_you"]['iteration'] <= $this->_sections["thank_you"]['total'];
                 $this->_sections["thank_you"]['index'] += $this->_sections["thank_you"]['step'], $this->_sections["thank_you"]['iteration']++):
$this->_sections["thank_you"]['rownum'] = $this->_sections["thank_you"]['iteration'];
$this->_sections["thank_you"]['index_prev'] = $this->_sections["thank_you"]['index'] - $this->_sections["thank_you"]['step'];
$this->_sections["thank_you"]['index_next'] = $this->_sections["thank_you"]['index'] + $this->_sections["thank_you"]['step'];
$this->_sections["thank_you"]['first']      = ($this->_sections["thank_you"]['iteration'] == 1);
$this->_sections["thank_you"]['last']       = ($this->_sections["thank_you"]['iteration'] == $this->_sections["thank_you"]['total']);
?>
          <div><?php echo $this->_tpl_vars['survey']['thank_you_text']; ?>
</div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["quit"])) unset($this->_sections["quit"]);
$this->_sections["quit"]['name'] = "quit";
$this->_sections["quit"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["quit"]['show'] = (bool)$this->_run_mod_handler('default', true, $this->_tpl_vars['show']['quit'], FALSE);
$this->_sections["quit"]['max'] = $this->_sections["quit"]['loop'];
$this->_sections["quit"]['step'] = 1;
$this->_sections["quit"]['start'] = $this->_sections["quit"]['step'] > 0 ? 0 : $this->_sections["quit"]['loop']-1;
if ($this->_sections["quit"]['show']) {
    $this->_sections["quit"]['total'] = $this->_sections["quit"]['loop'];
    if ($this->_sections["quit"]['total'] == 0)
        $this->_sections["quit"]['show'] = false;
} else
    $this->_sections["quit"]['total'] = 0;
if ($this->_sections["quit"]['show']):

            for ($this->_sections["quit"]['index'] = $this->_sections["quit"]['start'], $this->_sections["quit"]['iteration'] = 1;
                 $this->_sections["quit"]['iteration'] <= $this->_sections["quit"]['total'];
                 $this->_sections["quit"]['index'] += $this->_sections["quit"]['step'], $this->_sections["quit"]['iteration']++):
$this->_sections["quit"]['rownum'] = $this->_sections["quit"]['iteration'];
$this->_sections["quit"]['index_prev'] = $this->_sections["quit"]['index'] - $this->_sections["quit"]['step'];
$this->_sections["quit"]['index_next'] = $this->_sections["quit"]['index'] + $this->_sections["quit"]['step'];
$this->_sections["quit"]['first']      = ($this->_sections["quit"]['iteration'] == 1);
$this->_sections["quit"]['last']       = ($this->_sections["quit"]['iteration'] == $this->_sections["quit"]['total']);
?>
          <div>
            Usted ha abandonado esta encuesta. Sus respuestas no fueron salvadas.
          </div>
        <?php endfor; endif; ?>

        
        <?php if (isset($this->_sections["main_url"])) unset($this->_sections["main_url"]);
$this->_sections["main_url"]['name'] = "main_url";
$this->_sections["main_url"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["main_url"]['show'] = (bool)$this->_run_mod_handler('default', true, $this->_tpl_vars['show']['main_url'], FALSE);
$this->_sections["main_url"]['max'] = $this->_sections["main_url"]['loop'];
$this->_sections["main_url"]['step'] = 1;
$this->_sections["main_url"]['start'] = $this->_sections["main_url"]['step'] > 0 ? 0 : $this->_sections["main_url"]['loop']-1;
if ($this->_sections["main_url"]['show']) {
    $this->_sections["main_url"]['total'] = $this->_sections["main_url"]['loop'];
    if ($this->_sections["main_url"]['total'] == 0)
        $this->_sections["main_url"]['show'] = false;
} else
    $this->_sections["main_url"]['total'] = 0;
if ($this->_sections["main_url"]['show']):

            for ($this->_sections["main_url"]['index'] = $this->_sections["main_url"]['start'], $this->_sections["main_url"]['iteration'] = 1;
                 $this->_sections["main_url"]['iteration'] <= $this->_sections["main_url"]['total'];
                 $this->_sections["main_url"]['index'] += $this->_sections["main_url"]['step'], $this->_sections["main_url"]['iteration']++):
$this->_sections["main_url"]['rownum'] = $this->_sections["main_url"]['iteration'];
$this->_sections["main_url"]['index_prev'] = $this->_sections["main_url"]['index'] - $this->_sections["main_url"]['step'];
$this->_sections["main_url"]['index_next'] = $this->_sections["main_url"]['index'] + $this->_sections["main_url"]['step'];
$this->_sections["main_url"]['first']      = ($this->_sections["main_url"]['iteration'] == 1);
$this->_sections["main_url"]['last']       = ($this->_sections["main_url"]['iteration'] == $this->_sections["main_url"]['total']);
?>
          <div style="text-align:center">
            <br />
            [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">INICIO</a> ]
          </div>
        <?php endfor; endif; ?>

        
          <div style="text-align:right">
        <!--     <?php if (isset($this->_sections["quit"])) unset($this->_sections["quit"]);
$this->_sections["quit"]['name'] = "quit";
$this->_sections["quit"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["quit"]['show'] = (bool)$this->_tpl_vars['show']['quit_button'];
$this->_sections["quit"]['max'] = $this->_sections["quit"]['loop'];
$this->_sections["quit"]['step'] = 1;
$this->_sections["quit"]['start'] = $this->_sections["quit"]['step'] > 0 ? 0 : $this->_sections["quit"]['loop']-1;
if ($this->_sections["quit"]['show']) {
    $this->_sections["quit"]['total'] = $this->_sections["quit"]['loop'];
    if ($this->_sections["quit"]['total'] == 0)
        $this->_sections["quit"]['show'] = false;
} else
    $this->_sections["quit"]['total'] = 0;
if ($this->_sections["quit"]['show']):

            for ($this->_sections["quit"]['index'] = $this->_sections["quit"]['start'], $this->_sections["quit"]['iteration'] = 1;
                 $this->_sections["quit"]['iteration'] <= $this->_sections["quit"]['total'];
                 $this->_sections["quit"]['index'] += $this->_sections["quit"]['step'], $this->_sections["quit"]['iteration']++):
$this->_sections["quit"]['rownum'] = $this->_sections["quit"]['iteration'];
$this->_sections["quit"]['index_prev'] = $this->_sections["quit"]['index'] - $this->_sections["quit"]['step'];
$this->_sections["quit"]['index_next'] = $this->_sections["quit"]['index'] + $this->_sections["quit"]['step'];
$this->_sections["quit"]['first']      = ($this->_sections["quit"]['iteration'] == 1);
$this->_sections["quit"]['last']       = ($this->_sections["quit"]['iteration'] == $this->_sections["quit"]['total']);
?>
              <input type="submit" name="quit" value="Quit Survey - Do not save answers">
            <?php endfor; endif; ?>

            <?php if (isset($this->_sections["previous"])) unset($this->_sections["previous"]);
$this->_sections["previous"]['name'] = "previous";
$this->_sections["previous"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["previous"]['show'] = (bool)$this->_tpl_vars['show']['previous_button'];
$this->_sections["previous"]['max'] = $this->_sections["previous"]['loop'];
$this->_sections["previous"]['step'] = 1;
$this->_sections["previous"]['start'] = $this->_sections["previous"]['step'] > 0 ? 0 : $this->_sections["previous"]['loop']-1;
if ($this->_sections["previous"]['show']) {
    $this->_sections["previous"]['total'] = $this->_sections["previous"]['loop'];
    if ($this->_sections["previous"]['total'] == 0)
        $this->_sections["previous"]['show'] = false;
} else
    $this->_sections["previous"]['total'] = 0;
if ($this->_sections["previous"]['show']):

            for ($this->_sections["previous"]['index'] = $this->_sections["previous"]['start'], $this->_sections["previous"]['iteration'] = 1;
                 $this->_sections["previous"]['iteration'] <= $this->_sections["previous"]['total'];
                 $this->_sections["previous"]['index'] += $this->_sections["previous"]['step'], $this->_sections["previous"]['iteration']++):
$this->_sections["previous"]['rownum'] = $this->_sections["previous"]['iteration'];
$this->_sections["previous"]['index_prev'] = $this->_sections["previous"]['index'] - $this->_sections["previous"]['step'];
$this->_sections["previous"]['index_next'] = $this->_sections["previous"]['index'] + $this->_sections["previous"]['step'];
$this->_sections["previous"]['first']      = ($this->_sections["previous"]['iteration'] == 1);
$this->_sections["previous"]['last']       = ($this->_sections["previous"]['iteration'] == $this->_sections["previous"]['total']);
?>
              &nbsp;
              <input type="submit" name="previous" value="<?php echo $this->_run_mod_handler('default', true, $this->_tpl_vars['button']['previous'], "&lt;&lt;&nbsp;ANTERIOR"); ?>
">
            <?php endfor; endif; ?> -->

            <?php if (isset($this->_sections["next"])) unset($this->_sections["next"]);
$this->_sections["next"]['name'] = "next";
$this->_sections["next"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["next"]['show'] = (bool)$this->_tpl_vars['show']['next_button'];
$this->_sections["next"]['max'] = $this->_sections["next"]['loop'];
$this->_sections["next"]['step'] = 1;
$this->_sections["next"]['start'] = $this->_sections["next"]['step'] > 0 ? 0 : $this->_sections["next"]['loop']-1;
if ($this->_sections["next"]['show']) {
    $this->_sections["next"]['total'] = $this->_sections["next"]['loop'];
    if ($this->_sections["next"]['total'] == 0)
        $this->_sections["next"]['show'] = false;
} else
    $this->_sections["next"]['total'] = 0;
if ($this->_sections["next"]['show']):

            for ($this->_sections["next"]['index'] = $this->_sections["next"]['start'], $this->_sections["next"]['iteration'] = 1;
                 $this->_sections["next"]['iteration'] <= $this->_sections["next"]['total'];
                 $this->_sections["next"]['index'] += $this->_sections["next"]['step'], $this->_sections["next"]['iteration']++):
$this->_sections["next"]['rownum'] = $this->_sections["next"]['iteration'];
$this->_sections["next"]['index_prev'] = $this->_sections["next"]['index'] - $this->_sections["next"]['step'];
$this->_sections["next"]['index_next'] = $this->_sections["next"]['index'] + $this->_sections["next"]['step'];
$this->_sections["next"]['first']      = ($this->_sections["next"]['iteration'] == 1);
$this->_sections["next"]['last']       = ($this->_sections["next"]['iteration'] == $this->_sections["next"]['total']);
?>
              &nbsp;
              <input type="submit" name="next" value="<?php echo $this->_run_mod_handler('default', true, $this->_tpl_vars['button']['next'], "Siguiente&nbsp;&gt;&gt;"); ?>
">
            <?php endfor; endif; ?>
          </div>
      </td>
    </tr>
  </table>
</form>