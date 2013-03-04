/* script.js */
$(function(){
	
	$('a[rel^="external"]').attr('target', '_blank')
	
	
	$('[data-toggle="modal"]')
	.click(function(e){
		e.preventDefault()
		
		var o = $(this)
		
		$('#modal').find('.modal-body').empty()
		.append('something')
		
		$('#modal').modal()
	})
	$('.modal').on('hide', function() {
		$(this).find('.modal-body').empty()
	})
	
}) // ready


/* tools */
;(function($, window, undefined){
	$.fn.equalHeight = function(maxHeight){
		maxHeight = maxHeight || 0
		
		this.each(function(){
			var o = $(this)
			o.css({height: 'auto'})
			if(o.outerHeight() > maxHeight)	maxHeight = o.outerHeight()
		})
		
		this.each(function(){
			var o = $(this), pad = parseInt(o.css('padding-top'), 10) + parseInt(o.css('padding-bottom'), 10)
			o.height(maxHeight - pad)
		})
		
		return this
	}
})(jQuery, window) // jQuery.equalHeight() by Stéphan Zych (monkeymonk.be)

var tpl = function(str, data){
	for(var p in data) str = str.replace(new RegExp('{' + p + '}', 'g'), data[p])
	return str
} // tpl

var isMobile = function(){
	return /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)
} // isMobile

;(function(window, document, undefined){
	var inject = inject = function(files, cb){
		if(typeof files === 'string')	files = files.replace(/\s/g, '').split(',')
		else return false
		
		var d = document, i = files.length, file, node, head
		, load = function(){
			if(i === 0)	cb.call(this) || function(){}
		}
		
		if(!/in/.test(document.readyState) || !!setTimeout(function(){inject(files, cb)}, 9)){
			head = d.getElementsByTagName('head')[0]
			
			while(file = files[--i]){
				if(/\.css$/i.test(file)){
					node = d.createElement('link')
					node.rel = 'stylesheet'
					node.href = file
				}
				else if(/\.js$/i.test(file)){
					node = d.createElement('script')
					node.src = file
				}
				else	break
				node.onreadystatechange = function(){
					if(this.readyState === 'complete')	load.call(this)
				};
				node.onload = load
				head.appendChild(node);
			}
		}
	}
	window.inject = inject
})(window, document) // inject() by Stéphan Zych (monkeymonk.be)
// use: inject('test.js, test.css', function(){alert('all files are loaded!')})
