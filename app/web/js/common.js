(function($) 
{
	$.prepare = [];
	$.fn.rule = function(rule)
	{
		for(var i = 0; i < this.length; ++i)
			this[i].rule = rule;
  };
  $.fn.validate = function()
	{
		for(var i = 0; i < this.length; ++i)
			if(this[i].rule)
				if(!this[i].rule())
					return false;
		return true;
  };
	$.fn.prepare = function(fn)
	{
		if(fn)
			$.prepare.push(fn);
		else for(var i = 0; i < $.prepare.length; ++i)
			$.prepare[i]();
	}
})(jQuery);

function ClickPjax()
{
	if(!window.history)
		return true;
	window.history.pushState({href: this.href}, null, this.href);
	var t = $(this).attr("data-target");
	if(!t)
		t = "#content";
	dc.Pjax(this.href, t, 0);
	return false;
}
	
var dc =
{
	Decode: function(x)
	{
		var r = /\\u([\d\w]{4})/gi;
		x = x.replace(r, function (match, grp) { return String.fromCharCode(parseInt(grp, 16));});
		return x;
	},
	EscapeHtml: function(x)
	{
		var entityMap = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#39;',
			'/': '&#x2F;',
			'`': '&#x60;',
			'=': '&#x3D;'
		};
		return String(x).replace(/[&<>"'`=\/]/g, function (s)
		{
			return entityMap[s];
		});
	},
	PjaxDecode: function(res, selector)
	{
		this.PjaxDecodeFn(res, function() {$(selector).html(res.text)});
	},
	PjaxDecodeAfter: function(res, selector)
	{
		this.PjaxDecodeFn(res, function() {$(selector).append(res.text)});
	},
	PjaxDecodeFn: function(res, fn)
	{
		fn();
		if(res.title)
			document.title = res.title;
		var codes = $(res.codes);
		var find = 0;
		var scripts = $("script");
		for(var i = 0; i < codes.length; ++i)
		{
			find = 0;
			for(var j = 0; j < scripts.length; ++j)
			{
				if(scripts[j].outerHTML == codes[i].outerHTML)
					find = 1;
			}
			if(!find)
				$("body").append(codes[i]);
		}
		for(var i = 0; i < res.script.length; ++i)
			eval(res.script[i]);
		$(document).prepare();
	},
	PjaxSend: function(href, selector)
	{
		if(!window.history)
		{
			location.href = href;
			return;
		}
		window.history.pushState({href: href}, null, href);
		dc.Pjax(href, selector, 0);
	},
	Pjax: function(href, selector, isBack)
	{
		main.SetScroll(0);
		if(isBack)
			$("#logo").addClass('loadb');
		else
			$("#logo").addClass('load');
		$.ajax(
		{
			type:"POST",
			cache: false,
			url: href,
			data: {selector: selector},
			success: function(res)
			{
				if(res.text)
				{
					$("html:not(:animated), body:not(:animated)").scrollTop(0);
					dc.PjaxDecode(res, selector);
					dc.UpdatePjax();
				}
				else
					main.Error(res);
				$("#logo").removeClass('load').removeClass('loadb');
			},
			error: function(res)
			{
				if(main)
					main.Error(res.responseText);
				$("#logo").removeClass('load').removeClass('loadb');
			}
		});
	},
	UpdatePjax: function()
	{
		var as = $("a.pjax");
		as.unbind('click', ClickPjax);
		for(i = 0; i < as.length; ++i)
			if(as[i].href.indexOf('http://chronopolis.ru/') == 0)
				$(as[i]).click(ClickPjax);
	},
	InsertTab: function(e) 
	{
		var el = e.target;
		var keyCode = e.keyCode || e.which;
		if(keyCode == 9)
		{
			e.preventDefault();
			var start = el.selectionStart;
			var end = el.selectionEnd;
			$(el).val($(el).val().substring(0, start) + "\t" + $(el).val().substring(end));
			el.selectionStart = el.selectionEnd = start + 1;
		}
	},
	GetCaret: function(editableDiv)
	{
		var caretPos = 0, sel, range;
		if (window.getSelection)
		{
			sel = window.getSelection();
			if(sel.rangeCount)
				return sel.getRangeAt(0);
		}
		return null;
	}
}
window.addEventListener('popstate', function(e)
{
	if(e.state)
		dc.Pjax(e.state.href, "#content", 1);
});
$(document).ready(function()
{
	window.history.replaceState({href: location.href}, null, location.href);
	dc.UpdatePjax();
	$(this).prepare();
});