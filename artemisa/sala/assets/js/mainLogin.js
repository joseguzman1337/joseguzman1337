/**
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 */

$(function() {
    $("#login_btn").click(function(e){
    	e.stopPropagation();
    	e.preventDefault();
    	$("form#login").submit();
    });
});