/* jQuery Meuns */
(function(jQuery){
	istojQ=jQuery.noConflict();
	var mouseover_tid=[];
	var mouseout_tid=[];
	istojQ(document).ready(function(){
		istojQ('#navmenus > li').find('ul:eq(0)').slideUp(50);
		istojQ('#navmenus > li').each(function(index){
			istojQ(this).hover(function(){
				var _self=this;
				clearTimeout(mouseout_tid[index]);
				mouseover_tid[index] = setTimeout(function(){				
					istojQ(_self).find('ul:eq(0)').slideDown(200);
					istojQ(_self).find('ul:eq(0)').addClass('sub-menu');
				},200);
			},function(){
				var _self=this;
				clearTimeout(mouseover_tid[index]);
				mouseout_tid[index]=setTimeout(function(){
					istojQ(_self).find('ul:eq(0)').slideUp(200);
					istojQ(_self).find('ul:eq(0)').removeClass('sub-menu');
				},200);
			});
		});
	});
})(jQuery);