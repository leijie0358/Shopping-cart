(function($) {

	$.fn.toFloat = function(options) {
		options = $.extend({
			side: 'right',
			top: 100,
			margin: 20,
			width:200
		}, options || {});
		
		var panel = $(this);
		panel.css('display','');
		panel.css('position','absolute'); 
		panel.appendTo('body')

		var _windowScrollTop=0;    //滚动条距离顶端距离  
		var _windowWidth=jQuery(window).width(); //窗口宽度  

		if(options.width<panel.width())
		{
			options.width = panel.width();
		}

		panel.offset({left:(options.side=="left")?options.margin:(_windowWidth - options.width - options.margin), top: _windowScrollTop +  options.top});
	
		// panel.top = _windowScrollTop +  options.top ;

		jQuery(window).scroll(function(){
			_windowScrollTop = jQuery(window).scrollTop();  //获取当前滚动条高度  
			_windowWidth=jQuery(window).width();//获取当前窗口宽度  
			panel.stop().animate(
				 {
					left:(options.side=="left")?options.margin:(_windowWidth - options.width - options.margin), 
					top: _windowScrollTop +  options.top  
				 }, "normal"
			);  
		}).resize(function(){
			_windowScrollTop = jQuery(window).scrollTop();  //获取当前滚动条高度  
			_windowWidth=jQuery(window).width();//获取当前窗口宽度  
			left = (options.side=="left")?options.margin:(_windowWidth - options.width - options.margin);
			// alert(left);
			panel.stop().animate(
				{  
					left: left, 
					top: _windowScrollTop +  options.top  
				}, "normal"
			);  
		});  //监听滚动条事件和窗口缩放事件  
	
	};

})(jQuery);
