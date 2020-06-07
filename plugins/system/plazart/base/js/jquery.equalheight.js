/** 
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/plazartfw
 * @Link:         http://plazart-framework.org 
 *------------------------------------------------------------------------------
 */

;(function ($) {
	$.fn.equalHeight = function (options){
		var tallest = 0;
		$(this).each(function() {
			$(this).css({height:"", "min-height":""});
			var thisHeight = $(this).height();
			if(thisHeight > tallest) {
				tallest = thisHeight;
			}
		});

		$(this).each(function() {
			$(this).css( "min-height", tallest );
		});
	}
})(jQuery);