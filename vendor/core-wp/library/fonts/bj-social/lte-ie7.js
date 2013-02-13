/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'bj-social\'">' + entity + '</span>' + html;
	}
	var icons = {
			'social-facebook' : '&#x61;',
			'social-twitter' : '&#x62;',
			'social-twitter-2' : '&#x63;',
			'social-twitter-3' : '&#x64;',
			'social-facebook-2' : '&#x65;',
			'social-gplus' : '&#x66;',
			'social-google-plus' : '&#x67;',
			'social-feed' : '&#x68;',
			'social-feed-2' : '&#x69;',
			'social-feed-3' : '&#x6a;',
			'social-pinterest' : '&#x6b;',
			'social-pinterest-2' : '&#x6c;',
			'social-linkedin' : '&#x6d;',
			'social-skype' : '&#x6e;',
			'social-flickr' : '&#x6f;',
			'social-flickr-2' : '&#x70;',
			'social-flickr-3' : '&#x71;',
			'social-forrst' : '&#x72;',
			'social-yahoo' : '&#x73;',
			'social-deviantart' : '&#x74;',
			'social-deviantart-2' : '&#x75;',
			'social-wordpress' : '&#x76;',
			'social-wordpress-2' : '&#x77;',
			'social-stumbleupon' : '&#x78;',
			'social-stumbleupon-2' : '&#x79;',
			'social-tumblr' : '&#x7a;',
			'social-tumblr-2' : '&#x31;',
			'social-dribbble' : '&#x32;',
			'social-dribbble-2' : '&#x33;',
			'social-picassa' : '&#x34;',
			'social-blogger' : '&#x35;',
			'social-blogger-2' : '&#x36;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/social-[^\s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};