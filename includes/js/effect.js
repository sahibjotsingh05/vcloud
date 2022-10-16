$(document).ready(function(){
	$(".effect_holder").animate({opacity: '1'}, 200);
	setTimeout(function() {
		$(".left_exit").animate({width: '0'}, 900);
		$(".right_exit").animate({width: '0'}, 900, function(){
			$(".login_page").css({display : 'block'});
			$(".login_page").animate({opacity : '1'}, 600);
		});
	}, 600);
});