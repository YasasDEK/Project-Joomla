<?php
function hmenu_6() {
    $view = JFactory::getDocument()->view;
    $modulesContains = $view->containsModules('position-1');
    $isPreview  = $GLOBALS['theme_settings']['is_preview'];
    if (isset($GLOBALS['isModuleContentExists']) && false == $GLOBALS['isModuleContentExists'])
        $GLOBALS['isModuleContentExists'] = $view->containsModules('position-1') ? true : false;
    ?>
    <?php if ($isPreview || $modulesContains) : ?>
        <div data-affix
     data-offset=""
     data-fix-at-screen="top"
     data-clip-at-control="top"
     
 data-enable-lg
     
 data-enable-md
     
 data-enable-sm
     
     class=" bd-affix-5 bd-no-margins bd-margins ">
        <nav class=" bd-hmenu-6 "  data-responsive-menu="true" data-responsive-levels="expand on click" data-responsive-type="offcanvas" data-offcanvas-delay="0ms" data-offcanvas-duration="700ms" data-offcanvas-timing-function="ease">
            <?php if ($view->containsModules('position-1')) : ?>
            
                <div class=" bd-menuoverlay-4 bd-menu-overlay"></div>
                <div class=" bd-responsivemenu-10 collapse-button">
    <div class="bd-container-inner">
        <div class="bd-menuitem-77 ">
            <a  data-toggle="collapse"
                data-target=".bd-hmenu-6 .collapse-button + .navbar-collapse"
                href="#" onclick="return false;">
                    <span></span>
            </a>
        </div>
    </div>
</div>
                <div class="navbar-collapse collapse width">
            <?php echo $view->position('position-1', '', '6', 'hmenu'); ?>
                <div class="bd-menu-close-icon">
    <a href="#" class="bd-icon  bd-icon-103"></a>
</div>
            
                </div>
            <?php else: ?>
                Please add a menu module in the 'position-1' position
            <?php endif; ?>
        </nav>
        </div>
    <?php endif; ?>
<?php
}