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
}

/**
 * Inits the fixed header and runs resize functions
 *
 * @return void
 */
FixedHeader.prototype.resize = function() {
  this.resizeHeight();
  this.resizeWidth();
  this.fixedHeader.addClass('active');
};

/**
 * Resizes the fixed header columns width
 *
 * @return void
 */
FixedHeader.prototype.resizeWidth = function() {
  var fixedHeaderItems = this.fixedHeader.find('tr').children('td');
  this.fixedHeader.width(this.table.find('thead').width());
  this.table.find('tr').first().children('td').each(function(index) {
    var newWidth = $(this).width();
    $(fixedHeaderItems[index]).width(newWidth);
  });
};

/**
 * Resizes the fixed header columns height
 *
 * @return void
 */
FixedHeader.prototype.resizeHeight = function() {
  var newHeight = $(window).height() - this.fixedHeader.offset().top - $('.bottom-buttons').height();
  if(newHeight < this.table.height() && newHeight > 95) {
    this.table.parent('.table-fixed-header-wrap').height(newHeight);
  }
};

/**
 * Scrolls to bottom row
 *
 * @return void
 */
FixedHeader.prototype.scrollToBottom = function() {
  this.fixedHeader.scrollTop($('.table-fixed-header-wrap table').height());
};

/**
 * Load jquery methods to interact on el
 *
 * @return void
 */
$.fn.fixedHeader = function() {
  var fixedHeader = new FixedHeader($(this));
  fixedHeader.resize();
  $(window).resize(function() {
    fixedHeader.resize();
  });
  $('.js-new-item').on('click.fixedHeader', function(e) {
    e.preventDefault();
    fixedHeader.resize();
  });
};
