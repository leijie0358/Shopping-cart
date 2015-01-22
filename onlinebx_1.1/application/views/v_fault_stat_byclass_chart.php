<script type="text/javascript" src="<?=$root_url?>application/views/scripts/Highcharts-2.1.4/js/highcharts.js"></script>
<script>
	var export_server_url = "<?=$root_url?>application/views/scripts/Highcharts-2.1.4/exporting-server/"
</script>
<script type="text/javascript" src="<?=$root_url?>application/views/scripts/Highcharts-2.1.4/js/modules/exporting.src.js"></script> 
<script type="text/javascript"> 
	/**
	 * Visualize an HTML table using Highcharts. The top (horizontal) header 
	 * is used for series names, and the left (vertical) header is used 
	 * for category names. This function is based on jQuery.
	 * @param {Object} table The reference to the HTML table to visualize
	 * @param {Object} options Highcharts options
	 */
	Highcharts.visualize = function(table, options) {
		// the categories
		options.xAxis.categories = [];
		$('tr:gt(0)', table).each( function(i) {
			var first_td = $(this).find('td').eq(0);
			options.xAxis.categories.push(first_td[0].innerHTML);
		});
		
		// the data series
		options.series = [];
		$('tr', table).each( function(i) {
			var tr = this;
			var index  = 0;
			$('th, td', tr).each( function(j) {
				if (j > 1 && j%2==0) { // skip first column
					if (i == 0) { // get the name and init the series
						options.series[index] = { 
							name: this.innerHTML,
							data: []
						};
					} else { // add values
						options.series[index].data.push(parseFloat(this.innerHTML));
					}
					index ++;
				}
			});
		});
		
		var chart = new Highcharts.Chart(options);
	}
		
	// On document ready, call visualize on the datatable.
	$(document).ready(function() {			
		var table = $('.datatable')[0];
		var text =  "";
		if($('#bx_time_begin').val()=="" && $('#bx_time_en').val()=="")
		{
			text = "故障类别统计";
		}
		else if($('#bx_time_begin').val()=="")
		{
			text = $('#bx_time_end').val() + "之前的故障类别统计";
		}
		else if($('#bx_time_end').val()=="")
		{
			text = $('#bx_time_begin').val() + "之后的故障类别统计";
		}
		else
		{
			text = $('#bx_time_begin').val() + "到" + $('#bx_time_end').val() + "的故障类别统计";
		}

		options = {
			   chart: {
				  renderTo: 'chart',
				  defaultSeriesType: 'column'
			   },
			   title: {
				  text: text
			   },
			   xAxis: {
			   },
			   yAxis: {
				  title: {
					 text: '故障单数'
				  }
			   },
			   plotOptions: {
					column: {
						stacking: 'normal'
					}
				},
			   tooltip: {
				  formatter: function() {
					return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>'+
								 '总单数: '+ this.point.stackTotal;
				  }
			   }
			};
		
							
		Highcharts.visualize(table, options);
	});
		
</script> 

<div id="chart" style="width: 560px; height: 400px; margin: 0 auto"></div> 