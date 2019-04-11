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

var vUpdate = new Vue({
  el: "#vUpdate",
	data:
	{
		updateName: '',
		items: [{ name: 'Foo', val:1 },],
  },
  methods:
  {
		Create: function()
		{
			axios.post('/admin/post/update/create', {name: this.updateName}).then(response =>
			{
				this.items = response.data.files;
				console.log(response);
			}).catch(e => {});
		},
		Update: function()
		{
			axios.post('/admin/post/update/update').then(response =>
				{
					this.items = response.data.files;
				}).catch(e => {});
		},
		Delete: function(num)
		{
			if(window.confirm('Вы действительно хотите удалить файл "' + this.items[num].name + '"?'))
			{
				axios.post('/admin/post/update/delete', {name: this.items[num].name}).then(response =>
				{
					if(response.data.r)
						this.items = response.data.files;
					console.log(response);
				}).catch(e => {});
			}
		},
		Down: function(num)
		{
			if(window.confirm('Вы действительно хотите отменить обновление "' + this.items[num].name + '"?'))
			{
				axios.post('/admin/post/update/down', {name: this.items[num].name}).then(response => {console.log(response);}).catch(e => {});
			}
		}
  }
});