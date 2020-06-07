<?php
function joomlaposition_19() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('dd-top-4') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('dd-top-4')) : ?>

    <?php if ($isPreview && !$view->containsModules('dd-top-4')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-19 clearfix" <?php echo buildDataPositionAttr('dd-top-4'); ?>>
        <?php echo $view->position('dd-top-4', 'block%joomlaposition_block_19', '19'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('dd-top-4')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}