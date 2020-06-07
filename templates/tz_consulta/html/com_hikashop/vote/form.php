<?php
/**
 * @package	HikaShop for Joomla!
 * @version	3.2.0
 * @author	hikashop.com
 * @copyright	(C) 2010-2017 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

if(empty($this->row->comment_enabled) || $this->row->comment_enabled == 0)
	return;

$row =& $this->row;

if($row->access_vote == 'registered' && hikashop_loadUser() == null) {
	echo '<div class="hikashop_vote_comment_not_allowed">' . JText::_('ONLY_REGISTERED_CAN_COMMENT') . '</div>';
	return;
}

if($row->access_vote == 'buyed' && $row->purchased == 0) {
	echo '<div class="hikashop_vote_comment_not_allowed">' . JText::_('MUST_HAVE_BUY_TO_VOTE') . '</div>';
	return;
}

$row->hikashop_vote_average_score = (float)hikashop_toFloat($row->hikashop_vote_average_score);
if($row->hikashop_vote_total_vote == '0') {
	$tooltip = JText::_('HIKA_NO_VOTE');
} else {
	$user_rating = JText::_('HIKA_NO_VOTE');
	if(isset($this->user_vote->vote_rating))
		$user_rating = $this->user_vote->vote_rating;
	$tooltip = JText::sprintf('HIKA_VOTE_TOOLTIP', $row->hikashop_vote_average_score, $row->hikashop_vote_total_vote, $user_rating);
}
?>
<div class="hikashop_vote_form">
    <h5 class="hikashop_form_comment ui-corner-top"><?php echo JText::_('HIKASHOP_LET_A_COMMENT'); ?></h5>
<?php
if($row->vote_enabled == 1) {
?>
	<div class="hikashop_vote_stars"><?php echo JText::_('VOTE'); ?>:<br />
		<input type="hidden" name="hikashop_vote_rating" data-max="<?php echo $row->hikashop_vote_nb_star; ?>" data-votetype="<?php echo $row->type_item; ?>" data-ref="<?php echo $row->vote_ref_id; ?>" data-rate="<?php echo $row->hikashop_vote_average_score_rounded; ?>" data-original-title="<?php echo $tooltip ?>" id="hikashop_vote_rating_id" />
	</div>
	<div class="clear_both"></div>
<?php
} else {
?>
	<input type="hidden" name="hikashop_vote_rating" data-votetype="<?php echo $row->type_item; ?>" data-ref="<?php echo $row->vote_ref_id; ?>" id="hikashop_vote_rating_id" />
<?php
}
?>
	<div id='hikashop_vote_status_form' class="hikashop_vote_notification" ></div>

<?php
if(hikashop_loadUser() == null) {
?>
    <div class="hikashop_comment_form">
        <div class="hikashop_comment_form_name"><?php echo JText::_('HIKA_USERNAME'); ?>:</div>
        <div class="hikashop_comment_form_input"><input  type='text' name="pseudo_comment" id='pseudo_comment' /></div>
    </div>
    <?php
    if ($row->email_comment == 1) {
        ?>
        <div class="hikashop_comment_form_mail"><?php echo JText::_('HIKA_EMAIL'); ?>:</div>
        <div class="hikashop_comment_form_input"><input  type='text' name="email_comment" id='email_comment' value=''/></div>
    <?php
    } else {
        ?>
        <input type='hidden' name="email_comment" id='email_comment' value='0'/>
    <?php
    }
    ?>
<?php
} else {
?>
	<input type='hidden' name="pseudo_comment" id='pseudo_comment' value='0'/>
	<input type='hidden' name="email_comment" id='email_comment' value='0'/>
<?php
	}
?>
	<textarea type="text" name="hikashop_vote_comment" id="hikashop_vote_comment" class="hikashop_comment_textarea" placeholder="<?php echo JText::_('HIKASHOP_POST_COMMENT');?>"></textarea>
	<input class="button btn" type="button" value="<?php echo JText::_('HIKASHOP_SEND_COMMENT'); ?>" onclick="hikashop_send_comment();"/>
</div>
