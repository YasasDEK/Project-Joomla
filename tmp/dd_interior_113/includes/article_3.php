<?php function article_3($data) {
    ob_start();
    $attr = '';
    if (isset($data['article_id'])) {
        $attr = ' id="' . $data['postcontent_editor_id'] . '"';
    }
    $postIdClass = '';
    if (isset($data['post_id_class'])) {
        $postIdClass = ' data-post-value="data-post-id-' . $data['post_id_class'] . '"';
    }
    ?>
        
        <article class=" bd-article-3"<?php echo $attr; ?><?php echo $postIdClass; ?>>
            <div class=" bd-settopagebackground-3 bd-settopagebackground">
<div class=" bd-flexalign-3 bd-no-margins bd-flexalign">
<h2 class=" bd-postheader-3  "  itemprop="name">
    <?php if (isset($data['header-text']) && strlen($data['header-text'])) : ?>
        <?php if (isset($data['header-link']) && strlen($data['header-link'])) : ?>
            <a <?php echo funcBuildRoute($data['header-link'], 'href'); ?>>
                <?php echo $data['header-text'];?>
            </a>
        <?php else: ?>
            <?php echo $data['header-text']; ?>
        <?php endif; ?>
    <?php endif; ?>
</h2>
<?php if (isset($data['header-badge']) && strlen($data['header-badge'])) : ?>
    <?php echo $data['header-badge']; ?>
<?php endif; ?>
</div>
</div>
	
		<div class=" bd-layoutbox-8 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <?php if (isset($data['date-icons']) && count($data['date-icons'])) : ?>
<div class=" bd-posticondate-4 bd-no-margins">
    <span class=" bd-icon bd-icon-41"><span><?php
        $count = count($data['date-icons']);
        foreach ($data['date-icons'] as $key => $icon) {
            echo $icon;
            if ($key !== $count - 1) echo ' | ';
        }
    ?></span></span>
</div>
<?php endif; ?>
	
		<?php if (isset($data['author-icon']) && strlen($data['author-icon'])) : ?>
<div class=" bd-posticonauthor-5 bd-no-margins">
    <span class=" bd-icon bd-icon-43"><span><?php echo $data['author-icon']; ?></span></span>
</div>
<?php endif; ?>
	
		<?php if (isset($data['hits-icons']) && strlen($data['hits-icons'])) : ?>
<div class=" bd-posticonhits-27 bd-no-margins">
    <span class=" bd-icon bd-icon-91"><span><?php echo $data['hits-icons']; ?></span></span>
</div>
<?php endif; ?>
	
		<?php if (isset($data['print-icon'])) : ?>
<div class=" bd-posticonprint-6 bd-no-margins print-action">
    <?php preg_match('/<a(.*?")>[\s\S]+<\/a>/', $data['print-icon']['content'], $matches); ?>
    <a<?php echo $matches[1];?>>
    <?php if ($data['print-icon']['showIcon']) : ?>
        <?php if (JRequest::getVar('print', '') == '1') : ?>
            <?php echo JHtml::_('image', 'system/printButton.png', JText::_('JGLOBAL_PRINT'), null, true); ?>
        <?php else: ?>
            <span class=" bd-icon bd-icon-45"><span></span></span>
        <?php endif; ?>
    <?php else: ?>
    <span><?php echo JText::_('JGLOBAL_PRINT'); ?></span>
    <?php endif; ?>
    </a>
</div>
<?php endif; ?>
	
		<?php if (isset($data['email-icon'])) : ?>
<div class=" bd-posticonemail-7 bd-no-margins">
    <?php preg_match('/<a([^>]+)>[\s\S]+<\/a>/', $data['email-icon']['content'], $matches); ?>
    <a<?php echo $matches[1];?>>
    <?php if ($data['email-icon']['showIcon']) : ?>
    <span class=" bd-icon bd-icon-47"><span></span></span>
    <?php else: ?>
    <span><?php echo JText::_('JGLOBAL_EMAIL'); ?></span>
    <?php endif; ?>
    </a>
</div>
<?php endif; ?>
	
		<?php if (isset($data['edit-icon'])) : ?>
<div class=" bd-posticonedit-8 bd-no-margins">
    <?php preg_match('/<a([^>]+)>[\s\S]+<\/a>/', $data['edit-icon']['content'], $matches); ?>
    <a<?php echo $matches[1];?>>
    <?php if ($data['edit-icon']['showIcon']) : ?>
    <span class=" bd-icon bd-icon-49"><span></span></span>
    <?php else: ?>
    <span><?php echo JText::_('JGLOBAL_EDIT'); ?></span>
    <?php endif; ?>
    </a>
</div>
<?php endif; ?>
    </div>
</div>
	
		<div class=" bd-layoutbox-10 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <?php if (isset($data['data-image'])) : ?>
<?php
    $image = $data['data-image'];
    $caption = $image['caption'];
    $floatClass = $image['float'] ? ( 'pull-' . $image['float']) : '';
    ?>
<div class=" bd-postimage-3 <?php echo $floatClass; ?>">
    
    <?php if (isset($image['link']) && $image['link'] !== '') : ?>
    <a href="<?php echo $image['link']; ?>">
        <?php endif; ?>
        <img src="<?php echo $image['image']; ?>" alt="<?php echo $image['alt']; ?>" class=" bd-imagestyles" itemprop="image"/>
        <?php if (isset($image['link']) && $image['link'] !== '') : ?>
    </a>
    <?php endif; ?>
    
    <?php if ($caption): ?>
    <div class=" bd-container-54 bd-tagstyles ">
        <?php echo $caption; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
	
		<?php
    $attr = '';
    if (isset($data['postcontent_editor_id'])) {
        $attr = ' data-editable-id="' . $data['postcontent_editor_id'] . '"';
    }
?>
<div class=" bd-postcontent-3 bd-tagstyles bd-custom-blockquotes bd-contentlayout-offset" <?php echo $attr; ?> itemprop="articleBody">
    <?php if (isset($data['content']) && strlen($data['content'])):
        $content = funcPostprocessPostContent($data['content']);
        echo funcContentRoutesCorrector($content);
    endif; ?>
</div>
    </div>
</div>
	
		<div class=" bd-layoutbox-12 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <?php if (isset($data['category-icon']) && strlen($data['category-icon'])) : ?>
<div class=" bd-posticoncategory-9 bd-no-margins">
    <span class=" bd-icon bd-icon-50"><span><?php echo $data['category-icon']; ?></span></span>
</div>
<?php endif; ?>
	
		<?php if (isset($data['tags-icon'])) : ?>
<div class=" bd-posticontags-18 bd-no-margins">
            <span class=" bd-icon bd-icon-15"><span>
            <?php foreach($data['tags-icon'] as $key => $item) : ?>
            <?php $separator = ($key !== count($data['tags-icon']) - 1) ? ',' : ''; ?>
            <a href="<?php echo $item['href'];?>" itemprop="keywords">
                <?php echo $item['title'] . $separator; ?>
            </a>
            <?php endforeach; ?>
            </span></span>
</div>
<?php endif; ?>
    </div>
</div>
        </article>
        <div class="bd-container-inner"><?php if (isset($data['pager'])) : ?>
<div class=" bd-pager-3">
    <ul class=" bd-pagination pager">
        <?php if (preg_match('/<li[^>]*previous[^>]*>([\S\s]*?)<\/li>/', $data['pager'], $prevMatches)) : ?>
        <li class=" bd-paginationitem-1"><?php echo funcContentRoutesCorrector($prevMatches[1]); ?></li>
        <?php endif; ?>
        <?php if (preg_match('/<li[^>]*next[^>]*>([\S\s]*?)<\/li>/', $data['pager'], $nextMatches)) : ?>
        <li class=" bd-paginationitem-1"><?php echo funcContentRoutesCorrector($nextMatches[1]); ?></li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?></div>
        
<?php
    return ob_get_clean();
}