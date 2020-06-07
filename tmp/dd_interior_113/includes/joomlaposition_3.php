<?php
function joomlaposition_3() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('bottom-banner-1') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('bottom-banner-1')) : ?>

    <?php if ($isPreview && !$view->containsModules('bottom-banner-1')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-3 clearfix" <?php echo buildDataPositionAttr('bottom-banner-1'); ?>>
        <?php echo $view->position('bottom-banner-1', 'block%joomlaposition_block_3', '3'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('bottom-banner-1')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}