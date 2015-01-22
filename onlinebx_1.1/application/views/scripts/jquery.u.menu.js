// JavaScript Document
$(document).ready(function(){
	$('.get_u_menu_box').eq(0).before('<div id="z_u_menu_w"><div id="z_u_menu_t"></div><div id="z_u_menu_b"></div></div>');
	
	$("#z_u_menu_t").css({background:"#ffffff"});
	$("#z_u_menu_b").css({background:"#ffffff"});
	
	$("#z_u_menu_w").css({position:"absolute",zIndex: 9999,width:0,height:0,overflow:"hidden",top:0,left:0});
	
	$('.get_u_menu_box').each(function(i){
		var m_offset = $(this).offset();
		var g_um_w = $(this).width();
		var g_um_h = $(this).height();
		var g_um_l = m_offset.left;
		var g_um_t = m_offset.top;
		$(this).css({ top:g_um_t,left:g_um_l});
		$('.get_u_menu_box').eq(i).css({ position: "absolute",zIndex: 10000});
		$(this).before('<div class="get_u_menu_box_t" style="float:left;"></div>');
		$("div.get_u_menu_box_t").eq(i).css({width:g_um_w,height:g_um_h});
		$(this).bind({
			mouseenter: function(){
				z_u_menu_f(g_um_w,g_um_h,g_um_t,g_um_l,i);
			},
			mouseleave: function(){
				$("#z_u_menu_t").stop();
				$('.get_u_menu_box').stop();
				$("#z_u_menu_w").css({position:"absolute",zIndex: 9999,width:0,height:0,overflow:"hidden",top:0,left:0});
				$("#z_u_menu_t").css({marginTop:"0px"});
				$('.get_u_menu_box').eq(i).fadeTo(1,1);
			}
		});
	});
});
function z_u_menu_f(w,h,t,l,d_i){	
	var get_u_menu_box_html = $('.get_u_menu_box').eq(d_i).html();
	$("#z_u_menu_t").html(get_u_menu_box_html);
	$("#z_u_menu_b").html(get_u_menu_box_html);
	$('.get_u_menu_box').eq(d_i).fadeTo(10,0);
	$('#z_u_menu_w').css({width:w,height:h,overflow:"hidden",top:t,left:l});
	$("#z_u_menu_t").animate({ marginTop: -h },400);
	$('.get_u_menu_box').eq(d_i).fadeTo(600,1);
}