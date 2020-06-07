<?php
function joomlaposition_25() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('dd-top-7') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('dd-top-7')) : ?>

    <?php if ($isPreview && !$view->containsModules('dd-top-7')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-25 clearfix" <?php echo buildDataPositionAttr('dd-top-7'); ?>>
        <?php echo $view->position('dd-top-7', 'block%joomlaposition_block_25', '25'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('dd-top-7')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}