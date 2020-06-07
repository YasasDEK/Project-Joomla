<!DOCTYPE html>
<html lang="<?php echo $document->language; ?>" dir="ltr">
<head>
   <?php include("$themeDir/site/base.php"); ?>
   <?php include("$themeDir/site/style.php"); ?> 
</head>
<body class=" bootstrap bd-body-1 
 bd-homepage bd-pagebackground-124 bd-margins">
   <?php include("$themeDir/site/header.php"); ?>
   <?php if ($slideshow_close == 1) { ?><?php include("$themeDir/site/slideshow.php"); ?><?php } ?>
  
	

<section class=" bd-section-25 bd-tagstyles" id="mod1" data-section-title="mod1">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
    renderTemplateFromIncludes('joomlaposition_4');
?>
    </div>
</section>
	

	
		<section class=" bd-section-41 bd-tagstyles" id="mod2" data-section-title="mod2">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
    renderTemplateFromIncludes('joomlaposition_36');
?>
    </div>
</section>
	
		<div class="bd-containereffect-6 container-effect container ">
<div class=" bd-stretchtobottom-1 bd-stretch-to-bottom" data-control-selector=".bd-contentlayout-9">
<div class="bd-contentlayout-9   bd-sheetstyles-7  bd-no-margins bd-margins" >
    <div class="bd-container-inner">

        <div class="bd-flex-vertical bd-stretch-inner bd-contentlayout-offset">
            
 <?php renderTemplateFromIncludes('sidebar_area_1'); ?>
            <div class="bd-flex-horizontal bd-flex-wide bd-no-margins">
                
 <?php renderTemplateFromIncludes('sidebar_area_3'); ?>
                <div class="bd-flex-vertical bd-flex-wide bd-no-margins">
                    
 <?php renderTemplateFromIncludes('sidebar_area_5'); ?>

                    <div class=" bd-layoutitemsbox-27 bd-flex-wide bd-no-margins">
    <div class=" bd-content-11">
    <?php
            $document = JFactory::getDocument();
            echo $document->view->renderSystemMessages();
    $document->view->componentWrapper('common');
    echo '<jdoc:include type="component" />';
    ?>
</div>
</div>

                    
 <?php renderTemplateFromIncludes('sidebar_area_6'); ?>
                </div>
                
 <?php renderTemplateFromIncludes('sidebar_area_2'); ?>
            </div>
            
 <?php renderTemplateFromIncludes('sidebar_area_4'); ?>
        </div>

    </div>
</div></div>
</div>
	
		<section class=" bd-section-27 bd-tagstyles" id="mod3" data-section-title="mod3">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
    renderTemplateFromIncludes('joomlaposition_12');
?>
    </div>
</section>
	
		<?php if ($footer_close == 1) { ?><?php include("$themeDir/site/footer.php"); ?><?php } ?>
        <?php if ($design_close== 1) { ?><?php include("$themeDir/site/design.php"); ?><?php } ?>
	
		<div data-smooth-scroll data-animation-time="250" class=" bd-smoothscroll-3"><a href="#" class=" bd-backtotop-1 ">
    <span class="bd-icon-66 bd-icon "></span>
</a></div>
</body>
</html>