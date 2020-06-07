<?php
function joomlaposition_29() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('dd-footer-2') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('dd-footer-2')) : ?>

    <?php if ($isPreview && !$view->containsModules('dd-footer-2')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-29 clearfix" <?php echo buildDataPositionAttr('dd-footer-2'); ?>>
        <?php echo $view->position('dd-footer-2', 'block%joomlaposition_block_29', '29'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('dd-footer-2')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}