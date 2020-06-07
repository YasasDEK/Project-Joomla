<?php
function joomlaposition_30() {
    $document = JFactory::getDocument();
    $view = $document->view;
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('post2') ? true : false;
?>
    <?php if ($isPreview || $view->containsModules('post2')) : ?>

    <?php if ($isPreview && !$view->containsModules('post2')) : ?>
    <!-- empty::begin -->
    <?php endif; ?>
    <div class=" bd-joomlaposition-30 animated bd-animation-92 clearfix" data-animation-name="fadeIn" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="300ms" data-animation-infinited="false" <?php echo buildDataPositionAttr('post2'); ?>>
        <?php echo $view->position('post2', 'block%joomlaposition_block_30', '30'); ?>
    </div>
    <?php if ($isPreview && !$view->containsModules('post2')) : ?>
    <!-- empty::end -->
    <?php endif; ?>
    <?php endif; ?>
<?php
}