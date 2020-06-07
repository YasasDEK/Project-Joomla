<?php
defined ('_JEXEC') or die();
/**
 *
 * @package	VirtueMart
 * @subpackage   Models Fields
 * @author Valérie Isaksen
 * @link https://virtuemart.net
 * @copyright Copyright (c) 2004 - 2011 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id$
 */

if (!class_exists( 'VmConfig' )) require(JPATH_ROOT .'/administrator/components/com_virtuemart/helpers/config.php');

/**
 * Supports a modal product picker.
 *
 *
 */
class JFormFieldVendor extends JFormField {

	var $type = 'vendor';
	
	function getInput() {
		VmConfig::loadConfig();
		vmLanguage::loadJLang('com_virtuemart');
		$key = ($this->element['key_field'] ? $this->element['key_field'] : 'value');
		$val = ($this->element['value_field'] ? $this->element['value_field'] : $this->name);
		$model = VmModel::getModel('vendor');

		$vendors = $model->getVendors(true, true, false);
		return JHtml::_('select.genericlist', $vendors, $this->name, 'class="inputbox"  size="1"', 'virtuemart_vendor_id', 'vendor_name', $this->value, $this->id);
	}
}