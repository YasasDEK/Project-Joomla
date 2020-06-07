<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers
 * @todo handle child products
 * @link https://virtuemart.net
 * @copyright Copyright (c) 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 7833 2014-04-09 15:04:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$product = $viewData['product'];

if(isset($viewData['rowHeights'])){
	$rowHeights = $viewData['rowHeights'];
} else {
	$rowHeights['customfields'] = TRUE;
}

$init = 1;
if(isset($viewData['init'])){
	$init = $viewData['init'];
}

if(!empty($product->min_order_level) and $init<$product->min_order_level){
	$init = $product->min_order_level;
}

$step=1;
if (!empty($product->step_order_level)){
	$step=$product->step_order_level;
	if(!empty($init)){
		if($init<$step){
			$init = $step;
		} else {
			$init = ceil($init/$step) * $step;

		}
	}
	if(empty($product->min_order_level) and !isset($viewData['init'])){
		$init = $step;
	}
}

$maxOrder= '';
if (!empty($product->max_order_level)){
	$maxOrder = ' max="'.$product->max_order_level.'" ';
}

$addtoCartButton = '';
if(!VmConfig::get('use_as_catalog', 0)){
	if(!$product->addToCartButton and $product->addToCartButton!==''){
		$addtoCartButton = self::renderVmSubLayout('addtocartbtn',array('orderable'=>$product->orderable)); //shopFunctionsF::getAddToCartButton ($product->orderable);
	} else {
		$addtoCartButton = $product->addToCartButton;
	}
}
$position = 'addtocart';

if ($product->min_order_level > 0) {
	$minOrderLevel = $product->min_order_level;
}
else {
	$minOrderLevel = 1;
}


if (!VmConfig::get('use_as_catalog', 0)  ) { ?>

    <div class="addtocart-bar">
	<?php
	// Display the quantity box
	$stockhandle = VmConfig::get('stockhandle_products', false) && $product->product_stockhandle ? $product->product_stockhandle : VmConfig::get('stockhandle','none');
	if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < $minOrderLevel) { ?>
        <a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $product->virtuemart_product_id); ?>" class="notify"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a><?php
	} else {
		$tmpPrice = (float) $product->prices['costPrice'];
		if (!( VmConfig::get('askprice', true) and empty($tmpPrice) ) ) {
			$editable = 'hidden';
			if ($product->orderable) {
				$editable = 'text';
			} ?>
            <!-- <label for="quantity<?php echo $product->virtuemart_product_id; ?>" class="quantity_box"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
            <span class="quantity-box">
				<input type="<?php echo $editable ?>" class="quantity-input js-recalculate" name="quantity[]"
                       data-errStr="<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>"
                       value="<?php echo $init; ?>" init="<?php echo $init; ?>" step="<?php echo $step; ?>" <?php echo $maxOrder; ?> />
			</span>
			<?php if ($product->orderable) { ?>
                <span class="quantity-controls js-recalculate">
				<input type="button" class="quantity-controls quantity-plus"/>
				<input type="button" class="quantity-controls quantity-minus"/>
			</span>
			<?php }

			if(!empty($addtoCartButton)){
				?><span class="addtocart-button">
				<?php echo $addtoCartButton ?>
                </span> <?php
			} ?>
            <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
            <noscript><input type="hidden" name="task" value="add"/></noscript> <?php
		}
	} ?>

    </div><?php
} ?>
