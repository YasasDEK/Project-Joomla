<?php
/**
*
* Coupon View
*
* @package	VirtueMart
* @subpackage Coupon
* @author RickG
 * @author Valerie Isaksen
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 9843 2018-05-18 22:39:36Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for maintaining the list of Coupons
 *
 * @package	VirtueMart
 * @subpackage Coupon
 * @author RickG
 * @author Valerie Isaksen
 */


class VirtuemartViewCoupon extends VmViewAdmin {

	function display($tpl = null) {

		// Load the helper(s)
		$model = VmModel::getModel();

		$layoutName = vRequest::getCmd('layout', 'default');


// 		if(Vmconfig::get('multix','none')!=='none'){
// 				$vendorList= ShopFunctions::renderVendorList($coupon->virtuemart_vendor_id);
// 				$this->assignRef('vendorList', $vendorList);
// 		}

		$vendorModel = VmModel::getModel('Vendor');
		$vendorModel->setId(1);
		$vendor = $vendorModel->getVendor();

		$currencyModel = VmModel::getModel('Currency');
		$currencyModel = $currencyModel->getCurrency($vendor->vendor_currency);
		$this->assignRef('vendor_currency', $currencyModel->currency_symbol);

		if ($layoutName == 'edit') {
			$coupon = $model->getCoupon();
			$this->SetViewTitle('', $coupon->coupon_code);
			if ($coupon->virtuemart_coupon_id < 1) {
				// Set a default expiration date
				$_expTime = explode(',', VmConfig::get('coupons_default_expire','14,D'));

				if (!empty( $_expTime[1]) && $_expTime[1] == 'W') {
					$_expTime[0] = $_expTime[0] * 7;
					$_expTime[1] = 'D';
				}
				if (version_compare(PHP_VERSION, '5.3.0', '<')) {
					$_dtArray = getdate(time());
					if ($_expTime[1] == 'D') {
						$_dtArray['mday'] += $_expTime[0];
					} elseif ($_expTime[1] == 'M') {
						$_dtArray['mon'] += $_expTime[0];
					} elseif ($_expTime[1] == 'Y') {
						$_dtArray['year'] += $_expTime[0];
					}
					$coupon->coupon_expiry_date =
						  mktime($_dtArray['hours'], $_dtArray['minutes'], $_dtArray['seconds']
						, $_dtArray['mon'], $_dtArray['mday'], $_dtArray['year']);
				} else {
					$_expDate = new DateTime();
					$_expDate->add(new DateInterval('P'.$_expTime[0].$_expTime[1]));
					$coupon->coupon_expiry_date = $_expDate->format("Y-m-d H:i:s");
				}
			}

			$this->assignRef('coupon',	$coupon);

			$this->addStandardEditViewCommands();
			if($this->showVendors()){
				$this->vendorList = Shopfunctions::renderVendorList($coupon->virtuemart_vendor_id);
			}
        } else {
			//$this->SetViewTitle('', $coupon->coupon_code);
			$this->addStandardDefaultViewCommands();
			$this->addStandardDefaultViewLists($model);

			$filter_coupon = vRequest::getString('filter_coupon', false);
			$this->coupons = $model->getCoupons($filter_coupon);

			$this->pagination = $model->getPagination();
			if($this->showVendors()){
				$this->vendorlist = Shopfunctions::renderVendorList($model->virtuemart_vendor_id, 'virtuemart_vendor_id', true);
			}
		}

		parent::display($tpl);
	}

}
// pure php no closing tag
