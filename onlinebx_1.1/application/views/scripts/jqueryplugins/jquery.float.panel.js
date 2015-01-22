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

		var _windowScrollTop=0;    //���������붥�˾���  
		var _windowWidth=jQuery(window).width(); //���ڿ��  

		if(options.width<panel.width())
		{
			options.width = panel.width();
		}

		panel.offset({left:(options.side=="left")?options.margin:(_windowWidth - options.width - options.margin), top: _windowScrollTop +  options.top});
	
		// panel.top = _windowScrollTop +  options.top ;

		jQuery(window).scroll(function(){
			_windowScrollTop = jQuery(window).scrollTop();  //��ȡ��ǰ�������߶�  
			_windowWidth=jQuery(window).width();//��ȡ��ǰ���ڿ��  
			panel.stop().animate(
				 {
					left:(options.side=="left")?options.margin:(_windowWidth - options.width - options.margin), 
					top: _windowScrollTop +  options.top  
				 }, "normal"
			);  
		}).resize(function(){
			_windowScrollTop = jQuery(window).scrollTop();  //��ȡ��ǰ�������߶�  
			_windowWidth=jQuery(window).width();//��ȡ��ǰ���ڿ��  
			left = (options.side=="left")?options.margin:(_windowWidth - options.width - options.margin);
			// alert(left);
			panel.stop().animate(
				{  
					left: left, 
					top: _windowScrollTop +  options.top  
				}, "normal"
			);  
		});  //�����������¼��ʹ��������¼�  
	
	};

})(jQuery);
