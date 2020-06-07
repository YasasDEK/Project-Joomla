<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) : ?>
	<li itemscope itemtype="https://schema.org/Article">
        <?php
        $images =   json_decode($item->images);
        $backgrounds    =   ['#e7c1ad','#bfd8bd','#9c95dc','#d0c2d7','#9c73ac'];
        ?>
        <div class="post_media col-md-4 col-sm-3 col-xs-12">
            <?php if ($images->image_intro) : ?>
                <a class="post_image" href="<?php echo $item->link ; ?>" style="background-image:url(<?php echo $images->image_intro; ?>)" title="<?php echo $images->image_intro_caption; ?>"></a>
            <?php else: ?>
                <span class="post_icon" style="background-color: <?php echo $backgrounds[rand(0,4)]; ?>"><?php echo substr($item->title,0,1); ?></span>
            <?php endif; ?>
        </div>
        <div class="info col-md-8 col-sm-9 col-xs-12">
            <a href="<?php echo $item->link; ?>" itemprop="url" class="post_title">
			<h4 itemprop="name">
				<?php echo $item->title; ?>
			</h4>
            </a>
            <time><?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC')); ?></time>
        </div>
	</li>
<?php endforeach; ?>
</ul>
