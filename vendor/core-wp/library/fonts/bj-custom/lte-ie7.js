/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'bj-custom\'">' + entity + '</span>' + html;
	}
	var icons = {
			'sss-ss-blog-logo' : '&#x73;',
			'sss-open' : '&#x21;',
			'sss-sale' : '&#x22;',
			'sss-image' : '&#x23;',
			'sss-cord' : '&#x24;',
			'sss-pictures' : '&#x25;',
			'sss-compass' : '&#x26;',
			'sss-star' : '&#xe00c;',
			'sss-star-2' : '&#xe000;',
			'sss-socket' : '&#xe001;',
			'sss-iconmonstr-star-7-icon' : '&#xe002;',
			'sss-compass-2' : '&#x3c;',
			'sss-compass-3' : '&#x3e;',
			'sss-facebook' : '&#x31;',
			'sss-twitter-old' : '&#x32;',
			'sss-share' : '&#x33;',
			'sss-feed' : '&#x34;',
			'sss-untitled' : '&#x67;',
			'sss-untitled-2' : '&#x66;',
			'sss-untitled-3' : '&#x69;',
			'sss-untitled-4' : '&#x6c;',
			'sss-untitled-5' : '&#x6e;',
			'sss-untitled-6' : '&#x72;',
			'sss-untitled-7' : '&#x2d;',
			'sss-untitled-8' : '&#x28;',
			'sss-untitled-9' : '&#x27;',
			'sss-untitled-10' : '&#x77;',
			'sss-untitled-11' : '&#xa0;',
			'sss-untitled-12' : '&#x68;',
			'sss-untitled-13' : '&#x6f;',
			'sss-untitled-14' : '&#x76;',
			'sss-untitled-15' : '&#xb9;',
			'sss-quote' : '&#x37;',
			'sss-quote-2' : '&#x36;'
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
		c = c.match(/sss-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};