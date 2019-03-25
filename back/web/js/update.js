var upd =
{
	Create: function()
	{
		var name = $("#name").val();
		if(name == '')
		{
			$("#name").addClass('error').find("+ .tip").html("Заполните поле");
		}
		else
			$.ajax(
			{
				type:"POST", cache: false, url: "/admin/post/update/create",
				data: {name: name},
				success: function(res)
				{
					if(res.r)
						dc.PjaxDecode(res.html, "#content > .updates");
					else
						admin.Error("Ошибка создания файла обновлений");
				},
				error: function(res)
				{
					admin.Error(res.responseText);
				}
			});
	},
	Down: function(el)
	{
		var name = $(el).closest(".row").find(".name").text();
		if(window.confirm('Вы уверены')==true)
		{
			$.ajax(
			{
				type:"POST", cache: false, url: "/admin/post/update/down",
				data: {name: name},
				success: function(res)
				{
					dc.PjaxDecode(res.html, "#content > .updates");
				},
				error: function(res)
				{
					admin.Error(res.responseText);
				}
			});
		}
	},
	Delete: function(el)
	{
		var name = $(el).closest(".row").find(".name").text();
		if(window.confirm('Вы уверены')==true)
		{
			$.ajax(
			{
				type:"POST", cache: false, url: "/admin/post/update/delete",
				data: {name: name},
				success: function(res)
				{
					if(res.r)
						dc.PjaxDecode(res.html, "#content > .updates");
					else
						admin.Error(res.html);
				},
				error: function(res)
				{
					admin.Error(res.responseText);
				}
			});
		}
	},
	Run: function()
	{
		$.ajax(
		{
			type:"POST", cache: false, url: "/admin/post/update/update",
			data: {},
			success: function(res)
			{
				dc.PjaxDecode(res.html, "#content > .updates");
			},
			error: function(res)
			{
				admin.Error(res.responseText);
			}
		});
	}
}
$(document).prepare(function()
{
	$("#name").click(function() {$(this).find('+ .tip').html("");} );
});
