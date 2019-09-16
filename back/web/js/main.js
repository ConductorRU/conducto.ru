var admin =
{
	Error: function(desc)
	{
		$("#error").fadeIn(200);
		$("#error > div").html(desc);
	}
}
$(document).ready(function()
{
	$("#error > i").click(function() {$("#error").fadeOut(200);});
});