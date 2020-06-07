<?php
function joomlaposition_36() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('mod2') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('mod2')) : ?>

    <?php if ($isPreview && !$view->containsModules('mod2')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-36 clearfix" <?php echo buildDataPositionAttr('mod2'); ?>>
        <?php echo $view->position('mod2', 'block%joomlaposition_block_36', '36'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('mod2')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}