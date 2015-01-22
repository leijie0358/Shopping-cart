$.fn.extend({
	jr_datatable: function(options){
		// 将一个表格构造成 三个 表格,且中间的表格被DIV WRAP
		var defaults = 
		{
			width : "780px",
			border : "1px solid #aaaaaa",
			header :
			{
				height : "32px",
				align : "center",
				padding : "0px 3px 0px 6px"
			},
			body :
			{
				height : "438px",
				row_height : "20px",
				align : "left",
				padding : "3px 3px 3px 6px",
				scrollx : "hidden",
				scrolly : "auto"
			},
			footer :
			{
				height : "30px",
				align : "left",
				padding : "0px 3px 0px 6px"
			}
		};
		
		var paramas = $.extend(defaults,options); 
		
		// 获取原始表的对象
		var ori_table_id = $(this).attr('id');
		var ori_table = $('#' + ori_table_id);
		
		// 新建一个容器 并将此容器追加到原始表的父对象里
		var container_id = "container_" + ori_table_id;
		var container = $("<div id='" + container_id + "'></div>");
		container.appendTo(ori_table.parent());
		
		// 找到取第一行
		var ot_rows = ori_table.find('tr');
		var ot_first_row = ot_rows.first();
		// 新建一个id为 "header_" + ori_table_id 的表格 
		var header_table_id = "header_" + ori_table_id;
		var header_table = $("<table id='" + header_table_id + "'></table>");
		// 将第一行追加到 ID 为   "header_" + ori_table_id 的表格中
		ot_first_row.appendTo(header_table);
		// 将ID为"header_" + ori_table_id 的表格追加到 容器
		header_table.appendTo(container);
		// 新建一个id为 "body_" + ori_table_id 的表格 
		var body_table_id = "body_" + ori_table_id;
		var body_table = $("<table id='" + body_table_id + "'></table>");
		// 将除第一行和最后一行外的所有行追加到   "body_" + ori_table_id 的表格中
		//alert('abc');
		ori_table.find('tr:not(:last)').each(function(i){
			$(this).appendTo(body_table);
		});
		// 为 "body_" + ori_table_id 加一个 有滚动属性的div的wrap
		body_table_wrap = $("<div id='wrap_" + body_table_id + "'></div>");
		body_table.appendTo(body_table_wrap);
		// 将此此DIV追加到 容器
		body_table_wrap.appendTo(container);
		// 直接将 原始表格 移到 body_table_wrap 之后 ,并追 到到容器
		var footer_table = ori_table;
		footer_table.appendTo(container);
		body_table_wrap.after(footer_table);

		
		
		header_table.addClass('jr_datatable_header_table');
		body_table.addClass('jr_datatable_body_table');
		body_table_wrap.addClass('jr_datatable_body_table_wrap');
		footer_table.addClass('jr_datatable_footer_table');
		
		
		
		header_table.css('width',paramas.width);
		
		header_table.css('height',paramas.header.height);
		//alert(paramas.header.height);
		
		//body_table.css('height',paramas.style.body.row_height);
		
		
		footer_table.css('width',paramas.width);
		footer_table.css('height',paramas.footer.height);
		
		body_table_wrap.css('background-color','#fcfcfc');
		body_table_wrap.css('border-collapse','collapse');
		container.find('table').each(function(){
			$(this).css('border-collapse','collapse');
			$(this).find('tr:first td').each(function(col){
				var column_width = paramas.columns[col];
				if(column_width != null)
				{
					$(this).css('width',column_width);
				}
			});
		});	
		
		// 设置头表格
		header_table.find('tr td').each(function(){
			$(this).addClass('jr_datatable_body_first_row_td');
			$(this).css('border',paramas.border);
			$(this).css('text-align',paramas.header.align);
			$(this).css('color',paramas.header.color);
			$(this).css('padding',paramas.header.padding);
		});
		
		// 设置主体
		body_table_wrap.css('border-left',paramas.border);
		body_table_wrap.css('border-right',paramas.border);
		body_table_wrap.css('width',
				parseFloat(paramas.width)
				-
				2*parseFloat(paramas.border)
		);
		body_table_wrap.css('height',paramas.body.height);
		//alert(body_table_wrap.find('table').attr('id'));
		body_table_wrap.css('overflow-x',paramas.body.scrollx);
		body_table_wrap.css('overflow-y',paramas.body.scrolly);
		
		body_table.css('width',
				parseFloat(paramas.width)
				-
				2*parseFloat(paramas.border)
		);
		
		var count = body_table.find('tr:first td').size();
		body_table.find('tr td').each(function(){
			var index = $(this).index();
			if(index!=0 && index !=(count-1))
			{
				$(this).css('border-left',paramas.border);
				$(this).css('border-right',paramas.border);
				$(this).css('border-bottom',paramas.border);
			}
			else
			{
				$(this).css('border-bottom',paramas.border);
			}

			$(this).css('background-color','white');
			$(this).css('text-align',paramas.body.align);
			$(this).css('color',paramas.body.color);
			$(this).css('padding',paramas.body.padding);
			$(this).css('height',paramas.body.row_height);
			//$(this).css('border-right',paramas.style.border);
			
		});
		
		body_table_wrap.scroll(function(){
			body_table.find('tr:last td').css('border-bottom',"0px");
		});
		
		// 设置尾表格
		footer_table.find('tr td').each(function(){
			$(this).css('border',paramas.border);
			$(this).css('text-align',paramas.footer.align);
			$(this).css('color',paramas.footer.color);
			$(this).css('padding',paramas.footer.padding);
		});
	
	}
});

