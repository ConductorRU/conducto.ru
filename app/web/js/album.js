var album =
{
	isPost: 0,
	Save: function()
	{
		if(album.isPost)
			return;
		var form = $("#saveAlbum").closest(".settings");
		var data = {};
		data['id'] = form.find("input[name='id']").val();
		data['name'] = form.find("input[name='name']").val();
		data['status'] = form.find("select[name='status']").val();
		data['desc'] = form.find("div[name='desc']").html();
		
		album.isPost = 1;
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/album/save",
			data: data, el: form,
			success: function(res)
			{
				if(res.r == 1)
				{
					location.href = res.path;
				}
				else if(res.r == 2)
					main.FormError(this.el, res.errors);
				else
					main.Error(res.text);
			},
			error: function(res)
			{
				main.Error(res.responseText);
			},
			complete: function(res)
			{
				album.isPost = 0;
			}
		});
	},
	Ready: function()
	{
		$("#saveAlbum").click(function()
		{
			album.Save();
		});
	},
}
