var chat =
{
	chat_id: 0,
	user1: 0,
	user2: 0,
	Init: function(chat_id, last, fn)
	{
		this.chat_id = chat_id;
		main.AddListener('chat_' + chat_id, {last: last}, fn);
		$("#chat").scrollTop($("#chat").prop('scrollHeight'));
	},
	InitIm: function(user1, user2, last, fn)
	{
		this.user1 = user1;
		this.user2 = user2;
		main.AddListener('im_' + user1 + '_' + user2, {last: last}, fn);
		$("#chat").scrollTop($("#chat").prop('scrollHeight'));
	},
	Delete: function()
	{
		main.SilentListener('chat_' + this.chat_id);
	},
	DeleteIm: function()
	{
		main.SilentListener('im_' + this.user1 + '_' + this.user2);
	},
	Send: function()
	{
		var text = $("#sendM").html().trim();
		if(text)
		{
			var data = {text: text};
			if(this.chat_id)
				data['chat_id'] = this.chat_id;
			else if(this.user1 && this.user2)
			{
				data['user1'] = this.user1;
				data['user2'] = this.user2;
			}
			else return;
			$("#sendM").html('');
			$.ajax(
			{
				type:"POST", cache: false, url: "/post/chat/send",
				data: data,
				dText: text,
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
	},
	Append: function()
	{
		dc.PjaxDecodeFn(poll.value, function() {$("#chat").append(poll.value.text)});
		$("#chat").scrollTop($("#chat").prop('scrollHeight'));
	},
	SideDialog: function()
	{
		$(".chatSide > div").unbind("click").click(function()
		{
			var user1 = $(this).attr('data-user1');
			var user2 = $(this).attr('data-user2');
			dc.PjaxSend('im' + user2, "#cont");
		});
	},
	SideChat: function()
	{
		$(".chatSide > div").unbind("click").click(function()
		{
			var id = $(this).attr('data-chat');
			dc.PjaxSend('chat' + id, "#cont");
		});
	}
}
$(window).on('beforeunload', function()
{
	chat.Delete();
});