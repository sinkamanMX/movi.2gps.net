$(document).ready(function(){

	$('#p_menu').panel({
		controls:$('#cntrl').html(),
	    collapsed:false,
	    vHeight:'160px',
	    width:'200px',
		draggable:false,
		containment: "parent", 
		scroll: false,
		cursor:'move'
	});	
});