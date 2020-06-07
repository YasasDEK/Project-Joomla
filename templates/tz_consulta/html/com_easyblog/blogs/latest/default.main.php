<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2017 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting" class="eb-post" data-blog-posts-item data-id="<?php echo $post->id;?>">

	<div class="eb-post-content">
        <?php echo $this->output('site/blogs/latest/post.cover', array('post' => $post)); ?>
        <?php echo $this->output('site/blogs/admin.tools', array('post' => $post, 'return' => $return)); ?>
		<div class="eb-post-head no-overflow">
			<?php if ($this->params->get('post_date', true) || $this->params->get('post_author', true) || $this->params->get('post_category', true)) { ?>
			<div class="eb-post-meta text-muted">
                <?php if ($this->config->get('layout_avatar') && $this->params->get('post_author_avatar', true)) { ?>
                    <div class="eb-post-avatar mr-15">
                        <div class="eb-post-author-avatar single" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                            <a href="<?php echo $post->getAuthorPermalink(); ?>" class="eb-avatar" itemtype="https://schema.org/ImageObject" itemscope="" itemprop="logo">
                                <img src="<?php echo $post->creator->getAvatar();?>" width="32" height="32" alt="<?php echo $post->getAuthorName();?>" />
                                <meta content="<?php echo $post->creator->getAvatar();?>" itemprop="url">
                                <meta content="32" itemprop="width">
                                <meta content="32" itemprop="height">
                            </a>
                            <meta content="<?php echo EB::showSiteName(); ?>" itemprop="name">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($post->isFeatured) { ?>
                    <div class="eb-post-featured">
                        <i class="fa fa-star" data-original-title="<?php echo JText::_('COM_EASYBLOG_POST_IS_FEATURED');?>" data-placement="bottom" data-eb-provide="tooltip"></i>
                        <?php echo JText::_('COM_EASYBLOG_FEATURED');?>
                    </div>
                <?php } ?>
				<?php if ($this->params->get('post_type', true)) { ?>
				<div class="eb-post-type">
					<?php echo $post->getIcon(); ?>
				</div>
				<?php } ?>

				<?php if ($this->params->get('post_author', true)) { ?>
				<div class="eb-post-author" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
					<i class="fa fa-user"></i>
					<span itemprop="name">
						<a href="<?php echo $post->getAuthorPermalink();?>" itemprop="url" rel="author"><?php echo $post->getAuthorName();?></a>
					</span>
				</div>
				<?php } ?>

				<?php if ($post->isTeamBlog() && $this->config->get('layout_teamavatar')) { ?>
				<div class="eb-post-meta-team">
					<a href="<?php echo $post->getBlogContribution()->getPermalink(); ?>" class="">
						<img src="<?php echo $post->getBlogContribution()->getAvatar();?>" width="16" height="16" alt="<?php echo $post->getBlogContribution()->getTitle();?>" />
					</a>
					<span itemprop="">
						<a href="<?php echo $post->getBlogContribution()->getPermalink(); ?>" class="">
							<?php echo $post->getBlogContribution()->getTitle();?>
						</a>
					</span>
				</div>
				<?php } ?>

				<?php if ($this->params->get('post_date', true)) { ?>
				<div class="eb-post-date">
					<i class="fa fa-clock-o"></i>
					<time class="eb-meta-date" itemprop="datePublished" content="<?php echo $post->getDisplayDate($this->params->get('post_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC4'));?>">
						<?php echo $post->getDisplayDate($this->params->get('post_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC1')); ?>
					</time>
				</div>
				<?php } ?>

				<?php if ($this->params->get('post_category', true) && $post->categories) { ?>
				<div class="eb-post-category comma-seperator">
					<i class="fa fa-folder-open"></i>
					<?php foreach ($post->categories as $category) { ?>
					<span>
						<a href="<?php echo $category->getPermalink();?>"><?php echo $category->getTitle();?></a>
					</span>
					<?php } ?>
				</div>
				<?php } ?>

				<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>

				<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" class="hidden">
					<img src="<?php echo $post->getImage($this->config->get('cover_size', 'large'));?>" alt="<?php echo $this->html('string.escape', $post->getImageTitle());?>"/>
					<meta itemprop="url" content="<?php echo $post->getImage($this->config->get('cover_size', 'large'));?>">
					<meta itemprop="width" content="<?php echo $this->config->get('cover_width');?>">
					<meta itemprop="height" content="<?php echo $this->config->get('cover_height');?>">
				</div>

				<meta itemprop="dateModified" content="<?php echo $post->getFormDateValue('modified');?>"/>
			</div>
			<?php } ?>

            <?php if ($post->getType() == 'quote') { ?>
                <div class="eb-post-headline">
                    <h2 itemprop="name headline" class="eb-post-title reset-heading">
                        <a href="<?php echo $post->getPermalink();?>" class="text-inherit"><?php echo nl2br($post->title);?></a>
                    </h2>

                    <div class="eb-post-headline-source">
                        <?php echo $post->getContent(); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($post->getType() == 'link') { ?>
                <div class="eb-post-headline">
                    <h2 itemprop="name headline" class="eb-placeholder-link-title eb-post-title reset-heading">
                        <a href="<?php echo $post->getPermalink();?>"><?php echo nl2br($post->title);?></a>
                    </h2>

                    <div class="eb-post-headline-source">
                        <a href="<?php echo $post->getAsset('link')->getValue(); ?>" target="_blank"><?php echo $post->getAsset('link')->getValue();?></a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($post->getType() == 'twitter') { ?>
                <?php $screen_name = $post->getAsset('screen_name')->getValue();
                $created_at = EB::date($post->getAsset('created_at')->getValue(), true)->format(JText::_('DATE_FORMAT_LC'));
                ?>
                <div class="eb-post-headline">
                    <h2 itemprop="name headline" class="eb-post-title-tweet reset-heading">
                        <?php echo $post->content;?>
                    </h2>

                    <?php if (!empty($screen_name) && !empty($created_at)) { ?>
                        <div class="eb-post-headline-source">
                            <?php echo '@'.$screen_name.' - '.$created_at; ?>
                            &middot;
                            <a href="<?php echo $post->getPermalink();?>">
                                <?php echo JText::_('COM_EASYBLOG_LINK_TO_POST'); ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ((in_array($post->posttype, array('photo', 'standard', 'video', 'email'))) && $this->params->get('post_title', true)) { ?>
                <h2 itemprop="name headline" class="eb-post-title reset-heading">
                    <a href="<?php echo $post->getPermalink();?>" class="text-inherit"><?php echo $post->title;?></a>
                </h2>
            <?php } ?>
		</div>

		<?php if (in_array($post->getType(), array('photo', 'standard', 'twitter', 'email', 'link'))) { ?>
			<div class="eb-post-body type-<?php echo $post->posttype; ?>">
				<?php echo $post->getIntro();?>
			</div>
		<?php } ?>

		<?php if ($post->posttype == 'video') { ?>
		<div class="eb-post-video">
			<?php foreach ($post->videos as $video) { ?>
			<div class="eb-responsive-video">
				<?php echo $video->html;?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

		<?php if ($post->hasReadmore() && $this->params->get('post_readmore', true)) { ?>
			<div class="eb-post-more mt-15">
				<a class="btn btn-default" href="<?php echo $post->getPermalink();?>"><?php echo JText::_('COM_EASYBLOG_CONTINUE_READING');?></a>
			</div>
		<?php } ?>

		<?php if ($post->fields && $this->params->get('post_fields', true)) { ?>
			<?php echo $this->output('site/blogs/entry/fields', array('fields' => $post->fields, 'post'=>$post)); ?>
		<?php } ?>

		<?php if ($this->params->get('post_tags', true)) { ?>
			<?php echo $this->output('site/blogs/tags/item', array('post' => $post)); ?>
		<?php } ?>

		<?php if ($this->config->get('main_ratings') && $this->params->get('post_ratings', true)) { ?>
			<div class="eb-post-rating">
				<?php echo $this->output('site/ratings/frontpage', array('post' => $post, 'locked' => $this->config->get('main_ratings_frontpage_locked'))); ?>
			</div>
		<?php } ?>

		<?php if ($post->copyrights && $this->params->get('post_copyrights', true)) { ?>
			<div class="eb-entry-copyright">
				<h4 class="eb-section-title"><?php echo JText::_('COM_EASYBLOG_COPYRIGHT_HEADING');?></h4>
				<p>&copy; <?php echo $post->copyrights;?></p>
			</div>
		<?php } ?>

		<?php if ($this->params->get('post_social_buttons', true)) { ?>
			<?php echo EB::socialbuttons()->html($post, 'listings'); ?>
		<?php } ?>

		<?php if ($post->allowComments()) { ?>
			<?php echo $this->output('site/blogs/latest/part.comments', array('post' => $post)); ?>
		<?php } ?>

		<div class="eb-post-foot">
			<?php if ($this->params->get('post_hits', true)) { ?>
				<div class="col-cell eb-post-hits">
					<i class="fa fa-eye"></i> <?php echo JText::sprintf('COM_EASYBLOG_POST_HITS', $post->hits);?>
				</div>
			<?php } ?>

			<?php if ($post->getTotalComments() !== false && $this->params->get('post_comment_counter', true)) { ?>
				<div class="col-cell eb-post-comments">
					<i class="fa fa-comments"></i>
					<a href="<?php echo $post->getCommentsPermalink();?>"><?php echo $this->getNouns('COM_EASYBLOG_COMMENT_COUNT', $post->getTotalComments(), true); ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
