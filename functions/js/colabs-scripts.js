/**
 * Detect mobile phone
 * 
 */
var mobileDetector = {
	engine: {
		webkit: "webkit"
	},
	device: {
		iphone: "iphone",
		ipad: "ipad",
		android: "android"
	},
	uagent: function() {
		if (navigator && navigator.userAgent)
    		return navigator.userAgent.toLowerCase();
	},
	detectIphone: function() {
		if (mobileDetector.uagent().search(mobileDetector.device.iphone) > -1)
			return true;
		else
			return false;
	},
	detectIpad: function() {
		if (mobileDetector.uagent().search(mobileDetector.device.ipad) > -1  && mobileDetector.detectWebkit())
			return true;
		else
			return false;
	},
	detectWebkit: function() {
		if (mobileDetector.uagent().search(mobileDetector.engine.webkit) > -1)
			return true;
		else
			return false;
	},
	detectAndroid: function() {
		if (mobileDetector.uagent().search(mobileDetector.device.android) > -1)
			return true;
		else
			return false;
	}
};



(function($){
/**
 * Equal Height plugin
 */
(function(a){a.fn.equalHeight=function(){var c=0,b=a(window).width();this.addClass("equal-height").each(function(){var d=a(this).outerHeight();if(d>c){c=d}});a(this).outerHeight(c);return this}})(jQuery);

/**
 *
 * Style Select
 *
 * Replace Select text
 * Dependencies: jQuery
 *
 */
colabsAdmin = {
	styleSelect: function () {
		$( '.select_wrapper').each(function () {
			$(this).prepend( '<span>' + $(this).find( '.colabs-input option:selected').text() + '</span>' );
		});
		$( 'select.colabs-input').live( 'change', function () {
			$(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
		});
		$( 'select.colabs-input').bind($.browser.msie ? 'click' : 'change', function(event) {
			$(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
		}); 
	},
	equalHeight: function() {
		$('#sidebar-nav, #panel-content').height('auto').equalHeight();
	},
	showGroup: function(target) {
		$('#panel-content .group').hide();
		$(target).fadeIn(500);
	}
};

$(window).load(function(){
	colabsAdmin.equalHeight();
	// Hide all group settings except the first one
	/*var hash = window.location.hash;
	if( hash !== '#' && hash !== '' ) {
		console.log( colabsAdmin.showGroup( hash ) );
	}*/
});

$(document).ready(function(){
	colabsAdmin.styleSelect();

	/**
	 * Drag and drop for sidebar menu
	 */
	function sidebarMenu() {
		var dropped = false,
			draggable_sibling;
		
		$('#sidebar-nav a').click(function(e){
			e.preventDefault();
		});

		if( mobileDetector.detectAndroid() || mobileDetector.detectIpad() || mobileDetector.detectIphone() ) {
			var menuLink = $("#sidebar-nav li a");
			menuLink.css('cursor','pointer');
			$('.help-block p').hide();
			menuLink.click(function(e){
				e.preventDefault();
				var $this = $(this);
				$('#sidebar-nav li').removeClass('current');
				$this.parent('li').addClass('current');
				colabsAdmin.showGroup($this.attr('href'));
				colabsAdmin.equalHeight();
				$('body, html').animate({
					scrollTop: $('#panel-content').position().top
				});
			});
		} else {
			if( jQuery.fn.sortable !== undefined ) {
				$("#sidebar-nav li").draggable({
					revert: 'invalid',
					stack: '#sidebar-nav li'
				});

				$('#panel-content').droppable({
					drop: function(event, ui) {
						var dragEl = $(ui.draggable),
							target = dragEl.find('a').attr('href'),
							$this = $(this);
							dropped = true;

						if( target.length ) {
							colabsAdmin.showGroup(target);
							colabsAdmin.equalHeight();
							$('#sidebar-nav li').removeClass('current');
							$('body, html').animate({
								scrollTop: $this.position().top
							});

							// Animate draggable element
							dragEl.fadeOut(function(){
								$(this).css({
									top: 0,
									left: 0
								}).addClass('current').fadeIn();
							});
						}
					}
				});
			}		
		}
	};
	sidebarMenu();

});

})(jQuery);
