
jQuery(document).ready(function ($) {

	wpdsClockUpdate();
	setInterval( function() {
		wpdsClockUpdate();
	}, 1000);
});

function wpdsClockUpdate() {

	// Create two variable with the names of the months and days in an array
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ];
	var dayNames= ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

	var newDate = new Date();

	var now = moment();
	jQuery('.clock').each(function(){

		var locale = jQuery(this).attr('data-locale');
		if (locale) {
			now.locale(locale);
		}

		var timezone = jQuery(this).attr('data-timezone');
		if (timezone) {
			now = now.tz(timezone);
		}

		jQuery(this).find(".clock-hours").html(now.format('HH'));
		jQuery(this).find(".clock-minutes").html(now.format('mm'));
		jQuery(this).find('.clock-date').html(now.format('dddd LL'));
	});
}
