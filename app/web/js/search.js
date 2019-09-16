var search =
{
	start: 0,
	count: 20,
	maxId: 0,
	isLoad: 0,
	isEnd: 0,
	Restart: function(count, maxId)
	{
		search.start = 0;
		search.count = count;
		search.isEnd = 0;
		search.maxId = 0;
	},
	Scroll: function(type)
	{
		if(search.isLoad || search.isEnd)
			return;
		search.isLoad = 1;
		search.start += search.count;
		var data = {};
		data['q'] = '';
		data['start'] = search.start;
		data['max_id'] = search.maxId;
		main.AddLoader('#cont');
		
	$.ajax(
		{
			type:"POST", cache: false, url: "/search/" + type,
			data: data,
			success: function(res)
			{
				main.RemoveLoader();
				dc.PjaxDecodeAfter(res, '#cont');
				main.scrollLock = 0;
				search.isLoad = 0;
			},
			error: function(res)
			{
				main.RemoveLoader();
				main.Error(res.responseText);
				main.scrollLock = 0;
				search.isLoad = 0;
			}
		});
	},
	ScrollUsers: function()
	{
		search.Scroll("users");
	}
	,
	ScrollChats: function()
	{
		search.Scroll("chats");
	}
}