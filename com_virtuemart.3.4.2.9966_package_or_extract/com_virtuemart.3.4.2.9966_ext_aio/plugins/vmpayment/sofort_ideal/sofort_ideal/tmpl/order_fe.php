<?php
defined ('_JEXEC') or die();

/**
 * @author Valérie Isaksen
 * @version $Id: order_fe.php 9821 2018-04-16 18:04:39Z Milbo $
 * @package VirtueMart
 * @subpackage payment
 * @copyright Copyright (C) 2004-Copyright (C) 2004 - 2018 Virtuemart Team. All rights reserved.   - All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
 *
 * http://virtuemart.net
 */

?>
      <div class="payment_name" style="width: 100%">
 		<?php echo  $viewData['paymentName'] ; ?>
    </div>
<div class="response_transaction" style="width: 100%">
	<span class="response_transaction_title"><?php echo vmText::_ ('VMPAYMENT_SOFORT_IDEAL_RESPONSE_TRANSACTION'); ?> </span>
	<?php echo  $viewData['paymentInfos']->sofort_ideal_response_transaction; ?>
</div>







