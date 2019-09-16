var photo =
{
	target: 0,
	sel: '',
	isQuad: 0,
	offset: {left:0, top:0},
	Close: function(eve, el)
	{
		if(eve.target == el)
			$("#fadePhoto").fadeOut(300);
	},
	Open: function()
	{
		$("#fadePhLarge").show();
		$("#fadePhMini").hide();
		$("#fadePhoto").fadeIn(300);
		photo.InitQuad("#photoQuad", 0);
	},
	InitQuad: function(sel, isQuad)
	{
		photo.sel = sel;
		photo.isQuad = isQuad;
		var w = $(sel).width();
		var h = $(sel).height();
		var t = h/3;
		var l = w/3;
		$(sel).css("width", w + "px").css("height", h + "px");
		$(sel + " .cell > span:nth-child(5)").css("top", t + "px").css("left", l + "px");
		$(sel + " .cell > span > i:nth-child(1)").css("top", "-4px").css("left", "-4px");
		$(sel + " .cell > span > i:nth-child(2)").css("top", "-4px").css("left", (t - 20) + "px");
		$(sel + " .cell > span > i:nth-child(3)").css("top", (t - 20) + "px").css("left", "-4px");
		$(sel + " .cell > span > i:nth-child(4)").css("top", (t - 20) + "px").css("left", (t - 20) + "px");
		photo.Align(photo.sel);
	},
	Next: function()
	{
		$("#fadePhLarge").hide();
		$("#fadePhMini").show();
		photo.InitQuad("#photoMini", 1);
	},
	Align: function(sel)
	{
		var elems = $(sel + " .cell > span i");
		var quads = $(sel + " .cell > span");
		var off = $(sel + " .cell").offset();
		var width = $(sel + " .cell").width();
		var height = $(sel + " .cell").height();
		var qW = $(quads[4]).width();
		var qH = $(quads[4]).height();
		var qPos = $(quads[4]).position();
		var minX = 40;
		var minY = 40;
		var ofs = [];
		var isCenter = 0;
		if(photo.target)
		{
			var type = $(photo.target).attr("data-type");
			var pos = $(photo.target).position();
			if(type == 1)
			{
				if(photo.isQuad)
				{
					
				}
				$(elems[1]).css('top', pos.top);
				$(elems[2]).css('left', pos.left);
			}
			else if(type == 2)
			{
				$(elems[0]).css('top', pos.top);
				$(elems[3]).css('left', pos.left);
			}
			else if(type == 3)
			{
				$(elems[3]).css('top', pos.top);
				$(elems[0]).css('left', pos.left);
			}
			else if(type == 4)
			{
				$(elems[2]).css('top', pos.top);
				$(elems[1]).css('left', pos.left);
			}
			else
				isCenter = 1;
		}
		ofs[0] = {left: $(elems[0]).offset().left - off.left + 2, top: $(elems[0]).offset().top - off.top + 2};
		ofs[1] = {left: $(elems[1]).offset().left - off.left + 18, top: $(elems[1]).offset().top - off.top + 2};
		ofs[2] = {left: $(elems[2]).offset().left - off.left + 2, top: $(elems[2]).offset().top - off.top + 18};
		ofs[3] = {left: $(elems[3]).offset().left - off.left + 18, top: $(elems[3]).offset().top - off.top + 18};
		if(!isCenter && sel == '#photoMini')
		{
			var l1 = ofs[1].left - ofs[0].left;
			var l2 = ofs[3].left - ofs[2].left;
			var ls = l2 - l1;
			var h1 = ofs[2].top - ofs[0].top;
			var h2 = ofs[3].top - ofs[1].top;
			var hs = h2 - h1;
			var size = (l1 + h1)/2;
			if(size < minX)
				size = minX;
			if(type == 1)
			{
				ofs[0].left = ofs[1].left - size;
				ofs[0].top = ofs[2].top - size;
				if(ofs[0].left < 0)
				{
					ofs[0].top -= ofs[0].left;
					ofs[0].left = 0;
				}
				if(ofs[0].top < 0)
				{
					ofs[0].left -= ofs[0].top;
					ofs[0].top = 0;
				}
			}
			if(type == 2)
			{
				ofs[1].left = ofs[2].left + size;
				ofs[1].top = ofs[2].top - size;
				/*if(ofs[1].left > 0)
				{
					ofs[1].top -= ofs[1].left;
					ofs[1].left = 0;
				}
				if(ofs[1].top < 0)
				{
					ofs[1].left -= ofs[1].top;
					ofs[1].top = 0;
				}*/
			}
			console.log({l:ofs[1].left, h: ofs[1].top, s: size});
		}
		if(!isCenter)
		{
			if(ofs[0].left < 0)
				ofs[0].left = 0;
			if(ofs[0].top < 0)
				ofs[0].top = 0;
		}
		var w = ofs[1].left - ofs[0].left;
		var h = ofs[2].top - ofs[0].top;
		if(isCenter)
		{
			if(ofs[0].left < 0)
				ofs[0].left = 0;
			if(ofs[0].top < 0)
				ofs[0].top = 0;
			if(ofs[0].left > width - w)
				ofs[0].left = width - w;
			if(ofs[0].top > height - h)
				ofs[0].top = height - h;
		}
		else
		{
			if(ofs[1].left > width)
				w = width - ofs[0].left;
			if(ofs[2].top > height)
				h = height - ofs[0].top;
			if(w < minX)
			{
				if(type == 1 || type == 3)
					ofs[0].left = ofs[2].left = ofs[1].left - minX;
				else if(type == 2 || type == 4)
					ofs[1].left = ofs[3].left = ofs[0].left + minX;
				w = minX;
			}
			if(h < minY)
			{
				if(type == 1 || type == 2)
					ofs[0].top = ofs[1].top = ofs[2].top - minY;
				else if(type == 3 || type == 4)
					ofs[2].top = ofs[3].top = ofs[0].top + minY;
				h = minY;
			}
		}
		$(quads[4]).css("left", ofs[0].left + "px").css("top", ofs[0].top + "px").css("width", w + "px").css("height", h + "px");
		$(elems[0]).css('top', '-4px').css('left', '-4px');
		$(elems[1]).css('top', '-4px').css('left', ($(quads[4]).width() - 16) + 'px');
		$(elems[2]).css('left', '-4px').css('top', ($(quads[4]).height() - 16) + 'px');
		$(elems[3]).css('left', ($(quads[4]).width() - 16) + 'px').css('top', ($(quads[4]).height() - 16) + 'px');
		
		
		$(quads[0]).css("width", ofs[0].left + "px").css("height", ofs[0].top + "px");
		$(quads[1]).css("left", ofs[0].left + "px").css("width", w + "px").css("height", ofs[0].top + "px");
		$(quads[2]).css("left", ofs[0].left + w + "px").css("width", width - (ofs[0].left + w) + "px").css("height", ofs[0].top + "px");
		$(quads[3]).css("width", ofs[0].left + "px").css("top", ofs[0].top + "px").css("height", h + "px");
		$(quads[5]).css("left", ofs[0].left + w + "px").css("top", ofs[0].top + "px").css("width", width - (ofs[0].left + w) + "px").css("height", h + "px");
		$(quads[6]).css("width", ofs[0].left + "px").css("top", ofs[0].top + h + "px").css("height", (height - (ofs[0].top + h)) + "px");
		$(quads[7]).css("left", ofs[0].left + "px").css("top", ofs[0].top + h + "px").css("width", w + "px").css("height", (height - (ofs[0].top + h)) + "px");
		$(quads[8]).css("left", ofs[0].left + w + "px").css("top", ofs[0].top + h + "px").css("width", width - (ofs[0].left + w) + "px").css("height", (height - (ofs[0].top + h)) + "px");
		if(sel == '#photoMini')
		{
			var iWidth = $(sel + " .cell img").width();
			var iHeight = $(sel + " .cell img").height();
			var sizX = w;
			var sizY = h;
			var posX = ofs[0].left*(100/sizX);
			var posY = ofs[0].top*(100/sizY);
			var size = width*(100/sizX) + 'px ' + height*(100/sizY) + 'px';
			$("#photoThumb").css("background-size", size).css("background-position", '-' + posX + 'px -' + posY + 'px');
		}
	},
	moveAt: function(e)
	{
		if(photo.target)
		{
			var pos = $(photo.target.parentNode).offset();
			photo.target.style.left = (e.pageX - pos.left) - photo.offset.left + 'px';
			photo.target.style.top = (e.pageY - pos.top) - photo.offset.top + 'px';
			photo.Align(photo.sel);
		}
  }
}
$(document).ready(function()
{
	$("#fadePhoto, #fadePhoto > div > div > i").mousedown(function()
	{
		photo.Close(event, this);
	});
	$("#fadePhLarge .btn").click(function() {photo.Next();});
	$("#fadePhoto .cell > span:nth-child(5)").mousedown(function(eve)
	{
		photo.target = this;
		photo.offset.left = eve.offsetX + 2;
		photo.offset.top = eve.offsetY + 2;
		photo.moveAt(eve);
		eve.stopPropagation();
	});
	$("#fadePhoto .cell > span i").mousedown(function(eve)
	{
		photo.target = this;
		photo.offset.left = eve.offsetX + 2;
		photo.offset.top = eve.offsetY + 2;
		photo.moveAt(eve);
		eve.stopPropagation();
	});
	$(document).mousemove(function(eve)
	{
		photo.moveAt(eve);
	});
	$(document).mouseup(function(eve)
	{
		if(photo.target)
		{
			photo.Align(photo.sel);
			photo.target = 0;
			eve.stopPropagation();
		}
	});
	$("#fadePhoto .cell > span i, #fadePhoto .cell img").on('dragstart', function()
	{
		return false;
	});
});