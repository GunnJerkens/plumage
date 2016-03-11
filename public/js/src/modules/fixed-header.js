/**
 * This is the fixed-header module, it resizes the fixed
 * header to the correct size.
 *
 */
var fixedHeader;
/**
 * Declare our class Type
 *
 * @return void
 */
function FixedHeader() {

}

/**
 * Inits the fixed header and runs resize functions
 *
 * @return void
 */
FixedHeader.prototype.resize = function() {
  var _this = this;
  $('.table-fixed-header').each(function() {
    var fixedHeaderItems = $(this).find('tr').children('td');
    var tableId = $(this).attr('table-id');
    _this.resizeHeight(tableId);
    _this.resizeWidth(tableId, fixedHeaderItems, $(this));
    $(this).addClass('active');
  });
};

/**
 * Resizes the fixed header columns width
 *
 * @return void
 */
FixedHeader.prototype.resizeWidth = function(tableId, fixedHeaderItems, $fixedHeader) {
  $fixedHeader.width($('#'+tableId).find('thead').width());
  $('#'+tableId+' tr').first().children('td').each(function(index) {
    var newWidth = $(this).width();
    $(fixedHeaderItems[index]).width(newWidth);
  });
};

/**
 * Resizes the fixed header columns height
 *
 * @return void
 */
FixedHeader.prototype.resizeHeight = function(tableId) {
  var newHeight = $(window).height() - $('#'+tableId).offset().top - $('.bottom-buttons').height();
  if(newHeight < $('#'+tableId).height() && newHeight > 95) {
    $('#'+tableId).parent('.table-fixed-header-wrap').height(newHeight);
  }
};

/**
 * Scrolls to bottom row
 *
 * @return void
 */
FixedHeader.prototype.scrollToBottom = function() {
  $('.table-fixed-header-wrap').scrollTop($('.table-fixed-header-wrap table').height());
};

fixedHeader = new FixedHeader();
fixedHeader.resize();
$(window).resize(function() {
  fixedHeader.resize();
});
