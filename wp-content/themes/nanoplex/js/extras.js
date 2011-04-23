var $j = jQuery.noConflict();
//fix up the links in the menu!

$j(document).ready(function() { 
	

	$j('.linksul', '.primary').each(function() {
		var position = $j('.primary .links').position();
		var currentWidth = $j(this).width();
		var newWidth = position.left+$j('.links').width();
		
		if(newWidth>currentWidth) {
			$j(this).width(newWidth);
		}
	});
	$j('.linksul', '.footer').each(function() {
		var position = $j('.footer .links').position();
		var currentWidth = $j(this).width();
		var newWidth = position.left+$j('.links').width();
		
		if(newWidth>currentWidth) {
			$j(this).width(newWidth);
		}
	});
	//menu stuff
	$j('.menu-item, .page_item', '.primary').each(function() {
		var position = $j(this).position();
		if ((position.top == $j('div.menu', '.primary').height()-35) && (position.left == 685-$j(this).width())) $j(this).children('a').addClass('rightlink');
	});
	$j('.menu-item, .page_item', '.footer').each(function() {
		var position = $j(this).position();
		if ((position.top == 0) && (position.left == 650-$j(this).width())) $j(this).children('a').addClass('rightlink');
	});
	$j('nav.primary div.menu').hover(function() {
		//figure out what auto height is
		$j(this).stop(true, false).delay(600); //get rid of css resizing
		
		var currentHeight = $j(this).height();
		$j(this).css('height', 'auto');
		var height = $j(this).height();
		$j(this).css({'height': currentHeight+'px'});
		
		if(height!=currentHeight) 
			$j(this).animate({'height': height+'px'}, 400, function() {
				$j(this).css({"overflow":"visible"});
				$j('.menu-item, .page_item, .links', '.primary').each(function() {
					var position = $j(this).position();
					if ((position.top == $j('div.menu', '.primary').height()-35) && (position.left == 685-$j(this).width())) $j(this).children('a').addClass('rightlink');
					else $j(this).children('a').removeClass('rightlink');
				});
			});
		else $j(this).css({"overflow":"visible"});
		
	},function(){ 
		$j(this).stop(true, false).delay(1000).css({"overflow":"hidden"}).animate({'height': "35px"}, 600, function() {
			$j('.menu-item, .page_item, .links', '.primary').each(function() {
				var position = $j(this).position();
				if ((position.top == $j('div.menu', '.primary').height()-35) && (position.left == 685-$j(this).width())) $j(this).children('a').addClass('rightlink');
				else $j(this).children('a').removeClass('rightlink');
			});
		}); 
	});
	$j('nav.footer div.menu').hover(function() {
		//figure out what auto height is
		$j(this).stop(true, false).delay(600); //get rid of css resizing
		
		var currentHeight = $j(this).height();
		$j(this).css('height', 'auto');
		var height = $j(this).height();
		$j(this).css({'height': currentHeight+'px'});
		if(height!=currentHeight) $j(this).animate({'height': height+'px'}, 400, function() {$j(this).css({"overflow":"visible"});});
		else $j(this).css({"overflow":"visible"});
		
	},function(){ 
		$j(this).stop(true, false).delay(1000).css({"overflow":"hidden"}).animate({'height': "35px"}, 600); 
		
	});
	
	
	
	$j('nav.primary .links a.linktext').hover(function(){ 
		$j('nav.primary .menu .menu-links').addClass('hover');
	},function(){ 
		$j('nav.primary .menu .menu-links').removeClass('hover'); 
	});
	
	$j('nav.primary .menu .menu-links').hover(function(){ 
		$j('nav.primary .links').addClass('smallhover');
	},function(){ 
		$j('nav.primary .links').removeClass('smallhover'); 
	});
	
	$j('nav.footer .links a.linktext').hover(function(){ 
		$j('nav.footer .menu .menu-links').addClass('hover');
	},function(){ 
		$j('nav.footer .menu .menu-links').removeClass('hover'); 
	});
	
	$j('nav.footer .menu .menu-links').hover(function(){ 
		$j('nav.footer .links').addClass('smallhover');
	},function(){ 
		$j('nav.footer .links').removeClass('smallhover'); 
	});
	
	$j('nav.primary .links .linksul').hover(function(){ 
		$j('nav.primary .menu .menu-links').addClass('hover');
	},function(){ 
		$j('nav.primary .menu .menu-links').removeClass('hover'); 
	});
	$j('nav.footer .links .linksul').hover(function(){ 
		$j('nav.footer .menu .menu-links').addClass('hover');
	},function(){ 
		$j('nav.footer .menu .menu-links').removeClass('hover'); 
	});
	
	$j('#comments .comment .comment-text').each(function() {
		$j(this).css('height', 'auto');
		var autoheight = $j(this).height();
		if (autoheight>62) {
			$j(this).addClass('comment-text-css-overflowed').parent().addClass('comment-overflowed');
		}
		$j(this).css('height', '62px');

	});
	
	$j('#comments .comment .comment-text').hover(function() {
		//figure out what auto height is
		$j(this).stop(true, false).removeClass('comment-text-css').delay(600); //get rid of css resizing
		
		var currentHeight = $j(this).height();
		$j(this).css('height', 'auto');
		var height = $j(this).height();
		$j(this).css({'height': currentHeight+'px'});
		$j(this).animate({'height': height+'px'}, 500);
		
	},function(){ 
		$j(this).stop(true, false).delay(500).animate({'height': "62px"}, 600); 
		
	});
	
	// now for the author bar
	$j('.author-post .author-info').each(function() {
		$j(this).css('height', 'auto');
		var autoheight = $j(this).height();
		if (autoheight>160) {
			$j(this).addClass('author-text-overflowed').parent().addClass('author-overflowed');
		}
		$j(this).css('height', '160px');

	});
	
	$j('.author-post .author-text-overflowed').hover(function() {
		//figure out what auto height is
		$j(this).stop(true, false).delay(600); //get rid of css resizing
		
		var currentHeight = $j(this).height();
		$j(this).css('height', 'auto');
		var height = $j(this).height();
		$j(this).css({'height': currentHeight+'px'});
		$j(this).animate({'height': height+'px'}, 500);
		
	},function(){ 
		$j(this).stop(true, false).delay(500).animate({'height': "160px"}, 600); 
		
	});
	
	$j('.top-level', '#comments').has('.children').each(function() {
		$j(this).has('.thread-odd').addClass('comment-background-odd');
		$j(this).has('.thread-even').addClass('comment-background-even');
	});
	
});