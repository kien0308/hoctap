jQuery(document).ready(function($) {
	
	
	$(".cf7_calculator_currency").change(function(event) {
		/* Act on the event */
		if($(this).val() == "" ){
            $(".cf7_calculator_currency_position").addClass('hidden');
		}else{
            $(".cf7_calculator_currency_position").removeClass('hidden');
		}
	});
	$(".cf7_calculator_enable").change(function(event) {
		$(".setting-total-cf7").toggleClass('hidden');
	});
});