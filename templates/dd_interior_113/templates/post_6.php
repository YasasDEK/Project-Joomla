<!DOCTYPE html>
<html lang="<?php echo $document->language; ?>" dir="ltr">
<head>
<?php include("$themeDir/site/base.php"); ?>
   <?php include("$themeDir/site/style.php"); ?>
    
</head>
<body class=" bootstrap bd-body-6  bd-pagebackground-22 bd-textureoverlay bd-textureoverlay-6 bd-margins">
    <header class=" bd-headerarea-1  bd-margins">
        <?php
    renderTemplateFromIncludes('hmenu_6', array());
?>
</header>
	
		<section class=" bd-section-18 bd-tagstyles" id="logo_post" data-section-title="logo_post">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
$app = JFactory::getApplication();
$themeParams = $app->getTemplate(true)->params;
$sitename = $app->getCfg('sitename');
$logoSrc = '';
ob_start();
?>
src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/logo.png"
<?php

$logoSrc = ob_get_clean();
$logoLink = '';

if ($themeParams->get('logoFile'))
    $logoSrc = 'src="' . JURI::root() . $themeParams->get('logoFile') . '"';

if ($themeParams->get('logoLink'))
    $logoLink = $themeParams->get('logoLink');

if (!$logoLink)
    $logoLink = JUri::base(true);

?>
<a class=" bd-logo-10 animated bd-animation-80" data-animation-name="flipInY" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="0ms" data-animation-infinited="false" href="<?php echo $logoLink; ?>">
<img class=" bd-imagestyles" <?php echo $logoSrc; ?> alt="<?php echo $sitename; ?>">
</a>
    </div>
</section>
	
		<div class="bd-containereffect-23 container-effect container ">
<img class="bd-imagelink-32 hidden-xs animated bd-animation-76  bd-own-margins bd-imagestyles   "  data-animation-name="fadeInDownBig" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="500ms" data-animation-infinited="false" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/lamp.png"></div>
	
		<?php if ($slideshowpost_close== 1) { ?><?php include("$themeDir/site/slideshow_post.php"); ?><?php } ?>
	
		<div class="bd-containereffect-21 container-effect container "><section class=" bd-section-31 bd-tagstyles " id="post1" data-section-title="post1">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
    renderTemplateFromIncludes('joomlaposition_15');
?>
    </div>
</section></div>
	
		<section class=" bd-section-36 bd-tagstyles" id="post2" data-section-title="post2">
    <div class="bd-container-inner bd-margins clearfix">
        <?php
    renderTemplateFromIncludes('joomlaposition_30');
?>
    </div>
</section>
	
		<div class="bd-containereffect-4 container-effect container ">
<div class=" bd-stretchtobottom-2 bd-stretch-to-bottom" data-control-selector=".bd-contentlayout-6">
<div class="bd-contentlayout-6   bd-sheetstyles-3  bd-no-margins bd-margins" >
    <div class="bd-container-inner">

        <div class="bd-flex-vertical bd-stretch-inner bd-contentlayout-offset">
            
 <?php renderTemplateFromIncludes('sidebar_area_1'); ?>
            <div class="bd-flex-horizontal bd-flex-wide bd-no-margins">
                
 <?php renderTemplateFromIncludes('sidebar_area_3'); ?>
                <div class="bd-flex-vertical bd-flex-wide bd-no-margins">
                    
 <?php renderTemplateFromIncludes('sidebar_area_5'); ?>

                    <div class=" bd-layoutitemsbox-23 bd-flex-wide bd-no-margins">
    <div class=" bd-content-6">
    <?php
            $document = JFactory::getDocument();
            echo $document->view->renderSystemMessages();
    $document->view->componentWrapper('blog_3');
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
    
    <?php if ($footer_close == 1) { ?><?php include("$themeDir/site/footer.php"); ?><?php } ?>
        <?php if ($design_close== 1) { ?><?php include("$themeDir/site/design.php"); ?><?php } ?>
<div data-smooth-scroll data-animation-time="250" class=" bd-smoothscroll-3"><a href="#" class=" bd-backtotop-1 ">
 <span class="bd-icon-66 bd-icon "></span>
</a></div>
	
		<div class="bd-containereffect-2 container-effect container ">
<img class="bd-imagelink-25 hidden-xs animated bd-animation-75  bd-own-margins bd-imagestyles   "  data-animation-name="fadeInDownBig" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="0ms" data-animation-infinited="false" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/lamp.png"></div>
	
		<div class="bd-containereffect-26 container-effect container ">
<img class="bd-imagelink-34 hidden-xs animated bd-animation-79  bd-own-margins bd-imagestyles   "  data-animation-name="fadeInDownBig" data-animation-event="onload" data-animation-duration="1000ms" data-animation-delay="200ms" data-animation-infinited="false" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/lamp.png"></div>
</body>
</html>