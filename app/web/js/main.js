var main =
{
	isReg: 0,
	isPost: 0,
	data: {},
	scrollLoad: 0,
	scrollLock: 0,
	caret: 0,
	AddLoader: function(parSel)
	{
		var icon = '<span class="loader"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve"><rect x="0" y="10" width="4" height="10" fill="#333" opacity="0.2"><animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0s" dur="0.6s" repeatCount="indefinite" /></rect><rect x="8" y="10" width="4" height="10" fill="#333"  opacity="0.2"><animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.15s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" /></rect><rect x="16" y="10" width="4" height="10" fill="#333"  opacity="0.2"><animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.3s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" /><animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" /></rect></svg></span>';
		$(parSel).append(icon);
	},
	RemoveLoader: function()
	{
		$('.loader').remove();
	},
	SetScroll: function(func)
	{
		main.scrollLoad = func;
		main.scrollLock = 0;
	},
	Scroll: function()
	{
		if(!main.scrollLoad || main.scrollLock)
			return;
		var st = $(window).scrollTop();
		var h = $(window).height();
		var hc = $("#cont").height();
		if(hc - st - h > h)
			return;
		main.scrollLock = 1;
		main.scrollLoad();
	},
	Error: function(desc)
	{
		$("#error").fadeIn(200);
		$("#error > div").html(dc.EscapeHtml(dc.Decode(desc)));
	},
	FormError: function(form, errors)
	{
		for(var i = 0; i < errors.length; ++i)
		{
			var a = form.find("[name='" + errors[i].name + "']");
			a.addClass("error").unbind("click").click(function()
			{
				$(this).removeClass("error");
				$(this).find(" + .tip").text("");
			});
			a.find(" + .tip").text(errors[i].text);
		}
	},
	SendListener: function(lists)
	{
		localStorage.setItem('listener', JSON.stringify(lists));
		$.ajax({url: '/listen', cache: false, type: 'post', data: {listeners: JSON.stringify(lists)},
			success: function (res)
			{
				
			},
			error: function (res)
			{
				main.Error(res.responseText);
			}
		});
	},
	AddListener: function(name, data, fn)
	{
		var lis = JSON.parse(localStorage.getItem('listener'));
		if(lis)
			lis[name] = data;
		else
		{
			lis = {};
			lis[name] = data;
		}
		var func = JSON.parse(localStorage.getItem('fn'));
		if(func)
			func[name] = fn;
		else
		{
			func = {};
			func[name] = fn;
		}
		this.SendListener(lis);
		localStorage.setItem('fn', JSON.stringify(func));
	},
	SilentListener: function(name)
	{
		var lis = JSON.parse(localStorage.getItem('listener'));
		if(lis)
			delete lis[name];
		var func = JSON.parse(localStorage.getItem('fn'));
		if(func)
			delete func[name];
		this.SendListener(lis);
		localStorage.setItem('fn', JSON.stringify(func));
	},
	RemoveListener: function(name)
	{
		var lis = JSON.parse(localStorage.getItem('listener'));
		if(name in lis)
			delete lis[name];
		var func = JSON.parse(localStorage.getItem('fn'));
		if(name in func)
			delete func[name];
	},
	Enter: function()
	{
		$('input').removeClass('error');
		var is = 1;
		var data = {};
		data['email'] = $("#eEnter input[name='email']").val().trim();
		data['password'] = $("#eEnter input[name='password']").val().trim();
		if(data['email'] == '')
		{
			$("#eEnter input[name='email']").addClass("error").unbind().click(function() {$(this).removeClass("error");});
			is = 0;
		}
		if(data['password'] == '')
		{
			$("#eEnter input[name='password']").addClass("error").unbind().click(function() {$(this).removeClass("error");});
			is = 0;
		}
		if(is)
			$.ajax({url: '/login', cache: false, type: 'post', data: data,
				success: function (res)
				{
					if(res.r == 's')
						location.href = '/';
					else
						$("#eEnter input[name='email']").addClass("error").find("+ label").html(res.text);
				},
				error: function (res)
				{
					main.Error(res.responseText);
				}
			});
	},
	Reg: function()
	{
		if(main.isReg)
			return;
		$('input').removeClass('error');
		main.isReg = 1;
		var data = {};
		data['login'] = $("#eReg input[name='login']").val().trim();
		data['email'] = $("#eReg input[name='email']").val().trim();
		data['password'] = $("#eReg input[name='password']").val().trim();
		if(data['login'] == '')
		{
			$("#eReg input[name='login']").addClass("error").unbind().click(function() {$(this).removeClass("error");});
			main.isReg = 0;
		}
		if(data['email'] == '')
		{
			$("#eReg input[name='email']").addClass("error").unbind().click(function() {$(this).removeClass("error");});
			main.isReg = 0;
		}
		if(data['password'] == '')
		{
			$("#eReg input[name='password']").addClass("error").unbind().click(function() {$(this).removeClass("error");});
			main.isReg = 0;
		}
		if(main.isReg)
		{
			$.ajax({url: '/signup', cache: false, type: 'post', data: data,
				success: function (res)
				{
					if(res.r == 's')
					{
						$("#eReg").html(res.text);
					}
					else if(res.r == 'f')
					{
						$("#eReg input[name='" + res.name + "']").addClass("error").unbind().click(function() {$(this).removeClass("error");$(this).find("+ label").html("");});
						$("#eReg input[name='" + res.name + "'] + label").html(res.text);
					}
					main.isReg = 0;
				},
				error: function (res)
				{
					main.Error(res.responseText);
					main.isReg = 0;
				}
			});
		}
	},
	AddFriend: function(el, id, type)
	{
		if(!main.data['friends'])
			main.data['friends'] = $(el).html();
		$(el).html($(el).attr('data-wait'));
		var data = {user_id:id, type: type};
		$.ajax({url: '/post/user/add-friend', cache: false, type: 'post', data: data, el: el,
			success: function (res)
			{
				if(res.r)
					$("#sFriend").html(res.json.text);
				else
				{
					main.Error(res.text);
					$(el).html(main.data['friends']);
				}
			},
			error: function (res)
			{
				main.Error(res.responseText);
				$(el).html(main.data['friends']);
			}
		});
	},
	SlideProp: function(el)
	{
		var mark = $(el).closest(".sideprops").find(".mark");
		$(el.parentNode).find("a").removeClass("sel");
		var cur = $(el);
		if(mark.length)
		{
			mark.show();
			mark.stop().animate({height: cur.outerHeight(), top: cur.position().top }, 130, 'swing', function() {$(el).addClass("sel");mark.hide();});
		}
	},
	ShowPopEdit: function(butSel, popSel)
	{
		$(butSel).click(function()
		{
			$(popSel).fadeIn(200);
		});
		$(document).mouseup(function(e)
		{
			$(popSel).fadeOut(200);
		});
	},
	ShowFade: function()
	{
		$("#fade").html("");
		$("#fade").fadeIn(200, function() {$("body").css("overflow", "hidden");});
	},
	HideFade: function()
	{
		$("#fade").fadeOut(200, function() {$("body").css("overflow", "auto");});
	},
	PastleUnformat: function(e)
	{
		var clipboardData, pastedData;
		e.stopPropagation();
		e.preventDefault();
		clipboardData = e.clipboardData || window.clipboardData;
		pastedData = clipboardData.getData('Text');
		window.document.execCommand('insertText', false, pastedData);
	},
	
	FormatBox: function(butSel, boxSel)
	{
		$(boxSel).click(function() {main.caret = dc.GetCaret(this);});
		$(boxSel)[0].addEventListener('paste', main.PastleUnformat);
		var childs = $(butSel).find('> i');
		for(var i = 0; i < childs.length; ++i)
		{
			var c = $(childs[i]);
			c.mousedown(function(e) { e.preventDefault(); });
			var attr = c.data('cmd');
			if(attr == 'bold' || attr == 'italic' || attr == 'strikeThrough' || attr == 'underline'
			 || attr == 'justifyLeft' || attr == 'justifyCenter' || attr == 'justifyRight' || attr == 'justifyFull'
			 || attr == 'indent' || attr == 'outdent' || attr == 'insertUnorderedList' || attr == 'insertOrderedList')
			{
				c.click(function(e)
				{
					document.execCommand($(this).data('cmd'), false, null);
				});
			}
			if(attr == 'h1' || attr == 'h2' || attr == 'div')
			{
				c.click(function(e)
				{
					document.execCommand('formatBlock', false, $(this).data('cmd'));
				});
			}
			if(attr == 'code')
			{
				c.click(function(e)
				{
					main.FormatOpenCode(0);
				});
			}
		}
	},
	FormatOpenCode: function(id)
	{
		main.ShowFade();
		$("#fade").unbind("click").click(function(eve) {if(eve.target == this) main.HideFade(); });
		var data = {id: id};
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/box/code",
			data: data, 
			success: function(res)
			{
				dc.PjaxDecode(res.text, "#fade");
			},
			error: function(res)
			{
				main.Error(res.responseText);
			}
		});
	},
	FormatSaveCode: function(boxSel, inSel)
	{
		var data = {};
		data['id'] = $("#codeForm input[name='id']").val();
		data['name'] = $("#codeForm input[name='name']").val();
		data['number'] = $("#codeForm input[name='number']").val();
		data['type'] = $("#codeForm select[name='type']").val();
		data['content'] = $("#codeForm textarea[name='content']").val();
		$.ajax(
		{
			type:"POST", cache: false, url: "/post/box/save-code",
			data: data, el: $(boxSel), elIn: $(inSel),
			success: function(res)
			{
				if(res.r == 1)
				{
					if(res.update)
					{
						$('attach[data-type="code"][data-value="' + res.update + '"]').replaceWith(res.text);
					}
					else
					{
						var el = $(main.caret.commonAncestorContainer);
						var current = main.caret.commonAncestorContainer.data;
						if(!current)
						{
							var childs = main.caret.commonAncestorContainer.childNodes;
							$(res.text).insertAfter($(childs[main.caret.startOffset]));
						}
						else
						{
							var newValue = current.substring(0, main.caret.startOffset) + res.text + current.substring(main.caret.startOffset);
							$(main.caret.commonAncestorContainer).replaceWith(newValue);
						}
					}
					main.HideFade();
				}
				else if(res.r == 2)
				{
					for(var i = 0; i < res.errors.length; ++i)
					{
						var a = this.el.find("[name='" + res.errors[i].name + "']");
						a.addClass("error").unbind("click").click(function() {$(this).removeClass("error");$(this).find(" + .tip").text("");});
						a.find(" + .tip").text(res.errors[i].text);
					}
				}
				else
				{
					main.Error(res.text);
				}
			},
			error: function(res)
			{
				main.Error(decodeURIComponent(escape(res.responseText)));
			},
			complete: function(res)
			{
				main.isPost = 0;
			}
		});
	},
	FormatDeleteCode: function(id)
	{
		$("attach[data-type='code'][data-value='" + id + "']").hide();
	}
}
var poll =
{
	isActive: 0,
	num: '',
	count: 0,
	inter: 0,
	last: -1,
	lastKey: '',
	value: null,
	Check: function()
	{
		var t = new Date().getTime();
		var pol = localStorage.getItem('poll');
		if(!pol)
		{
			localStorage.setItem('poll', poll.num);
			localStorage.setItem('time', t);
			return true;
		}
		var time = localStorage.getItem('time');
		if(pol == poll.num)
		{
			localStorage.setItem('time', t);
			return true;
		}
		if(Number(time) + 1000 < t)
		{
			localStorage.setItem('poll', poll.num);
			localStorage.setItem('time', t);
			return true;
		}
		return false;
	},
	Random: function(n)
	{
		var s ='';
		var abd ='abcdefghijklmnopqrstuvwxyz0123456789';
		var aL = abd.length;
		while(s.length < n)
			s += abd[Math.random() * aL|0];
		poll.num = s;
		return poll.num;
	},
	Update: function()
	{
		if(poll.num == '')
			poll.Random(32);
		if(localStorage)
		{
			var res = localStorage.getItem('poll_res');
			if(res)
			{
				res = JSON.parse(res);
				if(poll.lastKey == "")
					poll.lastKey = res.num;
				if(poll.last == -1)
					poll.last = res.count;
				else if(res.count != poll.last || poll.lastKey != res.num)
				{
					poll.lastKey = res.num;
					poll.last = res.count;
					for(var i = 0; i < res.data.length; ++i)
					{
						var func = JSON.parse(localStorage.getItem('fn'));
						var lis = JSON.parse(localStorage.getItem('listener'));
						if(lis)
							lis[res.data[i].name] = res.data[i].data;
						localStorage.setItem('listener', JSON.stringify(lis));
						
						poll.value = res.data[i].value;
						eval(func[res.data[i].name]);
						//localStorage.removeItem('poll_res');
					}
				}
			}
		}
		var active = localStorage.getItem('poll_active');
		var lis = JSON.parse(localStorage.getItem('listener'));
		var data = {num: poll.num, count: poll.count, offset: poll.count};
		if(!lis)
			data['listeners'] = lis;
		if(poll.Check() || !active || active == "0")
		{
			console.log('Send poll: ' + poll.count);
			localStorage.setItem('poll_active', 1);
			poll.inter = setInterval(poll.Check, 100);
			poll.isActive = 1;
			$.ajax({url: '/long', cache: false, type: 'post', data: data,
				success: function (res, textStatus, jqXHR)
				{
					if(localStorage)
						localStorage.setItem('poll_res', JSON.stringify(res));
					clearInterval(poll.inter);
					console.log('Success: ' + poll.count);
					++poll.count;
					poll.Update();
					poll.isActive = 0;
					localStorage.setItem('poll_active', 0);
				},
				error: function (res, textStatus, jqXHR)
				{
					clearInterval(poll.inter);
					console.log('Error: ' + poll.count);
					++poll.count;
					poll.isActive = 0;
					localStorage.setItem('poll_active', 0);
					setTimeout(poll.Update, 1000);
				}
			});
		}
		else
			setTimeout(poll.Update, 100);
	}
}
poll.Update();
$(document).ready(function()
{
	$("#error > i").click(function() {$("#error").fadeOut(200);});
	document.addEventListener("touchmove", main.Scroll, false);
	document.addEventListener("scroll", main.Scroll, false);
});