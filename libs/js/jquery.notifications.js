
;(function($){
	$.notifications = {
		defaults: {
			className: 'notification',
			alive: 5000,
			fadeIn: 600,
			fadeOut: 800,
			tpl: '<div class="{className}"><div class="{className}-img"><img src="{image}" alt="" /></div><div class="{className}-title">{title}</div><div class="{className}-text">{text}</div></div>',
			callback: function(){},
			
			sticky: false,
			
			image: '',
			title: '',
			text: ''
		}, // defaults
		
		private: {
			isSet: false
			, count: 0
		}, // private
		
		add: function(params){
			var o = this, private = this.private
			
			s = $.extend({}, this.defaults, params)
			
			s.image = s.image ? '<div class="' + s.className + '-img"><img src="' + s.image + '" alt="" /></div>' : ''
			
			if(!private.isSet){
				$('body').append('<div class="' + s.className + '-wrapper"></div>')
				private.isSet = true
			}
			
			private.count++
			
			$(o.tpl(s.tpl, s)).attr('data-notification', private.count)
			.appendTo('.' + s.className + '-wrapper').css({opacity: 0})
			.animate({opacity: 1}, s.fadeIn, function(){
				var n = $(this).attr('data-notification')
				
				$(this).click(function(){o.remove.call(o, n, s)})
				$(this).find('a').click(function(e){e.stopImmediatePropagation()})
				
				if(!s.sticky){
					var timer = setTimeout(function(){o.remove.call(o, n, s)}, s.alive)
					$(this).bind({
						mouseenter: function(){
							clearTimeout(timer)
						}
						, mouseleave: function(){
							timer = setTimeout(function(){o.remove.call(o, n, s)}, s.alive)
						}
					})
				}
				
				if(typeof s.callback == 'function')	s.callback.call(o, s)
			})
		}, // add
		
		remove: function(n, s){
			var o = this, s = s || o.defaults, private = o.private
			
			$('.' + s.className + '[data-notification="' + n + '"]')
			.animate({opacity: 0}, s.fadeOut, function(){
				$(this).animate({height: 0}, 150, function(){
					$(this).remove()
				})
			})
		}, // remove
		
		removeAll: function(params){
			$('.' + s.className)
			.each(function(){
				$(this).animate({opacity: 0}, s.fadeOut, function(){
					$(this).animate({height: 0}, 150, function(){$(this).remove()})
				})
			})
		}, // removeAll
		
		tpl: function(s, d){
			for(var k in d)	s = s.replace(new RegExp('{' + k + '}', 'g'), d[k])
			return s
		} // tpl
	}
})(jQuery) // jQuery.notifications by Stéphan Zych (monkeymonk.be)
