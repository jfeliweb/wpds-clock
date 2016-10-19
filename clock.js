
jQuery(document).ready(function ($) {

	wpdsClockUpdate();
	setInterval( function() {
		wpdsClockUpdate();
	}, 1000);
});

function wpdsClockUpdate() {

	jQuery('.clock').each(function(){
		var now = moment();

		var locale = jQuery(this).attr('data-locale');
		if (locale) {
			now = now.locale(locale);
		}

		var timezone = jQuery(this).attr('data-timezone');
		if (timezone) {
			now = now.tz(timezone);
		}

		var timeStr = now.format('LT');
		var hours = timeStr.replace(/[:.].+.*$/, '');
		var mins = timeStr.replace(/^.+[:.]/, '');

		jQuery(this).find(".clock-hours").html(hours);
		jQuery(this).find(".clock-minutes").html(mins);
		jQuery(this).find('.clock-date').html(now.format('dddd LL'));
	});
}
