$(document).ready(function(){
  /* Sooperfish Dropdown
  ----------------------------------------------*/
  $('.top-menu ul').sooperfish({
		hoverClass : 'sfHover',
		animationShow : {height:'show'},
		speedShow : 200,
		delay:100,
		animationHide : {height:'hide'},
		speedHide : 200,
		autoArrows : true,
		dualColumn: 1000,
		tripleColumn: 1000
	});
    $("#slider").easySlider({
        auto: true,
        continuous: true,
        nextId: "nextBtn",
        prevId: "prevBtn"
    });
    $("#slider2").easySlider({ 
        auto: true,
        continuous: true,
        nextId: "slider1next",
        prevId: "slider1prev"
    });

    // addclass to playicon element parent
    $('.playicon').parent().addClass('video-thumb');

    // Move select menu on header
    $('.bg-container select').appendTo('.top-menu');

    // Select menu event
    $('.top-menu select').change(function(){
        var val = $(this).val();
        window.location.href = val; 
    });
});