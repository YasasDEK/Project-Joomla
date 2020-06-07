<?php
function joomlaposition_37() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('dd-footer-6') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('dd-footer-6')) : ?>

    <?php if ($isPreview && !$view->containsModules('dd-footer-6')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-37 clearfix" <?php echo buildDataPositionAttr('dd-footer-6'); ?>>
        <?php echo $view->position('dd-footer-6', 'block%joomlaposition_block_37', '37'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('dd-footer-6')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}