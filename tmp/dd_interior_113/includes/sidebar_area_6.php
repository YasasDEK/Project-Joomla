<?php
    function sidebar_area_6() {
        $isPreview = $GLOBALS['theme_settings']['is_preview'];
        $GLOBALS['isModuleContentExists'] = false;
        ob_start();
?>
        <?php
    renderTemplateFromIncludes('joomlaposition_3');
?>
        <?php
            $content = trim(ob_get_clean());
            $modContentExists = $GLOBALS['isModuleContentExists'];
            $showContent = strlen(trim(preg_replace('/<!-- empty::begin -->[\s\S]*?<!-- empty::end -->/', '', $content)));
        ?>
        <?php if ($isPreview || ($content && true === $modContentExists)): ?>
            <aside class="bd-sidebararea-6-column  bd-flex-vertical bd-flex-fixed <?php echo ($isPreview && !$modContentExists) ? ' hidden bd-hidden-sidebar' : ''; ?>">
                <div class="bd-sidebararea-6 bd-flex-wide  bd-margins">
                    
                    <?php echo $content; ?>
                    
                </div>
            </aside>
        <?php endif; ?>
<?php
    }
?>