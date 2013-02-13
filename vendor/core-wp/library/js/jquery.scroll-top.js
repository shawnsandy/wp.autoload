/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * http://davidwalsh.name/jquery-top-link
 */

jQuery.fn.topLink = function(settings) {
	settings = jQuery.extend({
		min: 1,
		fadeSpeed: 200
	}, settings);
	return this.each(function() {
		//listen for scroll
		var el = jQuery(this);
		el.hide(); //in case the user forgot
		jQuery(window).scroll(function() {
			if(jQuery(window).scrollTop() >= settings.min)
			{
				el.fadeIn(settings.fadeSpeed);
			}
			else
			{
				el.fadeOut(settings.fadeSpeed);
			}
		});
	});
};

//usage w/ smoothscroll
jQuery(document).ready(function($) {
	//set the link
	$('#top-link').topLink({
		min: 400,
		fadeSpeed: 500
	});
	//smoothscroll
	$('#top-link').click(function(e) {
		e.preventDefault();
		$.scrollTo(0,300);
	});
});