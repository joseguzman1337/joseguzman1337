
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class toolsFormClass {
        


    public function __construct() {
        
    }
    
    
    public function getForm($item,$nameItem,$action=null,$value=null,$iditem=null,$class=null,$width=null,$height=null) {
		$salida=null;
		switch($item){
			
			case checkbox:
				if($action=='1'){
					$salida="
					<script type=\"text/javascript\">
						$(function(){
							var controlche=1;
							$('#select_$iditem').click(function() {
								if(controlche==1){
									$('.class_$nameItem').attr('checked', true);
									controlche=2
								}else{
									$('.class_$nameItem').attr('checked', false);
									controlche=1
								}
							});
						})
					</script>\n\n
					
					<input type=\"checkbox\" id=\"select_$iditem\" name=\"select_$nameItem\" class=\"select_$nameItem $class\" value=\"$value\">
					";
					
					
				}else{
				
			$salida="<input type=\"checkbox\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\">";
				}
				
			return $salida;
			
			case radio:
				
				if($action!=''){
					$salida="<input type=\"radio\" onClick=\"$action()\" id=\"$iditem\" name=\"$nameItem\" class=\"class_$nameItem $class\" value=\"$value\" />";
				}else{
					$salida="<input type=\"radio\" id=\"$iditem\" name=\"$nameItem\" class=\"class_$nameItem $class\" value=\"$value\" />";
				}
				
			return $salida;
			
			case button:
			
				if($action=='1'){
					$salida="<input type=\"button\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\" style=\"width:$width;  height:$height; \" />";
				}
				if($action=='2'){
					$salida="<input type=\"reset\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\" style=\"width:$width;  height:$height; \" />";
				}
				if($action=='3'){
					$salida="<input type=\"submit\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\" style=\"width:$width;  height:$height; \" />";
				}
			
			return $salida;
			
			case text:
			
				if($action=='1'){
					$salida="<input type=\"text\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\" style=\"width:$width;  height:$height;\" />";
				}
				if($action=='2'){
					$salida="<input type=\"text\" id=\"$iditem\" name=\"".$nameItem."\" class=\"class_$nameItem $class\" value=\"$value\" style=\"width:$width;  height:$height; \"/>";
				}
				return $salida;
				
			case hidden:
			
				if($action=='1'){
					$salida="<input type=\"hidden\" id=\"$iditem\" name=\"".$nameItem."[]\" class=\"class_$nameItem $class\" value=\"$value\"/>";
				}
				if($action=='2'){
					$salida="<input type=\"hidden\" id=\"$iditem\" name=\"".$nameItem."\" class=\"class_$nameItem $class\" value=\"$value\"/>";
				}
				return $salida;
			
			case textarea:
			
				if($action=='1'){
					$salida="
					 <script type=\"text/javascript\">
						 new nicEditor({fullPanel : true}).panelInstance('$iditem');
					</script>
					\n\n\n
					
   					 <textarea style=\"width:$width;  height:$height;\" id=\"$iditem\" name=\"$nameItem\" class=\"class_$nameItem $class\" >$value</textarea>";
				}
				if($action=='2'){
					$salida="
					 <script type=\"text/javascript\">
					 new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html']}).panelInstance('$iditem');
					</script>
					\n\n\n
					
   					 <textarea style=\"width:$width;  height:$height;\" id=\"$iditem\" name=\"$nameItem\" class=\"class_$nameItem $class\" >$value</textarea>";
				}
				
				if($action=='3'){
					$salida="					
   					 <textarea style=\"width:$width;  height:$height;\" id=\"$iditem\" name=\"$nameItem\" class=\"class_$nameItem $class\" >$value</textarea>";
				}
			
				if($action=='4'){
					$salida="
					 <script type=\"text/javascript\">
						 new nicEditor({fullPanel : true}).panelInstance('$iditem');
					</script>
					\n\n\n
					
   					 <textarea style=\"width:$width;  height:$height;\" id=\"$iditem\" name=\"".$nameItem."\" class=\"class_$nameItem $class\" >$value</textarea>";
				}
				if($action=='5'){
					$salida="
					 <script type=\"text/javascript\">
					 new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','image']}).panelInstance('$iditem');
					</script>
					\n\n\n
					
   					 <textarea style=\"width:$width;  height:$height;\" id=\"$iditem\" name=\"".$nameItem."\" class=\"class_$nameItem $class\" >$value</textarea>";
				}
				
				
				return $salida;
			
			case lbox:
			
			if($action=='1'){
			$salida="
			<script type=\"text/javascript\">
			$(document).ready(function () {
			  $('.$class').on(\"click\", function (e) {
			
				e.preventDefault();
				$.ajax({
				  type: \"POST\",
				  cache: false,
				  url: this.href,
				  data: $(\"#$iditem\").serializeArray(), 
				  success: function (data) {
					  	 
					$.fancybox(data, {
					  fitToView: false,
					  width: $width,
					  height: $height,
					  autoSize: false,
					  closeClick: false,
					  openEffect: 'none',
					  closeEffect: 'none'
					}); // fancybox
				  } // success
				}); // ajax
			  }); // on
			}); // ready
			</script>\n\n
			 		
                                <a class=\"$class fancybox\" style=\"background-color:#FFFFFF; background-image:-moz-linear-gradient(0% 100% 90deg, #BBB BBB, #FFFFFF);border:1px solid #F1F1F1;border-radius:10px 10px 10px 10px;
                                                                        box-shadow:0 1px 2px rgba(0, 0, 0, 0.5);color:#444444;font-weight:Helvetica,Arial,sans-serif;line-height:1; padding:9px 17px;text-shadow:text-shadow \"  data-fancybox-type=\"ajax\" href=\"$nameItem\" >$value</a>
                            
			";
			}
			if($action=='2'){
			$salida="
			<script type=\"text/javascript\">
			$(document).ready(function () {
			    	 
					$.fancybox(data, {
					  fitToView: false,
					  width: $width,
					  height: $height,
					  autoSize: false,
					  closeClick: false,
					  openEffect: 'none',
					  closeEffect: 'none'
					
			}); // ready
			</script>\n\n
					
			<a class=\"$class fancybox\"  data-fancybox-type=\"ajax\" href=\"$nameItem\" >$value</a>		
			";
			}
			return $salida;
		} 
    }
            
                        
    public function __destruct() {
        
    }
}
?>
