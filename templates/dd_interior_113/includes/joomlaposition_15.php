<?php
function joomlaposition_15() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('post1') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('post1')) : ?>

    <?php if ($isPreview && !$view->containsModules('post1')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-15 animated bd-animation-65 clearfix" data-animation-name="fadeIn" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="0ms" data-animation-infinited="false" <?php echo buildDataPositionAttr('post1'); ?>>
        <?php echo $view->position('post1', 'block%joomlaposition_block_15', '15'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('post1')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}