// JavaScript Document
jQuery(function()
{
	toTop();
});

function toTop()
{
	jQuery('body').append('<a id="top-btn-main" href="#" class="to-top-btn"><span class="screen-reader-text">Scroll Up</span></a>');
	
	jQuery(window).scroll(function(event)
	{
		var currentScroll = jQuery(this).scrollTop();
		var em = document.getElementById("top-btn-main");
		var temp = window.getComputedStyle(em).getPropertyValue("opacity");
		
		if(currentScroll >= 300)
		{			
			if(temp == 0)
			{
				if(!jQuery('.to-top-btn').hasClass('visible'))
				{
					jQuery('.to-top-btn').addClass('visible');
				}
				jQuery('.to-top-btn').stop().animate({'opacity': '.5'}, 250);
			}
		}
		else 
		{
			if(temp != 0)
			{
				jQuery('.to-top-btn').stop().animate({'opacity': '0'}, 250);
				
				if(jQuery('.to-top-btn').hasClass('visible'))
				{
					jQuery('.to-top-btn').removeClass('visible');
				}
			}
		}
	});
	
	jQuery('body').on('click', 'a.to-top-btn', function(e)
	{
		e.preventDefault();
		
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
  		return false;
	});
}