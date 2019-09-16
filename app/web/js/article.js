var article =
{
	isPost: 0,
	Save: function()
	{
		if(article.isPost)
			return;
		var form = $("#saveArticle").closest(".settings");
		var data = {};
		data['id'] = form.find("input[name='id']").val();
		data['name'] = form.find("input[name='name']").val();
		data['status'] = form.find("select[name='status']").val();
		data['desc'] = form.find("div[name='desc']").html();
		data['content'] = form.find("div[name='content']").html();
		
		article.isPost = 1;
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/article/save",
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
				article.isPost = 0;
			}
		});
	},
	Visible: function(isVisible)
	{
		var id = $('input[data-type="article"]').val();
		var data = {};
		data['id'] = id;
		data['status'] = isVisible ? 1 : 2;
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/article/status",
			data: data,
			success: function(res)
			{
				if(res.r == 1)
				{
					if(res.status == 2)
						$(".conBar").addClass("hidden");
					else
						$(".conBar").removeClass("hidden");
				}
				else
					main.Error(res.text);
			},
			error: function(res)
			{
				main.Error(res.responseText);
			}
		});
	},
	Delete: function(status)
	{
		var id = $('input[data-type="article"]').val();
		var data = {};
		data['id'] = id;
		data['status'] = status;
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/article/delete",
			data: data,
			success: function(res)
			{
				if(res.r == 1)
				{
					dc.PjaxDecode(res.html, "#cont > .conBody");
					if(res.status == 2)
						$(".conBar").addClass("hidden");
					else
						$(".conBar").removeClass("hidden");
				}
				else
					main.Error(res.text);
			},
			error: function(res)
			{
				main.Error(res.responseText);
			}
		});
	},
	Ready: function()
	{
		$("#saveArticle").click(function()
		{
			article.Save();
		});
	},
	Prepare: function(butSel, popSel)
	{
		main.ShowPopEdit(butSel, popSel);
		$(popSel).find("span[data-action='hide']").click(function()
		{
			article.Visible(0);
		});
		$(popSel).find("span[data-action='show']").click(function()
		{
			article.Visible(1);
		});
		$(popSel).find("span[data-action='delete']").click(function()
		{
			article.Delete(0);
		});
	}
}
