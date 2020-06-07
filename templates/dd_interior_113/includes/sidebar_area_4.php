<?php
    function sidebar_area_4() {
        $isPreview = $GLOBALS['theme_settings']['is_preview'];
        $GLOBALS['isModuleContentExists'] = false;
        ob_start();
?>
        <section class=" bd-section-24 bd-tagstyles" id="section5" data-section-title="modules">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-38 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-92 
 col-lg-3
 col-sm-6">
    <div class="bd-layoutcolumn-92 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_27');
?></div></div>
</div>
	
		<div class=" bd-columnwrapper-96 
 col-lg-3
 col-sm-6">
    <div class="bd-layoutcolumn-96 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_29');
?></div></div>
</div>
	
		<div class=" bd-columnwrapper-100 
 col-lg-3
 col-sm-6">
    <div class="bd-layoutcolumn-100 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_31');
?></div></div>
</div>
	
		<div class=" bd-columnwrapper-103 
 col-lg-3
 col-sm-6">
    <div class="bd-layoutcolumn-103 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_33');
?></div></div>
</div>
            </div>
        </div>
    </div>
</div>
	
		<div class=" bd-layoutcontainer-40 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-105 
 col-sm-6">
    <div class="bd-layoutcolumn-105 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_35');
?></div></div>
</div>
	
		<div class=" bd-columnwrapper-107 
 col-sm-6">
    <div class="bd-layoutcolumn-107 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_37');
?></div></div>
</div>
            </div>
        </div>
    </div>
</div>
	
		<div class=" bd-layoutcontainer-43 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-109 
 col-sm-12">
    <div class="bd-layoutcolumn-109 bd-column" ><div class="bd-vertical-align-wrapper"><?php
    renderTemplateFromIncludes('joomlaposition_39');
?></div></div>
</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
        <?php
            $content = trim(ob_get_clean());
            $modContentExists = $GLOBALS['isModuleContentExists'];
            $showContent = strlen(trim(preg_replace('/<!-- empty::begin -->[\s\S]*?<!-- empty::end -->/', '', $content)));
        ?>
        <?php if ($isPreview || ($content && true === $modContentExists)): ?>
            <aside class="bd-sidebararea-4-column  bd-flex-vertical bd-flex-fixed <?php echo ($isPreview && !$modContentExists) ? ' hidden bd-hidden-sidebar' : ''; ?>">
                <div class="bd-sidebararea-4 bd-flex-wide  bd-margins">
                    
                    <?php echo $content; ?>
                    
                </div>
            </aside>
        <?php endif; ?>
<?php
    }
?>