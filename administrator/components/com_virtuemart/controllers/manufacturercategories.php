<?php
/**
*
* Manufacturer category controller
*
* @package	VirtueMart
* @subpackage Manufacturer Category
* @author Patrick Kohl
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: manufacturercategories.php 9831 2018-05-07 13:45:33Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Manufacturer category controller
 *
 * @package    VirtueMart
 * @subpackage Manufacturer
 * @author
 */
class VirtuemartControllermanufacturercategories extends VmController {

	/**
	 * Method to display the view
	 *
	 * @access	public
	 * @author
	 */
	function __construct() {
		parent::__construct('virtuemart_manufacturercategories_id');

	}


}
// pure php no closing tag
