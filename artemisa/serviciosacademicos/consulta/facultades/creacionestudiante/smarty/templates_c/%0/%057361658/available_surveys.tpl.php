<?php /* Smarty version 2.3.0, created on 2008-04-07 15:31:14
         compiled from Default/available_surveys.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
">Sistema de Encuestas </td>
    <td width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table" >
  <tr>
    <td ></td>
  </tr>
  <tr>
    <td>
      <div style="font-weight:bold;text-align:center">
         Las siguientes Encuestas estan disponibles. presione el link para iniciar la encuesta algunas encuestas pueden 
		 necesitar autenticacion.
		  </div>

      <div class="indented_cell">
      <?php if (isset($this->_sections["s"])) unset($this->_sections["s"]);
$this->_sections["s"]['name'] = "s";
$this->_sections["s"]['loop'] = is_array($this->_tpl_vars['survey']['public']) ? count($this->_tpl_vars['survey']['public']) : max(0, (int)$this->_tpl_vars['survey']['public']);
$this->_sections["s"]['show'] = (bool)"TRUE";
$this->_sections["s"]['max'] = $this->_sections["s"]['loop'];
$this->_sections["s"]['step'] = 1;
$this->_sections["s"]['start'] = $this->_sections["s"]['step'] > 0 ? 0 : $this->_sections["s"]['loop']-1;
if ($this->_sections["s"]['show']) {
    $this->_sections["s"]['total'] = $this->_sections["s"]['loop'];
    if ($this->_sections["s"]['total'] == 0)
        $this->_sections["s"]['show'] = false;
} else
    $this->_sections["s"]['total'] = 0;
if ($this->_sections["s"]['show']):

            for ($this->_sections["s"]['index'] = $this->_sections["s"]['start'], $this->_sections["s"]['iteration'] = 1;
                 $this->_sections["s"]['iteration'] <= $this->_sections["s"]['total'];
                 $this->_sections["s"]['index'] += $this->_sections["s"]['step'], $this->_sections["s"]['iteration']++):
$this->_sections["s"]['rownum'] = $this->_sections["s"]['iteration'];
$this->_sections["s"]['index_prev'] = $this->_sections["s"]['index'] - $this->_sections["s"]['step'];
$this->_sections["s"]['index_next'] = $this->_sections["s"]['index'] + $this->_sections["s"]['step'];
$this->_sections["s"]['first']      = ($this->_sections["s"]['iteration'] == 1);
$this->_sections["s"]['last']       = ($this->_sections["s"]['iteration'] == $this->_sections["s"]['total']);
?>
        <?php echo $this->_sections['s']['iteration']; ?>
. <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/survey.php?sid=<?php echo $this->_tpl_vars['survey']['public'][$this->_sections['s']['index']]['sid']; ?>
"><?php echo $this->_tpl_vars['survey']['public'][$this->_sections['s']['index']]['display']; ?>
</a>
        &nbsp;&nbsp;[ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['survey']['public'][$this->_sections['s']['index']]['sid']; ?>
">Ver Resultados</a> ]
        <br />
      <?php endfor; else: ?>
        No hay encuestas dispnibles.
      <?php endif; ?>
      </div>
    </td>
  </tr>
  <tr>
    <td >Editar Encuestas</td>
  </tr>
  <tr>
    <td>
      <form class="indented_cell" method="get" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php">
        Encuesta:&nbsp;
        <select name="sid" size="1">
          <?php if (isset($this->_sections["as"])) unset($this->_sections["as"]);
$this->_sections["as"]['name'] = "as";
$this->_sections["as"]['loop'] = is_array($this->_tpl_vars['survey']['all_surveys']['sid']) ? count($this->_tpl_vars['survey']['all_surveys']['sid']) : max(0, (int)$this->_tpl_vars['survey']['all_surveys']['sid']);
$this->_sections["as"]['show'] = true;
$this->_sections["as"]['max'] = $this->_sections["as"]['loop'];
$this->_sections["as"]['step'] = 1;
$this->_sections["as"]['start'] = $this->_sections["as"]['step'] > 0 ? 0 : $this->_sections["as"]['loop']-1;
if ($this->_sections["as"]['show']) {
    $this->_sections["as"]['total'] = $this->_sections["as"]['loop'];
    if ($this->_sections["as"]['total'] == 0)
        $this->_sections["as"]['show'] = false;
} else
    $this->_sections["as"]['total'] = 0;
if ($this->_sections["as"]['show']):

            for ($this->_sections["as"]['index'] = $this->_sections["as"]['start'], $this->_sections["as"]['iteration'] = 1;
                 $this->_sections["as"]['iteration'] <= $this->_sections["as"]['total'];
                 $this->_sections["as"]['index'] += $this->_sections["as"]['step'], $this->_sections["as"]['iteration']++):
$this->_sections["as"]['rownum'] = $this->_sections["as"]['iteration'];
$this->_sections["as"]['index_prev'] = $this->_sections["as"]['index'] - $this->_sections["as"]['step'];
$this->_sections["as"]['index_next'] = $this->_sections["as"]['index'] + $this->_sections["as"]['step'];
$this->_sections["as"]['first']      = ($this->_sections["as"]['iteration'] == 1);
$this->_sections["as"]['last']       = ($this->_sections["as"]['iteration'] == $this->_sections["as"]['total']);
?>
            <option value="<?php echo $this->_tpl_vars['survey']['all_surveys']['sid'][$this->_sections['as']['index']]; ?>
"><?php echo $this->_tpl_vars['survey']['all_surveys']['name'][$this->_sections['as']['index']]; ?>
</option>
          <?php endfor; endif; ?>
        </select>
        &nbsp;<input type="submit" name="submit" value="Editar Encuestas">
      </form>
    </td>
  </tr>
  <tr>
    <td style="text-align:center">
      <br />
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/new_survey.php"> Nueva Encuesta</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/admin.php">Admin</a>
      &nbsp;|&nbsp;
      <?php if (isset($this->_sections["logout"])) unset($this->_sections["logout"]);
$this->_sections["logout"]['name'] = "logout";
$this->_sections["logout"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["logout"]['show'] = (bool)$this->_tpl_vars['show']['logout'];
$this->_sections["logout"]['max'] = $this->_sections["logout"]['loop'];
$this->_sections["logout"]['step'] = 1;
$this->_sections["logout"]['start'] = $this->_sections["logout"]['step'] > 0 ? 0 : $this->_sections["logout"]['loop']-1;
if ($this->_sections["logout"]['show']) {
    $this->_sections["logout"]['total'] = $this->_sections["logout"]['loop'];
    if ($this->_sections["logout"]['total'] == 0)
        $this->_sections["logout"]['show'] = false;
} else
    $this->_sections["logout"]['total'] = 0;
if ($this->_sections["logout"]['show']):

            for ($this->_sections["logout"]['index'] = $this->_sections["logout"]['start'], $this->_sections["logout"]['iteration'] = 1;
                 $this->_sections["logout"]['iteration'] <= $this->_sections["logout"]['total'];
                 $this->_sections["logout"]['index'] += $this->_sections["logout"]['step'], $this->_sections["logout"]['iteration']++):
$this->_sections["logout"]['rownum'] = $this->_sections["logout"]['iteration'];
$this->_sections["logout"]['index_prev'] = $this->_sections["logout"]['index'] - $this->_sections["logout"]['step'];
$this->_sections["logout"]['index_next'] = $this->_sections["logout"]['index'] + $this->_sections["logout"]['step'];
$this->_sections["logout"]['first']      = ($this->_sections["logout"]['iteration'] == 1);
$this->_sections["logout"]['last']       = ($this->_sections["logout"]['iteration'] == $this->_sections["logout"]['total']);
?>
        <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php?action=logout">Salir</a>
        &nbsp;|&nbsp;
      <?php endfor; endif; ?>
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html">Documentacion</a> ]
    </td>
  </tr>
</table>