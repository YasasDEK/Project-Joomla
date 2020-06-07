<?php
function joomlaposition_16() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('topbanner-1') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('topbanner-1')) : ?>

    <?php if ($isPreview && !$view->containsModules('topbanner-1')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-16 bd-no-margins clearfix" <?php echo buildDataPositionAttr('topbanner-1'); ?>>
        <?php echo $view->position('topbanner-1', 'block%joomlaposition_block_16', '16'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('topbanner-1')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}