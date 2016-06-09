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

	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = newDate.getMinutes();

	// Add a leading zero to the minutes value
	jQuery(".clock-minutes").html(( minutes < 10 ? "0" : "" ) + minutes);

	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = newDate.getHours();
	if(hours>=13){
		hours -= 12
	};

	// Add a leading zero to the hours value
	jQuery(".clock-hours").html(hours);

	// Output the day, date, month and year
	jQuery('.clock-date').html(dayNames[newDate.getDay()] + ", " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
}
