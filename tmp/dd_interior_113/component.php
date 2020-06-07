<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/functions.php';

$content = $this->getBuffer('component');

$componentStyle = 'common';
if (preg_match('/<!--TEMPLATE ([\s\S]*?) \/-->/', $content, $matches)) {
    $content = str_replace('<!--TEMPLATE ' . $matches[1] . ' /-->', '', $content);
    $parts = explode('_', $matches[1]);
    if ($parts[0] == $_COOKIE['componentType'] && isset($_COOKIE['componentStyle']))
        $componentStyle = $_COOKIE['componentStyle'];
}
$content = getCustomComponentContent($content, JRequest::getVar('componentStyle', $componentStyle));
$this->setBuffer($content, 'component');

$document = $this;
$document->templateUrl = $document->baseurl . '/templates/' . $document->template;

?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $this->language; ?>">
<head>
    <script>
    var themeHasJQuery = !!window.jQuery;
</script>
<script src="<?php echo addThemeVersion($document->templateUrl . '/jquery.js'); ?>"></script>
<script>
    window._$ = jQuery.noConflict(themeHasJQuery);
</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="<?php echo addThemeVersion($document->templateUrl . '/bootstrap.min.js'); ?>"></script>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" />
    <?php if ('1' == JRequest::getVar('print')) : ?>
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/css/print.css" />
    <?php else : ?>
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/css/template.css" />
        <?php if('com_media' == JRequest::getVar('option') || 'articles' == JRequest::getVar('view')) : ?>
            <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/css/media.css" />
        <?php endif; ?>
    <?php endif; ?>
</head>
<body class="contentpane">
 <jdoc:include type="message" />
 <jdoc:include type="component" />
</body>
</html>