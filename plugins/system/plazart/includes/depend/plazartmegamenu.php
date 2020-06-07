<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2013 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
/**
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org
 *------------------------------------------------------------------------------
 */


defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('hidden');

// Import the com_menus helper.
require_once realpath(JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php');

/**
 * Supports an HTML select list of menus
 *
 * @package     Joomla.Libraries
 * @subpackage  Form
 * @since       1.6
 */
class JFormFieldPlazartMegaMenu extends JFormFieldHidden
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	public $type = 'PlazartMegaMenu';

	/**
	 * Method to get the list of menus for the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), JHtml::_('menu.menus'));

		return $options;
	}

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		return parent::getInput() . "\n" . $this->getMegaMenuMarkup();
	}

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getMegaMenuMarkup()
	{
		if(!defined('PLAZART')){
			return false;
		}

		if(!defined('PLAZART_TEMPLATE')){
			$this->loadPlazartDepend();
		}

		$plazartpath = PLAZART_ADMIN_PATH;
		
		if(!defined('__PLAZART_MEGAMENU_ASSET__')){
			define('__PLAZART_MEGAMENU_ASSET__', 1);

			$jdoc = JFactory::getDocument();

			if(is_file(PLAZART_PATH . '/css/megamenu.css')){
				$jdoc->addStylesheet(PLAZART_URL . '/css/megamenu.css');
			}

			if(is_file(PLAZART_ADMIN_PATH . '/admin/megamenu/css/megamenu.css')){
				$jdoc->addStylesheet(PLAZART_ADMIN_URL . '/admin/megamenu/css/megamenu.css');
			}

			if(version_compare(JVERSION, '3.0', 'ge')){
				JHtml::_('jquery.framework');
			} else {
				$jdoc->addScript(PLAZART_ADMIN_URL . '/admin/js/jquery-1.8.0.min.js');
				$jdoc->addScript(PLAZART_ADMIN_URL . '/admin/js/jquery.noconflict.js');
			}
			
			if(is_file(PLAZART_ADMIN_PATH . '/admin/megamenu/js/megamenu.js')){
				$jdoc->addScript(PLAZART_ADMIN_URL . '/admin/megamenu/js/megamenu.js');
			}
		}

		if(is_file(PLAZART_ADMIN_PATH . '/admin/megamenu/megamenu.tpl.php')){
			include PLAZART_ADMIN_PATH . '/admin/megamenu/megamenu.tpl.php';
		}

		if($this->element['hide']):
		?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($){
				$('#<?php echo $this->id ?>').closest('li, div.control-group').css('display', 'none');
			});
			//]]>
		</script>
		<?php
		endif;
	}

	/**
	 * Check and load assets file if needed
	 */
	function loadPlazartDepend(){
		if (!defined ('_PLAZART_DEPEND_ASSET_')) {
			define ('_PLAZART_DEPEND_ASSET_', 1);
			
			JFactory::getLanguage()->load(PLAZART_PLUGIN, JPATH_ADMINISTRATOR);
			
			$jdoc = JFactory::getDocument();	
			$jdoc->addStyleSheet(PLAZART_ADMIN_URL . '/includes/depend/css/depend.css');
			$jdoc->addScript(PLAZART_ADMIN_URL . '/includes/depend/js/depend.js');

			JFactory::getDocument()->addScriptDeclaration ( '
				jQuery.extend(PlazartDepend, {
					adminurl: \'' . JFactory::getURI()->toString() . '\',
					rooturl: \'' . JURI::root() . '\'
				});
			');
		}
	}
}