jQuery(document).ready(onDocReady);

function onDocReady () {
	var $ = jQuery;
	menuToggler();
	menuSticky();
	fixVHAfterLoad();

	// formhandling.js
	ajaxFeedbackForm();
	hideUpdateFields();
	resetFormLink();

	// userinfoedit.js
	userInfoEdit();

	// social.js
	socialFeed();

	// filters.js
	registerFilters();
}

function menuToggler () {

	var menuToggle = $('.js-menu-toggle'),
		menu = $('.primary-menu');

	menuToggle.click(function () {
		menu.toggleClass('opened');
		menuToggle.toggleClass('opened');
	});

}

function menuSticky() {
	var primaryMenu = $('.primary-menu');
	var biesImage = $('.bies__image');
	var posFromTop = primaryMenu.offset().top

	$(window).scroll(function() {
		var scroll = $(window).scrollTop();

		if (scroll > posFromTop) {
	    primaryMenu.addClass("primary-menu--sticky");
			biesImage.addClass("bies__image--sticky");
	  } else {
			primaryMenu.removeClass("primary-menu--sticky");
			biesImage.removeClass("bies__image--sticky");
	  }
	});

}

function fixVHAfterLoad() {
	$('.fix-me').height($('.fix-me').height());
}

// Polyfill from the lovely Brian Blakely (don’t know him but his polyfill is
// nice) https://jsfiddle.net/brianblakely/h3EmY/
(function templatePolyfill(d) {
	if('content' in d.createElement('template')) {
		return false;
	}

	var qPlates = d.getElementsByTagName('template'),
		plateLen = qPlates.length,
		elPlate,
		qContent,
		contentLen,
		docContent;

	for(var x=0; x<plateLen; ++x) {
		elPlate = qPlates[x];
		qContent = elPlate.childNodes;
		contentLen = qContent.length;
		docContent = d.createDocumentFragment();

		while(qContent[0]) {
			docContent.appendChild(qContent[0]);
		}

		elPlate.content = docContent;
	}
})(document);

// Polyfill from MDN for the .children property
(function(constructor) {
    if (constructor &&
        constructor.prototype &&
        constructor.prototype.children == null) {
        Object.defineProperty(constructor.prototype, 'children', {
            get: function() {
                var i = 0, node, nodes = this.childNodes, children = [];
                while (node = nodes[i++]) {
                    if (node.nodeType === 1) {
                        children.push(node);
                    }
                }
                return children;
            }
        });
    }
})(window.Node || window.Element);
