<?php
function joomlaposition_4() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('mod1') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('mod1')) : ?>

    <?php if ($isPreview && !$view->containsModules('mod1')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-4 clearfix" <?php echo buildDataPositionAttr('mod1'); ?>>
        <?php echo $view->position('mod1', 'block%joomlaposition_block_4', '4'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('mod1')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}