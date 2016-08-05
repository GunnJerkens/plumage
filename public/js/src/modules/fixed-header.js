/**
 * This is the fixed-header module, it resizes the fixed
 * header to the correct size.
 *
 */
/**
 * Declare our class Type
 *
 * @return void
 */
var fixedHeaderNode, table, topOffset;

function FixedHeader($fixedHeader) {
  fixedHeaderNode = $fixedHeader;
  table = $fixedHeader.next('table');
  topOffset = table.offset().top;
}

/**
 * Inits the fixed header and runs resize functions
 *
 * @return void
 */
FixedHeader.prototype.resize = function() {
  this.resizeWidth();
};

/**
 * Resizes the fixed header columns width
 *
 * @return void
 */
FixedHeader.prototype.resizeWidth = function() {
  var fixedHeaderItems = fixedHeaderNode.find('tr').children('td');
  fixedHeaderNode.width(table.width());
  table.find('tr').first().children('td').each(function(index) {
    var newWidth = $(this).width();
    $(fixedHeaderItems[index]).width(newWidth);
  });
};

/**
 * Scrolls to bottom row
 *
 * @return void
 */
FixedHeader.prototype.scrollToBottom = function() {
  $('body').scrollTop($(document).height());
};

/**
 * Sets fixed header to active when scrolled
 *
 * @return void
 */

 var latestKnownScrollY = 0,
 	ticking = false;

 function onScroll() {
 	latestKnownScrollY = window.scrollY;
 	requestTick();
 }

 function requestTick() {
 	if(!ticking) {
 		requestAnimationFrame(processScroll);
 	}
 	ticking = true;
 }

 function processScroll() {
	// reset the tick so we can
	// capture the next onScroll
	ticking = false;

	var currentScrollY = latestKnownScrollY;

	// read offset of DOM elements
	// and compare to the currentScrollY value
	// then apply some CSS classes
	// to the visible items

  if($('body').scrollTop() >= topOffset) {
    fixedHeaderNode.addClass('active');
    fixedHeaderNode.css('top', $('body').scrollTop());
  } else {
    fixedHeaderNode.removeClass('active');
  }
}

/**
 * Load jquery methods to interact on el
 *
 * @return void
 */
$.fn.fixedHeader = function() {
  var fixedHeader = new FixedHeader($(this));
  fixedHeader.resize();
  processScroll();
  $(window).resize(function() {
    fixedHeader.resize();
  });
  $(window).on('scroll', function() {
    onScroll();
  });
  $('.js-new-item').on('click.fixedHeader', function(e) {
    e.preventDefault();
    fixedHeader.resize();
    fixedHeader.scrollToBottom();
  });
};
