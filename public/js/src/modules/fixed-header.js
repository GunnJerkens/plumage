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
function FixedHeader($fixedHeader) {
  this.fixedHeader = $fixedHeader;
  this.table = $fixedHeader.next('.table-fixed-header-wrap').find('table');
  this.topOffset = this.table.offset().top;
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
  if($(window).width() < 768) {
    return false
  }
  var fixedHeaderItems = this.fixedHeader.find('tr').children('td');
  this.fixedHeader.width(this.table.find('thead').width());
  this.table.find('tr').first().children('td').each(function(index) {
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
FixedHeader.prototype.processScroll = function() {
  if($(window).width() < 768) {
    return false
  }
  if($('body').scrollTop() >= this.topOffset) {
    this.fixedHeader.addClass('active');
  } else {
    this.fixedHeader.removeClass('active');
  }
};

/**
 * Load jquery methods to interact on el
 *
 * @return void
 */
$.fn.fixedHeader = function() {
  var fixedHeader = new FixedHeader($(this));
  fixedHeader.resize();
  fixedHeader.processScroll();
  $(window).resize(function() {
    fixedHeader.resize();
  });
  $(window).on('scroll', function() {
    fixedHeader.processScroll();
  });
  $('.js-new-item').on('click.fixedHeader', function(e) {
    e.preventDefault();
    fixedHeader.resize();
    fixedHeader.scrollToBottom();
  });
};
