<?php function article_6($data) {
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
        
        <article class=" bd-article-6"<?php echo $attr; ?><?php echo $postIdClass; ?>>
            <h2 class=" bd-postheader-6"  itemprop="name">
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
	
		<div class=" bd-layoutcontainer-22 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-49 
 col-md-6">
    <div class="bd-layoutcolumn-49 bd-column" ><div class="bd-vertical-align-wrapper"><?php if (isset($data['date-icons']) && count($data['date-icons'])) : ?>
<div class=" bd-posticondate-12">
    <span class=" bd-icon bd-icon-59"><span><?php
        $count = count($data['date-icons']);
        foreach ($data['date-icons'] as $key => $icon) {
            echo $icon;
            if ($key !== $count - 1) echo ' | ';
        }
    ?></span></span>
</div>
<?php endif; ?></div></div>
</div>
	
		<div class=" bd-columnwrapper-50 
 col-md-6">
    <div class="bd-layoutcolumn-50 bd-column" ><div class="bd-vertical-align-wrapper"><?php if (isset($data['author-icon']) && strlen($data['author-icon'])) : ?>
<div class=" bd-posticonauthor-13">
    <span class=" bd-icon bd-icon-61"><span><?php echo $data['author-icon']; ?></span></span>
</div>
<?php endif; ?></div></div>
</div>
            </div>
        </div>
    </div>
</div>
	
		<?php
    $attr = '';
    if (isset($data['postcontent_editor_id'])) {
        $attr = ' data-editable-id="' . $data['postcontent_editor_id'] . '"';
    }
?>
<div class=" bd-postcontent-6 bd-tagstyles  bd-contentlayout-offset" <?php echo $attr; ?> itemprop="articleBody">
    <?php if (isset($data['content']) && strlen($data['content'])):
        $content = funcPostprocessPostContent($data['content']);
        echo funcContentRoutesCorrector($content);
    endif; ?>
</div>
	
		<div class=" bd-layoutcontainer-23 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-51 
 col-md-4">
    <div class="bd-layoutcolumn-51 bd-column" ><div class="bd-vertical-align-wrapper"><?php if (isset($data['category-icon']) && strlen($data['category-icon'])) : ?>
<div class=" bd-posticoncategory-14">
    <span class=" "><span><?php echo $data['category-icon']; ?></span></span>
</div>
<?php endif; ?></div></div>
</div>
            </div>
        </div>
    </div>
</div>
        </article>
        <div class="bd-container-inner"><?php if (isset($data['pager'])) : ?>
<div class=" bd-pager-6">
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