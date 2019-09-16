var sets =
{
	SaveCommon: function(el)
	{
		var form = $(el).closest(".settings");
		var data = {};
		data['login'] = form.find('input[name="login"]').val().trim();
		data['email'] = form.find('input[name="email"]').val().trim();
		data['login'] = form.find('input[name="login"]').val().trim();
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/settings/save",
			data: data,
			success: function(res)
			{
				if(res.r)
				{
					
				}
				else
					main.Error(res.responseText);
			},
			error: function(res)
			{
				main.Error(res.responseText);
			}
		});
	}
}