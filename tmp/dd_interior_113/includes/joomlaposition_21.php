<?php
function joomlaposition_21() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('dd-top-5') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('dd-top-5')) : ?>

    <?php if ($isPreview && !$view->containsModules('dd-top-5')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-21 clearfix" <?php echo buildDataPositionAttr('dd-top-5'); ?>>
        <?php echo $view->position('dd-top-5', 'block%joomlaposition_block_21', '21'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('dd-top-5')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}