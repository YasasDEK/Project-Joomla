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
$row =& $this->rows;
if($row->comment_enabled != 1)
	return;

if(($row->hikashop_vote_con_req_list == 1 && hikashop_loadUser() != "") || $row->hikashop_vote_con_req_list == 0) {
?>

<div class="hikashop_listing_comment">
    <div class="commentHeader">
        <h5 class="hkc-md-6"><?php echo JText::_('HIKASHOP_LISTING_COMMENT');?></h5>
        <?php
        if($row->vote_comment_sort_frontend) {
            $sort = hikaInput::get()->getString('sort_comment','');
            ?>
            <span class="hikashop_sort_listing_comment hkc-md-6">
		<select name="sort_comment" onchange="refreshCommentSort(this.value); return false;">
            <option <?php if($sort == 'date')echo "selected"; ?> value="date"><?php echo JText::_('HIKASHOP_COMMENT_ORDER_DATE');?></option>
            <option <?php if($sort == 'helpful')echo "selected"; ?> value="helpful"><?php echo JText::_('HIKASHOP_COMMENT_ORDER_HELPFUL');?></option>
        </select>
	</span>
        <?php
        }
        ?>
    </div>

<?php
	$i = 0;
	foreach($this->elts as $elt) {
		if(empty($elt->vote_comment))
			continue;
?>
    <div itemprop="review" itemscope itemtype="http://schema.org/Review" class="hika_comment_listing" style="width:100%;">
        <div class="hika_comment_listing_head">
            <div class="hika_comment_listing_name" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <?php if ($elt->vote_pseudo == '0') { ?>
                    <span itemprop="name" class="hika_vote_listing_username"><?php echo $elt->username; ?> </span>
                <?php } else { ?>
                    <span itemprop="name" class="hika_vote_listing_username" ><?php echo $elt->vote_pseudo; ?></span>
                <?php } ?>
            </div>
            <div class="hika_comment_listing_date">
                <?php if($row->show_comment_date) { ?>
                    <?php
                            $voteClass = hikashop_get('class.vote');
                            $vote = $voteClass->get($elt->vote_id);
                            echo hikashop_getDate($vote->vote_date);
                            ?>
                <?php } ?>
            </div>
            <div class="hika_comment_listing_notification" id="<?php echo $elt->vote_id; ?>"><?php
                if($row->useful_rating == 1){
                    if($elt->total_vote_useful != 0){
                        if($elt->vote_useful == 0) {
                            $hika_useful = $elt->total_vote_useful / 2;
                        } else if($elt->total_vote_useful == $elt->vote_useful) {
                            $hika_useful = $elt->vote_useful;
                        } else if($elt->total_vote_useful == -$elt->vote_useful) {
                            $hika_useful = 0;
                        } else {
                            $hika_useful = ($elt->total_vote_useful + $elt->vote_useful) /2;
                        }

                        $hika_useless = $elt->total_vote_useful - $hika_useful;
                        if($row->useful_style == 'helpful'){
                            echo JText::sprintf('HIKA_FIND_IT_HELPFUL', $hika_useful, $elt->total_vote_useful);
                        }
                    } else {
                        $hika_useless = 0;
                        $hika_useful  = 0;
                        if($row->useful_style == 'helpful' && $elt->vote_user_id != hikashop_loadUser() && $elt->vote_user_id != hikashop_getIP()) {
                            echo JText::_('HIKASHOP_NO_USEFUL');
                        }
                    }
                }
                ?></div>
            <?php
            if($row->useful_rating == 1) {
                if($row->hide == 0 && $elt->already_vote == 0 && $elt->vote_user_id != hikashop_loadUser() && $elt->vote_user_id != hikashop_getIP()){

                    if($row->useful_style == 'thumbs') {
                        ?>
                        <div class="hika_comment_listing_useful_p"><?php
                            echo $hika_useful;
                            ?></div>
                    <?php
                    }
                    ?>
                    <div class="hika_comment_listing_useful" title="<?php echo JText::_('HIKA_USEFUL'); ?>" onclick="if(!window.Oby.hasClass(this, 'next_button_disabled')) hikashop_vote_useful(<?php echo $elt->vote_id;?>,1); window.Oby.addClass(this, 'next_button_disabled');"></div>
                    <?php if($row->useful_style == 'thumbs'){?>
                        <div class="hika_comment_listing_useful_p"><?php
                            echo $hika_useless;
                            ?></div>
                    <?php } ?>
                    <div class="hika_comment_listing_useless" title="Useless" onclick="if(!window.Oby.hasClass(this, 'next_button_disabled')) hikashop_vote_useful(<?php echo $elt->vote_id;?>,2); window.Oby.addClass(this, 'next_button_disabled');"></div>
                <?php
                } else if($row->useful_style == "thumbs") {
                    ?>
                    <div class="hika_comment_listing_useful_p"><?php
                        echo $hika_useful;
                        ?></div>
                    <div class="hika_comment_listing_useful locked"></div>
                    <div class="hika_comment_listing_useless_p"><?php
                        echo $hika_useless;
                        ?></div>
                    <div class="hika_comment_listing_useless locked"></div>
                <?php
                } else {
                    ?>
                    <div class="hika_comment_listing_useful_p hide"></div>
                    <div class="hika_comment_listing_useful locked hide"></div>
                    <div class="hika_comment_listing_useless_p hide"></div>
                    <div class="hika_comment_listing_useless locked hide"></div>
                <?php
                }
            }
            ?>
            <div class="hika_comment_listing_stars hk-rating"><?php

                $nb_star_vote = $elt->vote_rating;
                hikaInput::get()->set("nb_star", $nb_star_vote);
                $nb_star_config = $row->vote_star_number;
                hikaInput::get()->set("nb_max_star", $nb_star_config);
                //var_dump($elt);
                if($nb_star_vote != 0) {
                    for($k = 0; $k < $nb_star_vote; $k++) {
                        ?><span class="hika_comment_listing_full_stars hk-rate-star state-full"></span><?php
                    }
                    $nb_star_empty = $nb_star_config - $nb_star_vote;
                    for($k = 0; $k < $nb_star_empty; $k++) {
                        ?><span class="hika_comment_listing_empty_stars hk-rate-star state-empty"></span><?php
                    }
                    ?>
                    <span style="display:none;" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
				<span itemprop="bestRating"><?php echo $nb_star_config; ?></span>
				<span itemprop="worstRating">1</span>
				<span itemprop="ratingValue"><?php echo $nb_star_vote; ?></span>
			</span>
                <?php
                }
                ?>
            </div>
        </div>
        <div id="<?php echo $i++; ?>" itemprop="reviewBody" class="hika_comment_listing_content"><?php echo nl2br($this->escape($elt->vote_comment)); ?></div>
        <div colspan="8" class="hika_comment_listing_bottom">
            <?php if(!empty ($elt->purchased)) { ?>
                <span class="hikashop_vote_listing_useful_bought"><?php echo JText::_('HIKASHOP_VOTE_BOUGHT_COMMENT'); ?></span>
            <?php } ?>
        </div>
    </div>
<?php

	}

	if(!count($this->elts)) {
?>
<table class="hika_comment_listing">
	<tr>
		<td class="hika_comment_listing_empty"><?php
			echo JText::_('HIKASHOP_NO_COMMENT_YET');
		?></td>
	</tr>
</table>
<?php
	} else {
		$this->pagination->form = '_hikashop_comment_form';
?>
<div class="pagination"><?php
	echo $this->pagination->getListFooter();
	echo $this->pagination->getResultsCounter();
?></div>
<?php
	}
?>
</div>
<?php
}
if($row->vote_comment_sort_frontend) {
	$jconfig = JFactory::getConfig();
	$sef = (HIKASHOP_J30 ? $jconfig->get('sef') : $jconfig->getValue('config.sef'));

	$sortUrl = $sef ? '/sort_comment-' : '&sort_comment=';
?>
<script type="text/javascript">
function refreshCommentSort(value){
	var url = window.location.href;
	if(url.match(/sort_comment/g)){
		url = url.replace(/\/sort_comment.?[a-z]*/g,'').replace(/&sort_comment.?[a-z]*/g,'');
	}
	url = url+'<?php echo $sortUrl; ?>'+value;
	document.location.href = url;
}
</script>
<?php }
