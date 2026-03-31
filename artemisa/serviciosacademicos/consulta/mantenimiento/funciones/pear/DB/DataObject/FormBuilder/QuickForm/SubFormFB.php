<?php

require_once('DB/DataObject/FormBuilder/QuickForm/SubForm.php');

class HTML_QuickForm_SubFormFB extends HTML_QuickForm_SubForm {
    function preValidationCallback($values) {
        return isset($values[$this->getName().'__displayed']) && $values[$this->getName().'__displayed'];
    }

    function toHtml() {
        return '
<script language="javascript">
function db_do_fb_'.$this->getName().'_display(sel) {
  div = document.getElementById("'.$this->getName().'__div");
  if(sel.value == "'.$this->linkNewValueText.'") {
    div.style.visibility = "visible";
    div.style.display = "block";
    div.style.overflow = "auto";
    document.getElementById("'.$this->getName().'__displayed").value = "1";
  } else {
    div.style.display = "none";
    div.style.overflow = "hidden";
    div.style.visibility = "hidden";
    document.getElementById("'.$this->getName().'__displayed").value = "0";
  }
}
</script>
<div id="'.$this->getName().'__div">
'.parent::toHtml().'
</div>
<script language="javascript">
db_do_fb_'.$this->getName().'_display(document.getElementById("'.$this->selectName.'"));
</script>
';
    }
}

if (class_exists('HTML_QuickForm')) {
    HTML_QuickForm::registerElementType('subFormFB', __FILE__, 'HTML_QuickForm_SubFormFB');
}

?>